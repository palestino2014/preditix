<?php

namespace NfeApi\Validators;

use Respect\Validation\Validator as v;
use NfeApi\Utils\NfeUtils;

class NfeValidator
{
    private NfeUtils $nfeUtils;

    public function __construct(NfeUtils $nfeUtils)
    {
        $this->nfeUtils = $nfeUtils;
    }

    public function validateConsulta(array $data): void
    {
        $validator = v::key('chave_acesso', v::allOf(
            v::notEmpty(),
            v::stringType(),
            v::length(44, 44),
            v::callback(function($value) {
                return $this->nfeUtils->validarChaveAcesso($value);
            })
        ));

        if (!$validator->validate($data)) {
            throw new \InvalidArgumentException('Dados de consulta inválidos');
        }
    }

    public function validateValidacao(array $data): void
    {
        $validator = v::key('chave_acesso', v::allOf(
            v::notEmpty(),
            v::stringType(),
            v::length(44, 44),
            v::callback(function($value) {
                return $this->nfeUtils->validarChaveAcesso($value);
            })
        ));

        if (!$validator->validate($data)) {
            throw new \InvalidArgumentException('Dados de validação inválidos');
        }
    }

    public function validateStatus(array $data): void
    {
        $validator = v::key('chave_acesso', v::allOf(
            v::notEmpty(),
            v::stringType(),
            v::length(44, 44),
            v::callback(function($value) {
                return $this->nfeUtils->validarChaveAcesso($value);
            })
        ));

        if (!$validator->validate($data)) {
            throw new \InvalidArgumentException('Dados de status inválidos');
        }
    }

    public function validateDestinatario(array $data): void
    {
        $validator = v::key('chave_acesso', v::allOf(
            v::notEmpty(),
            v::stringType(),
            v::length(44, 44),
            v::callback(function($value) {
                return $this->nfeUtils->validarChaveAcesso($value);
            })
        ));

        if (!$validator->validate($data)) {
            throw new \InvalidArgumentException('Dados de destinatário inválidos');
        }
    }

    public function validateCnpj(string $cnpj): bool
    {
        return $this->nfeUtils->validarCnpj($cnpj);
    }

    public function validateChaveAcesso(string $chaveAcesso): bool
    {
        return $this->nfeUtils->validarChaveAcesso($chaveAcesso);
    }
} 