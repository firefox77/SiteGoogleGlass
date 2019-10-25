<?php
/**
 * Add theme page for up-selling services and software
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
 * Store service text in array for reuse. Used in theme inc/theme-info.php
 *
 * @since Crimson_Rose 1.01
 *
 * @return array
 */
function crimson_rose_dashboard_get_services() {
	$services = array(
		array(
			'short'       => esc_html__( 'Documentation', 'crimson-rose' ),
			'title'       => esc_html__( 'Theme Documentation', 'crimson-rose' ),
			'link'        => 'https://webplantmedia.com/product/crimson-rose-wordpress-theme/',
			'description' => esc_html__( 'Every theme option and theme feature is well documented on our product page. Find out all the amazing features coded within our theme.', 'crimson-rose' ),
		),
		array(
			'short'       => esc_html__( 'Support', 'crimson-rose' ),
			'title'       => esc_html__( 'Extended WordPress Support', 'crimson-rose' ),
			'link'        => 'https://webplantmedia.com/product/extended-wordpress-support/',
			'description' => esc_html__( 'If you are using one of our themes, and need WordPress support, a little CSS hack, or some custom debugging support for your WordPress site, then you can purchase extended WordPress support. We are WordPress experts, and will quickly and efficiently take care of your site problem or need.', 'crimson-rose' ),
		),
		array(
			'short'       => esc_html__( 'Font Customizer Plugin', 'crimson-rose' ),
			'title'       => esc_html__( 'Designer Fonts Plugin', 'crimson-rose' ),
			'link'        => 'https://webplantmedia.com/product/designer-fonts-wordpress-plugin/',
			'description' => esc_html__( 'Use our Designer Fonts plugin to quickly and easily customize the default fonts on your theme. Easily change your site title font, heading font, accent font, and body font, from your Customizer panel using our Designer Fonts plugin.', 'crimson-rose' ),
		),
		array(
			'title'       => esc_html__( 'Watercolor Backgrounds Plugin', 'crimson-rose' ),
			'link'        => 'https://webplantmedia.com/product/crimson-rose-watercolor-backgrounds-wordpress-plugin/',
			'description' => esc_html__( 'To add more watercolor background options in your Customizer for your header and footer areas of your theme, please download our Watercolor Backgrounds plugin.', 'crimson-rose' ),
		),
	);

	return $services;
}

/**
 * Static feed to helpful posts for first time WordPress users.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_dashboard_static_feed() {
	$blog = array(
		array(
			'title' => esc_html__( 'The Best Setup For Your Self Hosted WordPress Shopping Site and Blog', 'crimson-rose' ),
			'link'  => 'https://webplantmedia.com/the-best-setup-for-your-wordpress-shopping-site-and-blog/',
		),
		array(
			'title' => esc_html__( 'How to Transfer and Migrate Your Site Content from WordPress.com to a Self Hosted WordPress.org Site on Bluehost &#8211; Step By Step Instructions', 'crimson-rose' ),
			'link'  => 'https://webplantmedia.com/how-to-transfer-and-migrate-your-site-content-from-wordpress-com-to-a-self-hosted-wordpress-org-site-on-bluehost-step-by-step-instructions/',
		),
		array(
			'title' => esc_html__( 'WordPress.com vs WordPress.org: What is the Difference?', 'crimson-rose' ),
			'link'  => 'https://webplantmedia.com/wordpress-com-vs-wordpress-org-what-is-the-difference/',
		),
		array(
			'title' => esc_html__( 'The Best Managed WordPress Hosting for Your Small Business Site', 'crimson-rose' ),
			'link'  => 'https://webplantmedia.com/the-best-managed-wordpress-hosting-for-your-small-business-site/',
		),
	);
	?>

	<?php foreach ( $blog as $post ) : ?>
		<div>
			<span class="dashicons dashicons-thumbs-up" style="color:#82878c;float:left;"></span>
			<p style="overflow:hidden;padding-left:10px;">
				<a target="_blank" href="<?php echo esc_attr( $post['link'] ); ?>"><?php echo $post['title']; /* WPCS: XSS OK. Already escaped. */ ?></a>
			</p>
		</div>
	<?php endforeach; ?>

	<?php
}

/**
 * Add theme page for up-sell
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_theme_info() {
	add_theme_page( esc_html__( 'Theme Add-ons', 'crimson-rose' ), esc_html__( 'Theme Add-ons', 'crimson-rose' ), 'edit_theme_options', 'crimson-rose-theme-info', 'crimson_rose_theme_page' );
}
add_action( 'admin_menu', 'crimson_rose_theme_info' );

/**
 * Load theme info page. Modified from core.
 *
 * @since Crimson_Rose 1.01
 *
 * @return void
 */
function crimson_rose_theme_page() {
	require get_parent_theme_file_path() . '/inc/theme-info.php';
}
