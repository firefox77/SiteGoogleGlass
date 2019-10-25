<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package WordPress
 * @subpackage Crimson_Rose
 * @since 1.01
 * @author Chris Baldelomar <chris@webplantmedia.com>
 * @copyright Copyright (c) 2018, Chris Baldelomar
 * @link https://webplantmedia.com/product/crimson-rose-wordpress-theme/
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 */

?>
<!doctype html>
<html id="master" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'crimson-rose' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-header-inner">
			<?php get_template_part( 'template-parts/menu', 'top' ); ?>

			<div class="site-branding">
				<div class="site-boundary">
					<?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
						<div class="site-logo">
							<?php the_custom_logo(); ?>
						</div>
					<?php endif; ?>

					<?php if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif; ?>

					<?php $description = get_bloginfo( 'description', 'display' ); ?>
					<?php if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php endif; ?>
				</div><!-- .site-boundary -->
			</div><!-- .site-branding -->
		</div><!-- .site-header-inner -->

		<div id="site-navigation" class="main-navigation">
			<div class="site-boundary">
				<?php crimson_rose_mobile_menu_button(); ?>

				<?php get_template_part( 'template-parts/menu', 'mobile-cart' ); ?>
				<nav class="main-menu in-menu-bar">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
					?>
				</nav>

				<?php get_template_part( 'template-parts/menu', 'cart' ); ?>

				<?php get_template_part( 'template-parts/menu', 'mobile' ); ?>
			</div><!-- .site-boundary -->
		</div><!-- #site-navigation -->
	</header><!-- #masthead -->

	<?php if ( is_category() || is_tag() || is_tax() || is_date() || is_author() ) : ?>
		<header class="archive-page-header">
			<div class="site-boundary">
				<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			</div><!-- .site-boundary -->
		</header><!-- .page-header -->
	<?php elseif ( is_search() ) : ?>
		<header class="archive-page-header">
			<div class="site-boundary">
				<h1 class="page-title">
					<span class="archive-type"><?php esc_html_e( 'Search Results for:', 'crimson-rose' ); ?></span>
					<span class="archive-title"><?php echo get_search_query(); ?></span>
				</h1>
			</div>
		</header><!-- .page-header -->

	<?php endif; ?>

	<?php if ( crimson_rose_display_header_image() ) : ?>
		<?php $url = get_the_post_thumbnail_url( get_the_ID(), 'full' ); ?>
		<div class="page-image-header">
			<div class="page-image-header-background" style="background-image:url('<?php echo esc_url( $url ); ?>');"></div>
		</div><!-- .entry-image -->
	<?php endif; ?>

	<div id="content" class="site-content">
		<div class="site-boundary">
