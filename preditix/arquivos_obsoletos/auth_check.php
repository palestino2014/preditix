<?php
// Verificar se estamos na página de login
$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page != 'login.php') {
    // Verificar se o usuário está logado
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: login.php');
        exit();
    }

    // Verificar se a sessão expirou (30 minutos)
    if (isset($_SESSION['ultimo_acesso']) && (time() - $_SESSION['ultimo_acesso'] > 1800)) {
        session_unset();
        session_destroy();
        header('Location: login.php?expired=1');
        exit();
    }

    // Atualizar o tempo do último acesso
    $_SESSION['ultimo_acesso'] = time();
}
?> 