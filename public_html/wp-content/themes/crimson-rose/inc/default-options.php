<?php
/**
 * Default options for Customizer
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

// Store user defined options.
$crimson_rose = array();

// Store default options.
$crimson_rose_default = array();

/**
 * Site Info Section in Customizer
 */

// Title & Tagline.
$crimson_rose_default['custom_logo_2x']         = '';
$crimson_rose_default['heading_padding_top']    = '50';
$crimson_rose_default['heading_padding_bottom'] = '50';

/**
 * Colors Section in Customizer
 */

// Colors.
$crimson_rose_default['header_background_image_color'] = 'red';
$crimson_rose_default['primary_color']                 = '#de8699';
$crimson_rose_default['primary_hover_color']           = '#d66c83';
$crimson_rose_default['archive_background_color']      = '#fcf7f7';
$crimson_rose_default['archive_title_light']           = 0;
$crimson_rose_default['footer_background_color']       = '#fcf7f7';
$crimson_rose_default['footer_background_image_color'] = 'red';
$crimson_rose_default['footer_text_light']             = 0;
$crimson_rose_default['link_color']                    = '#666666';
$crimson_rose_default['link_hover_color']              = '#d66c83';

/**
 * New Theme Options Section in Customizer
 */

// Top header.
$crimson_rose_default['top_header_background_offset'] = 460;

// Menu.
$crimson_rose_default['show_menu_arrows'] = 1;

// Site.
$crimson_rose_default['default_button_style']     = 'button-2';
$crimson_rose_default['disable_body_font']        = 0;
$crimson_rose_default['disable_heading_font']     = 0;
$crimson_rose_default['disable_accent_font']      = 0;
$crimson_rose_default['page_image_header_height'] = 400;

// Blog.
$crimson_rose_default['blog_display']                     = 'blog1';
$crimson_rose_default['archive_display']                  = 'blog1';
$crimson_rose_default['search_display']                   = 'blog2';
$crimson_rose_default['thumb_excerpt_max_height']         = 0;
$crimson_rose_default['thumb_grid_max_height']            = 0;
$crimson_rose_default['blog_single_hide_post_navigation'] = 0;
$crimson_rose_default['jetpack_hide_share_count']         = 0;

// Shop.
$crimson_rose_default['shop_columns']                  = 2;
$crimson_rose_default['shop_archive_columns']          = 3;
$crimson_rose_default['shop_related_products_columns'] = 2;
$crimson_rose_default['shop_image_backdrop']           = 0;
$crimson_rose_default['shop_hide_title']               = 1;
$crimson_rose_default['shop_hide_breadcrumbs']         = 0;
$crimson_rose_default['shop_hide_stars']               = 0;
$crimson_rose_default['shop_hide_result_count']        = 0;
$crimson_rose_default['shop_hide_catalog_ordering']    = 0;
$crimson_rose_default['shop_product_hide_stars']       = 0;
$crimson_rose_default['shop_product_hide_meta']        = 0;
$crimson_rose_default['shop_disable_gallery_zoom']     = 0;
$crimson_rose_default['shop_disable_gallery_lightbox'] = 0;
$crimson_rose_default['shop_disable_gallery_slider']   = 0;
$crimson_rose_default['shop_truncate_titles']          = 1;

// Display Sidebar.
$crimson_rose_default['display_sidebar_blog']         = 1;
$crimson_rose_default['display_sidebar_post']         = 1;
$crimson_rose_default['display_sidebar_shop']         = 0;
$crimson_rose_default['display_sidebar_archive']      = 1;
$crimson_rose_default['display_sidebar_search']       = 0;
$crimson_rose_default['display_sidebar_shop_archive'] = 0;
$crimson_rose_default['display_sidebar_attachment']   = 0;

// Labels.
$crimson_rose_default['mobile_menu_label'] = esc_html__( 'Menu', 'crimson-rose' );
$crimson_rose_default['read_more_label']   = esc_html__( 'Continue Reading', 'crimson-rose' );

// 404 Page.
$crimson_rose_default['404_custom_page']   = 0;
$crimson_rose_default['404_cover_opacity'] = 80;
$crimson_rose_default['404_cover_color']   = '#ffffff';
$crimson_rose_default['404_text_white']    = 0;

/**
 * Set default options
 *
 * Function wp_loaded gets called before template_redirect, so we can safely
 * set a custom $content_width.
 *
 * Also, if we call get_theme_mod any sooner, then we can't live preview.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_default_options() {
	global $crimson_rose_default;
	global $crimson_rose;

	foreach ( $crimson_rose_default as $key => $value ) {
		$crimson_rose[ $key ] = get_theme_mod( $key, $value );
	}
}
add_action( 'wp_loaded', 'crimson_rose_default_options' );
