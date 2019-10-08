<?php
function ts_themes_styles(){
	wp_enqueue_style('theme_css', get_template_directory_uri().'css/theme.css');
	wp_enqueue_style('theme_css', get_template_directory_uri().'css/freelancer.css');
	wp_enqueue_style('theme_css', get_template_directory_uri().'css/freelancer.min.css');
	wp_enqueue_style('theme_css', get_template_directory_uri().'css/style.css');

	wp_enqueue_scripts('theme_js', get_template_directory_uri().'js/freelancer.js', array('jquery'), '', false);
}

add_action('wp_enqueue_scripts', 'ts_themes_styles');