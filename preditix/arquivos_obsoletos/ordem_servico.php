<?php
require_once '../includes/auth.php';
require_once '../classes/OrdemServico.php';

Auth::checkAuth();

header('Content-Type: application/json');

$ordemServico = new OrdemServico();
$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? '';

if ($id) {
    if ($action === 'itens') {
        echo json_encode($ordemServico->listarItens($id));
    } else {
        echo json_encode($ordemServico->buscarPorId($id));
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID não fornecido']);
} 