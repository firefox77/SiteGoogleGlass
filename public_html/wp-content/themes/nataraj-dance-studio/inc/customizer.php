<?php
/**
 * nataraj-dance-studio: Customizer
 *
 * @package WordPress
 * @subpackage nataraj-dance-studio
 * @since 1.0
 */

function nataraj_dance_studio_customize_register( $wp_customize ) {

	$wp_customize->add_panel( 'nataraj_dance_studio_panel_id', array(
	    'priority' => 10,
	    'capability' => 'edit_theme_options',
	    'theme_supports' => '',
	    'title' => __( 'Theme Settings', 'nataraj-dance-studio' ),
	    'description' => __( 'Description of what this panel does.', 'nataraj-dance-studio' ),
	) );

	$wp_customize->add_section( 'nataraj_dance_studio_theme_options_section', array(
    	'title'      => __( 'General Settings', 'nataraj-dance-studio' ),
		'priority'   => 30,
		'panel' => 'nataraj_dance_studio_panel_id'
	) );

	// Add Settings and Controls for Layout
	$wp_customize->add_setting('nataraj_dance_studio_theme_options',array(
        'default' => __('Right Sidebar','nataraj-dance-studio'),
        'sanitize_callback' => 'nataraj_dance_studio_sanitize_choices'	        
	));

	$wp_customize->add_control('nataraj_dance_studio_theme_options',array(
        'type' => 'radio',
        'label' => __('Do you want this section','nataraj-dance-studio'),
        'section' => 'nataraj_dance_studio_theme_options_section',
        'choices' => array(
            'Left Sidebar' => __('Left Sidebar','nataraj-dance-studio'),
            'Right Sidebar' => __('Right Sidebar','nataraj-dance-studio'),
            'One Column' => __('One Column','nataraj-dance-studio'),
            'Three Columns' => __('Three Columns','nataraj-dance-studio'),
            'Four Columns' => __('Four Columns','nataraj-dance-studio'),
            'Grid Layout' => __('Grid Layout','nataraj-dance-studio')
        ),
	));

	// Contact Details
	$wp_customize->add_section( 'nataraj_dance_studio_contact_details', array(
    	'title'      => __( 'Contact Details', 'nataraj-dance-studio' ),
		'priority'   => null,
		'panel' => 'nataraj_dance_studio_panel_id'
	) );

	$wp_customize->add_setting('nataraj_dance_studio_call',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('nataraj_dance_studio_call',array(
		'label'	=> __('Contact Number','nataraj-dance-studio'),
		'section'=> 'nataraj_dance_studio_contact_details',
		'setting'=> 'nataraj_dance_studio_call',
		'type'=> 'text'
	));

	$wp_customize->add_setting('nataraj_dance_studio_mail',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('nataraj_dance_studio_mail',array(
		'label'	=> __('Email Address','nataraj-dance-studio'),
		'section'=> 'nataraj_dance_studio_contact_details',
		'setting'=> 'nataraj_dance_studio_mail',
		'type'=> 'text'
	));	

	$wp_customize->add_setting('nataraj_dance_studio_time',array(
		'default'=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('nataraj_dance_studio_time',array(
		'label'	=> __('Timing','nataraj-dance-studio'),
		'section'=> 'nataraj_dance_studio_contact_details',
		'setting'=> 'nataraj_dance_studio_time',
		'type'=> 'text'
	));	

	//social icons
	$wp_customize->add_section('nataraj_dance_studio_topbar_header',array(
		'title'	=> __('Social Icons','nataraj-dance-studio'),
		'description'	=> __('Add Header Content here','nataraj-dance-studio'),
		'priority'	=> null,
		'panel' => 'nataraj_dance_studio_panel_id',
	));

	$wp_customize->add_setting('nataraj_dance_studio_facebook_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('nataraj_dance_studio_facebook_url',array(
		'label'	=> __('Add Facebook link','nataraj-dance-studio'),
		'section'	=> 'nataraj_dance_studio_topbar_header',
		'setting'	=> 'nataraj_dance_studio_facebook_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('nataraj_dance_studio_twitter_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('nataraj_dance_studio_twitter_url',array(
		'label'	=> __('Add Twitter link','nataraj-dance-studio'),
		'section'	=> 'nataraj_dance_studio_topbar_header',
		'setting'	=> 'nataraj_dance_studio_twitter_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('nataraj_dance_studio_linkedin_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));
	$wp_customize->add_control('nataraj_dance_studio_linkedin_url',array(
		'label'	=> __('Add Linkedin link','nataraj-dance-studio'),
		'section'	=> 'nataraj_dance_studio_topbar_header',
		'setting'	=> 'nataraj_dance_studio_linkedin_url',
		'type'	=> 'url'
	));

	$wp_customize->add_setting('nataraj_dance_studio_insta_url',array(
		'default'	=> '',
		'sanitize_callback'	=> 'esc_url_raw'
	));	
	$wp_customize->add_control('nataraj_dance_studio_insta_url',array(
		'label'	=> __('Add Instagram link','nataraj-dance-studio'),
		'section'	=> 'nataraj_dance_studio_topbar_header',
		'setting'	=> 'nataraj_dance_studio_insta_url',
		'type'	=> 'url'
	));

	//home page slider
	$wp_customize->add_section( 'nataraj_dance_studio_slider_section' , array(
    	'title'      => __( 'Slider Settings', 'nataraj-dance-studio' ),
		'priority'   => null,
		'panel' => 'nataraj_dance_studio_panel_id'
	) );

	$wp_customize->add_setting('nataraj_dance_studio_slider_hide_show',array(
       	'default' => 'true',
       	'sanitize_callback'	=> 'sanitize_text_field'
	));
	$wp_customize->add_control('nataraj_dance_studio_slider_hide_show',array(
	   	'type' => 'checkbox',
	   	'label' => __('Show / Hide slider','nataraj-dance-studio'),
	   	'section' => 'nataraj_dance_studio_slider_section',
	));

	for ( $count = 1; $count <= 4; $count++ ) {

		// Add color scheme setting and control.
		$wp_customize->add_setting( 'nataraj_dance_studio_slider' . $count, array(
			'default'           => '',
			'sanitize_callback' => 'nataraj_dance_studio_sanitize_dropdown_pages'
		) );

		$wp_customize->add_control( 'nataraj_dance_studio_slider' . $count, array(
			'label'    => __( 'Select Slide Image Page', 'nataraj-dance-studio' ),
			'section'  => 'nataraj_dance_studio_slider_section',
			'type'     => 'dropdown-pages'
		) );
	}

	//	Terms and Condition
	$wp_customize->add_section('nataraj_dance_studio_service',array(
		'title'	=> __('Our Features','nataraj-dance-studio'),
		'description'=> __('This section will appear below the slider.','nataraj-dance-studio'),
		'panel' => 'nataraj_dance_studio_panel_id',
	));

	$wp_customize->add_setting('nataraj_dance_studio_our_services_title',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('nataraj_dance_studio_our_services_title',array(
		'label'	=> __('Section Title','nataraj-dance-studio'),
		'section'	=> 'nataraj_dance_studio_service',
		'setting'	=> 'nataraj_dance_studio_our_services_title',
		'type'		=> 'text'
	));

	$categories = get_categories();
	$cats = array();
	$i = 0;
	$cat_pst[]= 'select';
	foreach($categories as $category){
		if($i==0){
			$default = $category->slug;
			$i++;
		}
		$cat_pst[$category->slug] = $category->name;
	}

	$wp_customize->add_setting('nataraj_dance_studio_category_setting',array(
		'default'	=> 'select',
		'sanitize_callback' => 'sanitize_text_field',
	));
	$wp_customize->add_control('nataraj_dance_studio_category_setting',array(
		'type'    => 'select',
		'choices' => $cat_pst,
		'label' => __('Select Category to display Post','nataraj-dance-studio'),
		'section' => 'nataraj_dance_studio_service',
	));

	//Footer
    $wp_customize->add_section( 'nataraj_dance_studio_footer', array(
    	'title'      => __( 'Footer Text', 'nataraj-dance-studio' ),
		'priority'   => null,
		'panel' => 'nataraj_dance_studio_panel_id'
	) );

    $wp_customize->add_setting('nataraj_dance_studio_footer_copy',array(
		'default'	=> '',
		'sanitize_callback'	=> 'sanitize_text_field'
	));	
	$wp_customize->add_control('nataraj_dance_studio_footer_copy',array(
		'label'	=> __('Footer Text','nataraj-dance-studio'),
		'section'	=> 'nataraj_dance_studio_footer',
		'setting'	=> 'nataraj_dance_studio_footer_copy',
		'type'		=> 'text'
	));

	$wp_customize->get_setting( 'blogname' )->transport          = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport   = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport  = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'blogname', array(
		'selector' => '.site-title a',
		'render_callback' => 'nataraj_dance_studio_customize_partial_blogname',
	) );
	$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
		'selector' => '.site-description',
		'render_callback' => 'nataraj_dance_studio_customize_partial_blogdescription',
	) );

	//front page
	$num_sections = apply_filters( 'nataraj_dance_studio_front_page_sections', 4 );

	// Create a setting and control for each of the sections available in the theme.
	for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {
		$wp_customize->add_setting( 'panel_' . $i, array(
			'default'           => false,
			'sanitize_callback' => 'nataraj_dance_studio_sanitize_dropdown_pages',
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( 'panel_' . $i, array(
			/* translators: %d is the front page section number */
			'label'          => sprintf( __( 'Front Page Section %d Content', 'nataraj-dance-studio' ), $i ),
			'description'    => ( 1 !== $i ? '' : __( 'Select pages to feature in each area from the dropdowns. Add an image to a section by setting a featured image in the page editor. Empty sections will not be displayed.', 'nataraj-dance-studio' ) ),
			'section'        => 'theme_options',
			'type'           => 'dropdown-pages',
			'allow_addition' => true,
			'active_callback' => 'nataraj_dance_studio_is_static_front_page',
		) );

		$wp_customize->selective_refresh->add_partial( 'panel_' . $i, array(
			'selector'            => '#panel' . $i,
			'render_callback'     => 'nataraj_dance_studio_front_page_section',
			'container_inclusive' => true,
		) );
	}
}
add_action( 'customize_register', 'nataraj_dance_studio_customize_register' );

function nataraj_dance_studio_customize_partial_blogname() {
	bloginfo( 'name' );
}

function nataraj_dance_studio_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

function nataraj_dance_studio_is_static_front_page() {
	return ( is_front_page() && ! is_home() );
}

function nataraj_dance_studio_is_view_with_layout_option() {
	// This option is available on all pages. It's also available on archives when there isn't a sidebar.
	return ( is_page() || ( is_archive() && ! is_active_sidebar( 'sidebar-1' ) ) );
}

/**
 * Singleton class for handling the theme's customizer integration.
 *
 * @since  1.0.0
 * @access public
 */
final class Nataraj_Dance_Studio_Customize {

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function __construct() {}

	/**
	 * Sets up initial actions.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function setup_actions() {

		// Register panels, sections, settings, controls, and partials.
		add_action( 'customize_register', array( $this, 'sections' ) );

		// Register scripts and styles for the controls.
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_control_scripts' ), 0 );
	}

	/**
	 * Sets up the customizer sections.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object  $manager
	 * @return void
	 */
	public function sections( $manager ) {

		// Load custom sections.
		load_template( trailingslashit( get_template_directory() ) . '/inc/section-pro.php' );

		// Register custom section types.
		$manager->register_section_type( 'Nataraj_Dance_Studio_Customize_Section_Pro' );

		// Register sections.
		$manager->add_section(
			new Nataraj_Dance_Studio_Customize_Section_Pro(
				$manager,
				'example_1',
				array(
					'priority' => 9,
					'title'    => esc_html__( 'Dancing Pro Theme', 'nataraj-dance-studio' ),
					'pro_text' => esc_html__( 'Go Pro','nataraj-dance-studio' ),
					'pro_url'  => esc_url( 'https://www.luzuk.com/themes/dance-studio-wordpress-theme/' ),
				)
			)
		);
	}

	/**
	 * Loads theme customizer CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_control_scripts() {

		wp_enqueue_script( 'nataraj-dance-studio-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/js/customize-controls.js', array( 'customize-controls' ) );

		wp_enqueue_style( 'nataraj-dance-studio-customize-controls', trailingslashit( get_template_directory_uri() ) . '/assets/css/customize-controls.css' );
	}
}

// Doing this customizer thang!
Nataraj_Dance_Studio_Customize::get_instance();