<?php
function puremag_upgrade_to_pro($wp_customize) {

    $wp_customize->add_section( 'sc_puremag_upgrade', array( 'title' => esc_html__( 'Upgrade to Pro Version', 'puremag' ), 'priority' => 400 ) );
    
    $wp_customize->add_setting( 'puremag_options[upgrade_text]', array( 'default' => '', 'sanitize_callback' => '__return_false', ) );
    
    $wp_customize->add_control( new PureMag_Customize_Static_Text_Control( $wp_customize, 'puremag_upgrade_text_control', array(
        'label'       => esc_html__( 'PureMag Pro', 'puremag' ),
        'section'     => 'sc_puremag_upgrade',
        'settings' => 'puremag_options[upgrade_text]',
        'description' => esc_html__( 'Do you enjoy PureMag? Upgrade to PureMag Pro now and get:', 'puremag' ).
            '<ul class="puremag-customizer-pro-features">' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'Color Options', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'Font Options', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( '5 Different Posts Styles', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( '5 Different Featured Posts Widgets(each widget displays recent/popular/random posts or posts from a given category or tag.)', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'Social Profiles Widget and About Me Widget', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'Layout Options (full-width / content+sidebar / sidebar+content)', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'Custom Page Templates (full-width / content+sidebar / sidebar+content / sitemap)', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'Custom Post Templates (full-width / content+sidebar / sidebar+content)', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( '2 Header Layouts (full-width header or header+728x90 ad)', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'Post Share Buttons', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'Related Posts with Thumbnails', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'Author Bio Box with Social Buttons', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'WooCommerce Support', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'Search Engine Optimized', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'More Customizer options', 'puremag' ) . '</li>' .
                '<li><i class="fa fa-check"></i> ' . esc_html__( 'More Features...', 'puremag' ) . '</li>' .
            '</ul>'.
            '<strong><a href="'.PUREMAG_PROURL.'" class="button button-primary" target="_blank"><i class="fa fa-shopping-cart"></i> ' . esc_html__( 'Upgrade To PureMag PRO', 'puremag' ) . '</a></strong>'
    ) ) ); 

}