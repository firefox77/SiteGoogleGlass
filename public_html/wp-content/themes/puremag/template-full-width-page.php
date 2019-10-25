<?php
/**
 * Template Name: Full Width, no sidebar
 * Template Post Type: page
*/

get_header(); ?>

<div class="puremag-main-wrapper clearfix" id="puremag-main-wrapper" role="main">
<div class="theiaStickySidebar">

<div class="puremag-posts-wrapper" id="puremag-posts-wrapper">

<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part( 'template-parts/content', 'page' ); ?>

    <?php
    // If comments are open or we have at least one comment, load up the comment template
    if ( comments_open() || get_comments_number() ) :
            comments_template();
    endif;
    ?>

<?php endwhile; ?>
<div class="clear"></div>

</div><!--/#puremag-posts-wrapper -->

</div>
</div><!-- /#puremag-main-wrapper -->

<?php get_footer(); ?>