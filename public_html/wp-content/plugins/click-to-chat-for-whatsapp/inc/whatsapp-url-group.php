<?php
/**
* when user click on items this page will load 
* and here settings added as where to navigate 
* but at some place added navigation using onclick 
*   at shorcode.php ->  attribute for shortcode  - > img_click_link
*
* @package ccw
* @since 1.0
*/    

// const wont work here
require_once( explode( "wp-content" , __FILE__ )[0] . "wp-load.php" );

// this can call directly - its needed like this - if this cant call directly it wont work 
//   or to call directly require - wp-content to load .. wp-load.php 
if ( ! defined( 'ABSPATH' ) ) exit;

$id = sanitize_text_field( $_GET['id'] );

header("Location: https://chat.whatsapp.com/$id");

exit();