<?php
function ts_theme_styles(){
	wp_enqueue_style('bootstrap_css', get_template_directory_uri().'assets/css/bootstrap.min.css');
	wp_enqueue_style('theme_css', get_template_directory_uri().'assets/css/style.css');
}

add_action('wp_enqueue_scripts', 'ts_theme_styles');