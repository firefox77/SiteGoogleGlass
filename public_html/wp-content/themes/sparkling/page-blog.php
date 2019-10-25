<!--?php /* Template name: Blog */ ?-->
<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package sparkling
 */

get_header(); ?>  
  <div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
     <?php     
        global $post;
        $args = array( 'posts_per_page' => 10, 'order'=> 'DESC', 'orderby' => 'title' );
        $postslist = get_posts( $args );
        foreach ( $postslist as $post ) :
          setup_postdata( $post ); ?> 
          <div class="row page_blog">
            <?php         
              echo '<a href="' . get_permalink( $_post->ID ) . the_title('<h3 style="text-align: center;">', '</h3>') . esc_attr( $_post->post_title ) . '">';                
                echo '<div class="conteudo-post col-sm-3 col-xs-4">';
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
<?php get_sidebar('aux'); ?>
<?php get_footer(); ?>
