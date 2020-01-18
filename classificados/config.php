<?php
session_start(); //Inicia a sessão

global $pdo; //variavel global para pode usar em todos os locais

try{
	//$pdo = new PDo("mysql:dbname=classificados;host=localhost","wvtodoz","senha");
	$pdo = new PDo("mysql:dbname=classificados;host=localhost","root","senha");
}catch(PDOException $e){
	echo "FALHOU: ".$e->getMessage();
	exit;

}//Para fazer a conexão com o banco
?>