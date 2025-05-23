<?php
require_once 'includes/auth.php';
// require_once 'includes/header.php';
require_once 'classes/Embarcacao.php';

Auth::checkAuth();

$embarcacao = new Embarcacao();

include 'includes/header.php';

$embarcacoes = $embarcacao->listar();
?>

<div class="container">    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Embarcações</h1>
        <a href="form_embarcacao.php" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nova Embarcação
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-ativos">
                    <thead>
                        <tr>
                            <th class="col-nome">Nome</th>
                            <th class="col-inscricao">Inscrição</th>
                            <th class="col-tipo">Tipo</th>
                            <th class="col-tag">Tag</th>
                            <th class="col-ano">Ano</th>
                            <th class="table-cell-number">Capacidade</th>
                            <th class="col-armador">Armador</th>
                            <th class="table-cell-status">Status</th>
                            <th class="table-cell-actions">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($embarcacoes as $e): ?>
                            <tr>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($e['nome'] ?? ''); ?>"><?php echo htmlspecialchars($e['nome'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($e['inscricao'] ?? ''); ?>"><?php echo htmlspecialchars($e['inscricao'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($e['tipo'] ?? ''); ?>"><?php echo htmlspecialchars($e['tipo'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($e['tag'] ?? ''); ?>"><?php echo htmlspecialchars($e['tag'] ?? ''); ?></td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($e['ano_fabricacao'] ?? ''); ?>"><?php echo htmlspecialchars($e['ano_fabricacao'] ?? ''); ?></td>
                                <td class="table-cell-number"><?php echo number_format($e['capacidade_volumetrica'] ?? 0, 2); ?> m³</td>
                                <td class="table-cell-text" title="<?php echo htmlspecialchars($e['armador'] ?? ''); ?>"><?php echo htmlspecialchars($e['armador'] ?? ''); ?></td>
                                <td class="table-cell-status">
                                    <span class="badge bg-<?php echo $e['status'] === 'ativo' ? 'success' : ($e['status'] === 'inativo' ? 'danger' : 'warning'); ?>">
                                        <?php echo ucfirst($e['status']); ?>
                                    </span>
                                </td>
                                <td class="table-cell-actions">
                                    <div class="btn-group">
                                        <a href="detalhes_embarcacao.php?id=<?php echo $e['id']; ?>" class="btn btn-sm" title="Visualizar">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="form_embarcacao.php?id=<?php echo $e['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="ordens_servico/os.php?tipo=embarcacao&id_equipamento=<?php echo $e['id']; ?>" class="btn btn-sm btn-success" title="Nova OS">
                                            <i class="bi bi-clipboard-plus"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
