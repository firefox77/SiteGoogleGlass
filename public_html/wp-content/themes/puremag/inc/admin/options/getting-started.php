<?php
function puremag_getting_started($wp_customize) {

    $wp_customize->add_section( 'sc_puremag_getting_started', array( 'title' => esc_html__( 'Getting Started', 'puremag' ), 'description' => __( 'Thanks for your interest in PureMag! If you have any questions or run into any trouble, please visit us the following links. We will get you fixed up!', 'puremag' ), 'panel' => 'puremag_main_options_panel', 'priority' => 5, ) );

    $wp_customize->add_setting( 'puremag_options[documentation]', array( 'default' => '', 'sanitize_callback' => '__return_false', ) );

    $wp_customize->add_control( new PureMag_Customize_Button_Control( $wp_customize, 'puremag_documentation_control', array( 'label' => esc_html__( 'Documentation', 'puremag' ), 'section' => 'sc_puremag_getting_started', 'settings' => 'puremag_options[documentation]', 'type' => 'button', 'button_tag' => 'a', 'button_class' => 'button button-primary', 'button_href' => 'https://themesdna.com/puremag-wordpress-theme/', 'button_target' => '_blank', ) ) );

    $wp_customize->add_setting( 'puremag_options[contact]', array( 'default' => '', 'sanitize_callback' => '__return_false', ) );

    $wp_customize->add_control( new PureMag_Customize_Button_Control( $wp_customize, 'puremag_contact_control', array( 'label' => esc_html__( 'Contact Us', 'puremag' ), 'section' => 'sc_puremag_getting_started', 'settings' => 'puremag_options[contact]', 'type' => 'button', 'button_tag' => 'a', 'button_class' => 'button button-primary', 'button_href' => 'https://themesdna.com/contact/', 'button_target' => '_blank', ) ) );

}