<?php
require_once 'includes/auth.php';
require_once 'includes/header.php';
require_once 'classes/Implemento.php';

Auth::checkAuth();

$implemento = new Implemento();
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: implementos.php');
    exit();
}

$dados = $implemento->buscarPorId($id);

if (!$dados) {
    header('Location: implementos.php');
    exit();
}
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalhes do Implemento</h1>
        <div>
            <a href="implementos.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <a href="form_implemento.php?id=<?php echo $id; ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>

    <div class="card mx-auto" style="max-width: 800px;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2" class="text-center">Informações Básicas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="30%" class="text-center">Tag</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['tag'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Tipo</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['tipo'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Placa</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['placa'] ?? ''); ?></td>
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
                                <th class="text-center">Ano</th>
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
                                <th class="text-center">Renavam</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['renavam'] ?? ''); ?></td>
                            </tr>
                            <tr class="text-center">
                                <th class="text-center">Proprietário</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['proprietario'] ?? ''); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2" class="text-center">Especificações Técnicas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center">Tara</th>
                                <td class="text-center"><?php echo number_format($dados['tara'] ?? 0, 2); ?> kg</td>
                            </tr>
                            <tr class="text-center">
                                <th class="text-center">Lotação</th>
                                <td class="text-center"><?php echo htmlspecialchars($dados['lotacao'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th width="30%" class="text-center">Peso Bruto Total</th>
                                <td class="text-center"><?php echo number_format($dados['peso_bruto_total'] ?? 0, 2); ?> kg</td>
                            </tr>
                            <tr>
                                <th width="30%" class="text-center">Capacidade Máxima de Tração</th>
                                <td class="text-center"><?php echo number_format($dados['capacidade_maxima_tracao'] ?? 0, 2); ?> ton</td>
                            </tr>
                            <tr>
                                <th width="30%" class="text-center">Capacidade Volumétrica</th>
                                <td class="text-center"><?php echo number_format($dados['capacidade_volumetrica'] ?? 0, 2); ?> m³</td>
                            </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2" class="text-center">Status e Datas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th width="30%" class="text-center">Status</th>
                                <td class="text-center">
                                    <span class="badge bg-<?php echo $dados['status'] === 'ativo' ? 'success' : ($dados['status'] === 'inativo' ? 'danger' : 'warning'); ?>">
                                        <?php echo ucfirst($dados['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">Data de Criação</th>
                                <td class="text-center"><?php echo date('d/m/Y H:i', strtotime($dados['data_criacao'])); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Última Atualização</th>
                                <td class="text-center"><?php echo date('d/m/Y H:i', strtotime($dados['data_atualizacao'])); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php if (!empty($dados['foto'])): ?>
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="card-title mb-0 text-center">Foto</h5>
                            </div>
                            <div class="card-body text-center">
                                <img src="<?php echo htmlspecialchars($dados['foto']); ?>" 
                                     alt="Foto do Implemento" 
                                     class="img-fluid rounded" 
                                     style="max-height: 400px;">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
