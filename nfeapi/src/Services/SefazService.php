<?php

namespace NfeApi\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Monolog\Logger;

class SefazService
{
    private Client $httpClient;
    private Logger $logger;
    private array $sefazEndpoints;

    public function __construct(Client $httpClient, Logger $logger)
    {
        $this->httpClient = $httpClient;
        $this->logger = $logger;
        $this->sefazEndpoints = $this->getSefazEndpoints();
    }

    public function consultarNfe(string $chaveAcesso, string $uf): array
    {
        try {
            $endpoint = $this->getEndpoint($uf, 'consulta');
            
            $response = $this->httpClient->post($endpoint, [
                'json' => [
                    'chave_acesso' => $chaveAcesso,
                    'cnpj_consultante' => $_ENV['CNPJ_CONSULTANTE'],
                    'certificado' => $_ENV['CERTIFICADO_PATH']
                ],
                'timeout' => 30,
                'verify' => true // SSL obrigatório
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            return [
                'success' => true,
                'data' => $data,
                'timestamp' => date('Y-m-d H:i:s'),
                'uf' => $uf
            ];

        } catch (GuzzleException $e) {
            $this->logger->error('Erro ao consultar NFE na SEFAZ', [
                'chave_acesso' => $chaveAcesso,
                'uf' => $uf,
                'error' => $e->getMessage()
            ]);

            throw new \Exception('Erro ao consultar NFE na SEFAZ: ' . $e->getMessage());
        }
    }

    public function validarNfe(string $chaveAcesso, string $uf): array
    {
        try {
            $endpoint = $this->getEndpoint($uf, 'validacao');
            
            $response = $this->httpClient->post($endpoint, [
                'json' => [
                    'chave_acesso' => $chaveAcesso,
                    'cnpj_consultante' => $_ENV['CNPJ_CONSULTANTE'],
                    'certificado' => $_ENV['CERTIFICADO_PATH']
                ],
                'timeout' => 30,
                'verify' => true
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            return [
                'success' => true,
                'valida' => $data['valida'] ?? false,
                'motivo' => $data['motivo'] ?? '',
                'timestamp' => date('Y-m-d H:i:s'),
                'uf' => $uf
            ];

        } catch (GuzzleException $e) {
            $this->logger->error('Erro ao validar NFE na SEFAZ', [
                'chave_acesso' => $chaveAcesso,
                'uf' => $uf,
                'error' => $e->getMessage()
            ]);

            throw new \Exception('Erro ao validar NFE na SEFAZ: ' . $e->getMessage());
        }
    }

    public function verificarStatus(string $chaveAcesso, string $uf): array
    {
        try {
            $endpoint = $this->getEndpoint($uf, 'status');
            
            $response = $this->httpClient->post($endpoint, [
                'json' => [
                    'chave_acesso' => $chaveAcesso,
                    'cnpj_consultante' => $_ENV['CNPJ_CONSULTANTE'],
                    'certificado' => $_ENV['CERTIFICADO_PATH']
                ],
                'timeout' => 30,
                'verify' => true
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            return [
                'success' => true,
                'status' => $data['status'] ?? 'INDEFINIDO',
                'data_autorizacao' => $data['data_autorizacao'] ?? null,
                'protocolo' => $data['protocolo'] ?? null,
                'timestamp' => date('Y-m-d H:i:s'),
                'uf' => $uf
            ];

        } catch (GuzzleException $e) {
            $this->logger->error('Erro ao verificar status da NFE na SEFAZ', [
                'chave_acesso' => $chaveAcesso,
                'uf' => $uf,
                'error' => $e->getMessage()
            ]);

            throw new \Exception('Erro ao verificar status da NFE na SEFAZ: ' . $e->getMessage());
        }
    }

    public function consultarDestinatario(string $chaveAcesso, string $uf): array
    {
        try {
            $endpoint = $this->getEndpoint($uf, 'destinatario');
            
            $response = $this->httpClient->post($endpoint, [
                'json' => [
                    'chave_acesso' => $chaveAcesso,
                    'cnpj_consultante' => $_ENV['CNPJ_CONSULTANTE'],
                    'certificado' => $_ENV['CERTIFICADO_PATH']
                ],
                'timeout' => 30,
                'verify' => true
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            return [
                'success' => true,
                'destinatario' => $data['destinatario'] ?? [],
                'timestamp' => date('Y-m-d H:i:s'),
                'uf' => $uf
            ];

        } catch (GuzzleException $e) {
            $this->logger->error('Erro ao consultar destinatário na SEFAZ', [
                'chave_acesso' => $chaveAcesso,
                'uf' => $uf,
                'error' => $e->getMessage()
            ]);

            throw new \Exception('Erro ao consultar destinatário na SEFAZ: ' . $e->getMessage());
        }
    }

    private function getEndpoint(string $uf, string $tipo): string
    {
        if (!isset($this->sefazEndpoints[$uf])) {
            throw new \InvalidArgumentException("UF não suportada: {$uf}");
        }

        return $this->sefazEndpoints[$uf][$tipo] ?? '';
    }

    private function getSefazEndpoints(): array
    {
        return [
            'SP' => [
                'consulta' => 'https://nfe.fazenda.sp.gov.br/ws/nfeconsulta2.asmx',
                'validacao' => 'https://nfe.fazenda.sp.gov.br/ws/nfevalida.asmx',
                'status' => 'https://nfe.fazenda.sp.gov.br/ws/nfestatus.asmx',
                'destinatario' => 'https://nfe.fazenda.sp.gov.br/ws/nfedestinatario.asmx'
            ],
            'RJ' => [
                'consulta' => 'https://nfe.fazenda.rj.gov.br/ws/nfeconsulta2.asmx',
                'validacao' => 'https://nfe.fazenda.rj.gov.br/ws/nfevalida.asmx',
                'status' => 'https://nfe.fazenda.rj.gov.br/ws/nfestatus.asmx',
                'destinatario' => 'https://nfe.fazenda.rj.gov.br/ws/nfedestinatario.asmx'
            ],
            // Adicionar outros estados conforme necessário
        ];
    }
} 