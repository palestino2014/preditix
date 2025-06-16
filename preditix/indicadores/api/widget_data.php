<?php
require_once '../../includes/auth.php';
require_once '../classes/Indicadores.php';
require_once '../classes/Widget.php';

Auth::checkAuth();

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do widget não fornecido']);
    exit;
}

$widget_id = (int)$_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

try {
    $widget = new Widget();
    $widget_data = $widget->buscarPorId($widget_id, $usuario_id);
    
    if (!$widget_data) {
        http_response_code(404);
        echo json_encode(['error' => 'Widget não encontrado']);
        exit;
    }
    
    $configuracao = json_decode($widget_data['configuracao'], true);
    $dados = $widget->gerarDadosWidget($widget_data['tipo_widget'], $configuracao);
    
    // Adicionar informações do widget aos dados
    $dados['id'] = $widget_id;
    $dados['tipo'] = $widget_data['tipo_widget'];
    $dados['titulo'] = $widget_data['titulo'];
    
    echo json_encode($dados);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erro interno: ' . $e->getMessage()]);
} 