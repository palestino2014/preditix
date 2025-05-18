<?php
// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'preditix_v1');

// Configurações do sistema
// define('BASE_URL', 'http://localhost/preditix_v1');
define('UPLOAD_DIR', __DIR__ . '/../assets/uploads/');

// Inicia a sessão
session_start();

// Configurações de exibição de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);