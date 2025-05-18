<?php
$titulo = 'Visualizar Ordem de Serviço';
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../classes/Database.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

// Verifica se o ID da OS foi fornecido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../ordens_servico.php');
    exit;
}

$id_os = (int)$_GET['id'];

// Inicializa a conexão com o banco de dados
$db = new Database();

try {
    // Busca os dados da OS
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
            WHERE os.id = :id";

    error_log("Tentando buscar OS ID: " . $id_os);
    error_log("SQL: " . $sql);
    error_log("Parâmetros: " . print_r([':id' => $id_os], true));
    
    try {
        $result = $db->query($sql, [':id' => $id_os]);
        error_log("Resultado da query: " . print_r($result, true));
    } catch (PDOException $e) {
        error_log("Erro PDO ao executar query: " . $e->getMessage());
        error_log("Código do erro: " . $e->getCode());
        error_log("Estado SQL: " . $e->errorInfo[0]);
        throw $e;
    }
    
    $os = $result[0] ?? null;

    if (!$os) {
        error_log("OS não encontrada para o ID: " . $id_os);
        header('Location: ../ordens_servico.php');
        exit;
    }

    // Inicializa o histórico como array vazio
    $historico = [];
    
    // Tenta buscar o histórico da OS
    try {
        $sql_historico = "SELECT h.*, u.nome as nome_usuario
                         FROM historico_os h
                         LEFT JOIN usuarios u ON u.id = h.usuario_id
                         WHERE h.ordem_servico_id = :id_os
                         ORDER BY h.data_registro DESC";
        
        error_log("SQL Histórico: " . $sql_historico);
        error_log("Parâmetros Histórico: " . print_r([':id_os' => $id_os], true));
        
        $historico = $db->query($sql_historico, [':id_os' => $id_os]);
        error_log("Resultado do histórico: " . print_r($historico, true));
    } catch (Exception $e) {
        error_log("Erro ao buscar histórico: " . $e->getMessage());
        error_log("Stack trace do histórico: " . $e->getTraceAsString());
        // O histórico permanece como array vazio
    }

} catch (Exception $e) {
    error_log("Erro detalhado ao buscar dados da OS: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    error_log("SQL State: " . ($e->getCode() ?? 'N/A'));
    
    // Em ambiente de desenvolvimento, mostra o erro
    if (defined('ENVIRONMENT') && ENVIRONMENT === 'development') {
        die("Erro ao buscar dados da ordem de serviço: " . $e->getMessage() . 
            "<br>SQL State: " . ($e->getCode() ?? 'N/A') . 
            "<br>Stack trace: <pre>" . $e->getTraceAsString() . "</pre>");
    } else {
        // Verifica se é um erro de tabela não encontrada
        if ($e instanceof PDOException && $e->getCode() == '42S02') {
            error_log("Erro: Tabela não encontrada no banco de dados");
            die("Erro de configuração do banco de dados. Por favor, contate o administrador do sistema.");
        }
        
        // Verifica se é um erro de conexão
        if ($e instanceof PDOException && $e->getCode() == 'HY000') {
            error_log("Erro: Falha na conexão com o banco de dados");
            die("Erro de conexão com o banco de dados. Por favor, tente novamente mais tarde.");
        }
        
        die("Erro ao buscar dados da ordem de serviço. Por favor, tente novamente mais tarde.");
    }
}

// Inclui o cabeçalho
require_once '../includes/header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ordem de Serviço #<?php echo htmlspecialchars($os['numero_os']); ?></h1>
        <div>
            <?php if ($os['status'] === 'aberta'): ?>
                <a href="os.php?id=<?php echo $os['id']; ?>&tipo=<?php echo $os['tipo_equipamento']; ?>" class="btn btn-primary">
                    <i class="bi bi-pencil"></i> Editar OS
                </a>
            <?php endif; ?>
            <a href="ordens_servico.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informações Principais -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informações da OS</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tipo de Equipamento:</strong> <?php echo ucfirst($os['tipo_equipamento']); ?></p>
                            <p><strong>Equipamento:</strong> <?php echo htmlspecialchars($os['identificacao_equipamento']); ?></p>
                            <p><strong>Data de Abertura:</strong> <?php echo date('d/m/Y H:i', strtotime($os['data_abertura'])); ?></p>
                            <p><strong>Aberto por:</strong> <?php echo htmlspecialchars($os['nome_usuario_abertura']); ?></p>
                            <p><strong>Tipo de Manutenção:</strong> <?php echo ucfirst($os['tipo_manutencao']); ?></p>
                            <p><strong>Prioridade:</strong> 
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
                            </p>
                            <?php if ($os['data_prevista']): ?>
                                <p><strong>Data Prevista:</strong> <?php echo date('d/m/Y', strtotime($os['data_prevista'])); ?></p>
                            <?php endif; ?>
                            <?php if (($os['tipo_equipamento'] === 'veiculo' || $os['tipo_equipamento'] === 'implemento') && isset($os['odometro'])): ?>
                                <p><strong>Odômetro:</strong> <?php echo number_format($os['odometro'], 0, ',', '.'); ?> km</p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <p>
                                <strong>Status:</strong>
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
                            </p>
                            <?php if ($os['data_conclusao']): ?>
                                <p><strong>Data de Conclusão:</strong> <?php echo date('d/m/Y H:i', strtotime($os['data_conclusao'])); ?></p>
                            <?php endif; ?>
                            <?php if (isset($os['usuario_conclusao']) && !empty($os['usuario_conclusao'])): ?>
                                <p><strong>Concluído por:</strong> <?php echo htmlspecialchars($os['usuario_conclusao']); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (!empty($os['descricao_problema'])): ?>
                        <div class="mt-4">
                            <h5>Descrição do Problema</h5>
                            <p><?php echo nl2br(htmlspecialchars($os['descricao_problema'])); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($os['observacoes'])): ?>
                        <div class="mt-4">
                            <h5>Observações</h5>
                            <p><?php echo nl2br(htmlspecialchars($os['observacoes'])); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Histórico -->
            <?php if (!empty($historico)): ?>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Histórico</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <?php foreach ($historico as $registro): ?>
                                <div class="timeline-item">
                                    <div class="timeline-marker"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1"><?php echo htmlspecialchars($registro['acao']); ?></h6>
                                        <p class="text-muted mb-0">
                                            <?php echo date('d/m/Y H:i', strtotime($registro['data_registro'])); ?> - 
                                            Por: <?php echo htmlspecialchars($registro['nome_usuario']); ?>
                                        </p>
                                        <?php if ($registro['observacao']): ?>
                                            <p class="mt-2"><?php echo nl2br(htmlspecialchars($registro['observacao'])); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Detalhes Técnicos -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Detalhes Técnicos</h5>
                </div>
                <div class="card-body">
                    <?php
                    $campos_json = [
                        'sistemas_afetados' => 'Sistemas Afetados',
                        'sintomas_detectados' => 'Sintomas Detectados',
                        'causas_defeitos' => 'Causas dos Defeitos',
                        'intervencoes_realizadas' => 'Intervenções Realizadas',
                        'acoes_realizadas' => 'Ações Realizadas'
                    ];

                    foreach ($campos_json as $campo => $titulo):
                        $valores = json_decode($os[$campo] ?? '[]', true);
                        if (!empty($valores)):
                    ?>
                        <div class="mb-3">
                            <h6><?php echo $titulo; ?></h6>
                            <ul class="list-unstyled">
                                <?php foreach ($valores as $valor): ?>
                                    <li><i class="bi bi-check2"></i> <?php echo htmlspecialchars($valor); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>

                    <?php if (isset($os['custo_total']) && !empty($os['custo_total'])): ?>
                        <div class="mt-3">
                            <h6>Custo Total</h6>
                            <p class="h5">R$ <?php echo number_format($os['custo_total'], 2, ',', '.'); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 0;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #0d6efd;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #0d6efd;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 5px;
    top: 12px;
    height: calc(100% + 8px);
    width: 2px;
    background: #dee2e6;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 4px;
}
</style>

<!-- Scripts do Bootstrap e jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
