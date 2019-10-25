<?php
/**
 * Starter..
 * 
 * Include files - admin - front end 
 * 
 * add hooks
 * 
 * added variable to declare other instance if needed 
 * ( in some cases in this plugin, using static methods and calling with out creating instance )
 * 
 * @package CCW
 * @since 1.3 + ( later in 1.3 - made changes, but not created a new version )
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'HT_CCW' ) ) :

class HT_CCW {

    /**
     * plugin version 
     * 
     * it's private to this class, 
     * out side of this class use defined constant
     * HT_CCW_VERSION
     * 
     * @uses to define constant  -  HT_CCW_VERSION
     * 
     * @var float
     * 
     * if this changed dont forgot to change in plugin header content 
     * click-to-chat.php - Version
     */
    private $version = '1.6';


    /**
     * singleton instance
     *
     * @var HT_CCW 
     */
    private static $instance = null;
    

    /**
     * wp_is_mobile - if true then 1, else 2
     *
     * @var int if mobile, tab .. then 1, else 2
     */
    public $device_type;


    /**
     * instance of HT_CCW_Variables
     * 
     * database values , .. . options .. 
     *
     * @var HT_CCW_Variables
     */
    public $variables = null;


    /**
     * main instance - HT_CCW
     *
     * @return HT_CCW instance
     * @since 1.0
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function __clone() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'click-to-chat-for-whatsapp' ), '1.0' );
    }
    
    public function __wakeup() {
		wc_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'click-to-chat-for-whatsapp' ), '1.0' );
    }



    /**
     * constructor 
     * calling to - includes - which include files
     * calling to - hooks  - which run hooks 
     */
    public function __construct() {
        $this->define_constants();

        $this->basic();

        $this->includes();
        $this->hooks();
    }
    

    

    /**
     * Define Constants
     *
     * @return void
     */
    private function define_constants() {
        
        $this->define( 'HT_CCW_VERSION', $this->version );

        $this->define( 'HT_CCW_WP_MIN_VERSION', '4.6' );
        $this->define( 'HT_CCW_PLUGIN_DIR', plugin_dir_path( HT_CCW_PLUGIN_FILE ) );
        $this->define( 'HT_CCW_PLUGIN_BASENAME', plugin_basename( HT_CCW_PLUGIN_FILE ) );

        $this->define( 'HT_CCW_OPTIONS_PAGE_SLUG', 'click-to-chat' );
        $this->define( 'HT_CCW_OPTIONS_PAGE_SLUG_CUSTOM_STYLES', 'ccw-edit-styles' );
    }




    /**
     * add the basic things
     * 
     * calling this before include, initilize other things
     * 
     * because this things may useful before initilize other things
     * 
     *  e.g. include, initialize files based on device, user settings
     */
    private function basic() {

        require_once HT_CCW_PLUGIN_DIR .'inc/commons/class-ht-ccw-ismobile.php';
        require_once HT_CCW_PLUGIN_DIR .'inc/commons/class-ht-ccw-variables.php';
        
        $this->device_type = new HT_CCW_IsMobile();
        $this->variables = new HT_CCW_Variables();

    }




    /**
     * @uses this->define_constants
     *
     * @param string $name Constant name
     * @param string.. $value Constant value
     */
    private function define( $name, $value ) {
        if ( ! defined( $name ) ) {
            define( $name, $value );
        }
    }



    
    /**
     * include plugin file
     */
    private function includes() {

        // include in admin and front pages
        require_once HT_CCW_PLUGIN_DIR .'inc/class-ht-ccw-register.php';
        // require_once HT_CCW_PLUGIN_DIR .'inc/commons/class-ht-ccw-variables.php';
        // require_once HT_CCW_PLUGIN_DIR .'inc/commons/class-ht-ccw-ismobile.php';


        //  is_admin ? include file to admin area : include files to non-admin area 
        if ( is_admin() ) {
            require_once HT_CCW_PLUGIN_DIR . 'admin/admin.php';
        } else {
            require_once HT_CCW_PLUGIN_DIR . 'inc/class-ccw-add-styles-scripts.php';
            require_once HT_CCW_PLUGIN_DIR . 'inc/class-ccw-shortcode.php';

            // require_once HT_CCW_PLUGIN_DIR . 'inc/class-ht-ccw-floating-style.php';
            require_once HT_CCW_PLUGIN_DIR . 'inc/class-ht-ccw-chat.php';
            
        }
    }



    /**
     * Register hooks - when plugin activate, deactivate, uninstall
     * commented deactivation, uninstall hook - its not needed as now
     * 
     * plugins_loaded  - Check Diff - uses when plugin updates.
     */
    private function hooks() {

        register_activation_hook( __FILE__, array( 'HT_CCW_Register', 'activate' )  );
        register_deactivation_hook( __FILE__, array( 'HT_CCW_Register', 'deactivate' )  );
        register_uninstall_hook(__FILE__, array( 'HT_CCW_Register', 'uninstall' ) );

        // initilaze classes
        if ( ! is_admin() ) {
            add_action( 'init', array( $this, 'init' ), 0 );
        }

        // enable shortcodes in widget area.
        add_filter('widget_text', 'do_shortcode');
        
        // add_filter( 'the_excerpt', 'do_shortcode');

        // settings page link
        add_filter( 'plugin_action_links_' . HT_CCW_PLUGIN_BASENAME, array( 'HT_CCW_Register', 'plugin_action_links' ) );

        // when plugin updated - check version diff
        add_action('plugins_loaded', array( 'HT_CCW_Register', 'version_check' ) );

    }




    /**
     * create instance
     * @uses this->hooks() - using init hook - priority 0
     */
    public function init() {
        
        // $this->variables = new HT_CCW_Variables();

        // $this->device_type = new HT_CCW_IsMobile();

        // $this->floating_style = new HT_CCW_Floating_Style();
        $this->floating_style = new HT_CCW_Chat();

    }



}

endif; // END class_exists check