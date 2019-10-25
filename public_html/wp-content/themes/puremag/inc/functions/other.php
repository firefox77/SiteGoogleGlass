<?php
// Get custom-logo URL
function puremag_custom_logo() {
    if ( ! has_custom_logo() ) {return;}
    $puremag_custom_logo_id = get_theme_mod( 'custom_logo' );
    $puremag_logo = wp_get_attachment_image_src( $puremag_custom_logo_id , 'full' );
    return $puremag_logo[0];
}

function puremag_read_more_text() {
       $readmoretext = __( 'Continue Reading...', 'puremag' );
        if ( puremag_get_option('read_more_text') ) {
                $readmoretext = puremag_get_option('read_more_text');
        }
       return $readmoretext;
}

// Category ids in post class
function puremag_category_id_class($classes) {
        global $post;
        foreach((get_the_category($post->ID)) as $category) {
            $classes [] = 'wpcat-' . $category->cat_ID . '-id';
        }
        return $classes;
}
add_filter('post_class', 'puremag_category_id_class');

// Change excerpt length
function puremag_excerpt_length($length) {
    if ( is_admin() ) {
        return $length;
    }
    $read_more_length = 25;
    if ( puremag_get_option('read_more_length') ) {
        $read_more_length = puremag_get_option('read_more_length');
    }
    return $read_more_length;
}
add_filter('excerpt_length', 'puremag_excerpt_length');

// Change excerpt more word
function puremag_excerpt_more($more) {
       if ( is_admin() ) {
         return $more;
       }
       return '...';
}
add_filter('excerpt_more', 'puremag_excerpt_more');

// Adds custom classes to the array of body classes.
function puremag_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'puremag-group-blog';
    }     
    if ( is_page_template( 'template-full-width-page.php' ) || !is_active_sidebar( 'puremag-main-sidebar' ) ) {
        $classes[] = 'puremag-page-full-width';
    }
    if ( is_404() ) {
        $classes[] = 'puremag-404-full-width';
    }
    return $classes;
}
add_filter( 'body_class', 'puremag_body_classes' );

function puremag_post_style() {
    $post_style = 'list';
    if ( puremag_get_option('post_style') ) {
        $post_style = puremag_get_option('post_style');
    }
    return $post_style;
}