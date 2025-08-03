<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../classes/Database.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

// Obtém o tipo de equipamento da URL
$tipo_equipamento = isset($_GET['tipo']) ? $_GET['tipo'] : null;

// Valida o tipo de equipamento
$tipos_permitidos = ['embarcacao', 'veiculo', 'implemento', 'tanque'];
if (!in_array($tipo_equipamento, $tipos_permitidos)) {
    die('Tipo de equipamento inválido');
}

// Inicializa a conexão com o banco de dados
$db = new Database();

// Busca as ordens de serviço
$sql = "SELECT os.*, 
               u.nome as nome_usuario_abertura,
               CASE 
                   WHEN os.tipo_equipamento = 'embarcacao' THEN e.nome
                   WHEN os.tipo_equipamento = 'veiculo' THEN v.placa
                   WHEN os.tipo_equipamento = 'implemento' THEN i.placa
                   WHEN os.tipo_equipamento = 'tanque' THEN t.tag
               END as identificacao_equipamento
        FROM ordens_servico os
        LEFT JOIN usuarios u ON u.id = os.usuario_abertura_id
        LEFT JOIN embarcacoes e ON e.id = os.equipamento_id AND os.tipo_equipamento = 'embarcacao'
        LEFT JOIN veiculos v ON v.id = os.equipamento_id AND os.tipo_equipamento = 'veiculo'
        LEFT JOIN implementos i ON i.id = os.equipamento_id AND os.tipo_equipamento = 'implemento'
        LEFT JOIN tanques t ON t.id = os.equipamento_id AND os.tipo_equipamento = 'tanque'
        WHERE os.tipo_equipamento = :tipo
        ORDER BY os.data_abertura DESC, os.numero_os DESC";

try {
    $ordens_servico = $db->query($sql, ['tipo' => $tipo_equipamento]);
} catch (Exception $e) {
    error_log("Erro ao buscar ordens de serviço: " . $e->getMessage());
    die("Erro ao buscar ordens de serviço. Por favor, tente novamente mais tarde.");
}

// Inclui o cabeçalho
require_once '../includes/header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ordens de Serviço - <?php echo ucfirst($tipo_equipamento); ?>s</h1>
        <div>
            <a href="os.php?tipo=<?php echo $tipo_equipamento; ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nova OS
            </a>
        </div>
    </div>

    <?php if (empty($ordens_servico)): ?>
        <div class="alert alert-info">
            Nenhuma ordem de serviço encontrada para este tipo de equipamento.
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Número OS</th>
                        <th>Equipamento</th>
                        <th>Data Abertura</th>
                        <th>Status</th>
                        <th>Prioridade</th>
                        <th>Aberto por</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordens_servico as $os): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($os['numero_os']); ?></td>
                            <td><?php echo htmlspecialchars($os['identificacao_equipamento']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($os['data_abertura'])); ?></td>
                            <td>
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
                            <td>
                                <span class="badge bg-<?php 
                                    echo match($os['prioridade']) {
                                        'baixa' => 'success',
                                        'media' => 'info',
                                        'alta' => 'warning',
                                        'urgente' => 'danger',
                                        default => 'secondary'
                                    };
                                ?>">
                                    <?php echo ucfirst($os['prioridade']); ?>
                                </span>
                            </td>
                            <td><?php echo htmlspecialchars($os['nome_usuario_abertura']); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="visualiza_os.php?id=<?php echo $os['id']; ?>" 
                                       class="btn btn-info btn-sm" title="Visualizar">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if ($os['status'] === 'aberta'): ?>
                                        <a href="edita_os.php?id=<?php echo $os['id']; ?>" 
                                           class="btn btn-primary btn-sm" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
