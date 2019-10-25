<?php
/**
* Tag Groups
*
* @package     Tag Groups
* @author      Christoph Amthor
* @copyright   2019 Christoph Amthor (@ Chatty Mango, chattymango.com)
* @license     GPL-3.0+
*
*/

if ( ! class_exists( 'TagGroups_Loader' ) ) {

  class TagGroups_Loader {


    /**
    * absolute path to the plugin main file
    *
    * @var string
    */
    var $plugin_path;


    function __construct( $plugin_path ) {

      $this->plugin_path = $plugin_path;

    }


    /**
    * Provide objects that we'll need frequently
    *
    * @param void
    * @return object $this
    */
    public function provide_globals() {

      global $tag_group_groups, $tag_group_terms;

      $tag_group_groups = new TagGroups_Groups();

      $tag_group_terms = new TagGroups_Terms();

      return $this;

    }


    /**
    * Adds all required classes
    *
    * @param void
    * @return object $this
    */
    public function require_classes()
    {

      /*
      * Require all classes of this plugin
      */
      foreach ( glob( $this->plugin_path . '/include/entities/*.php') as $filename ) {

        require_once $filename;

      }

      foreach ( glob( $this->plugin_path . '/include/helpers/*.php') as $filename ) {

        require_once $filename;

      }

      foreach ( glob( $this->plugin_path . '/include/admin/*.php') as $filename ) {

        require_once $filename;

      }

      /**
      * Must be after helpers
      */
      foreach ( glob( $this->plugin_path . '/include/shortcodes/*.php') as $filename ) {

        require_once $filename;

      }

      return $this;

    }


    /**
    * Sets the version from the plugin main file
    *
    * @param void
    * @return object $this;
    */
    public function set_version()
    {

      if ( defined( 'TAG_GROUPS_VERSION') ) {

        return $this;

      }

      if ( ! function_exists('get_plugin_data') ){

        require_once ABSPATH . '/wp-admin/includes/plugin.php';

      }

      $plugin_header = get_plugin_data( WP_PLUGIN_DIR . '/' . TAG_GROUPS_PLUGIN_BASENAME, false, false );

      if ( isset( $plugin_header['Version'] ) ) {

        $version = $plugin_header['Version'];

      } else {

        $version = '1.0';

      }


      define( 'TAG_GROUPS_VERSION', $version );

    }


    /**
    * Check if WordPress meets the minimum version
    *
    * @param void
    * @return void
    */
    public function check_preconditions() {

      if ( ! defined( 'TAG_GROUPS_MINIMUM_VERSION_WP' ) ) {

        return;

      }

      global $wp_version;

      // Check the minimum WP version
      if ( version_compare( $wp_version, TAG_GROUPS_MINIMUM_VERSION_WP , '<' ) ) {

        error_log( '[Tag Groups] Insufficient WordPress version for Tag Groups plugin.' );

        TagGroups_Admin_Notice::add( 'error', sprintf( __( 'The plugin %1$s requires WordPress %2$s to function properly.', 'tag-groups'), '<b>Tag Groups</b>', TAG_GROUPS_MINIMUM_VERSION_WP ) .
        __( 'Please upgrade WordPress and then try again.', 'tag-groups' ) );

        return;

      }

    }


    /**
    * adds all hooks
    *
    * @param void
    * @return object $this
    */
    public function add_hooks()
    {

      add_action( 'init', array( $this, 'add_init_hooks' ) );


      // general stuff
      add_action( 'plugins_loaded', array( $this, 'register_textdomain' ) );

      if ( is_admin() ) {

        // backend stuff
        add_action( 'admin_init', array( 'TagGroups_Admin', 'admin_init' ) );

        add_action( 'admin_init', array( $this, 'check_old_premium' ) );

        add_action( 'admin_menu', array( 'TagGroups_Admin', 'register_menus' ) );

        add_action( 'admin_enqueue_scripts', array( 'TagGroups_Admin', 'add_admin_js_css' ) );

        add_action( 'admin_notices', array( 'TagGroups_Admin_Notice', 'display' ) );

      } else {

        // frontend stuff
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

        add_action( 'init', array( 'TagGroups_Shortcode', 'widget_hook' ) );

      }

      return $this;

    }


    /**
    * adds all hooks that need to be registered after init
    *
    * @param void
    * @return object $this
    */
    public function add_init_hooks()
    {

      return $this;

    }


    /**
    * registers the shortcodes with Gutenberg blocks
    *
    * @param void
    * @return object $this
    */
    public function register_shortcodes_and_blocks()
    {

      /**
      * add Gutenberg functionality
      */
      require_once $this->plugin_path . '/src/init.php';

      // Register shortcodes also for admin so that we can remove them with strip_shortcodes in Ajax call
      TagGroups_Shortcode::register();

      return $this;

    }

    /**
    * registers the REST API
    *
    * @param void
    * @return object $this
    */
    public function register_REST_API()
    {

      TagGroups_REST_API::register();

      return $this;

    }


    /**
    * Check if we don't have any old Tag Groups Premium
    *
    * @param void
    * @return void
    */
    public function check_old_premium() {

      // Check the minimum WP version
      if (
        defined( 'TAG_GROUPS_VERSION' ) &&
        defined( 'TAG_GROUPS_VERSION' ) &&
        version_compare( TAG_GROUPS_VERSION, '0.38' , '>' ) &&
        version_compare( TAG_GROUPS_VERSION, '1.12' , '<' )
      ) {

        error_log( '[Tag Groups Premium] Incompatible versions of Tag Groups and Tag Groups Premium.' );

        TagGroups_Admin_Notice::add( 'info', sprintf( __( 'Your version of Tag Groups Premium is out of date and will not work with this version of Tag Groups. Please <a %s>update Tag Groups Premium</a>.', 'tag-groups'), 'href="https://documentation.chattymango.com/documentation/tag-groups-premium/maintenance-and-troubleshooting/updating-tag-groups-premium/" target="_blank"' ), '<b>Tag Groups</b>' );

        return;

      }

    }


    /**
    *   Initializes values and prevents errors that stem from wrong values, e.g. based on earlier bugs.
    *   Runs when plugin is activated.
    *
    * @param void
    * @return void
    */
    static function on_activation() {

      if ( ! current_user_can( 'activate_plugins' ) ) {

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

          error_log( '[Tag Groups] Insufficient permissions to activate plugin.' );

        }

        return;

      }

      if ( TAG_GROUPS_PLUGIN_IS_KERNL ) {

        register_uninstall_hook( TAG_GROUPS_PLUGIN_ABSOLUTE_PATH, array( 'TagGroups_Activation_Deactivation', 'on_uninstall' ) );

      }

      if ( ! defined( 'TAG_GROUPS_VERSION') ){

        $tag_groups_loader = new TagGroups_Loader( __FILE__ );

        $tag_groups_loader->set_version();

      }

      update_option( 'tag_group_base_version', TAG_GROUPS_VERSION );

      /*
      * Taxonomy should not be empty
      */
      $tag_group_taxonomy = get_option( 'tag_group_taxonomy', array() );

      if ( empty( $tag_group_taxonomy ) ) {

        update_option( 'tag_group_taxonomy', array('post_tag') );

      } elseif ( ! is_array( $tag_group_taxonomy ) ) {

        // Prevent some weird errors
        update_option( 'tag_group_taxonomy', array( $tag_group_taxonomy ) );

      }

      /*
      * Theme should not be empty
      */
      if ( '' == get_option( 'tag_group_theme', '' )  ) {

        update_option( 'tag_group_theme', TAG_GROUPS_STANDARD_THEME );

      }


      /**
      * Register time of first use
      */
      if ( ! get_option( 'tag_group_base_first_activation_time', false ) ) {

        update_option( 'tag_group_base_first_activation_time', time() );

      }


      // If requested and new options exist, then remove old options.
      if (
        defined( 'TAG_GROUPS_REMOVE_OLD_OPTIONS' )
        && TAG_GROUPS_REMOVE_OLD_OPTIONS
        && get_option( 'term_groups', false )
        && get_option( 'term_group_positions', false )
        && get_option( 'term_group_labels', false )
      ) {

        delete_option( 'tag_group_labels' );

        delete_option( 'tag_group_ids' );

        delete_option( 'max_tag_group_id' );

        if ( defined( 'WP_DEBUG') && WP_DEBUG ) {

          error_log( '[Tag Groups] Deleted deprecated options' );

        }

      }


      // purge cache
      if ( class_exists( 'ChattyMango_Cache' ) ) {
        $cache = new ChattyMango_Cache();
        $cache
        ->type( get_option( 'tag_group_object_cache', ChattyMango_Cache::WP_OPTIONS ) )
        ->path( WP_CONTENT_DIR . '/chatty-mango/cache/' )
        ->purge_all();
      }


      if ( get_option( 'tag_group_onboarding', false ) === false ) {

        /*
        * Seems to be a first-time user - display some help
        */
        $onboarding_link =  admin_url( 'admin.php?page=tag-groups-settings-first-steps' );

        if ( defined( 'TAG_GROUPS_VERSION' ) ) {

          $plugin_name = 'Tag Groups Premium';

        } else {

          $plugin_name = 'Tag Groups';
          
        }

        TagGroups_Admin_Notice::add(
          'info',
          '<h3>' . sprintf( __( 'Thank you for installing %s!', 'tag-groups' ), $plugin_name ) . '</h3>' .
          '<p>' . sprintf( __( 'Click <a %s>here</a> to get some help on how to get started.', 'tag-groups' ), 'href="' . $onboarding_link . '"') . '</p>'
        );

        update_option( 'tag_group_onboarding', 1 );

      }

    }


    /**
    * Adds js and css to frontend
    *
    *
    * @param void
    * @return void
    */
    public function enqueue_scripts() {

      /* enqueue frontend scripts and styling only if shortcode in use */
      global $post;

      if (
        get_option( 'tag_group_shortcode_enqueue_always', 1 ) ||
        ( ! is_a( $post, 'WP_Post' ) || (
          has_shortcode( $post->post_content, 'tag_groups_cloud' ) ||
          has_shortcode( $post->post_content, 'tag_groups_accordion' ) ||
          has_shortcode( $post->post_content, 'tag_groups_table' ) )
          )
        ) {

          $theme = get_option( 'tag_group_theme', TAG_GROUPS_STANDARD_THEME );

          $default_themes = explode( ',', TAG_GROUPS_BUILT_IN_THEMES );

          $tag_group_enqueue_jquery = get_option( 'tag_group_enqueue_jquery', 1 );


          if ( $tag_group_enqueue_jquery ) {

            wp_enqueue_script( 'jquery' );

            wp_enqueue_script( 'jquery-ui-core' );

            wp_enqueue_script( 'jquery-ui-tabs' );

            wp_enqueue_script( 'jquery-ui-accordion' );

          }

          if ( $theme == '' ) {

            return;

          }

          wp_register_style( 'tag-groups-css-frontend-structure', TAG_GROUPS_PLUGIN_URL . '/assets/css/jquery-ui.structure.min.css', array(), TAG_GROUPS_VERSION );


          if ( in_array( $theme, $default_themes ) ) {

            wp_register_style( 'tag-groups-css-frontend-theme', TAG_GROUPS_PLUGIN_URL . '/assets/css/' . $theme . '/jquery-ui.theme.min.css', array(), TAG_GROUPS_VERSION );

          } else {
            /*
            * Load minimized css if available
            */
            if ( file_exists( WP_CONTENT_DIR . '/uploads/' . $theme . '/jquery-ui.theme.min.css' ) ) {

              wp_register_style( 'tag-groups-css-frontend-theme', get_bloginfo( 'wpurl' ) . '/wp-content/uploads/' . $theme . '/jquery-ui.theme.min.css', array(), TAG_GROUPS_VERSION );

            } else if ( file_exists( WP_CONTENT_DIR . '/uploads/' . $theme . '/jquery-ui.theme.css' ) ) {

              wp_register_style( 'tag-groups-css-frontend-theme', get_bloginfo( 'wpurl' ) . '/wp-content/uploads/' . $theme . '/jquery-ui.theme.css', array(), TAG_GROUPS_VERSION );

            } else {
              /*
              * Fallback: Is this a custom theme of an old version?
              */
              try {

                $dh = opendir( WP_CONTENT_DIR . '/uploads/' . $theme );

              } catch ( ErrorException $e ) {

                error_log( '[Tag Groups] Error searching ' . WP_CONTENT_DIR . '/uploads/' . $theme );

              }

              if ( $dh ) {

                while ( false !== ( $filename = readdir( $dh ) ) ) {

                  if ( preg_match( "/jquery-ui-\d+\.\d+\.\d+\.custom\.(min\.)?css/i", $filename ) ) {

                    wp_register_style( 'tag-groups-css-frontend-theme', get_bloginfo( 'wpurl' ) . '/wp-content/uploads/' . $theme . '/' . $filename, array(), TAG_GROUPS_VERSION );

                    break;

                  }
                }
              }
            }
          }

          wp_enqueue_style( 'tag-groups-css-frontend-structure' );

          wp_enqueue_style( 'tag-groups-css-frontend-theme' );

        }

      }


      /**
      * Loads text domain for internationalization
      */
      public function register_textdomain() {

        load_plugin_textdomain( 'tag-groups', false, TAG_GROUPS_PLUGIN_RELATIVE_PATH . '/languages/' );

      }

    }

  }
