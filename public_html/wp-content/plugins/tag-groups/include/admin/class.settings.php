<?php
/**
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2018 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*/

if ( ! class_exists('TagGroups_Settings') ) {

  /**
  *
  */
  class TagGroups_Settings {


    function __construct() {

    }

    /**
    * renders the top of all setting pages
    *
    * @param void
    * @return void
    */
    public static function add_header()
    {

      $view = new TagGroups_View( 'admin/settings_header' );

      $view->set( 'admin_page_title', get_admin_page_title() );

      $view->render();

    }


    /**
    * renders the bottom of all settings pages
    *
    * @param void
    * @return void
    */
    public static function add_footer()
    {

      $view = new TagGroups_View( 'admin/settings_footer' );

      $view->render();

    }


    /**
    * gets the slug of the currently selected tab
    *
    * @param string $default
    * @return string
    */
    public static function get_active_tab( $tabs )
    {

      if ( isset( $_GET['active-tab'] ) ) {

        return sanitize_title( $_GET['active-tab'] );

      } else {

        $keys = array_keys( $tabs );

        return reset( $keys );

      }

    }


    /**
    * gets the HTML of the header of tabbed view
    *
    * @param string $default
    * @return string
    */
    public static function add_tabs( $page, $tabs, $active_tab )
    {

      if ( count( $tabs ) < 2 ) {

        return empty( $label ) ? '' : '<h2>' . $label . '</h2>';

      }

      $view = new TagGroups_View( 'admin/settings_tabs' );

      $view->set( array(
        'tabs'        => $tabs,
        'page'        => $page,
        'active_tab'  => $active_tab
      ) );

      $view->render();

    }


    /**
    * renders a settings page: home
    *
    * @param void
    * @return void
    */
    public static function settings_page_home()
    {

      global $tag_group_groups;

      // Make very sure that only administrators can access this page
      if ( ! current_user_can( 'manage_options' ) ) {

        die( "Capability check failed" );

      }

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      self::add_header();

      $html = '';

      $tg_group = new TagGroups_Group;

      $group_count = $tag_group_groups->get_number_of_term_groups();

      $tag_group_base_first_activation_time = get_option( 'tag_group_base_first_activation_time', 0 );

      $tag_group_premium_first_activation_time = get_option( 'tag_group_base_first_activation_time', 0 );

      $absolute_first_activation_time = ( $tag_group_base_first_activation_time < $tag_group_premium_first_activation_time ) ? $tag_group_base_first_activation_time : $tag_group_premium_first_activation_time;

      self::add_settings_help();

      $alerts = array();

      if ( defined( 'ICL_LANGUAGE_CODE' ) && ICL_LANGUAGE_CODE == 'all' ) {

        $view = new TagGroups_View( 'partials/language_notice' );

        $view->render();

      }

      if ( time() - $absolute_first_activation_time < 60*60*24*7 || $group_count < 2 ) {

        $alerts[] = sprintf( __( 'See the <a %s>First Steps</a> for some basic instructions on how to get started.', 'tag-groups' ), 'href="' . menu_page_url( 'tag-groups-settings-first-steps', false ) . '"' );

      }

      if ( function_exists( 'pll_get_post_language' ) ) {

        $alerts[] = __( 'We detected Polylang. Your tag group names are translatable.', 'tag-groups' );

      } elseif ( defined( 'ICL_LANGUAGE_CODE' ) ) {

        $alerts[] = __( 'We detected WPML. Your tag group names are translatable.', 'tag-groups' );

      }

      $alerts = apply_filters( 'tag_groups_settings_alerts', $alerts );

      if ( ! empty( $alerts ) ) {

        $view = new TagGroups_View( 'admin/settings_alerts' );

        $view->set( 'alerts', $alerts );

        $view->render();

      }

      $taxonomy_infos = array();

      foreach ( $enabled_taxonomies as $taxonomy ) {

        /**
        * We try to avoid excessive loading times on this page
        */
        $term_count = get_terms( array(
          'hide_empty'  => false,
          'taxonomy'  => $taxonomy,
          'fields' => 'count'
        ) );

        if ( is_object( $term_count ) ) {

          continue;

        }

        $taxonomy_infos[] = array(
          'slug'              => $taxonomy,
          'tag_group_admin'   => TagGroups_Taxonomy::get_tag_group_admin_url( $taxonomy ),
          'name'              => TagGroups_Taxonomy::get_name_from_slug( $taxonomy ),
          'info_html'         => TagGroups_Shortcode_Info::tag_groups_info( array( 'taxonomy' => $taxonomy, 'group_id' => 'all', 'html_class' => 'widefat fixed striped' ) ),
          'term_count'        => $term_count
        );

      }

      $view = new TagGroups_View( 'admin/settings_home' );

      $view->set( array(
        'group_count'   => $group_count,
        'taxonomy_infos' => $taxonomy_infos
      ) );

      $view->render();

      self::add_footer();

    }


    /**
    * renders a settings page: taxonomies
    *
    * @param void
    * @return void
    */
    public static function settings_page_taxonomies()
    {

      // Make very sure that only administrators can access this page
      if ( ! current_user_can( 'manage_options' ) ) {

        die( "Capability check failed" );

      }

      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      $public_taxonomies = TagGroups_Taxonomy::get_public_taxonomies();

      self::add_header();

      $html = '';

      self::add_settings_help();

      $tabs = array();

      $tabs['taxonomies'] = '';

      $tabs = apply_filters( 'tag_groups_settings_taxonomies_tabs', $tabs );

      $active_tab = self::get_active_tab( $tabs );

      self::add_tabs( 'tag-groups-settings-taxonomies', $tabs, $active_tab );

      switch ( $active_tab ) {

        case 'taxonomies':

        $view = new TagGroups_View( 'admin/settings_taxonomies' );

        $view->set( array(
          'public_taxonomies'   => $public_taxonomies,
          'enabled_taxonomies'  => $enabled_taxonomies,
        ) );

        $view->render();

        break;

        default:

        if ( class_exists( 'TagGroups_Premium_Settings' ) ) {

          TagGroups_Premium_Settings::get_content( $active_tab );

        }

        break;

      }

      self::add_footer();

    }


    /**
    * renders a settings page: back end
    *
    * @param void
    * @return void
    */
    public static function settings_page_back_end()
    {

      // Make very sure that only administrators can access this page
      if ( ! current_user_can( 'manage_options' ) ) {

        die( "Capability check failed" );

      }

      $show_filter_posts = get_option( 'tag_group_show_filter', 1 );

      $show_filter_tags = get_option( 'tag_group_show_filter_tags', 1 );


      self::add_header();

      self::add_settings_help();

      $tabs = array();

      $tabs['filters'] = __( 'Filters', 'tag-groups' );

      $tabs = apply_filters( 'tag_groups_settings_back_end_tabs', $tabs );

      $active_tab = self::get_active_tab( $tabs );

      self::add_tabs( 'tag-groups-settings-back-end', $tabs, $active_tab );


      switch ( $active_tab ) {

        case 'filters':

        $view = new TagGroups_View( 'admin/settings_back_end_filters' );

        $view->set( array(
          'show_filter_posts' => $show_filter_posts,
          'show_filter_tags'  => $show_filter_tags
        ) );

        $view->render();

        break; // filters

        default:

        if ( class_exists( 'TagGroups_Premium_Settings' ) ) {

          TagGroups_Premium_Settings::get_content( $active_tab );

        }

        break;

      }


      self::add_footer();

    }


    /**
    * renders a settings page: front end
    *
    * @param void
    * @return void
    */
    public static function settings_page_front_end()
    {

      // Make very sure that only administrators can access this page
      if ( ! current_user_can( 'manage_options' ) ) {

        die( "Capability check failed" );

      }

      $default_themes = explode( ',', TAG_GROUPS_BUILT_IN_THEMES );

      $tag_group_theme = get_option( 'tag_group_theme', TAG_GROUPS_STANDARD_THEME );

      $tag_group_mouseover = get_option( 'tag_group_mouseover', '' );

      $tag_group_collapsible = get_option( 'tag_group_collapsible', '' );

      $tag_group_enqueue_jquery = get_option( 'tag_group_enqueue_jquery', 1 );

      $tag_group_html_description = get_option( 'tag_group_html_description', 0 );

      $tag_group_shortcode_widget = get_option( 'tag_group_shortcode_widget' );

      $tag_group_shortcode_enqueue_always = get_option( 'tag_group_shortcode_enqueue_always', 1 );

      self::add_header();

      self::add_settings_help();

      $tabs = array();

      $tabs['shortcodes'] = __( 'Shortcodes', 'tag-groups' );

      $tabs['themes'] = __( 'Themes and Appearance', 'tag-groups' );

      $tabs = apply_filters( 'tag_groups_settings_front_end_tabs', $tabs );

      $active_tab = self::get_active_tab( $tabs );

      self::add_tabs( 'tag-groups-settings-front-end', $tabs, $active_tab );

      switch ( $active_tab ) {

        case 'shortcodes':

        /**
        * Let the premium plugin add own shortcode information.
        */
        $premium_shortcode_info = apply_filters( 'tag_groups_hook_shortcodes', '' );

        $view = new TagGroups_View( 'admin/settings_front_end_shortcodes' );

        $view->set( array(
          'premium_shortcode_info'              => $premium_shortcode_info,
          'tag_group_shortcode_enqueue_always'  => $tag_group_shortcode_enqueue_always,
          'tag_group_shortcode_widget'          => $tag_group_shortcode_widget,
        ) );

        $view->render();

        break;

        case 'themes':

        $view = new TagGroups_View( 'admin/settings_front_end_themes' );

        $view->set( array(
          'default_themes'              => $default_themes,
          'tag_group_theme'             => $tag_group_theme,
          'tag_group_enqueue_jquery'    => $tag_group_enqueue_jquery,
          'tag_group_mouseover'         => $tag_group_mouseover,
          'tag_group_collapsible'       => $tag_group_collapsible,
          'tag_group_html_description'  => $tag_group_html_description,
        ) );

        $view->render();

        break;

        default:

        if ( class_exists( 'TagGroups_Premium_Settings' ) ) {

          TagGroups_Premium_Settings::get_content( $active_tab );

        }

        break;

      }

      self::add_footer();

    }


    /**
    * renders a settings page: tools
    *
    * @param void
    * @return void
    */
    public static function settings_page_tools()
    {

      // Make very sure that only administrators can access this page
      if ( ! current_user_can( 'manage_options' ) ) {

        die( "Capability check failed" );

      }

      $tag_group_reset_when_uninstall = get_option( 'tag_group_reset_when_uninstall', 0 );

      self::add_header();

      self::add_settings_help();

      $tabs = array();

      $tabs['export_import'] = __( 'Export/Import', 'tag-groups' );

      $tabs['reset'] = __( 'Reset', 'tag-groups' );

      $tabs = apply_filters( 'tag_groups_settings_tools_tabs', $tabs );

      $active_tab = self::get_active_tab( $tabs );

      self::add_tabs( 'tag-groups-settings-tools', $tabs, $active_tab );


      switch ( $active_tab ) {

        case 'export_import':

        $view = new TagGroups_View( 'admin/settings_tools_export_import' );

        $view->render();

        break;

        case 'reset':

        $view = new TagGroups_View( 'admin/settings_tools_reset' );

        $view->set( 'tag_group_reset_when_uninstall', $tag_group_reset_when_uninstall );

        $view->render();

        break;

        default:

        if ( class_exists( 'TagGroups_Premium_Settings' ) ) {

          TagGroups_Premium_Settings::get_content( $active_tab );

        }

        break;

      }

      self::add_footer();

    }


    /**
    * renders a settings page: troubleshooting
    *
    * @param void
    * @return void
    */
    public static function settings_page_troubleshooting()
    {

      // Make very sure that only administrators can access this page
      if ( ! current_user_can( 'manage_options' ) ) {

        die( "Capability check failed" );

      }

      self::add_header();

      self::add_settings_help();

      $tabs = array();

      $tabs['faq'] = __( 'FAQ and Common Issues', 'tag-groups' );

      $tabs['documentation'] = __( 'Documentation', 'tag-groups' );

      $tabs['support'] = __( 'Get Support', 'tag-groups' );

      $tabs['system'] = __( 'System Information', 'tag-groups' );

      $tabs = apply_filters( 'tag_groups_settings_troubleshooting_tabs', $tabs );

      $active_tab = self::get_active_tab( $tabs );

      self::add_tabs( 'tag-groups-settings-troubleshooting', $tabs, $active_tab );

      switch ( $active_tab ) {

        case 'faq':

        $view = new TagGroups_View( 'admin/settings_troubleshooting_faq' );

        $view->render();

        break;


        case 'documentation':

        $view = new TagGroups_View( 'admin/settings_troubleshooting_documentation' );

        $view->render();

        break;


        case 'support':

        $view = new TagGroups_View( 'admin/settings_troubleshooting_support' );

        $view->render();

        break;


        case 'system':

        $phpversion = phpversion();

        if ( version_compare( $phpversion, '7.0.0', '<' ) ) {

          $php_upgrade_recommendation = true;

        } else {

          $php_upgrade_recommendation = false;

        }

        $active_theme = wp_get_theme();

        $protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';

        $ajax_test_url = admin_url( 'admin-ajax.php', $protocol );


        /* constants */
        $wp_constants = array(
          'WP_DEBUG',
          'WP_DEBUG_DISPLAY',
          'WP_DEBUG_LOG',
          'ABSPATH',
          // 'WP_HOME',
          'MULTISITE',
          'WP_CACHE',
          'COMPRESS_SCRIPTS',
          // 'FS_CHMOD_DIR',
          // 'FS_CHMOD_FILE',
          'FORCE_SSL_ADMIN',
          'CM_UPDATE_CHECK',
          'WP_MEMORY_LIMIT',
          'WP_MAX_MEMORY_LIMIT'
        );

        sort( $wp_constants );


        $constants = get_defined_constants();

        foreach ( $constants as &$constant ) {

          if ( isset( $constant ) ) {

            $constant = self::echo_var( $constant );

          }

        }

        ksort( $constants );


        $view = new TagGroups_View( 'admin/settings_troubleshooting_system' );

        $view->set( array(
          'phpversion'                  => $phpversion,
          'php_upgrade_recommendation'  => $php_upgrade_recommendation,
          'wp_constants'                => $wp_constants,
          'constants'                   => $constants,
          'ajax_test_url'               => $ajax_test_url,
          'active_theme'                => $active_theme
        ) );

        $view->render();

        break;


        default:

        if ( class_exists( 'TagGroups_Premium_Settings' ) ) {

          TagGroups_Premium_Settings::get_content( $active_tab );

        }

        break;

      }

      self::add_footer();

    }


    /**
    * renders a settings page: premium
    *
    * @param void
    * @return void
    */
    public static function settings_page_premium()
    {

      global $tag_groups_premium_fs_sdk;

      // Make very sure that only administrators can access this page
      if ( ! current_user_can( 'manage_options' ) ) {

        die( "Capability check failed" );

      }

      self::add_header();

      $view = new TagGroups_View( 'admin/settings_premium' );

      $view->set( 'tag_groups_premium_fs_sdk', $tag_groups_premium_fs_sdk );

      $view->render();

      self::add_footer();

    }


    /**
    * renders a settings page: about
    *
    * @param void
    * @return void
    */
    public static function settings_page_about()
    {

      // Make very sure that only administrators can access this page
      if ( ! current_user_can( 'manage_options' ) ) {

        die( "Capability check failed" );

      }

      self::add_header();

      self::add_settings_help();

      $tabs = array();

      $tabs['info'] = __( 'Info', 'tag-groups' );

      $tabs['licenses'] = __( 'Licenses', 'tag-groups' );

      $tabs['news'] = __( 'Development News', 'tag-groups' );

      $tabs = apply_filters( 'tag_groups_settings_about_tabs', $tabs );

      $active_tab = self::get_active_tab( $tabs );

      self::add_tabs( 'tag-groups-settings-about', $tabs, $active_tab );


      switch ( $active_tab ) {

        case 'info':

        $view = new TagGroups_View( 'admin/settings_about_info' );

        $view->render();

        break;

        case 'licenses':

        $view = new TagGroups_View( 'admin/settings_about_licenses' );

        $view->render();

        break;

        case 'news':

        $protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';

        $admin_url = admin_url( 'admin-ajax.php', $protocol );

        $view = new TagGroups_View( 'admin/settings_about_news' );

        $view->set( 'admin_url', $admin_url );

        $view->render();

        break;

        default:

        if ( class_exists( 'TagGroups_Premium_Settings' ) ) {

          TagGroups_Premium_Settings::get_content( $active_tab );

        }

        break;

      }


      self::add_footer();

    }


    /**
    * renders a menu-less settings page: onboarding
    *
    * @param void
    * @return void
    */
    public static function settings_page_onboarding()
    {

      // Make very sure that only administrators can access this page
      if ( ! current_user_can( 'manage_options' ) ) {

        return;

      }

      global $tag_groups_premium_fs_sdk;

      self::add_header();


      $settings_taxonomy_link = admin_url( 'admin.php?page=tag-groups-settings-taxonomies' );

      $settings_home_link = admin_url( 'admin.php?page=tag-groups-settings' );

      $settings_premium_link = admin_url( 'admin.php?page=tag-groups-settings-premium' );

      $settings_setup_wizard_link = admin_url( 'admin.php?page=tag-groups-settings-setup-wizard' );

      if ( defined('TAG_GROUPS_PLUGIN_IS_FREE') && TAG_GROUPS_PLUGIN_IS_FREE ) {

        $title = 'Tag Groups';

        $documentation_link = 'https://documentation.chattymango.com/documentation/tag-groups/';

        $logo = '<img src="' . TAG_GROUPS_PLUGIN_URL . '/assets/images/cm-tg-icon-64x64.png" alt="Tag Groups logo" class="tg_onboarding_logo"/>';

      } else {

        $title = 'Tag Groups Premium';

        $documentation_link = 'https://documentation.chattymango.com/documentation/tag-groups-premium/';

        $logo = '<img src="' . TAG_GROUPS_PLUGIN_URL . '/assets/images/cm-tgp-icon-64x64.png" alt="Tag Groups Premium logo" class="tg_onboarding_logo"/>';

      }

      $view = new TagGroups_View( 'admin/onboarding' );

      $view->set( array(
        'logo'                          => $logo,
        'title'                         => $title,
        'settings_taxonomy_link'        => $settings_taxonomy_link,
        'settings_home_link'            => $settings_home_link,
        'documentation_link'            => $documentation_link,
        'settings_premium_link'         => $settings_premium_link,
        'settings_setup_wizard_link'    => $settings_setup_wizard_link
      ) );

      $view->render();

      self::add_footer();

    }


    /**
    * renders a menu-less settings page: onboarding
    *
    * @param void
    * @return void
    */
    public static function settings_page_setup_wizard()
    {

      // Make very sure that only administrators can access this page
      if ( ! current_user_can( 'manage_options' ) ) {

        return;

      }

      global $tag_groups_premium_fs_sdk, $tag_group_groups;

      self::add_header();

      $step = isset( $_GET[ 'step' ] ) && $_GET[ 'step' ] > 0 ? (int) $_GET[ 'step' ] : 1;


      $setup_wizard_next_link = add_query_arg( 'step', $step + 1, admin_url( 'admin.php?page=tag-groups-settings-setup-wizard' ) );

      if ( defined('TAG_GROUPS_PLUGIN_IS_FREE') && TAG_GROUPS_PLUGIN_IS_FREE ) {

        $title = 'Tag Groups';

        $is_premium = false;

        $documentation_link = 'https://documentation.chattymango.com/documentation/tag-groups/';

      } else {

        $title = 'Tag Groups Premium';

        $is_premium = true;

        $documentation_link = 'https://documentation.chattymango.com/documentation/tag-groups-premium/';

      }


      if ( $is_premium && $tag_groups_premium_fs_sdk->is_plan_or_trial('premium') ) {

        $steps = array(
          1 => array(
            'id'    => 'start',
            'title' => 'Start'
          ),
          2 => array(
            'id'    => 'taxonomies',
            'title' => 'Taxonomies'
          ),
          3 => array(
            'id'    => 'meta_box',
            'title' => 'Meta Box'
          ),
          4 => array(
            'id'    => 'post_tags',
            'title' => 'Post Tags'
          ),
          5 => array(
            'id'    => 'sample_content',
            'title' => 'Sample Content'
          ),
          6 => array(
            'id'    => 'finished',
            'title' => null
          ),
        );

      } else {

        $steps = array(
          1 => array(
            'id'    => 'start',
            'title' => 'Start'
          ),
          2 => array(
            'id'    => 'taxonomies',
            'title' => 'Taxonomies'
          ),
          3 => array(
            'id'    => 'sample_content',
            'title' => 'Sample Content'
          ),
          4 => array(
            'id'    => 'finished',
            'title' => null
          ),
        );

      }



      $view = new TagGroups_View( 'admin/setup_wizard_header' );

      $view->set( array(
        'title'   => $title,
        'step'    => $step,
        'steps'   => $steps,
      ) );

      $view->render();



      switch ( $steps[ $step ]['id'] ) {

        case 'sample_content':

        $view = new TagGroups_View( 'admin/setup_wizard_sample_content' );

        $group_names = array(
          'Sample Group A',
          'Sample Group B',
          'Sample Group C'
        );

        /**
        * Make sure they don't yet exist
        */
        $group_names = array_map( function( $original_name ) {

          $tg_group = new TagGroups_Group();

          $name = $original_name;

          $i = 0;

          while ( $tg_group->find_by_label( $name ) !== false ) {

            $i++;

            $name = $original_name . ' - ' . $i;

          }

          return $name;

        }, $group_names );

        $tag_names = array(
          'First Sample Tag',
          'Second Sample Tag',
          'Third Sample Tag'
        );

        $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

        $taxonomy = array_shift( $enabled_taxonomies );

        /**
        * Make sure they don't yet exist
        */
        $tag_names = array_map( function( $original_name ) use ( $taxonomy ) {

          $name = $original_name;

          $i = 0;

          while ( get_term_by( 'name', $name, $taxonomy ) !== false ) {

            $i++;

            $name = $original_name . ' - ' . $i;

          }

          return $name;

        }, $tag_names );


        $view->set( array(
          'title'                   => $title,
          'group_names'             => $group_names,
          'tag_names'               => $tag_names,
          'setup_wizard_next_link'  => $setup_wizard_next_link
        ) );

        break;


        case 'post_tags':

        // $groups = $tag_group_groups->get_all_with_position_as_key();

        $tag_group_display_groups_under_posts = get_option( 'tag_group_display_groups_under_posts', $tag_group_groups->get_group_ids() );

        $tag_group_display_groups_under_posts_title = get_option( 'tag_group_display_groups_under_posts_title', __( 'Tags', 'tag-groups' ) );

        $tag_group_display_groups_under_posts_separator = get_option( 'tag_group_display_groups_under_posts_separator', '&nbsp;|&nbsp;' );

        $tag_group_display_groups_under_posts_single = get_option( 'tag_group_display_groups_under_posts_single', false );

        $tag_group_display_groups_under_posts_home = get_option( 'tag_group_display_groups_under_posts_home', false );

        $tag_group_display_groups_under_posts_archive = get_option( 'tag_group_display_groups_under_posts_archive', false );

        $tag_group_display_groups_under_posts_feed = get_option( 'tag_group_display_groups_under_posts_feed', false );

        $tag_group_display_groups_under_posts_priority = get_option( 'tag_group_display_groups_under_posts_priority', 10 );

        $tag_group_remove_the_post_terms = get_option( 'tag_group_remove_the_post_terms', false );


        $view = new TagGroups_Premium_View( 'admin/setup_wizard_post_tags' );


        $view->set( array(
          'title'                   => $title,
          // 'groups'                                            => $groups,
          'tag_group_display_groups_under_posts'              => $tag_group_display_groups_under_posts,
          'tag_group_display_groups_under_posts_title'        => $tag_group_display_groups_under_posts_title,
          'tag_group_display_groups_under_posts_separator'    => $tag_group_display_groups_under_posts_separator,
          'tag_group_display_groups_under_posts_single'       => $tag_group_display_groups_under_posts_single,
          'tag_group_display_groups_under_posts_home'         => $tag_group_display_groups_under_posts_home,
          'tag_group_display_groups_under_posts_archive'      => $tag_group_display_groups_under_posts_archive,
          'tag_group_display_groups_under_posts_feed'         => $tag_group_display_groups_under_posts_feed,
          'tag_group_display_groups_under_posts_priority'     => $tag_group_display_groups_under_posts_priority,
          'tag_group_remove_the_post_terms'                   => $tag_group_remove_the_post_terms,
          'setup_wizard_next_link'  => $setup_wizard_next_link
        ) );

        break;


        case 'meta_box':

        $tag_group_meta_box_change_group = get_option( 'tag_group_meta_box_change_group', 1 );

        $tag_group_meta_box_add_term = get_option( 'tag_group_meta_box_add_term', 1 );

        $tag_group_meta_box_open_all = get_option( 'tag_group_meta_box_open_all', 1 );

        $tag_group_hide_tagsdiv = get_option( 'tag_group_hide_tagsdiv', 1 );

        $tag_group_open_all_with_terms = get_option( 'tag_group_open_all_with_terms', 1 );

        $tag_group_meta_box_taxonomy = get_option( 'tag_group_meta_box_taxonomy', array() );

        $all_taxonomies = get_taxonomies( array( 'public' => true ), 'objects' );

        $non_hierarchical_taxonomies_names = array();

        foreach ( $all_taxonomies as $taxonomy ) {

          /**
          * We offer only non-hierarchical taxonomies
          */
          if ( ! empty( $taxonomy ) && is_object( $taxonomy ) && ! $taxonomy->hierarchical ) {

            $non_hierarchical_taxonomies_names[] = $taxonomy->name;

          }

        }

        $taxonomies = array_intersect( get_option( 'tag_group_taxonomy', array() ), $non_hierarchical_taxonomies_names );

        // No groups yet defined
        $tag_group_meta_box_include = get_option( 'tag_group_meta_box_include', $tag_group_groups->get_group_ids() );


        $view = new TagGroups_Premium_View( 'admin/setup_wizard_meta_box' );

        $view->set( array(
          'title'                   => $title,
          'taxonomies'                        => $taxonomies,
          'tag_group_meta_box_include'        => $tag_group_meta_box_include,
          'tag_group_meta_box_change_group'   => $tag_group_meta_box_change_group,
          'tag_group_meta_box_add_term'       => $tag_group_meta_box_add_term,
          'tag_group_meta_box_open_all'       => $tag_group_meta_box_open_all,
          'tag_group_hide_tagsdiv'            => $tag_group_hide_tagsdiv,
          'tag_group_open_all_with_terms'     => $tag_group_open_all_with_terms,
          'tag_group_meta_box_taxonomy'       => $tag_group_meta_box_taxonomy,
          'setup_wizard_next_link'  => $setup_wizard_next_link
        ) );

        break;


        case 'taxonomies':

        $view = new TagGroups_View( 'admin/setup_wizard_taxonomies' );

        $view->set( array(
          'title'                   => $title,
          'public_taxonomies'       => TagGroups_Taxonomy::get_public_taxonomies(),
          'enabled_taxonomies'      => TagGroups_Taxonomy::get_enabled_taxonomies(),
          'setup_wizard_next_link'  => $setup_wizard_next_link
        ) );

        break;


        case 'finished':

        $view = new TagGroups_View( 'admin/setup_wizard_finished' );

        $documentation_link = $is_premium ? 'https://documentation.chattymango.com/documentation/tag-groups-premium/?pk_campaign=tgp&pk_kwd=wizard' : 'https://documentation.chattymango.com/documentation/tag-groups/?pk_campaign=tg&pk_kwd=wizard';

        $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

        $taxonomy = array_shift( $enabled_taxonomies );

        $view->set( array(
          'groups_admin_link'         => TagGroups_Taxonomy::get_tag_group_admin_url( $taxonomy ),
          'documentation_link'        => $documentation_link,
          'settings_home_link'        => admin_url( 'admin.php?page=tag-groups-settings' ),
          'tag_group_sample_page_id'  => get_option( 'tag_group_sample_page_id', 0 )
        ) );

        break;


        case 'start':
        default:

        $view = new TagGroups_View( 'admin/setup_wizard_start' );

        $view->set( array(
          'title'                   => $title,
          'setup_wizard_next_link'  => $setup_wizard_next_link,
          'is_premium'              => $is_premium
        ) );

        break;

      }

      $view->render();


      $view = new TagGroups_View( 'admin/setup_wizard_footer' );

      $view->render();


      self::add_footer();

    }


    /**
    * Processes form submissions from the settings page
    *
    * @param void
    * @return void
    */
    static function settings_page_actions_wizard() {

      global $tag_group_groups, $tag_groups_premium_fs_sdk;


      if ( empty( $_REQUEST['tg_action_wizard'] ) ) {

        return;

      }

      // Make very sure that only administrators can do actions
      if ( ! current_user_can( 'manage_options' ) ) {

        die( "Capability check failed" );

      }

      if ( ! isset( $_POST['tag-groups-setup-wizard-nonce'] ) || ! wp_verify_nonce( $_POST['tag-groups-setup-wizard-nonce'], 'tag-groups-setup-wizard-nonce' ) ) {

        die( "Security check failed" );

      }


      $enabled_taxonomies = TagGroups_Taxonomy::get_enabled_taxonomies();

      $taxonomy = array_shift( $enabled_taxonomies );


      switch ( $_REQUEST['tg_action_wizard'] ) {

        case 'taxonomy':

        if ( isset( $_POST['taxonomies'] ) ) {

          $taxonomies = $_POST['taxonomies'];

          if ( is_array( $taxonomies ) ) {

            $taxonomies = array_map( 'sanitize_text_field', $taxonomies );

            $taxonomies = array_map( 'stripslashes', $taxonomies );

          } else {

            $taxonomies = array( 'post_tag' );

          }

        } else {

          $taxonomies = array( 'post_tag' );

        }

        $public_taxonomies = TagGroups_Taxonomy::get_public_taxonomies();

        foreach ( $taxonomies as $taxonomy_item ) {

          if ( ! in_array( $taxonomy_item, $public_taxonomies ) ) {

            return;

          }

        }

        update_option( 'tag_group_taxonomy', $taxonomies );

        // trigger actions
        do_action( 'taxonomies_saved', $taxonomies );

        if ( class_exists( 'TagGroups_Premium_Post' ) && ( ! defined( 'TAG_GROUPS_DISABLE_CACHE_REBUILD' ) || TAG_GROUPS_DISABLE_CACHE_REBUILD ) ) {

          // schedule rebuild of cache
          wp_schedule_single_event( time() + 10, 'tag_groups_rebuild_post_terms' );

        }

        break;


        case 'meta-box':

        if ( isset( $_POST['taxonomies'] ) ) {

          $selected_taxonomies = $_POST['taxonomies'];

        } else {

          $selected_taxonomies = array();

        }

        $taxonomies = TagGroups_Taxonomy::get_public_taxonomies();

        foreach ( $selected_taxonomies as $taxonomy_item ) {

          $taxonomy_item = stripslashes( sanitize_text_field( $taxonomy_item ) );

          if ( ! in_array( $taxonomy_item, $taxonomies ) ) {

            die( "Security check: taxonomies" );

          }

        }
        update_option( 'tag_group_meta_box_taxonomy', $selected_taxonomies );


        if ( isset( $_POST['tag_group_meta_box_include'] ) ) {

          $tag_group_meta_box_include = array_map( 'intval', array_values( $_POST['tag_group_meta_box_include'] ) );

        } else {

          // We don't allow here to select none
          $tag_groups = $tag_group_groups->get_all_with_position_as_key();

          $tag_group_ids = array_keys( $tag_groups );

          $tag_group_meta_box_include = $tag_group_ids;

          update_option( 'tag_group_meta_box_include', $tag_group_ids );


          if ( isset( $_POST['tag_group_meta_box_open_all'] ) ) {

            $tag_group_meta_box_open_all = $_POST['tag_group_meta_box_open_all'] ? 1 : 0;

          } else {

            $tag_group_meta_box_open_all = 0;

          }
          update_option( 'tag_group_meta_box_open_all', $tag_group_meta_box_open_all );


          if ( isset( $_POST['tag_group_meta_box_add_term'] ) ) {

            $tag_group_meta_box_add_term = $_POST['tag_group_meta_box_add_term'] ? 1 : 0;

          } else {

            $tag_group_meta_box_add_term = 0;

          }
          update_option( 'tag_group_meta_box_add_term', $tag_group_meta_box_add_term );


          if ( isset( $_POST['tag_group_hide_tagsdiv'] ) ) {

            $tag_group_hide_tagsdiv = $_POST['tag_group_hide_tagsdiv'] ? 1 : 0;

          } else {

            $tag_group_hide_tagsdiv = 1;

          }
          update_option( 'tag_group_hide_tagsdiv', $tag_group_hide_tagsdiv );


          if ( isset( $_POST['tag_group_meta_box_change_group'] ) ) {

            $tag_group_meta_box_change_group = $_POST['tag_group_meta_box_change_group'] ? 1 : 0;

          } else {

            $tag_group_meta_box_change_group = 0;

          }
          update_option( 'tag_group_meta_box_change_group', $tag_group_meta_box_change_group );

          if ( isset( $_POST['tag_group_open_all_with_terms'] ) ) {

            $tag_group_open_all_with_terms = $_POST['tag_group_open_all_with_terms'] ? 1 : 0;

          } else {

            $tag_group_open_all_with_terms = 0;

          }
          $return = update_option( 'tag_group_open_all_with_terms', $tag_group_open_all_with_terms );


          TagGroups_Admin_Notice::add( 'success', __( 'Your settings have been saved.', 'tag-groups' ) );

        }

        do_action( 'tag_groups_metabox_saved' );

        break;


        case 'post-tags':

        if ( isset( $_POST['tag_group_display_groups_under_posts_title'] ) ) {

          $tag_group_display_groups_under_posts_title = sanitize_text_field( $_POST['tag_group_display_groups_under_posts_title'] ) ;

        } else {

          $tag_group_display_groups_under_posts_title = __( 'Tags', 'tag-groups' );

        }

        update_option( 'tag_group_display_groups_under_posts_title', $tag_group_display_groups_under_posts_title );


        if ( isset( $_POST['tag_group_display_groups_under_posts_priority'] ) ) {

          $tag_group_display_groups_under_posts_priority = intval( $_POST['tag_group_display_groups_under_posts_priority'] ) ;

        } else {

          $tag_group_display_groups_under_posts_priority = 10;

        }

        update_option( 'tag_group_display_groups_under_posts_priority', $tag_group_display_groups_under_posts_priority );


        if ( isset( $_POST['tag_group_display_groups_under_posts_separator'] ) ) {

          // preserving space
          $tag_group_display_groups_under_posts_separator = wp_kses( $_POST['tag_group_display_groups_under_posts_separator'], array() ) ; // sanitize_textarea_field() trims spaces

        } else {

          $tag_group_display_groups_under_posts_separator = '&nbsp;|&nbsp;';

        }

        update_option( 'tag_group_display_groups_under_posts_separator', $tag_group_display_groups_under_posts_separator );


        if ( isset( $_POST['tag_group_display_groups_under_posts_single'] ) ) {

          $tag_group_display_groups_under_posts_single = intval( $_POST['tag_group_display_groups_under_posts_single'] );

        } else {

          $tag_group_display_groups_under_posts_single = array();

        }
        update_option( 'tag_group_display_groups_under_posts_single', $tag_group_display_groups_under_posts_single );


        if ( isset( $_POST['tag_group_display_groups_under_posts_home'] ) ) {

          $tag_group_display_groups_under_posts_home = intval( $_POST['tag_group_display_groups_under_posts_home'] );

        } else {

          $tag_group_display_groups_under_posts_home = array();

        }
        update_option( 'tag_group_display_groups_under_posts_home', $tag_group_display_groups_under_posts_home );


        if ( isset( $_POST['tag_group_display_groups_under_posts_archive'] ) ) {

          $tag_group_display_groups_under_posts_archive = intval( $_POST['tag_group_display_groups_under_posts_archive'] );

        } else {

          $tag_group_display_groups_under_posts_archive = array();

        }
        update_option( 'tag_group_display_groups_under_posts_archive', $tag_group_display_groups_under_posts_archive );


        if ( isset( $_POST['tag_group_display_groups_under_posts_feed'] ) ) {

          $tag_group_display_groups_under_posts_feed = intval( $_POST['tag_group_display_groups_under_posts_feed'] );

        } else {

          $tag_group_display_groups_under_posts_feed = array();

        }
        update_option( 'tag_group_display_groups_under_posts_feed', $tag_group_display_groups_under_posts_feed );


        if ( isset( $_POST['tag_group_remove_the_post_terms'] ) ) {

          $tag_group_remove_the_post_terms = intval( $_POST['tag_group_remove_the_post_terms'] );

        } else {

          $tag_group_remove_the_post_terms = array();

        }
        update_option( 'tag_group_remove_the_post_terms', $tag_group_remove_the_post_terms );



        if ( isset( $_POST['tag_group_display_groups_under_posts'] ) ) {

          $tag_group_display_groups_under_posts = array_map( 'intval', array_values( $_POST['tag_group_display_groups_under_posts'] ) );

        } else {

          $tag_group_display_groups_under_posts = array();

        }

        // Evaluate "empty" as "all" if any of the page types was selected
        if ( count( $tag_group_display_groups_under_posts ) == 0 &&
        ( $tag_group_display_groups_under_posts_single || $tag_group_display_groups_under_posts_home || $tag_group_display_groups_under_posts_archive || $tag_group_display_groups_under_posts_feed ) ) {

          $tag_group_display_groups_under_posts = $tag_group_groups->get_group_ids();

        }

        update_option( 'tag_group_display_groups_under_posts', $tag_group_display_groups_under_posts );


        do_action( 'tag_groups_post_tags_saved' );

        break;


        case 'sample-content':

        $created_groups = array();

        /**
        * Create groups
        */
        if ( isset( $_POST['tag-groups-create-sample-groups'] ) && $_POST['tag-groups-create-sample-groups'] ) {

          foreach ( $_POST['tag_groups_group_names'] as $group_name ) {

            $tg_group = new TagGroups_Group();

            $tg_group->create( null, sanitize_text_field( $group_name ) );

            $created_groups[] = $tg_group->get_group_id();

          }

        }

        /**
        * Create tags
        */
        if ( isset( $_POST['tag-groups-create-sample-tags'] ) && $_POST['tag-groups-create-sample-tags'] ) {

          foreach ( $_POST['tag_groups_tag_names'] as $tag_name ) {

            $tag_name = sanitize_text_field( $tag_name );

            if ( ! term_exists( $tag_name, $taxonomy ) ) {

              $term_array = wp_insert_term( $tag_name, $taxonomy );


              $tg_term = new TagGroups_Term( $term_array['term_id'] );

              if ( empty( $created_groups ) ) {

                $group_ids = $tag_group_groups->get_group_ids();

                unset( $group_ids[0] );

              } else {

                $group_ids = $created_groups;

              }

              if ( $tag_groups_premium_fs_sdk->can_use_premium_code() ) {

                $amount = mt_rand( 2, count( $group_ids ) );

              }  else {
                // add one group

                $amount = 1;

              }

              if ( 1 == $amount ) {

                $random_group_ids = $group_ids[ array_rand( $group_ids ) ];

              } else {

                $random_group_ids = array_intersect_key( $group_ids, array_rand( $group_ids, $amount ) );

              }

              $tg_term->add_group( $random_group_ids )->save();

            }

          }

        }

        if ( isset( $_POST['tag-groups-create-sample-page'] ) && $_POST['tag-groups-create-sample-page'] ) {

          $view = new TagGroups_View( 'admin/sample_page' );

          if ( defined('TAG_GROUPS_PLUGIN_IS_FREE') && TAG_GROUPS_PLUGIN_IS_FREE ) {

            $view->set( 'premium_shortcodes', false );

          } else {

            $view->set( 'premium_shortcodes', true );

          }

          $current_user = wp_get_current_user();

          $view->set( array(
            'enabled_taxonomies'          => $enabled_taxonomies,
            'author_display_name'         => $current_user->display_name,
            'tag_groups_premium_fs_sdk'   => $tag_groups_premium_fs_sdk
          ) );

          $content = $view->return_html();

          $post_data = array(
            'post_title'    => wp_strip_all_tags( 'Tag Groups Sample Page' ),
            'post_content'  => $content,
            'post_status'   => 'draft',
            'post_type'     => 'page',
            'post_author'   => get_current_user_id(),
          );

          $post_id = wp_insert_post( $post_data );

          update_option( 'tag_group_sample_page_id', $post_id );

        } else {

          delete_option( 'tag_group_sample_page_id' );

        }

        break;

      }

    }


    /**
    * Processes form submissions from the settings page
    *
    * @param void
    * @return void
    */
    static function settings_page_actions() {

      global $tag_group_groups;


      if ( ! empty( $_REQUEST['tg_action'] ) ) {

        $tg_action = $_REQUEST['tg_action'];

      } else {

        return;

      }

      // Make very sure that only administrators can do actions
      if ( ! current_user_can( 'manage_options' ) ) {

        die( "Capability check failed" );

      }

      if ( isset( $_GET['id'] ) ) {

        $tag_groups_id = (int) $_GET['id'];

      } else {

        $tag_groups_id = 0;

      }

      if ( isset( $_POST['ok'] ) ) {

        $ok = $_POST['ok'];

      } else {

        $ok = '';

      }


      switch ( $tg_action ) {

        case 'shortcode':

        if ( ! isset( $_POST['tag-groups-shortcode-nonce'] ) || ! wp_verify_nonce( $_POST['tag-groups-shortcode-nonce'], 'tag-groups-shortcode' ) ) {

          die( "Security check" );

        }

        if ( isset( $_POST['widget'] ) && ($_POST['widget'] == '1') ) {

          update_option( 'tag_group_shortcode_widget', 1 );

        } else {

          update_option( 'tag_group_shortcode_widget', 0 );

        }


        if ( isset( $_POST['enqueue'] ) && ($_POST['enqueue'] == '1') ) {

          update_option( 'tag_group_shortcode_enqueue_always', 1 );

        } else {

          update_option( 'tag_group_shortcode_enqueue_always', 0 );

        }

        TagGroups_Admin_Notice::add( 'success', __( 'Your settings have been saved.', 'tag-groups' ) );

        break;


        case 'reset':

        if ( ! isset( $_POST['tag-groups-reset-nonce'] ) || ! wp_verify_nonce( $_POST['tag-groups-reset-nonce'], 'tag-groups-reset' ) ) {

          die( "Security check" );

        }


        if ( $ok == 'yes' ) {

          $tag_group_groups->reset_groups();

          /**
          * Remove filters
          */
          delete_option( 'tag_group_tags_filter' );

          TagGroups_Admin_Notice::add( 'success', __( 'All groups have been deleted and assignments reset.', 'tag-groups' ) );

        }

        break;


        case 'uninstall':

        if ( ! isset( $_POST['tag-groups-uninstall-nonce'] ) || ! wp_verify_nonce( $_POST['tag-groups-uninstall-nonce'], 'tag-groups-uninstall' ) ) {

          die( "Security check" );

        }


        if ( $ok == 'yes' ) {

          update_option( 'tag_group_reset_when_uninstall', 1 );

        } else {

          update_option( 'tag_group_reset_when_uninstall', 0 );

        }

        TagGroups_Admin_Notice::add( 'success', __( 'Your settings have been saved.' ) );

        break;


        case 'theme':

        if ( isset( $_POST['theme-name'] ) ) {

          $theme_name = stripslashes( sanitize_text_field( $_POST['theme-name'] ) );

        } else {

          $theme_name = '';

        }

        if ( isset( $_POST['theme'] ) ) {

          $theme = stripslashes( sanitize_text_field( $_POST['theme'] ) );

        } else {

          $theme = '';

        }

        if ( $theme == 'own' ) {

          $theme = $theme_name;

        }

        if ( ! isset( $_POST['tag-groups-settings-nonce'] ) || ! wp_verify_nonce( $_POST['tag-groups-settings-nonce'], 'tag-groups-settings' ) ) {

          die( "Security check" );

        }

        update_option( 'tag_group_theme', $theme );

        $mouseover = (isset( $_POST['mouseover'] ) && $_POST['mouseover'] == '1') ? 1 : 0;

        $collapsible = (isset( $_POST['collapsible'] ) && $_POST['collapsible'] == '1') ? 1 : 0;

        $html_description = (isset( $_POST['html_description'] ) && $_POST['html_description'] == '1') ? 1 : 0;

        update_option( 'tag_group_mouseover', $mouseover );

        update_option( 'tag_group_collapsible', $collapsible );

        update_option( 'tag_group_html_description', $html_description );

        $tag_group_enqueue_jquery = ( isset( $_POST['enqueue-jquery'] ) && $_POST['enqueue-jquery'] == '1' ) ? 1 : 0;

        update_option( 'tag_group_enqueue_jquery', $tag_group_enqueue_jquery );

        // TagGroups_Admin::clear_cache();

        TagGroups_Admin_Notice::add( 'success', __( 'Your settings have been saved.' ) );

        do_action( 'tag_groups_theme_saved' );

        break;


        case 'taxonomy':

        if ( ! isset( $_POST['tag-groups-taxonomy-nonce'] ) || ! wp_verify_nonce( $_POST['tag-groups-taxonomy-nonce'], 'tag-groups-taxonomy' ) ) {

          die( "Security check" );

        }

        if ( isset( $_POST['taxonomies'] ) ) {

          $taxonomies = $_POST['taxonomies'];

          if ( is_array( $taxonomies ) ) {

            $taxonomies = array_map( 'sanitize_text_field', $taxonomies );

            $taxonomies = array_map( 'stripslashes', $taxonomies );

          } else {

            $taxonomies = array( 'post_tag' );

          }

        } else {

          $taxonomies = array( 'post_tag' );

        }

        $public_taxonomies = TagGroups_Taxonomy::get_public_taxonomies();

        foreach ( $taxonomies as $taxonomy_item ) {

          if ( ! in_array( $taxonomy_item, $public_taxonomies ) ) {

            die( "Security check: taxonomies" );

          }

        }

        update_option( 'tag_group_taxonomy', $taxonomies );

        // trigger actions
        do_action( 'taxonomies_saved', $taxonomies );

        if ( class_exists( 'TagGroups_Premium_Post' ) && ( ! defined( 'TAG_GROUPS_DISABLE_CACHE_REBUILD' ) || TAG_GROUPS_DISABLE_CACHE_REBUILD ) ) {

          // schedule rebuild of cache
          wp_schedule_single_event( time() + 10, 'tag_groups_rebuild_post_terms' );

        }

        TagGroups_Admin_Notice::add( 'success', __( 'Your settings have been saved.' ) );


        break;


        case 'backend':

        if ( ! isset( $_POST['tag-groups-backend-nonce'] ) || ! wp_verify_nonce( $_POST['tag-groups-backend-nonce'], 'tag-groups-backend' ) ) {

          die( "Security check" );

        }

        $show_filter_posts = isset( $_POST['filter_posts'] ) ? 1 : 0;

        update_option( 'tag_group_show_filter', $show_filter_posts );

        $show_filter_tags = isset( $_POST['filter_tags'] ) ? 1 : 0;

        update_option( 'tag_group_show_filter_tags', $show_filter_tags );

        TagGroups_Admin_Notice::add( 'success', __( 'Your settings have been saved.' ) );

        break;


        case 'export':

        if ( ! isset( $_POST['tag-groups-export-nonce'] ) || ! wp_verify_nonce( $_POST['tag-groups-export-nonce'], 'tag-groups-export' ) ) {

          die( "Security check" );

        }

        $options = array(
          'name' => 'tag_groups_options',
          'version' => TAG_GROUPS_VERSION,
          'date' => current_time( 'mysql' )
        );

        $tg_options = new TagGroups_Options();

        $option_names = $tg_options->get_option_names();

        foreach ( $option_names as $key => $value ) {

          if ( $option_names[ $key ][ 'export' ] ) {

            $options[ $key ] = get_option( $key );

          }

        }

        // generate array of all terms
        $terms = get_terms( array(
          'hide_empty' => false,
        ) );

        $cm_terms = array(
          'name' => 'tag_groups_terms',
          'version' => TAG_GROUPS_VERSION,
          'date' => current_time( 'mysql' )
        );

        $cm_terms['terms'] = array();

        $tag_group_taxonomy = TagGroups_Taxonomy::get_enabled_taxonomies();

        foreach ( $terms as $term ) {

          if ( in_array( $term->taxonomy, $tag_group_taxonomy ) ) {

            if ( class_exists('TagGroups_Premium_Term') && get_term_meta( $term->term_id, '_cm_term_group_array', true ) != '' ) {

              $term_group = explode( ',', get_term_meta( $term->term_id, '_cm_term_group_array', true ) );

            } else {

              $term_group = $term->term_group;

            }

            $cm_terms['terms'][] = array(
              'term_id' => $term->term_id,
              'name' => $term->name,
              'slug' => $term->slug,
              'term_group' => $term_group,
              'term_taxonomy_id' => $term->term_taxonomy_id,
              'taxonomy' => $term->taxonomy,
              'description' => $term->description,
              'parent' => $term->parent,
              'count' => $term->count,
              'filter' => $term->filter,
              'meta' => $term->meta,
            );

          }

        }


        /**
        * Writing file
        */
        try {

          // misusing the password generator to get a hash
          $hash = wp_generate_password( 10, false );

          /*
          * Write settings/groups and tags separately
          */
          $fp = fopen( WP_CONTENT_DIR . '/uploads/tag_groups_settings-' . $hash . '.json', 'w' );

          fwrite( $fp, json_encode( $options ) );

          fclose( $fp );


          $fp = fopen( WP_CONTENT_DIR . '/uploads/tag_groups_terms-' . $hash . '.json', 'w' );

          fwrite( $fp, json_encode( $cm_terms ) );

          fclose( $fp );


          TagGroups_Admin_Notice::add( 'success', __( 'Your settings/groups and your terms have been exported. Please download the resulting files with right-click or ctrl-click:', 'tag-groups' ) .
          '  <p>
          <a href="' . get_bloginfo( 'wpurl' ) . '/wp-content/uploads/tag_groups_settings-' . $hash . '.json" target="_blank">tag_groups_settings-' . $hash . '.json</a>
          </p>' .
          '  <p>
          <a href="' . get_bloginfo( 'wpurl' ) . '/wp-content/uploads/tag_groups_terms-' . $hash . '.json" target="_blank">tag_groups_terms-' . $hash . '.json</a>
          </p>' );

        } catch ( Exception $e ) {

          TagGroups_Admin_Notice::add( 'error', __( 'Writing of the exported settings failed.', 'tag-groups' ) );

        }

        break;

        case 'import':

        if ( ! isset( $_POST['tag-groups-import-nonce'] ) || ! wp_verify_nonce( $_POST['tag-groups-import-nonce'], 'tag-groups-import' ) ) {

          die( "Security check" );

        }

        // Make very sure that only administrators can upload stuff
        if ( ! current_user_can( 'manage_options' ) ) {

          die( "Capability check failed" );

        }

        if ( ! isset( $_FILES['settings_file'] ) ) {

          die( "File missing" );

        }

        if ( ! function_exists( 'wp_handle_upload' ) ) {

          require_once ABSPATH . 'wp-admin/includes/file.php';

        }

        $settings_file = $_FILES['settings_file'];

        // Check file name, but allow for some additional characters in file name since downloading multiple times may add something to the original name.
        // Allow extension txt for backwards compatibility
        preg_match( '/^tag_groups_settings-\w{10}[\w,\s-]*\.((txt)|(json))$/', $_FILES['settings_file']['name'], $matches_settings );

        preg_match( '/^tag_groups_terms-\w{10}[\w,\s-]*\.json$/', $_FILES['settings_file']['name'], $matches_terms );

        if ( ! empty( $matches_settings ) && ! empty( $matches_settings[0] ) && $matches_settings[0] == $_FILES['settings_file']['name'] ) {

          $contents = @file_get_contents( $settings_file['tmp_name'] );

          if ( $contents === false ) {

            TagGroups_Admin_Notice::add( 'error', __( 'Error reading the file.', 'tag-groups' ) );

          } else {

            $options = @json_decode( $contents , true);

            if ( empty( $options ) || !is_array( $options ) || $options['name'] != 'tag_groups_options' ) {

              TagGroups_Admin_Notice::add( 'error', __( 'Error parsing the file.', 'tag-groups' ) );

            } else {

              $tg_options = new TagGroups_Options();

              $option_names = $tg_options->get_option_names();

              $changed = 0;

              // import only whitelisted options
              foreach ( $option_names as $key => $value ) {

                if ( isset( $options[ $key ] ) ) {

                  $changed += update_option( $key, $options[ $key ] ) ? 1 : 0;

                }

              }

              if ( ! isset( $options['date'] ) ) {
                $options['date'] = ' - ' . __( 'date unknown', 'tag-groups' ) . ' - ';
              }

              TagGroups_Admin_Notice::add( 'success', sprintf( __( 'Your settings and groups have been imported from the file %1$s (created with plugin version %2$s on %3$s).', 'tag-groups' ), '<b>' . $_FILES['settings_file']['name'] . '</b>', $options['version'], $options['date'] ) . '</p><p>' .
              sprintf( _n( '%d option was added or changed.','%d options were added or changed.', $changed, 'tag-groups' ), $changed ) );

              do_action( 'tag_groups_settings_imported' );

            }

          }

        } elseif ( ! empty( $matches_terms ) && ! empty( $matches_terms[0] ) && $matches_terms[0] == $_FILES['settings_file']['name'] ) {

          $contents = @file_get_contents( $settings_file['tmp_name'] );

          if ( $contents === false ) {

            TagGroups_Admin_Notice::add( 'error', __( 'Error reading the file.', 'tag-groups' ) );

          } else {

            $terms = @json_decode( $contents , true);

            if ( empty( $terms ) || !is_array( $terms ) || $terms['name'] != 'tag_groups_terms' ) {

              TagGroups_Admin_Notice::add( 'error', __( 'Error parsing the file.', 'tag-groups' ) );

            } else {

              $changed = 0;

              foreach ( $terms['terms'] as $term ) {

                // change only terms with the same name, else create new one
                if ( ! term_exists( $term['term_id'], $term['taxonomy'] ) ) {

                  $inserted_term = wp_insert_term( $term['name'], $term['taxonomy'] );

                  if ( is_array( $inserted_term ) ) {

                    if ( is_array( $term['term_group'] ) && class_exists( 'TagGroups_Premium_Term' ) ) {

                      TagGroups_Premium_Term::save( $inserted_term['term_id'], $term['taxonomy'], $term['term_group'] );

                      unset( $term['term_group'] );

                    }

                    $result = wp_update_term( $inserted_term['term_id'], $term['taxonomy'], $term );

                    if ( is_array( $result ) ) {

                      $changed++;

                    }

                  }

                } else {

                  $result = wp_update_term( $term['term_id'], $term['taxonomy'], $term );

                  if ( is_array( $result ) ) {

                    $changed++;

                  }

                }

              }

              if ( ! isset( $terms['date'] ) ) {

                $terms['date'] = ' - ' . __( 'date unknown', 'tag-groups' ) . ' - ';

              }

              TagGroups_Admin_Notice::add( 'success', sprintf( __( 'Your terms have been imported from the file %1$s (created with plugin version %2$s on %3$s).', 'tag-groups' ), '<b>' . $_FILES['settings_file']['name'] . '</b>', $terms['version'], $terms['date'] ) . '</p><p>' .
              sprintf( _n( '%d term was added or updated.','%d terms were added or updated.', $changed, 'tag-groups' ), $changed ) );

              do_action( 'tag_groups_terms_imported' );

            }

          }

        } else {

          if ( ! empty( $_FILES['settings_file']['name'] ) ) {

            $file_info = ' ' . $_FILES['settings_file']['name'];

          } else {

            $file_info = '';

          }

          TagGroups_Admin_Notice::add( 'error', __( 'Error uploading the file.', 'tag-groups' ) . $file_info );

        }

        break;

        default:
        // hook for premium plugin
        do_action( 'tag_groups_hook_settings_action', $tg_action );

        break;
      }


    }


    /**
    * Prepares variable for echoing as string
    *
    *
    * @param mixed $var Mixed type that needs to be echoed as string.
    * @return return string
    */
    private static function echo_var( $var = null )
    {

      if ( is_bool( $var ) ) {

        return $var ? 'true' : 'false';

      } elseif ( is_array( $var ) )  {

        return print_r( $var, true );

      } else {

        return (string) $var;

      }

    }


    /**
    * Returns an array that contains topics covered in the settings
    *
    * @param void
    * @return array
    */
    public static function get_setting_topics()
    {

      $public_taxonomies_slugs = TagGroups_Taxonomy::get_public_taxonomies();

      $public_taxonomies_names = array_map( array( 'TagGroups_Taxonomy', 'get_name_from_slug' ), $public_taxonomies_slugs );

      $topics = array(
        'taxonomies'  => array(
          'title' => __( 'Taxonomies', 'tag-groups' ),
          'page' => 'tag-groups-settings-taxonomies',
          'keywords'  => array_merge(
            array_keys( $public_taxonomies_names ),
            array_values( $public_taxonomies_names ),
            array(
              __( 'tag groups', 'tag-groups' ),
            )
          ),
        ),
        'shortcodes'  => array(
          'title' => __( 'Shortcodes', 'tag-groups' ),
          'page' => 'tag-groups-settings-front-end' ,
          'keywords'  => array(
            __( 'tag cloud', 'tag-groups' ),
            __( 'group info', 'tag-groups' ),
            __( 'sidebar widget', 'tag-groups' ),
            __( 'accordion', 'tag-groups' ),
            __( 'tabs', 'tag-groups' ),
            __( 'alphabetical', 'tag-groups' ),
            __( 'post list', 'tag-groups' ),
            'Gutenberg',
          ),
        ),
        'themes'  => array(
          'title' => __( 'Themes and Appearance', 'tag-groups' ),
          'page' => 'tag-groups-settings-front-end' ,
          'keywords'  => array(
            __( 'tag cloud', 'tag-groups' ),
            'CSS',
            'style',
            'HTML',
            __( 'colors', 'tag-groups' ),
            __( 'tag description', 'tag-groups' ),
          ),
        ),
        'filters'  => array(
          'title' => __( 'Filters', 'tag-groups' ),
          'page' => 'tag-groups-settings-back-end' ,
          'keywords'  => array(
            __( 'tag filter', 'tag-groups' ),
            __( 'post filter', 'tag-groups' ),
          ),
        ),
        'export_import'  => array(
          'title' => __( 'Export/Import', 'tag-groups' ),
          'page' => 'tag-groups-settings-tools' ,
          'keywords'  => array(
            __( 'backup', 'tag-groups' ),
          ),
        ),
        'reset'  => array(
          'title' => __( 'Reset', 'tag-groups' ),
          'page' => 'tag-groups-settings-tools' ,
          'keywords'  => array(
            __( 'remove plugin', 'tag-groups' ),
            __( 'remove data', 'tag-groups' ),
            __( 'delete groups', 'tag-groups' ),
          ),
        ),
        'faq'  => array(
          'title' => __( 'FAQ and Common Issues', 'tag-groups' ),
          'page' => 'tag-groups-settings-troubleshooting' ,
          'keywords'  => array(
            __( 'frequently asked questions', 'tag-groups' ),
            __( 'help', 'tag-groups' ),
            __( 'bug', 'tag-groups' ),
            __( 'problem', 'tag-groups' ),
            __( 'troubleshooting', 'tag-groups' ),
            __( 'support', 'tag-groups' ),
          ),
        ),
        'documentation'  => array(
          'title' => __( 'Documentation', 'tag-groups' ),
          'page' => 'tag-groups-settings-troubleshooting' ,
          'keywords'  => array(
            __( 'instructions', 'tag-groups' ),
            __( 'help', 'tag-groups' ),
            __( 'problem', 'tag-groups' ),
            __( 'troubleshooting', 'tag-groups' ),
            __( 'support', 'tag-groups' ),
            'Gutenberg',
            'CSS',
            'style',
            'PHP',
            'REST API'
          ),
        ),
        'support'  => array(
          'title' => __( 'Get Support', 'tag-groups' ),
          'page' => 'tag-groups-settings-troubleshooting' ,
          'keywords'  => array(
            __( 'support', 'tag-groups' ),
            __( 'contact', 'tag-groups' ),
            __( 'forum', 'tag-groups' ),
            __( 'bug', 'tag-groups' ),
            __( 'problem', 'tag-groups' ),
            __( 'help', 'tag-groups' ),
          ),
        ),
        'system'  => array(
          'title' => __( 'System Information', 'tag-groups' ),
          'page' => 'tag-groups-settings-troubleshooting' ,
          'keywords'  => array(
            __( 'debugging', 'tag-groups' ),
            __( 'PHP Version', 'tag-groups' ),
            __( 'Ajax Test', 'tag-groups' ),
            __( 'troubleshooting', 'tag-groups' ),
          ),
        ),
        'premium'  => array(
          'title' => __( 'Premium', 'tag-groups' ),
          'page' => 'tag-groups-settings-premium' ,
          'keywords'  => array(
            __( 'upgrade', 'tag-groups' ),
            __( 'more groups', 'tag-groups' ),
            __( 'posts', 'tag-groups' ),
            __( 'tag cloud', 'tag-groups' ),
            __( 'filter', 'tag-groups' ),
            'WooCommerce'
          ),
        ),
        'info'  => array(
          'title' => __( 'Info', 'tag-groups' ),
          'page' => 'tag-groups-settings-about' ,
          'keywords'  => array(
            __( 'author', 'tag-groups' ),
            __( 'version', 'tag-groups' ),
            __( 'contact', 'tag-groups' ),
            __( 'about', 'tag-groups' ),
          ),
        ),
        'licenses'  => array(
          'title' => __( 'Licenses', 'tag-groups' ),
          'page' => 'tag-groups-settings-about' ,
          'keywords'  => array(
            __( 'Credits', 'tag-groups' ),
          ),
        ),
        'news'  => array(
          'title' => __( 'Development News', 'tag-groups' ),
          'page' => 'tag-groups-settings-about' ,
          'keywords'  => array(
            __( 'blog', 'tag-groups'),
            __( 'updates', 'tag-groups' ),
          ),
        ),
        'getting_started'  => array(
          'title' => __( 'First Steps', 'tag-groups' ),
          'page' => 'tag-groups-settings-first-steps' ,
          'keywords'  => array(
            __( 'getting started', 'tag-groups' ),
            __( 'introduction', 'tag-groups' ),
            __( 'help', 'tag-groups' ),
          ),
        ),
        'setup_wizard'  => array(
          'title' => __( 'Setup Wizard', 'tag-groups' ),
          'page' => 'tag-groups-settings-setup-wizard' ,
          'keywords'  => array(
            __( 'getting started', 'tag-groups' ),
            __( 'introduction', 'tag-groups' ),
            __( 'sample', 'tag-groups' ),
          ),
        ),
      );

      $topics = apply_filters( 'tag_groups_setting_topics' , $topics );

      return $topics;

    }


    /**
    * Renders the widget where you can search for help
    *
    * @param void
    * @return void
    */
    public static function add_settings_help()
    {

      $topics = self::get_setting_topics();

      asort( $topics );

      $view = new TagGroups_View( 'admin/settings_help' );

      $view->set( 'topics', $topics );

      $view->render();

    }


  }

}
