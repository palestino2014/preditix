<?php
require_once 'includes/auth.php';
require_once 'classes/Database.php';
require_once 'classes/AlmoxarifadoItem.php';

Auth::checkAuth();
Auth::checkGestor();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: almoxarifado.php');
    exit();
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    header('Location: almoxarifado.php?erro=ID+inv%C3%A1lido.');
    exit();
}

try {
    $db = new Database();
    $uso = $db->query("SELECT COUNT(*) as total FROM itens_ordem_servico WHERE almoxarifado_item_id = :id", [':id' => $id]);
    $total = (int)($uso[0]['total'] ?? 0);

    if ($total > 0) {
        header('Location: almoxarifado.php?erro=Item+em+uso+em+ordens+de+servi%C3%A7o.');
        exit();
    }

    $almoxarifado = new AlmoxarifadoItem();
    $almoxarifado->excluir($id);
    header('Location: almoxarifado.php?sucesso=Item+exclu%C3%ADdo+com+sucesso.');
    exit();
} catch (Exception $e) {
    header('Location: almoxarifado.php?erro=N%C3%A3o+foi+poss%C3%ADvel+excluir+o+item.');
    exit();
}
