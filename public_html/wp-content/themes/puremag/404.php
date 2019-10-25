<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package PureMag
 */

get_header(); ?>

<div class='puremag-main-wrapper clearfix' id='puremag-main-wrapper' role='main'>
<div class='theiaStickySidebar'>

<div class='puremag-posts-wrapper' id='puremag-posts-wrapper'>

<div class='puremag-posts'>

<header class="page-header">
    <h1 class="page-title"><?php esc_html_e( 'Oops! That page can not be found.', 'puremag' ); ?></h1>
</header><!-- .page-header -->

<div class='puremag-posts-content'>

    <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'puremag' ); ?></p>
    <?php get_search_form(); ?>

    <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
    
    <div>
        <h2><?php esc_html_e( 'Most Used Categories', 'puremag' ); ?></h2>
        <ul>
        <?php
                wp_list_categories( array(
                        'orderby'    => 'count',
                        'order'      => 'DESC',
                        'show_count' => 1,
                        'title_li'   => '',
                        'number'     => 10,
                ) );
        ?>
        </ul>
    </div>

    <?php
        /* translators: %1$s: smiley */
        $archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'puremag' ), convert_smilies( ':)' ) ) . '</p>';
        the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
    ?>

    <?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

</div>

</div>

</div><!--/#puremag-posts-wrapper -->

</div>
</div><!-- /#puremag-main-wrapper -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>