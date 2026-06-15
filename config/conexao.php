<?php
class Conexao {
 public static function conectar() {
 $host = "localhost";
 $banco = "escola";
 $usuario = "root";
 $senha = "";
 try {
 $pdo = new PDO("mysql:host=$host;dbname=$banco;charset=utf8", $usuario, $senha);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 return $pdo;
 } catch(PDOException $e) {
 echo json_encode(["erro" => "Erro na conexão: " . $e->getMessage()]);
 exit;
 }
 }
}
?>