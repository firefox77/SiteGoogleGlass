<?php

/**
 * Plugin Name: Responsive Pricing Table
 * Plugin URI: https://wpdarko.com/items/responsive-pricing-table-pro/
 * Description: A responsive, easy and elegant way to present your offer to your visitors. Just create a new pricing table (custom type) and copy-paste the shortcode into your posts/pages. Find help and information on our <a href="https://wpdarko.com/ask-for-support/">support site</a>. This free version is NOT limited and does not contain any ad. Check out the <a href='http://wpdarko.com/items/responsive-pricing-table-pro/'>PRO version</a> for more great features.
 * Version: 5.0.4
 * Author: WP Darko
 * Author URI: https://wpdarko.com
 * Text Domain: dk-pricr-responsive-pricing-table
 * Domain Path: /lang/
 * License: GPL2
 */

/* Defines plugin's root folder. */
define( 'RPT_PATH', plugin_dir_path( __FILE__ ) );


/* Defines plugin's text domain. */
define( 'RPT_TXTDM', 'dk-pricr-responsive-pricing-table' );


/* General. */
require_once('inc/rpt-text-domain.php');
require_once('inc/rpt-pro-version-check.php');


/* Scripts. */
require_once('inc/rpt-front-scripts.php');
require_once('inc/rpt-admin-scripts.php');


/* Pricing tables. */
require_once('inc/rpt-post-type.php');


/* Shortcode. */
require_once('inc/rpt-shortcode-column.php');
require_once('inc/rpt-shortcode.php');


/* Registers metaboxes. */
require_once('inc/rpt-metaboxes-plans.php');
require_once('inc/rpt-metaboxes-settings.php');
require_once('inc/rpt-metaboxes-help.php');
require_once('inc/rpt-metaboxes-pro.php');


/* Saves metaboxes. */
require_once('inc/rpt-save-metaboxes.php');

?>
