<?php

/**
* Tag Groups
*
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
* @since      1.8.0
*
*/
if ( !class_exists( 'TagGroups_Group' ) ) {
    class TagGroups_Group
    {
        /**
         * term_group id
         *
         * @var int
         */
        private  $group_id ;
        /**
         * object of groups
         *
         * @var array
         */
        private  $tg_groups ;
        /**
         * array of positions[term_group]
         *
         * @var array
         */
        private  $position ;
        /**
         * array of labels[term_group]
         *
         * @var array
         */
        private  $label ;
        /**
         * instance of the premium part
         *
         * @var object
         */
        private  $tg_group_premium ;
        /**
         * Constructor
         *
         *
         * @param int $group_id optional term_group
         * @return return type
         */
        public function __construct( $group_id = null )
        {
            global  $tag_group_groups ;
            $this->tg_groups = $tag_group_groups;
            if ( isset( $group_id ) ) {
                $this->group_id = $group_id;
            }
            $this->load();
            if ( class_exists( 'TagGroups_Premium_Group' ) ) {
                $this->tg_group_premium = new TagGroups_Premium_Group( $this->group_id );
            }
            return $this;
        }
        
        /**
         * Load data from database
         *
         *
         * @param int $group_id optional term_group
         * @return return type
         */
        public function load()
        {
            $labels = $this->tg_groups->get_labels();
            $positions = $this->tg_groups->get_positions();
            
            if ( isset( $labels[$this->group_id] ) ) {
                $this->label = $labels[$this->group_id];
            } else {
                $this->label = '';
            }
            
            
            if ( isset( $positions[$this->group_id] ) ) {
                $this->position = $positions[$this->group_id];
            } else {
                $this->position = 1;
            }
            
            return $this;
        }
        
        /**
         * checks whether this group exists, identified by its ID
         *
         *
         * @param void
         * @return boolean
         */
        public function exists()
        {
            if ( 0 == $this->group_id ) {
                return true;
            }
            return isset( $this->group_id ) && in_array( $this->group_id, $this->tg_groups->get_group_ids() );
        }
        
        /**
         * Saves this group to the database
         *
         *
         * @param void
         * @return object $this
         */
        public function save()
        {
            if ( empty($this->group_id) ) {
                return $this;
            }
            $labels = $this->tg_groups->get_labels();
            $positions = $this->tg_groups->get_positions();
            $labels[$this->group_id] = $this->label;
            $positions[$this->group_id] = $this->position;
            $this->tg_groups->set_labels( $labels );
            $this->tg_groups->set_positions( $positions );
            $this->tg_groups->save();
            return $this;
        }
        
        /**
         * getter for the term_group value
         *
         *
         * @param void
         * @return int term_group
         */
        public function get_group_id()
        {
            return $this->group_id;
        }
        
        /**
         * setter for the term_group value
         *
         *
         * @param int $group_id
         * @return object $this
         */
        public function set_group_id( $group_id )
        {
            $this->group_id = $group_id;
            if ( isset( $this->tg_group_premium ) ) {
                $this->tg_group_premium->set_group_id( $group_id );
            }
            return $this;
        }
        
        /**
         * adds a new group and saves it
         *
         *
         * @param int $position position of the new group
         * @param string $label label of the new group
         * @return int
         */
        public function create( $position = null, $label )
        {
            $this->set_group_id( $this->tg_groups->get_max_term_group() + 1 );
            $this->label = $label;
            $this->set_position( $this->tg_groups->get_max_position() + 1 );
            $this->tg_groups->reindex_positions()->add_group( $this );
            if ( isset( $position ) && $position != $this->position ) {
                $this->move_to_position( $position );
            }
            $this->save();
            return $this;
        }
        
        /**
         * returns all terms that are associated with this term group
         *
         * @param string|array $taxonomy See get_terms
         * @param string $hide_empty See get_terms
         * @param string $fields See get_terms
         * @param string $post_id See get_terms
         * @param string $orderby See get_terms
         * @param string $order See get_terms
         * @return array
         */
        public function get_group_terms(
            $taxonomy = 'post_tag',
            $hide_empty = false,
            $fields = 'all',
            $post_id = 0,
            $orderby = 'name',
            $order = 'ASC'
        )
        {
            global  $tag_groups_premium_fs_sdk ;
            if ( !isset( $this->group_id ) ) {
                return array();
            }
            /**
             * Remove invalid taxonomies
             */
            $taxonomy = TagGroups_Taxonomy::remove_invalid( $taxonomy );
            $args = array(
                'taxonomy'   => $taxonomy,
                'hide_empty' => $hide_empty,
                'orderby'    => $orderby,
                'order'      => $order,
                'fields'     => 'all',
            );
            $terms = get_terms( $args );
            // need to sort manually
            
            if ( strtolower( $fields ) == 'ids' ) {
                $result = array();
                foreach ( $terms as $key => $term ) {
                    $tg_term = new TagGroups_Term( $term );
                    if ( $tg_term->is_in_group( $this->group_id ) && !in_array( $term->term_id, $result ) ) {
                        $result[] = $term->term_id;
                    }
                }
                return $result;
            } elseif ( strtolower( $fields ) == 'names' ) {
                $result = array();
                foreach ( $terms as $key => $term ) {
                    $tg_term = new TagGroups_Term( $term );
                    if ( $tg_term->is_in_group( $this->group_id ) && !in_array( $term->name, $result ) ) {
                        $result[] = $term->name;
                    }
                }
                return $result;
            } elseif ( strtolower( $fields ) == 'count' ) {
                $result = 0;
                $result_ids = array();
                foreach ( $terms as $key => $term ) {
                    $tg_term = new TagGroups_Term( $term );
                    
                    if ( $tg_term->is_in_group( $this->group_id ) && !in_array( $term->term_id, $result_ids ) ) {
                        $result++;
                        $result_ids[] = $term->term_id;
                    }
                
                }
                return $result;
            } else {
                $result = array();
                $result_ids = array();
                foreach ( $terms as $key => $term ) {
                    $tg_term = new TagGroups_Term( $term );
                    
                    if ( $tg_term->is_in_group( $this->group_id ) && !in_array( $term->term_id, $result_ids ) ) {
                        $result[] = $term;
                        $result_ids[] = $term->term_id;
                    }
                
                }
                return $result;
            }
        
        }
        
        /**
         * adds terms to this group
         *
         *
         * @param array $term_ids one-dimensional array of term IDs
         * @return object $this
         */
        public function add_terms( $term_ids )
        {
            foreach ( $term_ids as $term_id ) {
                $tg_term = new TagGroups_Term( $term_id );
                $tg_term->add_group( $this->group_id );
                $tg_term->save();
            }
            return $this;
        }
        
        /**
         * removes terms from this group
         *
         *
         * @param array $term_ids one-dimensional array of term IDs
         * @return object $this
         */
        public function remove_terms( $term_ids = array() )
        {
            $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();
            $terms = get_terms( array(
                'include'    => $term_ids,
                'hide_empty' => false,
                'taxonomy'   => $enabled_taxonomies,
            ) );
            foreach ( $terms as $term ) {
                $tg_term = new TagGroups_Term( $term );
                // make sure this term is really in this group
                if ( $tg_term->is_in_group( $this ) ) {
                    $tg_term->remove_group( $this )->save();
                }
            }
            return $this;
        }
        
        /**
         * deletes this group
         *
         *
         * @param int $group_id ID of this group
         * @return object $this
         */
        public function delete()
        {
            $labels = $this->tg_groups->get_labels();
            $positions = $this->tg_groups->get_positions();
            $group_ids = $this->tg_groups->get_group_ids();
            if ( ($key = array_search( $this->group_id, $group_ids )) === false ) {
                return $this;
            }
            unset( $group_ids[$key] );
            unset( $labels[$this->group_id] );
            unset( $positions[$this->group_id] );
            $this->tg_groups->set_labels( $labels );
            $this->tg_groups->set_positions( $positions );
            $this->tg_groups->set_group_ids( $group_ids );
            $this->tg_groups->reindex_positions();
            $this->tg_groups->save();
            $this->remove_terms();
            unset( $this->group_id );
            do_action( 'term_group_deleted' );
            return $this;
        }
        
        /**
         * returns the position of this group
         *
         * @param void
         * @return int|boolean
         */
        public function get_position()
        {
            return $this->position;
        }
        
        /**
         * sets the position of this group
         *
         *
         * @param int $position position of this group
         * @return object $this
         */
        public function set_position( $position )
        {
            $this->position = $position;
            return $this;
        }
        
        /**
         * sets the position of this group
         *
         *
         * @param int $position position of this group
         * @return object $this
         */
        public function move_to_position( $new_position )
        {
            if ( empty($this->group_id) ) {
                return false;
            }
            $old_position = $this->get_position();
            $positions = $this->tg_groups->get_positions();
            /**
             * 1. move down on old position
             */
            foreach ( $positions as $key => $value ) {
                if ( $value > $old_position ) {
                    $positions[$key] = $value - 1;
                }
            }
            /**
             * 2. make space at new position
             */
            foreach ( $positions as $key => $value ) {
                if ( $value >= $new_position ) {
                    $positions[$key] = $value + 1;
                }
            }
            /**
             * 3. Insert
             */
            $positions[$this->group_id] = $new_position;
            $this->tg_groups->set_positions( $positions );
            $this->position = $new_position;
            $this->tg_groups->reindex_positions();
            return $this;
        }
        
        /**
         * returns the label of this group
         *
         * @param void
         * @return string|boolean
         */
        public function get_label()
        {
            if ( !isset( $this->group_id ) ) {
                // allow also "not assigned"
                return false;
            }
            return $this->label;
        }
        
        /**
         * sets the label of this group
         *
         *
         * @param string $label label of this group
         * @return object $this
         */
        public function set_label( $label )
        {
            if ( empty($this->group_id) ) {
                return false;
            }
            $this->label = $label;
            return $this;
        }
        
        /**
         * returns the number of terms associated with this group
         *
         *
         * @param void
         * @return int
         */
        public function get_number_of_terms( $taxonomies )
        {
            if ( !isset( $this->group_id ) ) {
                return false;
            }
            if ( !is_array( $taxonomies ) ) {
                $taxonomies = array( $taxonomies );
            }
            /**
             * Consider only taxonomies that
             * 1. are among $tag_group_taxonomies
             * 2. actually exist
             */
            $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies( $taxonomies );
            
            if ( class_exists( 'TagGroups_Premium_Group' ) ) {
                return $this->get_group_terms( $enabled_taxonomies, false, 'count' );
            } else {
                $terms = get_terms( array(
                    'hide_empty' => false,
                    'taxonomy'   => $enabled_taxonomies,
                ) );
                $number = 0;
                foreach ( $terms as $term ) {
                    $tg_term = new TagGroups_Term( $term );
                    if ( $tg_term->is_in_group( $this->group_id ) ) {
                        $number++;
                    }
                }
            }
            
            return $number;
        }
        
        /**
         * sets $this->group_id by label
         *
         *
         * @param string $label
         * @return boolean|int
         */
        public function find_by_label( $label )
        {
            $labels = $this->tg_groups->get_labels();
            
            if ( in_array( $label, $labels ) ) {
                $this->group_id = array_search( $label, $labels );
                $this->load();
                return $this;
            } else {
                return false;
            }
        
        }
        
        /**
         * sets $this->group_id by position
         *
         *
         * @param int $position
         * @return boolean|int
         */
        public function find_by_position( $position )
        {
            $positions = $this->tg_groups->get_positions();
            
            if ( in_array( $position, $positions ) ) {
                $this->group_id = array_search( $position, $positions );
                $this->load();
                return $this;
            } else {
                $this->group_id = 0;
                return false;
            }
        
        }
        
        /**
         * returns an array of group properties as values
         *
         * @param void
         * @return array
         */
        public function get_info(
            $taxonomy = null,
            $hide_empty = false,
            $fields = null,
            $orderby = 'name',
            $order = 'ASC'
        )
        {
            // dealing with NULL values
            if ( empty($fields) ) {
                $fields = 'ids';
            }
            if ( empty($taxonomy) ) {
                $taxonomy = TagGroups_Taxonomy::get_enabled_taxonomies();
            }
            if ( !isset( $hide_empty ) || empty($hide_empty) ) {
                $hide_empty = false;
            }
            $terms = $this->get_group_terms(
                $taxonomy,
                $hide_empty,
                $fields,
                0,
                $orderby,
                $order
            );
            
            if ( !is_array( $terms ) ) {
                $terms = array();
                if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
                    error_log( '[Tag Groups] Error retrieving terms in get_info().' );
                }
            }
            
            return array(
                'term_group' => (int) $this->group_id,
                'label'      => $this->label,
                'position'   => (int) $this->position,
                'terms'      => $terms,
            );
        }
    
    }
}