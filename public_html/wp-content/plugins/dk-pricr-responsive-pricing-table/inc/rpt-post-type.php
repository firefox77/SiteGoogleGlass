<?php 

/* Registers the pricing table post type. */
add_action( 'init', 'register_rpt_type' );
function register_rpt_type() {
	
  /* Defines labels. */
  $labels = array(
		'name'               => __( 'Pricing Tables', RPT_TXTDM ),
		'singular_name'      => __( 'Pricing Table', RPT_TXTDM ),
		'menu_name'          => __( 'Pricing Tables', RPT_TXTDM ),
		'name_admin_bar'     => __( 'Pricing Table', RPT_TXTDM ),
		'add_new'            => __( 'Add New', RPT_TXTDM ),
		'add_new_item'       => __( 'Add New Pricing Table', RPT_TXTDM ),
		'new_item'           => __( 'New Pricing Table', RPT_TXTDM ),
		'edit_item'          => __( 'Edit Pricing Table', RPT_TXTDM ),
		'view_item'          => __( 'View Pricing Table', RPT_TXTDM ),
		'all_items'          => __( 'All Pricing Tables', RPT_TXTDM ),
		'search_items'       => __( 'Search Pricing Tables', RPT_TXTDM ),
		'not_found'          => __( 'No Pricing Tables found.', RPT_TXTDM ),
		'not_found_in_trash' => __( 'No Pricing Tables found in Trash.', RPT_TXTDM )
	);

  /* Defines permissions. */
	$args = array(
		'labels'             => $labels,
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_rest'       => true,
    'show_in_admin_bar'  => false,
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'supports'           => array( 'title' ),
    'menu_icon'          => 'dashicons-plus'
	);

  /* Registers post type. */
	register_post_type( 'rpt_pricing_table', $args );

}


/* Customizes pricing table update messages. */
add_filter( 'post_updated_messages', 'rpt_updated_messages' );
function rpt_updated_messages( $messages ) {

	$post = get_post();
	$post_type = get_post_type( $post );
	$post_type_object = get_post_type_object( $post_type );

  /* Defines update messages. */
	$messages['rpt_pricing_table'] = array(
		1  => __( 'Pricing Table updated.', RPT_TXTDM ),
		4  => __( 'Pricing Table updated.', RPT_TXTDM ),
		6  => __( 'Pricing Table published.', RPT_TXTDM ),
		7  => __( 'Pricing Table saved.', RPT_TXTDM ),
		10 => __( 'Pricing Table draft updated.', RPT_TXTDM )
	);

	return $messages;

}

?>