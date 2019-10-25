<?php 

/* Defines button behavior options. */
function dmb_rpts_link_behavior_options() {
	$options = array ( 
		__('New window', RPT_TXTDM ) => 'newwindow', 
		__('Same window', RPT_TXTDM ) => 'currentwindow' 
	);
	return $options;
}


/* Defines force font select options. */
function dmb_rpts_force_fonts_options() {
	$options = array ( 
		__('Use my theme\'s font', RPT_TXTDM ) => 'no',
		__('Use default font', RPT_TXTDM ) => 'yes'
	);
	return $options;
}


/* Defines title alignment select options. */
function dmb_rpts_title_alignment_options() {
	$options = array ( 
		__('Left', RPT_TXTDM ) => 'left', 
		__('Center', RPT_TXTDM ) => 'center',  
	);
	return $options;
}


/* Defines title font select options. */
function dmb_rpts_title_size_options() {
	$options = array ( 
		__('Tiny', RPT_TXTDM ) => 'tiny', 
		__('Small', RPT_TXTDM ) => 'small',
		__('Normal', RPT_TXTDM ) => 'normal'  
	);
	return $options;
}


/* Defines subtitle font select options. */
function dmb_rpts_subtitle_size_options() {
	$options = array ( 
		__('Tiny', RPT_TXTDM ) => 'tiny', 
		__('Small', RPT_TXTDM ) => 'small',
		__('Normal', RPT_TXTDM ) => 'normal'  
	);
	return $options;
}


/* Defines description font select options. */
function dmb_rpts_desc_size_options() {
	$options = array ( 
		__('Small', RPT_TXTDM ) => 'small',
		__('Normal', RPT_TXTDM ) => 'normal'  
	);
	return $options;
}


/* Defines price font select options. */
function dmb_rpts_price_size_options() {
	$options = array ( 
		__('Tiny', RPT_TXTDM ) => 'supertiny', 
		__('Small', RPT_TXTDM ) => 'tiny',
		__('Normal', RPT_TXTDM ) => 'small',
		__('Big', RPT_TXTDM ) => 'normal' 
	);
	return $options;
}


/* Defines recurrence font select options. */
function dmb_rpts_recu_size_options() {
	$options = array ( 
		__('Small', RPT_TXTDM ) => 'small',
		__('Normal', RPT_TXTDM ) => 'normal'  
	);
	return $options;
}


/* Defines button font select options. */
function dmb_rpts_btn_size_options() {
	$options = array ( 
		__('Small', RPT_TXTDM ) => 'small',
		__('Normal', RPT_TXTDM ) => 'normal'  
	);
	return $options;
}


/* Defines feature font select options. */
function dmb_rpts_features_size_options() {
	$options = array ( 
		__('Small', RPT_TXTDM ) => 'small',
		__('Normal', RPT_TXTDM ) => 'normal'  
	);
	return $options;
}


/* Hooks the metabox. */
add_action('admin_init', 'dmb_rpts_add_settings', 1);
function dmb_rpts_add_settings() {
	add_meta_box( 
		'rpt_pricing_table_settings', 
		'<span class="dashicons dashicons-admin-generic"></span> '.__('Settings', RPT_TXTDM ), 
		'dmb_rpts_settings_display', 
		'rpt_pricing_table', 
		'side', 
		'high'
	);
}


/* Displays the metabox. */
function dmb_rpts_settings_display() { 
	
	global $post;

	/* Retrieves select options */
	$button_behavior_options = dmb_rpts_link_behavior_options();
	$force_font = dmb_rpts_force_fonts_options();
	$title_alignment = dmb_rpts_title_alignment_options();
	$title_size = dmb_rpts_title_size_options();
	$subtitle_size = dmb_rpts_subtitle_size_options();
	$desc_size = dmb_rpts_desc_size_options();
	$price_size = dmb_rpts_price_size_options();
	$recu_size = dmb_rpts_recu_size_options();
	$btn_size = dmb_rpts_btn_size_options();
	$features_size = dmb_rpts_features_size_options();

	$settings_to_process = array(
		'_rpt_currency',
		'_rpt_open_newwindow',
		'_rpt_original_font',
		'_rpt_title_alignment',
	);

	/* Processes retrieved fields. */
	$settings = array();
	foreach ( $settings_to_process as $setting) {
		switch ($setting) {
			case '_rpt_original_font':
				$settings[$setting] = ( get_post_meta( $post->ID, $setting, true ) && get_post_meta( $post->ID, $setting, true ) != 'no' ) ? 'yes' : 'no';			
				break;
			default:
				$settings[$setting] = ( get_post_meta( $post->ID, $setting, true ) ) ? get_post_meta( $post->ID, $setting, true ) : '';
				break;
		}
	}

	$font_sizes_to_process = array(
		'_rpt_title_fontsize',
		'_rpt_subtitle_fontsize',
		'_rpt_description_fontsize',
		'_rpt_price_fontsize',
		'_rpt_recurrence_fontsize',
		'_rpt_button_fontsize',
		'_rpt_features_fontsize'
	);

	/* Processes retrieved fields. */
	$fonts = array();
	foreach ( $font_sizes_to_process as $font) {
		$fonts[$font] = ( get_post_meta( $post->ID, $font, true ) ) ? get_post_meta( $post->ID, $font, true ) : 'normal';
	}	
	
?>

<div class="dmb_settings_box">

	<div class="dmb_section_title">
		<?php /* translators: General settings */ _e('General', RPT_TXTDM ) ?>
	</div>

	<!-- Button behavior -->
	<div class="dmb_grid dmb_grid_50 dmb_grid_first">
		<div class="dmb_field_title">
			<?php _e('Button behavior', RPT_TXTDM ) ?>
		</div>
		<select class="dmb_side_select" name="table_btn_behavior">
			<?php foreach ( $button_behavior_options as $label => $value ) { ?>
			<option value="<?php echo $value; ?>"<?php selected( $settings['_rpt_open_newwindow'], $value ); ?>><?php echo $label; ?></option>
			<?php } ?>
		</select>
	</div>

	<!-- Currency sign -->
	<div class="dmb_grid dmb_grid_50 dmb_grid_last">
		<div class="dmb_field_title">
			<?php _e('Currency', RPT_TXTDM ) ?>
		</div>
		<input class="dmb_field" type="text" name="table_currency" value="<?php echo $settings['_rpt_currency']; ?>" placeholder="<?php _e('e.g. $', RPT_TXTDM ) ?>" />
	</div>

	<div class="dmb_clearfix"></div>

	<!-- Text settings switch -->
	<a class="dmb_text_settings_box_show">
		<span class="dashicons dashicons-admin-settings"></span> 
		<?php _e('Show/hide text settings', RPT_TXTDM ) ?>
	</a>

	<div class="dmb_text_settings_box">
	
		<div class="dmb_section_title">
			<?php _e('Text settings', RPT_TXTDM ) ?>
		</div>

		<!-- Choose font option -->
		<div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Font to use', RPT_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="font_size_force_font">
				<?php foreach ( $force_font as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( $settings['_rpt_original_font'], $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Choose title alignment -->
		<div class="dmb_grid dmb_grid_100 dmb_grid_first dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Title alignment', RPT_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="font_title_alignment">
				<?php foreach ( $title_alignment as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( $settings['_rpt_title_alignment'], $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<div class="dmb_clearfix"></div>

		<div class="dmb_section_title">
			<?php _e('Font sizes', RPT_TXTDM ) ?>
		</div>

		<!-- Title font size -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_first">
			<div class="dmb_field_title">
				<?php _e('Title', RPT_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="font_size_title">
				<?php foreach ( $title_size as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( $fonts['_rpt_title_fontsize'], $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Subtitle font size -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Subtitle', RPT_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="font_size_subtitle">
				<?php foreach ( $subtitle_size as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( $fonts['_rpt_subtitle_fontsize'], $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Description font size -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_first">
			<div class="dmb_field_title">
				<?php _e('Description', RPT_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="font_size_description">
				<?php foreach ( $desc_size as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( $fonts['_rpt_description_fontsize'], $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Price font size -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Price', RPT_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="font_size_price">
				<?php foreach ( $price_size as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( $fonts['_rpt_price_fontsize'], $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Recurrence font size -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_first">
			<div class="dmb_field_title">
				<?php _e('Frequency', RPT_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="font_size_recurrence">
				<?php foreach ( $recu_size as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( $fonts['_rpt_recurrence_fontsize'], $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Button font size -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_last">
			<div class="dmb_field_title">
				<?php _e('Button text', RPT_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="font_size_button">
				<?php foreach ( $btn_size as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( $fonts['_rpt_button_fontsize'], $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

		<!-- Feature font size -->
		<div class="dmb_grid dmb_grid_50 dmb_grid_first">
			<div class="dmb_field_title">
				<?php _e('Features', RPT_TXTDM ) ?>
			</div>
			<select class="dmb_side_select" name="font_size_features">
				<?php foreach ( $features_size as $label => $value ) { ?>
				<option value="<?php echo $value; ?>"<?php selected( $fonts['_rpt_features_fontsize'], $value ); ?>><?php echo $label; ?></option>
				<?php } ?>
			</select>
		</div>

	</div>

	<div class="dmb_clearfix"></div>

</div>

<?php } ?>