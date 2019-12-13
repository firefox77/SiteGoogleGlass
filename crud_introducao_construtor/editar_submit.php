<?php 
include 'contato.class.php';
$contato = new Contato();

if(!empty($_POST['id'])){
	$nome = $_POST['nome'];
	$id = $_POST['id'];

	$contato->editar($nome, $id);
	
	header("Location: index.php");
}