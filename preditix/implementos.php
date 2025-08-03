<?php
require_once 'includes/auth.php';
require_once 'classes/Implemento.php';

Auth::checkAuth();

$implemento = new Implemento();

// Incluir o header apenas após todo o processamento
include 'includes/header.php';

$implementos = $implemento->listar();
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Implementos</h1>
        <a href="form_implemento.php" class="btn btn-primary">
            <i class="bi bi-plus"></i> Novo Implemento
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
                        <?php foreach ($implementos as $i): ?>
                            <tr>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($i['tag'] ?? ''); ?>"><?php echo htmlspecialchars($i['tag'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($i['placa'] ?? ''); ?>"><?php echo htmlspecialchars($i['placa'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($i['fabricante'] ?? ''); ?>"><?php echo htmlspecialchars($i['fabricante'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($i['modelo'] ?? ''); ?>"><?php echo htmlspecialchars($i['modelo'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($i['ano_fabricacao'] ?? ''); ?>"><?php echo htmlspecialchars($i['ano_fabricacao'] ?? ''); ?></td>
                                <td class="table-cell-number"><?php echo number_format($i['capacidade_volumetrica'] ?? 0, 2); ?> m³</td>
                                <td class="table-cell-status">
                                    <span class="badge bg-<?php echo $i['status'] === 'ativo' ? 'success' : ($i['status'] === 'inativo' ? 'danger' : 'warning'); ?>">
                                        <?php echo ucfirst($i['status'] ?? ''); ?>
                                    </span>
                                </td>
                                <td class="table-cell-actions">
                                    <div class="btn-group">
                                        <a href="detalhes_implemento.php?id=<?php echo $i['id']; ?>" class="btn btn-sm" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="form_implemento.php?id=<?php echo $i['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="ordens_servico/os.php?tipo=implemento&id_equipamento=<?php echo $i['id']; ?>" class="btn btn-sm btn-success" title="Nova OS">
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
