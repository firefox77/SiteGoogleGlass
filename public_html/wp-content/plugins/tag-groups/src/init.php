<?php
/**
* Blocks Initializer
*
* Enqueue CSS/JS of all the blocks.
*
* @since 0.38
* @package Tag Groups
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
* Enqueue Gutenberg block assets for both frontend + backend.
*
* `wp-blocks`: includes block type registration and related functions.
*
* @since 1.0.0
*/
function chatty_mango_tag_groups_block_assets() {
	// Styles.
	wp_enqueue_style(
		'chatty-mango_tag-groups-style-css', // Handle.
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
		array( 'wp-blocks' ) // Dependency to include the CSS after it.
		// filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ) // Version: filemtime — Gets file modification time.
	);
} // End function chatty_mango_tag_groups_block_assets().

// Hook: Frontend assets.
add_action( 'enqueue_block_assets', 'chatty_mango_tag_groups_block_assets' );

/**
* Enqueue Gutenberg block assets for backend editor.
*
* `wp-blocks`: includes block type registration and related functions.
* `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
* `wp-i18n`: To internationalize the block's text.
*
* @since 1.0.0
*/
function chatty_mango_tag_groups_editor_assets() {

	global $tag_groups_premium_fs_sdk;

	// Scripts.
	wp_enqueue_script(
		'chatty-mango_tag-groups-block-js', // Handle.
		plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-components', 'wp-editor' ) // Dependencies, defined above.
		// filemtime( plugin_dir_path( __FILE__ ) . 'block.js' ) // Version: filemtime — Gets file modification time.
	);


	// make some data available
	$args = array(
		'siteUrl' 	=> get_option( 'siteurl' ),
		'siteLang'	=> '',	// for future use
		'pluginUrl'	=> TAG_GROUPS_PLUGIN_URL,
		'hasPremium'	=> $tag_groups_premium_fs_sdk->can_use_premium_code(),
	);

	wp_localize_script( 'chatty-mango_tag-groups-block-js', 'ChattyMangoTagGroupsGlobal', $args );

	// Styles.
	wp_enqueue_style(
		'chatty-mango_tag-groups-block-editor-css', // Handle.
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
		// filemtime( plugin_dir_path( __FILE__ ) . 'editor.css' ) // Version: filemtime — Gets file modification time.
	);

	if ( function_exists( 'gutenberg_get_jed_locale_data' ) ) {

		wp_add_inline_script(
			'wp-i18n',
			'wp.i18n.setLocaleData(' . json_encode( gutenberg_get_jed_locale_data('tag-groups') ) . ');'
		);

	}

} // End function chatty_mango_tag_groups_editor_assets().

// Hook: Editor assets.
add_action( 'enqueue_block_editor_assets', 'chatty_mango_tag_groups_editor_assets' );
