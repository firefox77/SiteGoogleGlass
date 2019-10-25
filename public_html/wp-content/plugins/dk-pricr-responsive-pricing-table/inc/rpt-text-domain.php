<?php 

/* Loads plugin's text domain. */
add_action( 'plugins_loaded', 'rpt_load_plugin_textdomain' );
function rpt_load_plugin_textdomain() {
  load_plugin_textdomain( RPT_TXTDM, FALSE, RPT_PATH . 'lang/' );
}

?>