<?php
/**
 * One click demo import
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
 * Set import files
 *
 * @since Crimson_Rose 1.01
 *
 * @return array
 */
function crimson_rose_ocdi_import_files() {
	return array(
		array(
			'import_file_name'             => 'Full Demo Import',
			'local_import_file'            => trailingslashit( get_template_directory() ) . 'demo/crimson-rose.wordpress.xml',
			'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'demo/crimson-rose.widgets.wie',
			'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'demo/crimson-rose.customizer.dat',
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'crimson_rose_ocdi_import_files' );

/**
 * Clear sidebars during import
 *
 * @since Crimson_Rose 1.01
 *
 * @param array $selected_import
 * @return void
 */
function crimson_rose_ocdi_before_widgets_import( $selected_import ) {
	$clear_sidebars = array(
		'widgetized-page',
		'footer-1',
		'footer-2',
		'footer-3',
		'sidebar-1',
	);

	/*
	 * if ( $selected_import['import_file_name'] == 'Full Demo Import' ) {
	 *     array_unshift( $clear_sidebars, 'sidebar-1' );
	 * }
	 */

	$sidebars_widgets = get_option( 'sidebars_widgets' );

	if ( is_array( $sidebars_widgets ) ) {
		foreach ( $sidebars_widgets as $sidebar_id => $widgets ) {
			if ( in_array( $sidebar_id, $clear_sidebars ) ) {
				if ( is_array( $widgets ) ) {
					foreach ( $widgets as $key => $widget_id ) {
						$pieces       = explode( '-', $widget_id );
						$multi_number = array_pop( $pieces );
						$id_base      = implode( '-', $pieces );
						$widget       = get_option( 'widget_' . $id_base );
						unset( $widget[ $multi_number ] );
						update_option( 'widget_' . $id_base, $widget );
						unset( $sidebars_widgets[ $sidebar_id ][ $key ] );
					}
				}
			}
		}
	}

	wp_set_sidebars_widgets( $sidebars_widgets );
}
add_action( 'pt-ocdi/before_widgets_import', 'crimson_rose_ocdi_before_widgets_import' );

/**
 * Cleared problem with refreshing page after import.
 *
 * @since Crimson_Rose 1.01
 *
 * @param object $current_screen
 * @return void
 */
function crimson_rose_current_screen( $current_screen ) {
	if ( 'appearance_page_pt-one-click-demo-import' == $current_screen->base ) {
		delete_transient( 'ocdi_importer_data' );
	}
}
add_action( 'current_screen', 'crimson_rose_current_screen' );

/**
 * Set nav menu in widgets.
 *
 * @since Crimson_Rose 1.01
 *
 * @param int $sidebar_id
 * @param int $menu_term_id
 * @return void
 */
function crimson_rose_update_widget_nav_menu( $sidebar_id, $menu_term_id ) {
	$widgets            = wp_get_sidebars_widgets();
	$widget_option_name = 'widget_nav_menu';

	if ( ! empty( $widgets ) && isset( $widgets[ $sidebar_id ] ) ) {
		foreach ( $widgets[ $sidebar_id ] as $widget ) {
			preg_match( '/^nav_menu-(\d+)$/', $widget, $match );

			if ( ! empty( $match ) && isset( $match[1] ) ) {
				$name = $match[0];
				$id   = $match[1];
				$data = get_option( $widget_option_name );

				if ( ! empty( $data ) && is_array( $data ) && array_key_exists( $id, $data ) ) {
					$data[ $id ]['nav_menu'] = $menu_term_id;
					update_option( $widget_option_name, $data );
				}
			}
		}
	}
}

/**
 * Automate common changes after import
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_ocdi_after_import_setup() {
	$menus = array();

	// Assign menus to their locations.
	$menu_1 = get_term_by( 'name', 'Primary', 'nav_menu' );

	if ( ! $menu_1 ) {
		$menu_1 = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
	}

	if ( ! $menu_1 ) {
		$menu_1 = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	}

	if ( isset( $menu_1->term_id ) ) {
		$menus['menu-1'] = $menu_1->term_id;
	}

	$menu_2 = get_term_by( 'name', 'Top Left Menu', 'nav_menu' );

	if ( isset( $menu_2->term_id ) ) {
		$menus['menu-2'] = $menu_2->term_id;
	}

	$menu_3 = get_term_by( 'name', 'Top Right Menu', 'nav_menu' );

	if ( isset( $menu_3->term_id ) ) {
		$menus['menu-3'] = $menu_3->term_id;
	}

	$social_menu = get_term_by( 'name', 'Social Links Menu', 'nav_menu' );

	if ( isset( $social_menu->term_id ) ) {
		$menus['social'] = $social_menu->term_id;
	}

	if ( ! empty( $menus ) ) {
		set_theme_mod( 'nav_menu_locations', $menus );
	}

	// update custom menu widget with correct menu.
	$footer_menu = get_term_by( 'name', 'Quick Links', 'nav_menu' );
	if ( isset( $footer_menu->term_id ) ) {
		$sidebar_id = 'footer-2';
		crimson_rose_update_widget_nav_menu( $sidebar_id, $footer_menu->term_id );

	}

	// posts or page.
	$front_page_display = 'page';

	if ( 'posts' == $front_page_display ) {
		// Assign front page to display posts.
		update_option( 'show_on_front', 'posts' );
	} else {
		// Assign front page and posts page (blog page).
		$front_page_id = get_page_by_title( 'Home' );
		$blog_page_id  = get_page_by_title( 'Blog' );

		if ( isset( $front_page_id->ID ) ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $front_page_id->ID );
		}
		if ( isset( $blog_page_id->ID ) ) {
			update_option( 'page_for_posts', $blog_page_id->ID );
		}
	}
}
add_action( 'pt-ocdi/after_import', 'crimson_rose_ocdi_after_import_setup' );

/**
 * Set into text
 *
 * @since Crimson_Rose 1.01
 *
 * @param string $default_text
 * @return string
 */
function crimson_rose_ocdi_plugin_intro_text( $default_text ) {
	$html      = '<div class="ocdi__intro-text">';
		$html .= '<p class="about-description">' . esc_html__( 'Importing demo data (post, pages, images, theme settings, ...) is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch.', 'crimson-rose' ) . '</p>';
		$html .= '<hr>';

		$html .= '<p><strong>' . esc_html__( 'Before Your Import:', 'crimson-rose' ) . '</strong></p>';

		$html     .= '<ul>';
			$html .= '<li>' . esc_html__( 'No existing posts, pages, categories, images, or custom post types will be deleted or modified.', 'crimson-rose' ) . '</li>';
			/* Translators: this string is a link to the widgets page on the dashboard. */
			$html .= '<li>' . sprintf( esc_html__( 'When doing a "Full Demo Import", your %s will be cleared, and replaced with our demo sidebar widgets.', 'crimson-rose' ), '<a href="' . esc_url( admin_url( 'widgets.php' ) ) . '" target="_blank">' . esc_html__( 'sidebar widgets', 'crimson-rose' ) . '</a>' ) . '</li>';
			$html .= '<li>' . esc_html__( 'Please click on the Import button only once and wait, it can take a couple of minutes.', 'crimson-rose' ) . '</li>';
		$html     .= '</ul>';

		$html .= '<p><strong>' . esc_html__( 'After Your Import:', 'crimson-rose' ) . '</strong></p>';

		$html .= '<ul>';
			/* Translators: this string is a link to the menu page on the dashboard. */
			$html .= '<li>' . sprintf( esc_html__( 'We try to set your menu, front page, and blog page, automatically. If your menu is not set, please %s.', 'crimson-rose' ), '<a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'set your menu manually', 'crimson-rose' ) . '</a>' ) . '</li>';
		$html     .= '</ul>';

		$html .= '<hr>';
	$html     .= '</div>';

	return $html;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'crimson_rose_ocdi_plugin_intro_text' );

/**
 * Disable branding
 */
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

/**
 * Better support for slower internet connections
 *
 * @link https://github.com/proteusthemes/one-click-demo-import/blob/master/docs/import-problems.md
 *
 * @since Crimson_Rose 1.01
 *
 * @return int
 */
function crimson_rose_ocdi_change_time_of_single_ajax_call() {
	return 10;
}
add_action( 'pt-ocdi/time_for_one_ajax_call', 'crimson_rose_ocdi_change_time_of_single_ajax_call' );
