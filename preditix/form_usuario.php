<?php
require_once 'includes/auth.php';
require_once 'classes/Usuario.php';

Auth::checkAuth();
Auth::checkGestor();

$usuario = new Usuario();
$dados = [
    'nome' => '',
    'email' => '',
    'nivel_acesso' => 'responsavel'
];
$acao = 'cadastrar';
$titulo = 'Novo Usuário';
$erro = null;

if (isset($_GET['id'])) {
    try {
        $dados = $usuario->buscarPorId($_GET['id']);
        $acao = 'atualizar';
        $titulo = 'Editar Usuário';
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $nivel_acesso = $_POST['nivel_acesso'] ?? 'responsavel';
        $senha = $_POST['senha'] ?? '';

        if ($nome === '') {
            throw new Exception('O nome do usuário é obrigatório.');
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Informe um email válido.');
        }
        if ($acao === 'cadastrar' && trim($senha) === '') {
            throw new Exception('A senha é obrigatória para novos usuários.');
        }
        if (!in_array($nivel_acesso, ['gestor', 'responsavel', 'admin', 'usuario'], true)) {
            throw new Exception('Nível de acesso inválido.');
        }

        $dados = [
            'nome' => $nome,
            'email' => $email,
            'nivel_acesso' => $nivel_acesso,
            'senha' => $senha
        ];

        if ($_POST['action'] === 'cadastrar') {
            $usuario->cadastrar($dados);
        } else {
            $usuario->atualizar($_POST['id'], $dados);
        }

        header('Location: usuarios.php');
        exit();
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

$nivel_atual = $dados['nivel_acesso'] ?? 'responsavel';
if ($nivel_atual === 'admin') {
    $nivel_atual = 'gestor';
} elseif ($nivel_atual === 'usuario') {
    $nivel_atual = 'responsavel';
}

require_once 'includes/header.php';
?>

<div class="container">
    <h1><?php echo $titulo; ?></h1>

    <?php if ($erro): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($erro); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <div id="erro-validacao" class="alert alert-danger d-none" role="alert"></div>

    <div class="card">
        <div class="card-body">
            <form method="POST" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="<?php echo $acao; ?>">
                <?php if ($acao === 'atualizar'): ?>
                    <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome *</label>
                            <input type="text" name="nome" id="nome" class="form-control"
                                   value="<?php echo htmlspecialchars($dados['nome'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" name="email" id="email" class="form-control"
                                   value="<?php echo htmlspecialchars($dados['email'] ?? ''); ?>" required>
                            <div class="invalid-feedback">
                                Informe um email válido.
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nivel_acesso" class="form-label">Nível de Acesso *</label>
                            <select name="nivel_acesso" id="nivel_acesso" class="form-control" required>
                                <option value="gestor" <?php echo $nivel_atual === 'gestor' ? 'selected' : ''; ?>>Gestor</option>
                                <option value="responsavel" <?php echo $nivel_atual === 'responsavel' ? 'selected' : ''; ?>>Responsável</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="senha" class="form-label"><?php echo $acao === 'cadastrar' ? 'Senha *' : 'Senha (opcional)'; ?></label>
                            <input type="password" name="senha" id="senha" class="form-control" <?php echo $acao === 'cadastrar' ? 'required' : ''; ?>>
                            <?php if ($acao === 'atualizar'): ?>
                                <small class="text-muted">Deixe em branco para manter a senha atual.</small>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="usuarios.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    (function () {
        const form = document.querySelector('form.needs-validation');
        const emailInput = document.getElementById('email');
        const alerta = document.getElementById('erro-validacao');

        if (!form || !emailInput || !alerta) {
            return;
        }

        form.addEventListener('submit', function (event) {
            alerta.classList.add('d-none');
            alerta.textContent = '';
            emailInput.classList.remove('is-invalid');

            if (!emailInput.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                emailInput.classList.add('is-invalid');
                alerta.textContent = 'Informe um email válido.';
                alerta.classList.remove('d-none');
            }
        });
    })();
</script>
