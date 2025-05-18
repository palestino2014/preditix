<?php
require_once 'includes/auth.php';
// require_once 'includes/header.php';
require_once 'classes/Embarcacao.php';

Auth::checkAuth();

$embarcacao = new Embarcacao();

if (isset($_GET['excluir'])) {
    $id = $_GET['excluir'];
    $embarcacao->excluir($id);
    header('Location: embarcacoes.php');
    exit();
}

include 'includes/header.php';

$embarcacoes = $embarcacao->listar();
?>

<div class="container">    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Embarcações</h1>
        <a href="form_embarcacao.php" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nova Embarcação
        </a>

    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Inscrição</th>
                            <th>Tipo</th>
                            <th>Tag</th>
                            <th>Ano</th>
                            <th>Capacidade</th>
                            <th>Armador</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($embarcacoes as $e): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($e['nome'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($e['inscricao'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($e['tipo'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($e['tag'] ?? ''); ?></td>
                                <td><?php echo htmlspecialchars($e['ano_fabricacao'] ?? ''); ?></td>
                                <td><?php echo number_format($e['capacidade_volumetrica'] ?? 0, 2); ?> m³</td>
                                <td><?php echo htmlspecialchars($e['armador'] ?? ''); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $e['status'] === 'ativo' ? 'success' : ($e['status'] === 'inativo' ? 'danger' : 'warning'); ?>">
                                        <?php echo ucfirst($e['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="detalhes_embarcacao.php?id=<?php echo $e['id']; ?>" class="btn btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="form_embarcacao.php?id=<?php echo $e['id']; ?>" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="ordens_servico/os.php?tipo=embarcacao&id=<?php echo $e['id']; ?>" class="btn btn-sm btn-success" title="Nova OS">
                                        <i class="bi bi-clipboard-plus"></i>
                                    </a>
                                    <a href="embarcacoes.php?excluir=<?php echo $e['id']; ?>" class="btn btn-danger btn-sm" 
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
