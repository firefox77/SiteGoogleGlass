<?php
/**
 * Content to display for add_theme_page.
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

wp_enqueue_script( 'underscore' );

$title = esc_html__( 'Theme Info', 'crimson-rose' );

$display_version = CRIMSON_ROSE_VERSION;
?>
	<div class="wrap about-wrap full-width-layout">

		<style>
			.wp-badge {
				background: #3a8323 url("<?php echo esc_url( get_template_directory_uri() ); ?>/img/leaf-logo-white.png") no-repeat !important;
				background-position: center 25px !important;
				background-size: 80px 80px !important;
			}
		</style>
		
		<h1>
		<?php
			/* Translators: this string is the currenty theme version number. */
			printf( esc_html__( 'Crimson Rose WordPress Theme - Version&nbsp;%s', 'crimson-rose' ), esc_html( $display_version ) );
		?>
		</h1>

		<?php /* Translators: this string is a link to the theme authors page. */ ?>
		<p class="about-text"><?php printf( esc_html__( 'Thank you for using a WordPress theme by %s! We are dedicated to making premium coded themes with beautiful designs that are open source, easy to use, and fast to install.', 'crimson-rose' ), '<a href="https://webplantmedia.com" target="_blank">' . esc_html__( 'Web Plant Media', 'crimson-rose' ) . '</a>' ); ?></p>
		<div class="wp-badge"><?php esc_html_e( 'Web Plant Media', 'crimson-rose' ); ?></div>

		<div style="margin-bottom:40px;">

			<h2 style="font-size:1.4em;font-weight:600;text-align:left;">
			<?php
				printf(
					/* translators: %s: smiling face with smiling eyes emoji */
					esc_html__( 'Premium Themes with Support %s', 'crimson-rose' ),
					'&#x1F60A'
				);
			?>
			</h2>

			<?php $services = crimson_rose_dashboard_get_services(); ?>

			<div class="under-the-hood two-col">

				<?php foreach ( $services as $service ) : ?>

					<div class="col">

						<h3 style="margin:1.33em 0;font-size:1em;line-height:inherit;color:#23282d;">
							<a target="_blank" href="<?php echo esc_url( $service['link'] ); ?>"><?php echo $service['title']; /* WPCS: XSS OK. already escaped */ ?></a>
						</h3>
						<p><?php echo $service['description']; /* WPCS: XSS OK. HTML output. */ ?></p>

					</div>

				<?php endforeach; ?>

			</div>

		</div>

		<hr />

		<div style="margin-bottom:40px;">

			<h2 style="font-size:1.4em;font-weight:600;text-align:left;"><?php echo esc_html__( 'Help Articles by WordPress Experts', 'crimson-rose' ); ?></h2>

			<div class="under-the-hood two-col">

				<div class="col">

					<?php crimson_rose_dashboard_static_feed(); ?>

				</div>

			</div>

		</div>

	</div>
<?php

return;
