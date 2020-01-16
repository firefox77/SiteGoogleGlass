<?php require 'pages/header.php'; ?>
<?php
if(empty($_SESSION['cLogin'])){
	?>
	<script type="text/javascript">window.location.href="login.php"</script>
	<?php
	exit; 
}
?>
<div class="container">
	<h1>Meus Anúncios -  Adicionar Anúncios</h1>
	
	<form method="POST" enctype="multipart/form-data">
		<div class="form-group">
			<label for="categoria">Categoria:</label>
			<select name="categoria" id="categoria">
				<option></option>				
			</select>			
		</div>
	</form>

</div>
<?php require 'pages/footer.php'; ?>

<!--Parei no minuto 03:16 da aula 06-->