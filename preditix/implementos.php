<?php
require_once 'includes/auth.php';
require_once 'classes/Implemento.php';

Auth::checkAuth();

$implemento = new Implemento();

// Processar exclusão
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $implemento->excluir($id);
    header('Location: implementos.php');
    exit();
}

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
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Tag</th>
                            <th>Tipo</th>
                            <th>Fabricante</th>
                            <th>Modelo</th>
                            <th>Ano</th>
                            <th>Proprietário</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($implementos as $i): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($i['tag'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($i['tipo'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($i['fabricante'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($i['modelo'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($i['ano_fabricacao'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($i['proprietario'] ?? ''); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $i['status'] === 'ativo' ? 'success' : ($i['status'] === 'inativo' ? 'danger' : 'warning'); ?>">
                                        <?php echo ucfirst($i['status'] ?? ''); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="detalhes_implemento.php?id=<?php echo $i['id']; ?>" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="form_implemento.php?id=<?php echo $i['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="ordens_servico/os.php?tipo=implemento&id=<?php echo $i['id']; ?>" class="btn btn-success btn-sm" title="Nova OS">
                                        <i class="bi bi-clipboard-plus"></i>
                                    </a>
                                    <a href="implementos.php?excluir=<?php echo $i['id']; ?>" class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Tem certeza que deseja excluir este implemento?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
