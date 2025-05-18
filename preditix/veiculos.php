<?php
require_once 'includes/auth.php';
require_once 'classes/Veiculo.php';

Auth::checkAuth();

$veiculo = new Veiculo();

// Processar exclusão
if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $veiculo->excluir($id);
    header('Location: veiculos.php');
    exit();
}

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
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Tag</th>
                            <th>Tipo</th>
                            <th>Placa</th>
                            <th>Fabricante</th>
                            <th>Modelo</th>
                            <th>Ano</th>
                            <th>Proprietário</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($veiculos as $v): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($v['tag']); ?></td>
                                <td><?php echo htmlspecialchars($v['tipo']); ?></td>
                                <td><?php echo htmlspecialchars($v['placa']); ?></td>
                                <td><?php echo htmlspecialchars($v['fabricante']); ?></td>
                                <td><?php echo htmlspecialchars($v['modelo']); ?></td>
                                <td><?php echo htmlspecialchars($v['ano_fabricacao']); ?></td>
                                <td><?php echo htmlspecialchars($v['proprietario']); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $v['status'] === 'ativo' ? 'success' : ($v['status'] === 'inativo' ? 'danger' : 'warning'); ?>">
                                        <?php echo ucfirst($v['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="detalhes_veiculo.php?id=<?php echo $v['id']; ?>" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="form_veiculo.php?id=<?php echo $v['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="veiculos.php?excluir=<?php echo $v['id']; ?>" class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Tem certeza que deseja excluir este ativo?')">
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

<?php require_once 'includes/footer.php'; ?>
