<?php
require_once '../includes/auth.php';
require_once '../classes/Embarcacao.php';
Auth::checkAuth();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Embarcações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2><i class="bi bi-arrow-repeat me-2 text-primary"></i> Embarcações</h2>
            <div class="d-flex align-items-center gap-3">
                <select class="form-select" id="embarcacao_id" style="width: 200px;">
                    <option value="">Todos</option>
                    <?php
                    $embarcacao = new Embarcacao();
                    $embarcacoes = $embarcacao->listar();
                    foreach ($embarcacoes as $embarcacao) {
                        echo "<option value='{$embarcacao['id']}'>{$embarcacao['nome']}</option>";
                    }
                    ?>
                </select>
                <form class="d-flex align-items-center gap-2" id="formPeriodo">
                    <label for="periodo_inicio" class="mb-0">Período:</label>
                    <input type="month" id="periodo_inicio" name="inicio" class="form-control" required>
                    <span class="mx-1">a</span>
                    <input type="month" id="periodo_fim" name="fim" class="form-control" required>
                    <button type="submit" class="btn btn-primary">Aplicar</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">MTTR - Embarcação</div>
                <div class="card-body"><canvas id="graficoMTTR"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">MTBF - Embarcação</div>
                <div class="card-body"><canvas id="graficoMTBF"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Custo - Embarcação</div>
                <div class="card-body"><canvas id="graficoCusto"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Disponibilidade - Embarcação</div>
                <div class="card-body"><canvas id="graficoDisponibilidade"></canvas></div>
            </div>
        </div>
    </div>
</div>
<script>
function getDefaultPeriod() {
    // Usar período onde há dados reais (2025-07 a 2025-08)
    const inicio = '2025-07';
    const fim = '2025-08';
    return {inicio, fim};
}
function renderGrafico(ctx, labels, valores, titulo, cor, unidade = 'Horas') {
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: titulo,
                data: valores,
                borderColor: cor,
                backgroundColor: cor + '33',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (unidade === 'R$') {
                                return context.dataset.label + ': R$ ' + Number(context.parsed.y).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            } else {
                                return context.dataset.label + ': ' + Number(context.parsed.y).toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2}) + ' ' + unidade.toLowerCase();
                            }
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    title: { display: true, text: unidade === 'R$' ? 'Valor (R$)' : unidade },
                    ticks: {
                        callback: function(value) {
                            if (unidade === 'R$') {
                                return 'R$ ' + value.toLocaleString('pt-BR', {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                            return value;
                        }
                    }
                }
            }
        }
    });
}

function renderGraficoMultiplo(ctx, labels, series, titulo) {
    const datasets = series.map(s => ({
        label: s.label,
        data: s.data,
        borderColor: s.cor,
        backgroundColor: s.cor + '33',
        fill: false,
        tension: 0.3
    }));
    
    return new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            plugins: {
                legend: { 
                    position: 'top',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                },
                title: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + ' equipamentos';
                        }
                    }
                }
            },
            scales: {
                y: { 
                    beginAtZero: true, 
                    title: { display: true, text: 'Quantidade' } 
                }
            }
        }
    });
}
async function atualizarGraficos(inicio, fim, embarcacaoId = '') {
    const metricas = [
        {metrica: 'mttr', id: 'graficoMTTR', cor: '#198754', titulo: 'MTTR - Embarcação'},
        {metrica: 'mtbf', id: 'graficoMTBF', cor: '#0d6efd', titulo: 'MTBF - Embarcação'},
        {metrica: 'custo', id: 'graficoCusto', cor: '#fd7e14', titulo: 'Custo - Embarcação'},
        {metrica: 'disponibilidade', id: 'graficoDisponibilidade', cor: '#6f42c1', titulo: 'Disponibilidade - Embarcação'}
    ];
    
    window.graficos = window.graficos || {};
    
    for (const m of metricas) {
        let url = `api_dashboard.php?metrica=${m.metrica}&tipo_ativo=embarcacao&inicio=${inicio}&fim=${fim}`;
        if (embarcacaoId) {
            url += `&equipamento_id=${embarcacaoId}`;
        }
        
        console.log(`Fazendo requisição para: ${url}`);
        const resp = await fetch(url);
        const data = await resp.json();
        console.log(`Resposta para ${m.metrica}:`, data);
        
        if (window.graficos[m.id]) window.graficos[m.id].destroy();
        const ctx = document.getElementById(m.id).getContext('2d');
        
        // Tratar formato diferente para disponibilidade
        if (m.metrica === 'disponibilidade') {
            // Para disponibilidade, criar gráfico de linha com múltiplas séries
            const labels = data.labels;
            const ativo = data.valores.map(v => v.ativo || 0);
            const manutencao = data.valores.map(v => v.manutencao || 0);
            const inativo = data.valores.map(v => v.inativo || 0);
            
            window.graficos[m.id] = renderGraficoMultiplo(ctx, labels, [
                {label: 'Ativo', data: ativo, cor: '#198754'},
                {label: 'Manutenção', data: manutencao, cor: '#fd7e14'},
                {label: 'Inativo', data: inativo, cor: '#dc3545'}
            ], m.titulo);
        } else {
            // Para outras métricas, usar gráfico de linha
            const unidade = m.metrica === 'custo' ? 'R$' : 'Horas';
            window.graficos[m.id] = renderGrafico(ctx, data.labels, data.valores, m.titulo, m.cor, unidade);
        }
    }
}
const periodo = getDefaultPeriod();
document.getElementById('periodo_inicio').value = periodo.inicio;
document.getElementById('periodo_fim').value = periodo.fim;
atualizarGraficos(periodo.inicio, periodo.fim);

document.getElementById('formPeriodo').addEventListener('submit', function(e) {
    e.preventDefault();
    const inicio = document.getElementById('periodo_inicio').value;
    const fim = document.getElementById('periodo_fim').value;
    const embarcacaoId = document.getElementById('embarcacao_id').value;
    atualizarGraficos(inicio, fim, embarcacaoId);
});

document.getElementById('embarcacao_id').addEventListener('change', function() {
    const inicio = document.getElementById('periodo_inicio').value;
    const fim = document.getElementById('periodo_fim').value;
    const embarcacaoId = this.value;
    atualizarGraficos(inicio, fim, embarcacaoId);
});
</script>
</body>
</html> 