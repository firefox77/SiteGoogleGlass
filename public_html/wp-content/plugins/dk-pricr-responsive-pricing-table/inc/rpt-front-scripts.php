<?php 

/* Enqueues front scripts. */
add_action( 'wp_enqueue_scripts', 'add_rpt_scripts', 99 );
function add_rpt_scripts() {
  wp_enqueue_style( 'rpt', plugins_url('css/rpt_style.min.css', __FILE__));
	wp_enqueue_script( 'rpt', plugins_url('js/rpt.min.js', __FILE__), array( 'jquery' ));
}

?>