<?php
require_once "config/conexao.php";
class Aluno {
 private $pdo;
 public function __construct() {
 $this->pdo = Conexao::conectar();
 }
 public function listar() {
 $sql = "SELECT * FROM alunos ORDER BY id DESC";
 $stmt = $this->pdo->query($sql);
 return $stmt->fetchAll(PDO::FETCH_ASSOC);
 }
 public function cadastrar($nome, $email) {
 $sql = "INSERT INTO alunos (nome, email) VALUES (:nome, :email)";
 $stmt = $this->pdo->prepare($sql);
 $stmt->bindValue(":nome", $nome);
 $stmt->bindValue(":email", $email);
 return $stmt->execute();
 }
 public function editar($id, $nome, $email) {
 $sql = "UPDATE alunos SET nome = :nome, email = :email WHERE id = :id";
 $stmt = $this->pdo->prepare($sql);
 $stmt->bindValue(":id", $id);
 $stmt->bindValue(":nome", $nome);
 $stmt->bindValue(":email", $email);
 return $stmt->execute();
 }
 public function excluir($id) {
 $sql = "DELETE FROM alunos WHERE id = :id";
 $stmt = $this->pdo->prepare($sql);
 $stmt->bindValue(":id", $id);
 return $stmt->execute();
 }
}
?>