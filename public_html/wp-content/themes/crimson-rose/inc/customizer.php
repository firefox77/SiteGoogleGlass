<?php
/**
 * Crimson Rose Theme Customizer
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Customizer support
 *
 * @since Crimson_Rose 1.01
 *
 * @param object $wp_customize
 * @return void
 */
function crimson_rose_customize_register( $wp_customize ) {
	global $crimson_rose_default;

	/**
	 * Load custom Customizer control class.
	 */
	require get_template_directory() . '/inc/class-customize-control.php';

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname', array(
				'selector'        => '.site-title a',
				'render_callback' => 'crimson_rose_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription', array(
				'selector'        => '.site-description',
				'render_callback' => 'crimson_rose_customize_partial_blogdescription',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'custom_logo_2x', array(
				'selector'        => '.site-logo',
				'render_callback' => 'crimson_rose_customize_partial_custom_logo',
			)
		);
	}

	/**
	 * Logo
	 */
	$section_id = 'title_tagline';

	$setting_id = 'custom_logo_2x';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize, $setting_id, array(
				'label'         => esc_html__( 'Retina Logo', 'crimson-rose' ),
				'priority'      => 8, /* below the logo media selector. */
				'section'       => $section_id,
				'button_labels' => array(
					'select'       => esc_html__( 'Select Retina Logo', 'crimson-rose' ),
					'change'       => esc_html__( 'Change Retina Logo', 'crimson-rose' ),
					'placeholder'  => esc_html__( 'No retina logo selected', 'crimson-rose' ),
					'frame_title'  => esc_html__( 'Select Retina Logo', 'crimson-rose' ),
					'frame_button' => esc_html__( 'Choose Retina Logo', 'crimson-rose' ),
				),
				'description'   => esc_html__( 'Select image twice the size as your original logo image for crisp display on retina screens.', 'crimson-rose' ),
			)
		)
	);

	$setting_id = 'heading_padding_top';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'number',
			'label'   => esc_html__( 'Padding Top', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'heading_padding_bottom';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'number',
			'label'   => esc_html__( 'Padding Bottom', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	/**
	 * Custom colors.
	 */
	$section_id = 'colors';

	$setting_id = 'header_background_image_color';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	if ( ! crimson_rose_is_watercolor_backgrounds_activated() ) {
		$description = sprintf(
			/* Translators: this string is a link to a self hosted WordPress plugin. */
			esc_html__( 'To add more watercolor backgrounds, please download our %s plugin.', 'crimson-rose' ),
			'<a target="_blank" href="https://webplantmedia.com/product/crimson-rose-watercolor-backgrounds-wordpress-plugin/"><span style="text-decoration:none;" class="dashicons dashicons-external"></span>' . esc_html__( 'Watercolor Backgrounds', 'crimson-rose' ) . '</a>'
		);
	} else {
		$description = esc_html__( 'Control the color of the watercolor background image in the header.', 'crimson-rose' );
	}

	$wp_customize->add_control(
		$setting_id, array(
			'type'        => 'select',
			'label'       => esc_html__( 'Header Background Image Color', 'crimson-rose' ),
			'description' => $description,
			'section'     => $section_id,
			'choices'     => apply_filters(
				'crimson-rose-header-background-image-color', array(
					'none' => esc_html__( 'No Image', 'crimson-rose' ),
					'red'  => esc_html__( 'Red', 'crimson-rose' ),
				)
			),
		)
	);

	$setting_id = 'primary_color';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, $setting_id, array(
				'label'   => esc_html__( 'Primary Color', 'crimson-rose' ),
				'section' => $section_id,
			)
		)
	);

	$setting_id = 'primary_hover_color';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, $setting_id, array(
				'label'   => esc_html__( 'Primary Hover Color', 'crimson-rose' ),
				'section' => $section_id,
			)
		)
	);

	$setting_id = 'archive_background_color';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, $setting_id, array(
				'label'   => esc_html__( 'Archive Background Color', 'crimson-rose' ),
				'section' => $section_id,
			)
		)
	);

	$setting_id = 'archive_title_light';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Display White Archive Title?', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'footer_background_color';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, $setting_id, array(
				'label'   => esc_html__( 'Footer Background Color', 'crimson-rose' ),
				'section' => $section_id,
			)
		)
	);

	$setting_id = 'footer_background_image_color';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	if ( ! crimson_rose_is_watercolor_backgrounds_activated() ) {
		$description = sprintf(
			/* Translators: this string is a link to a self hosted WordPress plugin. */
			esc_html__( 'To add more watercolor backgrounds, please download our %s plugin.', 'crimson-rose' ),
			'<a target="_blank" href="https://webplantmedia.com/product/crimson-rose-watercolor-backgrounds-wordpress-plugin/"><span style="text-decoration:none;" class="dashicons dashicons-external"></span>' . esc_html__( 'Watercolor Backgrounds', 'crimson-rose' ) . '</a>'
		);
	} else {
		$description = esc_html__( 'Control the color of the watercolor background image in the footer.', 'crimson-rose' );
	}

	$wp_customize->add_control(
		$setting_id, array(
			'type'        => 'select',
			'label'       => esc_html__( 'Footer Background Image Color', 'crimson-rose' ),
			'description' => $description,
			'section'     => $section_id,
			'choices'     => apply_filters(
				'crimson-rose-footer-background-image-color', array(
					'none' => esc_html__( 'No Image', 'crimson-rose' ),
					'red'  => esc_html__( 'Red', 'crimson-rose' ),
				)
			),
		)
	);

	$setting_id = 'footer_text_light';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Display White Footer Text?', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'link_color';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, $setting_id, array(
				'label'   => esc_html__( 'Link Color', 'crimson-rose' ),
				'section' => $section_id,
			)
		)
	);

	$setting_id = 'link_hover_color';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, $setting_id, array(
				'label'   => esc_html__( 'Link Hover Color', 'crimson-rose' ),
				'section' => $section_id,
			)
		)
	);

	/**
	 * Theme options.
	 */
	$wp_customize->add_panel(
		'theme_options', array(
			'title'    => esc_html__( 'Theme Options', 'crimson-rose' ),
			'priority' => 330, // Before Additional CSS.
		)
	);

	/**
	 * Site
	 */
	$section_id = 'theme_options_site';
	$wp_customize->add_section(
		$section_id, array(
			'title' => esc_html__( 'Site', 'crimson-rose' ),
			'panel' => 'theme_options',
		)
	);

	$setting_id = 'top_header_background_offset';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'        => 'range',
			'label'       => esc_html__( 'Top Header Background Offset', 'crimson-rose' ),
			'description' => esc_html__( 'This changes the position of your top header background so you can center it perfectly with your top header menu.', 'crimson-rose' ),
			'section'     => $section_id,
			'input_attrs' => array(
				'min'   => 0,
				'max'   => 600,
				'step'  => 1,
				'style' => 'width:100%;',
			),
		)
	);

	$setting_id = 'show_menu_arrows';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Show Menu Arrows', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'default_button_style';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'        => 'select',
			'label'       => esc_html__( 'Default Button Style', 'crimson-rose' ),
			'description' => esc_html__( 'When you insert a link on its own line in the WP Editor, the theme turns it into a button. Choose the default style of your button to display in your post and pages.', 'crimson-rose' ),
			'section'     => $section_id,
			'choices'     => array(
				'default'  => esc_html__( 'Default Button', 'crimson-rose' ),
				'button-1' => esc_html__( 'Button Style 1', 'crimson-rose' ),
				'button-2' => esc_html__( 'Button Style 2', 'crimson-rose' ),
			),
		)
	);

	$setting_id = 'disable_body_font';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Disable Body Font', 'crimson-rose' ),
			'description'     => esc_html__( 'If you are using a Google Font plugin, then you can disable the load of the body font.', 'crimson-rose' ),
			'section'         => $section_id,
			'active_callback' => 'crimson_rose_is_wpm_fonts_deactivated',
		)
	);

	$setting_id = 'disable_accent_font';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'            => 'checkbox',
			'label'           => esc_html__( 'Disable Accent Font', 'crimson-rose' ),
			'description'     => esc_html__( 'The accent font is a cursive font used in places such as your archive title. If you are using a Google Font plugin, then you can disable the load of this accent font.', 'crimson-rose' ),
			'section'         => $section_id,
			'active_callback' => 'crimson_rose_is_wpm_fonts_deactivated',
		)
	);

	$setting_id = 'page_image_header_height';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'section'     => $section_id,
			'type'        => 'range',
			'label'       => esc_html__( 'Page Image Header Height', 'crimson-rose' ),
			'description' => esc_html__( 'This changes the height of your featured image in your page header area.', 'crimson-rose' ),
			'section'     => $section_id,
			'input_attrs' => array(
				'min'   => 0,
				'max'   => 800,
				'step'  => 5,
				'style' => 'width:100%;',
			),
		)
	);

	/**
	 * Blog
	 */
	$section_id = 'theme_options_blog';
	$wp_customize->add_section(
		$section_id, array(
			'title' => esc_html__( 'Blog', 'crimson-rose' ),
			'panel' => 'theme_options',
		)
	);

	$setting_id = 'blog_display';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'select',
			'label'   => esc_html__( 'Blog Display', 'crimson-rose' ),
			'section' => $section_id,
			'choices' => array(
				'blog1' => esc_html__( 'Lead Excerpt + Grid', 'crimson-rose' ),
				'blog4' => esc_html__( 'Grid', 'crimson-rose' ),
				'blog2' => esc_html__( 'Excerpt', 'crimson-rose' ),
				'blog3' => esc_html__( 'Content', 'crimson-rose' ),
			),
		)
	);

	$setting_id = 'archive_display';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'select',
			'label'   => esc_html__( 'Archive Display', 'crimson-rose' ),
			'section' => $section_id,
			'choices' => array(
				'blog1' => esc_html__( 'Lead Excerpt + Grid', 'crimson-rose' ),
				'blog4' => esc_html__( 'Grid', 'crimson-rose' ),
				'blog2' => esc_html__( 'Excerpt', 'crimson-rose' ),
				'blog3' => esc_html__( 'Content', 'crimson-rose' ),
			),
		)
	);

	$setting_id = 'search_display';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'select',
			'label'   => esc_html__( 'Search Display', 'crimson-rose' ),
			'section' => $section_id,
			'choices' => array(
				'blog1' => esc_html__( 'Lead Excerpt + Grid', 'crimson-rose' ),
				'blog4' => esc_html__( 'Grid', 'crimson-rose' ),
				'blog2' => esc_html__( 'Excerpt', 'crimson-rose' ),
				'blog3' => esc_html__( 'Content', 'crimson-rose' ),
			),
		)
	);

	$setting_id = 'thumb_excerpt_max_height';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'section'     => $section_id,
			'type'        => 'number',
			'label'       => esc_html__( 'Thumb Excerpt Max Height', 'crimson-rose' ),
			'description' => esc_html__( 'If you have long featured images in your excerpts, set a max-height on your image. Enter 0 for no max-height', 'crimson-rose' ),
			'section'     => $section_id,
			'input_attrs' => array(
				'min'  => 0,
				'step' => 5,
			),
		)
	);

	$setting_id = 'thumb_grid_max_height';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'section'     => $section_id,
			'type'        => 'number',
			'label'       => esc_html__( 'Thumb Grid Max Height', 'crimson-rose' ),
			'description' => esc_html__( 'If you have long featured images in your grid, set a max-height on your image. Enter 0 for no max-height', 'crimson-rose' ),
			'section'     => $section_id,
			'input_attrs' => array(
				'min'  => 0,
				'step' => 5,
			),
		)
	);

	$setting_id = 'blog_single_hide_post_navigation';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Hide Post Navigation', 'crimson-rose' ),
			'description' => esc_html__( 'Hide the post navigation buttons at the bottom of each post.', 'crimson-rose' ),
			'section'     => $section_id,
		)
	);

	/**
	 * Jetpack
	 */
	$section_id = 'theme_options_jetpack';
	$wp_customize->add_section(
		$section_id, array(
			'title'           => esc_html__( 'Jetpack', 'crimson-rose' ),
			'panel'           => 'theme_options',
			'active_callback' => 'crimson_rose_is_jetpack_activated',
		)
	);

	$setting_id = 'jetpack_hide_share_count';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Hide Share Button Count', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	/**
	 * Shop
	 */
	$section_id = 'theme_options_shop';
	$wp_customize->add_section(
		$section_id, array(
			'title'           => esc_html__( 'Shop', 'crimson-rose' ),
			'panel'           => 'theme_options',
			'active_callback' => 'crimson_rose_is_woocommerce_activated',
		)
	);

	$setting_id = 'shop_columns';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'select',
			'label'   => esc_html__( 'Shop Columns', 'crimson-rose' ),
			'section' => $section_id,
			'choices' => array(
				2 => esc_html__( '2', 'crimson-rose' ),
				3 => esc_html__( '3', 'crimson-rose' ),
				4 => esc_html__( '4', 'crimson-rose' ),
			),
		)
	);

	$setting_id = 'shop_archive_columns';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'select',
			'label'   => esc_html__( 'Shop Archive Columns', 'crimson-rose' ),
			'section' => $section_id,
			'choices' => array(
				2 => esc_html__( '2', 'crimson-rose' ),
				3 => esc_html__( '3', 'crimson-rose' ),
				4 => esc_html__( '4', 'crimson-rose' ),
			),
		)
	);

	$setting_id = 'shop_related_products_columns';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'select',
			'label'   => esc_html__( 'Related Products Columns', 'crimson-rose' ),
			'section' => $section_id,
			'choices' => array(
				2 => esc_html__( '2', 'crimson-rose' ),
				3 => esc_html__( '3', 'crimson-rose' ),
				4 => esc_html__( '4', 'crimson-rose' ),
			),
		)
	);

	$setting_id = 'shop_image_backdrop';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Display Product Image Backdrop', 'crimson-rose' ),
			'description' => esc_html__( 'Add a light gray backdrop with a dropshadow for your product images. Visually helpful for images with light colored backgrounds.', 'crimson-rose' ),
			'section'     => $section_id,
		)
	);

	$setting_id = 'shop_hide_title';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Hide Shop Title From Main Shop Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'shop_hide_breadcrumbs';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Hide Breadcrumbs From Shop Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'shop_hide_stars';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Hide Product Reviews From Shop Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'shop_hide_result_count';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Hide Result Count String From Shop Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'shop_hide_catalog_ordering';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Hide Ordering Dropdown From Shop Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'shop_truncate_titles';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Truncate Product Titles', 'crimson-rose' ),
			'description' => esc_html__( 'This will cause product titles to appear in one line.', 'crimson-rose' ),
			'section'     => $section_id,
		)
	);

	$setting_id = 'shop_product_hide_stars';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Hide Product Reviews From Product Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'shop_product_hide_meta';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Hide Product Meta From Product Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'shop_disable_gallery_zoom';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Disable Gallery Zoom on Product Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'shop_disable_gallery_lightbox';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Disable Gallery Lightbox on Product Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'shop_disable_gallery_slider';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Disable Gallery Slider on Product Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	/**
	 * Display Sidebar
	 */
	$section_id = 'theme_options_display_sidebar';
	$wp_customize->add_section(
		$section_id, array(
			'title'       => esc_html__( 'Display Sidebar', 'crimson-rose' ),
			'panel'       => 'theme_options',
			'description' => esc_html__( 'Check the pages where you want the sidebar to display.', 'crimson-rose' ),
		)
	);

	$setting_id = 'display_sidebar_blog';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Blog', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'display_sidebar_post';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Post', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'display_sidebar_archive';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Archive', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'display_sidebar_search';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Search', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'display_sidebar_shop';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
			'active_callback'   => 'crimson_rose_is_woocommerce_activated',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Shop', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'display_sidebar_shop_archive';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
			'active_callback'   => 'crimson_rose_is_woocommerce_activated',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Shop Archive', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'display_sidebar_attachment';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Attachment Page', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	/**
	 * Labels
	 */
	$section_id = 'theme_options_lables';
	$wp_customize->add_section(
		$section_id, array(
			'title' => esc_html__( 'Labels', 'crimson-rose' ),
			'panel' => 'theme_options',
		)
	);

	$setting_id = 'mobile_menu_label';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'text',
			'label'   => esc_html__( 'Mobile Menu Label', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	$setting_id = 'read_more_label';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'text',
			'label'   => esc_html__( 'Read More Label', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	/**
	 * 404 Error Page
	 */
	$section_id = 'theme_options_404';
	$wp_customize->add_section(
		$section_id, array(
			'title' => esc_html__( '404 Error Page', 'crimson-rose' ),
			'panel' => 'theme_options',
		)
	);

	$setting_id = '404_custom_page';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'           => 'input',
			'label'          => esc_html__( 'Select 404 Page', 'crimson-rose' ),
			'description'    => esc_html__( 'Set the page\'s featured image for the background image to display.', 'crimson-rose' ),
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'section'        => $section_id,
		)
	);

	$setting_id = '404_cover_opacity';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'absint',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'        => 'range',
			'label'       => esc_html__( 'Page Cover Opacity', 'crimson-rose' ),
			'description' => esc_html__( 'Set opacity for 404 Page Cover\'s featured image.', 'crimson-rose' ),
			'section'     => $section_id,
			'input_attrs' => array(
				'min'   => 0,
				'max'   => 100,
				'step'  => 1,
				'style' => 'width:100%;',
			),
		)
	);

	$setting_id = '404_cover_color';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize, $setting_id, array(
				'label'   => esc_html__( 'Page Cover Color', 'crimson-rose' ),
				'section' => $section_id,
			)
		)
	);

	$setting_id = '404_text_white';
	$wp_customize->add_setting(
		$setting_id, array(
			'default'           => $crimson_rose_default[ $setting_id ],
			'transport'         => 'refresh',
			'sanitize_callback' => 'crimson_rose_sanitize_checkbox',
		)
	);

	$wp_customize->add_control(
		$setting_id, array(
			'type'    => 'checkbox',
			'label'   => esc_html__( 'Display White Text', 'crimson-rose' ),
			'section' => $section_id,
		)
	);

	if ( crimson_rose_is_wpm_fonts_deactivated() ) {
		/**
		 * Fonts
		 */
		$section_id = 'wpm_fonts';
		$wp_customize->add_section(
			$section_id, array(
				'title'    => esc_html__( 'Fonts', 'crimson-rose' ),
				'panel'    => 'theme_options',
				'priority' => 331, // Before Additional CSS.
			)
		);

		$setting_id = 'wpm_fonts_notice';
		$wp_customize->add_setting(
			$setting_id, array(
				'default'           => '',
				'transport'         => 'refresh',
				'sanitize_callback' => 'int',
			)
		);

		$wp_customize->add_control(
			new Crimson_Rose_Notice_Control(
				$wp_customize,
				$setting_id,
				array(
					'label'       => esc_html__( 'Font Customization', 'crimson-rose' ),
					'description' => sprintf(
						/* Translators: this string is a link to a self hosted WordPress plugin. */
						esc_html__( 'To easily change the font styles for your theme, please download our %s plugin.', 'crimson-rose' ),
						'<a target="_blank" href="https://webplantmedia.com/product/designer-fonts-wordpress-plugin/"><span style="text-decoration:none;" class="dashicons dashicons-external"></span>' . esc_html__( 'Designer Fonts', 'crimson-rose' ) . '</a>'
					),
					'section'     => $section_id,
					'settings'    => $setting_id,
				)
			)
		);
	}
}
add_action( 'customize_register', 'crimson_rose_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Render the site logo for the selective refresh partial.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_customize_partial_custom_logo() {
	the_custom_logo();
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_customize_preview_js() {
	wp_enqueue_script( 'crimson-rose-customizer', get_template_directory_uri() . '/js/admin/customizer.js', array( 'customize-preview' ), CRIMSON_ROSE_VERSION, true );
	wp_enqueue_script( 'crimson-rose-admin-notifier', get_template_directory_uri() . '/js/admin/admin-notifier.js', array( 'customize-preview' ), CRIMSON_ROSE_VERSION, true );
	wp_enqueue_style( 'crimson-rose-customizer-style', get_parent_theme_file_uri() . '/css/admin/customizer.css', array(), CRIMSON_ROSE_VERSION );
}
add_action( 'customize_preview_init', 'crimson_rose_customize_preview_js' );

/**
 * Sanitize the page layout options.
 *
 * @since Crimson_Rose 1.01
 *
 * @param mixed $input
 * @return int
 */
function crimson_rose_sanitize_checkbox( $input ) {
	$valid = array( 0, 1 );

	if ( in_array( $input, $valid ) ) {
		return $input;
	}

	return 0;
}
