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
$grafico_id = $input['grafico_id'] ?? 0;

if (!$grafico_id) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do gráfico não fornecido']);
    exit;
}

try {
    $usuario_id = $_SESSION['usuario_id'];
    $biblioteca = new BibliotecaGraficos();
    
    // Calcular próxima posição disponível
    $favoritos = $biblioteca->listarFavoritos($usuario_id);
    $posicao_y = count($favoritos);
    
    $resultado = $biblioteca->adicionarFavorito($usuario_id, $grafico_id, 0, $posicao_y, 1, 1);
    
    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Gráfico adicionado com sucesso']);
    } else {
        throw new Exception('Erro ao adicionar gráfico');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 