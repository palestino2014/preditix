<?php
require_once 'includes/auth.php';
require_once 'classes/Embarcacao.php';
require_once 'classes/Implemento.php';
require_once 'classes/Tanque.php';
require_once 'classes/Veiculo.php';
require_once 'classes/OrdemServico.php';
require_once 'classes/Alertas.php';

Auth::checkAuth();

// Inicializar classes
$embarcacao = new Embarcacao();
$implemento = new Implemento();
$tanque = new Tanque();
$veiculo = new Veiculo();
$ordemServico = new OrdemServico();
$alertas = new Alertas();

// Buscar dados
$embarcacoes = $embarcacao->listar();
$implementos = $implemento->listar();
$tanques = $tanque->listar();
$veiculos = $veiculo->listar();
$ordens = $ordemServico->listar();

// Buscar alertas
$alertasCriticos = $alertas->getAlertasCriticos();
$alertasTempo = $alertas->getAlertasTempo();
$estatisticas = $alertas->getEstatisticas();

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

    <div class="container-fluid mt-4">

        <!-- Lista de Alertas Críticos -->
        <div class="row mb-4">
            <!-- Ordens Urgentes -->
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Ordens Urgentes/Alta Prioridade
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        <?php if (!empty($alertasCriticos['ordens_urgentes'])): ?>
                            <?php foreach ($alertasCriticos['ordens_urgentes'] as $ordem): ?>
                                <a href="ordens_servico/visualiza_os.php?id=<?php echo $ordem['id']; ?>" 
                                   class="text-decoration-none">
                                    <div class="alert alert-<?php echo $alertas->getCorPrioridade($ordem['prioridade']); ?> py-2 mb-2 cursor-pointer" 
                                         style="cursor: pointer; transition: all 0.2s ease;" 
                                         onmouseover="this.style.transform='scale(1.02)'" 
                                         onmouseout="this.style.transform='scale(1)'">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo $ordem['numero_os']; ?></strong>
                                                <br>
                                                <small>
                                                    <i class="bi <?php echo $alertas->getIconeEquipamento($ordem['tipo_equipamento']); ?> me-1"></i>
                                                    <?php echo ucfirst($ordem['tipo_equipamento']); ?> #<?php echo $ordem['equipamento_id']; ?>
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-<?php echo $alertas->getCorPrioridade($ordem['prioridade']); ?>">
                                                    <?php echo ucfirst($ordem['prioridade']); ?>
                                                </span>
                                                <br>
                                                <small><?php echo $alertas->formatarData($ordem['data_abertura']); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-3">
                                <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                                <p class="mt-2">Nenhuma ordem urgente!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Ordens Antigas -->
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-clock-history me-2"></i>
                            Ordens Abertas há Mais de 30 Dias
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        <?php if (!empty($alertasCriticos['ordens_antigas'])): ?>
                            <?php foreach ($alertasCriticos['ordens_antigas'] as $ordem): ?>
                                <a href="ordens_servico/visualiza_os.php?id=<?php echo $ordem['id']; ?>" 
                                   class="text-decoration-none">
                                    <div class="alert alert-warning py-2 mb-2 cursor-pointer" 
                                         style="cursor: pointer; transition: all 0.2s ease;" 
                                         onmouseover="this.style.transform='scale(1.02)'" 
                                         onmouseout="this.style.transform='scale(1)'">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo $ordem['numero_os']; ?></strong>
                                                <br>
                                                <small>
                                                    <i class="bi <?php echo $alertas->getIconeEquipamento($ordem['tipo_equipamento']); ?> me-1"></i>
                                                    <?php echo ucfirst($ordem['tipo_equipamento']); ?> #<?php echo $ordem['equipamento_id']; ?>
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-warning text-dark">
                                                    <?php echo $alertas->formatarDias($ordem['dias_aberta']); ?>
                                                </span>
                                                <br>
                                                <small><?php echo $alertas->formatarData($ordem['data_abertura']); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-3">
                                <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                                <p class="mt-2">Nenhuma ordem antiga!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Alertas de Tempo -->
        <div class="row mb-4">
            <!-- Ordens há 7+ dias -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header" style="background-color:rgb(202, 247, 255); color:rgb(42, 223, 255);">
                        <h5 class="mb-0">
                            <i class="bi bi-calendar-week me-2"></i>
                            Ordens há 7+ Dias
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                        <?php if (!empty($alertasTempo['ordens_7_dias'])): ?>
                            <?php foreach ($alertasTempo['ordens_7_dias'] as $ordem): ?>
                                <a href="ordens_servico/visualiza_os.php?id=<?php echo $ordem['id']; ?>" 
                                   class="text-decoration-none">
                                    <div class="alert alert-info py-2 mb-2 cursor-pointer" 
                                         style="cursor: pointer; transition: all 0.2s ease;" 
                                         onmouseover="this.style.transform='scale(1.02)'" 
                                         onmouseout="this.style.transform='scale(1)'">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo $ordem['numero_os']; ?></strong>
                                                <br>
                                                <small>
                                                    <i class="bi <?php echo $alertas->getIconeEquipamento($ordem['tipo_equipamento']); ?> me-1"></i>
                                                    <?php echo ucfirst($ordem['tipo_equipamento']); ?>
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-info">
                                                    <?php echo $alertas->formatarDias($ordem['dias_aberta']); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-3">
                                <i class="bi bi-check-circle text-success" style="font-size: 1.5rem;"></i>
                                <p class="mt-2">Nenhuma ordem!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Ordens em andamento há muito tempo -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header" style="background-color:rgb(255, 233, 162); color: #856404;">
                        <h5 class="mb-0">
                            <i class="bi bi-gear-wide-connected me-2"></i>
                            Em Andamento há 15+ Dias
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                        <?php if (!empty($alertasTempo['ordens_andamento_longo'])): ?>
                            <?php foreach ($alertasTempo['ordens_andamento_longo'] as $ordem): ?>
                                <a href="ordens_servico/visualiza_os.php?id=<?php echo $ordem['id']; ?>" 
                                   class="text-decoration-none">
                                    <div class="alert alert-warning py-2 mb-2 cursor-pointer" 
                                         style="cursor: pointer; transition: all 0.2s ease;" 
                                         onmouseover="this.style.transform='scale(1.02)'" 
                                         onmouseout="this.style.transform='scale(1)'">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo $ordem['numero_os']; ?></strong>
                                                <br>
                                                <small>
                                                    <i class="bi <?php echo $alertas->getIconeEquipamento($ordem['tipo_equipamento']); ?> me-1"></i>
                                                    <?php echo ucfirst($ordem['tipo_equipamento']); ?>
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-warning text-dark">
                                                    <?php echo $alertas->formatarDias($ordem['dias_aberta']); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-3">
                                <i class="bi bi-check-circle text-success" style="font-size: 1.5rem;"></i>
                                <p class="mt-2">Nenhuma ordem!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Ordens concluídas hoje -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-header" style="background-color: #d4edda; color: #155724;">
                        <h5 class="mb-0">
                            <i class="bi bi-check-circle me-2"></i>
                            Concluídas Hoje
                        </h5>
                    </div>
                    <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                        <?php if (!empty($alertasTempo['ordens_concluidas_hoje'])): ?>
                            <?php foreach ($alertasTempo['ordens_concluidas_hoje'] as $ordem): ?>
                                <a href="ordens_servico/visualiza_os.php?id=<?php echo $ordem['id']; ?>" 
                                   class="text-decoration-none">
                                    <div class="alert alert-success py-2 mb-2 cursor-pointer" 
                                         style="cursor: pointer; transition: all 0.2s ease;" 
                                         onmouseover="this.style.transform='scale(1.02)'" 
                                         onmouseout="this.style.transform='scale(1)'">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <strong><?php echo $ordem['numero_os']; ?></strong>
                                                <br>
                                                <small>
                                                    <i class="bi <?php echo $alertas->getIconeEquipamento($ordem['tipo_equipamento']); ?> me-1"></i>
                                                    <?php echo ucfirst($ordem['tipo_equipamento']); ?>
                                                </small>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-success">
                                                    <?php echo $alertas->formatarDias($ordem['dias_duracao']); ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center text-muted py-3">
                                <i class="bi bi-info-circle text-info" style="font-size: 2rem;"></i>
                                <p class="mt-2">Nenhuma ordem concluída hoje!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>