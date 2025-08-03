<?php

namespace NfeApi\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use NfeApi\Utils\ResponseFormatter;
use Monolog\Logger;

class ErrorMiddleware implements MiddlewareInterface
{
    private Logger $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function process(Request $request, RequestHandlerInterface $handler): Response
    {
        try {
            return $handler->handle($request);
        } catch (\InvalidArgumentException $e) {
            $this->logger->warning('Erro de validação', [
                'error' => $e->getMessage(),
                'uri' => $request->getUri()->getPath(),
                'method' => $request->getMethod()
            ]);

            return ResponseFormatter::error(
                new \Slim\Psr7\Response(),
                $e->getMessage(),
                400
            );
        } catch (\Exception $e) {
            $this->logger->error('Erro interno do servidor', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'uri' => $request->getUri()->getPath(),
                'method' => $request->getMethod()
            ]);

            return ResponseFormatter::serverError(
                new \Slim\Psr7\Response(),
                'Erro interno do servidor'
            );
        }
    }
} 