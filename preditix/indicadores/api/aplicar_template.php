<?php
require_once '../../includes/auth.php';
require_once '../classes/Widget.php';

Auth::checkAuth();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$categoria = $input['categoria'] ?? '';

if (empty($categoria)) {
    http_response_code(400);
    echo json_encode(['error' => 'Categoria não especificada']);
    exit;
}

try {
    $usuario_id = $_SESSION['usuario_id'];
    $widget = new Widget();
    
    // Buscar template da categoria
    $template = $widget->buscarTemplatePorCategoria($categoria);
    
    if (!$template) {
        throw new Exception('Template não encontrado');
    }
    
    // Remover widgets existentes do usuário
    $widgets_existentes = $widget->listarPorUsuario($usuario_id);
    foreach ($widgets_existentes as $widget_existente) {
        $widget->excluir($widget_existente['id'], $usuario_id);
    }
    
    // Aplicar widgets do template
    $widgets_template = json_decode($template['widgets'], true);
    $posicao_y = 0;
    
    foreach ($widgets_template as $widget_config) {
        $dados_widget = [
            'usuario_id' => $usuario_id,
            'titulo' => $widget_config['titulo'],
            'tipo_widget' => $widget_config['tipo'],
            'configuracao' => [
                'metrica' => $widget_config['metrica'] ?? '',
                'filtros' => []
            ],
            'posicao_x' => $widget_config['posicao_x'] ?? 0,
            'posicao_y' => $widget_config['posicao_y'] ?? $posicao_y,
            'largura' => $widget_config['largura'] ?? 1,
            'altura' => $widget_config['altura'] ?? 1,
            'ativo' => 1
        ];
        
        $widget->salvar($dados_widget);
        $posicao_y++;
    }
    
    echo json_encode(['success' => true, 'message' => 'Template aplicado com sucesso']);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 