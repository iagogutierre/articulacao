<?php
#ini_set('display_errors', 'On');
#error_reporting(E_ALL | E_STRICT);
include_once("evento.php");
include_once("usuario.php");
include_once("local.php");

$usuario = new Usuario();
$evento = new Evento();
$local = new Local();

$usuario->setNome("iago");
$usuario->setEmail("email@teste.com");
$usuario->setTelefone("00008888");
$usuario->setSenha("12345");

if($usuario->cadastrarUsuario()){
	echo "usuario criado com sucesso <br/>";
}else{
	echo "não criou o usuario";
}

#$usuario->carregarDados();
$nome = $usuario->getNome();
$id = $usuario->getId();
echo("Nome do usuario: $nome <br> identificador: $id<br/>");

$usuario->atualizarDados("Iago Gutierre", "9997878", "", "", "");
$nome = $usuario->getNome();
$telefone = $usuario->getTelefone();
$id = $usuario->getId();
echo("Novo nome: $nome <br/> Telefone atualizdo: $telefone");

$local->setNome("Parcao");
$local->setEndereco("Parque manoel de barro solto lima ti melo rego");
$local->setDescricao("Um lugar muito agradavel prazerouzo pra queima um no fim de tarde coisa e tal tal e coisa");
$local->setTipo("Skate");
if ($local->cadastrarLocal($id)) {
	# code...
	echo "local foi adicionado com sucesso <br/>";
}else
	echo "falha ao adicionar local";

$local->atualizarDados("Parque ademar farias", "um lugar do caralho", "", "","");
$nome_local = $local->getNome();
echo("Novo nome: $nome_local<br/>");

$evento->setNome("evento de teste");
$evento->setFkIdUsuario($id);
$evento->setFkIdLocal(21);



if($evento->criarEvento()){
	$nome_evento= $evento->getNome();
	echo "evento $nome_evento criado com sucesso<br/>";
}else
	echo "falha na criação";
$evento->atualizarDados("Furakao 2000");
$nome_evento= $evento->getNome();
echo "evento $nome_evento atualizado</br>";

echo "deletando usuario $nome</br>";
$usuario->excluirUsuario();
echo "deletado com sucesso";

echo "deletando evento $nome_evento <br/>";
$evento->excluirEvento();
echo "evento exluido com sucesso<br/>";
echo "deletando lugar $nome_local <br/>";
$local->excluirLocal();

?>