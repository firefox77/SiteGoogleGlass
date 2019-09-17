<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- As 3 meta tags acima *devem* vir em primeiro lugar dentro do `head`; qualquer outro conteúdo deve vir *após* essas tags -->
    <title>Democracia Cristã Jovem</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim e Respond.js para suporte no IE8 de elementos HTML5 e media queries -->
    <!-- ALERTA: Respond.js não funciona se você visualizar uma página file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
    	body{
    		background: url(assets/imgs/bg.png) repeat;
    	}    	
    	
    	#topoheader{
    		display: flex;
    		flex-direction: row;
    		width: 100%;
    		max-width: 1098px;    		
    		position: relative;
    		background: url(assets/imgs/topo.png) no-repeat;
    		background-position: 513px 7px;
    		background-size: 50%; 
    		/* background: orange; */
    		margin: auto;     		
    	} 
    	.logo{
    		margin-top: 23px;
    		width: 465px;
    		height: auto;
    	}
    	.logo img{
    		filter: invert(10%);
    		box-shadow: 0px 0px 5px #000;
    	}
    	#busca{
    		flex: 2;
    		margin-top: 0px;
    	}
    	.teste{
    		color: #fffff;
    	}
    	.teste_busca{
    		padding: 0px;
		    margin: 0px;
		    margin-top: 155px;    		
    	}
    	.navbar-form{
    		margin-right: 0px;
    	}
    	.containerint{
    		width: 100%;
    		max-width: 1098px;
    		margin: auto;
    		/* display: flex;  
    			flex-direction: column;  	 */	
    		/* background: #dcdcdc; */
    		/* max-width: 1140px;   */  		
    	}
    	.slideshow{
    		width: 100%;    		    					
    	}

    	.slideshowint{
    		width: 100%;
    		max-width: 1098px;
    		background: #999;    		
    		min-height: 428px;
    	}
    	#meio{
    		background: #ffffff;
    		width: 100%;  
    		max-width: 1098px;
    		margin: auto;
    		padding: 5px;    		
    	}    	
    	.menu{
    		margin-bottom: 5px;

    	}
    	.menuint{
    	  		height: 45px;    		
    	  		background: #e8d100;    		 
    	  	}  	

    	/* @media only screen and (max-width: 1218px){
    		#topoheader, .container{
    			max-width: 890px;
    		}    		
    	} */

    </style>
  </head>
  <body>  	 	
		<div id="topoheader" class="row">  			
			<div class="logo">
				<a><img src="assets/imgs/logo_jovem.jpg" class="img-responsive"></a>
			</div>
			<div id="busca">
				<form class="navbar-form pull-right teste_busca" action="https://www.democraciacristajovem.org.br/" role="search" id="search">
	            <div class="input-group">
	                <input type="text" class="form-control" alue="" name="s" id="srch-term">
	                <div class="input-group-btn">
	                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
	                </div>
	            </div>
	        </form>  				
			</div>  			
		</div>  		
		<div class="container">
			<div class="containerint">
				<div id="meio" class="row">
					<div class="menu">
						<div class="menuint">
							MENU
						</div>
					</div>
					<div class="slideshow">
						<div class="slideshowint">
						
						</div>
					</div>					
				</div>
			</div>			  		
		</div>   

    <!-- jQuery (obrigatório para plugins JavaScript do Bootstrap) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Inclui todos os plugins compilados (abaixo), ou inclua arquivos separadados se necessário -->
    <script src="assets/js/bootstrap.min.js"></script>
  </body>
</html>