<?php
/**
 * depreated - now with style-4 sc can add as inline style and can fix auotp issue
 * using inline_issue attribute .. 
 */

if ( ! defined( 'ABSPATH' ) ) exit;

wp_enqueue_style('ccw_md_css');

$s4_text_color = $a['s4_text_color'];
$s4_background_color = $a['s4_background_color'];

$s4_text_color = $s4_text_color;
$s4_background_color = $s4_background_color;

$img_link_s4 = plugins_url("./assets/img/whatsapp-logo-32x32.png", HT_CCW_PLUGIN_FILE );

$o .= '<div class="ccw_plugin inline_issue sc_item" style=" '.$css.' " >';
$o .= '<div class="chip pointer ccw-analytics" data-ccw="style-4-1-sc" style=" color: '.$s4_text_color.'; background-color: '.$s4_background_color.' " onclick="'.$img_click_link.'">';
$o .= '<img class="ccw-analytics" data-ccw="style-4-1-sc" src="'.$img_link_s4.'" alt="WhatsApp chat">'.$a["val"].'';
$o .= '</div>';
$o .= '</div>';