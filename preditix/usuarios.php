<?php
require_once 'includes/auth.php';
require_once 'classes/Usuario.php';

Auth::checkAuth();

$usuario = new Usuario();
$usuarios = $usuario->listarDetalhado();
$titulo = 'Usuários';

function formatarNivelAcesso($nivel) {
    return in_array($nivel, ['gestor', 'admin'], true) ? 'Gestor' : 'Responsável';
}

$usuario_gestor = Auth::isGestor();

include 'includes/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?php echo $titulo; ?></h1>
        <?php if ($usuario_gestor): ?>
            <a href="form_usuario.php" class="btn btn-primary">
                <i class="bi bi-plus"></i> Novo Usuário
            </a>
        <?php endif; ?>
    </div>

    <?php if (!empty($_GET['erro'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['erro']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (!empty($_GET['sucesso'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['sucesso']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Nível de Acesso</th>
                            <th>Data Criação</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($u['nome']); ?></td>
                                <td><?php echo htmlspecialchars($u['email']); ?></td>
                                <td><?php echo formatarNivelAcesso($u['nivel_acesso']); ?></td>
                                <td><?php echo date('d/m/Y H:i', strtotime($u['data_criacao'])); ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="visualiza_usuario.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-info" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <?php if ($usuario_gestor): ?>
                                        <a href="form_usuario.php?id=<?php echo $u['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="delete_usuario.php" onsubmit="return confirm('Tem certeza que deseja excluir este usuário?');">
                                            <input type="hidden" name="id" value="<?php echo $u['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        <?php endif; ?>
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
