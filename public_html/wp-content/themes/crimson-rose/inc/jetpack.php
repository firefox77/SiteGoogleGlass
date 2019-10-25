<?php
/**
 * Jetpack Compatibility File
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
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	$footer_widgets = false;
	if ( crimson_rose_display_sidebar_footer() ) {
		$footer_widgets = true;
	}
	add_theme_support(
		'infinite-scroll', array(
			'container'      => 'main',
			'render'         => 'crimson_rose_infinite_scroll_render',
			'footer'         => 'page',
			'footer_widgets' => $footer_widgets,
		)
	);

	// Add theme support for Responsive Videos.
	add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Content Options.
	add_theme_support(
		'jetpack-content-options', array(
			'author-bio'         => true,
			'author-bio-default' => true,
			'post-details'       => array(
				'stylesheet' => 'crimson-rose-style',
				'date'       => '.posted-on,.entry-meta',
				'categories' => '.cat-links,.entry-cat-meta,.tags-links:before',
				'tags'       => '.tags-links,.tags-links + span:before',
				'author'     => '.byline,.cat-links:before',
				'comment'    => '.comments-link',
			),
			'featured-images'    => array(
				'archive' => true,
				'post'    => true,
				'page'    => true,
			),
		)
	);
}
add_action( 'after_setup_theme', 'crimson_rose_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_infinite_scroll_render() {
	crimson_rose_get_blog_part();
}

/**
 * Enqueue Jetpack Scripts
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_jetpack_enqueue() {
	wp_enqueue_style( 'crimson-rose-jetpack', get_template_directory_uri() . '/css/jetpack.css', array( 'crimson-rose-style' ), CRIMSON_ROSE_VERSION );
}
add_action( 'wp_enqueue_scripts', 'crimson_rose_jetpack_enqueue' );

/**
 * Replace footer credits for JetPack Inifite Scroll
 *
 * @since Crimson_Rose 1.01
 *
 * @return string
 */
function crimson_rose_infinite_scroll_credit() {
	$content = crimson_rose_get_site_info();

	return $content;
}
add_filter( 'infinite_scroll_credit', 'crimson_rose_infinite_scroll_credit' );

/**
 * Remove related posts. Inserting function instead in desired location.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_jetpackme_remove_rp() {
	if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
		$jprp     = Jetpack_RelatedPosts::init();
		$callback = array( $jprp, 'filter_add_target_to_dom' );
		remove_filter( 'the_content', $callback, 40 );
	}
}
add_filter( 'wp', 'crimson_rose_jetpackme_remove_rp', 20 );

/**
 * Remove share. Inserting function instead in desired location.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_jptweak_remove_share() {
	if ( ( is_single() && 'post' === get_post_type() )
		|| ( is_page() && 'page' === get_post_type() ) ) {
			remove_filter( 'the_content', 'sharing_display', 19 );
			remove_filter( 'the_excerpt', 'sharing_display', 19 );
	}
}
add_action( 'loop_start', 'crimson_rose_jptweak_remove_share' );

/**
 * Fixes bug with descripton output
 * Recommended by Jetpack support
 */
remove_filter( 'get_the_author_description', 'wpautop' );

/**
 * Customize share and prepent comment count.
 *
 * @since Crimson_Rose 1.01
 *
 * @param string $html
 * @param string $label
 * @param string $type
 * @return string
 */
function crimson_rose_jetpack_sharing_headline_html( $html, $label, $type ) {
	if ( is_single() && 'post' === get_post_type() && 'sharing' == $type ) {
		$html .= crimson_rose_get_comment_display( $label );
	}

	return $html;
}
add_filter( 'jetpack_sharing_headline_html', 'crimson_rose_jetpack_sharing_headline_html', 10, 3 );

/**
 * Display comment with share buttons
 *
 * @since Crimson_Rose 1.01
 *
 * @param string $label
 * @return string
 */
function crimson_rose_get_comment_display( $label ) {
	$html = '';

	$html .= '<div class="sd-title comment-display">';

	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

		$num_comments = get_comments_number(); /* get_comments_number returns only a numeric value. */

		if ( $num_comments == 0 ) {
			$comments = esc_html__( 'leave a Comment', 'crimson-rose' );
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . esc_html__( ' Comments', 'crimson-rose' );
		} else {
			$comments = esc_html__( '1 Comment', 'crimson-rose' );
		}
		$html .= '<a href="' . esc_url( get_comments_link() ) . '"><i class="genericons-neue genericons-neue-comment"></i>' . $comments . '</a>';
	} else {
		$html .= '<span>' . $label . '</span>';
	}

	$html .= '</div>';

	return $html;
}

/**
 * Change avatar size
 *
 * @since Crimson_Rose 1.01
 *
 * @param array $get_image_options
 * @return array
 */
function crimson_rose_custom_thumb_size( $get_image_options ) {
		$get_image_options['avatar_size'] = 128;

		return $get_image_options;
}
add_filter( 'jetpack_top_posts_widget_image_options', 'crimson_rose_custom_thumb_size' );


/**
 * Tell Jetpack that image galleries and the content width should be considered
 * larger (make it so images within image galleries don't get shown too small
 * [what tiled_gallery_content_width controls] as well as making sure the
 * sizes="(max-width:***)" doesn't pull a size smaller than desired
 * [what jetpack_content_width controls])
 *
 * @since Crimson_Rose 1.01
 *
 * @return int
 */
function crimson_rose_jetpack_overwrite_image_width() {
	return 1320; /* twice the size of normal content width. */
}
add_filter( 'tiled_gallery_content_width', 'crimson_rose_jetpack_overwrite_image_width' );
/* add_filter( 'jetpack_content_width', 'crimson_rose_jetpack_overwrite_image_width' ); */

/**
 * Add wrapper around author bio
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_jetpack_author_bio() {
	?>
	<div class="entry-author-container">
		<?php jetpack_author_bio(); ?>
	</div>
	<?php
}
