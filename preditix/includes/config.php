<?php
// Configurações do banco de dados
$ambienteIsRemoto = false;

if($ambienteIsRemoto){
    define('DB_HOST', 'localhost');
    define('DB_USER', 'autode51_adm');
    define('DB_PASS', 'bUd@36581259');
    define('DB_NAME', 'autode51_preditix_v5');
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'preditix_v1');
}

// Configurações do sistema
// define('BASE_URL', 'http://localhost/preditix_v1');
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');

// Configura o nome da sessão baseado no banco de dados
session_name('sess_' . DB_NAME);

// Inicia a sessão
session_start();

// Configurações de exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);