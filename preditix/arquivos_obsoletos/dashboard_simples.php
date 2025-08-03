<?php
require_once '../includes/auth.php';
require_once 'classes/BibliotecaGraficos.php';

Auth::checkAuth();

$biblioteca = new BibliotecaGraficos();
$graficos_categorias = $biblioteca->listarPorCategoria();
$graficos_favoritos = $biblioteca->listarFavoritos($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Preditix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
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
        
        .graficos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }
        
        .grafico-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            position: relative;
            cursor: move;
            min-height: 300px;
            display: flex;
            flex-direction: column;
        }
        
        .grafico-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }
        
        .grafico-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            flex-shrink: 0;
        }
        
        .grafico-title {
            font-weight: 600;
            color: #333;
            margin: 0;
            font-size: 1.1em;
        }
        
        .grafico-controls {
            display: flex;
            gap: 5px;
        }
        
        .grafico-control-btn {
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
            padding: 5px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .grafico-control-btn:hover {
            background: rgba(0, 0, 0, 0.1);
            color: #333;
        }
        
        .grafico-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 200px;
        }
        
        .sidebar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            height: fit-content;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .categoria-section {
            margin-bottom: 25px;
        }
        
        .categoria-title {
            font-size: 1.1em;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #667eea;
        }
        
        .grafico-item {
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .grafico-item:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateX(5px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .grafico-item.favorito {
            background: rgba(102, 126, 234, 0.1);
            border-color: #667eea;
        }
        
        .grafico-icon {
            font-size: 1.2em;
            color: #667eea;
            width: 20px;
        }
        
        .grafico-info {
            flex: 1;
        }
        
        .grafico-name {
            font-weight: 500;
            color: #333;
            margin: 0;
            font-size: 0.9em;
        }
        
        .grafico-desc {
            font-size: 0.8em;
            color: #666;
            margin: 0;
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
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .empty-state i {
            font-size: 4em;
            margin-bottom: 20px;
            opacity: 0.5;
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
        
        .gauge-container {
            text-align: center;
            padding: 20px;
        }
        
        .gauge-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 15px;
            position: relative;
            background: conic-gradient(var(--gauge-color) 0deg, #e9ecef 0deg);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .gauge-inner {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            font-weight: bold;
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
                    <h2 class="mb-0">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard
                    </h2>
                    <p class="text-muted mb-0">Visualize os indicadores mais importantes do seu sistema</p>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-custom" onclick="salvarPosicoes()">
                        <i class="bi bi-save me-2"></i>Salvar Layout
                    </button>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar com Biblioteca de Gráficos -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h5 class="mb-3">
                        <i class="bi bi-collection me-2"></i>
                        Biblioteca de Gráficos
                    </h5>
                    
                    <?php foreach ($graficos_categorias as $categoria => $graficos): ?>
                        <div class="categoria-section">
                            <h6 class="categoria-title">
                                <?php echo ucfirst($categoria); ?>
                            </h6>
                            <?php foreach ($graficos as $grafico): ?>
                                <?php 
                                $is_favorito = false;
                                foreach ($graficos_favoritos as $favorito) {
                                    if ($favorito['grafico_id'] == $grafico['id']) {
                                        $is_favorito = true;
                                        break;
                                    }
                                }
                                ?>
                                <div class="grafico-item <?php echo $is_favorito ? 'favorito' : ''; ?>" 
                                     onclick="adicionarGrafico(<?php echo $grafico['id']; ?>)">
                                    <i class="bi <?php echo $grafico['icone']; ?> grafico-icon"></i>
                                    <div class="grafico-info">
                                        <div class="grafico-name"><?php echo $grafico['nome']; ?></div>
                                        <div class="grafico-desc"><?php echo $grafico['descricao']; ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Área principal do dashboard -->
            <div class="col-md-9">
                <div class="graficos-grid" id="dashboardGrid">
                    <?php if (empty($graficos_favoritos)): ?>
                        <div class="empty-state">
                            <i class="bi bi-graph-up"></i>
                            <h4>Seu dashboard está vazio</h4>
                            <p>Clique nos gráficos da biblioteca para adicioná-los ao seu dashboard</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($graficos_favoritos as $favorito): ?>
                            <div class="grafico-card" 
                                 data-id="<?php echo $favorito['id']; ?>"
                                 data-grafico-id="<?php echo $favorito['grafico_id']; ?>">
                                <div class="grafico-header">
                                    <h6 class="grafico-title"><?php echo $favorito['nome']; ?></h6>
                                    <div class="grafico-controls">
                                        <button class="grafico-control-btn" onclick="removerGrafico(<?php echo $favorito['id']; ?>)">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="grafico-content" id="grafico-<?php echo $favorito['id']; ?>">
                                    <div class="text-center py-4">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Carregando...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    
    <script>
        // Inicializar drag and drop
        new Sortable(document.getElementById('dashboardGrid'), {
            animation: 150,
            ghostClass: 'sortable-ghost',
            onEnd: function(evt) {
                // Atualizar posições após arrastar
                atualizarPosicoes();
            }
        });

        // Carregar dados dos gráficos
        function carregarGraficos() {
            console.log('Iniciando carregamento dos gráficos');
            const graficos = document.querySelectorAll('.grafico-card');
            console.log('Gráficos encontrados:', graficos.length);
            
            graficos.forEach(grafico => {
                const id = grafico.dataset.id;
                console.log('Carregando gráfico com ID:', id);
                carregarDadosGrafico(id);
            });
        }

        // Carregar dados de um gráfico específico
        function carregarDadosGrafico(id) {
            console.log('Carregando dados do gráfico:', id);
            fetch(`api/grafico_data.php?id=${id}`)
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Dados recebidos:', data);
                    if (data.error) {
                        console.error('Erro:', data.error);
                        return;
                    }
                    renderizarGrafico(id, data);
                })
                .catch(error => {
                    console.error('Erro ao carregar dados:', error);
                });
        }

        // Renderizar gráfico baseado no tipo
        function renderizarGrafico(id, dados) {
            console.log('Renderizando gráfico:', id, 'Tipo:', dados.tipo);
            const container = document.getElementById(`grafico-${id}`);
            
            if (!container) {
                console.error('Container não encontrado para o gráfico:', id);
                return;
            }
            
            // Verificar se Chart.js está carregado
            if (typeof Chart === 'undefined') {
                console.error('Chart.js não está carregado. Aguardando...');
                container.innerHTML = '<div class="text-center text-muted">Carregando gráfico...</div>';
                setTimeout(() => renderizarGrafico(id, dados), 100);
                return;
            }
            
            switch (dados.tipo) {
                case 'indicador':
                    renderizarIndicador(container, dados);
                    break;
                case 'linha':
                    renderizarGraficoLinha(container, dados);
                    break;
                case 'barras':
                    renderizarGraficoBarras(container, dados);
                    break;
                case 'pizza':
                    renderizarGraficoPizza(container, dados);
                    break;
                case 'tabela':
                    renderizarTabela(container, dados);
                    break;
                case 'gauge':
                    renderizarGauge(container, dados);
                    break;
                default:
                    console.error('Tipo de gráfico não reconhecido:', dados.tipo);
                    container.innerHTML = '<div class="text-center text-muted">Tipo de gráfico não suportado</div>';
            }
        }

        // Renderizar indicador numérico
        function renderizarIndicador(container, dados) {
            container.innerHTML = `
                <div class="indicator-card">
                    <div class="indicator-value" style="color: ${dados.cor}">${dados.valor}</div>
                    <div class="indicator-unit">${dados.unidade}</div>
                    <div class="indicator-title">${dados.titulo}</div>
                    ${dados.subtitulo ? `<small class="text-muted">${dados.subtitulo}</small>` : ''}
                </div>
            `;
        }

        // Renderizar gráfico de linha
        function renderizarGraficoLinha(container, dados) {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js não está carregado');
                container.innerHTML = '<div class="text-center text-muted">Erro: Chart.js não carregado</div>';
                return;
            }
            
            container.innerHTML = '<canvas></canvas>';
            const ctx = container.querySelector('canvas').getContext('2d');
            
            new Chart(ctx, {
                type: 'line',
                data: dados,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    },
                    elements: {
                        point: {
                            radius: 4,
                            hoverRadius: 6
                        }
                    }
                }
            });
        }

        // Renderizar gráfico de barras
        function renderizarGraficoBarras(container, dados) {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js não está carregado');
                container.innerHTML = '<div class="text-center text-muted">Erro: Chart.js não carregado</div>';
                return;
            }
            
            container.innerHTML = '<canvas></canvas>';
            const ctx = container.querySelector('canvas').getContext('2d');
            
            new Chart(ctx, {
                type: 'bar',
                data: dados,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        }

        // Renderizar gráfico de pizza
        function renderizarGraficoPizza(container, dados) {
            if (typeof Chart === 'undefined') {
                console.error('Chart.js não está carregado');
                container.innerHTML = '<div class="text-center text-muted">Erro: Chart.js não carregado</div>';
                return;
            }
            
            container.innerHTML = '<canvas></canvas>';
            const ctx = container.querySelector('canvas').getContext('2d');
            
            new Chart(ctx, {
                type: 'pie',
                data: dados,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        }

        // Renderizar tabela
        function renderizarTabela(container, dados) {
            let html = '<div class="table-responsive" style="max-height: 250px; overflow-y: auto;">';
            html += '<table class="table table-sm table-hover">';
            
            // Cabeçalho
            html += '<thead class="table-light sticky-top">';
            html += '<tr>';
            dados.colunas.forEach(coluna => {
                html += `<th class="text-nowrap">${coluna}</th>`;
            });
            html += '</tr></thead>';
            
            // Dados
            html += '<tbody>';
            dados.dados.forEach(linha => {
                html += '<tr>';
                linha.forEach(celula => {
                    html += `<td class="text-nowrap">${celula}</td>`;
                });
                html += '</tr>';
            });
            html += '</tbody></table></div>';
            
            container.innerHTML = html;
        }

        // Renderizar gauge
        function renderizarGauge(container, dados) {
            const porcentagem = (dados.valor / dados.maximo) * 100;
            const cor = dados.cor;
            
            container.innerHTML = `
                <div class="gauge-container">
                    <div class="gauge-circle" style="--gauge-color: ${cor}; background: conic-gradient(${cor} 0deg ${porcentagem * 3.6}deg, #e9ecef ${porcentagem * 3.6}deg 360deg);">
                        <div class="gauge-inner">
                            ${dados.valor}%
                        </div>
                    </div>
                    <div class="indicator-title">${dados.titulo}</div>
                    ${dados.subtitulo ? `<small class="text-muted">${dados.subtitulo}</small>` : ''}
                </div>
            `;
        }

        // Adicionar gráfico aos favoritos
        function adicionarGrafico(graficoId) {
            fetch('api/adicionar_favorito.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    grafico_id: graficoId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Erro ao adicionar gráfico: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao adicionar gráfico');
            });
        }

        // Remover gráfico dos favoritos
        function removerGrafico(id) {
            if (confirm('Tem certeza que deseja remover este gráfico?')) {
                fetch('api/remover_favorito.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        id: id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erro ao remover gráfico: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao remover gráfico');
                });
            }
        }

        // Atualizar posições dos gráficos
        function atualizarPosicoes() {
            const graficos = [];
            const grid = document.getElementById('dashboardGrid');
            const items = grid.querySelectorAll('.grafico-card');
            
            items.forEach((item, index) => {
                const rect = item.getBoundingClientRect();
                const gridRect = grid.getBoundingClientRect();
                
                graficos.push({
                    id: item.dataset.id,
                    posicao_x: Math.floor((rect.left - gridRect.left) / (gridRect.width / 12)),
                    posicao_y: Math.floor((rect.top - gridRect.top) / 150),
                    largura: parseInt(item.style.gridColumnEnd) - parseInt(item.style.gridColumnStart) || 1,
                    altura: parseInt(item.style.gridRowEnd) - parseInt(item.style.gridRowStart) || 1
                });
            });

            fetch('api/atualizar_posicoes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    graficos: graficos
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Erro ao salvar posições:', data.error);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
            });
        }

        // Salvar posições
        function salvarPosicoes() {
            atualizarPosicoes();
            alert('Layout salvo com sucesso!');
        }

        // Carregar gráficos ao iniciar
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Página carregada, verificando Chart.js...');
            
            // Verificar se Chart.js está carregado
            function verificarChartJS() {
                if (typeof Chart !== 'undefined') {
                    console.log('Chart.js carregado com sucesso');
                    carregarGraficos();
                } else {
                    console.log('Chart.js ainda não carregado, aguardando...');
                    setTimeout(verificarChartJS, 100);
                }
            }
            
            verificarChartJS();
        });

        // Fallback para Chart.js caso o CDN principal falhe
        if (typeof Chart === 'undefined') {
            console.log('Tentando carregar Chart.js do CDN alternativo...');
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js';
            script.onload = function() {
                console.log('Chart.js carregado do CDN alternativo');
            };
            script.onerror = function() {
                console.error('Falha ao carregar Chart.js de ambos os CDNs');
            };
            document.head.appendChild(script);
        }
    </script>
</body>
</html> 