<?php
$titulo = 'Ordens de Serviço';
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../classes/Database.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

// Inicializa a conexão com o banco de dados
$db = new Database();

// Obtém os filtros da URL
$filtros = [
    'tipo_equipamento' => $_GET['tipo'] ?? null,
    'ativo_id' => $_GET['ativo_id'] ?? null,
    'status' => $_GET['status'] ?? null,
    'prioridade' => $_GET['prioridade'] ?? null,
    'data_abertura' => $_GET['data_abertura'] ?? null
];

// Constrói a query base
$sql = "SELECT os.*, 
               u.nome as nome_usuario_abertura,
               c.nome as nome_cliente,
               CASE 
                   WHEN os.tipo_equipamento = 'embarcacao' THEN e.nome
                   WHEN os.tipo_equipamento = 'veiculo' THEN v.placa
                   WHEN os.tipo_equipamento = 'implemento' THEN i.placa
                   WHEN os.tipo_equipamento = 'tanque' THEN t.tag
               END as identificacao_equipamento
        FROM ordens_servico os
        LEFT JOIN usuarios u ON u.id = os.usuario_abertura_id
        LEFT JOIN clientes c ON c.id = os.cliente_id
        LEFT JOIN embarcacoes e ON e.id = os.equipamento_id AND os.tipo_equipamento = 'embarcacao'
        LEFT JOIN veiculos v ON v.id = os.equipamento_id AND os.tipo_equipamento = 'veiculo'
        LEFT JOIN implementos i ON i.id = os.equipamento_id AND os.tipo_equipamento = 'implemento'
        LEFT JOIN tanques t ON t.id = os.equipamento_id AND os.tipo_equipamento = 'tanque'
        WHERE 1=1";

$params = [];

// Aplica os filtros
if ($filtros['tipo_equipamento']) {
    $sql .= " AND os.tipo_equipamento = :tipo_equipamento";
    $params[':tipo_equipamento'] = $filtros['tipo_equipamento'];
}

if ($filtros['ativo_id']) {
    $sql .= " AND os.equipamento_id = :ativo_id";
    $params[':ativo_id'] = $filtros['ativo_id'];
}

if ($filtros['status']) {
    $sql .= " AND os.status = :status";
    $params[':status'] = $filtros['status'];
}

if ($filtros['prioridade']) {
    $sql .= " AND os.prioridade = :prioridade";
    $params[':prioridade'] = $filtros['prioridade'];
}

if ($filtros['data_abertura']) {
    $sql .= " AND DATE(os.data_abertura) = :data_abertura";
    $params[':data_abertura'] = $filtros['data_abertura'];
}

// Ordenação
$sql .= " ORDER BY os.data_abertura DESC, os.numero_os DESC";

// Busca as ordens de serviço
try {
    $ordens_servico = $db->query($sql, $params);
    
    // Busca estatísticas
    $sql_stats = "SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'aberta' THEN 1 ELSE 0 END) as abertas,
        SUM(CASE WHEN status = 'em_andamento' THEN 1 ELSE 0 END) as em_andamento,
        SUM(CASE WHEN status = 'concluida' THEN 1 ELSE 0 END) as concluidas,
        SUM(CASE WHEN status = 'cancelada' THEN 1 ELSE 0 END) as canceladas,
        SUM(CASE WHEN prioridade = 'alta' OR prioridade = 'urgente' THEN 1 ELSE 0 END) as prioridade_alta
        FROM ordens_servico";
    
    $stats = $db->query($sql_stats)[0];
} catch (Exception $e) {
    error_log("Erro ao buscar ordens de serviço: " . $e->getMessage());
    die("Erro ao buscar ordens de serviço. Por favor, tente novamente mais tarde.");
}

// Inclui o cabeçalho
require_once '../includes/header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ordens de Serviço</h1>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFiltros">
                <i class="bi bi-funnel"></i> Filtros
            </button>
        </div>
    </div>

    <!-- Cards de Estatísticas -->
    <div class="row g-3 mb-4">
        <div class="col">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <h6 class="card-title">Abertas</h6>
                    <p class="card-text display-6"><?php echo $stats['abertas']; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-info h-100">
                <div class="card-body">
                    <h6 class="card-title">Em Andamento</h6>
                    <p class="card-text display-6"><?php echo $stats['em_andamento']; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger h-100">
                <div class="card-body">
                    <h6 class="card-title">Prioridade Alta</h6>
                    <p class="card-text display-6"><?php echo $stats['prioridade_alta']; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h6 class="card-title">Concluídas</h6>
                    <p class="card-text display-6"><?php echo $stats['concluidas']; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-secondary h-100">
                <div class="card-body">
                    <h6 class="card-title">Canceladas</h6>
                    <p class="card-text display-6"><?php echo $stats['canceladas']; ?></p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h6 class="card-title">Total</h6>
                    <p class="card-text display-6"><?php echo $stats['total']; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de Ordens de Serviço -->
    <div class="card">
        <div class="card-body">
            <?php if (empty($ordens_servico)): ?>
                <div class="alert alert-info">
                    Nenhuma ordem de serviço encontrada com os filtros selecionados.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-ativos">
                        <thead>
                            <tr>
                                <th class="col-numero">Número OS</th>
                                <th class="col-tipo">Tipo</th>
                                <th class="col-equipamento">Equipamento</th>
                                <th class="col-data">Data Abertura</th>
                                <th class="col-data">Data Conclusão</th>
                                <th class="col-usuario">Cliente</th>
                                <th class="table-cell-status">Status</th>
                                <th class="table-cell-status">Prioridade</th>
                                <th class="col-usuario">Aberto por</th>
                                <th class="table-cell-actions">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ordens_servico as $os): ?>
                                <tr>
                                    <td class="table-cell-text" title="<?php echo htmlspecialchars($os['numero_os']); ?>"><?php echo htmlspecialchars($os['numero_os']); ?></td>
                                    <td class="table-cell-text" title="<?php echo ucfirst($os['tipo_equipamento']); ?>"><?php echo ucfirst($os['tipo_equipamento']); ?></td>
                                    <td class="table-cell-text" title="<?php echo htmlspecialchars($os['identificacao_equipamento']); ?>"><?php echo htmlspecialchars($os['identificacao_equipamento']); ?></td>
                                    <td class="table-cell-text" title="<?php echo date('d/m/Y H:i', strtotime($os['data_abertura'])); ?>"><?php echo date('d/m/Y H:i', strtotime($os['data_abertura'])); ?></td>
                                    <td class="table-cell-text" title="<?php echo !empty($os['data_conclusao']) ? date('d/m/Y H:i', strtotime($os['data_conclusao'])) : '-'; ?>">
                                        <?php echo !empty($os['data_conclusao']) ? date('d/m/Y H:i', strtotime($os['data_conclusao'])) : '<span class="text-muted">-</span>'; ?>
                                    </td>
                                    <td class="table-cell-text">
                                        <?php if (!empty($os['nome_cliente'])): ?>
                                            <span class="badge bg-info"><?php echo htmlspecialchars($os['nome_cliente']); ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Próprio</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="table-cell-status">
                                        <span class="badge bg-<?php 
                                            echo match($os['status']) {
                                                'aberta' => 'warning',
                                                'em_andamento' => 'info',
                                                'concluida' => 'success',
                                                'cancelada' => 'danger',
                                                default => 'secondary'
                                            };
                                        ?>">
                                            <?php echo ucfirst($os['status']); ?>
                                        </span>
                                    </td>
                                    <td class="table-cell-status">
                                        <span class="badge bg-<?php 
                                            echo match($os['prioridade']) {
                                                'baixa' => 'success',
                                                'media' => 'info',
                                                'alta' => 'warning',
                                                'urgente' => 'danger',
                                                'critica' => 'danger',
                                                default => 'secondary'
                                            };
                                        ?>">
                                            <?php echo ucfirst($os['prioridade']); ?>
                                        </span>
                                    </td>
                                    <td class="table-cell-text" title="<?php echo htmlspecialchars($os['nome_usuario_abertura']); ?>"><?php echo htmlspecialchars($os['nome_usuario_abertura']); ?></td>
                                    <td class="table-cell-actions">
                                        <div class="btn-group">
                                            <a href="os.php?id=<?php echo $os['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="visualiza_os.php?id=<?php echo $os['id']; ?>" class="btn btn-sm btn-info" title="Visualizar">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal de Filtros -->
<div class="modal fade" id="modalFiltros" tabindex="-1" aria-labelledby="modalFiltrosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFiltrosLabel">Filtros</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <form method="GET" action="">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="tipo" class="form-label">Tipo de Ativo</label>
                                <select name="tipo" id="tipo" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="embarcacao" <?php echo ($filtros['tipo_equipamento'] ?? '') === 'embarcacao' ? 'selected' : ''; ?>>Embarcação</option>
                                    <option value="veiculo" <?php echo ($filtros['tipo_equipamento'] ?? '') === 'veiculo' ? 'selected' : ''; ?>>Veículo</option>
                                    <option value="implemento" <?php echo ($filtros['tipo_equipamento'] ?? '') === 'implemento' ? 'selected' : ''; ?>>Implemento</option>
                                    <option value="tanque" <?php echo ($filtros['tipo_equipamento'] ?? '') === 'tanque' ? 'selected' : ''; ?>>Tanque</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="ativo_id" class="form-label">Ativo</label>
                                <select name="ativo_id" id="ativo_id" class="form-select">
                                    <option value="">Todos</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="aberta" <?php echo ($filtros['status'] ?? '') === 'aberta' ? 'selected' : ''; ?>>Aberta</option>
                                    <option value="em_andamento" <?php echo ($filtros['status'] ?? '') === 'em_andamento' ? 'selected' : ''; ?>>Em Andamento</option>
                                    <option value="concluida" <?php echo ($filtros['status'] ?? '') === 'concluida' ? 'selected' : ''; ?>>Concluída</option>
                                    <option value="cancelada" <?php echo ($filtros['status'] ?? '') === 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="prioridade" class="form-label">Prioridade</label>
                                <select name="prioridade" id="prioridade" class="form-select">
                                    <option value="">Todas</option>
                                    <option value="baixa" <?php echo ($filtros['prioridade'] ?? '') === 'baixa' ? 'selected' : ''; ?>>Baixa</option>
                                    <option value="media" <?php echo ($filtros['prioridade'] ?? '') === 'media' ? 'selected' : ''; ?>>Média</option>
                                    <option value="alta" <?php echo ($filtros['prioridade'] ?? '') === 'alta' ? 'selected' : ''; ?>>Alta</option>
                                    <option value="critica" <?php echo ($filtros['prioridade'] ?? '') === 'critica' ? 'selected' : ''; ?>>Crítica</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="data_abertura" class="form-label">Data de Abertura</label>
                                <input type="date" name="data_abertura" id="data_abertura" class="form-control" 
                                       value="<?php echo htmlspecialchars($filtros['data_abertura'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="ordens_servico.php" class="btn btn-secondary">Limpar Filtros</a>
                    <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const ativoSelect = document.getElementById('ativo_id');
    
    // Carrega ativos quando a página carrega
    carregarAtivos();
    
    // Carrega ativos quando o tipo muda
    tipoSelect.addEventListener('change', function() {
        carregarAtivos();
    });
    
    function carregarAtivos() {
        const tipo = tipoSelect.value;
        
        // Limpa o select de ativos
        ativoSelect.innerHTML = '<option value="">Todos</option>';
        
        if (!tipo) {
            // Se nenhum tipo selecionado, desabilita o campo ativo
            ativoSelect.disabled = true;
            ativoSelect.innerHTML = '<option value="">Selecione um tipo de equipamento primeiro</option>';
        } else {
            // Habilita o campo ativo e carrega ativos do tipo específico
            ativoSelect.disabled = false;
            
            fetch(`processamento/busca_equipamentos.php?tipo=${tipo}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.equipamentos.forEach(equipamento => {
                            const option = document.createElement('option');
                            option.value = equipamento.id;
                            option.textContent = equipamento.identificacao;
                            option.selected = equipamento.id == '<?php echo $filtros['ativo_id'] ?? ''; ?>';
                            ativoSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Erro ao carregar ativos:', error);
                });
        }
    }
});
</script>