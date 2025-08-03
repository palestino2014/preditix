<?php
/**
 * Arquivo Principal - Ponto de Entrada
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

// Configurações gerais
ini_set('display_errors', 0);
error_reporting(E_ALL);
date_default_timezone_set('America/Sao_Paulo');

// Iniciar sessão
session_start();

// Cabeçalhos anti-cache para prevenir cache de conteúdo dinâmico
header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0, private');
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('ETag: "' . md5(time() . rand()) . '"');

// Autoloader simples
function autoload($className) {
    $paths = [
        'controllers/',
        'models/',
        'config/',
        'helpers/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
}

spl_autoload_register('autoload');

// Carregar configurações
require_once 'config/database.php';
require_once 'config/routes.php';
require_once 'helpers/Language.php';

// Inicializar idioma
Language::initialize();

// Processar rota
$url = isset($_GET['url']) ? $_GET['url'] : '';
Router::route($url);