<?php
function puremag_social_profiles($wp_customize) {

    $wp_customize->add_section( 'sc_puremag_sociallinks', array( 'title' => esc_html__( 'Social Links', 'puremag' ), 'panel' => 'puremag_main_options_panel', 'priority' => 400, ));

    $wp_customize->add_setting( 'puremag_options[hide_social_buttons]', array( 'default' => false, 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_checkbox', ) );

    $wp_customize->add_control( 'puremag_hide_social_buttons_control', array( 'label' => esc_html__( 'Hide Social Buttons', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[hide_social_buttons]', 'type' => 'checkbox', ) );

    $wp_customize->add_setting( 'puremag_options[twitterlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_twitterlink_control', array( 'label' => esc_html__( 'Twitter URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[twitterlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[facebooklink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_facebooklink_control', array( 'label' => esc_html__( 'Facebook URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[facebooklink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[googlelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) ); 

    $wp_customize->add_control( 'puremag_googlelink_control', array( 'label' => esc_html__( 'Google Plus URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[googlelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[pinterestlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_pinterestlink_control', array( 'label' => esc_html__( 'Pinterest URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[pinterestlink]', 'type' => 'text' ) );
    
    $wp_customize->add_setting( 'puremag_options[linkedinlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_linkedinlink_control', array( 'label' => esc_html__( 'Linkedin Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[linkedinlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[instagramlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_instagramlink_control', array( 'label' => esc_html__( 'Instagram Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[instagramlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[flickrlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_flickrlink_control', array( 'label' => esc_html__( 'Flickr Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[flickrlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[youtubelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_youtubelink_control', array( 'label' => esc_html__( 'Youtube URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[youtubelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[vimeolink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_vimeolink_control', array( 'label' => esc_html__( 'Vimeo URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[vimeolink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[soundcloudlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_soundcloudlink_control', array( 'label' => esc_html__( 'Soundcloud URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[soundcloudlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[lastfmlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_lastfmlink_control', array( 'label' => esc_html__( 'Lastfm URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[lastfmlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[githublink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_githublink_control', array( 'label' => esc_html__( 'Github URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[githublink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[bitbucketlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_bitbucketlink_control', array( 'label' => esc_html__( 'Bitbucket URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[bitbucketlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[tumblrlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_tumblrlink_control', array( 'label' => esc_html__( 'Tumblr URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[tumblrlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[digglink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_digglink_control', array( 'label' => esc_html__( 'Digg URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[digglink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[deliciouslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_deliciouslink_control', array( 'label' => esc_html__( 'Delicious URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[deliciouslink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[stumblelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_stumblelink_control', array( 'label' => esc_html__( 'Stumbleupon Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[stumblelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[redditlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_redditlink_control', array( 'label' => esc_html__( 'Reddit Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[redditlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[dribbblelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_dribbblelink_control', array( 'label' => esc_html__( 'Dribbble Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[dribbblelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[behancelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_behancelink_control', array( 'label' => esc_html__( 'Behance Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[behancelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[codepenlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_codepenlink_control', array( 'label' => esc_html__( 'Codepen Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[codepenlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[jsfiddlelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_jsfiddlelink_control', array( 'label' => esc_html__( 'JSFiddle Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[jsfiddlelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[stackoverflowlink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_stackoverflowlink_control', array( 'label' => esc_html__( 'Stack Overflow Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[stackoverflowlink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[stackexchangelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_stackexchangelink_control', array( 'label' => esc_html__( 'Stack Exchange Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[stackexchangelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[bsalink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_bsalink_control', array( 'label' => esc_html__( 'BuySellAds Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[bsalink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[slidesharelink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_slidesharelink_control', array( 'label' => esc_html__( 'SlideShare Link', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[slidesharelink]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[skypeusername]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'sanitize_text_field' ) );

    $wp_customize->add_control( 'puremag_skypeusername_control', array( 'label' => esc_html__( 'Skype Username', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[skypeusername]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[emailaddress]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'puremag_sanitize_email' ) );

    $wp_customize->add_control( 'puremag_emailaddress_control', array( 'label' => esc_html__( 'Email Address', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[emailaddress]', 'type' => 'text' ) );

    $wp_customize->add_setting( 'puremag_options[rsslink]', array( 'default' => '', 'type' => 'option', 'capability' => 'edit_theme_options', 'sanitize_callback' => 'esc_url_raw' ) );

    $wp_customize->add_control( 'puremag_rsslink_control', array( 'label' => esc_html__( 'RSS Feed URL', 'puremag' ), 'section' => 'sc_puremag_sociallinks', 'settings' => 'puremag_options[rsslink]', 'type' => 'text' ) );

}