<?php
/**
 * List of Styles
 * 
 * @uses chatbot.php, chatbot-mobile.php
 * 
 * @var $values  -  is initiated in chat.php
 * $values = ht_ccw()->variables->get_option;
 * 
 * @package ccw
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$ccw_options_cs = get_option('ccw_options_cs');

//  if it is mobile device, or tab is_mobile is 1, if not 2 or any thing
$is_mobile = ht_ccw()->device_type->is_mobile;

$return_type = $values['return_type'];
$group_id = $values['group_id'];
$page_url = get_permalink();
$text = $values['initial'];

$initial_text = str_replace( '{{url}}', $page_url, $text );


// $an_on_load = "animated bounce infinite";
$an_on_load = esc_attr( $ccw_options_cs['an_on_load'] );

// if yes - add's 'ccw-an' class to styles
// for class ccw-an - animated in javascript
$an_on_hover = esc_attr( $ccw_options_cs['an_on_hover'] );



/**
 * $redirect - redirect link for onclick attribute - window.open - direct link - using window.open
 * $redirect_page - ( use only for style -1 ) page where redirect url there .. whatsapp-url whatsapp-url-group file .. 
 * $redirect_a   -  full url - for 'a' tags - direct link - instead of calling another file using redirect_page
 */
$redirect = "";

if( 1 == $is_mobile ) {

    // selected style for mobile devices
    $style = $values['stylemobile'];

    
    if ( 'group_chat' == $return_type ) {
        $redirect_page = plugins_url( "inc/whatsapp-url-group.php?id=$group_id", HT_CCW_PLUGIN_FILE );
        $redirect = "window.open('https://chat.whatsapp.com/$group_id', '_blank')";
        $redirect_a = "https://chat.whatsapp.com/$group_id";
    } else {
        $base_url = plugins_url( "inc/whatsapp-url.php", HT_CCW_PLUGIN_FILE );
        $redirect_page = $base_url . "?num=$num&text=$initial_text&m=$is_mobile";
        $redirect = "window.open('https://api.whatsapp.com/send?phone=$num&text=$initial_text', '_blank')";
        $redirect_a = "https://api.whatsapp.com/send?phone=$num&text=$initial_text";
    }
} else {

    // selected style for desktop devices
    $style = $values['style'];


    if ( isset( $values['app_first'] ) ) {

        // App First - so mobile based url
        if ( 'group_chat' == $return_type ) {
            $redirect_page = plugins_url( "inc/whatsapp-url-group.php?id=$group_id", HT_CCW_PLUGIN_FILE );
            $redirect = "window.open('https://chat.whatsapp.com/$group_id', '_blank')";
            $redirect_a = "https://chat.whatsapp.com/$group_id";
        } else {
            // an issue addin another url in plugin_url - in {{url}} https:// - one / is missing is 
            $base_url = plugins_url( "inc/whatsapp-url.php", HT_CCW_PLUGIN_FILE );
            $redirect_page = $base_url . "?num=$num&text=$initial_text&m=1";
            $redirect = "window.open('https://api.whatsapp.com/send?phone=$num&text=$initial_text', '_blank')";
            $redirect_a = "https://api.whatsapp.com/send?phone=$num&text=$initial_text";
        }


    } else {

        // General - Desktop url
        if ( 'group_chat' == $return_type ) {
            $redirect_page = plugins_url( "inc/whatsapp-url-group.php?id=$group_id", HT_CCW_PLUGIN_FILE );
            $redirect = "window.open('https://chat.whatsapp.com/$group_id', '_blank')";
            $redirect_a = "https://chat.whatsapp.com/$group_id";
        } else {
            $base_url = plugins_url( "inc/whatsapp-url.php", HT_CCW_PLUGIN_FILE );
            $redirect_page = $base_url . "?num=$num&text=$initial_text&m=0";
            $redirect = "window.open('https://web.whatsapp.com/send?phone=$num&text=$initial_text', '_blank')";
            $redirect_a = "https://web.whatsapp.com/send?phone=$num&text=$initial_text";
        }

    }
    
    
}


if ( isset ( $_POST['subject'] ) ) {
    $num = $values['number'];
    $subject = $_POST['subject'];
    $url = "$redirect_a&text=$subject";
    
    if ( headers_sent() ) {
        die('<script type="text/javascript">window.location.href="' . $url . '";</script>');
    } else {
        header('Location: ' . $url);
        die();
    } 

}

// floating style template path
$path = plugin_dir_path( HT_CCW_PLUGIN_FILE ) . 'inc/commons/styles-list/style-' . $style. '.php';

if ( is_file( $path ) ) {
    include_once $path;
}