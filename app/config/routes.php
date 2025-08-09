<?php
/**
 * Sistema de Rotas
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

class Router {
    private static $routes = [
        '' => ['controller' => 'Auth', 'action' => 'login'],
        'login' => ['controller' => 'Auth', 'action' => 'login'],
        'authenticate' => ['controller' => 'Auth', 'action' => 'authenticate'],
        'logout' => ['controller' => 'Auth', 'action' => 'logout'],
        'change-language' => ['controller' => 'Auth', 'action' => 'changeLanguage'],
        'dashboard' => ['controller' => 'OS', 'action' => 'index'],
        'os/create' => ['controller' => 'OS', 'action' => 'create'],
        'os/store' => ['controller' => 'OS', 'action' => 'store'],
        'os/view' => ['controller' => 'OS', 'action' => 'viewOS'],
        'os/edit' => ['controller' => 'OS', 'action' => 'edit'],
        'os/update' => ['controller' => 'OS', 'action' => 'update'],
        'os/approve' => ['controller' => 'OS', 'action' => 'approve'],
        'os/reject' => ['controller' => 'OS', 'action' => 'reject'],
        'os/finish' => ['controller' => 'OS', 'action' => 'finish'],
        'os/cancel' => ['controller' => 'OS', 'action' => 'cancel'],
        'os/try-again' => ['controller' => 'OS', 'action' => 'tryAgain'],
        'os/give-up' => ['controller' => 'OS', 'action' => 'giveUp'],
        'api/sync' => ['controller' => 'API', 'action' => 'sync'],
        'api/save-offline' => ['controller' => 'API', 'action' => 'saveOffline'],
    ];
    
    public static function route($uri) {
        // Remove query string se existir
        $uri = strtok($uri, '?');
        
        // Remove barras iniciais e finais
        $uri = trim($uri, '/');
        
        if (isset(self::$routes[$uri])) {
            $route = self::$routes[$uri];
            $controllerName = $route['controller'] . 'Controller';
            $action = $route['action'];
            
            if (class_exists($controllerName)) {
                $controller = new $controllerName();
                if (method_exists($controller, $action)) {
                    $controller->$action();
                    return;
                }
            }
        }
        
        // 404 - Página não encontrada
        http_response_code(404);
        include 'views/errors/404.php';
    }
}