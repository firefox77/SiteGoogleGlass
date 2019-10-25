<?php
/*
* A Simple Category Template
*/
 get_header(); ?>
	
<main id="main" role="main">
	<div class="nextpage"> <?php classified_ads_mb_pagination(); ?></div>
		<section>	
<!-- Start dynamic -->
			<?php if(have_posts()): while (have_posts()): the_post(); ?>
			<article id="post-<?php the_ID(); ?>"  <?php post_class((is_sticky()?'sticky':'')); ?>>
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
					<div class="article-right">				
					<h1> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>				
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