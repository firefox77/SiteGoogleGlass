<?php require 'config.php'; ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Classificados</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="assets/css/style.css" />
		<script type="text/javascript" src="assets/js/jquery.min.js"></script> <!--Nos scripts o jquery sempre antes do bootstrap-->
		<script type="text/javascript" src="assets/js/bootstrap.min.js"></script> 
		<script type="text/javascript" src="assets/js/script.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-inverse"><!--usando bootstrap. O navbar-inverse deixa o fundo escuro-->
			<div class="container-fluid"><!--container-fluid pega de ponta a ponta da tela-->
				<div class="navbar-header"><!--Cabeçalho do Topo-->
					<a href="./" class="navbar-brand">Classificados</a>	<!--O link carrega a mesma pagina-->				
				</div>
				<ul class="nav navbar-nav navbar-right"><!--navbar-nav deixa os elementos um do lado do outro-->
					<!--Leitura da linha abaixo: Se login existir e não estiver vazio-->
					<?php if(isset($_SESSION['cLogin']) && !empty($_SESSION['cLogin'])): ?> <!--Verificando se a pessoa esta logada através da sessão-->
						<li><a><?php echo $_SESSION['cLogin']['nome']; ?></a></li>						
						<li><a href="meus-anuncios.php">Meus Anúncios</a></li>
						<li><a href="sair.php">Sair</a></li>
					<?php else: ?><!--Leitura: caso contrario, manter essa informação em exibição.-->
						<li><a href="cadastre-se.php">Cadastre-se</a></li>
						<li><a href="login.php">Login</a></li>
					<?php endif; ?>
				</ul>		
			</div>			
		</nav>