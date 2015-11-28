<?php
require_once("conexao.php");

class Evento{
	private $id;
	private $nome; 
	private $fk_id_local;
	private $fk_id_usuario;
	private $conn;

	public function __construct(){
		$this->conn = new Conexao("mysql:host=localhost;dbname=ARTICULACAO", "root", "12345");
	}
	public function criarEvento(){
		$this->conn->getInstance();
		$sql = $this->conn->prepare("INSERT INTO EVENTO (NOME, FK_ID_LOCAL, FK_ID_USUARIO) VALUES (:nome, :fk_id_local, :fk_id_usuario)");
		
		$sql->bindValue(':nome', $this->nome, PDO::PARAM_STR);
		$sql->bindValue(':fk_id_local', $this->fk_id_local, PDO::PARAM_INT);
		$sql->bindValue(':fk_id_usuario', $this->fk_id_usuario, PDO::PARAM_INT);
		
		$sql->execute();

		
		$rows= $sql->rowCount();
		
		if($rows > 0){
			return true;
		}else
			return false;
	}

	public function carregarDados(){
		$this->conn->getInstance();
		$sql = $this->conn->prepare("SELECT * FROM EVENTO WHERE ID = :id LIMIT 1");

		$sql->bindValue(":id", $this->id, PDO::PARAM_STR);
		$sql->execute();

		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
		if($rows){
			$this->nome = $rows[0]['nome'];

			return true;
		}else
			return false;

	}
	public function atualizarDados($nome){
		$this->conn->getInstance();
		$sql = $this->conn->prepare("UPDATE EVENTO SET NOME=':nome' WHERE ID=:id");
		#carregar e atualizar todos os dados, mudando os valores quando forem informados
		$this::carregarDados();
		if (!empty($nome)) {
			$this->nome= $nome;
		}
		
		$sql->bindValue(':nome', $this->nome, PDO::PARAM_STR);
		$sql->bindValue(':id', $this->id, PDO::PARAM_INT);

		$sql->execute();

	}
	public function excluirEvento(){
		$this->conn->getInstance();
		$sql = $this->conn->prepare("DELETE FROM EVENTO WHERE FK_ID_USUARIO= :id");

		$sql->bindValue(":id", $this->id, PDO::PARAM_INT);
		$sql->execute();

	}
	
	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}
	public function setFkIdUsuario($id){
		$this->fk_id_usuario = $id;
	}
	public function getFkIdUsuario(){
		return $this->fk_id_usuario;
	}
	public function setFkIdLocal($id){
		$this->fk_id_local = $id;
	}
	public function getFkIdLocal(){
		return $this->fk_id_local;
	}
	public function setNome($nome){
		$this->nome = $nome;
	}
	public function getNome(){
		return $this->nome;
	}
}
?>