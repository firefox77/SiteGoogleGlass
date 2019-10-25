<?php
/**
 * mdjs.js - material design - js - style 1 only needed - added at template file style-1.php
 * app.js  -  autop issue solution, animtions - added for all styles
 * 
 * mainstyles.css  -  for all styles .. 
 * mdstyles.css  - style 1, 8 needed - 
 *                  for floating style added with conditons - in this file
 *                  for shortcodes added at there related template files.. ( sc-style- .php )
 * for shortcode - if user faces issue, as style apply to elements later 
 *      - then uncomment a line, then works normal  
 *        - wp_enqueue_style('ccw_md_css'); - ( 46th line or near .. )
 * 
 * admin_mainstyles.css, admin_app-works.js - admin side
 * 
 * 
 * 
 * @package ccw
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'CCW_Add_Styles_Scripts' ) ) :
    
class CCW_Add_Styles_Scripts {


    /**
	 * Register styles - front end ( non admin )
	 *
	 * @since 1.0
	 */
    function ccw_register_files() {

        wp_register_style('ccw_main_css', plugins_url( 'assets/css/mainstyles.css', HT_CCW_PLUGIN_FILE ), '', HT_CCW_VERSION );
        wp_enqueue_style('ccw_main_css');
        
        
        wp_register_style('ccw_md_css', plugins_url( 'assets/css/required/mdstyles.css', HT_CCW_PLUGIN_FILE ), '', HT_CCW_VERSION );
        // needs - s1, s8
        // wp_enqueue_style('ccw_md_css');
        
        
        wp_enqueue_script( 'ccw_app', plugins_url( 'assets/js/app.js', HT_CCW_PLUGIN_FILE ), array ( 'jquery' ), HT_CCW_VERSION, true );

        // only style-1 needed
        wp_register_script( 'ccw_md_js', plugins_url( 'assets/js/required/mdjs.js', HT_CCW_PLUGIN_FILE ), array ( 'jquery' ), HT_CCW_VERSION, true );
        // wp_register_script( 'ccw_md_js', plugins_url( 'assets/js/md.js', HT_CCW_PLUGIN_FILE ), array ( 'jquery' ), HT_CCW_VERSION, true );


        // As now - for floating style - enqueue md style added like this
        // but for shortcodes enqueue while calling that template file
        $mobile_style = ht_ccw()->variables->get_option['stylemobile'];
        $desktop_style = ht_ccw()->variables->get_option['style'];

        /**
         * is mobile or not
         * and then enqueue styles if selected style is 1, 4, 8
         */
        if ( 1 == ht_ccw()->device_type->is_mobile ) {
            if ( 1 == $mobile_style || 8 == $mobile_style ) {
                wp_enqueue_style('ccw_md_css');
            }
        } else {
            if ( 1 == $desktop_style || 8 == $desktop_style ) {
                wp_enqueue_style('ccw_md_css');
            }
        }
        
    }


}

endif; // END class_exists check


$add_styles_scripts = new CCW_Add_Styles_Scripts();

add_action('wp_enqueue_scripts', array( $add_styles_scripts, 'ccw_register_files' ) );