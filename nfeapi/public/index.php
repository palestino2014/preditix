<?php

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use NfeApi\Middleware\CorsMiddleware;
use NfeApi\Middleware\ErrorMiddleware;
use NfeApi\Routes\NfeRoutes;

require __DIR__ . '/../vendor/autoload.php';

// Carregar variáveis de ambiente
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Configurar container de dependências
$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__ . '/../config/container.php');
$container = $containerBuilder->build();

// Configurar Slim App
$app = AppFactory::createFromContainer($container);

// Adicionar middleware de CORS
$app->add(new CorsMiddleware());

// Adicionar middleware de tratamento de erros
$app->add($container->get(ErrorMiddleware::class));

// Configurar rotas
NfeRoutes::register($app);

// Executar aplicação
$app->run(); 