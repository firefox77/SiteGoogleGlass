<?php get_header(); ?>	
<!-- Start dynamic -->
	<main id="main" role="main">
		<section>
			<?php if(have_posts()): while (have_posts()):the_post(); ?>  
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>		
				<?php edit_post_link('Edit', '', ''); ?>
				<h2><a href="<?php the_permalink();?>"><?php the_title(); ?></a></h2>
				<p class="img">			 
					<?php
					if ( has_post_thumbnail() ) { 
					the_post_thumbnail( 'custom-size' );
					} 
					else {
						if(!has_post_thumbnail()) {
					echo "<div class=\"img-def-single\"> </div>"; }								 
					}
					
					?> 
				</p>
				<div class="content"><?php the_content();?></div>
				<div class="meta-box-vision">
				<table>
					<tr><th><strong>Contacts:</strong></th></tr>
					<?php get_template_part( 'content', 'single' ); ?>
				</table>
				</div>
					<small>Posted by: </small> <em><?php the_author() ?></em> <small>on</small>	
					<em class="entry-date"> <?php echo get_the_date(); ?></em>
				<div class="tag-s"> <?php the_tags( 'Tags: ',' '  ); ?> </div>
				<div class="postpagination">
				  <span class="prevpost"><?php previous_post_link('%link', __(' <span class="meta-nav">&larr;</span>previous', 'classified-ads')); ?></span>
				 <span class="nextpost"><?php next_post_link('%link', __('next <span class="meta-nav">&rarr;</span>', 'classified-ads')); ?></span>
				</div>
		   </article>
			<div class="commen"><?php if (comments_open() || get_comments_number()) { comments_template(); } ?></div>
			<?php endwhile; endif; ?>
<!-- End dynamic -->
		</section>
<?php get_sidebar(); ?>
	</main>
<?php get_footer(); ?>