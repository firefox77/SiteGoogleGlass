<?php
/**
 * 
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header>
	<div class="top"><div id="site-login"><?php wp_register('',''); wp_loginout(); ?></div></div>
	<div  id="header-img" style="background: url('<?php header_image(); ?>') no-repeat; height:<?php echo get_custom_header()->height; ?>%; background-size: 100% 100%; background-position: center;" >
		<div id="header" >
			<a class="site-name" href="<?php echo esc_url(home_url('/')); ?>"><h1><?php bloginfo('name'); ?></h1></a>
			<p class="description"><?php bloginfo('description'); ?></p>
					<div class="postanad">
						<a href="<?php echo esc_url( home_url() ); ?>/wp-admin/">
						<?php 
						if ( !get_theme_mod( 'classified_ads_post_ad' )) { echo "Post An Ad"; }
							else {
								if ( get_theme_mod( 'classified_ads_post_ad' )) { ?>
								<div id="postads">
									<span><?php echo get_theme_mod( 'classified_ads_post_ad' ); ?></span>
								</div>
						<?php } }?>
						</a>
					</div>		
		</div>
	  </div>
</header>
	<nav>
		<div class="nav-ico">
		<a href="#" id="menu-icon">	
			<span class="menu-button"> </span>
			<span class="menu-button"> </span>
			<span class="menu-button"> </span>
		</a>
	 	 <?php
			wp_nav_menu ( array('theme_location' => 'menu-top',
			'container' => ''
		)); ?>
		</div>	
	</nav>