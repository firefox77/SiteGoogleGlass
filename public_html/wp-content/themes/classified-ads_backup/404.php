<?php
/**
 * The template for displaying 404 pages (not found)
 */
?>
<?php get_header(); ?>

	<main id="main" role="main">

		<section>

			<article>

				<h1 id="post-title"><?php _e('404 - Page not found', 'classified-ads'); ?></h1>			
				<p><?php _e('It seems we cannot find what you are looking for? Perhaps try searching.', 'classified-ads'); ?></p>
				<?php get_search_form(); ?>

			</article>

		</section>

<?php get_sidebar(); ?>

	</main>

<?php get_footer(); ?>