<?php
class Usuarios {

	private $db;

	public function __construct(){
		
		try{			
			$this->db = new PDO("mysql:dbname=blog; host=localhost", "wvtodoz", "senha");
		} catch(PDOException $e){
			echo "Falha: ".$e->getMessage();
		}
		
	}

	public function selecionar($id){

		$sql = $this->db->prepare("SELECT * FROM usuarios WHERE id = :id");  // id nome do campo = :id<- esse é o apelido
		$sql->bindValue(":id", $id); //dois parâmetros obrigatoria primeiro apelido, segundo valor oficial
		$sql->execute();

		$array = array();
		if($sql->rowCount() > 0){
			$array = $sql->fetch();
		}

		return $array;
	}
}