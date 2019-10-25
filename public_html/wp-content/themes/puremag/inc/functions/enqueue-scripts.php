<?php
/**
 * Enqueue scripts and styles.
 */
function puremag_scripts() {
    wp_enqueue_style('puremag-maincss', get_stylesheet_uri(), array(), NULL);
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), NULL );

    $puremag_font_subsets_array = puremag_get_option('font_subsets');
    if($puremag_font_subsets_array) {
        $puremag_font_subsets_list = rtrim(implode(',', $puremag_font_subsets_array), ',');
        $puremag_font_subsets_list = '&amp;subset='.$puremag_font_subsets_list;
    } else {
        $puremag_font_subsets_list = '';
    }
    wp_enqueue_style('puremag-webfont', '//fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i|Domine:400,700|Oswald:400,700'.$puremag_font_subsets_list, array(), NULL);

    wp_enqueue_script('fitvids', get_template_directory_uri() .'/assets/js/jquery.fitvids.js', array( 'jquery' ), NULL, true);
    wp_enqueue_script('resizesensor', get_template_directory_uri() .'/assets/js/ResizeSensor.js', array( 'jquery' ), NULL, true);
    wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() .'/assets/js/theia-sticky-sidebar.js', array( 'jquery' ), NULL, true);
    wp_enqueue_script('puremag-customjs', get_template_directory_uri() .'/assets/js/custom.js', array( 'jquery' ), NULL, true);

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'puremag_scripts' );

/**
 * Enqueue IE compatible scripts and styles.
 */
function puremag_ie_scripts() {
    wp_enqueue_script( 'puremag-html5shiv', get_template_directory_uri(). '/assets/js/html5shiv.js', array(), NULL, false);
    wp_script_add_data( 'puremag-html5shiv', 'conditional', 'lt IE 9' );

    wp_enqueue_script( 'puremag-respond', get_template_directory_uri(). '/assets/js/respond.js', array(), NULL, false );
    wp_script_add_data( 'puremag-respond', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'puremag_ie_scripts' );

/**
 * Enqueue customizer styles.
 */
function puremag_enqueue_customizer_styles() {
    wp_enqueue_style( 'puremag-customizer-styles', get_template_directory_uri() . '/inc/admin/css/customizer-style.css', array(), NULL );
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), NULL );
}
add_action( 'customize_controls_enqueue_scripts', 'puremag_enqueue_customizer_styles' );