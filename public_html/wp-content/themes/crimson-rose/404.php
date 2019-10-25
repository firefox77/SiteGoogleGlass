<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

global $crimson_rose;
get_header();

$error_page_id = $crimson_rose['404_custom_page'];
?>

<?php if ( 0 !== $error_page_id ) : ?>

	<?php
	$post = get_post( $error_page_id );
	setup_postdata( $post );
	$error_thumbnail     = get_the_post_thumbnail_url( $error_page_id, 'full' );
	$error_cover_opacity = $crimson_rose['404_cover_opacity'] / 100;
	$error_cover_color   = $crimson_rose['404_cover_color'];
	?>

	<div class="page-cover-bg" style="background-image:url('<?php echo esc_url( $error_thumbnail ); ?>');">
		<span class="cover"></span>
	</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section id="post-<?php the_ID(); ?>" <?php post_class( 'error-404 not-found has-background' ); ?>>
				<?php if ( crimson_rose_display_header() ) : ?>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .entry-header -->
				<?php endif; ?>

				<div class="entry-content">
					<?php remove_filter( 'the_content', 'sharing_display', 19 ); ?>
					<?php remove_filter( 'the_excerpt', 'sharing_display', 19 ); ?>
					<?php the_content(); ?>
				</div><!-- .entry-content -->

				<?php if ( get_edit_post_link() ) : ?>
					<footer class="entry-footer">
						<?php
							edit_post_link(
								sprintf(
									'%1$s <span class="screen-reader-text">%2$s</span>',
									esc_html__( 'Edit', 'crimson-rose' ),
									get_the_title()
								),
								'<div class="entry-footer-meta"><span class="edit-link">',
								'</span></div>'
							);
						?>
					</footer><!-- .entry-footer -->
				<?php endif; ?>
			</section><!-- #post-<?php the_ID(); ?> -->

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php wp_reset_postdata(); ?>

<?php else : ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'crimson-rose' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'crimson-rose' ); ?></p>

					<?php
						get_search_form();
						the_widget( 'WP_Widget_Recent_Posts' );
					?>

					<div class="widget widget_categories">
						<h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'crimson-rose' ); ?></h2>
						<ul>
						<?php
							wp_list_categories(
								array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								)
							);
						?>
						</ul>
					</div><!-- .widget -->

					<?php

						/* translators: %1$s: smiley */
						$archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'crimson-rose' ), convert_smilies( ':)' ) ) . '</p>';
						the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );

						the_widget( 'WP_Widget_Tag_Cloud' );
					?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php endif; ?>

<?php
get_footer();
