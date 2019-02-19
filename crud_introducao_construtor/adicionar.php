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
			    <input type="text" name="nome" class="form-control" placeholder="Digite seu nome">			    
			  </div>
			  <div class="form-group">
			    <label>E-mail</label>
			    <input type="email" name="email" class="form-control" placeholder="Digite seu email">	    
			  </div>	  			  
			  <input type="submit" value="adicionar" class="btn btn-primary"/>
			</form>	

		</div>
	</body>
</html>



<!-- <form method="POST" action="adicionar_submit.php">
	Nome:<br/>
	<input type="text" name="nome"><br/><br/>

	E-mail:<br/>
	<input type="email" name="email"><br/><br/>

	<input type="submit" value="adicionar">
	
</form> -->

