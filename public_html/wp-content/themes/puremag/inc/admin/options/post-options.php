<?php
function puremag_post_options($wp_customize) {

    $wp_customize->add_section( 'sc_puremag_posts', array( 'title' => esc_html__( 'Post Options', 'puremag' ), 'panel' => 'puremag_main_options_panel', 'priority' => 260 ) );

    $wp_customize->add_setting( 'puremag_options[post_style]', array( 'default' => 'list', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_post_style' ) );

    $wp_customize->add_control( 'puremag_post_style_control', array( 'label' => esc_html__( 'Non-Singular Posts Style', 'puremag' ), 'description' => __('Select the post style you want for home/categories/tags/archive/search-results pages.', 'puremag'), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[post_style]', 'type' => 'select', 'choices' => array( 'list' => __('List', 'puremag'), 'full' => __('Full', 'puremag') ) ) );

    $wp_customize->add_setting( 'puremag_options[read_more_length]', array( 'default' => 25, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_read_more_length' ) );

    $wp_customize->add_control( 'puremag_read_more_length_control', array( 'label' => esc_html__( 'Auto Post Summary Length', 'puremag' ), 'description' => __('Enter the number of words need to display in the post summary. Default is <b>25</b> words.', 'puremag'), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[read_more_length]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[read_more_text]', array( 'default' => 'Continue Reading...', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field', ) );

    $wp_customize->add_control( 'puremag_read_more_text_control', array( 'label' => esc_html__( 'Read More Text', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[read_more_text]', 'type' => 'text', ) );

    $wp_customize->add_setting( 'puremag_options[hide_posted_date]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_posted_date_control', array( 'label' => esc_html__( 'Hide Posted Date', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_posted_date]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[hide_post_author]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_post_author_control', array( 'label' => esc_html__( 'Hide Post Author', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_post_author]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[hide_post_categories]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_post_categories_control', array( 'label' => esc_html__( 'Hide Post Categories', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_post_categories]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[hide_post_tags]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_post_tags_control', array( 'label' => esc_html__( 'Hide Post Tags', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_post_tags]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[hide_comments_link]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_comments_link_control', array( 'label' => esc_html__( 'Hide Comment Link', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_comments_link]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[hide_post_edit]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_post_edit_control', array( 'label' => esc_html__( 'Hide Post Edit Link', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_post_edit]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[hide_thumbnail]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_thumbnail_control', array( 'label' => esc_html__( 'Hide Thumbnails from Every Page', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_thumbnail]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[hide_thumbnail_single]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_thumbnail_single_control', array( 'label' => esc_html__( 'Hide Thumbnails from Posts/Pages', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_thumbnail_single]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[hide_post_snippet]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_post_snippet_control', array( 'label' => esc_html__( 'Hide Post Snippet', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_post_snippet]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[hide_read_more_button]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_read_more_button_control', array( 'label' => esc_html__( 'Hide Read More Button', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_read_more_button]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[hide_author_bio_box]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_author_bio_box_control', array( 'label' => esc_html__( 'Hide Author Bio Box', 'puremag' ), 'section' => 'sc_puremag_posts', 'settings' => 'puremag_options[hide_author_bio_box]', 'type' => 'checkbox', ) );

}