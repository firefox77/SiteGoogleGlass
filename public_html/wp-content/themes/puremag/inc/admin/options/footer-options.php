<?php
function puremag_footer_options($wp_customize) {

    $wp_customize->add_section( 'sc_puremag_footer', array( 'title' => esc_html__( 'Footer', 'puremag' ), 'panel' => 'puremag_main_options_panel', 'priority' => 440 ) );

    $wp_customize->add_setting( 'puremag_options[footer_text]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_html', ) );

    $wp_customize->add_control( 'puremag_footer_text_control', array( 'label' => esc_html__( 'Footer copyright notice', 'puremag' ), 'section' => 'sc_puremag_footer', 'settings' => 'puremag_options[footer_text]', 'type' => 'text', ) );

}