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
}
------------------------------------------
*/


/*Eventos de teclado

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
	function clicou(){
		console.log("CLICOU!");
	}
	function botaoDireito(){
		console.log("BOTAO DIREITO");

		return false;
	}
	function cliqueDuplo(){
		console.log("CLICOU DUAS VEZES...");
	}
------------------------------------------
*/

/*Eventos de teclado
	function apertouTecla(event){
		if(event.shiftKey == true){
			console.log("Apertou alguma tecla com shift...");
		}	
	}

	function apertouTecla(event){
		if(event.shiftkey == true && event.keycode == 69){
			console.log("Apertou SHIFT + E");
		}
	}
------------------------------------------
*/

/*Eventos de Página:


function carregou(){
	alert("Pagina carregada");
}
-------------------------------------------
*/

/*function mudouOpcao(objeto){
	console.log("Selecionou :"+objeto.value);
}
function focou(){
	console.log("Fcou no campo 1");
}
function desfocou(){
	console.log("Desfocou do campo1");
}*/

/*function addBola(){
	var bola = document.createElement("div",);
	bola.setAttribute("class","bola");
	var p1 = Math.floor(Math.random() * 1300);
	var p2 = Math.floor(Math.random() * 420);
	var idCor = Math.floor(Math.random() * 6);
	var hd = ["green", "black", "orange", "blue", "pink", "red"]; //cor hexa decimal
	var cor = hd[idCor];
	bola.setAttribute("style", "left:"+p1+"px; top:"+p2+"px; background-color:"+cor);
	bola.setAttribute("onmousemove", "estourar(this)");

	document.body.appendChild(bola); //add elemento na tela
}
function estourar(elemento){
	document.body.removeChild(elemento); //remove o elemento da tela
	document.getElementById('placar').innerHTML++;
}
function iniciar(){
	setInterval(addBola, 1000);
}*/

function validar(){

	var valor = document.getElementById("numero").value;

	if(valor.length > 2){
		alert("Você digitou numero com mais de 2 algarismos!");
		return false;
	}else{
		return true;
	}

}