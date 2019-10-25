<?php

if ( ! defined( 'ABSPATH' ) ) exit;

$s3_icon_size = $a['s3_icon_size'];
$s3_icon_type = $a['s3_icon_type'];

$img_link = plugins_url("./assets/img/whatsapp-logo.$s3_icon_type", HT_CCW_PLUGIN_FILE );


$s3_icon_size = $s3_icon_size;

$o .= '<div class="ccw_plugin '.$inline_issue.' ">';
$o .= '<img class="img-icon-sc sc_item pointer style-3-sc ccw-analytics" data-ccw="style-3-sc" src="'.$img_link.'" alt="WhatsApp chat" onclick="'.$img_click_link.'" style="height: '.$s3_icon_size.'; '.$css.' " >';
$o .= '</div>';