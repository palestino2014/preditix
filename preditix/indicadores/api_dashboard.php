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

if (!in_array($metrica, $validas_metricas) || !in_array($tipo_ativo, $validos_tipos) || !$inicio || !$fim) {
    http_response_code(400);
    echo json_encode(['erro' => 'Parâmetros inválidos']);
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

$labels = gerarMeses($inicio, $fim);
$valores = [];

switch ($metrica) {
    case 'taxa_falhas':
        // Taxa de falhas: contagem de OS corretivas por mês
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
        // MTTR: média de dias entre data_abertura e data_conclusao das OS concluídas do tipo naquele mês
        foreach ($labels as $mes) {
            $sql = "SELECT AVG(DATEDIFF(os.data_conclusao, os.data_abertura)) as mttr
                    FROM ordens_servico os
                    WHERE os.tipo_equipamento = :tipo
                      AND os.status = 'concluida'
                      AND DATE_FORMAT(os.data_conclusao, '%Y-%m') = :mes";
            $params = [':tipo' => $tipo_ativo, ':mes' => $mes];
            
            if ($equipamento_id) {
                $sql .= " AND os.equipamento_id = :equipamento_id";
                $params[':equipamento_id'] = $equipamento_id;
            }
            
            $res = $db->query($sql, $params);
            $valores[] = isset($res[0]['mttr']) && $res[0]['mttr'] !== null ? round($res[0]['mttr'], 2) : 0;
        }
        break;
    case 'mtbf':
        // MTBF: média de dias entre aberturas de OS do tipo naquele mês (por equipamento)
        foreach ($labels as $mes) {
            $sql = "SELECT equipamento_id, MIN(os.data_abertura) as primeira, MAX(os.data_abertura) as ultima, COUNT(*) as total
                    FROM ordens_servico os
                    WHERE os.tipo_equipamento = :tipo
                      AND DATE_FORMAT(os.data_abertura, '%Y-%m') = :mes";
            $params = [':tipo' => $tipo_ativo, ':mes' => $mes];
            
            if ($equipamento_id) {
                $sql .= " AND os.equipamento_id = :equipamento_id";
                $params[':equipamento_id'] = $equipamento_id;
            }
            
            $sql .= " GROUP BY equipamento_id";
            $res = $db->query($sql, $params);
            $mtbf_mes = 0;
            $equip_count = 0;
            foreach ($res as $row) {
                if ($row['total'] > 1) {
                    $dias = (strtotime($row['ultima']) - strtotime($row['primeira'])) / 86400;
                    $intervalos = $row['total'] - 1;
                    $mtbf = $intervalos > 0 ? $dias / $intervalos : 0;
                    $mtbf_mes += $mtbf;
                    $equip_count++;
                }
            }
            $valores[] = $equip_count > 0 ? round($mtbf_mes / $equip_count, 2) : 0;
        }
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