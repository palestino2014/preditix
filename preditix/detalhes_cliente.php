<?php
require_once 'includes/auth.php';
require_once 'classes/Cliente.php';

Auth::checkAuth();

$cliente = new Cliente();
$dados = null;
$erro = null;

// Verifica se o ID foi fornecido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $erro = "ID do executor não fornecido.";
} else {
    try {
        $dados = $cliente->buscarPorId($_GET['id']);
        if (!$dados) {
            $erro = "Executor não encontrado.";
        }
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

$titulo = $dados ? 'Detalhes do Executor: ' . $dados['nome'] : 'Executor não encontrado';

include 'includes/header.php';
?>

<div class="container">
    <?php if ($erro): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($erro); ?>
            <a href="clientes.php" class="btn btn-secondary ms-2">Voltar</a>
        </div>
    <?php else: ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?php echo htmlspecialchars($dados['nome']); ?></h1>
            <div>
                <a href="form_cliente.php?id=<?php echo $dados['id']; ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="clientes.php" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Informações Básicas</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th class="text-center" style="width: 30%;">Nome</th>
                        <td><?php echo htmlspecialchars($dados['nome']); ?></td>
                    </tr>
                    <tr>
                        <th class="text-center">CNPJ</th>
                        <td><?php echo !empty($dados['cnpj']) ? htmlspecialchars($dados['cnpj']) : '<span class="text-muted">-</span>'; ?></td>
                    </tr>
                    <tr>
                        <th class="text-center">Telefone</th>
                        <td><?php echo !empty($dados['telefone']) ? htmlspecialchars($dados['telefone']) : '<span class="text-muted">-</span>'; ?></td>
                    </tr>
                    <tr>
                        <th class="text-center">Email</th>
                        <td><?php echo !empty($dados['email']) ? htmlspecialchars($dados['email']) : '<span class="text-muted">-</span>'; ?></td>
                    </tr>
                    <tr>
                        <th class="text-center">Endereço</th>
                        <td><?php echo !empty($dados['endereco']) ? nl2br(htmlspecialchars($dados['endereco'])) : '<span class="text-muted">-</span>'; ?></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
