<?php
require_once 'includes/auth.php';
require_once 'includes/header.php';
require_once 'classes/Veiculo.php';

Auth::checkAuth();

$veiculo = new Veiculo();
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: veiculos.php');
    exit();
}

$dados = $veiculo->buscarPorId($id);

if (!$dados) {
    header('Location: veiculos.php');
    exit();
}
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalhes do Veículo</h1>
        <div>
            <a href="veiculos.php" class="btn btn-secondary">Voltar</a>
            <a href="form_veiculo.php?id=<?php echo $id; ?>" class="btn btn-primary">Editar</a>
        </div>
    </div>

    <div class="card mx-auto" style="max-width: 800px;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Informações Básicas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" style="width: 30%">Tag</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['tag'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Placa</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['placa'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Tipo</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['tipo'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Fabricante</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['fabricante'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Modelo</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['modelo'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Ano de Fabricação</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['ano_fabricacao'] ?? ''); ?></td>
                            </tr>
                            <tr class="text-center">
                                <th class="text-center">Cor</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['cor'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Chassi</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['chassi'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">RENAVAM</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['renavam'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Proprietário</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['proprietario'] ?? ''); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Especificações Técnicas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" style="width: 30%">Tara (kg)</th>
                                <td class="text-center"><?php echo number_format($dados['tara'] ?? 0, 2); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Lotação</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['lotacao'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Peso Bruto Total (kg)</th>
                                <td class="text-center"><?php echo number_format($dados['peso_bruto_total'] ?? 0, 2); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Peso Bruto Total Combinado (kg)</th>
                                <td class="text-center"><?php echo number_format($dados['peso_bruto_total_combinado'] ?? 0, 2); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Capacidade Máxima de Tração (kg)</th>
                                <td class="text-center"><?php echo number_format($dados['capacidade_maxima_tracao'] ?? 0, 2); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2" class="text-center">Status e Datas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" style="width: 30%">Status</th>
                                <td class="text-center">
                                    <?php
                                    $status = $dados['status'] ?? '';
                                    $badgeClass = match($status) {
                                        'ativo' => 'bg-success',
                                        'inativo' => 'bg-danger',
                                        'manutencao' => 'bg-warning',
                                        default => 'bg-secondary'
                                    };
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?>">
                                        <?php echo ucfirst($status); ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">Data de Criação</th>
                                <td class="text-center"><?php echo date('d/m/Y H:i', strtotime($dados['data_criacao'] ?? '')); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Última Atualização</th>
                                <td class="text-center"><?php echo date('d/m/Y H:i', strtotime($dados['data_atualizacao'] ?? '')); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php if (!empty($dados['foto'])): ?>
                    <div class="card mt-4">
                        <div class="card-header text-center">
                            <h5 class="mb-0">Foto</h5>
                        </div>
                        <div class="card-body text-center">
                            <img src="<?php echo htmlspecialchars($dados['foto']); ?>" 
                                 alt="Foto do Veículo" 
                                 class="img-fluid" 
                                 style="max-height: 300px;">
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
