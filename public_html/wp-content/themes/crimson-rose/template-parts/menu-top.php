<?php
/**
 * Partials template for displaying top navigation in header.php
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! has_nav_menu( 'menu-3' ) && ! has_nav_menu( 'menu-2' ) && ! has_nav_menu( 'social' ) ) {
	return;
}
?>

<div class="top-header">
	<div class="site-boundary">
		<div class="top-left-header">
			<?php if ( has_nav_menu( 'menu-2' ) ) : ?>
				<nav id="top-left-navigation" class="top-left-header-menu header-menu" role="navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-2',
							'depth'          => 2,
							'fallback_cb'    => false,
							'container'      => 'ul',
							'menu_id'        => 'top-left-menu',
							'menu_class'     => 'menu',
						)
					);
					?>
				</nav>
			<?php endif; ?>
		</div>
		<div class="top-right-header">
			<?php
			if ( has_nav_menu( 'social' ) ) :
			?>
				<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'crimson-rose' ); ?>">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'social',
								'depth'          => 1,
								'fallback_cb'    => false,
								'container'      => 'ul',
								'menu_class'     => 'menu social-links-menu',
								'link_before'    => '<span class="screen-reader-text">',
								'link_after'     => '</span>',
							)
						);
					?>
				</nav><!-- .social-navigation -->
			<?php endif; ?>

			<?php if ( has_nav_menu( 'menu-3' ) ) : ?>
				<nav id="top-right-navigation" class="top-right-header-menu header-menu" role="navigation">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-3',
							'depth'          => 2,
							'fallback_cb'    => false,
							'container'      => 'ul',
							'menu_id'        => 'top-right-menu',
							'menu_class'     => 'menu',
						)
					);
					?>
				</nav>
			<?php endif; ?>
		</div>
	</div>
</div>
