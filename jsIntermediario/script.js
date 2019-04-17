// Definindo a variavel do nome do usuário.

/*
Comentário 
de 
multiplas 
linhas
*/
//var nome = "Tiago";

/*function trocarDiv(nome, idade){
	var area = document.getElementById("area");
	var texto = prompt("Qual o seu sobrenome?");

	area.innerHTML = nome+" "+texto+" tem "+idade+" anos "; 
}*/

/*function adicionarIngrediente(){
	var ing = document.getElementById("ingrediente").value;

	var listahtml = document.getElementById("lista").innerHTML;

	listahtml = listahtml + "<li>"+ing+"</li>";

	document.getElementById("lista").innerHTML = listahtml;

}*/

/*function somar(){
	var campo1 = parseInt(document.getElementById("campo1").value);
	var campo2 = parseInt(document.getElementById("campo2").value);

	var soma = campo1 + campo2;

	alert(soma);
}*/

/*function testeVerificador(){
	var x = prompt("Diga um número:");

	if (x >= 10){
		alert("É maior ou igual 10!!!");
	}else{
		alert("Não é maior que 10!");
	}
}*/

/*
------------------------------------------
	While
	var x = 0;

	document.write("Iniciando o Loop...<br/><br/>");

	while(x < 10){
		document.write("Numero: "+x+"<br/>");
		x++;
	}

	document.write("<br/>Finalizando o Loop...<br/>");
------------------------------------------
*/

/*
------------------------------------------
	For
	obs. No for eu defino a variavel, determino a condição, incremento, depois jogo na tela

	for(x = 0; x < 10; x++){
		document.write("Numero "+x+"<br/>");
	}
------------------------------------------
*/

/*
------------------------------------------
	Switch
	x = prompt("Qual é o número?");

		switch(x){
			case "0":
				alert("X é o 0");
				break;
			case "1":
				alert("X é o 1");
				break;
			case "2":
				alert("X é o 2");
				break;
			default:
				alert("Ninguém foi satisfeito!");
				break;
		}
------------------------------------------
*/

/*function verificar(){
	var n1 = document.getElementById("n1").innerHTML;
	var n2 = document.getElementById("n2").value;

	if(n1 == n2){
		alert("VOCÊ ACERTOU O NÚMERO!");
	}else{
		alert("VOCÊ ERROU!");
	}

	resetar();
}

function resetar(){
	document.getElementById("n2").value = "";

	var r = Math.floor(Math.random() * 100);
	document.getElementById("n1").innerHTML = r;	
}*/

function apertouMouse(){
	console.log("APERTOU O MOUSE!");
}
function soltouMouse(){
	console.log("SOLTOU O MOUSE!");
}
function mouseEmCima(){
	console.log("MOUSE PASSOU POR CIMA!");
}
function mouseSaiuDeCima(){
	console.log("MOUSE SAIU DE CIMA");
}
function moveuMouse(){
	console.log("MOUSE FOI MOVIDO");
}