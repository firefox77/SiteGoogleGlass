<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package PureMag
 */

?>

<div id="post-<?php the_ID(); ?>" class="puremag-list-post">

    <?php if ( has_post_thumbnail() ) { ?>
    <?php if ( !(puremag_get_option('hide_thumbnail')) ) { ?>
    <div class="puremag-list-post-thumbnail">
        <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( /* translators: %s: post title */ sprintf( __( 'Permanent Link to %s', 'puremag' ), the_title_attribute( 'echo=0' ) ) ); ?>"><?php the_post_thumbnail('puremag-medium-image', array('class' => 'puremag-list-post-thumbnail-img')); ?></a>
    </div>
    <?php } ?>
    <?php } ?>

    <?php if((has_post_thumbnail()) && !(puremag_get_option('hide_thumbnail'))) { ?><div class="puremag-list-post-details"><?php } ?>
    <?php if(!(has_post_thumbnail()) || (puremag_get_option('hide_thumbnail'))) { ?><div class="puremag-list-post-details-full"><?php } ?>

    <?php if ( !(puremag_get_option('hide_post_categories')) ) { ?><?php puremag_list_cats(); ?><?php } ?>

    <?php the_title( sprintf( '<h3 class="puremag-list-post-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>

    <?php puremag_list_postmeta(); ?>

    <?php if ( !(puremag_get_option('hide_post_snippet')) ) { ?><div class="puremag-list-post-snippet"><?php the_excerpt(); ?></div><?php } ?>

    <?php if ( !(puremag_get_option('hide_read_more_button')) ) { ?><div class='puremag-list-post-read-more'><a href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html( puremag_read_more_text() ); ?></a></div><?php } ?>

    <?php if(!(has_post_thumbnail()) || (puremag_get_option('hide_thumbnail'))) { ?></div><?php } ?>
    <?php if((has_post_thumbnail()) && !(puremag_get_option('hide_thumbnail'))) { ?></div><?php } ?>

</div>