<!DOCTYPE html>
<html>
	<head>
		<title>Adicionar</title>
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
			<h1>Adicionar</h1>
			<form method="POST" action="adicionar_submit.php">
			  <div class="form-group">
			    <label>Nome</label>
			    <input type="text" name="nome" required="nome" class="form-control" placeholder="Digite seu nome">
			  </div>
			  <div class="form-group">
			    <label>E-mail</label>
			    <input type="email" name="email" required="email" class="form-control" placeholder="Digite seu email">	    
			  </div>	  			  
			  <input type="submit" value="Adicionar" class="btn btn-primary"/>
			  <a href="index.php" value="Voltar" class="btn btn-warning"/>Voltar</a>
			</form>

		</div>
	</body>
</html>