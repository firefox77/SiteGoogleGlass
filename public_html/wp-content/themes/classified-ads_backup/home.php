<?php
/*
* Template Name:Home page
* 
*/
?>
<!DOCTYPE html>
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
<body <?php body_class(); ?> >
<header id="header-home">
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
<main id="main" role="main">
		 <div class="nextpage"> <?php classified_ads_mb_pagination(); ?></div>
		<section>
			<!-- Start dynamic -->
				<?php if(have_posts()): while (have_posts()): the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class((is_sticky()?'sticky':'')); ?>>
					<a href="<?php the_permalink(); ?>">
						<div class="img-ad">
							<div class="sticky-img"></div>
							<?php
							if ( has_post_thumbnail() ) { 
								the_post_thumbnail( 'custom-size' );
							}
							else {
							if(!has_post_thumbnail()) {
							echo "<div class=\"img-def\"> </div>";
							}			 
							}
							?> 
						</div>
					</a>
					<div class="article-right">
						<h2> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<div class="ad">					
							<em class="entry-date"><small><?php _e('Posted by: ', 'classified-ads' ); ?> </small>  <?php the_author() ?></em> <em class="entry-date"> <small><?php _e('On: ', 'classified-ads' ); ?>  </small>  <?php echo get_the_date(); ?></em>						
						</div>	
						<?php the_excerpt(); ?>
						<div class="tag-s"> <?php the_tags( 'Tags: ',' '  ); ?> </div>
					</div>
				</article>
				<?php endwhile; endif; ?>
			<!-- End dynamic -->
		</section>
		<?php get_sidebar(); ?>
		<div class="nextpage"> <?php classified_ads_mb_pagination(); ?></div>
	</main>
<?php get_footer(); ?>