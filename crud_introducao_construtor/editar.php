<?php
include 'contato.class.php';
$contato = new Contato();

if(!empty($_GET['id'])){
	$id = $_GET['id'];

	$info = $contato->getInfo($id);

	if(empty($info['email'])){
		header("Location: index.php");
		exit;
	}
}else{
	header("Location: index.php");
	exit;
}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Editar</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="assets/bootstrap/bootstrap.min.css">
		<style>
			.container{
				display: flex;
				flex-direction: column;
				max-width: 600px;
				border: 3px solid #dcdcdc;
				margin-top: 20px;	
				padding: 20px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<h1>Editar</h1>
			<form method="POST" action="editar_submit.php">				
			  <div class="form-group">
			  	<input type="hidden" name="id" value="<?php echo $info['id']; ?>" />
			    <label>Nome</label>
			    <input type="text" name="nome" value="<?php echo $info['nome']; ?>" required="nome" class="form-control" placeholder="Digite seu nome">
			  </div>
			  <div class="form-group">
			    <label>E-mail</label>
			    <?php echo $info['email']; ?><br/><br/>
			  </div>	  			  
			  <input type="submit" value="Salvar" class="btn btn-primary"/>
			  <a href="index.php" value="Voltar" class="btn btn-warning"/>Voltar</a>
			</form>

		</div>
	</body>
</html>