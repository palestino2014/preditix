<?php
require_once '../includes/auth.php';
Auth::checkAuth();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Disponibilidade</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
    .card-body {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 200px;
    }
    .card-body canvas {
        max-width: 100% !important;
        max-height: 250px !important;
    }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>
<div class="container-fluid mt-4">
    <div class="row mb-4">
        <div class="col-12 d-flex align-items-center justify-content-between">
            <h2><i class="bi bi-bar-chart-line me-2 text-success"></i> Disponibilidade Atual</h2>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Embarcação</div>
                <div class="card-body"><canvas id="pizzaEmbarcacao"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Implemento</div>
                <div class="card-body"><canvas id="pizzaImplemento"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Tanque</div>
                <div class="card-body"><canvas id="pizzaTanque"></canvas></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Veículo</div>
                <div class="card-body"><canvas id="pizzaVeiculo"></canvas></div>
            </div>
        </div>
    </div>
</div>
<script>
async function buscarDisponibilidade(tipo) {
    const resp = await fetch(`api_dashboard.php?metrica=disponibilidade&tipo_ativo=${tipo}`);
    return await resp.json();
}
function renderPizza(ctx, data, titulo) {
    return new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Ativo', 'Manutenção', 'Inativo'],
            datasets: [{
                data: [data.ativo, data.manutencao, data.inativo],
                backgroundColor: ['#198754', '#fd7e14', '#6c757d'],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: { position: 'bottom' },
                title: { display: false }
            }
        }
    });
}
window.graficos = {};
(async function(){
    const tipos = [
        {tipo: 'embarcacao', id: 'pizzaEmbarcacao'},
        {tipo: 'implemento', id: 'pizzaImplemento'},
        {tipo: 'tanque', id: 'pizzaTanque'},
        {tipo: 'veiculo', id: 'pizzaVeiculo'}
    ];
    for (const t of tipos) {
        const data = await buscarDisponibilidade(t.tipo);
        const ctx = document.getElementById(t.id).getContext('2d');
        if (window.graficos[t.id]) window.graficos[t.id].destroy();
        window.graficos[t.id] = renderPizza(ctx, data, t.tipo);
    }
})();
</script>
</body>
</html> 