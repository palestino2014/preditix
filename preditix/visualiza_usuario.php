<?php
require_once 'includes/auth.php';
require_once 'classes/Usuario.php';

Auth::checkAuth();

$usuario = new Usuario();
$erro = null;
$dados = null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $erro = 'ID do usuário não fornecido.';
} else {
    try {
        $dados = $usuario->buscarPorId($_GET['id']);
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

$titulo = $dados ? 'Detalhes do Usuário: ' . $dados['nome'] : 'Usuário não encontrado';

function formatarNivelAcesso($nivel) {
    return in_array($nivel, ['gestor', 'admin'], true) ? 'Gestor' : 'Responsável';
}

require_once 'includes/header.php';
?>

<div class="container">
    <?php if ($erro): ?>
        <div class="alert alert-danger">
            <?php echo htmlspecialchars($erro); ?>
            <a href="usuarios.php" class="btn btn-secondary ms-2">Voltar</a>
        </div>
    <?php else: ?>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><?php echo htmlspecialchars($dados['nome']); ?></h1>
            <div>
                <a href="usuarios.php" class="btn btn-secondary">
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
                        <th class="text-center">Email</th>
                        <td><?php echo htmlspecialchars($dados['email']); ?></td>
                    </tr>
                    <tr>
                        <th class="text-center">Nível de Acesso</th>
                        <td><?php echo formatarNivelAcesso($dados['nivel_acesso']); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
