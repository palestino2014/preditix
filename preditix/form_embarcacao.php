<?php
require_once 'includes/auth.php';
require_once 'classes/Embarcacao.php';

Auth::checkAuth();

$embarcacao = new Embarcacao();
$dados = [];
$acao = 'cadastrar';
$titulo = 'Nova Embarcação';
$erro = null;
$sucesso = null;

// Se estiver editando, carrega os dados
if (isset($_GET['id'])) {
    try {
        $dados = $embarcacao->buscarPorId($_GET['id']);
        if ($dados) {
            $acao = 'atualizar';
            $titulo = 'Editar Embarcação';
        }
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dados = [
            'tipo' => $_POST['tipo'],
            'subtipo_balsa' => $_POST['subtipo_balsa'] ?? null,
            'tag' => $_POST['tag'],
            'inscricao' => $_POST['inscricao'],
            'nome' => $_POST['nome'],
            'armador' => $_POST['armador'],
            'ano_fabricacao' => $_POST['ano_fabricacao'],
            'capacidade_volumetrica' => $_POST['capacidade_volumetrica'],
            'status' => $_POST['status'],
            'foto' => $_FILES['foto'] ?? null
        ];

        if ($_POST['action'] === 'cadastrar') {
            $embarcacao->cadastrar($dados);
            $sucesso = "Embarcação cadastrada com sucesso!";
        } else {
            $embarcacao->atualizar($_POST['id'], $dados);
            $sucesso = "Embarcação atualizada com sucesso!";
        }

        // Redireciona apenas se não houver erro
        header('Location: embarcacoes.php');
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

            <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <input type="hidden" name="action" value="<?php echo $acao; ?>">
                <?php if ($acao === 'atualizar'): ?>
                    <input type="hidden" name="id" value="<?php echo $dados['id']; ?>">
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select name="tipo" id="tipo" class="form-select" required>
                                <option value="balsa_simples" <?php echo ($dados['tipo'] ?? '') === 'balsa_simples' ? 'selected' : ''; ?>>Balsa Simples</option>
                                <option value="balsa_motorizada" <?php echo ($dados['tipo'] ?? '') === 'balsa_motorizada' ? 'selected' : ''; ?>>Balsa Motorizada</option>
                                <option value="empurrador" <?php echo ($dados['tipo'] ?? '') === 'empurrador' ? 'selected' : ''; ?>>Empurrador</option>
                            </select>
                        </div>

                        <div class="mb-3" id="subtipo_balsa_field" style="display: none;">
                            <label for="subtipo_balsa" class="form-label">Subtipo da Balsa *</label>
                            <select name="subtipo_balsa" id="subtipo_balsa" class="form-select">
                                <option value="">Selecione...</option>
                                <option value="docagem" <?php echo ($dados['subtipo_balsa'] ?? '') === 'docagem' ? 'selected' : ''; ?>>Docagem</option>
                                <option value="comboio" <?php echo ($dados['subtipo_balsa'] ?? '') === 'comboio' ? 'selected' : ''; ?>>Comboio</option>
                                <option value="outros" <?php echo ($dados['subtipo_balsa'] ?? '') === 'outros' ? 'selected' : ''; ?>>Outros</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tag" class="form-label">Tag *</label>
                            <input type="text" name="tag" id="tag" class="form-control" 
                                value="<?php echo htmlspecialchars($dados['tag'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="inscricao" class="form-label">Inscrição *</label>
                            <input type="text" name="inscricao" id="inscricao" class="form-control" 
                                value="<?php echo htmlspecialchars($dados['inscricao'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome *</label>
                            <input type="text" name="nome" id="nome" class="form-control" 
                                value="<?php echo htmlspecialchars($dados['nome'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="armador" class="form-label">Armador *</label>
                            <input type="text" name="armador" id="armador" class="form-control" 
                                value="<?php echo htmlspecialchars($dados['armador'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="ano_fabricacao" class="form-label">Ano de Fabricação *</label>
                            <input type="number" name="ano_fabricacao" id="ano_fabricacao" class="form-control" 
                                value="<?php echo htmlspecialchars($dados['ano_fabricacao'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="capacidade_volumetrica" class="form-label">Capacidade Volumétrica (m³) *</label>
                            <input type="number" step="0.01" name="capacidade_volumetrica" id="capacidade_volumetrica" class="form-control" 
                                value="<?php echo htmlspecialchars($dados['capacidade_volumetrica'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="ativo" <?php echo ($dados['status'] ?? '') === 'ativo' ? 'selected' : ''; ?>>Ativo</option>
                                <option value="inativo" <?php echo ($dados['status'] ?? '') === 'inativo' ? 'selected' : ''; ?>>Inativo</option>
                                <option value="manutencao" <?php echo ($dados['status'] ?? '') === 'manutencao' ? 'selected' : ''; ?>>Em Manutenção</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="embarcacoes.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tipoSelect = document.getElementById('tipo');
    const subtipoField = document.getElementById('subtipo_balsa_field');
    const subtipoSelect = document.getElementById('subtipo_balsa');
    
    function toggleSubtipoField() {
        if (tipoSelect.value === 'balsa_simples' || tipoSelect.value === 'balsa_motorizada') {
            subtipoField.style.display = 'block';
            subtipoSelect.required = true;
        } else {
            subtipoField.style.display = 'none';
            subtipoSelect.required = false;
            subtipoSelect.value = '';
        }
    }
    
    // Verificar estado inicial
    toggleSubtipoField();
    
    // Adicionar listener para mudanças
    tipoSelect.addEventListener('change', toggleSubtipoField);
});
</script>

