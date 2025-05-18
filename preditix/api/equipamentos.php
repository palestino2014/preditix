<?php
require_once '../includes/auth.php';
require_once '../classes/Embarcacao.php';
require_once '../classes/Implemento.php';
require_once '../classes/Tanque.php';
require_once '../classes/Veiculo.php';

Auth::checkAuth();

header('Content-Type: application/json');

$tipo = $_GET['tipo'] ?? '';

try {
    switch ($tipo) {
        case 'embarcacao':
            $equipamento = new Embarcacao();
            break;
        case 'implemento':
            $equipamento = new Implemento();
            break;
        case 'tanque':
            $equipamento = new Tanque();
            break;
        case 'veiculo':
            $equipamento = new Veiculo();
            break;
        default:
            error_log("Tipo de equipamento inválido: " . $tipo);
            http_response_code(400);
            echo json_encode(['error' => 'Tipo de equipamento inválido']);
            exit;
    }

    $dados = $equipamento->listar();
    
    if (empty($dados)) {
        error_log("Nenhum equipamento encontrado para o tipo: " . $tipo);
    }
    
    echo json_encode($dados);
} catch (Exception $e) {
    error_log("Erro ao buscar equipamentos do tipo {$tipo}: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erro ao buscar equipamentos']);
} 