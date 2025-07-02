<?php
header('Content-Type: application/json');
require_once '../../includes/config.php';
require_once '../../classes/Database.php';

try {
    $db = new Database();
    $tipo = $_GET['tipo'] ?? '';
    
    if (!$tipo) {
        throw new Exception('Tipo de equipamento não fornecido');
    }
    
    // Busca equipamentos de um tipo específico
    switch ($tipo) {
        case 'embarcacao':
            $sql = "SELECT id, nome as identificacao FROM embarcacoes ORDER BY nome";
            break;
        case 'veiculo':
            $sql = "SELECT id, placa as identificacao FROM veiculos ORDER BY placa";
            break;
        case 'implemento':
            $sql = "SELECT id, placa as identificacao FROM implementos ORDER BY placa";
            break;
        case 'tanque':
            $sql = "SELECT id, tag as identificacao FROM tanques ORDER BY tag";
            break;
        default:
            throw new Exception('Tipo de equipamento inválido');
    }
    
    $equipamentos = $db->query($sql);
    
    echo json_encode([
        'success' => true,
        'equipamentos' => $equipamentos
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
?> 