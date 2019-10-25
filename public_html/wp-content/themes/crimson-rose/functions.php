<?php
/**
 * Crimson Rose functions and definitions
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
 * The current version of the theme.
 */
define( 'CRIMSON_ROSE_VERSION', '2.20' );

if ( ! function_exists( 'crimson_rose_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	function crimson_rose_setup() {
		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Crimson Rose, use a find and replace
		 * to change 'crimson-rose' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'crimson-rose', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in four location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'crimson-rose' ),
				'menu-2' => esc_html__( 'Top Header Left', 'crimson-rose' ),
				'menu-3' => esc_html__( 'Top Header Right', 'crimson-rose' ),
				'social' => esc_html__( 'Social Menu', 'crimson-rose' ),
			)
		);

		// This theme styles the visual editor with editor-style.css to match the theme style.
		add_editor_style( array( 'css/admin/editor-style.css', get_parent_theme_file_uri() . '/fonts/lato/stylesheet.css' ) );

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background', apply_filters(
				'crimson_rose_custom_background_args', array(
					'default-color' => '#ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo', array(
				'height'      => 250,
				'width'       => 400,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array( 'site-title', 'site-description' ),
			)
		);

		/**
		 * Add support for up-sell fonts plugin
		 *
		 * @link https://webplantmedia.com/product/designer-fonts-wordpress-plugin/
		 */
		add_theme_support(
			'wpm-fonts', array(
				'logo'             => array(
					'font'      => 'Lato', /* This is a lookup value, and should not be translated. */
					'selectors' => '.site-title',
				),
				'body'             => array(
					'font'      => 'Lato', /* This is a lookup value, and should not be translated. */
					'selectors' => 'body, button, input, select, optgroup, textarea',
				),
				'heading'          => array(
					'font'      => 'Lato', /* This is a lookup value, and should not be translated. */
					'selectors' => '#master .h1, #master .h2, #master .h3, #master .h4, #master .h5, #master .h6, h1, h2, h3, h4, h5, h6',
				),
				'accent'           => array(
					'font'      => 'Mrs Saint Delafield', /* This is a lookup value, and should not be translated. */
					'selectors' => array(
						'.search .archive-page-header .page-title .archive-type',
						'.archive .archive-page-header .page-title .archive-type',
						'.site-branding .site-description',
					),
				),
				'customizer_panel' => 'theme_options',
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'crimson_rose_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @since Crimson_Rose 1.01
 *
 * @global int $content_width
 * @return void
 */
function crimson_rose_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'crimson_rose_content_width', 660 );
}
add_action( 'after_setup_theme', 'crimson_rose_content_width', 0 );

/**
 * Change content width for full site width pages.
 *
 * @since Crimson_Rose 1.01
 *
 * @global int $content_width
 * @return void
 */
function crimson_rose_content_width_check() {
	if ( crimson_rose_display_fullwidth() ) {
		$GLOBALS['content_width'] = apply_filters( 'crimson_rose_content_width', 1060 );
	}
}
add_action( 'template_redirect', 'crimson_rose_content_width_check' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 * @return void
 */
function crimson_rose_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'crimson-rose' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'crimson-rose' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 1', 'crimson-rose' ),
			'id'            => 'footer-1',
			'description'   => esc_html__( 'Add widgets here.', 'crimson-rose' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 2', 'crimson-rose' ),
			'id'            => 'footer-2',
			'description'   => esc_html__( 'Add widgets here.', 'crimson-rose' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer 3', 'crimson-rose' ),
			'id'            => 'footer-3',
			'description'   => esc_html__( 'Add widgets here.', 'crimson-rose' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer Bottom', 'crimson-rose' ),
			'id'            => 'footer-bottom',
			'description'   => esc_html__( 'Add a text or HTML widget here with your site credit and copyright information. Doing so will override the default footer credit at the bottom of your pages.', 'crimson-rose' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Instagram Gallery', 'crimson-rose' ),
			'id'            => 'gallery-1',
			'description'   => esc_html__( 'Add Instagram widget here.', 'crimson-rose' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	register_sidebar(
		array(
			'name'          => esc_html__( 'Widgetized Page', 'crimson-rose' ),
			'id'            => 'widgetized-page',
			'description'   => esc_html__( 'Add content widgets here.', 'crimson-rose' ),
			'before_widget' => '<section id="%1$s" class="content-widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title content-widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'crimson_rose_widgets_init' );

/**
 * Display customizer CSS.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_customizer_css_wrap() {
	/**
	 * Load CSS mixins
	 */
	require get_template_directory() . '/css/mixins.php';

	/**
	 * Load CSS functions
	 */
	require get_template_directory() . '/css/css-theme.php';

	$out  = '/* WP Customizer start */' . PHP_EOL;
	$out .= crimson_rose_custom_css();
	$out .= PHP_EOL . '/* WP Customizer end */';

	wp_add_inline_style( 'crimson-rose-style', $out );
}
add_action( 'wp_enqueue_scripts', 'crimson_rose_customizer_css_wrap', 20 );

/**
 * Enqueue scripts and styles.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_scripts() {
	global $crimson_rose;

	// Is up-sell designer font plugin installed and activated?
	if ( crimson_rose_is_wpm_fonts_deactivated() ) {
		if ( ! $crimson_rose['disable_body_font'] ) {
			// Add custom fonts, used in the main stylesheet.
			wp_enqueue_style( 'crimson-rose-body-font', get_parent_theme_file_uri() . '/fonts/lato/stylesheet.css', array(), CRIMSON_ROSE_VERSION );
		}

		if ( ! $crimson_rose['disable_accent_font'] ) {
			// Add custom fonts, used in the main stylesheet.
			wp_enqueue_style( 'crimson-rose-accent-font', get_parent_theme_file_uri() . '/fonts/mrs-saint-delafield/stylesheet.css', array(), CRIMSON_ROSE_VERSION );
		}
	}

	// Add genericons.
	wp_enqueue_style( 'genericons-neue', get_parent_theme_file_uri() . '/fonts/genericons-neue/genericons-neue.css', array(), CRIMSON_ROSE_VERSION );

	// Add social logos.
	wp_deregister_style( 'social-logos' ); // remove any plugins that try and use social icons, and use the themes.
	wp_enqueue_style( 'social-logos', get_parent_theme_file_uri() . '/fonts/social-logos/social-logos.css', array(), CRIMSON_ROSE_VERSION );

	// Add theme stylesheet.
	wp_enqueue_style( 'crimson-rose-style', get_stylesheet_uri() );

	// Add bxslider style.
	wp_enqueue_style( 'bx2slider', get_parent_theme_file_uri() . '/inc/vendors/bx2slider/css/jquery.bx2slider.css', array(), CRIMSON_ROSE_VERSION );

	// Register bxslider.
	wp_register_script( 'bx2slider', get_template_directory_uri() . '/inc/vendors/bx2slider/js/jquery.bx2slider.js', array( 'jquery' ), '4.2.14', true );

	// Register accordion.
	wp_enqueue_script( 'crimson-rose-accordion', get_template_directory_uri() . '/js/accordion.js', array( 'jquery' ), CRIMSON_ROSE_VERSION, true );

	// Add menu script.
	wp_enqueue_script( 'crimson-rose-navigation', get_template_directory_uri() . '/js/navigation.js', array( 'jquery' ), CRIMSON_ROSE_VERSION, true );

	// Add theme script.
	wp_enqueue_script( 'crimson-rose-theme', get_template_directory_uri() . '/js/theme.js', array( 'jquery' ), CRIMSON_ROSE_VERSION, true );

	// Helps with accessibility for keyboard only users.
	wp_enqueue_script( 'crimson-rose-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), CRIMSON_ROSE_VERSION, true );

	// Load comment script.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Load if Affiliate Royale plugin is activated.
	if ( defined( 'WAFP_VERSION' ) ) {
		wp_enqueue_style( 'crimson-rose-affiliate-royale', get_parent_theme_file_uri() . '/css/affiliate-royale.css', array(), CRIMSON_ROSE_VERSION );
	}

	// Load if Affiliate WP plugin is activated.
	if ( class_exists( 'Affiliate_WP' ) ) {
		wp_enqueue_style( 'crimson-rose-affiliate-wp', get_parent_theme_file_uri() . '/css/affiliate-wp.css', array(), CRIMSON_ROSE_VERSION );
	}

	// Load if WC SHORTCODES plugin is activated.
	if ( defined( 'WC_SHORTCODES_VERSION' ) ) {
		wp_enqueue_style( 'crimson-rose-wc-shortcodes', get_parent_theme_file_uri() . '/css/wc-shortcodes.css', array(), CRIMSON_ROSE_VERSION );
	}
}
add_action( 'wp_enqueue_scripts', 'crimson_rose_scripts' );

/**
 * Check if blog is on first page.
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_show_full_post() {
	global $paged;

	// should only show on first page.
	if ( $paged ) {
		return false;
	}

	return true;
}

/**
 * Check is h2 element exists so we can hide WooCommerce default heading element.
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_display_sub_header() {
	global $post;

	if ( preg_match( '/\<h2/', $post->post_content ) ) {
		return false;
	}

	return true;
}

/**
 * Check if h1 element exists so we can hide default page title on page.
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_display_header() {
	global $post;

	if ( preg_match( '/\<h1/', $post->post_content ) ) {
		return false;
	}

	return true;
}

/**
 * Check to load sidebar depending on page load
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_display_sidebar() {
	global $crimson_rose;

	if ( is_single() && 'post' == get_post_type() ) {
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			return false;
		}

		return $crimson_rose['display_sidebar_post'];
	}

	if ( is_home() ) {
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			return false;
		}

		return $crimson_rose['display_sidebar_blog'];
	}

	if ( crimson_rose_is_woocommerce_activated() ) {
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			return false;
		}

		if ( is_shop() ) {
			return $crimson_rose['display_sidebar_shop'];
		} elseif ( is_product_taxonomy() ) {
			return $crimson_rose['display_sidebar_shop_archive'];
		}
	}

	if ( is_search() ) {
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			return false;
		}

		return $crimson_rose['display_sidebar_search'];
	}

	if ( is_archive() ) {
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			return false;
		}

		return $crimson_rose['display_sidebar_archive'];
	}

	if ( is_attachment() ) {
		if ( ! is_active_sidebar( 'sidebar-1' ) ) {
			return false;
		}

		return $crimson_rose['display_sidebar_attachment'];
	}

	return false;
}

/**
 * Check if any footer sidebars are loaded.
 *
 * @since Crimson_Rose 1.01
 *
 * @return array 1:bool, 2:bool, 3:bool
 */
function crimson_rose_display_sidebar_footer() {
	$footer_1 = is_active_sidebar( 'footer-1' );
	$footer_2 = is_active_sidebar( 'footer-2' );
	$footer_3 = is_active_sidebar( 'footer-3' );

	if ( $footer_1 || $footer_2 || $footer_3 ) {
		return array(
			1 => $footer_1,
			2 => $footer_2,
			3 => $footer_3,
		);
	}

	return false;
}

/**
 * Check if fullwidth layout is activated
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_display_fullwidth() {
	global $crimson_rose;

	if ( crimson_rose_is_woocommerce_activated() ) {
		if ( is_woocommerce() || is_cart() || is_checkout() ) {
			return true;
		}
	}

	if ( is_page_template( 'templates/full-width-page.php' ) ) {
		return true;
	}

	return false;
}

/**
 * Check and load the correct blog template according to Customizer option.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_get_blog_part() {
	global $crimson_rose;

	if ( is_home() ) {
		get_template_part( 'template-parts/' . $crimson_rose['blog_display'] );
	} elseif ( is_archive() ) {
		get_template_part( 'template-parts/' . $crimson_rose['archive_display'] );
	} elseif ( is_search() ) {
		get_template_part( 'template-parts/' . $crimson_rose['search_display'] );
	}
}

/**
 * Additonal check to Show/Hide Featured Image outside of the loop.
 *
 * @link https://jetpack.com/support/content-options/
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_jetpack_featured_image_display() {
	if ( ! function_exists( 'jetpack_featured_images_remove_post_thumbnail' ) ) {
		return true;
	} else {
		$options         = get_theme_support( 'jetpack-content-options' );
		$featured_images = ( ! empty( $options[0]['featured-images'] ) ) ? $options[0]['featured-images'] : null;

		$settings = array(
			'post-default' => ( isset( $featured_images['post-default'] ) && false === $featured_images['post-default'] ) ? '' : 1,
			'page-default' => ( isset( $featured_images['page-default'] ) && false === $featured_images['page-default'] ) ? '' : 1,
		);

		$settings = array_merge(
			$settings, array(
				'post-option' => get_option( 'jetpack_content_featured_images_post', $settings['post-default'] ),
				'page-option' => get_option( 'jetpack_content_featured_images_page', $settings['page-default'] ),
			)
		);

		if ( ( ! $settings['post-option'] && is_single() )
			|| ( ! $settings['page-option'] && is_singular() && is_page() ) ) {
			return false;
		} else {
			return true;
		}
	}
}

/**
 * Check to see if page can display a header image using the posts
 * featured image.
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_display_header_image() {
	if ( is_page() && has_post_thumbnail() && crimson_rose_jetpack_featured_image_display() ) {
		if ( ! is_page_template( 'templates/widgetized-page.php' ) ) {
			if ( ! is_page_template( 'templates/no-featured-image-page.php' ) ) {
				return true;
			}
		}
	}

	return false;
}

/**
 * Query WooCommerce activation
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_is_woocommerce_activated() {
	return class_exists( 'woocommerce' ) ? true : false;
}

/**
 * Check Jetpack activation
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_is_jetpack_activated() {
	if ( defined( 'JETPACK__VERSION' ) ) {
		return true;
	}

	return false;
}

/**
 * Check WPM Fonts is activated
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_is_wpm_fonts_activated() {
	if ( defined( 'WPM_FONTS_VERSION' ) ) {
		return true;
	}

	return false;
}

/**
 * Check WPM Fonts id deactivated
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_is_wpm_fonts_deactivated() {
	return ! crimson_rose_is_wpm_fonts_activated();
}

/**
 * Check Crimson Rose Watercolor Backgrounds activation
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_is_watercolor_backgrounds_activated() {
	if ( defined( 'CRIMSON_ROSE_WATERCOLOR_BACKGROUNDS_VERSION' ) ) {
		return true;
	}

	return false;
}

/**
 * Check One Click Demo Import (ocdi) activation
 *
 * @since Crimson_Rose 1.01
 *
 * @return bool
 */
function crimson_rose_is_ocdi_activated() {
	return class_exists( 'OCDI_Plugin' ) ? true : false;
}

/**
 * Load Default option values.
 */
require get_template_directory() . '/inc/default-options.php';

/**
 * Load Gutenberg editor functions.
 */
require get_template_directory() . '/inc/gutenberg.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Widget Base
 */
require get_template_directory() . '/inc/class-widget.php';

/**
 * Load Each Individual Widget
 */
foreach ( glob( get_template_directory() . '/inc/widgets/*.php' ) as $filename ) {
	require_once $filename;
}

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Implement starter content.
 */
require get_template_directory() . '/inc/starter-content.php';

/**
 * Load Jetpack compatibility file.
 */
if ( crimson_rose_is_jetpack_activated() ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce class
 */
if ( crimson_rose_is_woocommerce_activated() ) {
	require get_parent_theme_file_path() . '/inc/class-woocommerce.php';
}

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path() . '/inc/icon-functions.php';

/**
 * Check for recommended plugins.
 */
require get_parent_theme_file_path() . '/inc/recommended-plugins.php';

/**
 * Add dashboard widget and info page.
 */
require get_parent_theme_file_path() . '/inc/dashboard.php';

/**
 * One Click Demo Import
 */
if ( crimson_rose_is_ocdi_activated() ) {
	require get_parent_theme_file_path() . '/inc/one-click-demo-import.php';
}
