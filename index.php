<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");
require_once "controllers/AlunoController.php";
$controller = new AlunoController();
$acao = $_GET["acao"] ?? "";
$dados = json_decode(file_get_contents("php://input"), true);
if ($acao == "listar") {
 $controller->listar();
} else if ($acao == "cadastrar") {
 $controller->cadastrar($dados);
} else if ($acao == "editar") {
 $controller->editar($dados);
} else if ($acao == "excluir") {
 $controller->excluir($dados);
} else {
 echo json_encode(["erro" => "Ação inválida"]);
}
?>