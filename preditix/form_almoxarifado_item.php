<?php
require_once 'includes/auth.php';
require_once 'classes/AlmoxarifadoItem.php';

Auth::checkAuth();
Auth::checkGestor();

$almoxarifado = new AlmoxarifadoItem();
$dados = [
    'codigo_barras' => '',
    'nome' => '',
    'quantidade' => 0,
    'valor_unitario' => 0
];
$acao = 'cadastrar';
$titulo = 'Novo Item';
$erro = null;

if (isset($_GET['id'])) {
    try {
        $dados = $almoxarifado->buscarPorId($_GET['id']);
        $acao = 'atualizar';
        $titulo = 'Editar Item';
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $codigo_barras = trim($_POST['codigo_barras'] ?? '');
        $nome = trim($_POST['nome'] ?? '');
        $quantidade = filter_var($_POST['quantidade'] ?? null, FILTER_VALIDATE_FLOAT);
        $valor_unitario = filter_var($_POST['valor_unitario'] ?? null, FILTER_VALIDATE_FLOAT);

        if ($codigo_barras === '') {
            throw new Exception('O código de barras é obrigatório.');
        }
        if ($nome === '') {
            throw new Exception('O nome do item é obrigatório.');
        }
        if ($quantidade === false || $quantidade < 0) {
            throw new Exception('Informe uma quantidade válida.');
        }
        if ($valor_unitario === false || $valor_unitario < 0) {
            throw new Exception('Informe um valor unitário válido.');
        }

        $dados = [
            'codigo_barras' => $codigo_barras,
            'nome' => $nome,
            'quantidade' => $quantidade,
            'valor_unitario' => $valor_unitario
        ];

        if ($_POST['action'] === 'cadastrar') {
            $almoxarifado->cadastrar($dados);
        } else {
            $almoxarifado->atualizar($_POST['id'], $dados);
        }

        header('Location: almoxarifado.php?sucesso=Item+salvo+com+sucesso.');
        exit();
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
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
                            <label for="codigo_barras" class="form-label">Cód. de Barras *</label>
                            <input type="text" name="codigo_barras" id="codigo_barras" class="form-control"
                                   value="<?php echo htmlspecialchars($dados['codigo_barras'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome *</label>
                            <input type="text" name="nome" id="nome" class="form-control"
                                   value="<?php echo htmlspecialchars($dados['nome'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade *</label>
                            <input type="number" step="0.01" min="0" name="quantidade" id="quantidade" class="form-control"
                                   value="<?php echo htmlspecialchars($dados['quantidade'] ?? 0); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="valor_unitario" class="form-label">Valor Unitário *</label>
                            <input type="number" step="0.01" min="0" name="valor_unitario" id="valor_unitario" class="form-control"
                                   value="<?php echo htmlspecialchars($dados['valor_unitario'] ?? 0); ?>" required>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="almoxarifado.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
