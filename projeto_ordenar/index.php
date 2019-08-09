<!DOCTYPE html>
<html>
	<head>
		<title>Projeto Ordenar</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	</head>
	<body>
		<?php //conexão com o banco
			try{
				$pdo = new PDO("mysql:dbname=projeto_ordenar;host=localhost", "wvtodoz", "senha");	
			} catch(PDOException $e){
				echo "ERRO: ".$e->getMessage();
				exit;
			}
			if(isset($_GET['ordem']) && !empty($_GET['ordem'])){
				$ordem = addslashes($_GET['ordem']);
				$sql = "SELECT * FROM usuarios ORDER BY ".$ordem; //consultando a tabela usuários
			} else{
				$ordem = "";
				$sql = "SELECT * FROM usuarios";
			}
		?>
		<div class="table-responsive" style="margin:20px;">
			<form method="GET">
				<label>Ordenar Por:</label>
				<select name="ordem" onchange="this.form.submit()"> <!-- Ao mudar a opção atualiza/envia o fomulário -->
					<option value=""></option>		
					<option value="nome" <?php echo ($ordem == "nome")?'selected="selected"':''; ?>>Nome</option>	
					<option value="idade" <?php echo ($ordem == "idade")?'selected="selected"':''; ?>>Idade</option>
				</select>	
			</form>		
			<table border="1" width="400" class="table-condensed">
				<tr>
					<th>Nome</th>
					<th>Idade</th>
				</tr>
				<?php			
				
				$sql = $pdo->query($sql);
				if($sql->rowCount() > 0){
					foreach($sql->fetchAll() as $usuario):
						?>
						<tr>
							<td><?php echo $usuario['nome']; ?></td>
							<td><?php echo $usuario['idade']; ?></td>
						</tr>	
						
						<?php
					endforeach;
				}
				?>	
			</table>
		</div>
	</body>
</html>

