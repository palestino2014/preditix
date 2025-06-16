<?php
require_once 'config.php';
require_once __DIR__ . '/../classes/Database.php';

class Auth {
    public static function login($email, $senha) {
        $db = new Database();
        
        $sql = "SELECT id, nome, email, senha FROM usuarios WHERE email = :email";
        $result = $db->query($sql, [':email' => $email]);
        
        if ($result && count($result) === 1) {
            $usuario = $result[0];
            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];
                return true;
            }
        }
        
        return false;
    }
    
    public static function logout() {
        session_unset();
        session_destroy();
    }
    
    public static function isLoggedIn() {
        return isset($_SESSION['usuario_id']);
    }
    
    public static function checkAuth() {
        if (!self::isLoggedIn()) {
            // Verificar se headers já foram enviados
            if (!headers_sent()) {
                // Determinar o caminho correto para o login baseado no diretório atual
                $current_dir = dirname($_SERVER['PHP_SELF']);
                if (strpos($current_dir, '/indicadores') !== false) {
                    header('Location: ../login.php');
                } else {
                    header('Location: login.php');
                }
                exit();
            } else {
                // Se headers já foram enviados, usar JavaScript para redirecionar
                $current_dir = dirname($_SERVER['PHP_SELF']);
                if (strpos($current_dir, '/indicadores') !== false) {
                    echo '<script>window.location.href = "../login.php";</script>';
                } else {
                    echo '<script>window.location.href = "login.php";</script>';
                }
                exit();
            }
        }
    }
}