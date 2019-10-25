<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! function_exists( 'crimson_rose_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	function crimson_rose_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'crimson_rose_entry_header' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @param string $delimeter
	 * @return void
	 */
	function crimson_rose_entry_header( $delimeter = '' ) {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( $delimeter, 'crimson-rose' );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">%1$s</span>', $categories_list ); // WPCS: XSS OK.
			}
		}
	}
endif;

if ( ! function_exists( 'crimson_rose_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	function crimson_rose_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$byline = sprintf(
				/* translators: %s: post author. */
				esc_html_x( 'By %s', 'post author', 'crimson-rose' ),
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
			);
			echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'crimson-rose' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'In %1$s', 'crimson-rose' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'crimson-rose' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'crimson-rose' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
				comments_popup_link(
					esc_html__( 'Leave a Comment', 'crimson-rose' )
				);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				'%1$s <span class="screen-reader-text">%2$s</span>',
				esc_html__( 'Edit', 'crimson-rose' ),
				get_the_title()
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'crimson_rose_the_term_description' ) ) :
	/**
	 * Display term description
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	function crimson_rose_the_term_description() {
		$description = term_description();
		?>

		<?php if ( ! empty( $description ) ) : ?>
			<div class="term-description">
				<?php echo $description; /* WPCS: XSS OK. HTML output. */ ?>
			</div>
		<?php endif; ?>

		<?php
	}
endif;

if ( ! function_exists( 'crimson_rose_mobile_menu_button' ) ) :
	/**
	 * Display mobile menu button
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	function crimson_rose_mobile_menu_button() {
		global $crimson_rose;

		?>
		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
			<?php if ( empty( $crimson_rose['mobile_menu_label'] ) ) : ?>
				<span class="menu-label menu-label-empty"></span>
			<?php else : ?>
				<span class="menu-label"><?php echo esc_html( $crimson_rose['mobile_menu_label'] ); ?></span>
			<?php endif; ?>
			<i class="genericons-neue"></i>
		</button>
		<?php
	}
endif;

if ( ! function_exists( 'crimson_rose_get_the_attachment' ) ) :
	/**
	 * Display attachment image
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return string
	 */
	function crimson_rose_get_the_attachment() {
		if ( wp_attachment_is( 'video' ) ) {
			$meta = wp_get_attachment_metadata( get_the_ID() );
			$atts = array( 'src' => wp_get_attachment_url() );
			if ( ! empty( $meta['width'] ) && ! empty( $meta['height'] ) ) {
				$atts['width']  = (int) $meta['width'];
				$atts['height'] = (int) $meta['height'];
			}
			if ( has_post_thumbnail() ) {
				$atts['poster'] = wp_get_attachment_url( get_post_thumbnail_id() );
			}
			$p = wp_video_shortcode( $atts );
		} elseif ( wp_attachment_is( 'audio' ) ) {
			$p = wp_audio_shortcode( array( 'src' => wp_get_attachment_url() ) );
		} else {
			// show the medium sized image representation of the attachment if available, and link to the raw file.
			$image_size = apply_filters( 'crimson_rose_attachment_size', 'large' );
			$p          = wp_get_attachment_link( 0, $image_size, false );
		}

		return $p;
	}
endif;

if ( ! function_exists( 'crimson_rose_the_attachment' ) ) :
	/**
	 * Display attachment image wrapper
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	function crimson_rose_the_attachment() {
		echo crimson_rose_get_the_attachment(); /* WPCS: XSS OK. HTML output. */
	}
endif;

if ( ! function_exists( 'crimson_rose_featured_post_navigation' ) ) :
	/**
	 * Display post navigation.
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	function crimson_rose_featured_post_navigation() {
		global $crimson_rose;

		if ( $crimson_rose['blog_single_hide_post_navigation'] ) {
			return;
		}

		// remove filter to keep featured images on post navigation.
		if ( function_exists( 'jetpack_featured_images_remove_post_thumbnail' ) ) {
			remove_filter( 'get_post_metadata', 'jetpack_featured_images_remove_post_thumbnail', true, 4 );
		}

		$prev_text = $next_text = '';

		// Previous/next post navigation.
		if ( $next_post = get_next_post() ) {
			$next_text .= get_the_post_thumbnail( $next_post->ID, 'thumbnail' );
		}

		if ( $previous_post = get_previous_post() ) {
			$prev_text .= get_the_post_thumbnail( $previous_post->ID, 'thumbnail' );
		}

		$next_text .= '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Next', 'crimson-rose' ) . '</span> ' .
			'<span class="screen-reader-text">' . esc_html__( 'Next post:', 'crimson-rose' ) . '</span> ' .
			'<span class="post-title">%title</span>';

		$prev_text .= '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Previous', 'crimson-rose' ) . '</span> ' .
			'<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'crimson-rose' ) . '</span> ' .
			'<span class="post-title">%title</span>';

		the_post_navigation(
			array(
				'next_text' => $next_text,
				'prev_text' => $prev_text,
			)
		);
	}
endif;

if ( ! function_exists( 'crimson_rose_parent_post_navigation' ) ) :
	/**
	 * Display parent post navigation
	 *
	 * @since Crimson_Rose 1.01
	 *
	 * @return void
	 */
	function crimson_rose_parent_post_navigation() {
		global $crimson_rose;

		$post = get_post();

		// remove filter to keep featured images on post navigation.
		if ( function_exists( 'jetpack_featured_images_remove_post_thumbnail' ) ) {
			remove_filter( 'get_post_metadata', 'jetpack_featured_images_remove_post_thumbnail', true, 4 );
		}

		$prev_text = '';

		// Previous/next post navigation.
		$parent_post_id = wp_get_post_parent_id( $post->ID );

		if ( ! $parent_post_id ) {
			return;
		}

		if ( $parent_post = get_post( $parent_post_id ) ) {
			$prev_text .= get_the_post_thumbnail( $parent_post->ID, 'thumbnail' );
		}

		$prev_text .= '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Post', 'crimson-rose' ) . '</span> ' .
			'<span class="screen-reader-text">' . esc_html__( 'Parent post:', 'crimson-rose' ) . '</span> ' .
			'<span class="post-title">%title</span>';

		the_post_navigation(
			array(
				'prev_text' => $prev_text,
			)
		);
	}
endif;
