<?php
require_once 'includes/auth.php';
require_once 'classes/Tanque.php';

Auth::checkAuth();

$tanque = new Tanque();
$dados = [];
$acao = 'cadastrar';
$titulo = 'Novo Tanque';
$erro = null;
$sucesso = null;

// Se estiver editando, carrega os dados
if (isset($_GET['id'])) {
    try {
        $dados = $tanque->buscarPorId($_GET['id']);
        if ($dados) {
            $acao = 'atualizar';
            $titulo = 'Editar Tanque';
        }
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dados = [
            'tag' => $_POST['tag'],
            'fabricante_responsavel' => $_POST['fabricante_responsavel'],
            'ano_fabricacao' => $_POST['ano_fabricacao'],
            'localizacao' => $_POST['localizacao'],
            'capacidade_volumetrica' => $_POST['capacidade_volumetrica'],
            'status' => $_POST['status'],
            'foto' => $_FILES['foto'] ?? null
        ];

        if ($_POST['action'] === 'cadastrar') {
            $tanque->cadastrar($dados);
            $sucesso = "Tanque cadastrado com sucesso!";
        } else {
            $tanque->atualizar($_POST['id'], $dados);
            $sucesso = "Tanque atualizado com sucesso!";
        }

        // Redireciona apenas se não houver erro
        header('Location: tanques.php');
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
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?php echo $acao; ?>">
                <?php if ($acao === 'atualizar'): ?>
                    <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
                <?php endif; ?>
                
                <div class="row">
                    <!-- Coluna 1 -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tag" class="form-label">Tag *</label>
                            <input type="text" class="form-control" id="tag" name="tag" 
                                   value="<?php echo htmlspecialchars($dados['tag'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="fabricante_responsavel" class="form-label">Fabricante Responsável *</label>
                            <input type="text" class="form-control" id="fabricante_responsavel" name="fabricante_responsavel" 
                                   value="<?php echo htmlspecialchars($dados['fabricante_responsavel'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <!-- Coluna 2 -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="ano_fabricacao" class="form-label">Ano de Fabricação *</label>
                            <input type="number" class="form-control" id="ano_fabricacao" name="ano_fabricacao" 
                                   value="<?php echo htmlspecialchars($dados['ano_fabricacao'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="localizacao" class="form-label">Localização *</label>
                            <input type="text" class="form-control" id="localizacao" name="localizacao" 
                                   value="<?php echo htmlspecialchars($dados['localizacao'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <!-- Coluna 3 -->
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="capacidade_volumetrica" class="form-label">Capacidade Volumétrica (m³) *</label>
                            <input type="number" step="0.01" class="form-control" id="capacidade_volumetrica" name="capacidade_volumetrica" 
                                   value="<?php echo htmlspecialchars($dados['capacidade_volumetrica'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="ativo" <?php echo ($dados['status'] ?? '') === 'ativo' ? 'selected' : ''; ?>>Ativo</option>
                                <option value="inativo" <?php echo ($dados['status'] ?? '') === 'inativo' ? 'selected' : ''; ?>>Inativo</option>
                                <option value="manutencao" <?php echo ($dados['status'] ?? '') === 'manutencao' ? 'selected' : ''; ?>>Em Manutenção</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        Salvar
                    </button>
                    <a href="tanques.php" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
