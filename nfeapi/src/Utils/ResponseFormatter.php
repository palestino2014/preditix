<?php

namespace NfeApi\Utils;

use Psr\Http\Message\ResponseInterface as Response;

class ResponseFormatter
{
    public static function success(Response $response, array $data = [], int $statusCode = 200): Response
    {
        $payload = [
            'success' => true,
            'data' => $data,
            'timestamp' => date('Y-m-d H:i:s'),
            'status_code' => $statusCode
        ];

        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }

    public static function error(Response $response, string $message, int $statusCode = 400): Response
    {
        $payload = [
            'success' => false,
            'error' => [
                'message' => $message,
                'code' => $statusCode
            ],
            'timestamp' => date('Y-m-d H:i:s'),
            'status_code' => $statusCode
        ];

        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($statusCode);
    }

    public static function validationError(Response $response, array $errors): Response
    {
        $payload = [
            'success' => false,
            'error' => [
                'message' => 'Erro de validação',
                'code' => 422,
                'details' => $errors
            ],
            'timestamp' => date('Y-m-d H:i:s'),
            'status_code' => 422
        ];

        $response->getBody()->write(json_encode($payload, JSON_UNESCAPED_UNICODE));
        
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(422);
    }

    public static function notFound(Response $response, string $message = 'Recurso não encontrado'): Response
    {
        return self::error($response, $message, 404);
    }

    public static function unauthorized(Response $response, string $message = 'Não autorizado'): Response
    {
        return self::error($response, $message, 401);
    }

    public static function forbidden(Response $response, string $message = 'Acesso negado'): Response
    {
        return self::error($response, $message, 403);
    }

    public static function serverError(Response $response, string $message = 'Erro interno do servidor'): Response
    {
        return self::error($response, $message, 500);
    }

    public static function rateLimitExceeded(Response $response, string $message = 'Limite de requisições excedido'): Response
    {
        return self::error($response, $message, 429);
    }
} 