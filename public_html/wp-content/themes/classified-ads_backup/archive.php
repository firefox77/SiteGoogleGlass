<?php 
/*
Template Name: Archives
*/
get_header(); ?>	
	<main id="main" role="main">

		<section>

<!-- Start dynamic -->

		<?php if(have_posts()): while (have_posts()): the_post(); ?>
		
		   <article>

                    <?php edit_post_link('Edit', '', ''); ?>
			<h2><a href="<?php the_permalink();?>"> <?php the_title(); ?></a></h2>
				 <p class="img">
					 <?php 
								if ( has_post_thumbnail() ) { the_post_thumbnail( 'custom-size' );} 
						 else {
							if(!has_post_thumbnail()) {
							echo "<div class=\"img-def\"> </div>";
							}					 
						}		
					?>
				</p>
					<div class="content"><?php the_content();?></div>

		   </article>
		   
		<?php endwhile; endif; ?>

<!-- End dynamic -->

		</section>
<?php get_sidebar(); ?>
	</main>
<?php get_footer(); ?>