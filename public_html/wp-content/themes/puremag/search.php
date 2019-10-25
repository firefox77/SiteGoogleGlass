<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package PureMag
 */

get_header(); ?>

<div class="puremag-main-wrapper clearfix" id="puremag-main-wrapper" role="main">
<div class="theiaStickySidebar">

<div class="puremag-featured-posts-area clearfix">
<?php dynamic_sidebar( 'puremag-top-widgets' ); ?>
</div>

<div class="puremag-posts-wrapper" id="puremag-posts-wrapper">

<div class="puremag-posts">

<header class="page-header">
<h1 class="page-title"><?php /* translators: %s: search query. */ printf( esc_html__( 'Search Results for: %s', 'puremag' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
</header>

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

<div class='puremag-featured-posts-area clearfix'>
<?php dynamic_sidebar( 'puremag-bottom-widgets' ); ?>
</div>

</div>
</div><!-- /#puremag-main-wrapper -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>