<?php
// Define a URL base do projeto
$base_url = '/preditix';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Manutenção - <?php echo $titulo ?? 'Dashboard'; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/assets/css/style.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Inicializar todos os dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl);
            });
        });
    </script>
    <style>
        /* Estilos comuns para tabelas de ativos */
        .table-ativos {
            width: 100%;
            table-layout: fixed;
            margin-bottom: 0;
        }
        .table-ativos th,
        .table-ativos td {
            padding: 0.5rem;
            vertical-align: middle;
        }
        .table-cell-text {
            max-width: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .table-cell-actions {
            white-space: nowrap;
            width: 160px;
            padding-right: 1rem;
        }
        .table-cell-status {
            width: 100px;
            text-align: center;
        }
        .table-cell-number {
            width: 120px;
            text-align: right;
        }
        /* Ajustes específicos para cada tipo de coluna */
        .col-tag { width: 12%; }
        .col-placa { width: 10%; }
        .col-nome { width: 18%; }
        .col-fabricante { width: 18%; }
        .col-modelo { width: 15%; }
        .col-ano { width: 7%; }
        .col-inscricao { width: 10%; }
        .col-tipo { width: 12%; }
        .col-localizacao { width: 18%; }
        .col-armador { width: 18%; }
        /* Classes específicas para a tabela de ordens de serviço */
        .col-numero { width: 10%; }
        .col-equipamento { width: 20%; }
        .col-data { width: 15%; }
        .col-usuario { width: 15%; }

        /* Ajustes para os botões de ação */
        .btn-group {
            gap: 0.25rem;
        }
        .btn-group .btn {
            padding: 0.25rem 0.5rem;
        }
        .btn-group .btn i {
            font-size: 0.875rem;
        }

        /* Ajuste para o container da tabela */
        .table-responsive {
            overflow-x: hidden;
        }
        .card-body {
            padding: 1rem;
        }
    </style>
</head>
<body>
    <header class="shadow-sm bg-white mb-4">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="<?php echo $base_url; ?>/index.php">
                    <i class="bi bi-gear-fill text-primary me-2" style="font-size: 1.5rem;"></i>
                    <span class="fw-bold">Preditix</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                        <!-- Menu Equipamentos -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="equipamentosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-box-seam me-1"></i> Ativos
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="equipamentosDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?php echo $base_url; ?>/embarcacoes.php">
                                        <i class="bi bi-water me-2 text-primary"></i> Embarcações
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo $base_url; ?>/implementos.php">
                                        <i class="bi bi-truck me-2 text-success"></i> Implementos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo $base_url; ?>/tanques.php">
                                        <i class="bi bi-droplet me-2 text-info"></i> Tanques
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo $base_url; ?>/veiculos.php">
                                        <i class="bi bi-car-front me-2 text-warning"></i> Veículos
                                    </a>
                                </li>
                            </ul>
                        </li>
                        
                        <!-- Ordens de Serviço -->
                        <li class="nav-item">
                            <a class="nav-link <?php echo strpos($_SERVER['PHP_SELF'], 'ordens_servico.php') !== false ? 'active' : ''; ?>" href="<?php echo $base_url; ?>/ordens_servico/ordens_servico.php">
                                <i class="bi bi-clipboard-check me-1"></i> Ordens de Serviço
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Perfil do Usuário -->
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="bi bi-person-circle me-2" style="font-size: 1.5rem;"></i>
                            <div>
                                <span class="d-block"><?php echo $_SESSION['usuario_nome']; ?></span>
                                <small class="text-muted"><?php echo $_SESSION['usuario_email']; ?></small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Meu Perfil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Configurações</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?php echo $base_url; ?>/logout.php"><i class="bi bi-box-arrow-right me-2"></i> Sair</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>


    <div class="container-fluid px-4">