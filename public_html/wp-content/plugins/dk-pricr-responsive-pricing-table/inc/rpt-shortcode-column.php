<?php 

/* Handles shortcode column display. */
add_action( 'manage_rpt_pricing_table_posts_custom_column' , 'rpt_custom_columns', 10, 2 );
function rpt_custom_columns( $column, $post_id ) {
  switch ( $column ) {
    case 'dk_shortcode' :
      global $post;
      $slug = '' ;
      $slug = $post->post_name;
      $shortcode = '<span style="display:inline-block;border:solid 2px lightgray; background:white; padding:0 8px; font-size:13px; line-height:25px; vertical-align:middle;">[rpt name="'.$slug.'"]</span>';
      echo $shortcode;
      break;
  }
}


/* Adds the shortcode column in admin. */
add_filter( 'manage_rpt_pricing_table_posts_columns' , 'add_rpt_pricing_table_columns' );
function add_rpt_pricing_table_columns( $columns ) {
  return array_merge( $columns, array('dk_shortcode' => 'Shortcode') );
}

?>