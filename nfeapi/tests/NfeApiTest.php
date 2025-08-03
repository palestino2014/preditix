<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use NfeApi\Utils\NfeUtils;

class NfeApiTest extends TestCase
{
    private NfeUtils $nfeUtils;

    protected function setUp(): void
    {
        $this->nfeUtils = new NfeUtils();
    }

    public function testValidarChaveAcessoValida()
    {
        // Chave de acesso válida (exemplo)
        $chaveAcesso = '35150112345678901234567890123456789012345678';
        
        $resultado = $this->nfeUtils->validarChaveAcesso($chaveAcesso);
        
        $this->assertTrue($resultado);
    }

    public function testValidarChaveAcessoInvalida()
    {
        // Chave de acesso inválida (tamanho incorreto)
        $chaveAcesso = '123456789';
        
        $resultado = $this->nfeUtils->validarChaveAcesso($chaveAcesso);
        
        $this->assertFalse($resultado);
    }

    public function testExtrairUf()
    {
        $chaveAcesso = '35150112345678901234567890123456789012345678';
        
        $uf = $this->nfeUtils->extrairUf($chaveAcesso);
        
        $this->assertEquals('SP', $uf);
    }

    public function testExtrairAno()
    {
        $chaveAcesso = '35150112345678901234567890123456789012345678';
        
        $ano = $this->nfeUtils->extrairAno($chaveAcesso);
        
        $this->assertEquals(2015, $ano);
    }

    public function testExtrairMes()
    {
        $chaveAcesso = '35150112345678901234567890123456789012345678';
        
        $mes = $this->nfeUtils->extrairMes($chaveAcesso);
        
        $this->assertEquals(1, $mes);
    }

    public function testExtrairCnpjEmitente()
    {
        $chaveAcesso = '35150112345678901234567890123456789012345678';
        
        $cnpj = $this->nfeUtils->extrairCnpjEmitente($chaveAcesso);
        
        $this->assertEquals('12345678901234', $cnpj);
    }

    public function testValidarCnpjValido()
    {
        $cnpj = '12345678000195';
        
        $resultado = $this->nfeUtils->validarCnpj($cnpj);
        
        $this->assertTrue($resultado);
    }

    public function testValidarCnpjInvalido()
    {
        $cnpj = '12345678901234';
        
        $resultado = $this->nfeUtils->validarCnpj($cnpj);
        
        $this->assertFalse($resultado);
    }

    public function testFormatarCnpj()
    {
        $cnpj = '12345678000195';
        
        $cnpjFormatado = $this->nfeUtils->formatarCnpj($cnpj);
        
        $this->assertEquals('12.345.678/0001-95', $cnpjFormatado);
    }
} 