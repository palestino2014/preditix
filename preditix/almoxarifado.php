<?php
require_once 'includes/auth.php';
require_once 'classes/AlmoxarifadoItem.php';

Auth::checkAuth();

$almoxarifado = new AlmoxarifadoItem();
$itens = $almoxarifado->listar();
$titulo = 'Almoxarifado';
$usuario_gestor = Auth::isGestor();

include 'includes/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?php echo $titulo; ?></h1>
        <?php if ($usuario_gestor): ?>
            <a href="form_almoxarifado_item.php" class="btn btn-primary">
                <i class="bi bi-plus"></i> Novo Item
            </a>
        <?php endif; ?>
    </div>

    <?php if (!empty($_GET['erro'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php echo htmlspefcialchars($_GET['erro']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (!empty($_GET['sucesso'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_GET['sucesso']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Cód. de Barras</th>
                            <th>Nome</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($itens as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['codigo_barras'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($item['nome']); ?></td>
                                <td><?php echo number_format($item['quantidade'], 2, ',', '.'); ?></td>
                                <td>R$ <?php echo number_format($item['valor_unitario'], 2, ',', '.'); ?></td>
                                <td>
                                    <?php if ($usuario_gestor): ?>
                                        <div class="btn-group">
                                            <a href="form_almoxarifado_item.php?id=<?php echo $item['id']; ?>" class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="delete_almoxarifado_item.php" onsubmit="return confirm('Tem certeza que deseja excluir este item?');">
                                                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Excluir">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted"></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
