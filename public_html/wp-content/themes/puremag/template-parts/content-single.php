<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package PureMag
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('puremag-post-singular'); ?>>

    <header class="entry-header">
        <?php if ( !(puremag_get_option('hide_post_categories')) ) { ?><?php puremag_single_cats(); ?><?php } ?>

        <?php the_title( sprintf( '<h1 class="post-title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

        <?php puremag_single_postmeta(); ?>
    </header><!-- .entry-header -->

    <div class="entry-content clearfix">
            <?php
            if ( has_post_thumbnail() ) {
                if ( !puremag_get_option('hide_thumbnail') ) {
                    if ( !puremag_get_option('hide_thumbnail_single') ) { /* translators: %s: Post title. */ ?>
                        <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( sprintf( __( 'Permanent Link to %s', 'puremag' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail('puremag-featured-image', array('class' => 'puremag-post-thumbnail-single')); ?></a>
                    <?php
                    }
                }
            }

            the_content( sprintf(
                wp_kses(
                    /* translators: %s: Name of current post. Only visible to screen readers */
                    __( 'Continue reading<span class="screen-reader-text"> "%s"</span> <span class="meta-nav">&rarr;</span>', 'puremag' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ) );

            wp_link_pages( array(
             'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'puremag' ) . '</span>',
             'after'       => '</div>',
             'link_before' => '<span>',
             'link_after'  => '</span>',
             ) );
             ?>
    </div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php if ( !(puremag_get_option('hide_post_tags')) ) { ?><?php puremag_post_tags(); ?><?php } ?>
    </footer><!-- .entry-footer -->

    <?php if ( !(puremag_get_option('hide_author_bio_box')) ) { puremag_add_author_bio_box(); } ?>

</article>