<?php
require_once '../includes/auth.php';
require_once '../classes/Tanque.php';
Auth::checkAuth();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Tanques</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2><i class="bi bi-droplet me-2 text-info"></i> Tanques</h2>
            <div class="d-flex align-items-center gap-3">
                <select class="form-select" id="tanque_id" style="width: 200px;">
                    <option value="">Todos</option>
                    <?php
                    $tanque = new Tanque();
                    $tanques = $tanque->listar();
                    foreach ($tanques as $tanque) {
                        echo "<option value='{$tanque['id']}'>{$tanque['tag']} - {$tanque['localizacao']}</option>";
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
                <div class="card-header">
                    <span>MTTR</span>
                </div>
                <div class="card-body text-center">
                    <div class="display-4 text-primary mb-2" id="valorMTTR">-</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span>MTBF</span>
                </div>
                <div class="card-body text-center">
                    <div class="display-4 text-success mb-2" id="valorMTBF">-</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Custo</div>
                <div class="card-body"><canvas id="graficoCusto"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Taxa de Falhas</div>
                <div class="card-body"><canvas id="graficoTaxaFalhas"></canvas></div>
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
async function atualizarGraficos(inicio, fim, tanqueId = '') {
    // Atualizar cards de MTTR e MTBF
    await atualizarCardsMTTRMTBF(tanqueId);
    
    // Atualizar gráficos de Custo e Taxa de Falhas
    const metricasGraficos = [
        {metrica: 'custo', id: 'graficoCusto', cor: '#fd7e14', titulo: 'Custo - Tanque'},
        {metrica: 'taxa_falhas', id: 'graficoTaxaFalhas', cor: '#dc3545', titulo: 'Taxa de Falhas - Tanque'}
    ];
    
    window.graficos = window.graficos || {};
    
    for (const m of metricasGraficos) {
        let url = `api_dashboard.php?metrica=${m.metrica}&tipo_ativo=tanque&inicio=${inicio}&fim=${fim}`;
        if (tanqueId) {
            url += `&equipamento_id=${tanqueId}`;
        }
        
        console.log(`Fazendo requisição para: ${url}`);
        const resp = await fetch(url, {
            credentials: 'same-origin'
        });
        
        if (!resp.ok) {
            console.error(`Erro HTTP ${resp.status} para ${m.metrica}`);
            return;
        }
        
        const text = await resp.text();
        console.log(`Resposta bruta para ${m.metrica}:`, text);
        
        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error(`Erro ao fazer parse do JSON para ${m.metrica}:`, e);
            console.error('Texto recebido:', text);
            return;
        }
        
        console.log(`Resposta para ${m.metrica}:`, data);
        
        if (window.graficos[m.id]) window.graficos[m.id].destroy();
        const ctx = document.getElementById(m.id).getContext('2d');
        
        const unidade = m.metrica === 'custo' ? 'R$' : 'Falhas';
        window.graficos[m.id] = renderGrafico(ctx, data.labels, data.valores, m.titulo, m.cor, unidade);
    }
}

async function atualizarCardsMTTRMTBF(tanqueId = '') {
    // Atualizar MTTR
    let url = `api_dashboard.php?metrica=mttr&tipo_ativo=tanque`;
    if (tanqueId) {
        url += `&equipamento_id=${tanqueId}`;
    }
    
    try {
        const resp = await fetch(url, { credentials: 'same-origin' });
        const data = await resp.json();
        
        document.getElementById('valorMTTR').textContent = data.valor_atual + ' horas';
        
    } catch (e) {
        console.error('Erro ao carregar MTTR:', e);
        document.getElementById('valorMTTR').textContent = 'Erro';
    }
    
    // Atualizar MTBF
    url = `api_dashboard.php?metrica=mtbf&tipo_ativo=tanque`;
    if (tanqueId) {
        url += `&equipamento_id=${tanqueId}`;
    }
    
    try {
        const resp = await fetch(url, { credentials: 'same-origin' });
        const data = await resp.json();
        
        document.getElementById('valorMTBF').textContent = data.valor_atual + ' horas';
        
    } catch (e) {
        console.error('Erro ao carregar MTBF:', e);
        document.getElementById('valorMTBF').textContent = 'Erro';
    }
}

function getTendenciaTexto(tendencia) {
    switch(tendencia) {
        case 'melhorando': return '↗️ Melhorando';
        case 'piorando': return '↘️ Piorando';
        default: return '→ Estável';
    }
}

function getTendenciaClasse(tendencia, tipo) {
    switch(tendencia) {
        case 'melhorando': 
            return tipo === 'mttr' ? 'bg-danger' : 'bg-success'; // MTTR menor = melhor, MTBF maior = melhor
        case 'piorando': 
            return tipo === 'mttr' ? 'bg-success' : 'bg-danger'; // MTTR maior = pior, MTBF menor = pior
        default: 
            return 'bg-secondary';
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
    const tanqueId = document.getElementById('tanque_id').value;
    atualizarGraficos(inicio, fim, tanqueId);
});

document.getElementById('tanque_id').addEventListener('change', function() {
    const inicio = document.getElementById('periodo_inicio').value;
    const fim = document.getElementById('periodo_fim').value;
    const tanqueId = this.value;
    atualizarGraficos(inicio, fim, tanqueId);
});
</script>
</body>
</html>
