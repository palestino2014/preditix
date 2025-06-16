<?php
// Função para log personalizado
if (!function_exists('debug_log')) {
    function debug_log($message) {
        $log_file = __DIR__ . '/../debug_api.log';
        $timestamp = date('Y-m-d H:i:s');
        file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND);
    }
}
?> 