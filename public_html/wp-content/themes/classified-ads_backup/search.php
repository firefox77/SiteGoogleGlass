<?php get_header(); ?>	
	<main id="main" role="main">
		<section>  <?php if (have_posts()) : ?>
		<!-- Search Results -->
   <?php while (have_posts()) : the_post(); ?>

<!-- Start dynamic -->

		   <article class="search-article"> 
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
					<h2> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>				
						<div class="ad">					
							<em class="entry-date"><small><?php _e('Posted by: ', 'classified-ads' ); ?> </small>  <?php the_author() ?></em> <em class="entry-date"> <small><?php _e('On: ', 'classified-ads' ); ?>  </small>  <?php echo get_the_date(); ?></em>						
						</div>						
						<?php the_excerpt(); ?>					
						<div class="tag-s"> <?php the_tags( 'Tags: ',' '  ); ?> </div>				
					</div>
 		   </article>  
   <?php endwhile; ?>
<div class="nextpage"> <?php classified_ads_mb_pagination(); ?></div> 
<?php else : ?>
  <h1 class="result">No results found. Try again.<?php _e(" </a>", 'classified-ads'); ?></h1>
		<?php  
			endif;
		?>

<!-- End dynamic -->

		</section>
<?php get_sidebar(); ?>
	</main>
<?php get_footer(); ?>