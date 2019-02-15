<?php
class contato {
	
	private $pdo;

	public function __construct(){
		$this->pdo = new PDO("mysql:dbname=crudoo;host=localhost", "root", "");
	}
}