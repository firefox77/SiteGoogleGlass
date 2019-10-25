<?php

/* Defines highlight select options. */
function dmb_rpts_is_highlight_plan_options() {
	$options = array ( __('Disabled', RPT_TXTDM ) => 'no', __('Enabled', RPT_TXTDM ) => 'yes' );
	return $options;
}


/* Defines currency select options. */
function dmb_rpts_is_currency_options() {
	$options = array ( __('Show', RPT_TXTDM ) => 'no', __('Hide', RPT_TXTDM ) => 'yes' );
	return $options;
}


/* Hooks the metabox. */
add_action('admin_init', 'dmb_rpts_add_plan', 1);
function dmb_rpts_add_plan() {
	add_meta_box( 
		'rpt_pricing_table', 
		'<span class="dashicons dashicons-edit"></span> '.__('Pricing table', RPT_TXTDM ), 
		'dmb_rpts_plan_display', // Below
		'rpt_pricing_table', 
		'normal', 
		'high'
	);
}


/* Displays the metabox. */
function dmb_rpts_plan_display() {

	global $post;
	
	/* Gets plan data. */
	$pricing_table = get_post_meta( $post->ID, '_rpt_plan_group', true );

	$fields_to_process = array(
		'_rpt_title',
		'_rpt_subtitle',
		'_rpt_recurrence',
		'_rpt_price',
		'_rpt_description',
		'_rpt_icon',
		'_rpt_recommended',
		'_rpt_free',
		'_rpt_features',
		'_rpt_btn_text',
		'_rpt_btn_link',
		'_rpt_btn_custom_btn',
		'_rpt_custom_classes',
		'_rpt_color'
	);

	/* Retrieves select options. */
	$is_highlight_plan_options = dmb_rpts_is_highlight_plan_options();
	$is_currency_plan_options = dmb_rpts_is_currency_options();

	wp_nonce_field( 'dmb_rpts_meta_box_nonce', 'dmb_rpts_meta_box_nonce' ); ?>

	<div id="dmb_preview_table">
		<!-- Add row button -->
		<a class="dmb_preview_button dmb_preview_table_close" href="#">
			<?php _e('Close preview', RPT_TXTDM ) ?>
		</a>
	</div>

	<!-- Toolbar for plan metabox -->
	<div class="dmb_toolbar">
		<div class="dmb_toolbar_inner">
			<a class="dmb_big_button_secondary dmb_expand_plans" href="#"><span class="dashicons dashicons-editor-expand"></span> <?php _e('Expand all', RPT_TXTDM ) ?>&nbsp;</a>&nbsp;&nbsp;
			<a class="dmb_big_button_secondary dmb_collapse_plans" href="#"><span class="dashicons dashicons-editor-contract"></span> <?php _e('Collapse all', RPT_TXTDM ) ?>&nbsp;</a>&nbsp;&nbsp;
			<a class="dmb_show_preview_table dmb_preview_button"><span class="dashicons dashicons-admin-appearance"></span> <?php _e('Instant preview', RPT_TXTDM ) ?>&nbsp;</a>
			<div class="dmb_clearfix"></div>
		</div>
	</div>

	<?php if ( $pricing_table ) {	

		/* Loops through plans. */
		foreach ( $pricing_table as $pricing_plan ) {

			/* Retrieves each field for current plan. */
			$plan = array();
			foreach ( $fields_to_process as $field) {
				switch ($field) {
					case '_rpt_recommended':
						// Moving to new framework.
						$plan[$field] = ( !isset($pricing_plan[$field]) || ($pricing_plan[$field] != 'on' && $pricing_plan[$field] != 'yes')) ? 'no' : 'yes';
						break;
					case '_rpt_free':
						// Moving to new framework.
						$plan[$field] = ( !isset($pricing_plan[$field]) || ($pricing_plan[$field] != 'on' && $pricing_plan[$field] != 'yes')) ? 'no' : 'yes';
						break;
					default:
						$plan[$field] = ( isset($pricing_plan[$field]) ) ? esc_attr($pricing_plan[$field]) : '';
						break;
				}
			}
			?>

			<!-- START plan -->
			<div class="dmb_main">

				<!-- plan handle bar -->
				<div class="dmb_handle">
					<div>
						<a class="dmb_big_button_secondary dmb_move_row_up" href="#" title="Move up"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
						<a class="dmb_big_button_secondary dmb_move_row_down" href="#" title="Move down"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
						<div class="dmb_handle_title"></div>
						<a class="dmb_big_button_secondary dmb_remove_row_btn" href="#" title="Remove"><span class="dashicons dashicons-no-alt"></span></a>
						<a class="dmb_big_button_secondary dmb_clone_row" href="#" title="Clone"><span class="dashicons dashicons-admin-page"></span><?php _e('Clone', RPT_TXTDM ); ?></a>
						<div class="dmb_clearfix"></div>
					</div>
				</div>

				<!-- START inner -->
				<div class="dmb_inner">

					<div class="dmb_section_title">
						<?php _e('Header', RPT_TXTDM ) ?>
					</div>

					<div class="dmb_grid dmb_grid_40 dmb_grid_first">
						<div class="dmb_field_title">
							<?php _e('Title', RPT_TXTDM ) ?>
						</div>
						<input class="dmb_big_field dmb_highlight_field dmb_title_of_plan" type="text" name="plan_titles[]" value="<?php echo $plan['_rpt_title']; ?>" placeholder="<?php _e('e.g. Platinum', RPT_TXTDM ) ?>" />
					</div>

					<div class="dmb_grid dmb_grid_60 dmb_grid_last">
						<div class="dmb_field_title">
							<?php _e('Subtitle', RPT_TXTDM ) ?>
						</div>
						<input class="dmb_big_field dmb_subtitle_of_plan" type="text" name="plan_subtitles[]" value="<?php echo $plan['_rpt_subtitle']; ?>" placeholder="<?php _e('e.g. Our best deal', RPT_TXTDM ) ?>" />
					</div>

					<div class="dmb_grid dmb_grid_60 dmb_grid_first">
						<div class="dmb_field_title">
							<?php _e('Short description', RPT_TXTDM ) ?>
						</div>
						<input class="dmb_field dmb_description_of_plan" type="text" name="plan_descriptions[]" value="<?php echo $plan['_rpt_description']; ?>" placeholder="<?php _e('e.g. This plan is suitable for small companies', RPT_TXTDM ) ?>" />
					</div>

					<div class="dmb_grid dmb_grid_20">
						<div class="dmb_field_title">
							<?php _e('Price', RPT_TXTDM ) ?>
						</div>
						<input class="dmb_field dmb_price_of_plan" type="text" name="plan_prices[]" value="<?php echo $plan['_rpt_price']; ?>" placeholder="<?php _e('e.g. 9', RPT_TXTDM ) ?>" />
					</div>

					<div class="dmb_grid dmb_grid_20 dmb_grid_last">
						<div class="dmb_field_title">
							<?php _e('Frequency', RPT_TXTDM ) ?>
						</div>
						<input class="dmb_field dmb_recurrence_of_plan" type="text" name="plan_recurrences[]" value="<?php echo $plan['_rpt_recurrence']; ?>" placeholder="<?php _e('e.g. monthly', RPT_TXTDM ) ?>" />
					</div>

					<div class="dmb_clearfix"></div>

					<!-- Plan features -->
					<div class="dmb_section_title">
						<?php _e('Features', RPT_TXTDM ) ?>
					</div>

					<textarea class="dmb_feature_dump dmb_features_of_plan" name="plan_features[]"><?php echo $plan['_rpt_features']; ?></textarea>

					<div class="dmb_tip">
						<?php 
							// Feature tips
							$dmb_image_tip = "<a class='dmb_tooltip_large' data-tooltip='<img src=\"http://yoursite.com/media/image.png\"/>'>[?]</a>";
							$dmb_link_tip = "<a class='dmb_tooltip_large' data-tooltip='<a href=\"http://yoursite.com\">Click here</a>'>[?]</a>";
							$dmb_bold_text_tip = "<a class='dmb_tooltip_small' data-tooltip=\"<strong>Bold</strong>\">[?]</a>";
							printf(
								/* translators: 1: image tooltip 2: link tooltip 3: bold text tooltip (leave at the end) */
								'<span class="dashicons dashicons-yes"></span>'.__( 'Images %1$s, links %2$s and bold text %3$s are allowed in the feature fields.', RPT_TXTDM ),
								$dmb_image_tip,
								$dmb_link_tip,
								$dmb_bold_text_tip
							);
						?>
						<br/>		
						<span class="dashicons dashicons-yes"></span><?php _e( 'Show some features as unavailable by adding \'-n\' before, e.g. \'-nMy feature\'.', RPT_TXTDM ); ?>	
					</div>

					<div class="dmb_features"></div>
					<a class="dmb_small_button_primary dmb_add_feature" href="#">
						<span class="dashicons dashicons-plus"></span> 
						<?php _e('Add feature', RPT_TXTDM ) ?>&nbsp;
					</a>

					<div class="dmb_clearfix"></div>

					<!-- Plan button -->
					<div class="dmb_button_text dmb_grid dmb_grid_50 dmb_grid_first">
						<div class="dmb_section_title">
							<?php _e('Standard button', RPT_TXTDM ) ?>
						</div>
						<div class="dmb_field_title">
							<?php _e('Button text', RPT_TXTDM ) ?>
						</div>
						<input class="dmb_field dmb_button_text_of_plan" type="text" name="plan_button_texts[]" value="<?php echo $plan['_rpt_btn_text']; ?>" placeholder="<?php _e('e.g. Subscribe', RPT_TXTDM ) ?>" />
						<div class="dmb_field_title">
							<?php _e('Button URL', RPT_TXTDM ) ?>
						</div>
						<input class="dmb_field" type="text" name="plan_button_urls[]" value="<?php echo $plan['_rpt_btn_link']; ?>" placeholder="<?php _e('e.g. http://site.com/product', RPT_TXTDM ) ?>" />
					</div>

					<div class="dmb_custom_button dmb_grid dmb_grid_50 dmb_grid_last">
						<div class="dmb_section_title">
							<?php _e('Custom button', RPT_TXTDM ) ?>
						</div>
						<div class="dmb_field_title">
							<?php _e('Add custom code here', RPT_TXTDM ) ?> 
							<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('Use the custom button field when you have code snippets/shortcodes from third party services/plugins that generate buttons. You could also use any HTML here such as an anchor tag. Custom buttons overwrite standard buttons.', RPT_TXTDM ) ?>">[?]</a>
						</div>
						<textarea class="dmb_field dmb_custom_button_of_plan" type="text" name="plan_custom_buttons[]" placeholder="<?php _e('Insert any code here to replace the standard button (e.g. Paypal/Stripe snippet, custom HTML...).', RPT_TXTDM ) ?>"><?php echo $plan['_rpt_btn_custom_btn']; ?></textarea>
					</div>

					<div class="dmb_clearfix"></div>

					<!-- Styling -->
					<div class="dmb_section_title"><?php _e('Styling', RPT_TXTDM ) ?></div>
					
					<div class=" dmb_grid dmb_grid_20 dmb_grid_first">
						<div class="dmb_field_title">
							<?php _e('Highlight plan', RPT_TXTDM ) ?> 
							<a class="dmb_inline_tip" data-tooltip="<?php _e('Highlight a plan to make it stand out from the rest.', RPT_TXTDM ) ?>">[?]</a>
						</div>
						<select class="dmb_switch_recommended" name="are_recommended_plans[]">
							<?php foreach ( $is_highlight_plan_options as $label => $value ) { ?>
							<option value="<?php echo $value; ?>"<?php selected( $plan['_rpt_recommended'], $value ); ?>><?php echo $label; ?></option>
							<?php } ?>
						</select>
					</div>
					
					<div class="dmb_grid dmb_grid_20">
						<div class="dmb_field_title">
							<?php _e('Show/hide currency', RPT_TXTDM ) ?>
						</div>
						<select class="dmb_switch_free" name="are_removed_currencies[]">
							<?php foreach ( $is_currency_plan_options as $label => $value ) { ?>
							<option value="<?php echo $value; ?>"<?php selected( $plan['_rpt_free'], $value ); ?>><?php echo $label; ?></option>
							<?php } ?>
						</select>
					</div>
					
					<div class="dmb_grid dmb_grid_25">
						<div class="dmb_field_title">
							<?php _e('CSS classes', RPT_TXTDM ) ?> 
							<a class="dmb_inline_tip dmb_tooltip_medium" data-tooltip="<?php _e('Add your CSS classes, separated by spaces.', RPT_TXTDM ) ?>">[?]</a>
						</div>
						<input class="dmb_field" type="text" name="plan_custom_classes[]" value="<?php echo $plan['_rpt_custom_classes']; ?>" placeholder="<?php _e('e.g. class more-class', RPT_TXTDM ) ?>" />
					</div>

					<div class="dmb_color_box dmb_grid dmb_grid_35 dmb_grid_last">
						<div class="dmb_field_title">
							<?php _e('Color', RPT_TXTDM ) ?>
						</div>
						<input class="dmb_color_picker dmb_field dmb_color_of_plan" name="plan_colors[]" type="text" value="<?php echo $plan['_rpt_color']; ?>" />
					</div>

					<div class="dmb_clearfix"></div>
					
					<div class="dmb_grid dmb_grid_35 dmb_grid_first dmb_grid_last">
						<div class="dmb_field_title dmb_icon_data_url" data-icon="<?php echo $plan['_rpt_icon']; ?>"></div>
						<input class="dmb_field dmb_icon_field" name="plan_icons[]" type="text" value="" />
						<div class="dmb_upload_icon_btn dmb_small_button_primary">
							<span class="dashicons dashicons-upload"></span> 
							<?php _e('Upload icon', RPT_TXTDM ) ?>&nbsp;
						</div>
					</div>

					<div class="dmb_clearfix"></div>						

				<!-- END inner -->
				</div>
			
			<!-- END plan -->
			</div>

			<?php
		}
	} ?>

	<!-- START empty plan -->
	<div class="dmb_main dmb_empty_plan" style="display:none;">

		<!-- plan handle bar -->
		<div class="dmb_handle">
			<div>
				<a class="dmb_big_button_secondary dmb_move_row_up" href="#" title="Move up"><span class="dashicons dashicons-arrow-up-alt2"></span></a>
				<a class="dmb_big_button_secondary dmb_move_row_down" href="#" title="Move down"><span class="dashicons dashicons-arrow-down-alt2"></span></a>
				<div class="dmb_handle_title"></div>
				<a class="dmb_big_button_secondary dmb_remove_row_btn" href="#" title="Remove"><span class="dashicons dashicons-no-alt"></span></a>
				<a class="dmb_big_button_secondary dmb_clone_row" href="#" title="Clone"><span class="dashicons dashicons-admin-page"></span><?php _e('Clone', RPT_TXTDM ); ?></a>
				<div class="dmb_clearfix"></div>
			</div>
		</div>

		<!-- START inner -->
		<div class="dmb_inner">

			<div class="dmb_section_title">
				<?php _e('Header', RPT_TXTDM ) ?>
			</div>

			<div class="dmb_grid dmb_grid_40 dmb_grid_first">
				<div class="dmb_field_title">
					<?php _e('Title', RPT_TXTDM ) ?>
				</div>
				<input class="dmb_big_field dmb_highlight_field dmb_title_of_plan" type="text" name="plan_titles[]" value="" placeholder="<?php _e('e.g. Platinum', RPT_TXTDM ) ?>" />
			</div>

			<div class="dmb_grid dmb_grid_60 dmb_grid_last">
				<div class="dmb_field_title">
					<?php _e('Subtitle', RPT_TXTDM ) ?>
				</div>
				<input class="dmb_big_field dmb_subtitle_of_plan" type="text" name="plan_subtitles[]" value="" placeholder="<?php _e('e.g. Our best deal', RPT_TXTDM ) ?>" />
			</div>

			<div class="dmb_grid dmb_grid_60 dmb_grid_first">
				<div class="dmb_field_title">
					<?php _e('Description', RPT_TXTDM ) ?>
				</div>
				<input class="dmb_field dmb_description_of_plan" type="text" name="plan_descriptions[]" value="" placeholder="<?php _e('e.g. This plan is suitable for small companies.', RPT_TXTDM ) ?>" />
			</div>

			<div class="dmb_grid dmb_grid_20">
				<div class="dmb_field_title">
					<?php _e('Price', RPT_TXTDM ) ?>
				</div>
				<input class="dmb_field dmb_price_of_plan" type="text" name="plan_prices[]" value="" placeholder="<?php _e('e.g. 9', RPT_TXTDM ) ?>" />
			</div>

			<div class="dmb_grid dmb_grid_20 dmb_grid_last">
				<div class="dmb_field_title">
					<?php _e('Frequency', RPT_TXTDM ) ?>
				</div>
				<input class="dmb_field dmb_recurrence_of_plan" type="text" name="plan_recurrences[]" value="" placeholder="<?php _e('e.g. monthly', RPT_TXTDM ) ?>" />
			</div>

			<div class="dmb_clearfix"></div>
			
			<!-- Plan features -->
			<div class="dmb_section_title"><?php _e('Features', RPT_TXTDM ) ?></div>

			<textarea class="emptyDump dmb_features_of_plan" name="plan_features[]"></textarea>

			<div class="dmb_tip">
				<?php 
					// Feature tips
					$dmb_image_tip = "<a class='dmb_tooltip_large' data-tooltip='<img src=\"http://yoursite.com/media/image.png\"/>'>[?]</a>";
					$dmb_link_tip = "<a class='dmb_tooltip_large' data-tooltip='<a href=\"http://yoursite.com\">Click here</a>'>[?]</a>";
					$dmb_bold_text_tip = "<a class='dmb_tooltip_small' data-tooltip=\"<strong>Bold</strong>\">[?]</a>";
					printf(
						/* translators: 1: image tooltip 2: link tooltip 3: bold text tooltip (leave at the end) */
						'<span class="dashicons dashicons-yes"></span>'.__( 'Images %1$s, links %2$s and bold text %3$s are allowed in the feature fields.', RPT_TXTDM ),
						$dmb_image_tip,
						$dmb_link_tip,
						$dmb_bold_text_tip
					);
				?>
				<br/>		
				<span class="dashicons dashicons-yes"></span><?php _e( 'Show some features as unavailable by adding \'-n\' before, e.g. \'-nMy feature\'.', RPT_TXTDM ); ?>	
			</div>

			<div class="dmb_features"></div>
			<a class="dmb_small_button_primary dmb_add_feature" href="#">
				<span class="dashicons dashicons-plus"></span> 
				<?php _e('Add feature', RPT_TXTDM ) ?>&nbsp;
			</a>

			<div class="dmb_clearfix"></div>
	
			<!-- Plan button -->
			<div class="dmb_button_text dmb_grid dmb_grid_50 dmb_grid_first">
				<div class="dmb_section_title">
					<?php _e('Standard button', RPT_TXTDM ) ?>
				</div>
				<div class="dmb_field_title">
					<?php _e('Button text', RPT_TXTDM ) ?>
				</div>
				<input class="dmb_field dmb_button_text_of_plan" type="text" name="plan_button_texts[]" value="" placeholder="<?php _e('e.g. Subscribe', RPT_TXTDM ) ?>" />
				<div class="dmb_field_title">
					<?php _e('Button URL', RPT_TXTDM ) ?>
				</div>
				<input class="dmb_field" type="text" name="plan_button_urls[]" value="" placeholder="<?php _e('e.g. http://site.com/product', RPT_TXTDM ) ?>" />
			</div>

			<div class="dmb_custom_button dmb_grid dmb_grid_50 dmb_grid_last">
				<div class="dmb_section_title">
					<?php _e('Custom button', RPT_TXTDM ) ?>
				</div>
				<div class="dmb_field_title">
					<?php _e('Add custom code here', RPT_TXTDM ) ?> 
					<a class="dmb_inline_tip dmb_tooltip_large" data-tooltip="<?php _e('Use the custom button field when you have code snippets/shortcodes from third party services/plugins that generate buttons. You could also use any HTML here such as an anchor tag. Custom buttons overwrite standard buttons', RPT_TXTDM ) ?>">[?]</a>
				</div>
				<textarea class="dmb_field dmb_custom_button_of_plan" type="text" name="plan_custom_buttons[]" placeholder="<?php _e('Insert any code here to replace the standard button (e.g. Paypal/Stripe snippet, custom HTML...).', RPT_TXTDM ) ?>"></textarea>
			</div>

			<div class="dmb_clearfix"></div>

			<!-- Plan styling -->
			<div class="dmb_section_title"><?php _e('Styling', RPT_TXTDM ) ?></div>
			
			<div class="dmb_grid dmb_grid_20 dmb_grid_first">
				<div class="dmb_field_title">
					<?php _e('Highlight plan', RPT_TXTDM ) ?> 
					<a class="dmb_inline_tip" data-tooltip="<?php _e('Highlight a plan to make it stand out from the rest.', RPT_TXTDM ) ?>">[?]</a>
				</div>
				<select class="dmb_switch_recommended" name="are_recommended_plans[]">
					<?php foreach ( $is_highlight_plan_options as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="dmb_grid dmb_grid_20">
				<div class="dmb_field_title">
					<?php _e('Show/hide currency', RPT_TXTDM ) ?>
				</div>
				<select class="dmb_switch_free" name="are_removed_currencies[]">
					<?php foreach ( $is_currency_plan_options as $label => $value ) { ?>
					<option value="<?php echo $value; ?>"><?php echo $label; ?></option>
					<?php } ?>
				</select>
			</div>
			
			<div class="dmb_grid dmb_grid_25">
				<div class="dmb_field_title">
					<?php _e('CSS classes', RPT_TXTDM ) ?> 
					<a class="dmb_inline_tip dmb_tooltip_medium" data-tooltip="<?php _e('Add your CSS classes, separated by spaces.', RPT_TXTDM ) ?>">[?]</a>
				</div>
				<input class="dmb_field" type="text" name="plan_custom_classes[]" value="" placeholder="<?php _e('e.g. class more-class', RPT_TXTDM ) ?>" />
			</div>

			<div class="dmb_color_box dmb_grid dmb_grid_35 dmb_grid_last" style="position:relative;">
				<div class="dmb_field_title">
					<?php _e('Color', RPT_TXTDM ) ?>
				</div>
				<input class="dmb_color_picker_ready dmb_field dmb_color_of_plan" name="plan_colors[]" type="text" value="" />
			</div>

			<div class="dmb_clearfix"></div>

			<div class="dmb_grid dmb_grid_35 dmb_grid_first dmb_grid_last">
				<div class="dmb_field_title dmb_icon_data_url" data-icon=""></div>
				<input class="dmb_field dmb_icon_field" name="plan_icons[]" type="text" value="" />
				<div class="dmb_upload_icon_btn dmb_small_button_primary">
					<span class="dashicons dashicons-upload"></span> <?php _e('Upload icon', RPT_TXTDM ) ?>&nbsp;
				</div>
			</div>

			<div class="dmb_clearfix"></div>

		<!-- END inner -->
		</div>

	<!-- END empty plan -->
	</div>

	<div class="dmb_clearfix"></div>

	<!-- Empty feature -->
	<div class="empty-feature dmb_feature" style="display:none;">

		<input class="dmb_field dmb_feature_field" type="text" value="" />
		<a class="dmb_remove_feature_btn" class="button" href="#">
			<span class="dashicons dashicons-no-alt"></span>
		</a>

	</div>

	<div class="dmb_clearfix"></div> 

	<div class="dmb_no_plan_notice">
		<?php /* translators: Leave HTML tags */ _e('Create your pricing table by <strong>adding plans</strong> to it.<br/>Click the button below to get started.', RPT_TXTDM ) ?>
	</div>

	<!-- Add row button -->
	<a class="dmb_big_button_primary dmb_add_row" href="#">
		<span class="dashicons dashicons-plus"></span> 
		<?php _e('Add a pricing plan', RPT_TXTDM ) ?>&nbsp;
	</a>

<?php }
