<?php
require_once '../../includes/auth.php';
require_once '../classes/BibliotecaGraficos.php';
require_once '../includes/debug.php';

Auth::checkAuth();

header('Content-Type: application/json');

if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID do gráfico não fornecido']);
    exit;
}

$id = (int)$_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

debug_log("API grafico_data.php - ID: $id, Usuario: $usuario_id");

try {
    $biblioteca = new BibliotecaGraficos();
    
    // Primeiro, buscar o gráfico favorito para obter o grafico_id
    $favoritos = $biblioteca->listarFavoritos($usuario_id);
    debug_log("Favoritos encontrados: " . count($favoritos));
    
    $grafico_id = null;
    
    foreach ($favoritos as $favorito) {
        debug_log("Verificando favorito ID: " . $favorito['id'] . " vs " . $id);
        if ($favorito['id'] == $id) {
            $grafico_id = $favorito['grafico_id'];
            debug_log("Grafico ID encontrado: $grafico_id");
            break;
        }
    }
    
    if (!$grafico_id) {
        debug_log("Grafico ID não encontrado para favorito ID: $id");
        http_response_code(404);
        echo json_encode(['error' => 'Gráfico favorito não encontrado']);
        exit;
    }
    
    // Agora gerar dados usando o grafico_id da biblioteca
    debug_log("Gerando dados para grafico_id: $grafico_id");
    $dados = $biblioteca->gerarDadosGrafico($grafico_id);
    
    if (!$dados) {
        debug_log("Dados não gerados para grafico_id: $grafico_id");
        http_response_code(404);
        echo json_encode(['error' => 'Gráfico não encontrado']);
        exit;
    }
    
    debug_log("Dados gerados com sucesso: " . json_encode($dados));
    echo json_encode($dados);
    
} catch (Exception $e) {
    debug_log("Erro na API grafico_data.php: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Erro interno: ' . $e->getMessage()]);
} 