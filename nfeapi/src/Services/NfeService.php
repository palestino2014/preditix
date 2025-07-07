<?php

namespace NfeApi\Services;

use GuzzleHttp\Client;
use NfeApi\Services\SefazService;
use NfeApi\Utils\NfeUtils;
use Monolog\Logger;

class NfeService
{
    private SefazService $sefazService;
    private Logger $logger;
    private NfeUtils $nfeUtils;

    public function __construct(SefazService $sefazService, Logger $logger, NfeUtils $nfeUtils)
    {
        $this->sefazService = $sefazService;
        $this->logger = $logger;
        $this->nfeUtils = $nfeUtils;
    }

    public function consultarNfe(string $chaveAcesso): array
    {
        $this->logger->info('Consultando NFE', ['chave_acesso' => $chaveAcesso]);
        
        // Validar formato da chave de acesso
        if (!$this->nfeUtils->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // Identificar UF da NFE
        $uf = $this->nfeUtils->extrairUf($chaveAcesso);
        
        // Consultar na SEFAZ correspondente
        $resultado = $this->sefazService->consultarNfe($chaveAcesso, $uf);
        
        $this->logger->info('Consulta NFE realizada com sucesso', [
            'chave_acesso' => $chaveAcesso,
            'uf' => $uf,
            'status' => $resultado['status'] ?? 'N/A'
        ]);

        return $resultado;
    }

    public function validarNfe(string $chaveAcesso): array
    {
        $this->logger->info('Validando NFE', ['chave_acesso' => $chaveAcesso]);
        
        // Validar formato da chave de acesso
        if (!$this->nfeUtils->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // Identificar UF da NFE
        $uf = $this->nfeUtils->extrairUf($chaveAcesso);
        
        // Validar na SEFAZ correspondente
        $resultado = $this->sefazService->validarNfe($chaveAcesso, $uf);
        
        $this->logger->info('Validação NFE realizada com sucesso', [
            'chave_acesso' => $chaveAcesso,
            'uf' => $uf,
            'valida' => $resultado['valida'] ?? false
        ]);

        return $resultado;
    }

    public function verificarStatus(string $chaveAcesso): array
    {
        $this->logger->info('Verificando status da NFE', ['chave_acesso' => $chaveAcesso]);
        
        // Validar formato da chave de acesso
        if (!$this->nfeUtils->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // Identificar UF da NFE
        $uf = $this->nfeUtils->extrairUf($chaveAcesso);
        
        // Verificar status na SEFAZ correspondente
        $resultado = $this->sefazService->verificarStatus($chaveAcesso, $uf);
        
        $this->logger->info('Status NFE verificado com sucesso', [
            'chave_acesso' => $chaveAcesso,
            'uf' => $uf,
            'status' => $resultado['status'] ?? 'N/A'
        ]);

        return $resultado;
    }

    public function consultarDestinatario(string $chaveAcesso): array
    {
        $this->logger->info('Consultando destinatário da NFE', ['chave_acesso' => $chaveAcesso]);
        
        // Validar formato da chave de acesso
        if (!$this->nfeUtils->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // Identificar UF da NFE
        $uf = $this->nfeUtils->extrairUf($chaveAcesso);
        
        // Consultar destinatário na SEFAZ correspondente
        $resultado = $this->sefazService->consultarDestinatario($chaveAcesso, $uf);
        
        $this->logger->info('Destinatário consultado com sucesso', [
            'chave_acesso' => $chaveAcesso,
            'uf' => $uf,
            'destinatario' => $resultado['destinatario'] ?? 'N/A'
        ]);

        return $resultado;
    }
} 