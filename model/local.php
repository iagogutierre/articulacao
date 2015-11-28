<?php
session_start();
include_once('conexao.php');

class Local{
	private $id;
	private $nome;
	private $descricao;
	private $tipo;
	private $endereco;
	private $conn;

	public function __construct(){
		$this->conn = new Conexao("mysql:host=localhost;dbname=ARTICULACAO", "root", "12345");

	}

	public function cadastrarLocal($id_usuario){
		$this->conn->getInstance();
		$sql = $this->conn->prepare("INSERT INTO LOCAL (NOME, DESCRICAO, TIPO, ENDERECO, FK_ID_USUARIO) VALUES (:nome, :descricao, :tipo, :endereco, :id_usuario)");
		
		$sql->bindValue(':nome', $this->nome, PDO::PARAM_STR);
		$sql->bindValue(':descricao', $this->descricao, PDO::PARAM_STR);
		$sql->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
		$sql->bindValue(':endereco', $this->endereco, PDO::PARAM_STR);
		$sql->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
		$sql->execute();

		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
		return true;
		#var_dump($sql);die();
		// if ($rows > 0) {
		// 	# code...
		// 	return true;
		// }else
		// 	return false;

	}
	public function carregarDados(){
		$this->conn->getInstance();
		$sql = $this->conn->prepare("SELECT * FROM LOCAL WHERE ID = :id LIMIT 1");


		$sql->bindValue(":id", $this->id, PDO::PARAM_STR);
		$sql->execute();

		$rows = $sql->fetchAll(PDO::FETCH_ASSOC);
		if($rows){
			$this->nome = $rows[0]['nome'];
			$this->descricao = $rows[0]['descricao'];
			$this->tipo = $rows[0]['tipo'];
			$this->endereco = $rows[0]['endereco'];

			return true;
		}else
			return false;
	}
	public function atualizarDados($nome, $descricao, $tipo, $endereco){
		$this->conn->getInstance();
		$sql = $this->conn->prepare("UPDATE LOCAL SET NOME=':nome', DESCRICAO=':descricao', TIPO=':tipo', ENDERECO=':endereco' WHERE ID=:id");
		#carregar e atualizar todos os dados, mudando os valores quando forem informados
		$this::carregarDados();
		if (!empty($nome)) {
			$this->nome= $nome;
		}
		if (!empty($descricao)) {
			$this->descricao = $descricao;
		}
		if(!empty($tipo)){
			$this->tipo = $tipo;
		}
		if (!empty($endereco)) {
			$this->endereco = $endereco;
		}

		$sql->bindValue(':nome', $this->nome, PDO::PARAM_STR);
		$sql->bindValue(':descricao', $this->descricao, PDO::PARAM_STR);
		$sql->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
		$sql->bindValue(':endereco', $this->endereco, PDO::PARAM_STR);
		$sql->bindValue(':id', $this->id, PDO::PARAM_INT);

		$sql->execute();
	}
	public function excluirLocal(){
		$this->conn->getInstance();
		$sql = $this->conn->prepare("DELETE FROM LOCAL WHERE ID = :id");

		$sql->bindValue(":id", $this->id, PDO::PARAM_INT);
		$sql->execute();

	}
	public function setId($id){
		$this->id= $id;
	}
	public function getId(){
		return $this->id;
	}
	public function setNome($nome){
		$this->nome = $nome;
	}
	public function getNome(){
		return $this->nome;
	}
	public function setDescricao($descricao){
		$this->descricao = $descricao;
	}
	public function setTipo($tipo){
		$this->tipo = $tipo;
	}
	public function getTipo(){
		return $this->tipo;
	}
	public function setEndereco($endereco){
		$this->endereco = $endereco;
	}
	public function getEndereco(){
		return $this->endereco;
	}
}
?>