<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Crimson_Rose 1.01
 *
 * @param array $classes
 * @return array
 */
function crimson_rose_body_classes( $classes ) {
	global $crimson_rose;

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Sidebar.
	if ( crimson_rose_display_sidebar() ) {
		$classes[] = 'display-sidebar';
	} elseif ( crimson_rose_display_fullwidth() ) {
		$classes[] = 'display-fullwidth';
		$classes[] = 'no-sidebar';
	} else {
		$classes[] = 'no-sidebar';
	}

	// Footer.
	if ( crimson_rose_display_sidebar_footer() ) {
		$classes[] = 'display-sidebar-footer';
	}

	// Widgetized Pages.
	if ( is_page_template( 'templates/widgetized-page.php' ) ) {
		$classes[] = 'widgetized-page';
	}

	if ( $crimson_rose['show_menu_arrows'] ) {
		$classes[] = 'show-menu-arrows';
	}

	if ( $crimson_rose['archive_title_light'] ) {
		$classes[] = 'archive-title-light';
	}

	if ( $crimson_rose['footer_text_light'] ) {
		$classes[] = 'footer-text-light';
	}

	if ( $crimson_rose['shop_truncate_titles'] ) {
		$classes[] = 'woocommerce-shop-truncate-titles';
	}

	if ( $crimson_rose['jetpack_hide_share_count'] ) {
		$classes[] = 'jetpack-hide-share-count';
	}

	if ( $crimson_rose['header_background_image_color'] ) {
		$classes[] = 'header-background-image-color-' . esc_attr( $crimson_rose['header_background_image_color'] );
	}

	if ( $crimson_rose['footer_background_image_color'] ) {
		$classes[] = 'footer-background-image-color-' . esc_attr( $crimson_rose['footer_background_image_color'] );
	}

	if ( crimson_rose_is_woocommerce_activated() ) {
		if ( is_shop() ) {
			$classes[] = 'woocommerce-shop';
			$classes[] = 'woocommerce-shop-columns-' . esc_attr( $crimson_rose['shop_columns'] );
		} elseif ( is_product_taxonomy() ) {
			$classes[] = 'woocommerce-shop-columns-' . esc_attr( $crimson_rose['shop_archive_columns'] );
		} elseif ( is_product() ) {
			$classes[] = 'woocommerce-shop-columns-' . esc_attr( $crimson_rose['shop_related_products_columns'] );
		}

		if ( $crimson_rose['shop_image_backdrop'] ) {
			$classes[] = 'woocommerce-shop-image-backdrop';
		}
	}

	if ( crimson_rose_display_header_image() ) {
		$classes[] = 'has-post-thumbnail';
	}

	if ( is_404() ) {
		if ( 0 !== $crimson_rose['404_custom_page'] ) {
			$classes[] = 'has-custom-404-page';
		}
	}

	return $classes;
}
add_filter( 'body_class', 'crimson_rose_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'crimson_rose_pingback_header' );

/**
 * Add retina src image to custom logo
 *
 * @since Crimson_Rose 1.01
 *
 * @param string $html
 * @param int    $blog_id
 * @return string
 */
function crimson_rose_get_custom_logo( $html, $blog_id ) {
	global $crimson_rose;

	if ( is_customize_preview() || is_preview() ) {
		// fixes obscure bug when admin panel is ssl and front end is not ssl.
		$crimson_rose['custom_logo_2x'] = preg_replace( '/^https?:/', '', $crimson_rose['custom_logo_2x'] );
	}

	if ( ! empty( $crimson_rose['custom_logo_2x'] ) ) {
		if ( preg_match( '/srcset=(\'|\").*?(\'|\")/', $html ) ) {
			$html = preg_replace( '/srcset=(\'|\").*?(\'|\")/', 'srcset="' . esc_url( $crimson_rose['custom_logo_2x'] ) . ' 2x"', $html );
		} else {
			$html = preg_replace( '/(src=(\'|\").*?(\'|\"))/', '\\1 srcset="' . esc_url( $crimson_rose['custom_logo_2x'] ) . ' 2x"', $html );
		}
	}

	return $html;
}
add_filter( 'get_custom_logo', 'crimson_rose_get_custom_logo', 10, 2 );

/**
 * Add "read more" link on all excerpts.
 *
 * @since Crimson_Rose 1.01
 *
 * @param string $output
 * @return string Appended "Read More" link
 */
function crimson_rose_read_more_link( $output ) {
	global $crimson_rose;

	if ( ! is_home() && ! is_archive() && ! is_search() ) {
		return $output;
	}

	$class = '';

	if ( empty( $output ) ) {
		$class = ' no-excerpt';
	}

	return $output . sprintf(
		' <a class="more-link%1$s" href="%2$s">%3$s<i class="genericons-neue genericons-neue-next"></i></a>',
		esc_attr( $class ),
		esc_url( get_permalink( get_the_ID() ) ),
		esc_html( $crimson_rose['read_more_label'] )
	);
}
add_filter( 'the_excerpt', 'crimson_rose_read_more_link' );

/**
 * Conditional display of read more text.
 *
 * @since Crimson_Rose 1.01
 *
 * @return string
 */
function crimson_rose_read_more_text() {
	global $crimson_rose;

	if ( 'post' != get_post_type() ) {
		return '';
	}

	return esc_html( $crimson_rose['read_more_label'] );
}
add_filter( 'crimson_rose_read_more_text', 'crimson_rose_read_more_text' );

/**
 * Convert single link line to button.
 *
 * @since Crimson_Rose 1.01
 *
 * @param string $output
 * @param string $button_style
 * @return string
 */
function crimson_rose_button_generation( $output, $button_style ) {
	$search  = array();
	$replace = array();

	switch ( $button_style ) {
		case 'button-1':
			$button_class = ' fancy-button';
			break;
		case 'button-2':
			$button_class = ' fancy2-button';
			break;
		default:
			$button_class = '';
			break;
	}

	if ( preg_match_all( '/\<p.*?>\<a.*?\>\s*[^\<].*?\<\/a\><\/p\>/', $output, $matches ) ) {
		foreach ( $matches as $match ) {
			foreach ( $match as $html ) {
				if ( ! preg_match( '/class\=\"|\'/', $html ) ) {
					$search[]  = $html;
					$replace[] = str_replace( '<a', '<a class="theme-generated-button button' . esc_attr( $button_class ) . '"', $html );
				}
			}
		}
	}

	if ( ! empty( $search ) ) {
		$output = str_replace( $search, $replace, $output );
	}

	return $output;
}

/**
 * Parse content, and convert single link line to button.
 *
 * @since Crimson_Rose 1.01
 *
 * @param string $output
 * @return string
 */
function crimson_rose_the_content( $output ) {
	global $crimson_rose;

	$post_type = get_post_type();

	if ( 'post' != $post_type && 'page' != $post_type && 'product' != $post_type ) {
		return $output;
	}

	$output = crimson_rose_button_generation( $output, $crimson_rose['default_button_style'] );

	return $output;

}
add_filter( 'the_content', 'crimson_rose_the_content', 11 );

/**
 * Filter the except length to specified characters.
 *
 * @since Crimson_Rose 1.01
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function crimson_rose_custom_excerpt_length( $length ) {
	return 80;
}
add_filter( 'excerpt_length', 'crimson_rose_custom_excerpt_length', 999 );

/**
 * Custom display of archive title
 *
 * @since Crimson_Rose 1.01
 *
 * @param string $title
 * @return string
 */
function crimson_rose_get_the_archive_title( $title ) {
	$pieces = explode( ': ', $title );

	if ( sizeof( $pieces ) == 2 ) {
		$title = '<span class="archive-type">' . implode( '</span><span class="archive-title">', $pieces ) . '</span>';
	} else {
		$title = '<span class="archive-type">' . $title . '</span>';
	}

	return $title;
}
add_filter( 'get_the_archive_title', 'crimson_rose_get_the_archive_title', 11, 1 );
