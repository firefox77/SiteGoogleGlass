<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*/

if ( ! class_exists('TagGroups_Admin') ) {

  class TagGroups_Admin {


    function __construct() {
    }


    /**
    * Initial settings after calling the plugin
    * Effective only for admin backend
    */
    static function admin_init() {

      global $tag_groups_premium_fs_sdk;

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      if ( $tag_groups_premium_fs_sdk->is_plan_or_trial('premium') ) {

        $tag_group_role_edit_tags = class_exists( 'TagGroups_Premium' ) ? get_option( 'tag_group_role_edit_tags', 'manage_options' ) : 'manage_options';

        $tag_group_role_edit_groups = class_exists( 'TagGroups_Premium' ) ? get_option( 'tag_group_role_edit_groups', 'edit_pages' ) : 'edit_pages';

      } else {

        $tag_group_role_edit_tags = 'manage_options';

        $tag_group_role_edit_groups = 'edit_pages';

      }

      if ( current_user_can( $tag_group_role_edit_tags ) ) {

        foreach ( $enabled_taxonomies as $taxonomy ) {

          // creating and editing tags
          add_action( "{$taxonomy}_edit_form_fields", array( 'TagGroups_Admin', 'tag_input_metabox' ) );

          add_action( "{$taxonomy}_add_form_fields", array( 'TagGroups_Admin', 'create_new_tag' ) );

        }

        /**
        * Actions that require permissions
        */
        add_action( 'quick_edit_custom_box', array( 'TagGroups_Admin', 'quick_edit_tag' ), 10, 3 );

        add_action( 'admin_footer-edit-tags.php', array( 'TagGroups_Admin', 'quick_edit_javascript' ) );

        add_action( 'admin_footer-edit-tags.php', array( 'TagGroups_Admin', 'bulk_admin_footer' ) );

        add_filter( 'tag_row_actions', array( 'TagGroups_Admin', 'expand_quick_edit_link' ), 10, 2 );

        add_action( 'groups_of_term_saved', array( 'TagGroups_Admin', 'update_post_meta' ), 10, 2 );

        add_action( 'load-edit-tags.php', array( 'TagGroups_Admin', 'do_bulk_action' ) );

        add_action( 'create_term', array( 'TagGroups_Admin', 'copy_term_group' ), 20 );

      }

      foreach ( $enabled_taxonomies as $taxonomy ) {

        // extra columns on tag page
        add_filter( "manage_edit-{$taxonomy}_columns", array( 'TagGroups_Admin', 'add_taxonomy_columns' ) );

        add_filter( "manage_{$taxonomy}_custom_column", array( 'TagGroups_Admin', 'add_taxonomy_column_content' ), 10, 3 );

      }

      add_action( 'load-edit-tags.php', array( 'TagGroups_Admin', 'do_filter_tags' ) );

      add_action( 'admin_head', array( 'TagGroups_Admin', 'add_tag_page_styling' ) );

      add_action( 'admin_footer-edit-tags.php', array( 'TagGroups_Admin', 'filter_admin_footer' ) );

      /**
      * Process data submitted from settings forms
      */
      add_action( 'in_admin_header', array( 'TagGroups_Settings', 'settings_page_actions' ) );

      /**
      * Process data submitted from setup wizard forms
      */
      add_action( 'in_admin_header', array( 'TagGroups_Settings', 'settings_page_actions_wizard' ) );


      add_action( 'create_term', array( 'TagGroups_Admin', 'update_edit_term_group_create' ) );

      add_action( 'edit_term', array( 'TagGroups_Admin', 'update_edit_term_group_edit' ) );

      add_action( 'delete_term', array( 'TagGroups_Admin', 'update_post_meta' ), 10, 2 );

      add_filter( "plugin_action_links_" . TAG_GROUPS_PLUGIN_BASENAME, array( 'TagGroups_Admin', 'add_plugin_settings_link' ) );

      add_action( 'restrict_manage_posts', array( 'TagGroups_Admin', 'add_post_filter' ) );

      add_filter( 'parse_query', array( 'TagGroups_Admin', 'apply_post_filter' ) );

      // Ajax Handler
      if ( current_user_can( $tag_group_role_edit_groups ) ) {

        add_action( 'wp_ajax_tg_ajax_manage_groups', array( 'TagGroups_Admin', 'ajax_manage_groups' ) );

      }

      add_action( 'wp_ajax_tg_ajax_get_feed', array( 'TagGroups_Admin', 'ajax_get_feed' ) );

      add_action( 'admin_notices', array( 'TagGroups_Admin', 'add_language_notice' ) );

    }


    /**
    * Adds the submenus and the settings page to the admin backend
    */
    static function register_menus()
    {

      // Add the main menu
      add_menu_page(
        __( 'Home', 'tag-groups' ),
        'Tag Groups',
        'manage_options',
        'tag-groups-settings',
        array( 'TagGroups_Settings', 'settings_page_home' ),
        'dashicons-tag',
        '99.01'
      );

      // Define the menu structure
      $tag_groups_admin_structure = array(
        0 => array(
          'title'     => __( 'Home', 'tag-groups' ),
          'slug'      => 'tag-groups-settings', // repeating the slug of the top-level menu page to prevent it from reappearing as submenu
          'parent'    => 'tag-groups-settings',
          'user_can'  => 'manage_options',
          'function'  => array( 'TagGroups_Settings', 'settings_page_home' ),
        ),
        1 => array(
          'title'     => __( 'Taxonomies', 'tag-groups' ),
          'slug'      => 'tag-groups-settings-taxonomies',
          'parent'    => 'tag-groups-settings',
          'user_can'  => 'manage_options',
          'function'  => array( 'TagGroups_Settings', 'settings_page_taxonomies' ),
        ),
        3 => array(
          'title'     => __( 'Front End', 'tag-groups' ),
          'slug'      => 'tag-groups-settings-front-end',
          'parent'    => 'tag-groups-settings',
          'user_can'  => 'manage_options',
          'function'  => array( 'TagGroups_Settings', 'settings_page_front_end' ),
        ),
        4 => array(
          'title'     => __( 'Back End', 'tag-groups' ),
          'slug'      => 'tag-groups-settings-back-end',
          'parent'    => 'tag-groups-settings',
          'user_can'  => 'manage_options',
          'function'  => array( 'TagGroups_Settings', 'settings_page_back_end' ),
        ),
        5 => array(
          'title'     => __( 'Tools', 'tag-groups' ),
          'slug'      => 'tag-groups-settings-tools',
          'parent'    => 'tag-groups-settings',
          'user_can'  => 'manage_options',
          'function'  => array( 'TagGroups_Settings', 'settings_page_tools' ),
        ),
        6 => array(
          'title'     => __( 'Troubleshooting', 'tag-groups' ),
          'slug'      => 'tag-groups-settings-troubleshooting',
          'parent'    => 'tag-groups-settings',
          'user_can'  => 'manage_options',
          'function'  => array( 'TagGroups_Settings', 'settings_page_troubleshooting' ),
        ),
        // /: back end
        7 => array(
          'title'     => __( 'Premium', 'tag-groups' ),
          'slug'      => 'tag-groups-settings-premium',
          'parent'    => 'tag-groups-settings',
          'user_can'  => 'manage_options',
          'function'  => array( 'TagGroups_Settings', 'settings_page_premium' ),
        ),
        8 => array(
          'title'     => __( 'About', 'tag-groups' ),
          'slug'      => 'tag-groups-settings-about',
          'parent'    => 'tag-groups-settings',
          'user_can'  => 'manage_options',
          'function'  => array( 'TagGroups_Settings', 'settings_page_about' ),
        ),
        9 => array(
          'title'     => __( 'First Steps', 'tag-groups' ),
          'slug'      => 'tag-groups-settings-first-steps',
          'parent'    => null, // no menu
          'user_can'  => 'manage_options',
          'function'  => array( 'TagGroups_Settings', 'settings_page_onboarding' ),
        ),
        10 => array(
          'title'     => __( 'Setup Wizard', 'tag-groups' ),
          'slug'      => 'tag-groups-settings-setup-wizard',
          'parent'    => null, // no menu
          'user_can'  => 'manage_options',
          'function'  => array( 'TagGroups_Settings', 'settings_page_setup_wizard' ),
        ),
      );

      // hook for premium plugin to modify the menu
      $tag_groups_admin_structure = apply_filters( 'tag_groups_admin_structure', $tag_groups_admin_structure );

      // make sure they all have the right order
      ksort( $tag_groups_admin_structure );

      // register the menus and pages
      foreach ( $tag_groups_admin_structure as $tag_groups_admin_page ) {

        add_submenu_page(
          $tag_groups_admin_page['parent'],
          $tag_groups_admin_page['title'],
          $tag_groups_admin_page['title'],
          $tag_groups_admin_page['user_can'],
          $tag_groups_admin_page['slug'],
          $tag_groups_admin_page['function']
        );

      }


      // for each registered taxonomy a tag group admin page

      $tag_group_taxonomies = get_option( 'tag_group_taxonomy', array('post_tag') );

      $tag_group_role_edit_groups = class_exists( 'TagGroups_Premium' ) ? get_option( 'tag_group_role_edit_groups', 'edit_pages' ) : 'edit_pages';

      $tag_group_post_types = TagGroups_Taxonomy::post_types_from_taxonomies( $tag_group_taxonomies );

      foreach ( $tag_group_post_types as $post_type ) {

        if ( 'post' == $post_type ) {

          $post_type_query = '';

        } else {

          $post_type_query = '?post_type=' . $post_type;

        }

        $submenu_page = add_submenu_page( 'edit.php' . $post_type_query, 'Tag Group Admin', 'Tag Group Admin', $tag_group_role_edit_groups, 'tag-groups_' . $post_type, array( 'TagGroups_Admin', 'group_administration' ) );

        if ( class_exists( 'TagGroups_Premium_Admin' ) && method_exists( 'TagGroups_Premium_Admin', 'add_screen_option' ) ) {

          add_action( "load-$submenu_page", array( 'TagGroups_Premium_Admin', 'add_screen_option' ) );

        }

      }

    }


    /**
    * Create the html to add tags to tag groups on single tag view (after clicking tag for editing)
    * @param type $tag
    */
    static function tag_input_metabox( $tag )
    {

      global $tag_groups_premium_fs_sdk, $tag_group_groups;

      $screen = get_current_screen();

      if ( 'post' == $screen->post_type ) {

        $url_post_type = '';

      } else {

        $url_post_type = '&post_type=' . $screen->post_type;

      }

      $tag_group_admin_url = admin_url( 'edit.php?page=tag-groups_' . $screen->post_type . $url_post_type );

      $data = $tag_group_groups->get_all_with_position_as_key();

      unset( $data[0] );

      $tg_term = new TagGroups_Term( $tag );

      $view = new TagGroups_View( 'admin/new_tag_main' );

      $view->set( array(
        'data'                      => $data,
        'tag_groups_premium_fs_sdk' => $tag_groups_premium_fs_sdk,
        'screen'                    => $screen,
        'tg_term'                   => $tg_term,
        'tag_group_admin_url'       => $tag_group_admin_url
      ) );

      $view->render();

    }


    /**
    * Create the html to assign tags to tag groups upon new tag creation (left of the table)
    * @param type $tag
    */
    static function create_new_tag( $tag )
    {

      global $tag_groups_premium_fs_sdk, $tag_group_groups;

      $screen = get_current_screen();

      $data = $tag_group_groups->get_all_with_position_as_key();

      unset( $data[0] );

      $view = new TagGroups_View( 'admin/new_tag_from_list' );

      $view->set( array(
        'data'                      => $data,
        'tag_groups_premium_fs_sdk' => $tag_groups_premium_fs_sdk,
        'screen'                    => $screen
      ) );

      $view->render();

    }



    /**
    * adds a custom column to the table of tags/terms
    * thanks to http://coderrr.com/add-columns-to-a-taxonomy-terms-table/
    * @global object $wp
    * @param array $columns
    * @return string
    */
    static function add_taxonomy_columns( $columns )
    {

      global $wp;

      $new_order = (isset( $_GET['order'] ) && $_GET['order'] == 'asc' && isset( $_GET['orderby'] ) && $_GET['orderby'] == 'term_group') ? 'desc' : 'asc';

      $screen = get_current_screen();

      if ( ! empty( $screen )) {

        $taxonomy = $screen->taxonomy;


        $link = add_query_arg( array('orderby' => 'term_group', 'order' => $new_order, 'taxonomy' => $taxonomy), admin_url( "edit-tags.php" . $wp->request ) );

        $link_escaped = esc_url( $link );

        $columns['term_group'] = '<a href="' . $link_escaped . '"><span>' . __( 'Tag Groups', 'tag-groups' ) . '</span><span class="sorting-indicator"></span></a>';

      }  else {

        $columns['term_group'] = '';

      }

      return $columns;

    }



    /**
    * adds data into custom column of the table for each row
    * thanks to http://coderrr.com/add-columns-to-a-taxonomy-terms-table/
    * @param type $a
    * @param type $b
    * @param type $term_id
    * @return string
    */
    static function add_taxonomy_column_content( $a = '', $b = '', $term_id = 0 )
    {

      global $tag_group_groups;

      if ( 'term_group' != $b ) {

        return $a;

      } // credits to Navarro (http://navarradas.com)

      if ( ! empty( $_REQUEST['taxonomy'] ) ) {

        $taxonomy = sanitize_title( $_REQUEST['taxonomy'] );

      } else {

        return '';
      }

      $term = get_term( $term_id, $taxonomy );

      if ( isset( $term ) ) {

        $term_o = new TagGroups_Term( $term );

        return implode( ', ', $tag_group_groups->get_labels_by_position( $term_o->get_groups() ) ) ;

      } else {

        return '';

      }

    }


    /**
    *
    * processing actions defined in bulk_admin_footer()
    * credits http://www.foxrunsoftware.net
    * @global int $tg_update_edit_term_group_called
    * @return void
    */
    static function do_bulk_action()
    {

      global $tg_update_edit_term_group_called, $tag_group_groups;

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      $screen = get_current_screen();

      $taxonomy = $screen->taxonomy;

      if ( is_object( $screen ) && ( ! in_array( $taxonomy, $enabled_taxonomies ) ) ) {

        return;

      }

      $show_filter_tags = get_option( 'tag_group_show_filter_tags', 1 );

      if ( $show_filter_tags ) {

        $tag_group_tags_filter = get_option( 'tag_group_tags_filter', array() );

        /*
        * Processing the filter
        * Values come as POST (via menu, precedence) or GET (via link from group admin)
        */
        if ( isset( $_POST['term-filter'] ) ) {

          $term_filter = (int) $_POST['term-filter'];

        } elseif ( isset( $_GET['term-filter'] ) ) {

          $term_filter = (int) $_GET['term-filter'];

          // We need to remove the term-filter piece, or it will stay forever
          $sendback = remove_query_arg( array( 'term-filter' ), $_SERVER['REQUEST_URI']);

        }

        if ( isset( $term_filter ) ) {

          if ( '-1' == $term_filter ) {

            unset( $tag_group_tags_filter[ $taxonomy ] );

            update_option( 'tag_group_tags_filter', $tag_group_tags_filter );

          } else {

            $tag_group_tags_filter[ $taxonomy ] = $term_filter;

            update_option( 'tag_group_tags_filter', $tag_group_tags_filter );

            /*
            * Modify the query
            */
            add_action( 'terms_clauses', array( 'TagGroups_Admin', 'terms_clauses' ), 10, 3 );

          }

          if ( isset( $sendback ) ) {

            // remove filter that destroys WPML's "&lang="
            remove_all_filters( 'wp_redirect' );

            // escaping $sendback
            wp_redirect( esc_url_raw( $sendback ) );

            exit;

          }

        } else {

          /*
          * If filter is set, make sure to modify the query
          */
          if ( isset( $tag_group_tags_filter[ $taxonomy ] ) ) {

            add_action( 'terms_clauses', array( 'TagGroups_Admin', 'terms_clauses' ), 10, 3 );

          }
        }

      }

      $wp_list_table = _get_list_table( 'WP_Terms_List_Table' );

      $action = $wp_list_table->current_action();

      $allowed_actions = array( 'assign' );

      if ( ! in_array( $action, $allowed_actions ) ) {

        return;

      }

      if ( isset( $_REQUEST['delete_tags'] ) ) {

        $term_ids = $_REQUEST['delete_tags'];

      }

      if ( isset( $_REQUEST['term-group-top'] ) ) {

        $term_group = (int) $_REQUEST['term-group-top'];

      } else {

        return;

      }

      $sendback = remove_query_arg( array( 'assigned', 'deleted' ), wp_get_referer() );

      if ( !$sendback ) {

        $sendback = admin_url( 'edit-tags.php?taxonomy=' . $taxonomy );

      }

      if ( empty( $term_ids ) ) {

        $sendback = add_query_arg( array( 'number_assigned' => 0, 'group_id' => $term_group ), $sendback );

        $sendback = remove_query_arg( array( 'action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status', 'post', 'bulk_edit', 'post_view' ), $sendback );

        // escaping $sendback
        wp_redirect( esc_url_raw( $sendback ) );

        exit();

      }

      $pagenum = $wp_list_table->get_pagenum();

      $sendback = add_query_arg( 'paged', $pagenum, $sendback );

      $tg_update_edit_term_group_called = true; // skip update_edit_term_group()

      switch ( $action ) {
        case 'assign':

        $assigned = 0;

        foreach ( $term_ids as $term_id ) {

          $term = new TagGroups_Term( $term_id );

          if ( false !== $term ) {

            if ( 0 == $term_group ) {

              $term->remove_all_groups()->save();

            } else {

              $term->add_group( $term_group )->save();

            }

            $assigned++;

          }

        }

        if ( 0 == $term_group ) {

          $message = _n( 'The term has been removed from all groups.', sprintf( '%d terms have been removed from all groups.', number_format_i18n( (int) $assigned ) ), (int) $assigned, 'tag-groups' );

        } else {

          $tg_group = new TagGroups_Group( $term_group );

          $message = _n( sprintf( 'The term has been assigned to the group %s.', '<i>' . $tg_group->get_label() . '</i>' ), sprintf( '%d terms have been assigned to the group %s.', number_format_i18n( (int) $assigned ), '<i>' . $tg_group->get_label() . '</i>' ), (int) $assigned, 'tag-groups' );
        }

        break;

        default:

        // Need to show a message?
        exit();

        break;
      }

      TagGroups_Admin_Notice::add( 'success', $message );

      $sendback = remove_query_arg( array( 'action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status', 'post', 'bulk_edit', 'post_view' ), $sendback );

      wp_redirect( esc_url_raw( $sendback ) );

      exit();

    }


    /**
    * Filter the tags on the tag page
    *
    * @return void
    */
    static function do_filter_tags()
    {

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      $screen = get_current_screen();

      $taxonomy = $screen->taxonomy;

      if ( is_object( $screen ) && ( ! in_array( $taxonomy, $enabled_taxonomies ) ) ) {

        return;

      }

      $show_filter_tags = get_option( 'tag_group_show_filter_tags', 1 );

      if ( $show_filter_tags ) {

        $tag_group_tags_filter = get_option( 'tag_group_tags_filter', array() );

        /*
        * Processing the filter
        * Values come as POST (via menu, precedence) or GET (via link from group admin)
        */
        if ( isset( $_POST['term-filter'] ) ) {

          $term_filter = (int) $_POST['term-filter'];

        } elseif ( isset( $_GET['term-filter'] ) ) {

          $term_filter = (int) $_GET['term-filter'];

          // We need to remove the term-filter piece, or it will stay forever
          $sendback = remove_query_arg( array( 'term-filter' ), $_SERVER['REQUEST_URI'] );

        }

        if ( isset( $term_filter ) ) {

          if ( '-1' == $term_filter ) {

            unset( $tag_group_tags_filter[ $taxonomy ] );

            update_option( 'tag_group_tags_filter', $tag_group_tags_filter );

          } else {

            $tag_group_tags_filter[ $taxonomy ] = $term_filter;

            update_option( 'tag_group_tags_filter', $tag_group_tags_filter );

            /*
            * Modify the query
            */
            add_action( 'terms_clauses', array( 'TagGroups_Admin', 'terms_clauses' ), 10, 3 );

          }

          if ( isset( $sendback ) ) {

            // remove filter that destroys WPML's "&lang="
            remove_all_filters( 'wp_redirect' );

            // escaping $sendback
            wp_redirect( esc_url_raw( $sendback ) );

            exit;

          }

        } else {

          /*
          * If filter is set, make sure to modify the query
          */
          if ( isset( $tag_group_tags_filter[ $taxonomy ] ) ) {

            add_action( 'terms_clauses', array( 'TagGroups_Admin', 'terms_clauses' ), 10, 3 );

          }

        }

      }


      // $sendback = remove_query_arg( array( 'action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status', 'post', 'term-filter', 'post_view' ), wp_get_referer() );
      //
      // wp_redirect( esc_url_raw( $sendback ) );
      //
      // exit();

    }


    /**
    * modifies Quick Edit link to call JS when clicked
    * thanks to http://shibashake.com/WordPress-theme/expand-the-WordPress-quick-edit-menu
    * @param array $actions
    * @param object $tag
    * @return array
    */
    static function expand_quick_edit_link( $actions, $tag )
    {

      $screen = get_current_screen();

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      if ( is_object( $screen ) && (!in_array( $screen->taxonomy, $enabled_taxonomies ) ) ) {

        return $actions;

      }

      $term_o = new TagGroups_Term( $tag );

      $groups = htmlspecialchars( json_encode( $term_o->get_groups() ) );


      $nonce = wp_create_nonce( 'tag-groups-nonce' );

      $actions['inline hide-if-no-js'] = '<a href="javascript:void(0)" class="editinline" title="';

      $actions['inline hide-if-no-js'] .= esc_attr( __( 'Edit this item inline', 'tag-groups' ) ) . '" ';

      $actions['inline hide-if-no-js'] .= " onclick=\"set_inline_tag_group_selected('{$groups}', '{$nonce}')\">";

      $actions['inline hide-if-no-js'] .= __( 'Quick&nbsp;Edit', 'tag-groups' );

      $actions['inline hide-if-no-js'] .= '</a>';

      return $actions;

    }


    /**
    * adds JS function that sets the saved tag group for a given element when it's opened in quick edit
    * thanks to http://shibashake.com/WordPress-theme/expand-the-WordPress-quick-edit-menu
    * @return void
    */
    static function quick_edit_javascript()
    {

      global $tag_groups_premium_fs_sdk;

      $screen = get_current_screen();

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      if ( ! in_array( $screen->taxonomy, $enabled_taxonomies ) ) {

        return;
      }

      $view = new TagGroups_View( 'admin/quick_edit_javascript' );

      $view->set( 'tag_groups_premium_fs_sdk', $tag_groups_premium_fs_sdk );

      $view->render();

    }


    /**
    * Create the html to assign tags to tag groups directly in tag table ('quick edit')
    * @return type
    */
    static function quick_edit_tag()
    {

      global $tg_quick_edit_tag_called, $tag_group_groups;

      if ( $tg_quick_edit_tag_called ) {

        return;

      }

      $tg_quick_edit_tag_called = true;

      $screen = get_current_screen();

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      if ( ! in_array( $screen->taxonomy, $enabled_taxonomies ) ) {

        return;

      }

      $data = $tag_group_groups->get_all_with_position_as_key();

      unset( $data[0] );

      $view = new TagGroups_View( 'admin/quick_edit_tag' );

      $view->set( array(
        'data'    => $data,
        'screen'  => $screen,
      ) );

      $view->render();

    }


    /**
    * Updates the post meta
    *
    *
    * @param type var Description
    * @return return type
    */
    public static function update_post_meta( $term_id, $term_groups = array() )
    {

      global $tag_group_posts;

      /**
      * update the post meta
      */
      if ( class_exists( 'TagGroups_Premium_Post' ) ) {

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

          error_log( '[Tag Groups Premium] Checking if posts need to be migrated.' );

          $start_time = microtime( true );

        }

        $count = $tag_group_posts->update_post_meta_for_term( $term_id, $term_groups );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

          error_log( sprintf( '[Tag Groups Premium] Meta of %d post(s) updated in %d milliseconds.', $count, round( ( microtime( true ) - $start_time ) * 1000 ) ) );

        }

      }

    }


    /**
    * Get the $_POSTed value after saving a tag/term and save it in the table
    *
    * @global int $tg_update_edit_term_group_called
    * @param int $term_id
    * @return void
    */
    public static function update_edit_term_group_create( $term_id )
    {

      // next lines to prevent infinite loops when the hook edit_term is called again from the function wp_update_term
      global $tg_update_edit_term_group_called;

      if ( $tg_update_edit_term_group_called ) {

        return;

      }

      self::update_edit_term_group_from_edit( $term_id );

    }


    /**
    * Get the $_POSTed value after saving a tag/term and save it in the table
    *
    * @global int $tg_update_edit_term_group_called
    * @param int $term_id
    * @return void
    */
    public static function update_edit_term_group_edit( $term_id )
    {

      // next lines to prevent infinite loops when the hook edit_term is called again from the function wp_update_term
      global $tg_update_edit_term_group_called;

      if ( $tg_update_edit_term_group_called ) {

        return;

      }

      self::update_edit_term_group_from_edit( $term_id );

      /**
      *   If necessary we also save default WP term properties.
      *   Make sure we have a taxonomy
      */
      if ( isset( $_POST['tag-groups-taxonomy'] ) ) {

        $taxonomy = sanitize_title( $_POST['tag-groups-taxonomy'] );

        $args = array();

        /**
        * Save the tag name
        */
        if ( isset( $_POST['name'] ) && ( $_POST['name'] != '' ) ) { // allow zeros

          $args['name'] = stripslashes( sanitize_text_field( $_POST['name'] ) );

        }

        /**
        * Save the tag slug
        */
        if ( isset( $_POST['slug'] ) ) { // allow empty values

          $args['slug'] = sanitize_title( $_POST['slug'] );

        }

        /**
        * Save the tag description
        */
        if ( isset( $_POST['description'] ) ) { // allow empty values

          /**
          * Check if the settings require us to omit sanitization
          */
          if ( get_option( 'tag_group_html_description', 0 ) ) {

            $args['description'] = $_POST['description'];

          } else {

            $args['description'] = stripslashes( sanitize_text_field( $_POST['description'] ) );

          }

        }

        /**
        * Save the parent
        */
        if ( isset( $_POST['parent'] ) && ($_POST['parent'] != '') ) {

          $args['parent'] = (int) $_POST['parent'] ;

        }

        wp_update_term( $term_id, $taxonomy, $args );

      }

    }


    /**
    * Get the $_POSTed value after saving a tag/term and save it in the table
    *
    * @param int $term_id
    * @return void
    */
    public static function update_edit_term_group_from_edit( $term_id )
    {

      global $tg_update_edit_term_group_called;

      $screen = get_current_screen();

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();


      $tg_update_edit_term_group_called = true;


      // if ( ( ! is_object( $screen ) || ! in_array( $screen->taxonomy, $enabled_taxonomies ) ) && ! isset( $_POST['new-tag-created'] ) ) {
      if ( is_object( $screen ) && ( ! in_array( $screen->taxonomy, $enabled_taxonomies ) ) && ( ! isset( $_POST['new-tag-created'] ) ) ) {

        return;

      }


      if ( empty( $_POST['tag-groups-nonce'] ) || ! wp_verify_nonce( $_POST['tag-groups-nonce'], 'tag-groups-nonce' ) ) {

        return;
        // die( "Security check" );

      }

      $term = new TagGroups_Term( (int) $term_id );

      if ( ! empty( $_POST['term-group'] ) ) {

        if ( is_array( $_POST['term-group'] ) ) {

          $term_group = array_map( 'intval', $_POST['term-group'] );

        } else {

          $term_group = (int) $_POST['term-group'];

        }

        $term->set_group( $term_group )->save();

      } else {
        // $_POST['term-group'] won't be set if multi select is empty => evaluate empty value as "unassigned"

        $term->set_group( 0 )->save();

      }

    }


    /**
    * WPML: Check if we need to copy group info to the translation
    *
    * Copy the groups of an original term to its translation if a translation is saved
    *
    * @param type $term_id
    * @return type
    */
    public static function copy_term_group( $term_id ) {

      /**
      * Check if WPML is available
      */
      $default_language_code = apply_filters( 'wpml_default_language', null );

      if ( ! isset( $default_language_code ) ) {

        return;

      }


      /**
      * Check if the new tag has no group set or groups set to unassigned
      */
      $term = new TagGroups_Term( $term_id );

      $translated_term_groups = $term->get_groups();

      if ( ! empty( $translated_term_groups ) && $translated_term_groups != array( 0 ) ) {

        return;

      }


      /**
      *   edit-tags.php form
      */
      if (
        isset( $_POST['icl_tax_post_tag_language'] )
        && $_POST['icl_tax_post_tag_language'] != $default_language_code
      ) {

        if ( ! empty( $_POST['icl_translation_of'] ) ) {
          // translated from the default language

          $original_term_id = $_POST['icl_translation_of'];

        } elseif ( ! empty( $_POST['icl_trid'] ) ) {
          // translated from another translated language

          $translations = apply_filters( 'wpml_get_element_translations', null, $_POST['icl_trid'] );

          if ( isset( $translations[ $default_language_code ]->element_id ) ) {

            $original_term_id = $translations[ $default_language_code ]->element_id;

          }

        }

      }


      /**
      *   taxonomy-translation.php form
      */
      elseif (
        isset( $_POST['term_language_code'] )
        && $_POST['term_language_code'] != $default_language_code
        && ! empty( $_POST['trid'] )
      ) {

        $translations = apply_filters( 'wpml_get_element_translations', null, $_POST['trid'] );

        if ( isset( $translations[ $default_language_code ]->element_id ) ) {

          $original_term_id = $translations[ $default_language_code ]->element_id;

        }

      }


      if ( isset( $original_term_id ) ) {

        $tg_original_term = new TagGroups_Term( $original_term_id );

        $original_term_groups = $tg_original_term->get_groups();

        if ( ! empty( $original_term_groups) ) {

          $term->set_group( $original_term_groups )->save();

        }

      }

    }


    /**
    * Adds a bulk action menu to a term list page
    * credits http://www.foxrunsoftware.net
    * @return void
    */
    static function bulk_admin_footer()
    {

      global $tag_group_groups;

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      $screen = get_current_screen();

      if ( is_object( $screen ) && ( ! in_array( $screen->taxonomy, $enabled_taxonomies ) ) ) {

        return;

      }

      $show_filter_tags = get_option( 'tag_group_show_filter_tags', 1 );

      $data = $tag_group_groups->get_all_with_position_as_key();

      $view = new TagGroups_View( 'admin/bulk_admin_footer' );

      $view->set( array(
        'data'  => $data
      ) );

      $view->render();

    }


    /**
    * Adds a bulk action menu to a term list page
    * credits http://www.foxrunsoftware.net
    * @return void
    */
    static function filter_admin_footer()
    {

      global $tag_group_groups;

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      $screen = get_current_screen();

      if ( is_object( $screen ) && ( ! in_array( $screen->taxonomy, $enabled_taxonomies ) ) ) {

        return;

      }

      $show_filter_tags = get_option( 'tag_group_show_filter_tags', 1 );


      $data = $tag_group_groups->get_all_with_position_as_key();


      if ( $show_filter_tags ) :

        $tag_group_tags_filter = get_option( 'tag_group_tags_filter', array() );

        if ( isset( $tag_group_tags_filter[ $screen->taxonomy ] ) ) {

          $tag_filter = $tag_group_tags_filter[ $screen->taxonomy ];

        } else {

          $tag_filter = -1;

        }

        $view = new TagGroups_View( 'admin/filter_admin_footer' );

        $view->set( array(
          'data'        => $data,
          'tag_filter'  => $tag_filter
        ) );

        $view->render();

      endif;

    }


    /**
    * Adds a pull-down menu to the filters above the posts.
    * Based on the code by Ohad Raz, http://wordpress.stackexchange.com/q/45436/2487
    * License: Creative Commons Share Alike
    * @return void
    */
    static function add_post_filter()
    {

      global $tag_group_groups;

      if ( ! get_option( 'tag_group_show_filter', 1 ) ) {

        return;

      }

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      $post_type = ( isset( $_GET['post_type'] ) ) ? sanitize_title( $_GET['post_type'] ) : 'post';

      if ( count( array_intersect( $enabled_taxonomies, get_object_taxonomies( $post_type ) ) ) ) {

        $data = $tag_group_groups->get_all_term_group_label();

        $current_term_group = isset( $_GET['tg_filter_posts_value'] ) ? sanitize_text_field( $_GET['tg_filter_posts_value'] ) : '';

        $view = new TagGroups_View( 'admin/post_filter' );

        $view->set( array(
          'data'                => $data,
          'current_term_group'  => $current_term_group
        ) );

        $view->render();

      }

    }


    /**
    * Applies the filter, if used.
    * Based on the code by Ohad Raz, http://wordpress.stackexchange.com/q/45436/2487
    * License: Creative Commons Share Alike
    *
    * @global type $pagenow
    * @param type $query
    * @return type
    */
    static function apply_post_filter( $query )
    {

      global $pagenow, $tag_group_posts;

      if ( $pagenow != 'edit.php' ) {

        return $query;

      }

      $show_filter_posts = get_option( 'tag_group_show_filter', 1 );

      if ( ! $show_filter_posts ) {

        return $query;

      }

      if ( isset( $_GET['post_type'] ) ) {

        $post_type = sanitize_title( $_GET['post_type'] );

      } else {

        $post_type = 'post';

      }

      /**
      * Losing here the filter by language from Polylang, but currently no other way to show any posts when combining tax_query and meta_query
      */
      unset( $query->query_vars['tax_query'] );


      $tg_taxonomy = TagGroups_Taxonomy::get_enabled_taxonomies();
      // note: removed restriction count( $tg_taxonomy ) <= 1 - rather let user figure out if the result works

      $taxonomy_intersect = array_intersect( $tg_taxonomy, get_object_taxonomies( $post_type ) );

      if ( count( $taxonomy_intersect ) && isset( $_GET['tg_filter_posts_value'] ) &&  $_GET['tg_filter_posts_value'] !== '' ) {

        if ( ! class_exists( 'TagGroups_Premium_Post' ) ) {
          // one tag group per tag

          $filter_terms = array( );

          $query->query_vars['tax_query'] = array(
            'relation' => 'OR'
          );

          $args = array(
            'taxonomy' => $taxonomy_intersect
          );

          $terms = get_terms( $args );

          if ( $terms ) {

            $selected_term_group = (int) $_GET['tg_filter_posts_value'];

            /**
            * Filtering for terms that are not assigned to group $selected_term_group
            * Add per taxonomy for future extensibility
            */
            foreach ( $terms as $term ) {

              if ( $term->term_group == $selected_term_group ) {

                $filter_terms[$term->taxonomy][] = $term->term_id;
              }

            }

            foreach ( $taxonomy_intersect as $taxonomy ) {

              /**
              * Add a dummy so that the taxonomy condition will not be ignored even if no applicable tags were found.
              */
              if ( ! isset( $filter_terms[$taxonomy] ) ) {
                $filter_terms[$taxonomy][] = 0;
              }

              $query->query_vars['tax_query'][] = array(
                'taxonomy'  => $taxonomy,
                'field'     => 'term_id',
                'terms'     => $filter_terms[$taxonomy],
                'compare'   => 'IN',
              );
            }

          }

        } else {
          // multiple tag groups per tag

          $query->query_vars['meta_query'] = $tag_group_posts->get_meta_query_group( (int) $_GET['tg_filter_posts_value'] );

        }

      }

      return $query;
    }


    /**
    * AJAX handler to get a feed
    */
    static function ajax_get_feed()
    {

      $response = new WP_Ajax_Response;

      if ( isset( $_REQUEST['url'] ) ) {

        $url = esc_url_raw( $_REQUEST['url'] );

      } else {

        $url = '';

      }

      if ( isset( $_REQUEST['amount'] ) ) {

        $amount = (int) $_REQUEST['amount'];

      } else {

        $amount = 5;

      }

      /**
      * Assuming that the posts URL is the $url minus the trailing /feed
      */
      $posts_url = preg_replace( '/(.+)feed\/?/i', '$1', $url );

      $rss = new TagGroups_Feed;

      $rss->debug( WP_DEBUG )->url( $url );

      $cache = $rss->cache_get();

      if ( empty( $cache ) ) {

        $cache = $rss->posts_url( $posts_url )->load()->parse()->render( $amount );

      }

      $response->add( array(
        'data' => 'success',
        'supplemental' => array(
          'output' => $cache,
        ),
      ));

      // Cannot use the method $response->send() because it includes die()
      header( 'Content-Type: text/xml; charset=' . get_option( 'blog_charset' ) );
      echo "<?xml version='1.0' encoding='" . get_option( 'blog_charset' ) . "' standalone='yes'?><wp_ajax>";
      foreach ( (array) $response->responses as $response_item ){
        echo $response_item;
      }
      echo '</wp_ajax>';


      // check if we received expired cache content
      if ( false !== $cache && $rss->expired ) {

        // load in background for next time
        $rss->posts_url( $posts_url )->load()->parse()->render( $amount );

        if ( WP_DEBUG ) {

          error_log('[Tag Groups] Preloaded feed into cache.');

        }

      }

      if ( wp_doing_ajax() ) {

        wp_die();

      } else {

        die();

      }

    }


    /**
    * AJAX handler to manage Tag Groups
    */
    static function ajax_manage_groups()
    {

      global $tag_groups_premium_fs_sdk, $tag_group_groups;

      $response = new WP_Ajax_Response;

      if ( isset( $_REQUEST['task'] ) ) {

        $task = $_REQUEST['task'];

      } else {

        $task = 'refresh';

      }

      if ( isset( $_REQUEST['taxonomy'] ) ) {

        $taxonomy = $_REQUEST['taxonomy'];

      } else {

        $taxonomy = array( 'post_tag' );

      }

      $message = '';

      if ( $tag_groups_premium_fs_sdk->is_plan_or_trial('premium') ) {

        $tag_group_role_edit_groups = class_exists( 'TagGroups_Premium' ) ? get_option( 'tag_group_role_edit_groups', 'edit_pages' ) : 'edit_pages';

      } else {

        $tag_group_role_edit_groups = 'edit_pages';

      }

      if (
        $task == 'refresh' ||
        $task == 'test' ||
        ( current_user_can( $tag_group_role_edit_groups ) && wp_verify_nonce( $_REQUEST['nonce'], 'tg_groups_management' ) )
      ) {

        if ( isset( $_REQUEST['position'] ) ) {

          $position = (int) $_REQUEST['position'];

        } else {

          $position = 0;

        }

        if ( isset( $_REQUEST['new_position'] ) ) {

          $new_position = (int) $_REQUEST['new_position'];

        } else {

          $new_position = 0;

        }

        if ( isset( $_REQUEST['start_position'] ) ) {

          $start_position = (int) $_REQUEST['start_position'];

        }

        if ( empty( $start_position ) || $start_position < 1 ) {

          $start_position = 1;

        }

        if ( isset( $_REQUEST['end_position'] ) ) {

          $end_position = (int) $_REQUEST['end_position'];

        }

        if ( empty( $end_position ) || $end_position < 1 ) {

          $end_position = 1;

        }

        $tg_group = new TagGroups_Group();

        switch ( $task ) {

          case "sortup":

          $tag_group_groups->sort('up')->save();

          $message = __( 'The groups have been sorted alphabetically.', 'tag-groups' );

          break;

          case "sortdown":

          $tag_group_groups->sort('down')->save();

          $message = __( 'The groups have been sorted alphabetically.', 'tag-groups' );

          break;

          case "new":

          if ( isset( $_REQUEST['label'] ) ) {

            $label = stripslashes( sanitize_text_field( $_REQUEST['label'] ) );

          }

          if ( empty( $label ) ) {

            $message = __( 'The label cannot be empty.', 'tag-groups' );
            TagGroups_Admin::send_error( $response, $message, $task );

          } elseif ( $tg_group->find_by_label( $label ) ) {

            $message = sprintf( __( 'A tag group with the label \'%s\' already exists, or the label has not changed. Please choose another one or go back.', 'tag-groups' ), $label );
            TagGroups_Admin::send_error( $response, $message, $task );

          } else {

            $tg_group->create( $position + 1, $label )->save();

            $message = sprintf( __( 'A new tag group with the label \'%s\' has been created!', 'tag-groups' ), $label );

          }
          break;

          case "update":
          if ( isset( $_REQUEST['label'] ) ) {

            $label = stripslashes( sanitize_text_field( $_REQUEST['label'] ) );

          }

          if ( empty( $label ) ) {

            $message = __( 'The label cannot be empty.', 'tag-groups' );
            TagGroups_Admin::send_error( $response, $message, $task );

          } elseif ( $tg_group->find_by_label( $label ) ) {

            if ( ! empty( $position ) && $position == $tg_group->get_position() ) {
              // Label hast not changed, just ignore

            } else {

              $message = sprintf( __( 'A tag group with the label \'%s\' already exists.', 'tag-groups' ), $label );
              TagGroups_Admin::send_error( $response, $message, $task );

            }
          } else {

            if ( ! empty( $position ) ) {

              if ( $tg_group->find_by_position( $position ) ) {

                $tg_group->set_label( $label )->save();

              }

            } else {

              TagGroups_Admin::send_error( $response, 'error: invalid position: ' . $position, $task );

            }

            $message = sprintf( __( 'The tag group with the label \'%s\' has been saved!', 'tag-groups' ), $label );

          }

          break;

          case "delete":
          if ( ! empty( $position ) && $tg_group->find_by_position( $position ) ) {

            $message = sprintf( __( 'A tag group with the id %1$s and the label \'%2$s\' has been deleted.', 'tag-groups' ), $tg_group->get_group_id(), $tg_group->get_label() );

            $tg_group->delete();

          } else {

            TagGroups_Admin::send_error( $response, 'error: invalid position: ' . $position, $task );

          }

          break;

          case "up":
          if ( $position > 1 && $tg_group->find_by_position( $position ) ) {

            if ( $tg_group->move_to_position( $position - 1 ) !== false ) {

              $tg_group->save();

            }

          }
          break;

          case "down":
          if ( $position < $tag_group_groups->get_max_position() && $tg_group->find_by_position( $position ) ) {

            if ( $tg_group->move_to_position( $position + 1 ) !== false ) {

              $tg_group->save();

            }

          }
          break;

          case "move":

          if ( $new_position < 1 ) {

            $new_position = 1;

          }

          if ( $new_position > $tag_group_groups->get_max_position() ) {

            $new_position = $tag_group_groups->get_max_position();

          }

          if ( $position == $new_position ) {

            break;

          }

          if ( $tg_group->find_by_position( $position ) ) {

            if ( $tg_group->move_to_position( $new_position ) !== false ) {

              $tg_group->save();

            }

          }

          break;

          case "refresh":
          // do nothing here
          break;


          case 'test':

          $response->add( array(
            'data' => 'success',
            'supplemental' => array(
              'message' => 'This is the regular Ajax response.'
            )
          ) );

          $response->send();

          exit();

          break;

        }

        $number_of_term_groups = $tag_group_groups->get_number_of_term_groups() - 1; // "not assigned" won't be displayed

        if ( $start_position > $number_of_term_groups ) {

          $start_position = $number_of_term_groups;

        }

        $items_per_page = self::get_items_per_page();

        // calculate start and end positions
        $start_position = floor( ($start_position - 1) / $items_per_page ) * $items_per_page + 1;

        if ( $start_position + $items_per_page - 1 < $number_of_term_groups ) {

          $end_position = $start_position + $items_per_page - 1;

        } else {

          $end_position = $number_of_term_groups;

        }


        $response->add( array(
          'data' => 'success',
          'supplemental' => array(
            'task' => $task,
            'message' => $message,
            'nonce' => wp_create_nonce( 'tg_groups_management' ),
            'start_position' => $start_position,
            'groups' => json_encode( TagGroups_Admin::group_table(
              $start_position,
              $end_position,
              $taxonomy
            ) ),
            'max_number' => $number_of_term_groups
          ),
        ));

      } else {

        TagGroups_Admin::send_error( $response, 'Security check', $task );

      }

      $response->send();

      exit();

    }



    /**
    *  Rerturns an error message to AJAX
    */
    static function send_error( $response, $message = 'error', $task = 'unknown' )
    {
      $response->add( array(
        'data' => 'error',
        'supplemental' => array(
          'message' => $message,
          'task' => $task,
        )
      ) );
      $response->send();
      exit();

    }


    /**
    * Assemble the content of the table of tag groups for AJAX
    */
    static function group_table( $start_position, $end_position, $taxonomy )
    {

      global $tag_group_groups;

      $data = $tag_group_groups->get_all_with_position_as_key();

      $output = array();

      if ( count( $data ) > 1 ) {

        for ( $i = $start_position; $i <= $end_position; $i++ ) {

          if ( ! empty( $data[ $i ] ) ) {

            $tg_group = new TagGroups_Group( $data[ $i ]['term_group'] );

            array_push( $output, array(
              'id' => $data[ $i ]['term_group'],
              'label' => $data[ $i ]['label'],
              'amount' => $tg_group->get_number_of_terms( $taxonomy )
            ) );
          }

        }

      }

      return $output;

    }


    /**
    * Outputs a table on a submenu page where you can add, delete, change tag groups, their labels and their order.
    *
    * @param void
    * @return void
    */
    static function group_administration()
    {

      $tag_group_show_filter_tags = get_option( 'tag_group_show_filter_tags', 1 ); //tags

      $tag_group_show_filter = get_option( 'tag_group_show_filter', 1 ); // posts


      if ( $tag_group_show_filter_tags || $tag_group_show_filter ) {

        $this_post_type = preg_replace( '/tag-groups_(.+)/', '$1', sanitize_title( $_GET['page'] ) );

      }

      $first_enabled_taxonomy = '';

      /**
      * Check if the tag filter is activated
      */
      if ( $tag_group_show_filter_tags ) {

        // get first of taxonomies that are associated with that $post_type
        // $tg_taxonomies = get_option( 'tag_group_taxonomy', array('post_tag') );
        $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

        $taxonomy_names = get_object_taxonomies( $this_post_type );

        $taxonomies = array_intersect( $enabled_taxonomies, $taxonomy_names );



        /**
        * Show the link to the taxonomy filter only if there is only one taxonomy for this post type (otherwise ambiguous where to link)
        */
        if ( ! empty( $taxonomies ) && count( $taxonomies ) == 1 ) {

          $first_enabled_taxonomy = reset( $taxonomies );

        }

      }

      /**
      * In case we use the WPML plugin: consider the language
      */
      if ( defined( 'ICL_LANGUAGE_CODE' ) ) {

        if ( 'all' == ICL_LANGUAGE_CODE ) {

          $wpml_piece = '&lang=' . (string) apply_filters( 'wpml_default_language', NULL );

        } else {

          $wpml_piece = '&lang=' . (string) ICL_LANGUAGE_CODE;

        }

      } else {

        $wpml_piece = '';

      }


      $items_per_page = self::get_items_per_page();

      $protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';

      $post_url = empty( $tag_group_show_filter ) ? '' : admin_url( 'edit.php?post_type=' . $this_post_type . $wpml_piece, $protocol );

      $tags_url = empty( $first_enabled_taxonomy ) ? '' : admin_url( 'edit-tags.php?taxonomy=' . $first_enabled_taxonomy . $wpml_piece, $protocol );

      $settings_url = admin_url( 'admin.php?page=tag-groups-settings' );

      $admin_url = admin_url( 'admin-ajax.php', $protocol );


      if ( isset( $_GET['lang'] ) ) {

        $admin_url = add_query_arg( 'lang', sanitize_key( $_GET['lang'] ), $admin_url );

      }

      if ( defined( 'ICL_LANGUAGE_CODE' ) && ICL_LANGUAGE_CODE == 'all' ) {

        $view = new TagGroups_View( 'partials/language_notice' );

        $view->render();

      }

      $view = new TagGroups_View( 'admin/tag_groups_admin' );

      $view->set( array(
        'tag_group_show_filter' => $tag_group_show_filter,
        'post_url'              => $post_url,
        'tags_url'              => $tags_url,
        'items_per_page'        => $items_per_page,
        'enabled_taxonomies'    => $enabled_taxonomies,
        'settings_url'          => $settings_url,
        'admin_url'             => $admin_url
      ) );

      $view->render();

    }


    /**
    *
    * Modifies the query to retrieve tags for filtering in the backend.
    *
    * @param array $pieces
    * @param array $taxonomies
    * @param array $args
    * @return array
    */
    static function terms_clauses( $pieces, $taxonomies, $args )
    {

      global $tag_group_groups;

      $taxonomy = TagGroups_Base::get_first_element( $taxonomies );

      if ( empty( $taxonomy ) || is_array( $taxonomy ) ) {

        $taxonomy = 'post_tag';

      }

      $show_filter_tags = get_option( 'tag_group_show_filter_tags', 1 );

      if ( $show_filter_tags ) {

        $tag_group_tags_filter = get_option( 'tag_group_tags_filter', array() );

        if ( isset( $tag_group_tags_filter[ $taxonomy ] ) ) {

          $group_id = $tag_group_tags_filter[ $taxonomy ];

        } else {

          $group_id = -1;

        }


        // check if group exists (could be deleted since last time the filter was set)
        if ( $group_id > $tag_group_groups->get_max_term_group() ) {

          $group_id = -1;

        }


        if ( $group_id > -1 ) {

          if ( ! class_exists('TagGroups_Premium_Group') ) {

            if ( ! empty( $pieces['where'] ) ) {

              $pieces['where'] .= sprintf( " AND t.term_group = %d ", $group_id );

            } else {

              $pieces['where'] = sprintf( "t.term_group = %d ", $group_id );

            }

          } else {

            $tg_group = new TagGroups_Premium_Group( $group_id );

            $mq_sql = $tg_group->terms_clauses();

            if ( ! empty( $pieces['join'] ) ) {

              $pieces['join'] .= $mq_sql['join'];

            } else {

              $pieces['join'] = $mq_sql['join'];

            }

            if ( ! empty( $pieces['where'] ) ) {

              $pieces['where'] .= $mq_sql['where'];

            } else {

              $pieces['where'] = $mq_sql['where'];

            }

          }
        }
      }

      return $pieces;

    }


    /**
    * Adds css to backend
    */
    static function add_admin_js_css( $where )
    {

      if ( strpos( $where, 'tag-groups-settings' ) !== false ) {

        wp_enqueue_script( 'jquery' );

        wp_enqueue_script( 'jquery-ui-core' );

        wp_enqueue_script( 'jquery-ui-accordion' );

        wp_register_style( 'tag-groups-css-backend-tgb', TAG_GROUPS_PLUGIN_URL .  '/assets/css/backend.css', array(), TAG_GROUPS_VERSION );

        wp_enqueue_style( 'tag-groups-css-backend-tgb' );

        wp_register_style( 'tag-groups-css-backend-structure', TAG_GROUPS_PLUGIN_URL . '/assets/css/jquery-ui.structure.min.css', array(), TAG_GROUPS_VERSION );

        wp_enqueue_style( 'tag-groups-css-backend-structure' );

        wp_register_script( 'sumoselect-js', TAG_GROUPS_PLUGIN_URL . '/assets/js/jquery.sumoselect.min.js', array(), TAG_GROUPS_VERSION );

        wp_enqueue_script( 'sumoselect-js' );

        wp_register_style( 'sumoselect-css', TAG_GROUPS_PLUGIN_URL .  '/assets/css/sumoselect.css', array(), TAG_GROUPS_VERSION );

        wp_enqueue_style( 'sumoselect-css' );


      } elseif ( strpos( $where, '_page_tag-groups' ) !== false ) {

        wp_register_style( 'tag-groups-css-backend-tgb', TAG_GROUPS_PLUGIN_URL .  '/assets/css/backend.css', array(), TAG_GROUPS_VERSION );

        wp_enqueue_style( 'tag-groups-css-backend-tgb' );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

          wp_register_script( 'tag-groups-js-backend', TAG_GROUPS_PLUGIN_URL . '/assets/js/taggroups.js', array(), TAG_GROUPS_VERSION );

        } else {

          wp_register_script( 'tag-groups-js-backend', TAG_GROUPS_PLUGIN_URL . '/assets/js/taggroups.min.js', array(), TAG_GROUPS_VERSION );

        }

        wp_enqueue_script( 'tag-groups-js-backend' );

        wp_enqueue_script( 'jquery-ui-sortable' );

        wp_enqueue_script( 'jquery-ui-core' );

        wp_enqueue_script( 'jquery-ui-accordion' );

      } elseif ( strpos( $where, 'edit-tags.php' ) !== false || strpos( $where, 'term.php' ) !== false  || strpos( $where, 'edit.php' ) !== false ) {

        wp_register_script( 'sumoselect-js', TAG_GROUPS_PLUGIN_URL . '/assets/js/jquery.sumoselect.min.js', array(), TAG_GROUPS_VERSION );

        wp_enqueue_script( 'sumoselect-js' );

        wp_register_style( 'sumoselect-css', TAG_GROUPS_PLUGIN_URL .  '/assets/css/sumoselect.css', array(), TAG_GROUPS_VERSION );

        wp_enqueue_style( 'sumoselect-css' );

        wp_register_style( 'tag-groups-css-backend-tgb', TAG_GROUPS_PLUGIN_URL .  '/assets/css/backend.css', array(), TAG_GROUPS_VERSION );

        wp_enqueue_style( 'tag-groups-css-backend-tgb' );

      } elseif ( strpos( $where, 'post-new.php' ) !== false || strpos( $where, 'post.php' ) !== false ) {

        wp_register_style( 'react-select-css', TAG_GROUPS_PLUGIN_URL .  '/assets/css/react-select.css', array(), TAG_GROUPS_VERSION );

        wp_enqueue_style( 'react-select-css' );

      }

    }


    /**
    * Adds Settings link to plugin list
    *
    * @param array $links
    * @return array
    */
    static function add_plugin_settings_link( $links )
    {

      global $tag_groups_premium_fs_sdk;

      $settings_link = '<a href="' . admin_url( 'admin.php?page=tag-groups-settings' ) . '">' . __( 'Settings', 'tag-groups' ) . '</a>';

      array_unshift( $links, $settings_link );


      if ( empty( $tag_groups_premium_fs_sdk ) ) {

        $settings_link = '<a href="https://chattymango.com/tag-groups-premium/?pk_campaign=tg&pk_kwd=settings_link" target="_blank"><span style="color:#3A0;">' . __( 'Upgrade to Premium', 'tag-groups' ) . '</span></a>';

        array_unshift( $links, $settings_link );

      }

      return $links;

    }


    /**
    * Returns the items per page on the tag groups screen
    *
    *
    * @param void
    * @return int
    */
    public static function get_items_per_page()
    {

      if ( class_exists( 'TagGroups_Premium_Admin' ) && method_exists( 'TagGroups_Premium_Admin', 'add_screen_option' ) ) {

        $items_per_page_all_users = get_option( 'tag_groups_per_page', array() );

        $user = get_current_user_id();

        if ( isset( $items_per_page_all_users[ $user ] ) ) {

          $items_per_page = intval( $items_per_page_all_users[ $user ] );

        }


        if ( ! isset( $items_per_page_all_users[ $user ] ) || $items_per_page < 1 ) {

          $items_per_page = TAG_GROUPS_ITEMS_PER_PAGE;

        }

      } else {

        $items_per_page = TAG_GROUPS_ITEMS_PER_PAGE;

      }

      return $items_per_page;

    }


    /**
    * Add a warning if the WPML/Polylang language switch is set to "all"
    *
    *
    * @param void
    * @return void
    */
    public static function add_language_notice()
    {

      $screen = get_current_screen();

      if ( ! $screen || ( 'edit-tags' !== $screen->base && 'term' !== $screen->base ) ) {

        return;

      }

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      if ( ! in_array( $screen->taxonomy, $enabled_taxonomies ) ) {

        return;

      }

      if ( defined( 'ICL_LANGUAGE_CODE' ) && ICL_LANGUAGE_CODE == 'all' ) {

        $view = new TagGroups_View( 'partials/language_notice' );

        $view->render();

      }

    }

    /**
    * Add inline styling to the tags page
    *
    * @param void
    * @return void
    */
    public static function add_tag_page_styling()
    {

      $view = new TagGroups_View( 'admin/tag_page_inline_style' );

      $view->render();

    }

  } // class

}
