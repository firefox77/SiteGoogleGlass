<?php
session_start();

global $pdo;

try{
	$pdo = new PDO("mysql:dbname=classificados;host=localhost", "wvtodoz","senha");

} catch(PDOExceptio $e){
	echo "FALHOU: ".$e->getMessage();
	exit;
}
?>