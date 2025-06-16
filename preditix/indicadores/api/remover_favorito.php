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
$id = $input['id'] ?? 0;

if (!$id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID não fornecido']);
    exit;
}

try {
    $usuario_id = $_SESSION['usuario_id'];
    $biblioteca = new BibliotecaGraficos();
    
    // Buscar o gráfico para obter o grafico_id
    $favoritos = $biblioteca->listarFavoritos($usuario_id);
    $grafico_id = null;
    
    foreach ($favoritos as $favorito) {
        if ($favorito['id'] == $id) {
            $grafico_id = $favorito['grafico_id'];
            break;
        }
    }
    
    if (!$grafico_id) {
        throw new Exception('Gráfico não encontrado');
    }
    
    $resultado = $biblioteca->removerFavorito($usuario_id, $grafico_id);
    
    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Gráfico removido com sucesso']);
    } else {
        throw new Exception('Erro ao remover gráfico');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 