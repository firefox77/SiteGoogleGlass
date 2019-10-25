<?php
/**
*  set the default values
*  which stores in database options table
*  dont override user settings 
*  get user setting value and merge with newly added values
*
*   ccw_plugin_details   - this values will be overrides.. 
*
* @package ccw
* @since 1.0
*/

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * table name: "ccw_options"
 * 
 * top level options page - values
 * 
 * initial  - default / inital text
 * 
 * enable, enable_sc  -  2 - enable, 1 - disable .. 
 * new: 919908469612
 * prev: 918897606725
 */
$values = array(
    'enable' => '2',
    'enable_sc' => '2',
    'number' => '919908469612',
    'initial' => '',
    'input_placeholder' => 'WhatsApp us',
    'position' => '1',
    'style' => '9',
    'stylemobile' => '3',
    
    'position-1_bottom' => '10px',
    'position-1_right' => '10px',
    'position-2_bottom' => '10px',
    'position-2_left' => '10px',
    'position-3_top' => '10px',
    'position-3_left' => '10px',
    'position-4_top' => '10px',
    'position-4_right' => '10px',
    'list_hideon_pages' => '',
    'list_hideon_cat' => '',
    'shortcode' => 'chat',
    'return_type' => 'chat',  // chat or group_chat 
    'group_id' => '9EHLsEsOeJk6AVtE8AvXiA',

);

    /**
     * for version before 1.3 
     * has things changed - showon is changed to hideon
     * as its checkboxes
     * handled in this way..
     */
    $showon = get_option( 'ccw_options' );
    $p_ver = get_option('ccw_plugin_details');

    if ( '1.1' == $p_ver['version'] || '1.2' == $p_ver['version']  ) {

        if( !isset( $showon['showon_posts'] )  ) {
            $values[hideon_posts] = '1';
        }
    
        if( !isset( $showon['showon_page'] )  ) {
            $values[hideon_page] = '1';
        }
    
        if( !isset( $showon['showon_homepage'] )  ) {
            $values[hideon_homepage] = '1';
        }
    
        if( !isset( $showon['showon_frontpage'] )  ) {
            $values[hideon_frontpage] = '1';
        }
    
        if( !isset( $showon['showon_category'] )  ) {
            $values[hideon_category] = '1';
        }
    
        if( !isset( $showon['showon_archive'] )  ) {
            $values[hideon_archive] = '1';
        }
    
        if( !isset( $showon['showon_404'] )  ) {
            $values[hideon_404] = '1';
        }
    }


// update_option( 'ccw_options', $values );
// add_option( 'ccw_options', $values );

$db_values = get_option( 'ccw_options', array() );
$update_values = array_merge($values, $db_values);
update_option('ccw_options', $update_values);





/**
 * table name  - "ccw_options_cs"
 * 
 * customize styles - options page
 * 
 * @var string an_on_hover
 *  - if yes - adds 'ccw-an' to styles
 *     - added animations based on ccw-an at javascript
 */
$values_cs = array(
    's1_text_color' => '#9e9e9e',
    's1_text_color_onfocus' => '#26a69a',
    's1_border_color' => '#9e9e9e',
    's1_border_color_onfocus' => '#26a69a',
    's1_submit_btn_color' => '#26a69a',
    's1_submit_btn_text_and_icon_color' => '#fff',
    's1_width' => 'auto',
    's1_btn_text' => 'Submit',

    's2_text_color' => 'initial',
    's2_text_color_onhover' => 'initial',
    's2_decoration' => 'initial',
    's2_decoration_onhover' => 'initial',
    
    's3_icon_size' => '34px',
    's3_icon_type' => 'png',

    's4_text_color' => 'rgba(0, 0, 0, 0.6)',
    's4_background_color' => '#e4e4e4',

    's5_color' => '#25D366',
    's5_hover_color' => '#00e51e',
    's5_icon_size' => '24px',
    
    's6_color' => '#fff',
    's6_hover_color' => '#000',
    's6_icon_size' => '24px',
    's6_circle_background_color' => '#25D366',
    's6_circle_background_hover_color' => '#00e51e',
    's6_circle_height' => '48px',
    's6_circle_width' => '48px',
    's6_line_height' => '48px',

    's7_color' => '#fff',
    's7_hover_color' => '#000',
    's7_icon_size' => '24px',
    's7_box_background_color' => '#25D366',
    's7_box_background_hover_color' => '#00e51e',
    's7_box_height' => '48px',
    's7_box_width' => '48px',
    's7_line_height' => '48px',

    's8_text_color' => '#fff',
    's8_background_color' => '#26a69a',
    's8_icon_color' => '#fff',
    's8_text_color_onhover' => '#fff',
    's8_background_color_onhover' => '#26a69a',
    's8_icon_color_onhover' => '#fff',
    's8_icon_float' => 'right',
    's8_1_width' => '',

    's9_icon_size' => '48px',

    's99_img_height_desktop' => '99px',
    's99_img_width_desktop' => '',
    's99_img_height_mobile' => '50px',
    's99_img_width_mobile' => '',
    's99_desktop_img' => 'https://www.holithemes.com/whatsapp-chat/wp-content/uploads/2018/03/WhatsApp_Logo_2_desktop.jpg',
    's99_mobile_img' => 'https://www.holithemes.com/whatsapp-chat/wp-content/uploads/2018/03/WhatsApp_Logo_2_mobile.jpg',

    // 'an_enable' => 'no',
    'an_on_load' => 'no-animation',
    'an_on_hover' => 'ccw-no-hover-an',
    
);

$db_values_cs = get_option( 'ccw_options_cs', array() );
$update_values_cs = array_merge($values_cs, $db_values_cs);
update_option('ccw_options_cs', $update_values_cs);





/**
 * Google Analytics
 * option  - ht_ccw_ga
 */
$ccw_ga = array(

    'ga_category' => 'Click to Chat for WhatsApp',
    'ga_action' => 'Click',
    'ga_label' => '{{url}}',
    
);

$db_ccw_ga = get_option( 'ht_ccw_ga', array() );
$update_ccw_ga = array_merge($ccw_ga, $db_ccw_ga);
update_option('ht_ccw_ga', $update_ccw_ga);



/**
 * fb Analytics
 * option  - ht_ccw_fb
 */
$ccw_fb = array(

    'fb_event_name' => 'Click to Chat Event',
    'p1_name' => 'Category',
    'p2_name' => 'Action',
    'p3_name' => 'Label',
    'p1_value' => 'Click to Chat',
    'p2_value' => 'Click',
    'p3_value' => '{{url}}',
    
);

$db_ccw_fb = get_option( 'ht_ccw_fb', array() );
$update_ccw_fb = array_merge($ccw_fb, $db_ccw_fb);
update_option('ht_ccw_fb', $update_ccw_fb);









// plugin details 
$plugin_details = array(
    'version' => HT_CCW_VERSION,
);

// Always use update_option - override new values .. don't preseve already existing values
update_option( 'ccw_plugin_details', $plugin_details );