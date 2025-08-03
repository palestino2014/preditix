<?php

namespace NfeApi\Routes;

use Slim\App;
use NfeApi\Controllers\NfeController;
use NfeApi\Controllers\HealthController;

class NfeRoutes
{
    public static function register(App $app): void
    {
        $container = $app->getContainer();
        
        // Rota de health check
        $app->get('/api/v1/health', [HealthController::class, 'check']);
        
        // Rotas de NFE
        $app->group('/api/v1/nfe', function ($group) use ($container) {
            $group->post('/consultar', [NfeController::class, 'consultar']);
            $group->post('/validar', [NfeController::class, 'validar']);
            $group->post('/status', [NfeController::class, 'status']);
            $group->post('/destinatario', [NfeController::class, 'consultarDestinatario']);
        });
    }
} 