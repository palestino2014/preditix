<?php
// Página temporária para forçar limpeza de cache

// Headers anti-cache mais agressivos
header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0, private');
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('ETag: "' . md5(time() . rand()) . '"');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Limpeza de Cache - Preditix</title>
    <meta charset="UTF-8">
</head>
<body>
    <h1>🔄 Limpando Cache...</h1>
    <p>Aguarde enquanto forçamos a atualização...</p>
    
    <script>
    // Forçar limpeza completa do cache
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.getRegistrations().then(function(registrations) {
            for(let registration of registrations) {
                console.log('Desregistrando Service Worker...');
                registration.unregister();
            }
        });
    }
    
    // Limpar todos os caches
    if ('caches' in window) {
        caches.keys().then(function(names) {
            for (let name of names) {
                console.log('Deletando cache:', name);
                caches.delete(name);
            }
        });
    }
    
    // Limpar localStorage e sessionStorage
    if (typeof(Storage) !== "undefined") {
        localStorage.clear();
        sessionStorage.clear();
    }
    
    // Aguardar e redirecionar
    setTimeout(() => {
        console.log('Redirecionando para login...');
        window.location.href = 'login?_cache_cleared=' + Date.now();
    }, 3000);
    </script>
</body>
</html>