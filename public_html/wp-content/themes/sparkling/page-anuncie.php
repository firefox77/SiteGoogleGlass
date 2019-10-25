<!--?php /* Template name: Anuncie */ ?-->
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

<div class="col-sm-12">

		<main id="main" class="site-main" role="main">
			<!-- <div class="row">
						<center><h1>Planos</h1></center>						
						<div class="col-sm-3">
							<center class="planos">
								<h4 class="titulo_plano">Básico</h4>
								<p>R$100,00/ano*</p>
							</center>							
							<center class="descricao_planos">
								<p>Cadastro Básico na Plataforma</p>
							</center>
							<center>
								<p>Logo</p>
								<p>Endereço Completo</p>
							</center>							
						</div>

						<div class="col-sm-3">
							<center class="planos">
								<h4 class="titulo_plano">Profissional</h4>
								<p>R$350,00/ano*</p>
							</center>					
							<center class="descricao_planos">
								<p>Cadastro completo </p>
							</center>
							<center>
								<p>Logo</p>
								<p>Endereço Completo</p>
							</center>
						</div>

						<div class="col-sm-3">
							<center class="plano_empresa">
								<h4 class="titulo_plano_empresa">Empresarial</h4>
								<p>R$550,00/ano*</p>
							</center>
							<center class="descricao_planos">
								<p>Cadastro Completo mais Midias Sociais</p>
							</center>
							<center>
								<p>Logo</p>
								<p>Endereço Completo</p>
							</center>					
						</div>

						<div class="col-sm-3">
							<center class="planos">
								<h4 class="titulo_plano">Midias Sociais</h4>
								<p>R$200,00/ano*</p>
							</center>
							<center class="descricao_planos">
								<p>Ação de Divulgação nas mídias digitais da nossa plataforma</p>
							</center>
							<center>
								<p>Logo</p>
								<p>Endereço Completo</p>
							</center>					
						</div>	
					</div>	 -->

					<?php the_content(); ?>		
		</main><!-- #main -->
	</div><!-- #primary -->	
	

<?php get_footer(); ?>
