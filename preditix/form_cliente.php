<?php
require_once 'includes/auth.php';
require_once 'classes/Cliente.php';

Auth::checkAuth();

$cliente = new Cliente();
$dados = [];
$acao = 'cadastrar';
$titulo = 'Novo Executor';
$erro = null;
$sucesso = null;

// Se estiver editando, carrega os dados
if (isset($_GET['id'])) {
    try {
        $dados = $cliente->buscarPorId($_GET['id']);
        if ($dados) {
            $acao = 'atualizar';
            $titulo = 'Editar Executor';
        }
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nome = trim($_POST['nome'] ?? '');
        if ($nome === '') {
            throw new Exception('O nome do executor é obrigatório.');
        }

        $dados = [
            'nome' => $nome,
            'cnpj' => $_POST['cnpj'],
            'telefone' => $_POST['telefone'],
            'email' => $_POST['email'],
            'endereco' => $_POST['endereco']
        ];

        if ($_POST['action'] === 'cadastrar') {
            $cliente->cadastrar($dados);
            $sucesso = "Executor cadastrado com sucesso!";
        } else {
            $cliente->atualizar($_POST['id'], $dados);
            $sucesso = "Executor atualizado com sucesso!";
        }

        // Redireciona apenas se não houver erro
        header('Location: clientes.php');
        exit();
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

// Incluir o header apenas se não houver redirecionamento
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

    <?php if ($sucesso): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($sucesso); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

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
                            <label for="cnpj" class="form-label">CNPJ</label>
                            <input type="text" name="cnpj" id="cnpj" class="form-control" 
                                value="<?php echo htmlspecialchars($dados['cnpj'] ?? ''); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" name="telefone" id="telefone" class="form-control" 
                                value="<?php echo htmlspecialchars($dados['telefone'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" 
                                value="<?php echo htmlspecialchars($dados['email'] ?? ''); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <textarea name="endereco" id="endereco" class="form-control" rows="4"><?php echo htmlspecialchars($dados['endereco'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="clientes.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
