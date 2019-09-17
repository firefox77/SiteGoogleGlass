<!DOCTYPE html>
	<html ng-app="CadClientes">
	<head>
		<title>Cadastro de Clientes</title>
		<meta charset="utf-8">
		<script src="angular/angular.js"></script>
		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="style.css">
		<script>
			angular.module("CadClientes", []);
			angular.module("CadClientes").controller("CadClientesCtrl",
				function($scope){
					$scope.app = "Cadastro de Clientes";
				});
		</script>
	</head>
	<body ng-controller="CadClientesCtrl">
		<div class="jumbotron">
			<h4 ng-bind="app"></h4>
		</div>
	</body>
</html>