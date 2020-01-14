<!DOCTYPE html>
<html>
	<head>
		<title>Formulário Básico</title>
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">		
			<h1>Formulário Básico</h1>
			<?php 
				if(isset($_POST['email']) && empty($_POST['email']) == false){
					if(isset($_POST['senha']) && empty($_POST['senha']) ==  false)
					$email = $_POST['email'];
					$senha = $_POST['senha'];

					echo "Meu email eh: ".$email." e minha senha  é: ".$senha;
				} 
			?>		
			<form method="POST">
				<label>E-mail:</label>
				<input type="text" name="email"><br/><br/>

				<label>Senha:</label>
				<input type="password" name="senha"><br/><br/>

				<input type="submit" value="Enviar Dados" class="btn btn-default">
			</form>
		</div>
	</body>
</html>