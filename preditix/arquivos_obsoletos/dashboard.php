<?php
require_once '../includes/auth.php';
require_once 'classes/Indicadores.php';
require_once 'classes/Widget.php';

Auth::checkAuth();

$indicadores = new Indicadores();
$widget = new Widget();

// Buscar widgets do usuário
$widgets_usuario = $widget->listarPorUsuario($_SESSION['usuario_id']);
$tipos_widgets = $widget->obterTiposWidgets();

// Buscar templates disponíveis
$templates = $widget->listarTemplates();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customizável - Preditix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.css">
    
    <style>
        .dashboard-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        
        .dashboard-header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }
        
        .widget-grid {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 15px;
            min-height: 600px;
        }
        
        .widget {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            cursor: move;
        }
        
        .widget:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
        
        .widget-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .widget-title {
            font-weight: 600;
            color: #333;
            margin: 0;
            flex: 1;
        }
        
        .widget-controls {
            display: flex;
            gap: 5px;
        }
        
        .widget-control-btn {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 2px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .widget-control-btn:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #333;
        }
        
        .widget-content {
            min-height: 100px;
        }
        
        .widget-placeholder {
            border: 2px dashed rgba(255, 255, 255, 0.5);
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1.1em;
            min-height: 150px;
        }
        
        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            height: fit-content;
        }
        
        .widget-type-item {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .widget-type-item:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateX(5px);
        }
        
        .widget-type-icon {
            font-size: 1.5em;
            margin-right: 10px;
            color: #667eea;
        }
        
        .btn-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }
        
        .indicator-card {
            text-align: center;
            padding: 20px;
        }
        
        .indicator-value {
            font-size: 2.5em;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .indicator-unit {
            font-size: 1.2em;
            color: #666;
            margin-bottom: 10px;
        }
        
        .indicator-title {
            font-size: 1.1em;
            color: #333;
            font-weight: 600;
        }
        
        .alert-widget {
            max-height: 300px;
            overflow-y: auto;
        }
        
        .alert-item {
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 8px;
            border-left: 4px solid;
        }
        
        .alert-item.alta {
            background: rgba(220, 53, 69, 0.1);
            border-left-color: #dc3545;
        }
        
        .alert-item.media {
            background: rgba(255, 193, 7, 0.1);
            border-left-color: #ffc107;
        }
        
        .alert-item.baixa {
            background: rgba(40, 167, 69, 0.1);
            border-left-color: #28a745;
        }
        
        .modal-custom {
            backdrop-filter: blur(10px);
        }
        
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="dashboard-container">
        <!-- Header do Dashboard -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard Customizável
                    </h1>
                    <p class="text-muted mb-0">Personalize sua visão dos indicadores</p>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-custom me-2" data-bs-toggle="modal" data-bs-target="#modalTemplates">
                        <i class="bi bi-grid-3x3-gap me-1"></i>
                        Templates
                    </button>
                    <button class="btn btn-custom me-2" data-bs-toggle="modal" data-bs-target="#modalAddWidget">
                        <i class="bi bi-plus-circle me-1"></i>
                        Adicionar Widget
                    </button>
                    <button class="btn btn-custom" onclick="salvarDashboard()">
                        <i class="bi bi-save me-1"></i>
                        Salvar
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar com tipos de widgets -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h5 class="mb-3">
                        <i class="bi bi-puzzle me-2"></i>
                        Tipos de Widgets
                    </h5>
                    
                    <?php foreach ($tipos_widgets as $tipo => $info): ?>
                    <div class="widget-type-item" onclick="adicionarWidget('<?php echo $tipo; ?>')">
                        <div class="d-flex align-items-center">
                            <i class="bi <?php echo $info['icone']; ?> widget-type-icon"></i>
                            <div>
                                <div class="fw-bold"><?php echo $info['nome']; ?></div>
                                <small class="text-muted"><?php echo $info['descricao']; ?></small>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Área principal do dashboard -->
            <div class="col-md-9">
                <div class="widget-grid" id="dashboardGrid">
                    <?php if (empty($widgets_usuario)): ?>
                        <div class="widget-placeholder" style="grid-column: span 12;">
                            <div class="text-center">
                                <i class="bi bi-plus-circle" style="font-size: 3em; margin-bottom: 15px;"></i>
                                <h4>Seu dashboard está vazio</h4>
                                <p>Adicione widgets arrastando da barra lateral ou use um template</p>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($widgets_usuario as $widget_data): ?>
                            <div class="widget" 
                                 data-widget-id="<?php echo $widget_data['id']; ?>"
                                 style="grid-column: span <?php echo $widget_data['largura']; ?>; grid-row: span <?php echo $widget_data['altura']; ?>;">
                                <div class="widget-header">
                                    <h6 class="widget-title"><?php echo htmlspecialchars($widget_data['titulo']); ?></h6>
                                    <div class="widget-controls">
                                        <button class="widget-control-btn" onclick="configurarWidget(<?php echo $widget_data['id']; ?>)">
                                            <i class="bi bi-gear"></i>
                                        </button>
                                        <button class="widget-control-btn" onclick="removerWidget(<?php echo $widget_data['id']; ?>)">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="widget-content" id="widget-<?php echo $widget_data['id']; ?>">
                                    <!-- Conteúdo do widget será carregado via AJAX -->
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para adicionar widget -->
    <div class="modal fade modal-custom" id="modalAddWidget" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Widget</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formAddWidget">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo_widget" class="form-label">Tipo de Widget</label>
                                    <select class="form-select" id="tipo_widget" name="tipo_widget" required>
                                        <option value="">Selecione...</option>
                                        <?php foreach ($tipos_widgets as $tipo => $info): ?>
                                            <option value="<?php echo $tipo; ?>"><?php echo $info['nome']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="titulo_widget" class="form-label">Título</label>
                                    <input type="text" class="form-control" id="titulo_widget" name="titulo" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="largura_widget" class="form-label">Largura</label>
                                    <select class="form-select" id="largura_widget" name="largura">
                                        <option value="1">1 coluna</option>
                                        <option value="2">2 colunas</option>
                                        <option value="3">3 colunas</option>
                                        <option value="4">4 colunas</option>
                                        <option value="6">6 colunas</option>
                                        <option value="12">12 colunas (largura total)</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="altura_widget" class="form-label">Altura</label>
                                    <select class="form-select" id="altura_widget" name="altura">
                                        <option value="1">1 linha</option>
                                        <option value="2">2 linhas</option>
                                        <option value="3">3 linhas</option>
                                        <option value="4">4 linhas</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div id="configuracoes_widget">
                            <!-- Configurações específicas do widget serão carregadas aqui -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-custom" onclick="salvarWidget()">Adicionar Widget</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para templates -->
    <div class="modal fade modal-custom" id="modalTemplates" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Templates de Dashboard</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-graph-up-arrow" style="font-size: 3em; color: #667eea; margin-bottom: 15px;"></i>
                                    <h5>Dashboard Executivo</h5>
                                    <p class="text-muted">Visão geral dos principais KPIs para gestão</p>
                                    <button class="btn btn-custom" onclick="aplicarTemplate('executivo')">Aplicar</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-gear" style="font-size: 3em; color: #667eea; margin-bottom: 15px;"></i>
                                    <h5>Dashboard Operacional</h5>
                                    <p class="text-muted">Foco em operações e manutenções em andamento</p>
                                    <button class="btn btn-custom" onclick="aplicarTemplate('operacional')">Aplicar</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-currency-dollar" style="font-size: 3em; color: #667eea; margin-bottom: 15px;"></i>
                                    <h5>Dashboard Financeiro</h5>
                                    <p class="text-muted">Foco em custos e eficiência financeira</p>
                                    <button class="btn btn-custom" onclick="aplicarTemplate('financeiro')">Aplicar</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="bi bi-tools" style="font-size: 3em; color: #667eea; margin-bottom: 15px;"></i>
                                    <h5>Dashboard Manutenção</h5>
                                    <p class="text-muted">Foco em detalhes técnicos de manutenção</p>
                                    <button class="btn btn-custom" onclick="aplicarTemplate('manutencao')">Aplicar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <script>
        // Inicializar drag and drop
        new Sortable(document.getElementById('dashboardGrid'), {
            animation: 150,
            ghostClass: 'widget-ghost',
            onEnd: function(evt) {
                // Atualizar posições dos widgets
                atualizarPosicoesWidgets();
            }
        });

        // Carregar dados dos widgets
        function carregarWidgets() {
            const widgets = document.querySelectorAll('.widget');
            widgets.forEach(widget => {
                const widgetId = widget.dataset.widgetId;
                if (widgetId) {
                    carregarDadosWidget(widgetId);
                }
            });
        }

        // Carregar dados de um widget específico
        function carregarDadosWidget(widgetId) {
            fetch(`api/widget_data.php?id=${widgetId}`)
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById(`widget-${widgetId}`);
                    if (container) {
                        container.innerHTML = renderizarWidget(data);
                    }
                })
                .catch(error => {
                    console.error('Erro ao carregar widget:', error);
                });
        }

        // Renderizar conteúdo do widget
        function renderizarWidget(data) {
            switch (data.tipo) {
                case 'indicador_numerico':
                    return `
                        <div class="indicator-card">
                            <div class="indicator-value">${data.valor}</div>
                            <div class="indicator-unit">${data.unidade}</div>
                            <div class="indicator-title">${data.titulo}</div>
                        </div>
                    `;
                
                case 'grafico_linha':
                case 'grafico_barras':
                case 'grafico_pizza':
                    return `<canvas id="chart-${data.id}"></canvas>`;
                
                case 'tabela':
                    return renderizarTabela(data.dados);
                
                case 'gauge':
                    return renderizarGauge(data);
                
                case 'alertas':
                    return renderizarAlertas(data.alertas);
                
                default:
                    return '<p>Widget não suportado</p>';
            }
        }

        // Adicionar widget
        function adicionarWidget(tipo) {
            document.getElementById('tipo_widget').value = tipo;
            document.getElementById('titulo_widget').value = '';
            carregarConfiguracoesWidget(tipo);
            new bootstrap.Modal(document.getElementById('modalAddWidget')).show();
        }

        // Carregar configurações específicas do widget
        function carregarConfiguracoesWidget(tipo) {
            const container = document.getElementById('configuracoes_widget');
            const tipos = <?php echo json_encode($tipos_widgets); ?>;
            const config = tipos[tipo]?.configuracoes || {};
            
            let html = '<h6 class="mt-3 mb-3">Configurações</h6>';
            
            Object.entries(config).forEach(([key, config_item]) => {
                html += `
                    <div class="mb-3">
                        <label class="form-label">${key.charAt(0).toUpperCase() + key.slice(1)}</label>
                        ${renderizarCampoConfiguracao(key, config_item)}
                    </div>
                `;
            });
            
            container.innerHTML = html;
        }

        // Renderizar campo de configuração
        function renderizarCampoConfiguracao(key, config) {
            switch (config.tipo) {
                case 'select':
                    return `
                        <select class="form-select" name="config_${key}">
                            ${config.opcoes.map(opcao => `<option value="${opcao}">${opcao}</option>`).join('')}
                        </select>
                    `;
                
                case 'text':
                    return `<input type="text" class="form-control" name="config_${key}" value="${config.padrao || ''}">`;
                
                case 'number':
                    return `<input type="number" class="form-control" name="config_${key}" value="${config.padrao || 0}">`;
                
                case 'color':
                    return `<input type="color" class="form-control" name="config_${key}" value="${config.padrao || '#0d6efd'}">`;
                
                case 'boolean':
                    return `
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="config_${key}" ${config.padrao ? 'checked' : ''}>
                            <label class="form-check-label">Ativo</label>
                        </div>
                    `;
                
                default:
                    return `<input type="text" class="form-control" name="config_${key}">`;
            }
        }

        // Salvar widget
        function salvarWidget() {
            const form = document.getElementById('formAddWidget');
            const formData = new FormData(form);
            
            fetch('api/salvar_widget.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erro ao salvar widget: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao salvar widget');
            });
        }

        // Aplicar template
        function aplicarTemplate(categoria) {
            if (confirm('Isso irá substituir todos os widgets atuais. Continuar?')) {
                fetch('api/aplicar_template.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ categoria: categoria })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erro ao aplicar template: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao aplicar template');
                });
            }
        }

        // Carregar widgets ao iniciar
        document.addEventListener('DOMContentLoaded', function() {
            carregarWidgets();
        });
    </script>
</body>
</html> 