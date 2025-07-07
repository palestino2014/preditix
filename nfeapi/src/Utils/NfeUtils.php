<?php

namespace NfeApi\Utils;

class NfeUtils
{
    /**
     * Valida o formato da chave de acesso da NFE
     */
    public function validarChaveAcesso(string $chaveAcesso): bool
    {
        // A chave de acesso deve ter exatamente 44 dígitos
        if (strlen($chaveAcesso) !== 44) {
            return false;
        }

        // Deve conter apenas números
        if (!ctype_digit($chaveAcesso)) {
            return false;
        }

        // Validar dígito verificador
        return $this->validarDigitoVerificador($chaveAcesso);
    }

    /**
     * Extrai a UF da chave de acesso
     */
    public function extrairUf(string $chaveAcesso): string
    {
        if (!$this->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // A UF está nas posições 0-1 da chave de acesso
        $codigoUf = substr($chaveAcesso, 0, 2);
        
        return $this->codigoParaUf($codigoUf);
    }

    /**
     * Extrai o ano da chave de acesso
     */
    public function extrairAno(string $chaveAcesso): int
    {
        if (!$this->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // O ano está nas posições 2-3 da chave de acesso
        $ano = substr($chaveAcesso, 2, 2);
        
        return 2000 + (int)$ano;
    }

    /**
     * Extrai o mês da chave de acesso
     */
    public function extrairMes(string $chaveAcesso): int
    {
        if (!$this->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // O mês está nas posições 4-5 da chave de acesso
        return (int)substr($chaveAcesso, 4, 2);
    }

    /**
     * Extrai o CNPJ do emitente da chave de acesso
     */
    public function extrairCnpjEmitente(string $chaveAcesso): string
    {
        if (!$this->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // O CNPJ está nas posições 6-19 da chave de acesso
        return substr($chaveAcesso, 6, 14);
    }

    /**
     * Extrai o modelo da NFE da chave de acesso
     */
    public function extrairModelo(string $chaveAcesso): string
    {
        if (!$this->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // O modelo está nas posições 20-21 da chave de acesso
        return substr($chaveAcesso, 20, 2);
    }

    /**
     * Extrai a série da NFE da chave de acesso
     */
    public function extrairSerie(string $chaveAcesso): string
    {
        if (!$this->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // A série está nas posições 22-25 da chave de acesso
        return substr($chaveAcesso, 22, 4);
    }

    /**
     * Extrai o número da NFE da chave de acesso
     */
    public function extrairNumero(string $chaveAcesso): string
    {
        if (!$this->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // O número está nas posições 26-34 da chave de acesso
        return substr($chaveAcesso, 26, 9);
    }

    /**
     * Extrai o código do tipo de emissão da chave de acesso
     */
    public function extrairTipoEmissao(string $chaveAcesso): string
    {
        if (!$this->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // O tipo de emissão está na posição 35 da chave de acesso
        return substr($chaveAcesso, 35, 1);
    }

    /**
     * Extrai o código numérico da chave de acesso
     */
    public function extrairCodigoNumerico(string $chaveAcesso): string
    {
        if (!$this->validarChaveAcesso($chaveAcesso)) {
            throw new \InvalidArgumentException('Chave de acesso inválida');
        }

        // O código numérico está nas posições 36-43 da chave de acesso
        return substr($chaveAcesso, 36, 8);
    }

    /**
     * Valida o dígito verificador da chave de acesso
     */
    private function validarDigitoVerificador(string $chaveAcesso): bool
    {
        // O dígito verificador está na posição 43 (última posição)
        $digitoVerificador = (int)substr($chaveAcesso, 43, 1);
        
        // Calcula o dígito verificador esperado
        $digitoCalculado = $this->calcularDigitoVerificador(substr($chaveAcesso, 0, 43));
        
        return $digitoVerificador === $digitoCalculado;
    }

    /**
     * Calcula o dígito verificador da chave de acesso
     */
    private function calcularDigitoVerificador(string $chave): int
    {
        $pesos = [4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
        
        $soma = 0;
        for ($i = 0; $i < 43; $i++) {
            $soma += (int)$chave[$i] * $pesos[$i];
        }
        
        $resto = $soma % 11;
        
        if ($resto == 0 || $resto == 1) {
            return 0;
        }
        
        return 11 - $resto;
    }

    /**
     * Converte código da UF para sigla
     */
    private function codigoParaUf(string $codigo): string
    {
        $ufs = [
            '11' => 'RO', '12' => 'AC', '13' => 'AM', '14' => 'RR', '15' => 'PA',
            '16' => 'AP', '17' => 'TO', '21' => 'MA', '22' => 'PI', '23' => 'CE',
            '24' => 'RN', '25' => 'PB', '26' => 'PE', '27' => 'AL', '28' => 'SE',
            '29' => 'BA', '31' => 'MG', '32' => 'ES', '33' => 'RJ', '35' => 'SP',
            '41' => 'PR', '42' => 'SC', '43' => 'RS', '50' => 'MS', '51' => 'MT',
            '52' => 'GO', '53' => 'DF'
        ];

        return $ufs[$codigo] ?? 'XX';
    }

    /**
     * Formata CNPJ com máscara
     */
    public function formatarCnpj(string $cnpj): string
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        return substr($cnpj, 0, 2) . '.' . 
               substr($cnpj, 2, 3) . '.' . 
               substr($cnpj, 5, 3) . '/' . 
               substr($cnpj, 8, 4) . '-' . 
               substr($cnpj, 12, 2);
    }

    /**
     * Valida CNPJ
     */
    public function validarCnpj(string $cnpj): bool
    {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        
        if (strlen($cnpj) != 14) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }

        // Calcula os dígitos verificadores
        for ($i = 0, $j = 5, $soma = 0; $i < 12; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;
        if ($cnpj[12] != ($resto < 2 ? 0 : 11 - $resto)) {
            return false;
        }

        for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++) {
            $soma += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $resto = $soma % 11;
        return $cnpj[13] == ($resto < 2 ? 0 : 11 - $resto);
    }
} 