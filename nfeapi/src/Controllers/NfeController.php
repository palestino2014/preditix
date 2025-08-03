<?php

namespace NfeApi\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use NfeApi\Services\NfeService;
use NfeApi\Validators\NfeValidator;
use NfeApi\Utils\ResponseFormatter;

class NfeController
{
    private NfeService $nfeService;
    private NfeValidator $validator;

    public function __construct(NfeService $nfeService, NfeValidator $validator)
    {
        $this->nfeService = $nfeService;
        $this->validator = $validator;
    }

    public function consultar(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            
            // Validar dados de entrada
            $this->validator->validateConsulta($data);
            
            $result = $this->nfeService->consultarNfe($data['chave_acesso']);
            
            return ResponseFormatter::success($response, $result);
            
        } catch (\Exception $e) {
            return ResponseFormatter::error($response, $e->getMessage(), 400);
        }
    }

    public function validar(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            
            // Validar dados de entrada
            $this->validator->validateValidacao($data);
            
            $result = $this->nfeService->validarNfe($data['chave_acesso']);
            
            return ResponseFormatter::success($response, $result);
            
        } catch (\Exception $e) {
            return ResponseFormatter::error($response, $e->getMessage(), 400);
        }
    }

    public function status(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            
            // Validar dados de entrada
            $this->validator->validateStatus($data);
            
            $result = $this->nfeService->verificarStatus($data['chave_acesso']);
            
            return ResponseFormatter::success($response, $result);
            
        } catch (\Exception $e) {
            return ResponseFormatter::error($response, $e->getMessage(), 400);
        }
    }

    public function consultarDestinatario(Request $request, Response $response): Response
    {
        try {
            $data = $request->getParsedBody();
            
            // Validar dados de entrada
            $this->validator->validateDestinatario($data);
            
            $result = $this->nfeService->consultarDestinatario($data['chave_acesso']);
            
            return ResponseFormatter::success($response, $result);
            
        } catch (\Exception $e) {
            return ResponseFormatter::error($response, $e->getMessage(), 400);
        }
    }
} 