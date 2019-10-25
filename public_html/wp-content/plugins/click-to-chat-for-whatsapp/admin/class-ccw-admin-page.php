<?php
/**
* content of the options page .. 
* admin_menu.php  -> settings_page.php  -> admin_page.php
*
* @package ccw
* @subpackage Administration
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'CCW_Admin_Page' ) ) :
    
class CCW_Admin_Page {

    function ccw_custom_settings() {
        
        register_setting( 'ccw_settings_group', 'ccw_options' , 'ccw_options_sanitize' );
    
        add_settings_section( 'ccw_settings', '', array( $this, 'ccw_settings_section' ), 'ccw_options_settings' );
    
        add_settings_field( 'ccw_enable', __( 'Enable Floating Styles' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_enable_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_enable_sc', __( 'Enable ShortCodes' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_enable_sc_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_return_type', __( 'Return Type' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_return_type_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_number', __( 'WhatsApp Number' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_number_input_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_pre_text', __( 'Initial Message' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_prefix_message_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_group_id', __( 'Group Id' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_group_id_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_style', __( 'Style for Desktops' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_style_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_style_mobile', __( 'Style for Mobile Devices' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_style_mobile_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_position', __( 'Position to Place' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_position_input_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_placeholder', __( 'Text to Display' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_input_placeholder_cb' ), 'ccw_options_settings', 'ccw_settings' );
        
        add_settings_field( 'ccw_google_analytics', __( 'Google Analytics' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_google_analytics_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_fb_analytics', __( 'Facebook Analytics' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_fb_analytics_cb' ), 'ccw_options_settings', 'ccw_settings' );
        
        add_settings_field( 'ccw_checkbox', __( 'Hide Based on post type' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_checkbox_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_list_id_tohide', __( 'Posts, Pages Id\'s to Hide' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_list_id_tohide_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_list_cat_tohide', __( 'Categorys to Hide' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_list_cat_tohide_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_custom_shortcode', __( 'Shortcode name' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_custom_shortcode_cb' ), 'ccw_options_settings', 'ccw_settings' );
        add_settings_field( 'ccw_app_first', __( 'App First' , 'click-to-chat-for-whatsapp' ), array( $this, 'ccw_app_first_cb' ), 'ccw_options_settings', 'ccw_settings' );
 
    }

    
    // heading
    function ccw_settings_section() {
        echo '<h1>Click to Chat For WhatsApp - Global Settings</h1>';
    }


    // enable / disable floating styles
    function ccw_enable_cb() {
        $ccw_enable = get_option('ccw_options');
        ?>
        <div class="row">
            <div class="input-field col s12">
                <select name="ccw_options[enable]" class="select-1">
                <option value="1"><?php _e( 'No' , 'click-to-chat-for-whatsapp' ) ?></option>
                <option value="2" <?php echo esc_attr( $ccw_enable['enable'] ) == 2 ? 'SELECTED' : ''; ?>  ><?php _e( 'Yes' , 'click-to-chat-for-whatsapp' ) ?></option>
                </select>
                <label><?php _e( 'enable' , 'click-to-chat-for-whatsapp' ) ?></label>
            </div>
        </div>
        <?php
    }

    // enable / disable shortcodes
    function ccw_enable_sc_cb() {
        $ccw_enable_sc = get_option('ccw_options');
        ?>
        <div class="row">
            <div class="input-field col s12 select-margin">
                <select name="ccw_options[enable_sc]" class="select-1">
                <option value="1"><?php _e( 'No' , 'click-to-chat-for-whatsapp' ) ?></option>
                <option value="2" <?php echo esc_attr( $ccw_enable_sc['enable_sc'] ) == 2 ? 'SELECTED' : ''; ?>  ><?php _e( 'Yes' , 'click-to-chat-for-whatsapp' ) ?></option>
                </select>
                <label><?php _e( 'enable ShortCodes' , 'click-to-chat-for-whatsapp' ) ?></label>
                <p class="description"> <?php _e( 'If Selected - No - then Hides Shortcodes and its syntax' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/enable-disable-styles/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
            </div>
        </div>
        <?php
    }

    // Return type  - chat or group chat
    function ccw_return_type_cb() {
        $ccw_return_type = get_option('ccw_options');
        ?>
        <div class="row">
            <div class="input-field col s12 select-margin">
                <select name="ccw_options[return_type]" class="select-1">
                <option value="chat" <?php echo esc_attr( $ccw_return_type['return_type'] ) == 'chat' ? 'SELECTED' : ''; ?> ><?php _e( 'Chat' , 'click-to-chat-for-whatsapp' ) ?></option>
                <option value="group_chat" <?php echo esc_attr( $ccw_return_type['return_type'] ) == 'group_chat' ? 'SELECTED' : ''; ?> ><?php _e( 'Group chat - Invite' , 'click-to-chat-for-whatsapp' ) ?></option>
                </select>
                <label><?php _e( 'Default return type - Chat or Group Chat Invite' , 'click-to-chat-for-whatsapp' ) ?></label>
                <p class="description"><?php _e( 'Default return type for Floating Style, shortcodes. But for shortcodes can change using shortcode attributes' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/return-type-chat-or-group-chat/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
            </div>
        </div>
        <?php
    }


    // Desktop - select style 
    function ccw_style_cb() {
        $ccw_style = get_option('ccw_options');
        $style_value = esc_attr( $ccw_style['style'] );
        ?>
        <div class="row">
            <div class="input-field col s12">
                <select name="ccw_options[style]" class="select-2">
                <option value="1" <?php echo $style_value == 1 ? 'SELECTED' : ''; ?> >Style-1</option>
                <option value="2" <?php echo $style_value == 2 ? 'SELECTED' : ''; ?> >Style-2</option>
                <option value="3" <?php echo $style_value == 3 ? 'SELECTED' : ''; ?> >Style-3</option>
                <option value="4" <?php echo $style_value == 4 ? 'SELECTED' : ''; ?> >Style-4</option>
                <option value="5" <?php echo $style_value == 5 ? 'SELECTED' : ''; ?> >Style-5</option>
                <option value="6" <?php echo $style_value == 6 ? 'SELECTED' : ''; ?> >Style-6</option>
                <option value="7" <?php echo $style_value == 7 ? 'SELECTED' : ''; ?> >Style-7</option>
                <option value="8" <?php echo $style_value == 8 ? 'SELECTED' : ''; ?> >Style-8</option>
                <option value="9" <?php echo $style_value == 9 ? 'SELECTED' : ''; ?> >Style-9</option>
                <option value="99" <?php echo $style_value == 99 ? 'SELECTED' : ''; ?> >Style-99 own Image / GIF</option>
                <option value="0" <?php echo $style_value == 0 ? 'SELECTED' : ''; ?> ><?php _e( 'Hide on Desktop Devices' , 'click-to-chat-for-whatsapp' ) ?></option>
                </select>
                <label><?php _e( 'Select Style for Destops' , 'click-to-chat-for-whatsapp' ) ?></label>
                <p class="description"> - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/select-styles/"><?php _e( 'List of syles with images' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
                <p class="description"> - <a target="_blank" href="<?php echo admin_url( 'admin.php?page=ccw-edit-styles' ); ?>"><?php _e( 'Customize Styles' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
                
            </div>
        </div>
        <?php
    }

    // Mobile - Select Style
    function ccw_style_mobile_cb() {
        $ccw_stylemobile = get_option('ccw_options');
        $style_mobile_value = esc_attr( $ccw_stylemobile['stylemobile'] );
        ?>
        <div class="row">
            <div class="input-field col s12">
                <select name="ccw_options[stylemobile]" class="select-2_2">
                <option value="1" <?php echo $style_mobile_value == 1 ? 'SELECTED' : ''; ?> >Style-1</option>
                <option value="2" <?php echo $style_mobile_value == 2 ? 'SELECTED' : ''; ?> >Style-2</option>
                <option value="3" <?php echo $style_mobile_value == 3 ? 'SELECTED' : ''; ?> >Style-3</option>
                <option value="4" <?php echo $style_mobile_value == 4 ? 'SELECTED' : ''; ?> >Style-4</option>
                <option value="5" <?php echo $style_mobile_value == 5 ? 'SELECTED' : ''; ?> >Style-5</option>
                <option value="6" <?php echo $style_mobile_value == 6 ? 'SELECTED' : ''; ?> >Style-6</option>
                <option value="7" <?php echo $style_mobile_value == 7 ? 'SELECTED' : ''; ?> >Style-7</option>
                <option value="8" <?php echo $style_mobile_value == 8 ? 'SELECTED' : ''; ?> >Style-8</option>
                <option value="9" <?php echo $style_mobile_value == 9 ? 'SELECTED' : ''; ?> >Style-9</option>
                <option value="99" <?php echo $style_mobile_value == 99 ? 'SELECTED' : ''; ?> >Style-99 own Image / GIF</option>
                <option value="0" <?php echo $style_mobile_value == 0 ? 'SELECTED' : ''; ?> ><?php _e( 'Hide on Mobile Devices' , 'click-to-chat-for-whatsapp' ) ?></option>
                </select>
                <label><?php _e( 'Select Style for Mobile Devices' , 'click-to-chat-for-whatsapp' ) ?></label>
            </div>
        </div>
        <?php
    }

    // number
    function ccw_number_input_cb() {
        $ccw_number = get_option('ccw_options');
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ccw_options[number]" value="<?php echo esc_attr( $ccw_number['number'] ) ?>" id="whatsapp_number" type="text" class="validate input-margin">
                <label for="whatsapp_number"><?php _e( 'Enter whatsapp number' , 'click-to-chat-for-whatsapp' ) ?> </label>
                <p class="description"><?php _e( 'Enter whatsapp number with country code ( e.g. 916123456789 ) please dont include +, ( here in e.g. 91 is country code 6123456789 is mobile number' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/whatsapp-number/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> ) </p>
            </div>
        </div>
        <?php
    }


    // prefix - message
    function ccw_prefix_message_cb() {
        $ccw_initial = get_option('ccw_options');
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ccw_options[initial]" value="<?php echo esc_attr( $ccw_initial['initial'] ) ?>" id="whatsapp_initial" type="text" class="validate input-margin">
                <label for="whatsapp_initial"><?php _e( 'Initial Message' , 'click-to-chat-for-whatsapp' ) ?></label>
                <p class="description"><?php _e( 'Initial message ( pre-filled ), placeholder {{url}} to add webpage url - ' , 'click-to-chat-for-whatsapp' ) ?> <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/pre-filled-message/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
            </div>
        </div>
        <?php
    }


    // Group ID
    function ccw_group_id_cb() {
        $ccw_group_id = get_option('ccw_options');
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ccw_options[group_id]" value="<?php echo esc_attr( $ccw_group_id['group_id'] ) ?>" id="whatsapp_group_id" type="text" class="validate input-margin">
                <label for="whatsapp_group_id"><?php _e( 'whatsapp group ID Extenstion' , 'click-to-chat-for-whatsapp' ) ?> </label>
                <p class="description"><?php _e( 'Enter whatsapp Group Id' , 'click-to-chat-for-whatsapp' ) ?>  - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/find-whatsapp-group-id/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> ) </p>
            </div>
        </div>
        <?php
    }

    // position
    function ccw_position_input_cb() {
        $ccw_position = get_option('ccw_options');
        $ccw_position_value = esc_attr( $ccw_position['position'] )
        ?>
        <div class="row">
            <div class="input-field col s12">
                <select name="ccw_options[position]" class="select">
                <option value="1"  <?php echo $ccw_position_value == 1 ? 'SELECTED' : ''; ?> ><?php _e( 'bottom right' , 'click-to-chat-for-whatsapp' ) ?></option>
                <option value="2"  <?php echo $ccw_position_value == 2 ? 'SELECTED' : ''; ?> ><?php _e( 'bottom left' , 'click-to-chat-for-whatsapp' ) ?></option>
                <option value="3"  <?php echo $ccw_position_value == 3 ? 'SELECTED' : ''; ?> ><?php _e( 'top left' , 'click-to-chat-for-whatsapp' ) ?></option>
                <option value="4"  <?php echo $ccw_position_value == 4 ? 'SELECTED' : ''; ?> ><?php _e( 'top right' , 'click-to-chat-for-whatsapp' ) ?></option>
                </select>
                <label><?php _e( 'Fixed position to place' , 'click-to-chat-for-whatsapp' ) ?></label>
                <p class="description"><?php _e( ' e.g. 10px - please add css units as suffix, e.g. 10px, 10%, 10rem, 10em' , 'click-to-chat-for-whatsapp' ) ?> .. <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/position-to-place/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
            </div>
        </div>

        <div class="row display-none position position-1 bottom-right">
            <div class="input-field col s6">
                <input name="ccw_options[position-1_bottom]" value="<?php echo esc_attr( $ccw_position['position-1_bottom'] ) ?>" id="position_bottom" type="text" class="validate">
                <label for="position_bottom"><?php _e( 'position_bottom' , 'click-to-chat-for-whatsapp' ) ?>: </label>
            </div>
            <div class="input-field col s6">
                <input name="ccw_options[position-1_right]" value="<?php echo esc_attr( $ccw_position['position-1_right'] ) ?>" id="position_right" type="text" class="validate">
                <label for="position_right"><?php _e( 'position_right' , 'click-to-chat-for-whatsapp' ) ?>: </label>
            </div>
        </div>

        <div class="row display-none position position-2 bottom-left">
            <div class="input-field col s6">
                <input name="ccw_options[position-2_bottom]" value="<?php echo esc_attr( $ccw_position['position-2_bottom'] ) ?>" id="position_bottom" type="text" class="validate">
                <label for="position_bottom"><?php _e( 'position_bottom' , 'click-to-chat-for-whatsapp' ) ?>: </label>
            </div>
            <div class="input-field col s6">
                <input name="ccw_options[position-2_left]" value="<?php echo esc_attr( $ccw_position['position-2_left'] ) ?>" id="position_left" type="text" class="validate">
                <label for="position_left"><?php _e( 'position_left' , 'click-to-chat-for-whatsapp' ) ?>: </label>
            </div>
        </div>



        <div class="row display-none position position-3 top-left">
            <div class="input-field col s6">
                <input name="ccw_options[position-3_top]" value="<?php echo esc_attr( $ccw_position['position-3_top'] ) ?>" id="position_top" type="text" class="validate">
                <label for="position_top"><?php _e( 'position_top' , 'click-to-chat-for-whatsapp' ) ?>: </label>
            </div>
            <div class="input-field col s6">
                <input name="ccw_options[position-3_left]" value="<?php echo esc_attr( $ccw_position['position-3_left'] ) ?>" id="position_left" type="text" class="validate">
                <label for="position_left"><?php _e( 'position_left' , 'click-to-chat-for-whatsapp' ) ?>: </label>
            </div>
        </div>

        <div class="row display-none position position-4 top-right">
            <div class="input-field col s6">
                <input name="ccw_options[position-4_top]" value="<?php echo esc_attr( $ccw_position['position-4_top'] ) ?>" id="position_top" type="text" class="validate">
                <label for="position_top"><?php _e( 'position_top' , 'click-to-chat-for-whatsapp' ) ?>: </label>
            </div>
            <div class="input-field col s6">
                <input name="ccw_options[position-4_right]" value="<?php echo esc_attr( $ccw_position['position-4_right'] ) ?>" id="position_right" type="text" class="validate">
                <label for="position_right"><?php _e( 'position_right' , 'click-to-chat-for-whatsapp' ) ?>: </label>
            </div>
        </div>

        <?php 
    }

    // Text - placeholder
    function ccw_input_placeholder_cb() {
        $ccw_placeholder = get_option('ccw_options');
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ccw_options[input_placeholder]" value="<?php echo esc_attr( $ccw_placeholder['input_placeholder'] ) ?>" id="input_placeholder" type="text" class="validate input-margin">
                <label for="input_placeholder"><?php _e( 'placeholder value' , 'click-to-chat-for-whatsapp' ) ?></label>
                <p class="description"> - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/text-to-display/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
            </div>
        </div>
        <?php
    }


    // Enable Google Analytics 
    function ccw_google_analytics_cb() {
        $ccw_google_analytics = get_option('ccw_options');


        if ( isset( $ccw_google_analytics['google_analytics'] ) ) {
            ?>
            <p>
                <input name="ccw_options[google_analytics]" type="checkbox" value="1" <?php checked( $ccw_google_analytics['google_analytics'], 1 ); ?> id="google_analytics" />
                <label for="google_analytics"><?php _e( 'Google Analytics' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <input name="ccw_options[google_analytics]" type="checkbox" value="1" id="google_analytics" />
                <label for="google_analytics"><?php _e( 'Google Analytics' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        }
        ?>
        
        <p class="description"> <?php _e( 'If Google Analytics is installed - creates an Event at there' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/google-analytics/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
        <p class="description"> <?php _e( 'Customize Event Values' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="<?php echo admin_url( 'admin.php?page=ccw-edit-styles#ga-analytics' ); ?>"><?php _e( 'Customize Styles' , 'click-to-chat-for-whatsapp' ) ?></a>  </p>
        <p class="description"> <?php _e( 'Using' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="https://www.holithemes.com/google-analytics-for-click-to-chat-for-whatsapp-plugin/"><?php _e( 'Google Tag Manager' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
        <?php
    }


    // Enable facebook Analytics
    function ccw_fb_analytics_cb() {
        $ccw_fb_analytics = get_option('ccw_options');


        if ( isset( $ccw_fb_analytics['fb_analytics'] ) ) {
            ?>
            <p>
                <input name="ccw_options[fb_analytics]" type="checkbox" value="1" <?php checked( $ccw_fb_analytics['fb_analytics'], 1 ); ?> id="fb_analytics" />
                <label for="fb_analytics"><?php _e( 'Facebook Analytics' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <input name="ccw_options[fb_analytics]" type="checkbox" value="1" id="fb_analytics" />
                <label for="fb_analytics"><?php _e( 'Facebook Analytics' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        }
        ?>
        <p class="description"> <?php _e( 'If Facebook Analytics is installed - creates an Event at there' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/facebook-analytics/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
        <p class="description"> <?php _e( 'Customize Event Values' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="<?php echo admin_url( 'admin.php?page=ccw-edit-styles#fb-analytics' ); ?>"><?php _e( 'Customize Styles' , 'click-to-chat-for-whatsapp' ) ?></a>  </p>
        <?php
    }



    // checkboxes - based on Type of posts .. 
    function ccw_checkbox_cb() {
        $ccw_checkbox = get_option('ccw_options');


        // Single Posts
        if ( isset( $ccw_checkbox['hideon_posts'] ) ) {
            ?>
            <p>
                <input name="ccw_options[hideon_posts]" type="checkbox" value="1" <?php checked( $ccw_checkbox['hideon_posts'], 1 ); ?> id="filled-in-box1" />
                <label for="filled-in-box1"><?php _e( 'Hide on - Posts' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <input name="ccw_options[hideon_posts]" type="checkbox" value="1" id="filled-in-box1" />
                <label for="filled-in-box1"><?php _e( 'Hide on - Posts' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        }


        // Page
        if ( isset( $ccw_checkbox['hideon_page'] ) ) {
            ?>
            <p>
                <input name="ccw_options[hideon_page]" type="checkbox" value="1" <?php checked( $ccw_checkbox['hideon_page'], 1 ); ?> id="filled-in-box2" />
                <label for="filled-in-box2"><?php _e( 'Hide on - Pages' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <input name="ccw_options[hideon_page]" type="checkbox" value="1" id="filled-in-box2" />
                <label for="filled-in-box2"><?php _e( 'Hide on - Pages' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        }


        // Home Page
        if ( isset( $ccw_checkbox['hideon_homepage'] ) ) {
            ?>
            <p>
                <input name="ccw_options[hideon_homepage]" type="checkbox" value="1" <?php checked( $ccw_checkbox['hideon_homepage'], 1 ); ?> id="filled-in-box3" />
                <label for="filled-in-box3"><?php _e( 'Hide on - Home Page' , 'click-to-chat-for-whatsapp' ) ?> </label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <input name="ccw_options[hideon_homepage]" type="checkbox" value="1" id="filled-in-box3" />
                <label for="filled-in-box3"><?php _e( 'Hide on - Home Page' , 'click-to-chat-for-whatsapp' ) ?> </label>
            </p>
            <?php
        }

        /* Front Page
         A front page is also a home page, but home page is not a front page
         if front page unchecked - it works on both homepage and fornt page
         but if home page is unchecked - it works only on home page, not on front page */
        if ( isset( $ccw_checkbox['hideon_frontpage'] ) ) {
            ?>
            <p>
                <input name="ccw_options[hideon_frontpage]" type="checkbox" value="1" <?php checked( $ccw_checkbox['hideon_frontpage'], 1 ); ?> id="filled-in-box4" />
                <label for="filled-in-box4"><?php _e( 'Hide on - Front Page' , 'click-to-chat-for-whatsapp' ) ?> </label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <input name="ccw_options[hideon_frontpage]" type="checkbox" value="1" id="filled-in-box4" />
                <label for="filled-in-box4"><?php _e( 'Hide on - Front Page' , 'click-to-chat-for-whatsapp' ) ?> </label>
            </p>
            <?php
        }

        // Category
        if ( isset( $ccw_checkbox['hideon_category'] ) ) {
            ?>
            <p>
                <input name="ccw_options[hideon_category]" type="checkbox" value="1" <?php checked( $ccw_checkbox['hideon_category'], 1 ); ?> id="filled-in-box5" />
                <label for="filled-in-box5"><?php _e( 'Hide on - Category' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <input name="ccw_options[hideon_category]" type="checkbox" value="1" id="filled-in-box5" />
                <label for="filled-in-box5"><?php _e( 'Hide on - Category' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        }

        // Archive
        if ( isset( $ccw_checkbox['hideon_archive'] ) ) {
            ?>
            <p>
                <input name="ccw_options[hideon_archive]" type="checkbox" value="1" <?php checked( $ccw_checkbox['hideon_archive'], 1 ); ?> id="filled-in-box6" />
                <label for="filled-in-box6"><?php _e( 'Hide on - Archive' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <input name="ccw_options[hideon_archive]" type="checkbox" value="1" id="filled-in-box6" />
                <label for="filled-in-box6"><?php _e( 'Hide on - Archive' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        }

        
        // 404 Page
        if ( isset( $ccw_checkbox['hideon_404'] ) ) {
            ?>
            <p>
                <input name="ccw_options[hideon_404]" type="checkbox" value="1" <?php checked( $ccw_checkbox['hideon_404'], 1 ); ?> id="filled-in-box7" />
                <label for="filled-in-box7"><?php _e( 'Hide on - 404 Page' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <input name="ccw_options[hideon_404]" type="checkbox" value="1" id="filled-in-box7" />
                <label for="filled-in-box7"><?php _e( 'Hide on - 404 Page' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        }
        ?>
        <p class="description"><?php _e( 'Check to hide - Hide - Styles - based on type of the page' , 'click-to-chat-for-whatsapp' ) ?> <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/show-hide-styles-based-on-type-of-the-page/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
        <?php
    }

    // ID's list to hide styles
    function ccw_list_id_tohide_cb() {
        $ccw_list_id_tohide = get_option('ccw_options');
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ccw_options[list_hideon_pages]" value="<?php echo esc_attr( $ccw_list_id_tohide['list_hideon_pages'] ) ?>" id="ccw_list_id_tohide" type="text" class="validate input-margin">
                <label for="ccw_list_id_tohide">Id's list to Hide - add ',' after each id </label>
                <p class="description"> Add Post, Pages, Media - ID's to hide, can add multiple id's separate with comma ( , ) - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/show-hide-styles-based-on-id/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
            </div>
        </div>
        <?php
    }

    //  Categorys list - to hide
    function ccw_list_cat_tohide_cb() {
        $ccw_list_cat_tohide = get_option('ccw_options');
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ccw_options[list_hideon_cat]" value="<?php echo esc_attr( $ccw_list_cat_tohide['list_hideon_cat'] ) ?>" id="ccw_list_cat_tohide" type="text" class="validate input-margin">
                <label for="ccw_list_cat_tohide"><?php _e( 'Category name\'s to Hide - add \',\' after each category name' , 'click-to-chat-for-whatsapp' ) ?> </label>
                <p class="description"><?php _e( 'Category name\'s to hide, can add multiple Categories separate with comma ( , )' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/hide-styles-based-on-category/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
            </div>
        </div>
        <?php
    }

    //  Custom shortcode
    function ccw_custom_shortcode_cb() {
        $ccw_shortcode = get_option('ccw_options');
        ?>
        <div class="row">
            <div class="input-field col s12">
                <input name="ccw_options[shortcode]" value="<?php echo esc_attr( $ccw_shortcode['shortcode'] ) ?>" id="shortcode" type="text" class="validate input-margin">
                <label for="shortcode"><?php _e( 'shortcode name' , 'click-to-chat-for-whatsapp' ) ?></label>
                <?php
                $shorcode_list = '';
                // global used here is defined by wordpress 
                foreach ($GLOBALS['shortcode_tags'] AS $key => $value) {
                   $shorcode_list .= $key . ', ';
                 }
                ?>
                <p class="description"> <?php _e( 'Default values is \'chat\', can customize shortcode name' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/change-shortcode-name/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
                <p class="description"> <?php _e( 'please dont add this already existing shorcode names' , 'click-to-chat-for-whatsapp' ) ?> - <?php echo $shorcode_list ?> </p>
            </div>
        </div>
        <?php
    }




    // if cache issue -  app first
    function ccw_app_first_cb() {
        $ccw_app_first = get_option('ccw_options');


        if ( isset( $ccw_app_first['app_first'] ) ) {
            ?>
            <p>
                <input name="ccw_options[app_first]" type="checkbox" value="1" <?php checked( $ccw_app_first['app_first'], 1 ); ?> id="app_first" />
                <label for="app_first"><?php _e( 'App First' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        } else {
            ?>
            <p>
                <input name="ccw_options[app_first]" type="checkbox" value="1" id="app_first" />
                <label for="app_first"><?php _e( 'App First' , 'click-to-chat-for-whatsapp' ) ?></label>
            </p>
            <?php
        }
        ?>
        <p class="description"> <?php _e( 'check this only if an issue with some cache plugins - its like a trick' , 'click-to-chat-for-whatsapp' ) ?> - <a target="_blank" href="https://www.holithemes.com/whatsapp-chat/app-first/"><?php _e( 'more info' , 'click-to-chat-for-whatsapp' ) ?></a> </p>
        <?php
    }






    // Sanitize callback ..
    function ccw_options_sanitize( $input ) {

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'not allowed to modify - please contact admin ' );
        }
        
        $new_input = array();

        foreach ($input as $key => $value) {
            if( isset( $input[$key] ) ) {
                $new_input[$key] = sanitize_text_field( $input[$key] );
            }
        }

        return $new_input;
    }


}



$admin_page = new CCW_Admin_Page();

add_action( 'admin_init', array( $admin_page,'ccw_custom_settings' ) );

endif; // END class_exists check