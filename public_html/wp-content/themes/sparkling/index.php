<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */
get_header(); ?>	
	<div id="primary" class="content-area">		
		<main id="main" class="site-main col-xs-12" role="main">			
			<?php     
		        global $post;
		        $args = array( 'posts_per_page' => 10, 'order'=> 'DESC', 'orderby' => 'title' );
		        $postslist = get_posts( $args );

		        foreach ( $postslist as $post ) :
		          setup_postdata( $post ); ?> 
		          <div class="row content_area">
		            <?php         
		              echo '<a href="' . get_permalink( $_post->ID ) . the_title('<h3 style="text-align: center;">', '</h3>') . esc_attr( $_post->post_title ) . '">';                
		                echo '<div class="conteudo-post col-sm-3 col-xs-6" style="margin-bottom: 10px;">';
		                    echo get_the_post_thumbnail( $_post->ID, 'thumbnail' );                       
		                  echo '</div>';
		              echo '</a>';

		              the_excerpt();

		              echo '<a href="'. get_permalink( $_post->ID ). esc_attr( $_post->post_title ) . '" type="button" class="btn btn-default pull-right info">Veja mais informações</a>';
		            ?>
		          </div>
		        <?php
		        endforeach; 
		        wp_reset_postdata();
		    	?>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();


	