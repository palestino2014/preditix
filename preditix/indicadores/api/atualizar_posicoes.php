<?php
require_once '../../includes/auth.php';
require_once '../classes/BibliotecaGraficos.php';

Auth::checkAuth();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$graficos = $input['graficos'] ?? [];

if (empty($graficos)) {
    http_response_code(400);
    echo json_encode(['error' => 'Dados dos gráficos não fornecidos']);
    exit;
}

try {
    $usuario_id = $_SESSION['usuario_id'];
    $biblioteca = new BibliotecaGraficos();
    
    $resultado = $biblioteca->atualizarPosicoes($usuario_id, $graficos);
    
    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Posições atualizadas com sucesso']);
    } else {
        throw new Exception('Erro ao atualizar posições');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 