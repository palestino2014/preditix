<?php
require_once 'includes/auth.php';
require_once 'includes/header.php';
require_once 'classes/Embarcacao.php';

Auth::checkAuth();

$embarcacao = new Embarcacao();
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: embarcacoes.php');
    exit();
}

$dados = $embarcacao->buscarPorId($id);

if (!$dados) {
    header('Location: embarcacoes.php');
    exit();
}
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detalhes da Embarcação</h1>
        <div>
            <a href="embarcacoes.php" class="btn btn-secondary">Voltar</a>
            <a href="form_embarcacao.php?id=<?php echo $id; ?>" class="btn btn-primary">Editar</a>
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
                                <th class="text-center" style="width: 30%;">Tag</th>
                                <td><?php echo htmlspecialchars($dados['tag'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center" style="width: 30%;">Tipo</th>
                                <td><?php echo htmlspecialchars($dados['tipo'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center" style="width: 30%;">Inscrição</th>
                                <td><?php echo htmlspecialchars($dados['inscricao'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center" style="width: 30%;">Nome</th>
                                <td><?php echo htmlspecialchars($dados['nome'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center" style="width: 30%;">Armador</th>
                                <td><?php echo htmlspecialchars($dados['armador'] ?? ''); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center" style="width: 30%;">Ano de Fabricação</th>
                                <td><?php echo htmlspecialchars($dados['ano_fabricacao'] ?? ''); ?></td>
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
                                <th class="text-center" style="width: 30%;">Capacidade Volumétrica</th>
                                <td><?php echo number_format($dados['capacidade_volumetrica'] ?? 0, 2); ?> m³</td>
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
                                <th class="text-center" style="width: 30%;">Status</th>
                                <td>
                                    <span class="badge bg-<?php echo $dados['status'] === 'ativo' ? 'success' : ($dados['status'] === 'inativo' ? 'danger' : 'warning'); ?>">
                                        <?php echo ucfirst($dados['status'] ?? ''); ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" style="width: 30%;">Data de Criação</th>
                                <td><?php echo date('d/m/Y H:i', strtotime($dados['data_criacao'] ?? '')); ?></td>
                            </tr>
                            <tr>
                                <th class="text-center" style="width: 30%;">Última Atualização</th>
                                <td><?php echo date('d/m/Y H:i', strtotime($dados['data_atualizacao'] ?? '')); ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <?php if (!empty($dados['foto'])): ?>
                        <div class="mt-4">
                            <div class="text-center">
                                <img src="<?php echo htmlspecialchars($dados['foto']); ?>" 
                                    alt="Foto da embarcação" 
                                    class="img-fluid rounded" 
                                    style="max-height: 300px;">
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
