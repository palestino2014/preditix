<?php
require_once 'includes/auth.php';
require_once 'classes/Tanque.php';

Auth::checkAuth();

$tanque = new Tanque();

// Processar exclusão
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $tanque->excluir($id);
    header('Location: tanques.php');
    exit();
}

// Incluir o header apenas após todo o processamento
include 'includes/header.php';

$tanques = $tanque->listar();
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Tanques</h1>
        <a href="form_tanque.php" class="btn btn-primary">
            <i class="bi bi-plus"></i> Novo Tanque
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-ativos">
                    <thead>
                        <tr>
                            <th class="col-tag">Tag</th>
                            <th class="col-fabricante">Fabricante</th>
                            <th class="col-ano">Ano</th>
                            <th class="col-localizacao">Localização</th>
                            <th class="table-cell-number">Capacidade</th>
                            <th class="table-cell-status">Status</th>
                            <th class="table-cell-actions">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($tanques as $t): ?>
                            <tr>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($t['tag'] ?? ''); ?>"><?php echo htmlspecialchars($t['tag'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($t['fabricante_responsavel'] ?? ''); ?>"><?php echo htmlspecialchars($t['fabricante_responsavel'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($t['ano_fabricacao'] ?? ''); ?>"><?php echo htmlspecialchars($t['ano_fabricacao'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($t['localizacao'] ?? ''); ?>"><?php echo htmlspecialchars($t['localizacao'] ?? ''); ?></td>
                                <td class="table-cell-number"><?php echo number_format($t['capacidade_volumetrica'] ?? 0, 2); ?> m³</td>
                                <td class="table-cell-status">
                                    <span class="badge bg-<?php echo $t['status'] === 'ativo' ? 'success' : ($t['status'] === 'inativo' ? 'danger' : 'warning'); ?>">
                                        <?php echo ucfirst($t['status'] ?? ''); ?>
                                    </span>
                                </td>
                                <td class="table-cell-actions">
                                    <div class="btn-group">
                                        <a href="detalhes_tanque.php?id=<?php echo $t['id']; ?>" class="btn btn-sm" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="form_tanque.php?id=<?php echo $t['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="ordens_servico/os.php?tipo=tanque&id_equipamento=<?php echo $t['id']; ?>" class="btn btn-sm btn-success" title="Nova OS">
                                            <i class="bi bi-clipboard-plus"></i>
                                        </a>
                                        <a href="tanques.php?excluir=<?php echo $t['id']; ?>" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Tem certeza que deseja excluir este ativo?')" title="Excluir">
                                            <i class="bi bi-trash"></i>
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

