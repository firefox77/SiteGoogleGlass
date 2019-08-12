<head>
	<meta charset="utf-8">
</head>

<?php
try{
	$pdo = new PDO("mysql:dbname=projeto_comentarios;host=localhost;charset=utf8", "wvtodoz", "senha");
} catch(PDOException $e) {
	echo "Erro: ".$e->getMessage();
	exit;
}
/*var_dump($_POST);
exit;*/

if(isset($_POST['nome']) && empty($_POST['nome']) == false){
	$nome = $_POST['nome'];
	$mensagem = $_POST['mensagem'];

	$sql = $pdo->prepare("INSERT INTO mensagens SET nome = :nome, msg = :msg, data_msg = NOW()");
	$sql->bindValue(":nome", $nome);
	$sql->bindValue(":msg", $mensagem);
	$sql->execute();
}
?>
<fieldset>
	<form method="POST"> 
		Nome:<br/>
		<input type="text" name="nome" /><br/><br/>

		Mensagem:<br/>
		<textarea name="mensagem"></textarea><br/><br/>

		<input type="submit" onclick="this.form.submit()" value="Enviar Mensagem" />
	</form>
</fieldset>
<br/><br/>

<?php

/*
1. calcular a quantidade total de páginas.
2. definir o $c.
3. fazer a query com LIMIT
*/
	$qt_por_pagina = 6;

	$total = 0;
	$sql = "SELECT COUNT(*) as c FROM mensagens";
	$sql = $pdo->query($sql);
	$sql = $sql->fetch();
	$total = $sql['c'];
	$paginas = $total / $qt_por_pagina;		

	$pg = 1;
	if(isset($_GET['c']) && !empty($_GET['c'])){
		$pg = addslashes($_GET['c']);
	}
	$c = ($pg - 1) * $qt_por_pagina;


	$sql = "SELECT *,date_format(data_msg,'%d-%m-%Y') as data_msg_formatada FROM mensagens ORDER BY data_msg DESC LIMIT $c, 5";
	$sql = $pdo->query($sql);
	if($sql->rowCount() > 0){ 
		foreach($sql->fetchAll() as $mensagem):
			?>			
			<strong><?php echo $mensagem['nome']; ?></strong><br/>
			<?php echo $mensagem['msg']; ?><br/>
			<?php echo $mensagem['data_msg_formatada']; ?>
			<hr/>
			<?php
		endforeach;
	} else {
		echo "Não há mensagens.";
	}

	echo "<hr/>";
	for($q=0;$q<$paginas;$q++){
		echo '<a href="./?c='.($q+1).'">['.($q+1).']</a>';
	} 
	
?>