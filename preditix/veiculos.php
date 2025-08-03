<?php
require_once 'includes/auth.php';
require_once 'classes/Veiculo.php';

Auth::checkAuth();

$veiculo = new Veiculo();

// Incluir o header apenas uma vez, após todo o processamento
include 'includes/header.php';

$veiculos = $veiculo->listar();
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Veículos</h1>
        <a href="form_veiculo.php" class="btn btn-primary">
            <i class="bi bi-plus"></i> Novo Veículo
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-ativos">
                    <thead>
                        <tr>
                            <th class="col-tag">Tag</th>
                            <th class="col-placa">Placa</th>
                            <th class="col-fabricante">Fabricante</th>
                            <th class="col-modelo">Modelo</th>
                            <th class="col-ano">Ano</th>
                            <th class="table-cell-number">Capacidade</th>
                            <th class="table-cell-status">Status</th>
                            <th class="table-cell-actions">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($veiculos as $v): ?>
                            <tr>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($v['tag'] ?? ''); ?>"><?php echo htmlspecialchars($v['tag'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($v['placa'] ?? ''); ?>"><?php echo htmlspecialchars($v['placa'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($v['fabricante'] ?? ''); ?>"><?php echo htmlspecialchars($v['fabricante'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($v['modelo'] ?? ''); ?>"><?php echo htmlspecialchars($v['modelo'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($v['ano_fabricacao'] ?? ''); ?>"><?php echo htmlspecialchars($v['ano_fabricacao'] ?? ''); ?></td>
                                <td class="table-cell-number"><?php echo number_format($v['capacidade_volumetrica'] ?? 0, 2); ?> m³</td>
                                <td class="table-cell-status">
                                    <span class="badge bg-<?php echo $v['status'] === 'ativo' ? 'success' : ($v['status'] === 'inativo' ? 'danger' : 'warning'); ?>">
                                        <?php echo ucfirst($v['status'] ?? ''); ?>
                                    </span>
                                </td>
                                <td class="table-cell-actions">
                                    <div class="btn-group">
                                        <a href="detalhes_veiculo.php?id=<?php echo $v['id']; ?>" class="btn btn-sm" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="form_veiculo.php?id=<?php echo $v['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="ordens_servico/os.php?tipo=veiculo&id_equipamento=<?php echo $v['id']; ?>" class="btn btn-sm btn-success" title="Nova OS">
                                            <i class="bi bi-clipboard-plus"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

