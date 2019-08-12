<?php
try{
		$pdo = new PDO("mysql:dbname=projeto_registroporconvite;host=localhost", "wvtodoz", "senha");		
} catch(PDOException $e){
		echo "ERRO: ".$e->getMessage();
		exit;		
}