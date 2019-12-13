<?php

$aluno = array(
	"nome" => "Boniek",
	"idade" => 90,
	"cidade" => "PB",
	"pais" => "Brasil"
);

foreach($aluno as $chave => $dado){
	echo $chave." = ".$dado."<br/>";
}
?>