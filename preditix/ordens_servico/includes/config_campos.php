<?php
/**
 * Configuração dos campos específicos para cada tipo de equipamento
 */

// Definição dos arrays base
$sintomas_base = [
    'aberto' => 'Aberto',
    'desvio_lateral' => 'Desvio lateral',
    'queimado' => 'Queimado',
    'sem_freio' => 'Sem freio',
    'sujo' => 'Sujo',
    'vazando' => 'Vazando',
    'baixo_rendimento' => 'Baixo Rendimento',
    'empenado' => 'Empenado',
    'rompido' => 'Rompido',
    'sem_velocidade' => 'Sem velocidade',
    'travado' => 'Travado',
    'vibrando' => 'Vibrando',
    'desarmado' => 'Desarmado',
    'ruido_anormal' => 'Ruído Anormal',
    'solto' => 'Solto',
    'trincado' => 'Trincado'
];

$causas_base = [
    'nao_identificada' => 'Não identificada',
    'defeito_fabrica' => 'Defeito de fábrica',
    'desnivelamento' => 'Desnivelamento',
    'destensionamento' => 'Destensionamento',
    'fissura' => 'Fissura',
    'gasto' => 'Gasto',
    'desalinhamento' => 'Desalinhamento',
    'falta_protecao' => 'Falta de proteção',
    'engripamento' => 'Engripamento',
    'folga' => 'Folga',
    'sobrecarga_peso' => 'Sobrecarga de peso',
    'subdimensionamento' => 'Subdimensionamento',
    'desbalanceamento' => 'Desbalanceamento',
    'desregulamento' => 'Desregulamento',
    'fadiga' => 'Fadiga',
    'fora_especificacao' => 'Fora de especificação',
    'nivel_baixo' => 'Nível Baixo',
    'rompido' => 'Rompido',
    'sobrecarga_tensao' => 'Sobrecarga de tensão'
];

$intervencoes_base = [
    'mecanica' => 'Mecânica',
    'pintura' => 'Pintura',
    'usinagem' => 'Usinagem',
    'eletrica' => 'Elétrica',
    'funilaria' => 'Funilaria',
    'caldeiraria' => 'Caldeiraria',
    'hidraulico' => 'Hidráulico',
    'soldagem' => 'Soldagem'
];

$acoes_base = [
    'acoplado' => 'Acoplado',
    'desacoplado' => 'Desacoplado',
    'instalado' => 'Instalado',
    'rearmado' => 'Rearmado',
    'soldado' => 'Soldado',
    'ajustado' => 'Ajustado',
    'fabricado' => 'Fabricado',
    'limpeza' => 'Limpeza',
    'recuperacao' => 'Recuperação',
    'substituido' => 'Substituído',
    'alinhado' => 'Alinhado',
    'fixado' => 'Fixado',
    'lubrificado' => 'Lubrificado',
    'reposto' => 'Reposto',
    'apertado' => 'Apertado',
    'inspecionado' => 'Inspecionado',
    'modificado' => 'Modificado',
    'retirado' => 'Retirado'
];

// Definição dos sistemas específicos
$sistemas_veiculo = [
    'cabine' => 'Cabine',
    'direcao' => 'Direção',
    'combustivel' => 'Combustível',
    'medicao_controle' => 'Medição de controle',
    'protecao_impactos' => 'Proteção contra impactos',
    'transmissao' => 'Transmissão',
    'estrutural' => 'Estrutural',
    'acoplamento' => 'Acoplamento',
    'controle_eletronico' => 'Controle eletrônico',
    'exaustao' => 'Exaustão',
    'propulsao' => 'Propulsão',
    'protecao_incendio' => 'Proteção contra incêndio',
    'ventilacao' => 'Ventilação',
    'tanque' => 'Tanque',
    'arrefecimento' => 'Arrefecimento',
    'descarga' => 'Descarga',
    'freios' => 'Freios',
    'protecao_ambiental' => 'Proteção ambiental',
    'suspensao' => 'Suspensão',
    'eletrico' => 'Elétrico'
];

// Definição do array principal
$config_campos = [
    'embarcacao' => [
        'sistemas' => [
            'arrefecimento' => 'Sistema de arrefecimento',
            'medicao_controle' => 'Sistema de medição e controle',
            'protecao_ambiental' => 'Sistema de proteção ambiental',
            'estrutural' => 'Estrutura geral',
            'combustivel' => 'Sistema de combustível',
            'exaustao' => 'Sistema de exaustão',
            'protecao_incendio' => 'Sistema de proteção contra incêndio',
            'tanque' => 'Tanque de armazenamento',
            'hidraulico' => 'Sistema hidráulico',
            'motor' => 'Motor',
            'eletrico' => 'Sistema elétrico'
        ],
        'sintomas' => $sintomas_base,
        'causas' => $causas_base,
        'intervencoes' => $intervencoes_base,
        'acoes' => $acoes_base
    ],
    'veiculo' => [
        'sistemas' => $sistemas_veiculo,
        'sintomas' => $sintomas_base,
        'causas' => $causas_base,
        'intervencoes' => $intervencoes_base,
        'acoes' => $acoes_base
    ],
    'implemento' => [
        'sistemas' => $sistemas_veiculo,
        'sintomas' => $sintomas_base,
        'causas' => $causas_base,
        'intervencoes' => $intervencoes_base,
        'acoes' => $acoes_base
    ],
    'tanque' => [
        'sistemas' => [
            'estrutural' => 'Estrutura geral',
            'medicao_controle' => 'Sistema de medição e controle',
            'protecao_ambiental' => 'Sistema de proteção ambiental',
            'combustivel' => 'Sistema de combustível',
            'protecao_incendio' => 'Sistema de proteção contra incêndio',
            'tanque' => 'Tanque de armazenamento',
            'hidraulico' => 'Sistema hidráulico',
            'eletrico' => 'Sistema elétrico'
        ],
        'sintomas' => $sintomas_base,
        'causas' => $causas_base,
        'intervencoes' => $intervencoes_base,
        'acoes' => $acoes_base
    ]
]; 