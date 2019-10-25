<?php 

/* Saves metaboxes. */
add_action('save_post', 'dmb_rpts_plan_meta_box_save');
function dmb_rpts_plan_meta_box_save($post_id) {

	if ( ! isset( $_POST['dmb_rpts_meta_box_nonce'] ) ||
	! wp_verify_nonce( $_POST['dmb_rpts_meta_box_nonce'], 'dmb_rpts_meta_box_nonce' ) )
		return;

	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;

	if (!current_user_can('edit_post', $post_id))
		return;

	/* Gets plans. */
	$old_plans = get_post_meta($post_id, '_rpt_plan_group', true);

	/* Gets settings. */
	$old_table_currency = get_post_meta($post_id, '_rpt_currency', true);
	$old_table_btn_behavior = get_post_meta($post_id, '_rpt_open_newwindow', true);

	/* Gets font size settings. */
	$old_font_size_force_font = get_post_meta($post_id, '_rpt_original_font', true);
	$old_font_title_alignment = get_post_meta($post_id, '_rpt_title_alignment', true);
	$old_font_size_title = get_post_meta($post_id, '_rpt_title_fontsize', true);
	$old_font_size_subtitle = get_post_meta($post_id, '_rpt_subtitle_fontsize', true);
	$old_font_size_description = get_post_meta($post_id, '_rpt_description_fontsize', true);
	$old_font_size_price = get_post_meta($post_id, '_rpt_price_fontsize', true);
	$old_font_size_recurrence = get_post_meta($post_id, '_rpt_recurrence_fontsize', true);
	$old_font_size_button = get_post_meta($post_id, '_rpt_button_fontsize', true);
	$old_font_size_features = get_post_meta($post_id, '_rpt_features_fontsize', true);
	
	$new_plans = array();

	$count = count( $_POST['plan_titles'] );

	for ( $i = 0; $i < $count; $i++ ) {

		if ( 
			$_POST['plan_titles'][$i] != ''
			|| $_POST['plan_subtitles'][$i] != '' 
			|| $_POST['plan_recurrences'][$i] != ''
			|| $_POST['plan_prices'][$i] != ''
			|| $_POST['plan_descriptions'][$i] != ''
			|| $_POST['plan_features'][$i] != ''
			|| $_POST['plan_button_texts'][$i] != ''
			|| $_POST['plan_button_urls'][$i] != ''
			|| $_POST['plan_custom_buttons'][$i] != ''
		) {

			/* Head. */
			(isset($_POST['plan_titles'][$i]) && $_POST['plan_titles'][$i]) ? $new_plans[$i]['_rpt_title'] = stripslashes( wp_kses_post( $_POST['plan_titles'][$i] ) ) : $new_plans[$i]['_rpt_title'] = 'Untitled';
			(isset($_POST['plan_subtitles'][$i]) && $_POST['plan_subtitles'][$i]) ? $new_plans[$i]['_rpt_subtitle'] = stripslashes( wp_kses_post( $_POST['plan_subtitles'][$i] ) ) : $new_plans[$i]['_rpt_subtitle'] = '';
			(isset($_POST['plan_recurrences'][$i]) && $_POST['plan_recurrences'][$i]) ? $new_plans[$i]['_rpt_recurrence'] = stripslashes( wp_kses_post( $_POST['plan_recurrences'][$i] ) ) : $new_plans[$i]['_rpt_recurrence'] = '';
			(isset($_POST['plan_prices'][$i])) ? $new_plans[$i]['_rpt_price'] = stripslashes( wp_kses_post( $_POST['plan_prices'][$i] ) ) : $new_plans[$i]['_rpt_price'] = '';
			(isset($_POST['plan_descriptions'][$i]) && $_POST['plan_descriptions'][$i]) ? $new_plans[$i]['_rpt_description'] = stripslashes( wp_kses_post( $_POST['plan_descriptions'][$i] ) ) : $new_plans[$i]['_rpt_description'] = '';
			
			/* Features */
			(isset($_POST['plan_features'][$i]) && $_POST['plan_features'][$i]) ? $new_plans[$i]['_rpt_features'] = wp_kses_post( $_POST['plan_features'][$i] ) : $new_plans[$i]['_rpt_features'] = '';
			
			/* Button. */
			(isset($_POST['plan_button_texts'][$i]) && $_POST['plan_button_texts'][$i]) ? $new_plans[$i]['_rpt_btn_text'] = stripslashes( wp_kses_post( $_POST['plan_button_texts'][$i] ) ) : $new_plans[$i]['_rpt_btn_text'] = '';
			(isset($_POST['plan_button_urls'][$i]) && $_POST['plan_button_urls'][$i]) ? $new_plans[$i]['_rpt_btn_link'] = wp_kses_post( $_POST['plan_button_urls'][$i] ) : $new_plans[$i]['_rpt_btn_link'] = '';
			(isset($_POST['plan_custom_buttons'][$i]) && $_POST['plan_custom_buttons'][$i]) ? $new_plans[$i]['_rpt_btn_custom_btn'] = balanceTags($_POST['plan_custom_buttons'][$i]) : $new_plans[$i]['_rpt_btn_custom_btn'] = '';
			
			/* Styling. */
			(isset($_POST['plan_colors'][$i]) && $_POST['plan_colors'][$i]) ? $new_plans[$i]['_rpt_color'] = stripslashes( strip_tags( sanitize_hex_color( $_POST['plan_colors'][$i] ) ) ) : $new_plans[$i]['_rpt_color'] = '#8dba09';
			(isset($_POST['are_recommended_plans'][$i]) && $_POST['are_recommended_plans'][$i]) ? $new_plans[$i]['_rpt_recommended'] = $_POST['are_recommended_plans'][$i] : $new_plans[$i]['_rpt_recommended'] = 'no';
			(isset($_POST['are_removed_currencies'][$i]) && $_POST['are_removed_currencies'][$i]) ? $new_plans[$i]['_rpt_free'] = $_POST['are_removed_currencies'][$i] : $new_plans[$i]['_rpt_free'] = 'no';
			(isset($_POST['plan_custom_classes'][$i]) && $_POST['plan_custom_classes'][$i]) ? $new_plans[$i]['_rpt_custom_classes'] = stripslashes( strip_tags( sanitize_text_field( $_POST['plan_custom_classes'][$i] ) ) ) : $new_plans[$i]['_rpt_custom_classes'] = '';
			(isset($_POST['plan_icons'][$i]) && $_POST['plan_icons'][$i]) ? $new_plans[$i]['_rpt_icon'] = stripslashes( strip_tags( sanitize_text_field( $_POST['plan_icons'][$i] ) ) ) : $new_plans[$i]['_rpt_icon'] = '';
			
			/* Plan settings. */
			(isset($_POST['table_currency']) && $_POST['table_currency']) ? $table_currency = stripslashes( wp_kses_post( $_POST['table_currency'] ) ) : $table_currency = '';
			(isset($_POST['table_btn_behavior']) && $_POST['table_btn_behavior']) ? $table_btn_behavior = stripslashes( strip_tags( sanitize_text_field( $_POST['table_btn_behavior'] ) ) ) : $table_btn_behavior = '';
			
			/* Font sizes. */
			(isset($_POST['font_size_force_font']) && $_POST['font_size_force_font']) ? $font_size_force_font = stripslashes( strip_tags( sanitize_text_field( $_POST['font_size_force_font'] ) ) ) : $font_size_force_font = '';
			(isset($_POST['font_title_alignment']) && $_POST['font_title_alignment']) ? $font_title_alignment = stripslashes( strip_tags( sanitize_text_field( $_POST['font_title_alignment'] ) ) ) : $font_title_alignment = 'left';
			(isset($_POST['font_size_title']) && $_POST['font_size_title']) ? $font_size_title = stripslashes( strip_tags( sanitize_text_field( $_POST['font_size_title'] ) ) ) : $font_size_title = '';
			(isset($_POST['font_size_subtitle']) && $_POST['font_size_subtitle']) ? $font_size_subtitle = stripslashes( strip_tags( sanitize_text_field( $_POST['font_size_subtitle'] ) ) ) : $font_size_subtitle = '';
			(isset($_POST['font_size_description']) && $_POST['font_size_description']) ? $font_size_description = stripslashes( strip_tags( sanitize_text_field( $_POST['font_size_description'] ) ) ) : $font_size_description = '';
			(isset($_POST['font_size_price']) && $_POST['font_size_price']) ? $font_size_price = stripslashes( strip_tags( sanitize_text_field( $_POST['font_size_price'] ) ) ) : $font_size_price = '';
			(isset($_POST['font_size_recurrence']) && $_POST['font_size_recurrence']) ? $font_size_recurrence = stripslashes( strip_tags( sanitize_text_field( $_POST['font_size_recurrence'] ) ) ) : $font_size_recurrence = '';
			(isset($_POST['font_size_button']) && $_POST['font_size_button']) ? $font_size_button = stripslashes( strip_tags( sanitize_text_field( $_POST['font_size_button'] ) ) ) : $font_size_button = '';
			(isset($_POST['font_size_features']) && $_POST['font_size_features']) ? $font_size_features = stripslashes( strip_tags( sanitize_text_field( $_POST['font_size_features'] ) ) ) : $font_size_features = '';
			
		}

	}


  /* Updates plans. */
	if ( !empty( $new_plans ) && $new_plans != $old_plans )
		update_post_meta( $post_id, '_rpt_plan_group', $new_plans );
	elseif ( empty($new_plans) && $old_plans )
		delete_post_meta( $post_id, '_rpt_plan_group', $old_plans );


	/* Updates settings. */
	if ( !empty( $table_currency ) && $table_currency != $old_table_currency )
		update_post_meta( $post_id, '_rpt_currency', $table_currency );
	elseif ( empty($table_currency) && $old_table_currency )
		delete_post_meta( $post_id, '_rpt_currency', $old_table_currency );

	if ( !empty( $table_btn_behavior ) && $table_btn_behavior != $old_table_btn_behavior )
		update_post_meta( $post_id, '_rpt_open_newwindow', $table_btn_behavior );

		
	/* Updates font sizes. */
	if ( !empty( $font_size_force_font ) && $font_size_force_font != $old_font_size_force_font )
		update_post_meta( $post_id, '_rpt_original_font', $font_size_force_font );

	if ( !empty( $font_title_alignment ) && $font_title_alignment != $old_font_title_alignment )
		update_post_meta( $post_id, '_rpt_title_alignment', $font_title_alignment );

	if ( !empty( $font_size_title ) && $font_size_title != $old_font_size_title )
		update_post_meta( $post_id, '_rpt_title_fontsize', $font_size_title );

	if ( !empty( $font_size_subtitle ) && $font_size_subtitle != $old_font_size_subtitle )
		update_post_meta( $post_id, '_rpt_subtitle_fontsize', $font_size_subtitle );

	if ( !empty( $font_size_description ) && $font_size_description != $old_font_size_description )
		update_post_meta( $post_id, '_rpt_description_fontsize', $font_size_description );

	if ( !empty( $font_size_price ) && $font_size_price != $old_font_size_price )
		update_post_meta( $post_id, '_rpt_price_fontsize', $font_size_price );

	if ( !empty( $font_size_recurrence ) && $font_size_recurrence != $old_font_size_recurrence )
		update_post_meta( $post_id, '_rpt_recurrence_fontsize', $font_size_recurrence );

	if ( !empty( $font_size_button ) && $font_size_button != $old_font_size_button )
		update_post_meta( $post_id, '_rpt_button_fontsize', $font_size_button );

	if ( !empty( $font_size_features ) && $font_size_features != $old_font_size_features )
		update_post_meta( $post_id, '_rpt_features_fontsize', $font_size_features );

}