<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../classes/Database.php';

// Verificar autenticação
if (!Auth::isLoggedIn()) {
    http_response_code(401);
    echo json_encode(['erro' => 'Não autorizado']);
    exit;
}

$db = new Database();
header('Content-Type: application/json');

// Parâmetros obrigatórios
$metrica = $_GET['metrica'] ?? '';
$tipo_ativo = $_GET['tipo_ativo'] ?? '';
$inicio = $_GET['inicio'] ?? '';
$fim = $_GET['fim'] ?? '';
$equipamento_id = $_GET['equipamento_id'] ?? '';

$validas_metricas = ['taxa_falhas', 'custo', 'mttr', 'mtbf'];
$validos_tipos = ['embarcacao', 'implemento', 'tanque', 'veiculo'];

if (!in_array($metrica, $validas_metricas) || !in_array($tipo_ativo, $validos_tipos)) {
    http_response_code(400);
    echo json_encode(['erro' => 'Parâmetros inválidos']);
    exit;
}

// Para métricas que precisam de período (custo e taxa_falhas)
if (in_array($metrica, ['custo', 'taxa_falhas']) && (!$inicio || !$fim)) {
    http_response_code(400);
    echo json_encode(['erro' => 'Período obrigatório para esta métrica']);
    exit;
}

// Gera os meses entre inicio e fim
function gerarMeses($inicio, $fim) {
    $meses = [];
    $data = DateTime::createFromFormat('Y-m', $inicio);
    $dataFim = DateTime::createFromFormat('Y-m', $fim);
    while ($data <= $dataFim) {
        $meses[] = $data->format('Y-m');
        $data->modify('+1 month');
    }
    return $meses;
}

switch ($metrica) {
    case 'taxa_falhas':
        // Taxa de falhas: contagem de OS corretivas por mês
        $labels = gerarMeses($inicio, $fim);
        $valores = [];
        foreach ($labels as $mes) {
            $sql = "SELECT COUNT(*) as falhas
                    FROM ordens_servico os
                    WHERE os.tipo_equipamento = :tipo
                      AND os.tipo_manutencao = 'corretiva'
                      AND DATE_FORMAT(os.data_abertura, '%Y-%m') = :mes";
            $params = [':tipo' => $tipo_ativo, ':mes' => $mes];
            
            if ($equipamento_id) {
                $sql .= " AND os.equipamento_id = :equipamento_id";
                $params[':equipamento_id'] = $equipamento_id;
            }
            
            $res = $db->query($sql, $params);
            $valores[] = isset($res[0]['falhas']) ? (int)$res[0]['falhas'] : 0;
        }
        break;
    case 'custo':
        // Custo: soma dos custos dos itens das OS concluídas do tipo naquele mês
        $labels = gerarMeses($inicio, $fim);
        $valores = [];
        foreach ($labels as $mes) {
            $sql = "SELECT SUM(ii.quantidade * ii.valor_unitario) as custo
                    FROM ordens_servico os
                    JOIN itens_ordem_servico ii ON ii.ordem_servico_id = os.id
                    WHERE os.tipo_equipamento = :tipo
                      AND os.status = 'concluida'
                      AND DATE_FORMAT(os.data_conclusao, '%Y-%m') = :mes";
            $params = [':tipo' => $tipo_ativo, ':mes' => $mes];
            
            if ($equipamento_id) {
                $sql .= " AND os.equipamento_id = :equipamento_id";
                $params[':equipamento_id'] = $equipamento_id;
            }
            
            $res = $db->query($sql, $params);
            $valores[] = isset($res[0]['custo']) && $res[0]['custo'] !== null ? round($res[0]['custo'], 2) : 0;
        }
        break;
    case 'mttr':
        // MTTR: buscar dados da tabela específica do tipo de ativo
        $tabela_mttr = "mttr_{$tipo_ativo}";
        
        if ($equipamento_id) {
            // Para equipamento específico
            $sql = "SELECT mttr, num_os, data_registro 
                    FROM {$tabela_mttr} 
                    WHERE id_ativo = :equipamento_id 
                    ORDER BY data_registro DESC 
                    LIMIT 1";
            $params = [':equipamento_id' => $equipamento_id];
        } else {
            // Para todos os equipamentos - média ponderada
            $sql = "SELECT AVG(mttr) as mttr, SUM(num_os) as total_os, MAX(data_registro) as data_registro
                    FROM {$tabela_mttr}";
            $params = [];
        }
        
        $res = $db->query($sql, $params);
        $mttr_atual = isset($res[0]['mttr']) && $res[0]['mttr'] !== null ? round($res[0]['mttr'], 2) : 0;
        $total_os = isset($res[0]['total_os']) ? (int)$res[0]['total_os'] : 0;
        
        // Calcular MTTR do período anterior para comparação
        if ($equipamento_id) {
            $sql_anterior = "SELECT mttr 
                            FROM {$tabela_mttr} 
                            WHERE id_ativo = :equipamento_id 
                              AND data_registro < DATE_SUB(NOW(), INTERVAL 3 MONTH)
                            ORDER BY data_registro DESC 
                            LIMIT 1";
            $params_anterior = [':equipamento_id' => $equipamento_id];
        } else {
            $sql_anterior = "SELECT AVG(mttr) as mttr 
                            FROM {$tabela_mttr} 
                            WHERE data_registro < DATE_SUB(NOW(), INTERVAL 3 MONTH)";
            $params_anterior = [];
        }
        
        $res_anterior = $db->query($sql_anterior, $params_anterior);
        $mttr_anterior = isset($res_anterior[0]['mttr']) && $res_anterior[0]['mttr'] !== null ? round($res_anterior[0]['mttr'], 2) : 0;
        
        // Determinar tendência
        $tendencia = 'estavel';
        if ($mttr_anterior > 0) {
            $diferenca = (($mttr_atual - $mttr_anterior) / $mttr_anterior) * 100;
            if ($diferenca > 10) $tendencia = 'piorando';
            elseif ($diferenca < -10) $tendencia = 'melhorando';
        }
        
        echo json_encode([
            'valor_atual' => $mttr_atual,
            'valor_anterior' => $mttr_anterior,
            'total_os' => $total_os,
            'tendencia' => $tendencia,
            'unidade' => 'horas'
        ]);
        exit;
        break;
    case 'mtbf':
        // MTBF: buscar dados da tabela específica do tipo de ativo
        $tabela_mtbf = "mtbf_{$tipo_ativo}";
        
        if ($equipamento_id) {
            // Para equipamento específico
            $sql = "SELECT mtbf, num_os, data_registro 
                    FROM {$tabela_mtbf} 
                    WHERE id_ativo = :equipamento_id 
                    ORDER BY data_registro DESC 
                    LIMIT 1";
            $params = [':equipamento_id' => $equipamento_id];
        } else {
            // Para todos os equipamentos - média ponderada
            $sql = "SELECT AVG(mtbf) as mtbf, SUM(num_os) as total_os, MAX(data_registro) as data_registro
                    FROM {$tabela_mtbf}";
            $params = [];
        }
        
        $res = $db->query($sql, $params);
        $mtbf_atual = isset($res[0]['mtbf']) && $res[0]['mtbf'] !== null ? round($res[0]['mtbf'], 2) : 0;
        $total_os = isset($res[0]['total_os']) ? (int)$res[0]['total_os'] : 0;
        
        // Calcular MTBF do período anterior para comparação
        if ($equipamento_id) {
            $sql_anterior = "SELECT mtbf 
                            FROM {$tabela_mtbf} 
                            WHERE id_ativo = :equipamento_id 
                              AND data_registro < DATE_SUB(NOW(), INTERVAL 3 MONTH)
                            ORDER BY data_registro DESC 
                            LIMIT 1";
            $params_anterior = [':equipamento_id' => $equipamento_id];
        } else {
            $sql_anterior = "SELECT AVG(mtbf) as mtbf 
                            FROM {$tabela_mtbf} 
                            WHERE data_registro < DATE_SUB(NOW(), INTERVAL 3 MONTH)";
            $params_anterior = [];
        }
        
        $res_anterior = $db->query($sql_anterior, $params_anterior);
        $mtbf_anterior = isset($res_anterior[0]['mtbf']) && $res_anterior[0]['mtbf'] !== null ? round($res_anterior[0]['mtbf'], 2) : 0;
        
        // Determinar tendência
        $tendencia = 'estavel';
        if ($mtbf_anterior > 0) {
            $diferenca = (($mtbf_atual - $mtbf_anterior) / $mtbf_anterior) * 100;
            if ($diferenca > 10) $tendencia = 'melhorando'; // MTBF maior = melhor
            elseif ($diferenca < -10) $tendencia = 'piorando'; // MTBF menor = pior
        }
        
        echo json_encode([
            'valor_atual' => $mtbf_atual,
            'valor_anterior' => $mtbf_anterior,
            'total_intervalos' => $total_os,
            'tendencia' => $tendencia,
            'unidade' => 'horas'
        ]);
        exit;
        break;
}

// Formatar labels para m/Y
$labels_fmt = array_map(function($m) {
    $dt = DateTime::createFromFormat('Y-m', $m);
    return $dt ? $dt->format('m/Y') : $m;
}, $labels);

echo json_encode([
    'labels' => $labels_fmt,
    'valores' => $valores
]); 