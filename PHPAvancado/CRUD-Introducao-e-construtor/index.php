<link rel="stylesheet" type="text/css" href="assets/bootstrap/bootstrap.min.css">

<style>
	.container{
		display: flex;
		flex-direction: column;
		max-width: 646px;
		border: 3px solid #dcdcdc;
		margin-top: 20px;	
		padding: 20px;
	}
	th{		
		text-align: center;
		padding: 10px;
	}	
	td{
		padding: 10px;
	}
	/* .botoes{
		display: flex;		
		justify-content: center;
	
	} */
	.botoes a{
		margin-left: 10px;
		padding: 5px;

	}
</style>

<?php 
	include 'contato.class.php';
	$contato = new Contato();	
?>

<div class="container">
	<h1>Contatos</h1>

	<a href="adicionar.php">[ Adicionar ]</a>
	<table border="1" width="600">
		<tr>
			<th>ID</th>
			<th>NOME</th>
			<th>E-MAIL</th>
			<th>AÇÕES</th>
		</tr>
		<?php
		$lista = $contato->getAll();
		foreach ($lista as $item): 
		?>
			<tr>
				<td><?php echo $item['id']; ?></td>
				<td><?php echo $item['nome']; ?></td>
				<td><?php echo $item['email']; ?></td>
				<td class="botoes">
					<a href="editar.php?id=<?php echo $item['id']; ?>">[ EDITAR ]</a>
					<a href="excluir.php?id=<?php echo $item['id']; ?>" class="btn btn-danger">[ EXCLUIR ]</a>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>


