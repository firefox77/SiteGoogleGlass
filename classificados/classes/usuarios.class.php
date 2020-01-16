<?php //criando o objeto
class Usuarios{
	public function cadastrar($nome, $email, $senha, $telefone){
		global $pdo;
		$sql = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email "); //antes de adicionar um funcionario novo, precisa verificar se ele existe pelo email
		$sql->bindValue(":email", $email);
		$sql->execute();

		if($sql->rowCount() == 0){ //se rowCount for igual a zero então cadastrar o novo usuario
			$sql = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, email = :email, senha =  :senha, telefone = :telefone");
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":email", $email);
			$sql->bindValue(":senha", md5($senha));
			$sql->bindValue(":telefone", $telefone);
			$sql->execute();

			return true;			
		}else{// caso contrario
			return false;
		}
//feito isso ele vai procurar no banco de dados na tabela usuarios, o usuario que tenha o email especifico

	}
	public function login($email, $senha){
		global $pdo;		
		$sql = $pdo->prepare("SELECT id, nome FROM usuarios WHERE email = :email AND senha = :senha");
		$sql->bindValue(":email", $email);
		$sql->bindValue(":senha", md5($senha));
		$sql->execute();
		//verificação de login
		if($sql->rowCount() > 0){
			$dado = $sql->fetch();
			$_SESSION['cLogin']['id'] = $dado['id'];
			$_SESSION['cLogin']['nome'] = $dado['nome'];
			return true;
		} else {
			return false;
		}
	}
	
}
?>