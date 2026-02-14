<?php
require_once 'includes/auth.php';
require_once 'classes/Usuario.php';

Auth::checkAuth();
Auth::checkGestor();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: usuarios.php');
    exit();
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id <= 0) {
    header('Location: usuarios.php?erro=ID+inv%C3%A1lido.');
    exit();
}

if ($id === (int)($_SESSION['usuario_id'] ?? 0)) {
    header('Location: usuarios.php?erro=Voc%C3%AA+n%C3%A3o+pode+excluir+seu+pr%C3%B3prio+usu%C3%A1rio.');
    exit();
}

try {
    $usuario = new Usuario();
    $usuario->excluir($id);
    header('Location: usuarios.php?sucesso=Usu%C3%A1rio+exclu%C3%ADdo+com+sucesso.');
    exit();
} catch (Exception $e) {
    header('Location: usuarios.php?erro=N%C3%A3o+foi+poss%C3%ADvel+excluir+o+usu%C3%A1rio.');
    exit();
}
