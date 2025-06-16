<?php
require_once '../includes/auth.php';
Auth::checkAuth();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - MTTR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2><i class="bi bi-arrow-repeat me-2 text-primary"></i> MTTR</h2>
            <form class="d-flex align-items-center gap-2" id="formPeriodo">
                <label for="periodo_inicio" class="mb-0">Período:</label>
                <input type="month" id="periodo_inicio" name="inicio" class="form-control" required>
                <span class="mx-1">a</span>
                <input type="month" id="periodo_fim" name="fim" class="form-control" required>
                <button type="submit" class="btn btn-primary">Aplicar</button>
            </form>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">MTTR - Embarcação</div>
                <div class="card-body"><canvas id="graficoEmbarcacao"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">MTTR - Implemento</div>
                <div class="card-body"><canvas id="graficoImplemento"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">MTTR - Tanque</div>
                <div class="card-body"><canvas id="graficoTanque"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">MTTR - Veículo</div>
                <div class="card-body"><canvas id="graficoVeiculo"></canvas></div>
            </div>
        </div>
    </div>
</div>
<script>
function getDefaultPeriod() {
    const now = new Date();
    const fim = now.toISOString().slice(0,7);
    const inicioDate = new Date(now.getFullYear(), now.getMonth() - 5, 1);
    const inicio = inicioDate.toISOString().slice(0,7);
    return {inicio, fim};
}
function renderGrafico(ctx, labels, valores, titulo, cor) {
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
                title: { display: false }
            },
            scales: {
                y: { beginAtZero: true, title: { display: true, text: 'Dias' } }
            }
        }
    });
}
async function atualizarGraficos(inicio, fim) {
    const tipos = [
        {tipo: 'embarcacao', id: 'graficoEmbarcacao', cor: '#198754', titulo: 'MTTR - Embarcação'},
        {tipo: 'implemento', id: 'graficoImplemento', cor: '#0d6efd', titulo: 'MTTR - Implemento'},
        {tipo: 'tanque', id: 'graficoTanque', cor: '#fd7e14', titulo: 'MTTR - Tanque'},
        {tipo: 'veiculo', id: 'graficoVeiculo', cor: '#6f42c1', titulo: 'MTTR - Veículo'}
    ];
    window.graficos = window.graficos || {};
    for (const t of tipos) {
        const url = `api_dashboard.php?metrica=mttr&tipo_ativo=${t.tipo}&inicio=${inicio}&fim=${fim}`;
        const resp = await fetch(url);
        const data = await resp.json();
        if (window.graficos[t.id]) window.graficos[t.id].destroy();
        const ctx = document.getElementById(t.id).getContext('2d');
        window.graficos[t.id] = renderGrafico(ctx, data.labels, data.valores, t.titulo, t.cor);
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
    atualizarGraficos(inicio, fim);
});
</script>
</body>
</html> 