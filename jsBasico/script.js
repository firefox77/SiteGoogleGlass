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

function somar(){
	var campo1 = parseInt(document.getElementById("campo1").value);
	var campo2 = parseInt(document.getElementById("campo2").value);

	var soma = campo1 + campo2;

	alert(soma);
}