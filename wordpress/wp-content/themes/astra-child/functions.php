<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-child-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

	wp_enqueue_script('bootstrap_css', get_template_directory_uri().'/assets/js/jqBootstrapValidation.js', ('jquery'),'', true);
	wp_enqueue_script('bootstrap_css', get_stylesheet_directory_uri().'/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', ('jquery'),'', true);		
	wp_enqueue_script('theme_js', get_stylesheet_directory_uri().'/assets/js/freelancer.js', ('jquery'),'', true);	
	wp_enqueue_script('theme_js', get_stylesheet_directory_uri().'/assets/js/freelancer.min.js', ('jquery'),'', true);
	wp_enqueue_script('jquery_js', get_stylesheet_directory_uri().'/assets/vendor/jquery/jquery.min.js', ('jquery'),'', true);

	/*wp_enqueue_style( 'theme-css', get_template_directory_uri() . '/assets/css/freelancer.min.css', array('astra-child-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

	wp_enqueue_style( 'theme-css', get_template_directory_uri() . '/assets/css/freelancer.css', array('astra-child-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );*/
	
}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles');