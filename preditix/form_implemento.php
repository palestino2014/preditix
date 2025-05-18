<?php
require_once 'includes/auth.php';
require_once 'classes/Implemento.php';

Auth::checkAuth();

$implemento = new Implemento();
$dados = [];
$acao = 'cadastrar';
$titulo = 'Novo Implemento';
$erro = null;
$sucesso = null;

// Se estiver editando, carrega os dados
if (isset($_GET['id'])) {
    try {
        $dados = $implemento->buscar($_GET['id']);
        if ($dados) {
            $acao = 'atualizar';
            $titulo = 'Editar Implemento';
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
            'tag' => $_POST['tag'],
            'placa' => $_POST['placa'],
            'fabricante' => $_POST['fabricante'],
            'modelo' => $_POST['modelo'],
            'ano_fabricacao' => $_POST['ano_fabricacao'],
            'chassi' => $_POST['chassi'],
            'renavam' => $_POST['renavam'],
            'proprietario' => $_POST['proprietario'],
            'tara' => $_POST['tara'],
            'lotacao' => $_POST['lotacao'],
            'peso_bruto_total' => $_POST['peso_bruto_total'],
            'capacidade_maxima_tracao' => $_POST['capacidade_maxima_tracao'],
            'capacidade_volumetrica' => $_POST['capacidade_volumetrica'],
            'cor' => $_POST['cor'],
            'status' => $_POST['status'],
            'foto' => $_FILES['foto'] ?? null
        ];

        if ($_POST['action'] === 'cadastrar') {
            $implemento->cadastrar($dados);
            $sucesso = "Implemento cadastrado com sucesso!";
        } else {
            $implemento->atualizar($_POST['id'], $dados);
            $sucesso = "Implemento atualizado com sucesso!";
        }

        // Redireciona apenas se não houver erro
        header('Location: implementos.php');
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
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Tipo</label>
                            <select name="tipo" class="form-select" required>
                                <option value="semirreboque_tanque_2_eixos" <?php echo ($dados['tipo'] ?? '') === 'semirreboque_tanque_2_eixos' ? 'selected' : ''; ?>>Semirreboque Tanque 2
                                    Eixos</option>
                                <option value="semirreboque_tanque_3_eixos" <?php echo ($dados['tipo'] ?? '') === 'semirreboque_tanque_3_eixos' ? 'selected' : ''; ?>>Semirreboque Tanque 3
                                    Eixos</option>
                                <option value="semirreboque_tanque_5a_roda_traseira_3_eixos" <?php echo ($dados['tipo'] ?? '') === 'semirreboque_tanque_5a_roda_traseira_3_eixos' ? 'selected' : ''; ?>>
                                    Semirreboque Tanque com 5ª Roda Traseira 3 Eixos</option>
                                <option value="comboio_abastecimento" <?php echo ($dados['tipo'] ?? '') === 'comboio_abastecimento' ? 'selected' : ''; ?>>Comboio de Abastecimento
                                </option>
                                <option value="bau" <?php echo ($dados['tipo'] ?? '') === 'bau' ? 'selected' : ''; ?>>Baú
                                </option>
                                <option value="outro" <?php echo ($dados['tipo'] ?? '') === 'outro' ? 'selected' : ''; ?>>
                                    Outro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tag</label>
                            <input type="text" name="tag" class="form-control"
                                value="<?php echo htmlspecialchars($dados['tag'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Placa</label>
                            <input type="text" name="placa" class="form-control"
                                value="<?php echo htmlspecialchars($dados['placa'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Fabricante</label>
                            <input type="text" name="fabricante" class="form-control"
                                value="<?php echo htmlspecialchars($dados['fabricante'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Modelo</label>
                            <input type="text" name="modelo" class="form-control"
                                value="<?php echo htmlspecialchars($dados['modelo'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ano de Fabricação</label>
                            <input type="number" name="ano_fabricacao" class="form-control"
                                value="<?php echo htmlspecialchars($dados['ano_fabricacao'] ?? ''); ?>" required>
                        </div>
                    
                        <div class="mb-3">
                            <label class="form-label">Chassi</label>
                            <input type="text" name="chassi" class="form-control"
                                value="<?php echo htmlspecialchars($dados['chassi'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">RENAVAM</label>
                            <input type="text" name="renavam" class="form-control"
                                value="<?php echo htmlspecialchars($dados['renavam'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Proprietário</label>
                            <input type="text" name="proprietario" class="form-control"
                                value="<?php echo htmlspecialchars($dados['proprietario'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tara (kg)</label>
                            <input type="number" step="0.01" name="tara" class="form-control"
                                value="<?php echo htmlspecialchars($dados['tara'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Lotação (kg)</label>
                            <input type="number" step="0.01" name="lotacao" class="form-control"
                                value="<?php echo htmlspecialchars($dados['lotacao'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Peso Bruto Total (kg)</label>
                            <input type="number" step="0.01" name="peso_bruto_total" class="form-control"
                                value="<?php echo htmlspecialchars($dados['peso_bruto_total'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Capacidade Máxima de Tração (kg)</label>
                            <input type="number" step="0.01" name="capacidade_maxima_tracao" class="form-control"
                                value="<?php echo htmlspecialchars($dados['capacidade_maxima_tracao'] ?? ''); ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Capacidade Volumétrica (m³)</label>
                            <input type="number" step="0.01" name="capacidade_volumetrica" class="form-control"
                                value="<?php echo htmlspecialchars($dados['capacidade_volumetrica'] ?? ''); ?>"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cor</label>
                            <input type="text" name="cor" class="form-control"
                                value="<?php echo htmlspecialchars($dados['cor'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                <option value="ativo" <?php echo ($dados['status'] ?? '') === 'ativo' ? 'selected' : ''; ?>>Ativo</option>
                                <option value="inativo" <?php echo ($dados['status'] ?? '') === 'inativo' ? 'selected' : ''; ?>>Inativo</option>
                                <option value="manutencao" <?php echo ($dados['status'] ?? '') === 'manutencao' ? 'selected' : ''; ?>>Em Manutenção</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="implementos.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>