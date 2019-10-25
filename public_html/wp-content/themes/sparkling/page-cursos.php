<?php
/* 
Template name: Aprender
*/ 

  $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')); $numSegments = count($segments);
get_header(); ?>
    
    <div role="main">      

      <?php if($numSegments == 1) : ?>              
      
          
        
          <?php 
            $posts = get_children('orderby=menu_order&order=asc&post_parent=1181&post_status=publish');
            foreach ($posts as $post): setup_postdata($post);                 
          ?>       
          <div class="col-sm-12 minha_borda">             
            <div class="col-sm-3" style="padding: 10px;">                    
              <img src="<?php echo get_the_post_thumbnail_url(null, array(115, 115)) ?>" class="img-responsive fotos_politicos thumb_page">        
            </div>
            <div class="col-sm-9" style="margin-right: -20px !important; padding: 10px;">
              <?php 
                echo '<a href="' . get_permalink( $_post->ID ) . the_title('<h3 style="text-align: center;">', '</h3>') . esc_attr( $_post->post_title ) . '">'; 
                echo '</a>';
                ?>              
                         
              <p><?php the_excerpt(); ?></p>
              <a href="<?php the_permalink(); ?>" class="btn btn-default btn-md pull-right projetos_politico fundo_botao">Veja mais informações</a>   
            </div>              
          </div>            
          <?php endforeach; ?>
        
      
      
    </div>      
    
    <?php else : ?>

    <div class="col-sm-12">     
      <div class="minha_borda">           
        <div class="destaque_img">
          <h2><strong><?php the_title(); ?></strong></h2>
          <?php the_post_thumbnail('img-responsive'); ?>
        </div>
        <div class="col-sm-12" style="margin-top: 15px;">          
          <?php while ( have_posts() ) : the_post(); ?>
          <!--<h3 class="data_atualizado"><strong>Atualizado em (<?php the_date('d/n/Y - H:i:s'); ?>)</strong></h3>-->
          <?php the_content(); ?>          
          <div id="campo-personalizado" style="padding: 10px 15px; margin: 0px; text-decoration: none; list-style: none; width: 100%; border-radius: 7px; border: 1px solid #ccc; box-sizing: border-box; margin-bottom: 15px;">
            <?php the_meta(); ?>
            <!-- <div class="col-sm-offset-9 col-sm-3">
                <?php echo do_shortcode("[DISPLAY_ULTIMATE_PLUS]"); ?>  
              </div> -->  
          </div>
          <?php endwhile; ?>            
        </div>              
      </div>   
    </div>

    </div>
    <?php endif; ?> 
  
<?php get_sidebar(); ?>
<?php get_footer(); ?>
