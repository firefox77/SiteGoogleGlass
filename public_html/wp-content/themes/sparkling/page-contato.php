<?php
/* 
Template name: Contato
*/

$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')); $numSegments = count($segments);
get_header(); ?>
	<main id="main" class="site-main contato" role="main">
		<div class="row">			
			<div class="col-sm-6 col-xs-12">
				<?php echo do_shortcode("[wpforms id='816']"); ?>					
			</div>
			<div class="col-sm-6 col-xs-12">			
				<div class="contatos">				
					<h1><?php the_title(); ?></h1>			
					<?php the_meta(); ?>
				</div>
			</div>
		</div>		
	</main><!-- #main -->	
<?php get_footer(); ?>
<!-- <script>
	// console.log(jQuery('.contatos ul.post-meta li'));
	jQuery('.contatos ul.post-meta li').eq(0).append('<img src="http://divulgamaisdanca.com.br/wp-content/uploads/2018/12/phone-call.png" id="teste5" class="you">')
	jQuery('.contatos ul.post-meta li').eq(1).append('<img src="http://divulgamaisdanca.com.br/wp-content/uploads/2018/12/email.png" id="teste5" class="you">')
	jQuery('.contatos ul.post-meta li').eq(2).append('<img src="http://divulgamaisdanca.com.br/wp-content/uploads/2018/12/facebook-1.png" id="teste5" class="you">')
	jQuery('.contatos ul.post-meta li').eq(3).append('<img src="http://divulgamaisdanca.com.br/wp-content/uploads/2018/12/instagram.png" id="teste5" class="you">')


	
	// jQuery('.contatos ul.post-meta li').css('color', 'blue');
	// console.log(jQuery('.contato_titulo'));
</script> -->
