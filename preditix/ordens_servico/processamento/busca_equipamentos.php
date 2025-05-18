<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../classes/Database.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Não autorizado']);
    exit;
}

// Verifica se o tipo de equipamento foi fornecido
if (!isset($_GET['tipo'])) {
    http_response_code(400);
    echo json_encode(['erro' => 'Tipo de equipamento não fornecido']);
    exit;
}

$tipo = $_GET['tipo'];
$db = new Database();

try {
    switch ($tipo) {
        case 'embarcacao':
            $sql = "SELECT id, nome FROM embarcacoes WHERE status = 'ativo' ORDER BY nome";
            $result = $db->query($sql);
            $equipamentos = array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'nome' => $item['nome']
                ];
            }, $result);
            break;

        case 'veiculo':
            $sql = "SELECT id, placa FROM veiculos WHERE status = 'ativo' ORDER BY placa";
            $result = $db->query($sql);
            $equipamentos = array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'placa' => $item['placa']
                ];
            }, $result);
            break;

        case 'implemento':
            $sql = "SELECT id, placa FROM implementos WHERE status = 'ativo' ORDER BY placa";
            $result = $db->query($sql);
            $equipamentos = array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'placa' => $item['placa']
                ];
            }, $result);
            break;

        case 'tanque':
            $sql = "SELECT id, tag FROM tanques WHERE status = 'ativo' ORDER BY tag";
            $result = $db->query($sql);
            $equipamentos = array_map(function($item) {
                return [
                    'id' => $item['id'],
                    'placa' => $item['tag']
                ];
            }, $result);
            break;

        default:
            http_response_code(400);
            echo json_encode(['erro' => 'Tipo de equipamento inválido']);
            exit;
    }

    header('Content-Type: application/json');
    echo json_encode($equipamentos);

} catch (Exception $e) {
    error_log("Erro ao buscar equipamentos: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao buscar equipamentos']);
} 