<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*/

if ( ! class_exists('TagGroups_Shortcode_Alphabet_Tabs') ) {

  class TagGroups_Shortcode_Alphabet_Tabs extends TagGroups_Shortcode {


    /**
    *
    * Render the tabbed tag cloud, usually by a shortcode, or returning a multidimensional array
    *
    * @param array $atts
    * @param bool $return_array
    * @return string
    */
    static function tag_groups_alphabet_tabs( $atts = array() ) {

      global $tag_group_groups;

      extract( shortcode_atts( array(
        'active' => null,
        'adjust_separator_size' => true,
        'amount' => 0,
        'append' => '',
        'assigned_class' => null,
        'collapsible' => null,
        'custom_title' => null,
        'div_class' => 'tag-groups-cloud',  // tag-groups-cloud preserved to create tab functionality
        'div_id' => 'tag-groups-cloud-alphabet-tabs-' . uniqid(),
        'exclude_terms' => '',
        'exclude_letters' => '',
        'hide_empty_tabs' => false,
        'hide_empty' => true,
        'include' => '',
        'include_letters' => '',
        'include_terms' => '',
        'largest' => 22,
        'link_append' => '',
        'link_target' => '',
        'mouseover' => null,
        'order' => 'ASC',
        'orderby' => 'name',
        'prepend' => '',
        'separator_size' => 12,
        'separator' => '',
        'show_tag_count' => true,
        'smallest' => 12,
        'source' => 'shortcode',
        'tags_post_id' => -1,
        'taxonomy' => null,
        'ul_class' => ''
      ), $atts ) );

      /**
      * Keep always jQuery UI class to produce correct output
      */
      if ( strpos( $div_class, 'tag-groups-cloud' )  === false ) {

        $div_class .= ' tag-groups-cloud';

      }

      $div_id_output = $div_id ? ' id="' . TagGroups_Base::sanitize_html_classes( $div_id ) . '"' : '';

      $div_class_output = $div_class ? ' class="' . TagGroups_Base::sanitize_html_classes( $div_class ) . '"' : '';

      if ( is_array( $atts ) ) {

        asort( $atts );

      }

      /*
      *  applying parameter tags_post_id
      */
      if ( $tags_post_id == 0 ) {

        $tags_post_id = get_the_ID();

      }

      $cache_key = md5( 'alphabet-tabs' . serialize( $atts ) . serialize( $tags_post_id ) );

      // check for a cached version (premium plugin)
      $html = apply_filters( 'tag_groups_hook_cache_get', false, $cache_key );

      if ( ! $html ) {

        $html_tabs = array();

        $html_tags = array();

        $post_id_terms = array();

        $assigned_terms = array();

        $include_tags_post_id_groups = array();

        if ( 'shortcode' == $source ) {

          $prepend = html_entity_decode( $prepend );

          $append = html_entity_decode( $append );

          $separator = html_entity_decode( $separator );

        }

        if ( 'natural' == $orderby ) {

          $natural_sorting = true;
          $orderby = 'name';

        } else {

          $natural_sorting = false;

        }

        if ( $smallest < 1 ) {

          $smallest = 1;

        }

        if ( $largest < $smallest ) {

          $largest = $smallest;

        }

        if ( $amount < 0 ) {

          $amount = 0;

        }

        if ( ! empty( $link_append ) && mb_strpos( $link_append, '?' ) === 0 ) {

          $link_append = mb_substr( $link_append, 1 );

        }

        if ( isset( $taxonomy ) ) {

          if ( empty( $taxonomy ) ) {

            unset( $taxonomy );

          } else {

            $taxonomy_array = explode( ',', $taxonomy );

            $taxonomy_array = array_filter( array_map( 'trim', $taxonomy_array ) );

          }
        }


        $taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

        if ( ! empty( $taxonomy_array ) ) {

          $taxonomies = array_intersect( $taxonomies, $taxonomy_array );

          if ( empty( $taxonomies ) ) {

            if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

              error_log( sprintf( '[Tag Groups] Wrong taxonomy in shortcode "tag_groups_cloud": %s', $taxonomy ) );

            }

            return '';

          }

        }

        $tag_group_ids = $tag_group_groups->get_group_ids_by_position();

        if ( $include !== '' ) {

          $include_array = explode( ',', str_replace( ' ', '', $include ) );

        } else {

          $include_array = $tag_group_ids;

        }

        /**
        * Reduce the risk of interference from other plugins
        */
        remove_all_filters( 'get_terms_orderby' );
        remove_all_filters( 'list_terms_exclusions' );
        remove_all_filters( 'get_terms' );

        $posttags = get_terms( $taxonomies, array( 'hide_empty' => $hide_empty, 'orderby' => $orderby, 'order' => $order, 'include' => $include_terms, 'exclude' => $exclude_terms ) );

        /**
        * In case of errors: return empty array
        */
        if ( ! is_array( $posttags ) ) {

          $posttags = array();

          if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

            error_log( '[Tag Groups] Error retrieving tags with get_terms.' );

          }

        }

        /*
        *  include
        */
        if ( $posttags ) {

          foreach ( $posttags as $key => $term ) {

            $term_o = new TagGroups_Term( $term->term_id );

            if ( ! $term_o->is_in_group( $include_array ) ) {

              unset( $posttags[ $key ] );

            }

          }

        }

        $ul_class_output = $ul_class ? ' class="' . TagGroups_Base::sanitize_html_classes( $ul_class ) . '"' : '';


        if ( $separator_size < 1 ) {

          $separator_size = 12;

        } else {

          $separator_size = (int) $separator_size;

        }

        if ( $tags_post_id > 0 ) {

          /*
          *  we have a particular post ID
          *  get all tags of this post
          */
          foreach ( $taxonomies as $taxonomy_item ) {

            $terms = get_the_terms( (int) $tags_post_id, $taxonomy_item );

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

        }

        // apply sorting that cannot be done on database level
        if ( $natural_sorting ) {

          $posttags = self::natural_sorting( $posttags, $order );

        } elseif ( 'random' == $orderby ) {

          $posttags = self::random_sorting( $posttags );

        }

        /**
        * Extract the alphabet
        */
        $alphabet = self::extract_alphabet( $posttags );

        /**
        * Use provided list to include
        */
        $include_letters = str_replace( ' ', '', $include_letters );

        if ( $include_letters != '' ) { // don't use empty()

          $include_letters_array = array();

          $include_letters = mb_strtolower( $include_letters );

          for ( $i = 0; $i < mb_strlen( $include_letters ); $i++ ) {

            $include_letters_array[] = mb_substr( $include_letters, $i, 1 );

          }

          $alphabet = array_intersect( $alphabet, $include_letters_array );

        }

        /**
        * Use provided list to exclude
        */
        $exclude_letters = str_replace( ' ', '', $exclude_letters );

        if ( $exclude_letters != '' ) { // don't use empty()

          $exclude_letters_array = array();

          $exclude_letters = mb_strtolower( $exclude_letters );

          for ( $i = 0; $i < mb_strlen( $exclude_letters ); $i++ ) {

            $exclude_letters_array[] = mb_substr( $exclude_letters, $i, 1 );

          }

          $alphabet = array_diff( $alphabet, $exclude_letters_array );

        }

        $alphabet = self::sort_alphabet( $alphabet );

        $html = '';

        /*
        *  render the tabs
        */

        $i = 0;

        foreach ( $alphabet as $letter ) {

          /**
          * Convert to upper case only now; otherwise ß would become SS and affect all cases with S
          */
          $html_tabs[ $i ] = '<li><a href="#tabs-1' . $i . '" >' . htmlentities( mb_strtoupper( $letter ), ENT_QUOTES, "UTF-8" ) . '</a></li>';

          $i++;

        }

        /*
        *  render the tab content
        */
        $min_max = self::determine_min_max_alphabet( $posttags, $amount, $alphabet );

        $post_counts = array();

        $i = 0;

        foreach ( $alphabet as $letter ) {

          $count_amount = 0;

          $html_tags[ $i ] = '';

          foreach ( $posttags as $key => $tag ) {

            $other_tag_classes = '';

            $description = '';

            if ( ! empty( $amount ) && $count_amount >= $amount ) {

              break;

            }

            if ( self::get_first_letter( $tag->name ) == $letter ) {

              $tag_count = $tag->count;

              if ( ! $hide_empty || $tag_count > 0 ) {

                $tag_link = get_term_link( $tag );

                if ( ! empty( $link_append ) ) {

                  if ( mb_strpos( $tag_link, '?' ) === false ) {

                    $tag_link = esc_url( $tag_link . '?' . $link_append );

                  } else {

                    $tag_link = esc_url( $tag_link . '&' . $link_append );

                  }

                }

                $font_size = self::font_size( $tag_count, $min_max[ $letter ]['min'], $min_max[ $letter ]['max'], $smallest, $largest );

                $font_size_separator = $adjust_separator_size ? $font_size : $separator_size;

                if ( $count_amount > 0 && ! empty( $separator ) ) {

                  $html_tags[ $i ] .= '<span style="font-size:' . $font_size_separator . 'px">' . $separator . '</span> ';

                }

                if ( ! empty( $assigned_class ) ) {

                  if ( ! empty( $assigned_terms[ $tag->term_id ] ) ) {

                    $other_tag_classes = ' ' . $assigned_class . '_1';

                  } else {

                    $other_tag_classes = ' ' . $assigned_class . '_0';

                  }

                }

                if ( ! empty( $custom_title ) ) {

                  $description = ! empty( $tag->description ) ? esc_html( $tag->description ) : '';

                  $title = preg_replace("/(\{description\})/", $description, $custom_title);

                  $title = preg_replace("/(\{count\})/", $tag_count, $title);

                } else {
                  // description and number
                  $description = ! empty( $tag->description ) ? esc_html( $tag->description ) . ' ' : '';

                  $tag_count_brackets = $show_tag_count ? '(' . $tag_count . ')' : '';

                  $title = $description . $tag_count_brackets;

                }

                // replace placeholders in prepend and append
                if ( ! empty( $prepend ) ) {

                  $prepend_output = preg_replace("/(\{count\})/", $tag_count, $prepend );

                } else {

                  $prepend_output = '';

                }

                if ( ! empty( $append ) ) {

                  $append_output = preg_replace("/(\{count\})/", $tag_count, $append );

                } else {

                  $append_output = '';

                }

                // adding link target
                $link_target_html = ! empty( $link_target ) ? 'target="' . $link_target . '"' : '';

                // assembling a tag
                $html_tags[ $i ] .= '<span class="tag-groups-tag' . $other_tag_classes . '" style="font-size:' . $font_size . 'px"><a href="' . $tag_link . '" ' . $link_target_html . ' title="' . $title . '"  class="' . $tag->slug . '">';

                if ( '' != $prepend_output ) {

                  $html_tags[ $i ] .= '<span class="tag-groups-prepend" style="font-size:' . $font_size . 'px">' . htmlentities( $prepend_output, ENT_QUOTES, "UTF-8" ) . '</span>';

                }

                $html_tags[ $i ] .= '<span class="tag-groups-label" style="font-size:' . $font_size . 'px">' . $tag->name . '</span>';

                if ( '' != $append_output ) {

                  $html_tags[ $i ] .= '<span class="tag-groups-append" style="font-size:' . $font_size . 'px">' . htmlentities( $append_output, ENT_QUOTES, "UTF-8" ) . '</span>';

                }

                $html_tags[ $i ] .= '</a></span> ';

                $count_amount++;

              }

              unset( $posttags[ $key ] ); // We don't need to look into that one again, since it can only appear under on tab

            }

          }

          if ( $hide_empty_tabs && ! $count_amount ) {

            unset( $html_tabs[ $i ] );

            unset( $html_tags[ $i ] );

          } elseif ( isset( $html_tags[ $i ] ) ) {

            $html_tags[ $i ] = '<div id="tabs-1' . $i . '">' .  $html_tags[ $i ] . '</div>';

          }

          $i++;

        }

        /*
        * assemble tabs
        */
        $html .= '<ul' . $ul_class_output . '>' . implode( "\n", $html_tabs ) . '</ul>';

        /*
        * assemble tags
        */
        $html .= implode( "\n", $html_tags );

        // create a cached version (premium plugin)
        do_action( 'tag_groups_hook_cache_set', $cache_key, $html );

      }

      $html = '<div' . $div_id_output . $div_class_output . '>' . $html . '</div>'; // entire wrapper

      $html .= self::custom_js_tabs( $div_id, $mouseover, $collapsible, $active );

      return $html;

    }


    /**
    * Extract the first letter of a name
    *
    * @param string $tag tag name
    * @return string
    */
    public static function get_first_letter( $tag )
    {

      return mb_strtolower( mb_substr( $tag, 0, 1 ) );

    }


    /**
    * Extract the first letters of the tags
    *
    * @param array $posttags names of tags in WP array
    * @return array
    */
    public static function extract_alphabet( $posttags )
    {

      $alphabet = array();

      foreach ( $posttags as $tag ) {

        $first_letter = self::get_first_letter( $tag->name );

        if ( ! in_array( $first_letter, $alphabet ) ) {

          $alphabet[] = $first_letter;

        }

      }

      return $alphabet;

    }


    /**
    * Sorts the alphabet according to the current sort order
    *
    * @param array $alphabet first letters
    * @return array
    */
    public static function sort_alphabet( $alphabet )
    {

      // TODO: consider WPML

      if ( class_exists( 'Collator' ) ) {
        // Collator can consider locale

        $collator = new Collator( get_locale() );

        $collator->sort( $alphabet );

      } else {

        sort( $alphabet );

      }

      return $alphabet;

    }


    /*
    *  find minimum and maximum of quantity of posts for each tag
    */
    static function determine_min_max_alphabet( $tags, $amount, $alphabet ) {

      $min_max = array();

      $count_amount = array();

      foreach ( $alphabet as $letter ) {

        $count_amount[ $letter ] = 0;

        $min_max[ $letter ]['min'] = 0;

        $min_max[ $letter ]['max'] = 0;

      }

      if ( empty( $tags ) || ! is_array( $tags ) ) {

        return $min_max;

      }

      foreach ( $tags as $tag ) {

        $first_letter = self::get_first_letter( $tag->name );

        if ( in_array( $first_letter, $alphabet ) ) {

          $tag_count = $tag->count;

          if ( $tag_count > 0 ) {

            if ( isset( $min_max[ $first_letter ]['max'] ) && $tag_count > $min_max[ $first_letter ]['max'] ) {

              $min_max[ $first_letter ]['max'] = $tag_count;

            }

            if ( isset( $min_max[ $first_letter ]['min'] ) && ( $tag_count < $min_max[ $first_letter ]['min'] || 0 == $min_max[ $first_letter ]['min'] ) ) {

              $min_max[ $first_letter ]['min'] = $tag_count;

            }

            $count_amount[ $first_letter ]++;

          }

        }

      }

      return $min_max;

    }


  } // class

}
