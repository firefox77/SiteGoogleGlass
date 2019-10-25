<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package PureMag
 */

?>

<div id="post-<?php the_ID(); ?>" class="puremag-full-post">

    <?php if ( has_post_thumbnail() ) { ?>
    <?php if ( !(puremag_get_option('hide_thumbnail')) ) { ?>
    <div class="puremag-full-post-thumbnail">
        <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( /* translators: %s: post title */ sprintf( __( 'Permanent Link to %s', 'puremag' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail('puremag-featured-image', array('class' => 'puremag-full-post-thumbnail-img')); ?></a>
    </div>
    <?php } ?>
    <?php } ?>

    <?php if((has_post_thumbnail()) && !(puremag_get_option('hide_thumbnail'))) { ?><div class="puremag-full-post-details"><?php } ?>
    <?php if(!(has_post_thumbnail()) || (puremag_get_option('hide_thumbnail'))) { ?><div class="puremag-full-post-details-full"><?php } ?>

    <?php if ( !(puremag_get_option('hide_post_categories')) ) { ?><?php puremag_full_cats(); ?><?php } ?>

    <?php the_title( sprintf( '<h3 class="puremag-full-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

    <?php puremag_full_postmeta(); ?>

    <div class="puremag-full-post-snippet clearfix">
    <?php
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
     'separator'   => '',
     ) );
    ?>
    </div>

    <footer class="puremag-full-post-footer">
        <?php if ( !(puremag_get_option('hide_post_tags')) ) { ?><?php puremag_post_tags(); ?><?php } ?>
    </footer>

    <?php if(!(has_post_thumbnail()) || (puremag_get_option('hide_thumbnail'))) { ?></div><?php } ?>
    <?php if((has_post_thumbnail()) && !(puremag_get_option('hide_thumbnail'))) { ?></div><?php } ?>

</div>