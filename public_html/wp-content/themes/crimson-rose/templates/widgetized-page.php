<?php
/**
 * Template Name: Widgetized Page
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

get_header(); ?>

	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>

		<?php dynamic_sidebar( 'widgetized-page' ); ?>

	<?php endwhile; ?>

<?php
get_footer();
