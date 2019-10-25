<?php

/* Enqueues admin scripts. */
add_action( 'admin_enqueue_scripts', 'add_admin_rpt_style' );
function add_admin_rpt_style() {

  /* Gets the post type. */
  global $post_type;

  if( 'rpt_pricing_table' == $post_type ) {

    /* CSS for metaboxes. */
    wp_enqueue_style( 'rpt_dmb_styles', plugins_url('dmb/dmb.min.css', __FILE__));
    /* CSS for previews */
    wp_enqueue_style( 'rpt_styles', plugins_url('css/rpt_style.min.css', __FILE__));
    /* Others */
    wp_enqueue_style( 'wp-color-picker' );

    /* JS for metaboxes. */
    wp_enqueue_script( 'rpt', plugins_url('dmb/dmb.min.js', __FILE__), array( 'jquery', 'thickbox', 'wp-color-picker' ));
    wp_localize_script( 'rpt', 'objectL10n', array(
      'untitled' => __( 'Untitled', RPT_TXTDM ),
      'copy' => __( 'copy', RPT_TXTDM ),
      'noPlan' => __( 'Add at least <strong>1</strong> plan to preview the pricing table.', RPT_TXTDM ),
      'previewAccuracy' => __( 'This is only a preview, shortcodes used in the fields will not be rendered and results may vary depending on your container\'s width.', RPT_TXTDM )
    ));
    wp_enqueue_style( 'thickbox' );
    
  }

}

?>