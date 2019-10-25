<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*/

if ( ! class_exists('TagGroups_Shortcode') ) {

  class TagGroups_Shortcode {

    /*
    * Register the shortcodes with WordPress
    */
    static function register() {

      /**
      * Tabbed tag cloud
      */
      add_shortcode( 'tag_groups_cloud', array( 'TagGroups_Shortcode_Tabs', 'tag_groups_cloud' ) );

      if ( function_exists( 'register_block_type' ) ) {

        register_block_type( 'chatty-mango/tag-groups-cloud-tabs', array(
          'render_callback' => array( 'TagGroups_Shortcode_Tabs', 'tag_groups_cloud' ),
        ) );

      }

      /**
      * Accordion tag cloud
      */
      add_shortcode( 'tag_groups_accordion', array( 'TagGroups_Shortcode_Accordion', 'tag_groups_accordion' ) );

      if ( function_exists( 'register_block_type' ) ) {

        register_block_type( 'chatty-mango/tag-groups-cloud-accordion', array(
          'render_callback' => array( 'TagGroups_Shortcode_Accordion', 'tag_groups_accordion' ) ,
        ) );

      }

      /**
      * Tabbed tag cloud with first letters as tabs
      */
      add_shortcode( 'tag_groups_alphabet_tabs', array( 'TagGroups_Shortcode_Alphabet_Tabs', 'tag_groups_alphabet_tabs' ) );

      if ( function_exists( 'register_block_type' ) ) {

        register_block_type( 'chatty-mango/tag-groups-alphabet-tabs', array(
          'render_callback' => array( 'TagGroups_Shortcode_Alphabet_Tabs', 'tag_groups_alphabet_tabs' ),
        ) );

      }


      /**
      * Group info
      */
      add_shortcode( 'tag_groups_info', array( 'TagGroups_Shortcode_Info', 'tag_groups_info' ) );

    }


    /**
    * Makes sure that shortcodes work in text widgets.
    */
    static function widget_hook() {

      $tag_group_shortcode_widget = get_option( 'tag_group_shortcode_widget', 0 );

      if ( $tag_group_shortcode_widget ) {

        add_filter( 'widget_text', 'do_shortcode' );

      }

    }


    /**
    * Calculates the font size for the cloud tag for a particular tag ($min, $max and $size with same unit, e.g. pt.)
    *
    * @param int $count
    * @param int $min
    * @param int $max
    * @param int $smallest
    * @param int $largest
    * @return int
    */
    static function font_size( $count, $min, $max, $smallest, $largest )
    {

      if ( $max > $min ) {

        $size = round( ( $count - $min ) * ( $largest - $smallest ) / ( $max - $min ) + $smallest );

      } else {

        $size = round( $smallest );

      }

      return $size;

    }


    /**
    * A piece of script for the tabs to work, including options, for each individual cloud
    *
    * @param type $id
    * @param type $option_mouseover
    * @param type $option_collapsible
    * @return string
    */
    static function custom_js_tabs( $id = null, $option_mouseover = null, $option_collapsible = null, $option_active = null )
    {

      $options = array();

      if ( isset( $option_mouseover ) ) {

        if ( $option_mouseover ) {

          $options[] = 'event: "mouseover"';

        }

      } else {

        if ( get_option( 'tag_group_mouseover', '' ) ) {

          $options[] = 'event: "mouseover"';

        }

      }

      if ( isset( $option_collapsible ) ) {

        if ( $option_collapsible ) {

          $options[] = 'collapsible: true';

        }

      } else {

        if ( get_option( 'tag_group_collapsible', '' ) ) {

          $options[] = 'collapsible: true';

        }

      }

      if ( isset( $option_active ) ) {

        if ( $option_active ) {

          $options[] = 'active: true';

        } else {

          $options[] = 'active: false';

        }

      }

      if ( empty( $options ) ) {

        $options_serialized = '';

      } else {

        $options_serialized = "{\n" . implode( ",\n", $options ) . "\n}";

      }

      if ( empty( $id ) ) {

        $id = 'tag-groups-cloud-tabs';

      } else {

        $id = TagGroups_Base::sanitize_html_classes( $id );

      }

      $view = new TagGroups_View( 'shortcodes/js_tabs_snippet' );

      $view->set( array(
        'id'                  => $id,
        'options_serialized'  => $options_serialized
      ));

      return $view->return_html();

    }


    /**
    * A piece of script for the tabs to work, including options, for each individual cloud
    *
    * @param type $id
    * @param type $option_mouseover
    * @param type $option_collapsible
    * @return string
    */
    static function custom_js_accordion( $id = null, $option_mouseover = null, $option_collapsible = null, $option_active = null, $heightstyle = null )
    {

      $options = array();

      if ( isset( $option_mouseover ) ) {

        if ( $option_mouseover ) {

          $options[] = 'event: "mouseover"';

        }

      } else {

        if ( get_option( 'tag_group_mouseover', '' ) ) {

          $options[] = 'event: "mouseover"';

        }

      }

      if ( isset( $option_collapsible ) ) {

        if ( $option_collapsible ) {

          $options[] = 'collapsible: true';

        }

      } else {

        if ( get_option( 'tag_group_collapsible', '' ) ) {

          $options[] = 'collapsible: true';

        }

      }

      if ( ! empty( $heightstyle ) ) {

        $options[] = 'heightStyle: "' . sanitize_title( $heightstyle ) . '"';

      }

      if ( isset( $option_active ) ) {

        if ( $option_active ) {

          $options[] = 'active: true';

        } else {

          $options[] = 'active: false';

        }

      }


      if ( empty( $options ) ) {

        $options_serialized = '';

      } else {

        $options_serialized = "{\n" . implode( ",\n", $options ) . "\n}";

      }

      if ( !isset( $id ) ) {

        $id = 'tag-groups-cloud-accordion';

      } else {

        $id = TagGroups_Base::sanitize_html_classes( $id );

      }

      $view = new TagGroups_View( 'shortcodes/js_accordion_snippet' );

      $view->set( array(
        'id'                  => $id,
        'options_serialized'  => $options_serialized
      ));

      return $view->return_html();

    }


    /*
    *  find minimum and maximum of quantity of posts for each tag
    *
    * @param
    * @return array $min_max
    */
    static function determine_min_max( $tags, $amount, $tag_group_ids, $include_tags_post_id_groups = null, $data = null, $post_counts = null ) {

      $min_max = array();

      $count_amount = array();

      foreach ( $tag_group_ids as $tag_group_id ) {

        $count_amount[ $tag_group_id ] = 0;

        $min_max[ $tag_group_id ]['min'] = 0;

        $min_max[ $tag_group_id ]['max'] = 0;

      }

      if ( empty( $tags ) || ! is_array( $tags ) ) {

        return $min_max;

      }

      foreach ( $tags as $tag ) {

        $tag_count_per_group = array();

        $tag_count = 0;

        $term_o = new TagGroups_Term( $tag );

        if ( $term_o->is_in_group( $tag_group_ids ) ) {

          // check if tag has posts for a particular group
          if ( ! empty( $data ) && ! empty( $post_counts ) ) {

            foreach ( $tag_group_ids as $tag_group_id ) {

              if ( isset( $post_counts[ $tag->term_id ][ $tag_group_id ] ) ) {

                $tag_count_per_group[ $tag_group_id ] = $post_counts[ $tag->term_id ][ $tag_group_id ];

                $tag_count += $post_counts[ $tag->term_id ][ $tag_group_id ];

              } else {

                $tag_count_per_group[ $tag_group_id ] = 0;

              }

            }

          } else {

            $tag_count = $tag->count;

          }

          if ( $tag_count > 0 ) {

            /**
            * Use only groups that are in the list
            */
            $term_groups = array_intersect( $term_o->get_groups(), $tag_group_ids );

            foreach ( $term_groups as $term_group ) {

              if ( isset( $tag_count_per_group[ $term_group ] ) ) {

                $tag_count_this_group = $tag_count_per_group[ $term_group ];

              } else {

                $tag_count_this_group = $tag_count;

              }

              if ( 0 == $amount || $count_amount[ $term_group ] < $amount ) {

                if ( empty( $include_tags_post_id_groups ) || in_array( $tag->term_id, $include_tags_post_id_groups[ $term_group ] ) ) {

                  if ( isset( $min_max[ $term_group ]['max'] ) && $tag_count_this_group > $min_max[ $term_group ]['max'] ) {

                    $min_max[ $term_group ]['max'] = $tag_count_this_group;

                  }

                  if ( isset( $min_max[ $term_group ]['min'] ) && ( $tag_count_this_group < $min_max[ $term_group ]['min'] || 0 == $min_max[ $term_group ]['min'] ) ) {

                    $min_max[ $term_group ]['min'] = $tag_count_this_group;

                  }

                  $count_amount[ $term_group ]++;

                }

              }

            }

          }

        }

      }

      return $min_max;

    }


    /**
    * Helper for natural sorting of names
    *
    * Inspired by _wp_object_name_sort_cb
    *
    * @param array $terms
    * @param string $order asc or desc
    * @return array
    */
    static function natural_sorting( $terms, $order )
    {
      $factor = ( 'desc' == strtolower( $order ) ) ? -1 : 1;

      // "use" requires PHP 5.3+
      uasort( $terms, function( $a, $b ) use ( $factor ) {
        return $factor * strnatcasecmp( $a->name, $b->name );
      });

      return $terms;

    }


    /**
    * Helper for (pseudo-)random sorting
    *
    *
    * @param array $terms
    * @return array
    */
    static function random_sorting( $terms )
    {

      uasort( $terms, function( $a, $b ) {
        return 2 * mt_rand( 0, 1 ) - 1;
      });

      return $terms;

    }


    /**
    * Adds all IDs of groups that provide tags for a given post
    *
    *
    * @param int $post_id
    * @param array $taxonomies
    * @param array $include_array
    * @return array
    */
    static function add_groups_of_post( $post_id, $taxonomies, $include_array ) {

      $post_id_terms = array();

      /*
      *  get all tags of this post
      */
      foreach ( $taxonomies as $taxonomy_item ) {

        $terms = get_the_terms( (int) $post_id, $taxonomy_item );

        if ( ! empty( $terms ) && is_array( $terms ) ) {

          $post_id_terms = array_merge( $post_id_terms, $terms );

        }

      }


      /*
      *  get all involved groups, append them to $include
      */
      if ( $post_id_terms ) {

        foreach ( $post_id_terms as $term ) {

          $term_o = new TagGroups_Term( $term );

          if ( ! $term_o->is_in_group( $include_array ) ) {

            $include_array = array_merge( $include_array, $term_o->get_groups() );

          }

        }

      }

      return $include_array;

    }



    /**
    * Adds the tags of a particular post to the tags of a tag cloud
    *
    *
    * @param int $post_id
    * @param array $taxonomies
    * @param array $posttags
    * @param string $assigned_class
    * @return array
    */
    static function add_tags_of_post( $post_id, $taxonomies, $posttags, $assigned_class ) {

      $post_id_terms = array();

      $assigned_terms = array();

      $include_tags_post_id_groups = array();

      /*
      *  we have a particular post ID
      *  get all tags of this post
      */
      foreach ( $taxonomies as $taxonomy_item ) {

        $terms = get_the_terms( (int) $post_id, $taxonomy_item );

        /*
        *  merging the results of selected taxonomies
        */
        if ( ! empty( $terms ) && is_array( $terms ) ) {

          $post_id_terms = array_merge( $post_id_terms, $terms );

        }

      }

      /*
      *  clean all others from $posttags
      */
      foreach ( $posttags as $key => $tag ) {

        $found = false;

        foreach ( $post_id_terms as $id_tag ) {

          if ( $tag->term_id == $id_tag->term_id ) {

            $found = true;

            break;
          }
        }

        if ( ! empty( $assigned_class ) ) {

          /*
          *  Keep all terms but mark for different styling
          */
          if ( $found ) {

            $assigned_terms[ $tag->term_id ] = true;

          }

        } else {

          /*
          *  Remove unused terms.
          */
          if ( ! $found ) {

            unset( $posttags[ $key ] );

          }

        }

      }

      /**
      *  get all involved groups
      */
      if ( class_exists( 'TagGroups_Premium_Post' ) ) {

        $post_o = new TagGroups_Premium_Post( $post_id );

        $terms_by_group_tmp = $post_o->get_terms_by_group();

        foreach ( $terms_by_group_tmp as $key => $value ) {

          if ( ! isset( $include_tags_post_id_groups[ $key ] ) ) {

            $include_tags_post_id_groups[ $key ] = array();

          }

          $include_tags_post_id_groups[ $key ] = array_merge( $include_tags_post_id_groups[ $key ], $value );

        }

      }

      return array(
        'assigned_terms'              => $assigned_terms,
        'posttags'                    => $posttags,
        'include_tags_post_id_groups' => $include_tags_post_id_groups
      );

    }


    /**
    * Sorts the tags array according to the post count of a particular group
    *
    * @since 1.21.3
    * @param array $posttags
    * @param int $group_id
    * @param string $order
    * @return return type
    */
    public static function sort_within_groups( $posttags, $group_id, $post_counts, $order = 'asc' )
    {

      uasort( $posttags, function( $a, $b ) use ( $post_counts, $group_id, $order ) {

        if ( ! isset( $post_counts[ $a->term_id ][ $group_id ] ) ) {

          $post_counts[ $a->term_id ][ $group_id ] = 0;

        }

        if ( ! isset( $post_counts[ $b->term_id ][ $group_id ] ) ) {

          $post_counts[ $b->term_id ][ $group_id ] = 0;

        }

        if ( $post_counts[ $a->term_id ][ $group_id ] == $post_counts[ $b->term_id ][ $group_id ] ) {

          return 0;

        }

        if ( 'asc' == strtolower( $order ) ) {

          return ( $post_counts[ $a->term_id ][ $group_id ] > $post_counts[ $b->term_id ][ $group_id ] ) ? 1 : -1;

        } else {

          return ( $post_counts[ $a->term_id ][ $group_id ] > $post_counts[ $b->term_id ][ $group_id ] ) ? -1 : 1;

        }

      });


      return $posttags;

    }


  } // class

}
