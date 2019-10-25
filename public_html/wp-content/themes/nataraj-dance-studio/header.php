<?php
/**
 * The header for our theme
 *
 * @package WordPress
 * @subpackage nataraj-dance-studio
 * @since 1.0
 * @version 0.1
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="<?php echo esc_url( __( 'http://gmpg.org/xfn/11', 'nataraj-dance-studio' ) ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="header">
	<div class="toggle"><a class="toggleMenu" href="#"><?php esc_html_e('Menu','nataraj-dance-studio'); ?></a></div>
	<div class="top-header">
		<div class="container">	
			<?php get_template_part( 'template-parts/header/header', 'image' ); ?>	
			<div class="row">
				<div class="col-lg-9 col-md-9 p-0">
					<div class="top">
						<span class="call">
							<?php if( get_theme_mod( 'nataraj_dance_studio_call','' ) != '') { ?>
					        <i class="fas fa-phone"></i><span class="col-org"><?php echo esc_html( get_theme_mod('nataraj_dance_studio_call',__('0123456789','nataraj-dance-studio')) ); ?></span>
					    	<?php } ?>
					    </span>	
					    <span class="call">
					    	<?php if( get_theme_mod( 'nataraj_dance_studio_mail','' ) != '') { ?>
					        <i class="fas fa-envelope"></i><span class="col-org"><?php echo esc_html( get_theme_mod('nataraj_dance_studio_mail',__('info@yourmail.com','nataraj-dance-studio')) ); ?></span>
					    	<?php } ?>
						</span>
						<span class="call">
					    	<?php if( get_theme_mod( 'nataraj_dance_studio_time','' ) != '') { ?>
					        <i class="far fa-clock"></i><span class="col-org"><?php echo esc_html( get_theme_mod('nataraj_dance_studio_time',__('Opening: 09am-5pm','nataraj-dance-studio')) ); ?></span>
					    	<?php } ?>
					    </span>		   		
					</div>	
				</div>
				<div class="col-lg-3 col-md-3 p-0">
					<div class="social-icons">
						<?php if( get_theme_mod( 'nataraj_dance_studio_facebook_url') != '') { ?>
					      <a href="<?php echo esc_url( get_theme_mod( 'nataraj_dance_studio_facebook_url','' ) ); ?>"><i class="fab fa-facebook-f" aria-hidden="true"></i></a>
					    <?php } ?>
					    <?php if( get_theme_mod( 'nataraj_dance_studio_twitter_url') != '') { ?>
					      <a href="<?php echo esc_url( get_theme_mod( 'nataraj_dance_studio_twitter_url','' ) ); ?>"><i class="fab fa-twitter"></i></a>
					    <?php } ?>
					    <?php if( get_theme_mod( 'nataraj_dance_studio_linkedin_url') != '') { ?>
					      <a href="<?php echo esc_url( get_theme_mod( 'nataraj_dance_studio_linkedin_url','' ) ); ?>"><i class="fab fa-linkedin-in"></i></a>
					    <?php } ?>
					    <?php if( get_theme_mod( 'nataraj_dance_studio_insta_url') != '') { ?>
					      <a href="<?php echo esc_url( get_theme_mod( 'nataraj_dance_studio_insta_url','' ) ); ?>"><i class="fab fa-instagram"></i></a>
					    <?php } ?>		            
					</div>	
				</div>
			</div>
		</div>
	</div>
    <div class="menu-section">
		<div class="container-fluid">
			<div class="main-top">
			    <div class="row">
			    	<div class="col-lg-3">
						<div class="logo">
					        <?php if( has_custom_logo() ){ nataraj_dance_studio_the_custom_logo();
					           }else{ ?>
					          <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					          <?php $description = get_bloginfo( 'description', 'display' );
					          if ( $description || is_customize_preview() ) : ?> 
					            <p class="site-description"><?php echo esc_html($description); ?></p>
					        <?php endif; }?>
					    </div>
					</div>
			      	<div class="col-lg-9">
						<div class="nav">
							<?php wp_nav_menu( array('theme_location'  => 'primary') ); ?>
						</div>
					</div>
			    </div>
			</div>
		</div>
	</div>	
</div>