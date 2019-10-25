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

if ( ! class_exists('TagGroups_Groups') ) {

  class TagGroups_Groups {

    /**
    * array of all term_group values, including 0
    *
    * @var array
    */
    private $group_ids;

    /**
    * array of positions[term_group]
    *
    * @var array
    */
    private $positions;

    /**
    * array of labels[term_group]
    *
    * @var array
    */
    private $labels;


    /**
    * Constructor
    *
    *
    * @param int $term_group optional term_group
    * @return return type
    */
    public function __construct()
    {

      $this->load();

      if ( count( $this->group_ids ) == 0 ) {

        $this->add_not_assigned();

        $this->save();

      }

      return $this;

    }


    /**
    * Load data from database
    *
    *
    * @param int $term_group optional term_group
    * @return return type
    */
    public function load()
    {
      /*
      * For historical reasons, term_groups and labels have been defined dependent of the position.
      * In future the way how it is saved in the database should be dependent on term_group.
      */
      $this->group_ids = get_option( 'term_groups', array() );

      if ( empty( $this->group_ids ) ) {

        $term_groups_position = get_option( 'tag_group_ids', array() ); // position -> id

        $labels_position = get_option( 'tag_group_labels', array() ); // position -> label

        $this->positions = array_flip( $term_groups_position );

        $this->group_ids = array_keys( $this->positions );

        $this->labels = array();

        foreach ( $term_groups_position as $position => $id ) {

          $this->labels[ $id ] = $labels_position[ $position ];

        }

      } else {

        $this->positions = get_option( 'term_group_positions', array() );

        $this->labels = get_option( self::get_tag_group_label_option_name(), array() );

        if ( empty( $this->labels ) ) {

          /**
          * This language has not yet been saved. We return the default language.
          */
          $this->labels = get_option( 'term_group_labels', array() );

        } elseif ( self::is_wpml_translated_language() ) {

          /**
          * Check for untranslated names
          */
          $default_language_labels = get_option( 'term_group_labels', array() );

          foreach ( $default_language_labels as $group_id => $default_language_label ) {

            if ( ! isset( $this->labels[ $group_id ] ) ) {

              $this->labels[ $group_id ] = $default_language_label;

            }

          }

        }

        // sanity checks

        // There should not be more elements for positions that IDs
        if ( count( $this->group_ids ) != count( $this->positions ) ) {

          $this->reindex_positions();

          // recreate $this->group_ids from positions

          $this->group_ids = array_keys( $this->positions );

          update_option( 'term_groups', $this->group_ids );

        }

        // There should not be more elements for label that IDs
        if ( count( $this->group_ids ) < count( $this->labels ) ) {

          foreach ( $this->labels as $group_id => $label ) {

            if ( ! in_array( $group_id, $this->group_ids ) ) {

              unset( $this->labels[ $group_id ] );

            }

          }

          update_option( 'term_group_labels', $this->labels );

          $tag_group_group_languages = get_option( 'tag_group_group_languages', array() );

          if ( isset( $tag_group_group_languages ) && is_array( $tag_group_group_languages ) ) {

            foreach ( $tag_group_group_languages as $language ) {

              $translated_labels = get_option( 'term_group_labels_' . $language );

              if ( count( $this->group_ids ) < count( $translated_labels ) ) {

                foreach ( $translated_labels as $group_id => $label ) {

                  if ( ! in_array( $group_id, $this->group_ids ) ) {

                    unset( $translated_labels[ $group_id ] );

                  }

                }

                update_option( 'term_group_labels_' . $language, $translated_labels );

              }

            }

          }



        }

      }

      return $this;

    }


    /**
    * checks and, if needed, initialize values for first use
    *
    * @param void
    * @return object $this
    */
    public function add_not_assigned()
    {

      $this->group_ids[0] = 0;

      $this->labels[0] = __('not assigned', 'tag-groups');

      $this->positions[0] = 0;

      return $this;

    }


    /**
    * Saves tag group-relevant information to the database
    *
    *
    * @param type var Description
    * @return return type
    */
    public function save()
    {

      global $tag_groups_premium_fs_sdk;

      if ( $tag_groups_premium_fs_sdk->is_plan_or_trial('premium') ) {

        $tag_group_role_edit_groups = class_exists( 'TagGroups_Premium' ) ? get_option( 'tag_group_role_edit_groups', 'edit_pages' ) : 'edit_pages';

      } else {

        $tag_group_role_edit_groups = 'edit_pages';

      }

      if ( ! current_user_can( $tag_group_role_edit_groups ) ) {

        return $this;

      }

      update_option( 'term_groups', $this->group_ids );

      update_option( 'term_group_positions', $this->positions );

      update_option( self::get_tag_group_label_option_name(), $this->labels );

      /**
      * If we save translated groups, make sure we have untranslated ones. If not, give them the translations.
      */
      if ( self::is_wpml_translated_language() ) {

        $default_language_labels = get_option( 'term_group_labels', array() );

        $changed = false;

        foreach ( $this->labels as $group_id => $group_label ) {

          if ( ! isset( $default_language_labels[ $group_id ] ) ) {

            $default_language_labels[ $group_id ] = $group_label;

            $changed = true;

          }

        }

        if ( $changed ) {

          update_option( 'term_group_labels', $default_language_labels );

        }

      }

      do_action( 'term_group_saved' );


      if ( class_exists( 'TagGroups_Premium_Post' ) && ( ! defined( 'TAG_GROUPS_DISABLE_CACHE_REBUILD' ) || TAG_GROUPS_DISABLE_CACHE_REBUILD ) ) {

        // schedule rebuild of cache
        wp_schedule_single_event( time() + 10, 'tag_groups_rebuild_post_terms' );

      }


      return $this;

    }


    /**
    * returns the highest term_group in use
    *
    * @param void
    * @return int
    */
    public function get_max_term_group()
    {
      if ( count( $this->group_ids ) == 0 ) {

        return 0;

      } else {

        return max( $this->group_ids );

      }
    }


    /**
    * returns the highest position in use
    *
    * @param void
    * @return int
    */
    public function get_max_position()
    {
      if ( count( $this->positions ) == 0 ) {

        return 0;

      } else {

        return max( $this->positions );

      }
    }


    /**
    * returns the number of term groups_only
    *
    *
    * @param void
    * @return int
    */
    public function get_number_of_term_groups()
    {
      return count( $this->group_ids );
    }


    /**
    * adds a new group and saves it
    *
    *
    * @param int $position position of the new group
    * @param string $label label of the new group
    * @return int
    */
    public function add_group( $tg_group )
    {

      if ( intval( $tg_group->get_group_id() ) >= 0 && ! in_array( $tg_group->get_group_id(), $this->group_ids ) ) {

        array_push( $this->group_ids, $tg_group->get_group_id() );

        $this->labels[ $tg_group->get_group_id() ] = $tg_group->get_label();

        $this->positions[ $tg_group->get_group_id() ] = $tg_group->get_position();

      }

      return $this;

    }


    /**
    * removes all terms from all groups
    *
    *
    * @param void
    * @return object $this
    */
    public function unassign_all_terms()
    {

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      $terms = get_terms( array( 'hide_empty' => false, 'taxonomy' => $enabled_taxonomies ) );

      foreach ( $terms as $term ) {

        $term_o = new TagGroups_Term( $term );

        $term_o->remove_all_groups()->save();

      }

      return $this;

    }


    /**
    * getter for $group_ids
    *
    * @param void
    * @return array
    */
    public function get_group_ids() {

      return $this->group_ids;

    }


    /**
    * setter for $group_ids
    *
    * @param array $group_ids
    * @return object $this
    */
    public function set_group_ids( $group_ids ) {

      $this->group_ids = $group_ids;

      return $this;

    }


    /**
    * returns the labels for an array of ids, sorted by position
    *
    * @param array $group_ids
    * @return array
    */
    public function get_labels_by_position( $group_ids )
    {
      $result = array();

      if ( ! is_array( $group_ids ) ) {

        $group_ids = array( $group_ids );

      }

      foreach ( $group_ids as $group_id) {

        if ( ! empty( $this->labels[ $group_id ] ) && isset( $this->positions[ $group_id ] ) ) {

          $result[ $this->positions[ $group_id ] ] = $this->labels[ $group_id ];

        }

      }

      ksort( $result );

      return array_values( $result );

    }


    /**
    * returns an array of group properties as values
    *
    * @param void
    * @return array
    */
    public function get_info_of_all( $taxonomy = null, $hide_empty = false, $fields = null, $orderby = 'name', $order = 'ASC' ) {

      // dealing with NULL values
      if ( empty( $fields ) ) {

        $fields = 'ids';

      }

      if ( empty( $taxonomy ) ) {

        $taxonomy = TagGroups_Taxonomy::get_enabled_taxonomies();

      }

      if ( ! isset( $hide_empty ) || empty( $hide_empty ) ) {

        $hide_empty = false;

      }

      $result = array();

      foreach ( $this->group_ids as $term_group ) {

        if ( isset( $this->positions[ $term_group ] ) && isset( $this->labels[ $term_group ] ) ) { // allow unassigned

          $tg_group = new TagGroups_Group( $term_group );

          $terms = $tg_group->get_group_terms( $taxonomy, $hide_empty, $fields, 0, $orderby, $order );

          if ( ! is_array( $terms ) ) {

            $terms = array();

            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

              error_log( '[Tag Groups] Error retrieving terms in get_info().' );

            }

          }

          $result[ $this->positions[ $term_group ] ] = array(
            'term_group' => (int) $term_group,
            'label' => $this->labels[ $term_group ],
            'position'  => (int) $this->positions[ $term_group ],
            'terms'  => $terms
          );

        }

      }

      /**
      * The position should determine the order.
      */
      ksort( $result );

      return $result;

    }


    /**
    * returns all tag groups with the position as keys and an array of group properties as values
    * including unassigned
    *
    * @param void
    * @return array
    */
    public function get_all_with_position_as_key() {

      $result = array();

      foreach ( $this->group_ids as $group_id ) {

        if ( isset( $this->positions[ $group_id ] ) && isset( $this->labels[ $group_id ] ) ) { // allow unassigned

          $result[ $this->positions[ $group_id ] ] = array(
            'term_group' => (int) $group_id,
            'label' => $this->labels[ $group_id ],
            'position'  => (int) $this->positions[ $group_id ]
          );

        }

      }

      /**
      * The position should determine the order.
      */
      ksort( $result );

      return $result;

    }


    /**
    * returns all tag groups with the term_group as keys and labels as values
    * sorted by position
    *
    * @param void
    * @return array
    */
    public function get_all_term_group_label() {

      $result = array();

      $positions_flipped = array_flip( $this->positions );

      ksort( $positions_flipped ); // ksort doesn't like return values of functions

      foreach ( $positions_flipped as $term_group ) {

        $result[ $term_group ] = $this->labels[ $term_group ];

      }

      return $result;

    }


    /**
    * returns all tag group ids
    * sorted by position
    *
    * @param void
    * @return array
    */
    public function get_group_ids_by_position() {

      $result = array();

      $position_flipped = array_flip( $this->positions );

      ksort( $position_flipped );

      foreach ( $position_flipped as $group_id ) {

        $result[] = $group_id;

      }

      return $result;

    }


    /**
    * returns all labels
    * sorted by position
    *
    * @param void
    * @return array
    */
    public function get_all_labels_by_position() {

      $result = array();

      $positions = $this->positions;

      asort( $positions );

      $positions_keys = array_keys( $positions );

      foreach ( $positions_keys as $term_group ) {

        $result[] = $this->labels[ $term_group ];

      }

      return $result;

    }


    /**
    * getter for $labels
    *
    * @param void
    * @return array
    */
    public function get_labels() {

      return $this->labels;

    }


    /**
    * setter for $labels
    *
    * @param array $labels
    * @return object $this
    */
    public function set_labels( $labels ) {

      $this->labels = $labels;

      return $this;

    }


    /**
    * getter for $positions
    *
    * @param void
    * @return object
    */
    public function get_positions() {

      return $this->positions;

    }


    /**
    * setter for $positions
    *
    * @param array $positions
    * @return object $this
    */
    public function set_positions( $positions ) {

      $this->positions = $positions;

      return $this;

    }


    /**
    * Deletes all groups
    *
    * @param void
    * @return void
    */
    public function reset_groups() {

      global $tag_groups_premium_fs_sdk;

      if ( $tag_groups_premium_fs_sdk->is_plan_or_trial('premium') ) {

        $tag_group_role_edit_groups = class_exists( 'TagGroups_Premium' ) ? get_option( 'tag_group_role_edit_groups', 'edit_pages' ) : 'edit_pages';

      } else {

        $tag_group_role_edit_groups = 'edit_pages';

      }

      if ( ! current_user_can( $tag_group_role_edit_groups ) ) {

        return false;

      }

      $this->group_ids = array();

      $this->positions = array();

      $this->labels = array();

      $this->delete_labels_languages();

      $this->unassign_all_terms();

      $this->add_not_assigned();

      $this->save();

      return true;

    }


    /**
    * Deletes all labels for all languages
    *
    *
    * @param void
    * @return void
    */
    public function delete_labels_languages()
    {

      delete_option( 'term_group_labels' );

      $tag_group_group_languages = get_option( 'tag_group_group_languages', array() );

      if ( isset( $tag_group_group_languages ) ) {

        foreach ( $tag_group_group_languages as $language ) {

          delete_option( 'term_group_labels_' . $language );

        }

      }

      delete_option( 'tag_group_group_languages' );

    }


    /**
    * Remove "holes" in position array
    *
    *
    * @param void
    * @return void
    */
    public function reindex_positions()
    {

      $positions_flipped = array_flip( $this->positions ); // result: position => id

      ksort( $positions_flipped );

      // re-index
      $positions_flipped = array_values( $positions_flipped );

      $this->positions = array_flip( $positions_flipped );

      return $this;

    }


    /**
    * Sorts the groups (positions) by alphabetical order
    *
    *
    * @param void
    * @return void
    */
    public function sort( $order = 'up' )
    {

      $group_ids = $this->group_ids;

      // remove unassigned
      unset( $group_ids[ 0 ] );

      usort( $group_ids, array( $this, 'sort_by_label' ) );

      if ( 'down' == $order ) {

        $group_ids = array_reverse( $group_ids );

      }
      // add back unassigned
      array_unshift( $group_ids, 0 );

      $this->positions = array_flip( $group_ids );

      return $this;

    }


    /**
    * Sorts by group label
    *
    *
    * @param int $a
    * @param int $b
    * @return boolean
    */
    private function sort_by_label( $a, $b )
    {

      $labels = get_option( self::get_tag_group_label_option_name(), array() );

      return strnatcmp( $labels[ $a ], $labels[ $b ] );

    }


    /**
    * Check for WPML and use the correct option name
    *
    * @param void
    * @return string
    */
    public static function get_tag_group_label_option_name()
    {

      if ( ! self::get_current_language() || ! self::is_wpml_translated_language() ) {

        return 'term_group_labels';

      }

      if ( 'all' == self::get_current_language() ) {

        $language = (string) apply_filters( 'wpml_default_language', NULL );

      } else {

        $language = (string) self::get_current_language();

      }

      /**
      * Make sure we can delete this option during uninstallation
      */
      $tag_group_group_languages = get_option( 'tag_group_group_languages', array() );

      if ( ! in_array( $language, $tag_group_group_languages ) ) {

        $tag_group_group_languages[] = $language;

        update_option( 'tag_group_group_languages', $tag_group_group_languages );

      }

      return 'term_group_labels_' . $language;

    }


    /**
    * Returns true if WPML is installed and we are not using the default language.
    *
    * @param void
    * @return boolean
    */
    public static function is_wpml_translated_language()
    {

      $current_language = self::get_current_language();

      if ( ! $current_language ) {

        return false;

      }

      $default_language = apply_filters( 'wpml_default_language', NULL );

      // workaround for Polylang
      if ( empty( $default_language ) && function_exists( 'pll_default_language' ) ) {

        $default_language = pll_default_language();

      }

      if ( $default_language === $current_language ) {

        return false;

      }

      return true;

    }


    /**
    * Gets the current language, considers Polylang
    *
    * @param void
    * @return string|boolean
    */
    public static function get_current_language()
    {

      if ( defined( 'ICL_LANGUAGE_CODE' ) ) {

        return ICL_LANGUAGE_CODE;

      }

      if ( function_exists( 'pll_current_language' ) ) {

        $current_language = pll_current_language();

        if ( ! $current_language ) {

          if ( isset( $_GET[ 'lang' ] ) ) {

            return sanitize_key( $_GET[ 'lang' ] );

          }

        }

        return $current_language;

      }

      return false;

    }

  }
}
