<?php require 'pages/header.php'; ?>
<?php
if(empty($_SESSION['cLogin'])){
	?>
	<script type="text/javascript">window.location.href="Login.php";</script>
	<?php
	exit;
}

require 'classes/anuncios.class.php';
$a = new Anuncios();
if(isset($_POST['titulo']) && !empty($_POST['titulo'])){
	$titulo = addslashes($_POST['titulo']);
	$categoris = addcslashes(str, charlist)
}


?>
<div class="container">
	<h1>Meus Anúncios - Adicionar Anúncios</h1>

	<form method="POST" enctype="multipart/form-data">

		<div class="form-goup">
			<label for="categoria">Categoria:</label>
			<select name="categoria" id="categoria" class="form-control">
				<?php
				require 'classes/categorias.class.php';
				$c = new Categorias();
				$cats = $c->getLista();
				foreach($cats as $cat):					
				?>
				<option value="<?php echo $cat['id']; ?>"><?php echo utf8_encode($cat['nome']); ?></option>
				<?php
				endforeach; 
				?>			
			</select>			
		</div>
		<div class="form-goup">
			<label for="titulo">Titulo:</label>
			<input type="text" name="titulo" id="titulo" class="form-control"/>			
		</div>
		<div class="form-goup">
			<label for="valor">Valor:</label>
			<input type="text" name="valor" id="valor" class="form-control"/>
		</div>
		<div class="form-goup">
			<label for="descricao">Descrição:</label>
			<textarea class="form-control" name="descricao"></textarea>		
		</div>
		<div class="form-goup">
			<label for="estado">Estado de conservação:</label>
			<select name="categoria" id="categoria" class="form-control">
				<option value="0">Ruim</option>				
				<option value="1">Bom</option>				
				<option value="2">Ótimo</option>				
			</select>	
		</div>
		<input type="submit" value="Adicionar" class="btn btn-default">		
	</form>
	
</div>

<?php require 'pages/footer.php'; ?>


<!-- Parei no minuto 11:17 -->