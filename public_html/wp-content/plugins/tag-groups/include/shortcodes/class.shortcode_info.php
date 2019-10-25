<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*/

if ( ! class_exists('TagGroups_Shortcode_Info') ) {

  class TagGroups_Shortcode_Info extends TagGroups_Shortcode {


    /**
    *
    * Render information about tag groups
    *
    * For <p> wrapping issue check: https://gist.github.com/bitfade/4555047
    *
    * @param array $atts
    * @return string
    */
    static function tag_groups_info( $atts = array() ) {

      global $tag_group_groups;

      if ( is_array( $atts ) ) {

        asort( $atts );

      }

      $cache_key = md5( 'tag_groups_info' . serialize( $atts ) );

      // check for a cached version (premium plugin)
      $html = apply_filters( 'tag_groups_hook_cache_get', false, $cache_key );

      if ( $html ) {

        return $html;

      }

      $active_tag_group_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      extract( shortcode_atts( array(
        'info'        =>  'number_of_tags',
        'group_id'    => '0',
        'html_id'     => '',
        'html_class'  => '',
        'taxonomy'    => null,
      ), $atts ) );


      if ( ! empty( $div_id ) ) {

        $id_string = ' id="' . $html_id . '"';

      } else {

        $id_string = '';

      }

      if ( ! empty( $html_class ) ) {

        $class_string = ' class="' . $html_class . '"';

      } else {

        $class_string = '';

      }

      if ( ! empty( $taxonomy ) ) {

        $taxonomy_array = explode( ',', $taxonomy );

        $taxonomy_array = array_filter( array_map( 'trim', $taxonomy_array ) );

        if ( ! empty( $taxonomy_array ) ) {

          $tag_group_taxonomies = array_intersect( $active_tag_group_taxonomies, $taxonomy_array );

          if ( empty( $tag_group_taxonomies ) ) {

            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

              error_log( sprintf( '[Tag Groups] Wrong taxonomy in "tag_groups_info": %s', $taxonomy ) );

            }

            return '';

          }

        }

      } else {

        $tag_group_taxonomies = $active_tag_group_taxonomies;

      }

      $term_groups = false;

      $output = '';

      switch ( $info ) {

        case 'number_of_tags':
        /**
        * Show the number of tags
        */

        if ( 'all' == $group_id ) {

          $term_groups = $tag_group_groups->get_group_ids_by_position();

        } elseif ( strpos( $group_id, ',' ) !== false ) {

          $term_groups = array_map( 'intval', explode( ',', $group_id ) );

        }

        if ( $term_groups !== false ) {
          /**
          * multiple groups
          */

          $output .= '<table' . $id_string . $class_string . '>';

          foreach ( $term_groups as $term_group ) {

            $tg_group = new TagGroups_Group( $term_group );

            if ( $tg_group->exists() ) {

              $output .= '<tr>
              <td class="tag-groups-td-label" title="ID: ' . $term_group . '">';

              $output .= $tg_group->get_label();

              $output .= '</td>
              <td class="tag-groups-td-number">';

              $output .= intval( $tg_group->get_number_of_terms( $tag_group_taxonomies ) );

              $output .= '</td>
              </tr>';

            } else {

              if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

                error_log( sprintf( '[Tag Groups] Unknown group ID in "tag_groups_info": %s', $term_group ) );

              }

            }

          }

          $output .= '</table>';

        } else {
          /**
          * one group
          */
          $term_group = intval( $group_id );

          $tg_group = new TagGroups_Group( $term_group );

          if ( $tg_group->exists() ) {

            $output .= '<span' . $id_string . $class_string . '>';

            $output .= intval( $tg_group->get_number_of_terms( $tag_group_taxonomies ) );

            $output .= '</span>';

          } else {

            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

              error_log( sprintf( '[Tag Groups] Unknown group ID in "tag_groups_info": %s', $term_group ) );

            }

          }

        }

        break;

        case 'label':

        if ( strpos( $group_id, ',' ) !== false ) {

          if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

            error_log( sprintf( '[Tag Groups] Wrong group ID in "tag_groups_info" with info=label: %s', $group_id ) );

          }

        } else {

          $term_group = intval( $group_id );

          $tg_group = new TagGroups_Group( $term_group );

          if ( $tg_group->exists() ) {

            $output = '<span' . $id_string . $class_string . '>';

            $output .= $tg_group->get_label();

            $output .= '</span>';

          } else {

            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

              error_log( sprintf( '[Tag Groups] Unknown group ID in "tag_groups_info": %s', $term_group ) );

            }

          }

        }

        break;

        default:

        $output = '';

        break;
      }

      // create a cached version (premium plugin)
      do_action( 'tag_groups_hook_cache_set', $cache_key, $output );

      return $output;

    }


  } // class

}
