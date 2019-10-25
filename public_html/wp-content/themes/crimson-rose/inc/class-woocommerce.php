<?php
/**
 * WooCommerce Class.
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Crimson_Rose_WooCommerce' ) ) :
	/**
	 * Class: WooCommerce Integration class.
	 *
	 * @since Crimson_Rose 1.01
	 */
	class Crimson_Rose_WooCommerce {
		/**
		 * __construct
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		public function __construct() {
			add_filter( 'woocommerce_product_get_image', array( $this, 'woocommerce_product_get_image' ) );

			add_action( 'wp', array( $this, 'disable_jetpack_infinite_scroll' ) );

			add_filter( 'woocommerce_pagination_args', array( $this, 'woocommerce_pagination_args' ) );
			add_filter( 'woocommerce_comment_pagination_args', array( $this, 'woocommerce_pagination_args' ) );

			add_filter( 'loop_shop_per_page', array( $this, 'loop_shop_per_page' ), 20 );

			add_filter( 'loop_shop_columns', array( $this, 'loop_columns' ) );

			add_filter( 'woocommerce_show_page_title', array( $this, 'hide_title' ) );

			add_filter( 'get_the_archive_title', array( $this, 'get_the_archive_title' ), 10, 1 );

			add_action( 'after_setup_theme', array( $this, 'woocommerce_setup' ) );

			add_action( 'wp_loaded', array( $this, 'check_features' ), 11 );

			add_action( 'wp', array( $this, 'check_image_size' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'woocommerce_enqueue' ) );

			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			add_filter( 'woocommerce_upsell_display_args', array( $this, 'related_products_args' ) );

			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

			add_action( 'woocommerce_before_main_content', array( $this, 'output_content_wrapper' ), 10 );
			add_action( 'woocommerce_after_main_content', array( $this, 'output_content_wrapper_end' ), 10 );

			add_action( 'crimson_rose_cart', array( $this, 'woocommerce_cart_dropdown' ), 10 );

			add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'woocommerce_header_cart_fragments' ) );

			add_action( 'woocommerce_before_mini_cart', array( $this, 'add_header_mini_cart' ), 10 );

			// Add header for payment info.
			add_action( 'woocommerce_review_order_before_payment', array( $this, 'before_shipping_title' ), 10 );

			add_filter( 'woocommerce_short_description', 'crimson_rose_the_content', 11 );
		}

		/**
		 * Shop image backdrop
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @param string $image
		 * @return string
		 */
		function woocommerce_product_get_image( $image ) {
			global $crimson_rose;

			if ( $crimson_rose['shop_image_backdrop'] ) {
				return '<span class="woocommerce-product-image-wrapper">' . $image . '</span>';
			}

			return $image;
		}

		/**
		 * No need for infinit scroll on WooCommerce pages.
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		function disable_jetpack_infinite_scroll() {
			if ( is_woocommerce() ) {
				remove_theme_support( 'infinite-scroll' );
			}
		}

		/**
		 * Add font icons to pagination
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @param array $args
		 * @return array
		 */
		function woocommerce_pagination_args( $args ) {
			$args['prev_text'] = '<i class="genericons-neue genericons-neue-previous"></i>';
			$args['next_text'] = '<i class="genericons-neue genericons-neue-next"></i>';

			return $args;
		}

		/**
		 * Change products per page
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @param int $cols
		 * @return int
		 */
		function loop_shop_per_page( $cols ) {
			$cols = 12;

			return $cols;
		}

		/**
		 * Add theme support
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		function woocommerce_setup() {
			// Declare WooCommerce support.
			add_theme_support(
				'woocommerce', array(
				// 'gallery_thumbnail_image_width' => 100,
				)
			);
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}

		/**
		 * Check features with user selected options from Customizer
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		function check_features() {
			global $crimson_rose;

			if ( $crimson_rose['shop_disable_gallery_zoom'] ) {
				remove_theme_support( 'wc-product-gallery-zoom' );
			}

			if ( $crimson_rose['shop_disable_gallery_lightbox'] ) {
				remove_theme_support( 'wc-product-gallery-lightbox' );
			}

			if ( $crimson_rose['shop_disable_gallery_slider'] ) {
				remove_theme_support( 'wc-product-gallery-slider' );
			}

			if ( $crimson_rose['shop_hide_stars'] ) {
				remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			}

			if ( $crimson_rose['shop_product_hide_stars'] ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			}

			if ( $crimson_rose['shop_hide_breadcrumbs'] ) {
				remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			}

			if ( $crimson_rose['shop_hide_result_count'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			}

			if ( $crimson_rose['shop_hide_catalog_ordering'] ) {
				remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			}

			if ( $crimson_rose['shop_product_hide_meta'] ) {
				remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			}

		}

		/**
		 * Change image size depending on columns
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		function check_image_size() {
			global $crimson_rose;

			if ( is_product_taxonomy() ) {
				if ( $crimson_rose['shop_archive_columns'] < 4 ) {
					add_filter( 'single_product_archive_thumbnail_size', array( $this, 'return_shop_single_image_size' ) );
					add_filter( 'subcategory_archive_thumbnail_size', array( $this, 'return_shop_single_image_size' ) );
				}
			} elseif ( is_shop() ) {
				if ( $crimson_rose['shop_columns'] < 4 ) {
					add_filter( 'single_product_archive_thumbnail_size', array( $this, 'return_shop_single_image_size' ) );
					add_filter( 'subcategory_archive_thumbnail_size', array( $this, 'return_shop_single_image_size' ) );
				}
			} elseif ( is_product() ) {
				if ( $crimson_rose['shop_related_products_columns'] < 4 ) {
					add_filter( 'single_product_archive_thumbnail_size', array( $this, 'return_shop_single_image_size' ) );
					add_filter( 'subcategory_archive_thumbnail_size', array( $this, 'return_shop_single_image_size' ) );
				}
			} else {
				add_filter( 'single_product_archive_thumbnail_size', array( $this, 'return_shop_single_image_size' ) );
				add_filter( 'subcategory_archive_thumbnail_size', array( $this, 'return_shop_single_image_size' ) );
			}
		}

		/**
		 * Change product image size
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return string
		 */
		function return_shop_single_image_size() {
			return 'shop_single';
		}

		/**
		 * Set columns depending on type of page.
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @param int $number_columns
		 * @return int
		 */
		function loop_columns( $number_columns ) {
			global $crimson_rose;

			if ( is_product_category() || is_product_taxonomy() ) {
				return $crimson_rose['shop_archive_columns'];
			}

			return $crimson_rose['shop_columns'];
		}

		/**
		 * Hide Title
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @param mixed $title
		 * @return bool
		 */
		function hide_title( $title ) {
			return false;
		}

		/**
		 * Adjust shop title
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @param string $title
		 * @return string
		 */
		function get_the_archive_title( $title ) {
			if ( is_shop() ) {
				$title = woocommerce_page_title( false );
			} elseif ( is_product_taxonomy() ) {
				$pieces = explode( ': ', $title );
				if ( sizeof( $pieces ) == 2 ) {
					$shop_page_id = wc_get_page_id( 'shop' );
					$page_title   = get_the_title( $shop_page_id );
					$page_title   = apply_filters( 'woocommerce_page_title', $page_title );

					$pieces[0] = $page_title;

					$title = implode( ': ', $pieces );

					return $title;
				}
			}

			return $title;
		}

		/**
		 * Enqueue scripts and styles
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		public function woocommerce_enqueue() {
			wp_enqueue_style( 'crimson-rose-woocommerce', get_template_directory_uri() . '/css/woocommerce.css', array( 'crimson-rose-style' ), CRIMSON_ROSE_VERSION );

			wp_enqueue_script( 'crimson-rose-woocommerce', get_template_directory_uri() . '/js/woocommerce.js', array(), CRIMSON_ROSE_VERSION, true );
		}

		/**
		 * Set related products args
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @param array $args
		 * @return array
		 */
		public function related_products_args( $args ) {
			global $crimson_rose;

			$args = array_merge(
				$args, apply_filters(
					'crimson_rose_related_products_args', array(
						'posts_per_page' => $crimson_rose['shop_related_products_columns'],
						'columns'        => $crimson_rose['shop_related_products_columns'],
					)
				)
			);

			return $args;
		}

		/**
		 * Set before content wrapper
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		public function output_content_wrapper() {
			global $crimson_rose;

			echo '<div id="primary" class="content-area"><main id="main" class="site-main">';

			if ( is_shop() && ! $crimson_rose['shop_hide_title'] ) {
				$title = woocommerce_page_title( false );
				$title = '<h1 class="h1-title">' . $title . '</h1>';
				echo $title; /* WPCS: XSS OK. HTML output. */
			}
		}

		/**
		 * Set after content wrapper
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		public function output_content_wrapper_end() {
			echo '</main></div>';
		}

		/**
		 * Add cart button dropdown
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		public function woocommerce_cart_dropdown() {
			global $woocommerce;

			$cart_subtotal = $woocommerce->cart->get_cart_subtotal();
			$link          = wc_get_cart_url();
			// $link             = get_permalink( wc_get_page_id( 'shop' ));
			$cart_items_count = $woocommerce->cart->cart_contents_count;

			$output  = '';
			$output .= '<li class="cart">';
			$output .= "<a class='cart_dropdown_link' href='" . esc_url( $link ) . "'>";
			$output .= "<i class='genericons-neue genericons-neue-cart'></i>";
			if ( 0 !== WC()->cart->get_cart_contents_count() ) {
				$output .= "<span class='alert-count'>" . intval( $cart_items_count ) . '</span>';
			}
			$output .= '</a>';
			$output .= '<ul class="woo-sub-menu woocommerce widget_shopping_cart cart_list"><li>';
			$output .= '<div class="widget_shopping_cart_content"></div>';
			$output .= '</li></ul>';
			$output .= '</li>';

			echo $output; /* WPCS: XSS OK. HTML output. */
		}

		/**
		 * Ajax update for item count in cart
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @param array $fragments
		 * @return array
		 */
		public function woocommerce_header_cart_fragments( $fragments ) {
			global $woocommerce;

			$cart_subtotal = $woocommerce->cart->get_cart_subtotal();
			$link          = wc_get_cart_url();
			// $link             = get_permalink( wc_get_page_id( 'shop' ));
			$cart_items_count = $woocommerce->cart->cart_contents_count;

			$temp = '<a class="cart_dropdown_link" href="' . esc_url( $link ) . '"><i class="genericons-neue genericons-neue-cart"></i><span class="alert-count">' . $cart_items_count . '</span></a><!--<span class="cart_subtotal">' . $cart_subtotal . '</span>-->';

			$fragments['a.cart_dropdown_link'] = $temp;

			return $fragments;
		}

		/**
		 * Add header mini cart
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		public function add_header_mini_cart() {
			global $woocommerce;
			$cart_items_count = $woocommerce->cart->cart_contents_count;

			$output = '<h3 class="widget-sub-title">' . $cart_items_count . ' ' . esc_html__( 'items in your cart', 'crimson-rose' ) . '</h3>';

			echo $output; /* WPCS: XSS OK. HTML output. */
		}

		/**
		 * Add header for payment info
		 *
		 * @since Crimson_Rose 1.01
		 *
		 * @return void
		 */
		function before_shipping_title() {
			echo '<h3 id="payment_method_heading">' . esc_html__( 'Payment info', 'crimson-rose' ) . '</h3>';
		}
	}
endif;

return new Crimson_Rose_WooCommerce();

/**
 * Show subcategory thumbnails.
 *
 * @since Crimson_Rose 1.01
 *
 * @param object $category
 * @return void
 */
function woocommerce_subcategory_thumbnail( $category ) {
	global $crimson_rose;

	$small_thumbnail_size = apply_filters( 'subcategory_archive_thumbnail_size', 'shop_catalog' );
	$dimensions           = wc_get_image_size( $small_thumbnail_size );
	$thumbnail_id         = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true );

	if ( $thumbnail_id ) {
		$image        = wp_get_attachment_image_src( $thumbnail_id, $small_thumbnail_size );
		$image        = $image[0];
		$image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, $small_thumbnail_size ) : false;
		$image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, $small_thumbnail_size ) : false;
	} else {
		$image        = wc_placeholder_img_src();
		$image_srcset = $image_sizes = false;
	}

	if ( $image ) {
		// Prevent esc_url from breaking spaces in urls for image embeds.
		// Ref: https://core.trac.wordpress.org/ticket/23605.
		$image = str_replace( ' ', '%20', $image );

		if ( $crimson_rose['shop_image_backdrop'] ) {
			echo '<span class="woocommerce-product-image-wrapper">';
		}

		// Add responsive image markup if available.
		if ( $image_srcset && $image_sizes ) {
			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="' . esc_attr( $image_sizes ) . '" />';
		} else {
			echo '<img src="' . esc_url( $image ) . '" alt="' . esc_attr( $category->name ) . '" width="' . esc_attr( $dimensions['width'] ) . '" height="' . esc_attr( $dimensions['height'] ) . '" />';
		}

		if ( $crimson_rose['shop_image_backdrop'] ) {
			echo '</span>';
		}
	}
}
