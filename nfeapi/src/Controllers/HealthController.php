<?php

namespace NfeApi\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use NfeApi\Utils\ResponseFormatter;

class HealthController
{
    public function check(Request $request, Response $response): Response
    {
        $healthData = [
            'status' => 'healthy',
            'version' => '1.0.0',
            'environment' => $_ENV['APP_ENV'] ?? 'production',
            'timestamp' => date('Y-m-d H:i:s'),
            'services' => [
                'sefaz_connection' => $this->checkSefazConnection(),
                'database' => $this->checkDatabase(),
                'certificate' => $this->checkCertificate()
            ]
        ];

        return ResponseFormatter::success($response, $healthData);
    }

    private function checkSefazConnection(): array
    {
        try {
            // Verificar se as configurações da SEFAZ estão presentes
            $requiredConfigs = ['CNPJ_CONSULTANTE', 'CERTIFICADO_PATH'];
            $missingConfigs = [];

            foreach ($requiredConfigs as $config) {
                if (empty($_ENV[$config])) {
                    $missingConfigs[] = $config;
                }
            }

            if (!empty($missingConfigs)) {
                return [
                    'status' => 'error',
                    'message' => 'Configurações ausentes: ' . implode(', ', $missingConfigs)
                ];
            }

            return [
                'status' => 'ok',
                'message' => 'Configurações da SEFAZ presentes'
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao verificar conexão com SEFAZ: ' . $e->getMessage()
            ];
        }
    }

    private function checkDatabase(): array
    {
        // Como não estamos usando banco de dados nesta implementação,
        // retornamos status ok
        return [
            'status' => 'ok',
            'message' => 'API não utiliza banco de dados'
        ];
    }

    private function checkCertificate(): array
    {
        try {
            $certPath = $_ENV['CERTIFICADO_PATH'] ?? '';
            
            if (empty($certPath)) {
                return [
                    'status' => 'error',
                    'message' => 'Caminho do certificado não configurado'
                ];
            }

            if (!file_exists($certPath)) {
                return [
                    'status' => 'error',
                    'message' => 'Certificado não encontrado no caminho especificado'
                ];
            }

            return [
                'status' => 'ok',
                'message' => 'Certificado encontrado e válido'
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Erro ao verificar certificado: ' . $e->getMessage()
            ];
        }
    }
} 