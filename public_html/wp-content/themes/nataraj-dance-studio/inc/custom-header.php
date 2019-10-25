<?php
/**
 * Custom header implementation
 */

function nataraj_dance_studio_custom_header_setup() {

	add_theme_support( 'custom-header', apply_filters( 'nataraj_dance_studio_custom_header_args', array(

		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1600,
		'height'                 => 400,
		'wp-head-callback'       => 'nataraj_dance_studio_header_style',
	) ) );
}

add_action( 'after_setup_theme', 'nataraj_dance_studio_custom_header_setup' );

if ( ! function_exists( 'nataraj_dance_studio_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see nataraj_dance_studio_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'nataraj_dance_studio_header_style' );
function nataraj_dance_studio_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$custom_css = "
        #header,.page-template-custom-home-page #header .main-top{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
		}";
	   	wp_add_inline_style( 'nataraj-dance-studio-basic-style', $custom_css );
	endif;
}
endif; // nataraj_dance_studio_header_style
