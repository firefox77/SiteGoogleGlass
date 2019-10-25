<?php
/**
* Register css styles, javascript files at admin side
* instead of register multiple styles - as using sass in dev env, 
*    import files and at final create less css files
*
* @package ccw
* @subpackage Administration
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'CCW_Add_Styles_Scripts_Admin' ) ) :

class CCW_Add_Styles_Scripts_Admin {


    // Register css styles, javascript files only on 'click-to-chat' page
    function ccw_register_files_admin($hook) {
        
        if( 'toplevel_page_click-to-chat' == $hook || 'click-to-chat_page_ccw-edit-styles' == $hook ) {

            wp_register_style('ccw_new_css_admin', plugins_url( 'assets/css/admin_mainstyles.css', HT_CCW_PLUGIN_FILE ) , '', HT_CCW_VERSION );
            
            
            wp_enqueue_style('ccw_new_css_admin');

            wp_enqueue_style( 'wp-color-picker' );

    
            // wp_enqueue_script( 'ccw_app_admin', plugins_url( 'assets/js/admin_app.js', HT_CCW_PLUGIN_FILE ), array( 'wp-color-picker' ), HT_CCW_VERSION, true );
            wp_enqueue_script( 'ccw_app_admin', plugins_url( 'assets/js/required/admin_app-works.js', HT_CCW_PLUGIN_FILE ), array( 'wp-color-picker' ), HT_CCW_VERSION, true );



            // wp_enqueue_script( 'ccw_app_admin_dir', plugins_url( 'assets/js/dir.js', HT_CCW_PLUGIN_FILE ), '', '', true );
            // return;
        } else {
            return;
        }

        
    }

}

$add_styles_scripts_admin =  new CCW_Add_Styles_Scripts_Admin();

add_action('admin_enqueue_scripts', array( $add_styles_scripts_admin, 'ccw_register_files_admin' ) );


endif; // END class_exists check