<?php

use GuzzleHttp\Client;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use NfeApi\Services\NfeService;
use NfeApi\Services\SefazService;
use NfeApi\Utils\NfeUtils;
use NfeApi\Validators\NfeValidator;
use NfeApi\Middleware\ErrorMiddleware;

return [
    // Configuração do Logger
    Logger::class => \DI\factory(function () {
        $logger = new Logger('nfeapi');
        
        // Criar pasta de logs se não existir
        $logDir = __DIR__ . '/../logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }
        
        // Log de erros
        $logger->pushHandler(new StreamHandler(
            $logDir . '/error.log',
            Logger::ERROR
        ));
        
        // Log de acesso
        $logger->pushHandler(new StreamHandler(
            $logDir . '/access.log',
            Logger::INFO
        ));
        
        // Log da SEFAZ
        $logger->pushHandler(new StreamHandler(
            $logDir . '/sefaz.log',
            Logger::DEBUG
        ));
        
        return $logger;
    }),

    // Configuração do HTTP Client
    Client::class => \DI\factory(function () {
        return new Client([
            'timeout' => $_ENV['HTTP_TIMEOUT'] ?? 60,
            'verify' => true, // SSL obrigatório
            'headers' => [
                'User-Agent' => 'NFE-API/1.0',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
    }),

    // Configuração do SefazService
    SefazService::class => \DI\autowire()
        ->constructorParameter('httpClient', \DI\get(Client::class))
        ->constructorParameter('logger', \DI\get(Logger::class)),

    // Configuração do NfeUtils
    NfeUtils::class => \DI\autowire(),

    // Configuração do NfeValidator
    NfeValidator::class => \DI\autowire()
        ->constructorParameter('nfeUtils', \DI\get(NfeUtils::class)),

    // Configuração do NfeService
    NfeService::class => \DI\autowire()
        ->constructorParameter('sefazService', \DI\get(SefazService::class))
        ->constructorParameter('logger', \DI\get(Logger::class))
        ->constructorParameter('nfeUtils', \DI\get(NfeUtils::class)),

    // Configuração do ErrorMiddleware
    ErrorMiddleware::class => \DI\autowire()
        ->constructorParameter('logger', \DI\get(Logger::class)),
]; 