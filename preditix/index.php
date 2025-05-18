<?php
// require_once 'includes/init.php';
require_once 'classes/Embarcacao.php';
require_once 'classes/Implemento.php';
require_once 'classes/Tanque.php';
require_once 'classes/Veiculo.php';
require_once 'classes/OrdemServico.php';

// Inicializar classes
$embarcacao = new Embarcacao();
$implemento = new Implemento();
$tanque = new Tanque();
$veiculo = new Veiculo();
$ordemServico = new OrdemServico();

// Buscar dados
$embarcacoes = $embarcacao->listar();
$implementos = $implemento->listar();
$tanques = $tanque->listar();
$veiculos = $veiculo->listar();
$ordens = $ordemServico->listar();

// Calcular estatísticas
$totalAtivos = count($embarcacoes) + count($implementos) + count($tanques) + count($veiculos);
$ordensAbertas = array_filter($ordens, function($ordem) { return $ordem['status'] == 'aberta'; });
$ordensEmAndamento = array_filter($ordens, function($ordem) { return $ordem['status'] == 'em_andamento'; });
$ordensConcluidas = array_filter($ordens, function($ordem) { return $ordem['status'] == 'concluida'; });

// Calcular custos
$custoTotal = array_sum(array_column($ordens, 'custo_estimado'));
$custoConcluido = array_sum(array_column($ordensConcluidas, 'custo_estimado'));

// Verificar existência das páginas de análise
$temDashboard = file_exists('dashboard.php');
$temAnaliseIndicadores = file_exists('analise_indicadores.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preditix - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .card {
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        .card-title {
            font-size: 1.1rem;
            color: #6c757d;
        }
        .card-value {
            font-size: 1.8rem;
            font-weight: bold;
            color: #0d6efd;
        }
        .nav-link {
            color: #495057;
        }
        .nav-link:hover {
            color: #0d6efd;
        }
        .nav-link.active {
            color: #0d6efd;
            font-weight: bold;
        }
        .analysis-card {
            height: 100%;
            text-align: center;
            padding: 1.5rem 1rem;
        }
        .analysis-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        .analysis-description {
            color: #6c757d;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Cards de Estatísticas -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-box-seam card-icon text-primary"></i>
                    <h6 class="card-title">Total de Ativos</h6>
                    <div class="card-value"><?php echo $totalAtivos; ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-file-earmark-text card-icon text-warning"></i>
                    <h6 class="card-title">Ordens Abertas</h6>
                    <div class="card-value"><?php echo count($ordensAbertas); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-gear card-icon text-info"></i>
                    <h6 class="card-title">Em Andamento</h6>
                    <div class="card-value"><?php echo count($ordensEmAndamento); ?></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="bi bi-check-circle card-icon text-success"></i>
                    <h6 class="card-title">Concluídas</h6>
                    <div class="card-value"><?php echo count($ordensConcluidas); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Custos -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Custos de Manutenção</h5>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted">Total Estimado</h6>
                            <h3 class="text-primary">R$ <?php echo number_format($custoTotal, 2, ',', '.'); ?></h3>
                        </div>
                        <div>
                            <h6 class="text-muted">Concluído</h6>
                            <h3 class="text-success">R$ <?php echo number_format($custoConcluido, 2, ',', '.'); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Distribuição de Ativos</h5>
                    <div class="row">
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-water me-2 text-primary"></i>
                                <span>Embarcações: <?php echo count($embarcacoes); ?></span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-truck me-2 text-success"></i>
                                <span>Implementos: <?php echo count($implementos); ?></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-droplet me-2 text-info"></i>
                                <span>Tanques: <?php echo count($tanques); ?></span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bi bi-car-front me-2 text-warning"></i>
                                <span>Veículos: <?php echo count($veiculos); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>