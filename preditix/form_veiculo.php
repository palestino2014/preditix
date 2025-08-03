<?php
require_once 'includes/auth.php';
require_once 'classes/Veiculo.php';

Auth::checkAuth();

$veiculo = new Veiculo();
$dados = [];
$acao = 'cadastrar';
$titulo = 'Novo Veículo';
$erro = null;
$sucesso = null;

// Se estiver editando, carrega os dados
if (isset($_GET['id'])) {
    try {
        $dados = $veiculo->buscarPorId($_GET['id']);
        if ($dados) {
            $acao = 'atualizar';
            $titulo = 'Editar Veículo';
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
            'peso_bruto_total_combinado' => $_POST['peso_bruto_total_combinado'],
            'capacidade_maxima_tracao' => $_POST['capacidade_maxima_tracao'],
            'cor' => $_POST['cor'],
            'status' => $_POST['status'],
            'foto' => $_FILES['foto'] ?? null
        ];

        if ($_POST['action'] === 'cadastrar') {
            $veiculo->cadastrar($dados);
            $sucesso = "Veículo cadastrado com sucesso!";
        } else {
            $veiculo->atualizar($_POST['id'], $dados);
            $sucesso = "Veículo atualizado com sucesso!";
        }

        // Redireciona apenas se não houver erro
        header('Location: veiculos.php');
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
                    <!-- Coluna 1 -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="tag" class="form-label">Tag *</label>
                            <input type="text" class="form-control" id="tag" name="tag" 
                                   value="<?php echo htmlspecialchars($dados['tag'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo *</label>
                            <select class="form-select" id="tipo" name="tipo" required>
                                <option value="">Selecione...</option>
                                <option value="caminhao_toco" <?php echo ($dados['tipo'] ?? '') === 'caminhao_toco' ? 'selected' : ''; ?>>Caminhão Toco</option>
                                <option value="cavalo_mecanico_eixo_simples" <?php echo ($dados['tipo'] ?? '') === 'cavalo_mecanico_eixo_simples' ? 'selected' : ''; ?>>Cavalo Mecânico Eixo Simples</option>
                                <option value="cavalo_mecanico_trucado" <?php echo ($dados['tipo'] ?? '') === 'cavalo_mecanico_trucado' ? 'selected' : ''; ?>>Cavalo Mecânico Trucado</option>
                                <option value="veiculo_leve_administrativo" <?php echo ($dados['tipo'] ?? '') === 'veiculo_leve_administrativo' ? 'selected' : ''; ?>>Veículo Leve Administrativo</option>
                                <option value="veiculo_leve_operacional" <?php echo ($dados['tipo'] ?? '') === 'veiculo_leve_operacional' ? 'selected' : ''; ?>>Veículo Leve Operacional</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="placa" class="form-label">Placa *</label>
                            <input type="text" class="form-control" id="placa" name="placa" 
                                   value="<?php echo htmlspecialchars($dados['placa'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="fabricante" class="form-label">Fabricante *</label>
                            <input type="text" class="form-control" id="fabricante" name="fabricante" 
                                   value="<?php echo htmlspecialchars($dados['fabricante'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <!-- Coluna 2 -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="modelo" class="form-label">Modelo *</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" 
                                   value="<?php echo htmlspecialchars($dados['modelo'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="ano_fabricacao" class="form-label">Ano de Fabricação *</label>
                            <input type="number" class="form-control" id="ano_fabricacao" name="ano_fabricacao" 
                                   value="<?php echo htmlspecialchars($dados['ano_fabricacao'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="chassi" class="form-label">Chassi</label>
                            <input type="text" class="form-control" id="chassi" name="chassi" 
                                   value="<?php echo htmlspecialchars($dados['chassi'] ?? ''); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="renavam" class="form-label">RENAVAM</label>
                            <input type="text" class="form-control" id="renavam" name="renavam" 
                                   value="<?php echo htmlspecialchars($dados['renavam'] ?? ''); ?>">
                        </div>
                    </div>

                    <!-- Coluna 3 -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="proprietario" class="form-label">Proprietário *</label>
                            <input type="text" class="form-control" id="proprietario" name="proprietario" 
                                   value="<?php echo htmlspecialchars($dados['proprietario'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="tara" class="form-label">Tara (kg) *</label>
                            <input type="number" step="0.01" class="form-control" id="tara" name="tara" 
                                   value="<?php echo htmlspecialchars($dados['tara'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="lotacao" class="form-label">Lotação (kg) *</label>
                            <input type="number" step="0.01" class="form-control" id="lotacao" name="lotacao" 
                                   value="<?php echo htmlspecialchars($dados['lotacao'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="peso_bruto_total" class="form-label">PBT (kg) *</label>
                            <input type="number" step="0.01" class="form-control" id="peso_bruto_total" name="peso_bruto_total" 
                                   value="<?php echo htmlspecialchars($dados['peso_bruto_total'] ?? ''); ?>" required>
                        </div>
                    </div>

                    <!-- Coluna 4 -->
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="peso_bruto_total_combinado" class="form-label">PBTC (kg) *</label>
                            <input type="number" step="0.01" class="form-control" id="peso_bruto_total_combinado" name="peso_bruto_total_combinado" 
                                   value="<?php echo htmlspecialchars($dados['peso_bruto_total_combinado'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="capacidade_maxima_tracao" class="form-label">CMT (kg) *</label>
                            <input type="number" step="0.01" class="form-control" id="capacidade_maxima_tracao" name="capacidade_maxima_tracao" 
                                   value="<?php echo htmlspecialchars($dados['capacidade_maxima_tracao'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="cor" class="form-label">Cor</label>
                            <input type="text" class="form-control" id="cor" name="cor" 
                                   value="<?php echo htmlspecialchars($dados['cor'] ?? ''); ?>">
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
                    <a href="veiculos.php" class="btn btn-secondary">
                        Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
