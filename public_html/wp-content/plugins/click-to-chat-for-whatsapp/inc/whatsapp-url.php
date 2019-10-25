<?php
/**
* when user click on items this page will load 
* and here settings added as where to navigate 
* but at some place added navigation using onclick 
*   at shorcode.php ->  attribute for shortcode  - > img_click_link
*
*  $subject , $is_mobile  - if value exists then it use, if not then rest works.
*  $subject  i.e.  post subject -  it works for style-1 form action .. 
*  $is_mobile get value if it is a mobile device or tab .. 
*
* @package ccw
* @since 1.0
*/    

// const wont work here
require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );

// this can call directly - its needed like this - if this cant call directly it wont work 
//   or to call directly require - wp-content load .. wp-load.php 
if ( ! defined( 'ABSPATH' ) ) exit;

$num = sanitize_text_field( $_GET['num'] );
$subject = sanitize_text_field( $_POST['subject'] );
$is_mobile = sanitize_text_field( $_GET['m'] );
$text = sanitize_text_field( $_GET['text'] );

$out_text = $text . ' ' .$subject;

check_admin_referer( 'ccw_style_1_verify' );


if( 1 == $is_mobile ) {
    header("Location: https://api.whatsapp.com/send?phone=$num&text=$out_text");
    // wp_redirect( "https://api.whatsapp.com/send?phone=$num&text=$out_text" );
}
else {
    header("Location: https://web.whatsapp.com/send?phone=$num&text=$out_text");
    // wp_redirect( "https://web.whatsapp.com/send?phone=$num&text=$subject" );
}

exit();