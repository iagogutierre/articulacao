<?php
session_start();
include_once('conexao.php');
include_once('evento.php');
include_once('local.php');

class Usuario{
	private $id;
	private $nome;
	private $email;
	private $telefone;
	private $senha;
	private $foto;
	private $conn;

	public function __construct(){
		$this->conn = new Conexao("mysql:host=localhost;dbname=ARTICULACAO", "root", "12345");
	}	

	public function cadastrarUsuario(){
		$this->conn->getInstance();
		$sql = $this->conn->prepare("INSERT INTO USUARIO (NOME, EMAIL, TELEFONE, SENHA) VALUES (:nome , :email, :telefone, :senha)");
		
		$sql->bindValue(':nome', $this->nome, PDO::PARAM_STR);
		$sql->bindValue(':email', $this->email, PDO::PARAM_STR);
		$sql->bindValue(':telefone', $this->telefone, PDO::PARAM_STR);
		$sql->bindValue(':senha', $this->senha, PDO::PARAM_STR);
		$sql->execute();

		$sql = $this->conn->prepare("SELECT ID FROM USUARIO WHERE NOME= :nome AND EMAIL = :email");
		$sql->bindValue(':nome', $this->nome, PDO::PARAM_STR);
		$sql->bindValue(':email', $this->email, PDO::PARAM_STR);
		$sql->execute();

		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
		if ($rows > 0) {
			$this->id = $rows[0]['ID'];
			return true; 
		}else{
			return false;
		}
		
	}
	public function atualizarDados($nome, $telefone, $email, $senha){
		$this->conn->getInstance();
		$sql = $this->conn->prepare("UPDATE USUARIO SET NOME=':nome', TELEFONE=':telefone', EMAIL=':email', SENHA=':senha' WHERE ID=:id");
		#carregar e atualizar todos os dados, mudando os valores quando forem informados
		$this::carregarDados();
		if (!empty($nome)) {
			$this->nome= $nome;
		}
		if (!empty($telefone)) {
			$this->telefone = $telefone;
		}
		if(!empty($email)){
			$this->email = $email;
		}
		if (!empty($senha)) {
			$this->senha = $senha;
		}

		$sql->bindValue(':nome', $this->nome, PDO::PARAM_STR);
		$sql->bindValue(':telefone', $this->telefone, PDO::PARAM_STR);
		$sql->bindValue(':email', $this->email, PDO::PARAM_STR);
		$sql->bindValue(':senha', $this->senha, PDO::PARAM_STR);
		$sql->bindValue(':id', $this->id, PDO::PARAM_INT);

		$sql->execute();

	}

	public function login(){
		$this->conn->getInstance();
		$stmt = $this->conn->prepare("SELECT * FROM USUARIO WHERE EMAIL =  :email AND senha = :senha LIMIT 1");

		$stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
		$stmt->bindValue(':senha', $this->senha, PDO::PARAM_STR);
		$stmt->execute();

		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if ($rows) {

			$_SESSION['id'] = $rows[0]['id'];

			$this::setId($rows[0]['id']);//encontrou o id do usuario
			$this::setNome($rows[0]['nome']); 
			$this::setEmail($rows[0]['email']);
			$this::setSenha($rows[0]['senha']);
			$this::setId($rows[0]['id']);//salva o id e retorna true
			
			return true;
		}else
			return false;
	}

	public function carregarDados(){
		$stmt = $this->conn->prepare("SELECT * FROM USUARIO WHERE ID = :id LIMIT 1");
		$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
		$stmt->execute();

		$results  = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		if($results[0]["ID"]){
			$this->nome = $results[0]["NOME"];
			$this->telefone = $results[0]["TELEFONE"];
			$this->email = $results[0]["EMAIL"];
			$this->senha = $results[0]["SENHA"];
			
		}      
	}
	public function excluirUsuario(){
		$this->conn->getInstance();
		
		$sql = $this->conn->prepare("DELETE FROM EVENTO WHERE FK_ID_USUARIO =:id");
		$sql->bindValue(":id", $this->id, PDO::PARAM_INT);
		$sql->execute();

		$sql = $this->conn->prepare("DELETE FROM LOCAL WHERE FK_ID_USUARIO =:id");
		$sql->bindValue(":id", $this->id, PDO::PARAM_INT);
		$sql->execute();

		$sql = $this->conn->prepare("DELETE FROM USUARIO WHERE ID = :id");

		$sql->bindValue(":id", $this->id, PDO::PARAM_INT);
		$sql->execute();
	}
	

	
	public function setId($val){
		$this->id = $val;
	}
	public function getId(){
		return $this->id;
	}

	public function setNome($val){
		$this->nome = $val;
	}
	public function getNome(){
		return $this->nome;
	}
	public function setEmail($val){
		$this->email = $val;
	}
	public function getEmail(){
		return $this->email;
	}
	public function setTelefone($telefone){
		$this->telefone = $telefone;
	}
	public function getTelefone(){
		return $this->telefone;
	}
	public function setSenha($val){
		$this->senha = $val;
	}
	public function getSenha(){
		return $this->senha;
	}
	public function setFoto($val){
		$this->foto = $val;
	}
	public function getFoto(){
		return $this->foto;
	}
}


?>
