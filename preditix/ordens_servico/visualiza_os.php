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
                   g.nome as nome_gestor,
                   r.nome as nome_responsavel,
                   CASE 
                       WHEN os.tipo_equipamento = 'embarcacao' THEN e.nome
                       WHEN os.tipo_equipamento = 'veiculo' THEN v.placa
                       WHEN os.tipo_equipamento = 'implemento' THEN i.placa
                       WHEN os.tipo_equipamento = 'tanque' THEN t.tag
                   END as identificacao_equipamento
            FROM ordens_servico os
            LEFT JOIN usuarios u ON u.id = os.usuario_abertura_id
            LEFT JOIN usuarios g ON g.id = os.gestor_id
            LEFT JOIN usuarios r ON r.id = os.usuario_responsavel_id
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

<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Ordem de Serviço #<?php echo htmlspecialchars($os['numero_os']); ?></h1>
        <div>
            <?php if (!empty($os['pdf'])): ?>
                <a href="../download_os_pdf.php?id=<?php echo $os['id']; ?>" class="btn btn-success me-2">
                    <i class="bi bi-download"></i> Download PDF
                </a>
            <?php endif; ?>
            <button onclick="window.print()" class="btn btn-info me-2">
                <i class="bi bi-printer"></i> Imprimir OS
            </button>
            <a href="os.php?id=<?php echo $os['id']; ?>&tipo=<?php echo $os['tipo_equipamento']; ?>" class="btn btn-primary me-2">
                <i class="bi bi-pencil"></i> Editar OS
            </a>
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
                            <p><strong>Aberto por:</strong> <?php echo htmlspecialchars($os['nome_usuario_abertura'] ?? ''); ?></p>
                            <p><strong>Gestor:</strong> <?php echo htmlspecialchars($os['nome_gestor'] ?? ''); ?></p>
                            <p><strong>Responsável:</strong> <?php echo htmlspecialchars($os['nome_responsavel'] ?? ''); ?></p>
                            <p><strong>Tipo de Manutenção:</strong> <?php echo ucfirst($os['tipo_manutencao']); ?></p>
                            <p><strong>Prioridade:</strong> 
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
                            </p>
                            <?php if ($os['data_prevista']): ?>
                                <p><strong>Estimativa de Conclusão:</strong> <?php echo date('d/m/Y', strtotime($os['data_prevista'])); ?></p>
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
                        'tipo_intervencao' => 'Intervenções Realizadas',
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

        <!-- Itens da OS -->
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Itens da Ordem de Serviço</h5>
                </div>
                <div class="card-body">
                    <?php
                    $sql_itens = "SELECT * FROM itens_ordem_servico WHERE ordem_servico_id = :id_os";
                    $itens = $db->query($sql_itens, [':id_os' => $id_os]);
                    
                    if (!empty($itens)):
                    ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Descrição</th>
                                        <th>Quantidade</th>
                                        <th>Valor Unitário</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total_geral = 0;
                                    foreach ($itens as $item): 
                                        $total_item = $item['quantidade'] * $item['valor_unitario'];
                                        $total_geral += $total_item;
                                    ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($item['descricao']); ?></td>
                                            <td><?php echo number_format($item['quantidade'], 2, ',', '.'); ?></td>
                                            <td>R$ <?php echo number_format($item['valor_unitario'], 2, ',', '.'); ?></td>
                                            <td>R$ <?php echo number_format($total_item, 2, ',', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                        <td><strong>R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Nenhum item registrado para esta ordem de serviço.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Adiciona a seção de assinaturas para impressão -->
<div class="assinaturas-print">
    <div class="row mt-5">
        <div class="col-6 text-center">
            <div class="assinatura-box">
                <div class="linha-assinatura"></div>
                <p class="nome-assinatura">Gestor de Manutenção</p>
                <p class="cargo-assinatura"><?php echo htmlspecialchars($os['nome_gestor'] ?? ''); ?></p>
            </div>
        </div>
        <div class="col-6 text-center">
            <div class="assinatura-box">
                <div class="linha-assinatura"></div>
                <p class="nome-assinatura">Responsável de Campo</p>
                <p class="cargo-assinatura"><?php echo htmlspecialchars($os['nome_responsavel'] ?? ''); ?></p>
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

/* Estilos para impressão harmoniosa */
@media print {
    /* Esconde elementos que não devem ser impressos */
    .btn, 
    .no-print {
        display: none !important;
    }

    /* Configuração da página */
    @page {
        margin: 1.5cm;
        size: A4;
    }

    /* Layout geral harmonioso */
    body {
        font-family: 'Arial', sans-serif !important;
        font-size: 11pt !important;
        line-height: 1.4 !important;
        color: #333 !important;
        background: white !important;
    }

    /* Container principal */
    .container-fluid {
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Títulos harmoniosos */
    h1 { 
        font-size: 16pt !important; 
        font-weight: bold !important;
        color: #2c3e50 !important;
        margin: 0 0 15px 0 !important;
        text-align: center !important;
        border-bottom: 2px solid #3498db !important;
        padding-bottom: 8px !important;
    }
    
    h5 { 
        font-size: 12pt !important; 
        font-weight: bold !important;
        color: #34495e !important;
        margin: 0 0 8px 0 !important;
        border-bottom: 1px solid #ecf0f1 !important;
        padding-bottom: 4px !important;
    }
    
    h6 { 
        font-size: 11pt !important; 
        font-weight: bold !important;
        color: #2c3e50 !important;
        margin: 0 0 5px 0 !important;
    }

    /* Cards elegantes */
    .card {
        border: 1px solid #bdc3c7 !important;
        box-shadow: none !important;
        margin-bottom: 12px !important;
        border-radius: 4px !important;
        overflow: hidden !important;
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        border-bottom: 2px solid #3498db !important;
        padding: 8px 12px !important;
        margin: 0 !important;
    }

    .card-body {
        padding: 12px !important;
        background: white !important;
    }

    /* Informações organizadas */
    .row {
        margin: 0 !important;
    }

    .col-md-6, .col-md-8, .col-md-4, .col-md-12 {
        padding: 0 8px !important;
    }

    /* Parágrafos com espaçamento harmonioso */
    p {
        margin: 0 0 6px 0 !important;
        font-size: 10pt !important;
    }

    /* Badges elegantes */
    .badge {
        border: 1px solid #34495e !important;
        font-size: 9pt !important;
        padding: 3px 6px !important;
        border-radius: 3px !important;
        font-weight: bold !important;
    }

    .bg-success { 
        background-color: #d5f4e6 !important; 
        color: #27ae60 !important; 
        border-color: #27ae60 !important;
    }
    .bg-info { 
        background-color: #d6eaf8 !important; 
        color: #3498db !important; 
        border-color: #3498db !important;
    }
    .bg-warning { 
        background-color: #fdeaa7 !important; 
        color: #f39c12 !important; 
        border-color: #f39c12 !important;
    }
    .bg-danger { 
        background-color: #fadbd8 !important; 
        color: #e74c3c !important; 
        border-color: #e74c3c !important;
    }

    /* Tabelas elegantes */
    .table {
        border-collapse: collapse !important;
        width: 100% !important;
        font-size: 10pt !important;
        margin: 8px 0 !important;
        border-radius: 4px !important;
        overflow: hidden !important;
    }

    .table th {
        background: linear-gradient(135deg, #34495e 0%, #2c3e50 100%) !important;
        color: white !important;
        font-weight: bold !important;
        padding: 8px 6px !important;
        border: 1px solid #2c3e50 !important;
        text-align: left !important;
    }

    .table td {
        padding: 6px !important;
        border: 1px solid #bdc3c7 !important;
        background: white !important;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f8f9fa !important;
    }

    /* Timeline elegante */
    .timeline {
        padding: 10px 0 !important;
        position: relative !important;
    }

    .timeline-item {
        padding-left: 25px !important;
        margin-bottom: 8px !important;
        position: relative !important;
    }

    .timeline-marker {
        width: 8px !important;
        height: 8px !important;
        border: 2px solid #3498db !important;
        background: white !important;
        border-radius: 50% !important;
        position: absolute !important;
        left: 0 !important;
        top: 2px !important;
    }

    .timeline-item:not(:last-child)::before {
        content: '' !important;
        position: absolute !important;
        left: 3px !important;
        top: 8px !important;
        height: calc(100% + 8px) !important;
        width: 2px !important;
        background: #bdc3c7 !important;
    }

    .timeline-content {
        background: #f8f9fa !important;
        border: 1px solid #e9ecef !important;
        padding: 8px !important;
        border-radius: 4px !important;
        font-size: 10pt !important;
    }

    /* Listas organizadas */
    .list-unstyled {
        margin: 0 !important;
        padding: 0 !important;
    }

    .list-unstyled li {
        margin-bottom: 3px !important;
        font-size: 10pt !important;
        padding-left: 15px !important;
        position: relative !important;
    }

    .list-unstyled li::before {
        content: '•' !important;
        color: #3498db !important;
        font-weight: bold !important;
        position: absolute !important;
        left: 0 !important;
    }

    /* Assinaturas elegantes */
    .assinaturas-print {
        display: block !important;
        margin-top: 30px !important;
        padding-top: 20px !important;
        border-top: 2px solid #bdc3c7 !important;
    }

    .assinatura-box {
        margin: 15px !important;
        padding: 10px !important;
        text-align: center !important;
    }

    .linha-assinatura {
        border-top: 1px solid #2c3e50 !important;
        width: 200px !important;
        margin: 30px auto 8px !important;
    }

    .nome-assinatura {
        font-weight: bold !important;
        margin: 5px 0 !important;
        font-size: 11pt !important;
        color: #2c3e50 !important;
    }

    .cargo-assinatura {
        font-size: 9pt !important;
        color: #7f8c8d !important;
        margin: 0 !important;
    }

    /* Cabeçalho da impressão */
    .print-header {
        display: block !important;
        text-align: center !important;
        margin-bottom: 20px !important;
        padding: 15px !important;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
        border: 1px solid #bdc3c7 !important;
        border-radius: 4px !important;
    }

    .print-header h2 {
        margin: 0 0 5px 0 !important;
        font-size: 14pt !important;
        color: #2c3e50 !important;
        font-weight: bold !important;
    }

    .print-header p {
        margin: 2px 0 !important;
        font-size: 9pt !important;
        color: #7f8c8d !important;
    }

    /* Evita quebras de página */
    .card, .table, .timeline {
        page-break-inside: avoid !important;
    }

    /* Remove espaçamentos desnecessários */
    .mb-4 { margin-bottom: 12px !important; }
    .mb-3 { margin-bottom: 8px !important; }
    .mb-2 { margin-bottom: 6px !important; }
    .mt-4 { margin-top: 12px !important; }
    .mt-3 { margin-top: 8px !important; }
    .mt-2 { margin-top: 6px !important; }
}

/* Adiciona cabeçalho específico para impressão */
.print-header {
    display: none;
}

/* Estilos para a seção de assinaturas */
.assinaturas-print {
    display: none;
}
</style>

<!-- Adiciona o cabeçalho para impressão -->
<div class="print-header">
    <h2>Ordem de Serviço #<?php echo htmlspecialchars($os['numero_os']); ?></h2>
    <p>Data de Emissão: <?php echo date('d/m/Y H:i'); ?></p>
    <p>Sistema Preditix - Gestão de Manutenção</p>
</div>

</body>
</html>
