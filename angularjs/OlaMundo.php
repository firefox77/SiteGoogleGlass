<!DOCTYPE html>
	<html ng-app="OlaMundo">
	<head>
		<title>Angular - JS</title>
		<meta charset="utf-8">
		<script src="angular/angular.js"></script>
		<script>
			angular.module("OlaMundo", []);
			angular.module("OlaMundo").controller("OlaMundoCtrl",
				function($scope){
					$scope.message = "Olá Mundo!";
				});
		</script>
	</head>
	<body>
		<div ng-controller="OlaMundoCtrl">
			{{message}}			
		</div>
	</body>
</html>