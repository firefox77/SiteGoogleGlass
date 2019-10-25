<?php
if ( ! function_exists( 'puremag_wp_pagenavi' ) ) :
function puremag_wp_pagenavi() {
    ?>
    <nav class="navigation posts-navigation clearfix" role="navigation">
        <?php wp_pagenavi(); ?>
    </nav><!-- .navigation -->
    <?php
}
endif;

if ( ! function_exists( 'puremag_posts_navigation' ) ) :
function puremag_posts_navigation() {
    if ( function_exists( 'wp_pagenavi' ) ) {
        puremag_wp_pagenavi();
    } else {
        the_posts_navigation(array('prev_text' => __( '&larr; Older posts', 'puremag' ), 'next_text' => __( 'Newer posts &rarr;', 'puremag' )));
    }
}
endif;