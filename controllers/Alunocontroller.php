<?php
require_once "models/Aluno.php";
class AlunoController {
 private $aluno;
 public function __construct() {
 $this->aluno = new Aluno();
 }
 public function listar() {
 $dados = $this->aluno->listar();
 echo json_encode($dados);
 }
 public function cadastrar($dados) {
 $nome = $dados["nome"] ?? "";
 $email = $dados["email"] ?? "";
 if ($nome == "" || $email == "") {
 echo json_encode(["erro" => "Nome e email são obrigatórios"]);
 return;
 }
 $this->aluno->cadastrar($nome, $email);
 echo json_encode(["mensagem" => "Aluno cadastrado com sucesso!"]);
 }
 public function editar($dados) {
 $id = $dados["id"] ?? "";
 $nome = $dados["nome"] ?? "";
 $email = $dados["email"] ?? "";
 if ($id == "" || $nome == "" || $email == "") {
 echo json_encode(["erro" => "ID, nome e email são obrigatórios"]);
 return;
 }
 $this->aluno->editar($id, $nome, $email);
 echo json_encode(["mensagem" => "Aluno atualizado com sucesso!"]);
 }
 public function excluir($dados) {
 $id = $dados["id"] ?? "";
 if ($id == "") {
 echo json_encode(["erro" => "ID é obrigatório"]);
 return;
 }
 $this->aluno->excluir($id);
 echo json_encode(["mensagem" => "Aluno excluído com sucesso!"]);
 }
}
?>