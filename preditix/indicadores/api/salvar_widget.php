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

try {
    $usuario_id = $_SESSION['usuario_id'];
    $tipo_widget = $_POST['tipo_widget'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $largura = (int)($_POST['largura'] ?? 1);
    $altura = (int)($_POST['altura'] ?? 1);
    
    if (empty($tipo_widget) || empty($titulo)) {
        throw new Exception('Tipo e título são obrigatórios');
    }
    
    // Coletar configurações do formulário
    $configuracao = [];
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'config_') === 0) {
            $config_key = substr($key, 7); // Remove 'config_'
            $configuracao[$config_key] = $value;
        }
    }
    
    // Adicionar filtros padrão se não especificados
    if (!isset($configuracao['filtros'])) {
        $configuracao['filtros'] = [];
    }
    
    $dados_widget = [
        'usuario_id' => $usuario_id,
        'titulo' => $titulo,
        'tipo_widget' => $tipo_widget,
        'configuracao' => $configuracao,
        'posicao_x' => 0, // Será calculado automaticamente
        'posicao_y' => 0, // Será calculado automaticamente
        'largura' => $largura,
        'altura' => $altura,
        'ativo' => 1
    ];
    
    $widget = new Widget();
    $resultado = $widget->salvar($dados_widget);
    
    if ($resultado) {
        echo json_encode(['success' => true, 'message' => 'Widget salvo com sucesso']);
    } else {
        throw new Exception('Erro ao salvar widget');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} 