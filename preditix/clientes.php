<?php
require_once 'includes/auth.php';
require_once 'classes/Cliente.php';

Auth::checkAuth();

$cliente = new Cliente();
$titulo = 'Executores';

include 'includes/header.php';

$clientes = $cliente->listar();
?>

<div class="container">    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?php echo $titulo; ?></h1>
        <a href="form_cliente.php" class="btn btn-primary">
            <i class="bi bi-plus"></i> Novo Executor
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>Data Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($c['nome']); ?></td>
                                <td><?php echo htmlspecialchars($c['cnpj'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($c['telefone'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($c['email'] ?? '-'); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($c['data_criacao'])); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="form_cliente.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="detalhes_cliente.php?id=<?php echo $c['id']; ?>" class="btn btn-sm btn-info" title="Visualizar">
                                            <i class="bi bi-eye"></i>
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
