<?php
/* 
Template name: Workshop
*/ 

  $segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')); $numSegments = count($segments);
get_header(); ?>
    
    <div role="main">      

      <?php if($numSegments == 1) : ?>              
      
      <div class="col-sm-12">       
        <div class="row">
          <?php 
            $posts = get_children('orderby=menu_order&order=asc&post_parent=1193&post_status=publish');
            foreach ($posts as $post): setup_postdata($post);                 
          ?>       
          <div class="col-sm-12 minha_borda">             
            <div class="col-sm-4" style="padding: 10px;">                    
              <img src="<?php echo get_the_post_thumbnail_url(null, array(115, 115)) ?>" class="img-responsive fotos_politicos thumb_page">              
            </div>
            <div class="col-sm-8 estado_politico" style="margin-right: -20px !important; padding: 10px;">
              <?php 
                echo '<a href="' . get_permalink( $_post->ID ) . the_title('<h3 style="text-align: center;">', '</h3>') . esc_attr( $_post->post_title ) . '">'; 
                echo '</a>';
                ?>


              
              
              <p><?php echo get_post_meta(get_the_ID(), 'cargo', true) ?></p>
              <p><?php echo get_post_meta(get_the_ID(), 'ano_eleicao', true) ?></p>             
              <p><?php the_excerpt(); ?></p>
              <a href="<?php the_permalink(); ?>" class="btn btn-default btn-md pull-right projetos_politico fundo_botao">Veja mais informações</a>   
            </div>              
          </div>            
          <?php endforeach; ?>
        </div>
      </div>
      
    </div>      
    
    <?php else : ?>

    <div class="fundo_politicos col-sm-12">
     <!-- <div class="row">
        <div class="col-sm-2">
          <?php the_post_thumbnail('img-responsive'); ?>
        </div>
        <div class="col-sm-10">
          <h2 class="projetos_detalhados_titulo"><strong><?php the_title(); ?></strong></h2>          
        </div>
      </div>-->
      <div class="row minha_borda">           
        <div class="col-sm-6" style="padding-top: 20px;">
          <?php the_post_thumbnail('img-responsive'); ?>
        </div>
        <div class="col-sm-6">
          <h2 class="projetos_detalhados_titulo"><strong><?php the_title(); ?></strong></h2>
          <?php while ( have_posts() ) : the_post(); ?>
          <!--<h3 class="data_atualizado"><strong>Atualizado em (<?php the_date('d/n/Y - H:i:s'); ?>)</strong></h3>-->
          <?php the_content(); ?>
          <?php endwhile; ?>            
        </div>              
      </div>   
    </div>

    </div>
    <?php endif; ?> 
  
<?php get_sidebar(); ?>
<?php get_footer(); ?>
