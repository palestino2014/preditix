<?php
require_once 'includes/auth.php';
require_once 'classes/OrdemServico.php';

Auth::checkAuth();

$ordem = new OrdemServico();
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: ordens_servico.php');
    exit();
}

$dados = $ordem->buscarPorId($id);
$itens = $ordem->listarItens($id);

if (!$dados) {
    header('Location: ordens_servico.php');
    exit();
}

// Incluir o header apenas após todo o processamento
require_once 'includes/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalhes da Ordem de Serviço</h1>
        <div>
            <a href="ordens_servico.php" class="btn btn-secondary">Voltar</a>
            <a href="form_ordem_servico.php?id=<?php echo $id; ?>" class="btn btn-primary">Editar</a>
        </div>
    </div>

    <div class="card mx-auto" style="max-width: 1000px;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <!-- Informações Básicas -->
                    <table class="table table-bordered mb-4">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2" class="text-center">Informações Básicas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" style="width: 30%;">Número OS</th>
                                <td><?php echo htmlspecialchars($dados['numero_os'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Status</th>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo match($dados['status']) {
                                            'aberta' => 'warning',
                                            'em_andamento' => 'info',
                                            'concluida' => 'success',
                                            'cancelada' => 'danger',
                                            default => 'secondary'
                                        };
                                    ?>">
                                        <?php echo ucfirst($dados['status'] ?? ''); ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center">Prioridade</th>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo match($dados['prioridade']) {
                                            'baixa' => 'success',
                                            'media' => 'warning',
                                            'alta' => 'danger',
                                            default => 'secondary'
                                        };
                                    ?>">
                                        <?php echo ucfirst($dados['prioridade'] ?? ''); ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Datas -->
                    <table class="table table-bordered mb-4">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2" class="text-center">Datas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" style="width: 30%;">Data de Abertura</th>
                                <td><?php echo date('d/m/Y H:i', strtotime($dados['data_abertura'] ?? '')); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Data Prevista</th>
                                <td><?php echo date('d/m/Y', strtotime($dados['data_prevista'] ?? '')); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Data de Conclusão</th>
                                <td><?php echo $dados['data_conclusao'] ? date('d/m/Y', strtotime($dados['data_conclusao'])) : '-'; ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Responsáveis -->
                    <table class="table table-bordered mb-4">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2" class="text-center">Responsáveis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" style="width: 30%;">Aberto por</th>
                                <td><?php echo htmlspecialchars($dados['usuario_abertura_nome'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Responsável</th>
                                <td><?php echo htmlspecialchars($dados['usuario_responsavel_nome'] ?? ''); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Descrições -->
                    <table class="table table-bordered mb-4">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2" class="text-center">Descrições</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" style="width: 30%;">Problema Reportado</th>
                                <td><?php echo nl2br(htmlspecialchars($dados['descricao_problema'] ?? '')); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Solução Aplicada</th>
                                <td><?php echo nl2br(htmlspecialchars($dados['descricao_solucao'] ?? '')); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Custos -->
                    <table class="table table-bordered mb-4">
                        <thead class="table-light">
                            <tr>
                                <th colspan="2" class="text-center">Custos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" style="width: 30%;">Custo Estimado</th>
                                <td>R$ <?php echo number_format($dados['custo_estimado'] ?? 0, 2, ',', '.'); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center">Custo Final</th>
                                <td>R$ <?php echo number_format($dados['custo_final'] ?? 0, 2, ',', '.'); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Itens da Ordem de Serviço -->
                    <?php if (!empty($itens)): ?>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th colspan="5" class="text-center">Itens da Ordem de Serviço</th>
                                </tr>
                                <tr>
                                    <th>Descrição</th>
                                    <th class="text-center">Quantidade</th>
                                    <th class="text-center">Unidade</th>
                                    <th class="text-center">Valor Unitário</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $total = 0;
                                foreach ($itens as $item): 
                                    $subtotal = $item['quantidade'] * $item['valor_unitario'];
                                    $total += $subtotal;
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['descricao']); ?></td>
                                    <td class="text-center"><?php echo number_format($item['quantidade'], 2, ',', '.'); ?></td>
                                    <td class="text-center"><?php echo htmlspecialchars($item['unidade']); ?></td>
                                    <td class="text-center">R$ <?php echo number_format($item['valor_unitario'], 2, ',', '.'); ?></td>
                                    <td class="text-center">R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="table-light">
                                    <th colspan="4" class="text-end">Total dos Itens:</th>
                                    <th class="text-center">R$ <?php echo number_format($total, 2, ',', '.'); ?></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <?php endif; ?>

                    <?php if (!empty($dados['fotos'])): ?>
                    <div class="mt-4">
                        <h5 class="text-center mb-3">Fotos do Serviço</h5>
                        <div class="row justify-content-center">
                            <?php foreach (explode(',', $dados['fotos']) as $foto): ?>
                                <div class="col-md-4 mb-3">
                                    <div class="text-center">
                                        <img src="<?php echo htmlspecialchars($foto); ?>" 
                                            alt="Foto do serviço" 
                                            class="img-fluid rounded" 
                                            style="max-height: 200px;">
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?> 