<?php
require_once 'includes/init.php';
require_once 'classes/Veiculo.php';

$veiculo = new Veiculo();

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: veiculos.php');
    exit;
}

$veiculo->excluir($id);
header('Location: veiculos.php');
exit;
