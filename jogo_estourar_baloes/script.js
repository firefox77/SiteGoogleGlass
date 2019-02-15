function addBola() {
	
	var bola = document.createElement("img");
	bola.setAttribute("class", "bola");

	var p1 = Math.floor(Math.random() * 500);
	var p2 = Math.floor(Math.random() * 500);
	var color = Math.floor(Math.random() * 999999);
	var gradiente = "rgba(0, 0, 0, .7)";
	var graus = Math.floor(Math.random() * 180);
    var position = Math.floor(Math.random() * 10);

    
    bola.setAttribute("src", "meteoro.gif")
    bola.setAttribute("style",  "left:" + p1 + "px; top:" + p2 + "px; animation-name:position" + position + ";")
    bola.setAttribute("onclick", "estourar(this)");
    //bola.setAttribute("onmouseup", "clicou()");
    bola.setAttribute("id", "meteoro");
   
    document.body.appendChild(bola);

	 
    
}
  
function estourar(elemento) {
 

	document.body.removeChild(elemento);
    
   
    
}
function iniciar(){
	setInterval(addBola, 2000);

}

/*function addBola() {
	var bola = document.createElement("div");
	bola.setAttribute("class", "bola");
	var p1 = Math.floor(Math.random() * 500);
	var p2 = Math.floor(Math.random() * 400);
	bola.setAttribute("style", "left:"+p1+"px; top:"+p2+"px;");
	bola.setAttribute("onclick", "estourar(this)");

	
	document.body.appendChild(bola);
}
function estourar(elemento){
	document.body.removeChild(elemento);	 
}
function iniciar(){	
	setInterval(addBola, 1000);
}*/

