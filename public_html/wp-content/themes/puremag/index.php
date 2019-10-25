<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package PureMag
 */

get_header(); ?>

<div class="puremag-main-wrapper clearfix" id="puremag-main-wrapper" role="main">
<div class="theiaStickySidebar">

<?php if(is_home() && !is_paged()) { ?>
<div class="puremag-featured-posts-area clearfix">
<?php dynamic_sidebar( 'puremag-home-top-widgets' ); ?>
</div>
<?php } ?>

<div class="puremag-featured-posts-area clearfix">
<?php dynamic_sidebar( 'puremag-top-widgets' ); ?>
</div>

<div class="puremag-posts-wrapper" id="puremag-posts-wrapper">

<div class="puremag-posts">
<h1 class="puremag-posts-heading"><?php esc_html_e( 'Recent Posts', 'puremag' ); ?></h1>
<div class="puremag-posts-content">

<?php if (have_posts()) : ?>

    <div class="puremag-posts-container">
    <?php while (have_posts()) : the_post(); ?>

        <?php get_template_part( 'template-parts/content', puremag_post_style() ); ?>

    <?php endwhile; ?>
    </div>
    <div class="clear"></div>

    <?php puremag_posts_navigation(); ?>

<?php else : ?>

  <?php get_template_part( 'template-parts/content', 'none' ); ?>

<?php endif; ?>

</div>
</div>

</div><!--/#puremag-posts-wrapper -->

<?php if(is_home() && !is_paged()) { ?>
<div class='puremag-featured-posts-area clearfix'>
<?php dynamic_sidebar( 'puremag-home-bottom-widgets' ); ?>
</div>
<?php } ?>

<div class='puremag-featured-posts-area clearfix'>
<?php dynamic_sidebar( 'puremag-bottom-widgets' ); ?>
</div>

</div>
</div><!-- /#puremag-main-wrapper -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>