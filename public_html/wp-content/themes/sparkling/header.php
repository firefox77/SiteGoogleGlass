<html <?php language_attributes(); ?>>

<!--[if !IE]>
<html class="no-js non-ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7 ]>
<html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>
<html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]>
<html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!-->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no"> 
<?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>	
	<div id="page" class="hfeed site">

		<header id="masthead" class="site-header" role="banner">
			<nav class="navbar navbar-default 
			<?php
			if ( of_get_option( 'sticky_header' ) ) {
				echo 'navbar-fixed-top';}
	?>
	" role="navigation">
				<div class="container">
					<div class="row">
						<div class="site-navigation-inner col-sm-12">
							<div class="navbar-header">
								<button type="button" class="btn navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								</button>

								<!--<?php header_image(); ?>-->

															<div id="logo">
																<?php if ( get_header_image() != '' ) { ?>
																		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>"  height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="<?php bloginfo( 'name' ); ?>"/></a>
																			<?php if ( is_home() ) { ?>
																			<h1 class="site-name hide-site-name"><a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
																		<?php
	}
	} else {
		echo is_home() ? '<h1 class="site-name">' : '<p class="site-name">';
		?>
																			<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
																	<?php echo is_home() ? '</h1>' : '</p>'; ?>
																<?php } ?>
															</div><!-- end of #logo -->
							</div>
							<?php sparkling_header_menu(); // main navigation ?>
						</div>
					</div>
				</div>
			</nav><!-- .site-navigation -->			
			
			<div id="search_topo" class="col-sm-12 col-xs-12">
				<aside id="search-4" class="widget widget_search col-sm-4 container">
					<form id="form" role="search" method="get" class="form-search" action="http://divulgamaisdanca.com.br/">
					  <div class="input-group">
						  <label class="screen-reader-text" for="s">Buscar:</label>
						<input type="text" class="form-control search-query" placeholder="Procurar…" value="" name="s" title="Buscar:">
						<span class="input-group-btn">
						  <button type="submit" class="btn btn-default" name="submit" id="searchsubmit" value="Pesquisar" style=""><span class="glyphicon glyphicon-search"></span></button>
						</span>
					  </div>
					</form>
				</aside>
			<!--Outro teste fim--> 
			</div>
			<div class="slider">
				<?php echo do_shortcode("[carousel_slide id='895']"); ?>	
			</div>						
		</header><!-- #masthead -->

		<div id="content" class="site-content">
			<div class="top-section">			
				<?php sparkling_call_for_action(); ?>		
			</div>

			<div class="container main-content-area testecontent">
				 
				<?php $layout_class = get_layout_class(); ?>
				<div id="row" class="<?php echo $layout_class; ?>">
					<div id="secondary" class="widget-area col-md-4 oigente2" role="complementary">
						<div class="well">
							<?php do_action( 'before_sidebar' ); ?>
							<?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>			

								<aside id="archives" class="widget">
									<h3 class="widget-title"><?php esc_html_e( 'Archives', 'sparkling' ); ?></h3>
									<ul>
										<?php
										$archives_args = array(
											'type' => 'monthly',
										);
										wp_get_archives( $archives_args );
										?>
									</ul>
								</aside>

								<aside id="meta" class="widget">
									<h3 class="widget-title"><?php esc_html_e( 'Meta', 'sparkling' ); ?></h3>
									<ul>
										<?php wp_register(); ?>
										<li><?php wp_loginout(); ?></li>
										<?php wp_meta(); ?>
									</ul>
								</aside>

							<?php endif; // end sidebar widget area ?>

						</div>
					</div><!-- #secondary -->
					<div class="main-content-inner <?php echo sparkling_main_content_bootstrap_classes(); ?>">		