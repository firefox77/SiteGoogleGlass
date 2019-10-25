<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function puremag_widgets_init() {

register_sidebar(array(
    'id' => 'puremag-header-banner',
    'name' => __( 'Header Banner', 'puremag' ),
    'description' => __( 'This sidebar is located on the header of the web page.', 'puremag' ),
    'before_widget' => '<div id="%1$s" class="puremag-header-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="puremag-widget-title">',
    'after_title' => '</h2>'));

register_sidebar(array(
    'id' => 'puremag-main-sidebar',
    'name' => __( 'Main Sidebar', 'puremag' ),
    'description' => __( 'This sidebar is located on the right-hand side of web page.', 'puremag' ),
    'before_widget' => '<div id="%1$s" class="puremag-side-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="puremag-widget-title">',
    'after_title' => '</h2>'));

register_sidebar(array(
    'id' => 'puremag-home-top-widgets',
    'name' => __( 'Top Widgets (Home Page Only)', 'puremag' ),
    'description' => __( 'This widget area is located at the top of homepage.', 'puremag' ),
    'before_widget' => '<div id="%1$s" class="puremag-main-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="puremag-widget-title">',
    'after_title' => '</h2>'));

register_sidebar(array(
    'id' => 'puremag-top-widgets',
    'name' => __( 'Top Widgets (Every Page)', 'puremag' ),
    'description' => __( 'This widget area is located at the top of every page.', 'puremag' ),
    'before_widget' => '<div id="%1$s" class="puremag-main-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="puremag-widget-title">',
    'after_title' => '</h2>'));

register_sidebar(array(
    'id' => 'puremag-home-bottom-widgets',
    'name' => __( 'Bottom Widgets (Home Page Only)', 'puremag' ),
    'description' => __( 'This widget area is located at the bottom of homepage.', 'puremag' ),
    'before_widget' => '<div id="%1$s" class="puremag-main-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="puremag-widget-title">',
    'after_title' => '</h2>'));

register_sidebar(array(
    'id' => 'puremag-bottom-widgets',
    'name' => __( 'Bottom Widgets (Every Page)', 'puremag' ),
    'description' => __( 'This widget area is located at the bottom of every page.', 'puremag' ),
    'before_widget' => '<div id="%1$s" class="puremag-main-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="puremag-widget-title">',
    'after_title' => '</h2>'));

register_sidebar(array(
    'id' => 'puremag-footer-1',
    'name' => __( 'Footer 1', 'puremag' ),
    'description' => __( 'This sidebar is located on the left bottom of web page.', 'puremag' ),
    'before_widget' => '<div id="%1$s" class="puremag-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="puremag-widget-title">',
    'after_title' => '</h2>'));

register_sidebar(array(
    'id' => 'puremag-footer-2',
    'name' => __( 'Footer 2', 'puremag' ),
    'description' => __( 'This sidebar is located on the middle bottom of web page.', 'puremag' ),
    'before_widget' => '<div id="%1$s" class="puremag-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="puremag-widget-title">',
    'after_title' => '</h2>'));

register_sidebar(array(
    'id' => 'puremag-footer-3',
    'name' => __( 'Footer 3', 'puremag' ),
    'description' => __( 'This sidebar is located on the middle bottom of web page.', 'puremag' ),
    'before_widget' => '<div id="%1$s" class="puremag-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="puremag-widget-title">',
    'after_title' => '</h2>'));

register_sidebar(array(
    'id' => 'puremag-footer-4',
    'name' => __( 'Footer 4', 'puremag' ),
    'description' => __( 'This sidebar is located on the right bottom of web page.', 'puremag' ),
    'before_widget' => '<div id="%1$s" class="puremag-footer-widget widget %2$s">',
    'after_widget' => '</div>',
    'before_title' => '<h2 class="puremag-widget-title">',
    'after_title' => '</h2>'));

}
add_action( 'widgets_init', 'puremag_widgets_init' );