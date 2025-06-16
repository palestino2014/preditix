<?php
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/Indicadores.php';
require_once __DIR__ . '/../includes/debug.php';

class BibliotecaGraficos
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Lista todos os gráficos da biblioteca por categoria
     */
    public function listarPorCategoria()
    {
        $sql = "SELECT * FROM biblioteca_graficos 
                WHERE ativo = 1 
                ORDER BY categoria, ordem_exibicao, nome";
        
        $result = $this->db->query($sql);
        
        if (!$result) {
            return [];
        }

        // Agrupar por categoria
        $categorias = [];
        foreach ($result as $grafico) {
            $categoria = $grafico['categoria'];
            if (!isset($categorias[$categoria])) {
                $categorias[$categoria] = [];
            }
            $categorias[$categoria][] = $grafico;
        }

        return $categorias;
    }

    /**
     * Busca um gráfico específico
     */
    public function buscarPorId($id)
    {
        $sql = "SELECT * FROM biblioteca_graficos WHERE id = :id AND ativo = 1";
        $result = $this->db->query($sql, [':id' => $id]);
        return $result ? $result[0] : null;
    }

    /**
     * Lista gráficos favoritos do usuário
     */
    public function listarFavoritos($usuario_id)
    {
        $sql = "SELECT gf.*, bg.nome, bg.descricao, bg.tipo_grafico, bg.configuracao, bg.icone, bg.cor_primaria
                FROM graficos_favoritos gf
                INNER JOIN biblioteca_graficos bg ON gf.grafico_id = bg.id
                WHERE gf.usuario_id = :usuario_id AND gf.ativo = 1
                ORDER BY gf.posicao_y, gf.posicao_x";
        
        return $this->db->query($sql, [':usuario_id' => $usuario_id]) ?: [];
    }

    /**
     * Adiciona gráfico aos favoritos
     */
    public function adicionarFavorito($usuario_id, $grafico_id, $posicao_x = 0, $posicao_y = 0, $largura = 1, $altura = 1)
    {
        // Verificar se já existe
        $sql_check = "SELECT id FROM graficos_favoritos WHERE usuario_id = :usuario_id AND grafico_id = :grafico_id";
        $existe = $this->db->query($sql_check, [':usuario_id' => $usuario_id, ':grafico_id' => $grafico_id]);
        
        if ($existe) {
            // Atualizar posição
            $sql = "UPDATE graficos_favoritos SET 
                        posicao_x = :posicao_x,
                        posicao_y = :posicao_y,
                        largura = :largura,
                        altura = :altura,
                        ativo = 1
                    WHERE usuario_id = :usuario_id AND grafico_id = :grafico_id";
        } else {
            // Inserir novo
            $sql = "INSERT INTO graficos_favoritos (
                        usuario_id, grafico_id, posicao_x, posicao_y, 
                        largura, altura, ativo
                    ) VALUES (
                        :usuario_id, :grafico_id, :posicao_x, :posicao_y,
                        :largura, :altura, 1
                    )";
        }

        $params = [
            ':usuario_id' => $usuario_id,
            ':grafico_id' => $grafico_id,
            ':posicao_x' => $posicao_x,
            ':posicao_y' => $posicao_y,
            ':largura' => $largura,
            ':altura' => $altura
        ];

        return $this->db->execute($sql, $params);
    }

    /**
     * Remove gráfico dos favoritos
     */
    public function removerFavorito($usuario_id, $grafico_id)
    {
        $sql = "UPDATE graficos_favoritos SET ativo = 0 
                WHERE usuario_id = :usuario_id AND grafico_id = :grafico_id";
        
        return $this->db->execute($sql, [':usuario_id' => $usuario_id, ':grafico_id' => $grafico_id]);
    }

    /**
     * Atualiza posições dos gráficos favoritos
     */
    public function atualizarPosicoes($usuario_id, $graficos)
    {
        foreach ($graficos as $grafico) {
            $sql = "UPDATE graficos_favoritos SET 
                        posicao_x = :posicao_x,
                        posicao_y = :posicao_y,
                        largura = :largura,
                        altura = :altura
                    WHERE id = :id AND usuario_id = :usuario_id";
            
            $params = [
                ':id' => $grafico['id'],
                ':usuario_id' => $usuario_id,
                ':posicao_x' => $grafico['posicao_x'],
                ':posicao_y' => $grafico['posicao_y'],
                ':largura' => $grafico['largura'],
                ':altura' => $grafico['altura']
            ];
            
            $this->db->execute($sql, $params);
        }
        
        return true;
    }

    /**
     * Gera dados para um gráfico específico
     */
    public function gerarDadosGrafico($grafico_id)
    {
        debug_log("BibliotecaGraficos::gerarDadosGrafico - ID: $grafico_id");
        
        $grafico = $this->buscarPorId($grafico_id);
        if (!$grafico) {
            debug_log("Gráfico não encontrado na biblioteca: $grafico_id");
            return null;
        }
        
        debug_log("Gráfico encontrado: " . $grafico['nome'] . " - Tipo: " . $grafico['tipo_grafico']);

        $config = json_decode($grafico['configuracao'], true);
        $indicadores = new Indicadores();
        
        switch ($grafico['tipo_grafico']) {
            case 'indicador':
                $dados = $this->gerarDadosIndicador($config, $indicadores, []);
                break;
            case 'linha':
                $dados = $this->gerarDadosLinha($config, $indicadores, []);
                break;
            case 'barras':
                $dados = $this->gerarDadosBarras($config, $indicadores, []);
                break;
            case 'pizza':
                $dados = $this->gerarDadosPizza($config, $indicadores, []);
                break;
            case 'tabela':
                $dados = $this->gerarDadosTabela($config, $indicadores, []);
                break;
            case 'gauge':
                $dados = $this->gerarDadosGauge($config, $indicadores, []);
                break;
            default:
                debug_log("Tipo de gráfico não reconhecido: " . $grafico['tipo_grafico']);
                return null;
        }
        
        debug_log("Dados gerados: " . json_encode($dados));
        return $dados;
    }

    private function gerarDadosIndicador($config, $indicadores, $filtros)
    {
        debug_log("gerarDadosIndicador - Config: " . json_encode($config));
        
        $metrica = $config['metrica'];
        $valor = 0;
        $unidade = '';

        switch ($metrica) {
            case 'mttr':
                debug_log("Calculando MTTR");
                $dados = $indicadores->calcularMTTR($filtros);
                $valor = round($dados['mttr_dias'], 1);
                $unidade = 'dias';
                debug_log("MTTR calculado: $valor dias");
                break;
            case 'mtbf':
                debug_log("Calculando MTBF");
                $dados = $indicadores->calcularMTBF($filtros);
                $valor = round($dados['mtbf_dias'], 1);
                $unidade = 'dias';
                debug_log("MTBF calculado: $valor dias");
                break;
            case 'disponibilidade':
                debug_log("Calculando Disponibilidade");
                $dados = $indicadores->calcularDisponibilidade($filtros);
                $valor = $dados['disponibilidade'];
                $unidade = '%';
                debug_log("Disponibilidade calculada: $valor%");
                break;
            case 'custo_medio_ordem':
                debug_log("Calculando Custo Médio por Ordem");
                $dados = $indicadores->calcularCustos($filtros);
                $valor = $dados['total_ordens'] > 0 ? round($dados['custo_total_final'] / $dados['total_ordens'], 2) : 0;
                $unidade = 'R$';
                debug_log("Custo médio calculado: R$ $valor");
                break;
            default:
                debug_log("Métrica não reconhecida: $metrica");
        }

        $resultado = [
            'tipo' => 'indicador',
            'valor' => $valor,
            'unidade' => $unidade,
            'titulo' => $config['titulo'],
            'subtitulo' => $config['subtitulo'] ?? '',
            'cor' => '#0d6efd'
        ];
        
        debug_log("Resultado indicador: " . json_encode($resultado));
        return $resultado;
    }

    private function gerarDadosLinha($config, $indicadores, $filtros)
    {
        $metrica = $config['metrica'];
        $periodo = $config['periodo'] ?? '12m';
        
        switch ($metrica) {
            case 'mttr_temporal':
                return $this->gerarDadosMTTRTemporal($periodo);
            case 'mtbf_temporal':
                return $this->gerarDadosMTBFTemporal($periodo);
            case 'custos_temporal':
                return $this->gerarDadosCustosTemporal($periodo);
            default:
                return [
                    'tipo' => 'linha',
                    'labels' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
                    'datasets' => [
                        [
                            'label' => $config['titulo'],
                            'data' => [10, 15, 12, 18, 20, 25],
                            'borderColor' => '#0d6efd',
                            'backgroundColor' => 'rgba(13, 110, 253, 0.1)'
                        ]
                    ]
                ];
        }
    }

    private function gerarDadosBarras($config, $indicadores, $filtros)
    {
        $metrica = $config['metrica'];
        
        switch ($metrica) {
            case 'mttr_por_tipo':
                return $this->gerarDadosMTTRPorTipo();
            default:
                return [
                    'tipo' => 'barras',
                    'labels' => ['Embarcações', 'Implementos', 'Tanques', 'Veículos'],
                    'datasets' => [
                        [
                            'label' => $config['titulo'],
                            'data' => [5, 8, 3, 12],
                            'backgroundColor' => ['#0d6efd', '#198754', '#ffc107', '#dc3545']
                        ]
                    ]
                ];
        }
    }

    private function gerarDadosPizza($config, $indicadores, $filtros)
    {
        $metrica = $config['metrica'];
        
        switch ($metrica) {
            case 'custos_por_categoria':
                return $this->gerarDadosCustosPorCategoria();
            case 'ordens_por_status':
                return $this->gerarDadosOrdensPorStatus();
            default:
                return [
                    'tipo' => 'pizza',
                    'labels' => ['Concluída', 'Em Andamento', 'Pendente', 'Cancelada'],
                    'datasets' => [
                        [
                            'data' => [45, 25, 20, 10],
                            'backgroundColor' => ['#198754', '#0d6efd', '#ffc107', '#dc3545']
                        ]
                    ]
                ];
        }
    }

    private function gerarDadosTabela($config, $indicadores, $filtros)
    {
        $metrica = $config['metrica'];
        
        switch ($metrica) {
            case 'top_custosos':
                return $this->gerarDadosTopCustosos();
            case 'ordens_atraso':
                return $this->gerarDadosOrdensAtraso();
            default:
                return [
                    'tipo' => 'tabela',
                    'colunas' => ['Ativo', 'Tipo', 'Custo Total', 'Última Manutenção'],
                    'dados' => [
                        ['Embarcação 001', 'Embarcação', 'R$ 15.000', '2024-01-15'],
                        ['Implemento 002', 'Implemento', 'R$ 8.500', '2024-01-10'],
                        ['Tanque 003', 'Tanque', 'R$ 12.300', '2024-01-08']
                    ]
                ];
        }
    }

    private function gerarDadosGauge($config, $indicadores, $filtros)
    {
        $metrica = $config['metrica'];
        $valor = 0;

        switch ($metrica) {
            case 'disponibilidade':
                $dados = $indicadores->calcularDisponibilidade($filtros);
                $valor = $dados['disponibilidade'];
                break;
        }

        return [
            'tipo' => 'gauge',
            'valor' => $valor,
            'maximo' => 100,
            'titulo' => $config['titulo'],
            'subtitulo' => $config['subtitulo'] ?? '',
            'cor' => $valor >= 80 ? '#198754' : ($valor >= 60 ? '#ffc107' : '#dc3545')
        ];
    }

    // Métodos para gerar dados específicos
    private function gerarDadosMTTRTemporal($periodo)
    {
        $labels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $data = [2.5, 3.2, 2.8, 3.5, 2.9, 3.1, 2.7, 3.3, 2.6, 3.0, 2.4, 2.8];
        
        return [
            'tipo' => 'linha',
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'MTTR (dias)',
                    'data' => $data,
                    'borderColor' => '#dc3545',
                    'backgroundColor' => 'rgba(220, 53, 69, 0.1)',
                    'tension' => 0.4
                ]
            ]
        ];
    }

    private function gerarDadosMTBFTemporal($periodo)
    {
        $labels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $data = [45, 52, 48, 55, 50, 53, 47, 54, 49, 51, 46, 50];
        
        return [
            'tipo' => 'linha',
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'MTBF (dias)',
                    'data' => $data,
                    'borderColor' => '#198754',
                    'backgroundColor' => 'rgba(25, 135, 84, 0.1)',
                    'tension' => 0.4
                ]
            ]
        ];
    }

    private function gerarDadosCustosTemporal($periodo)
    {
        $labels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $data = [15000, 18000, 16500, 22000, 19500, 21000, 17500, 23000, 18500, 20000, 16000, 19000];
        
        return [
            'tipo' => 'linha',
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Custos (R$)',
                    'data' => $data,
                    'borderColor' => '#fd7e14',
                    'backgroundColor' => 'rgba(253, 126, 20, 0.1)',
                    'tension' => 0.4
                ]
            ]
        ];
    }

    private function gerarDadosMTTRPorTipo()
    {
        // Usar dados reais da tabela para MTTR por tipo
        $sql = "SELECT 
                    tipo_equipamento,
                    COUNT(*) as total_ordens,
                    AVG(DATEDIFF(data_conclusao, data_abertura)) as mttr_medio
                FROM ordens_servico 
                WHERE status = 'concluida' 
                AND data_conclusao IS NOT NULL 
                AND data_abertura IS NOT NULL
                AND tipo_equipamento IS NOT NULL
                GROUP BY tipo_equipamento
                HAVING total_ordens > 0
                ORDER BY mttr_medio DESC";
        
        $result = $this->db->query($sql);
        
        if ($result && count($result) > 0) {
            $labels = [];
            $data = [];
            $colors = ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1'];
            
            foreach ($result as $row) {
                $labels[] = ucfirst($row['tipo_equipamento']);
                $data[] = round((float)$row['mttr_medio'], 1);
            }
            
            return [
                'tipo' => 'barras',
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'MTTR (dias)',
                        'data' => $data,
                        'backgroundColor' => array_slice($colors, 0, count($labels))
                    ]
                ]
            ];
        }
        
        // Dados simulados como fallback
        return [
            'tipo' => 'barras',
            'labels' => ['Embarcações', 'Implementos', 'Tanques', 'Veículos'],
            'datasets' => [
                [
                    'label' => 'MTTR (dias)',
                    'data' => [3.2, 2.8, 2.5, 3.5],
                    'backgroundColor' => ['#0d6efd', '#198754', '#ffc107', '#dc3545']
                ]
            ]
        ];
    }

    private function gerarDadosCustosPorCategoria()
    {
        // Dados simulados baseados em estatísticas típicas de manutenção
        return [
            'tipo' => 'pizza',
            'labels' => ['Preventiva', 'Corretiva', 'Preditiva', 'Emergencial'],
            'datasets' => [
                [
                    'data' => [40, 35, 15, 10],
                    'backgroundColor' => ['#198754', '#0d6efd', '#ffc107', '#dc3545']
                ]
            ]
        ];
    }

    private function gerarDadosOrdensPorStatus()
    {
        // Usar dados reais da tabela para status
        $sql = "SELECT 
                    status,
                    COUNT(*) as quantidade
                FROM ordens_servico 
                GROUP BY status
                ORDER BY quantidade DESC";
        
        $result = $this->db->query($sql);
        
        if ($result && count($result) > 0) {
            $labels = [];
            $data = [];
            $colors = ['#198754', '#0d6efd', '#ffc107', '#dc3545', '#6c757d'];
            
            foreach ($result as $row) {
                $status = $row['status'];
                $labels[] = ucfirst(str_replace('_', ' ', $status));
                $data[] = (int)$row['quantidade'];
            }
            
            return [
                'tipo' => 'pizza',
                'labels' => $labels,
                'datasets' => [
                    [
                        'data' => $data,
                        'backgroundColor' => array_slice($colors, 0, count($labels))
                    ]
                ]
            ];
        }
        
        // Dados simulados como fallback
        return [
            'tipo' => 'pizza',
            'labels' => ['Concluída', 'Em Andamento', 'Pendente', 'Cancelada'],
            'datasets' => [
                [
                    'data' => [45, 25, 20, 10],
                    'backgroundColor' => ['#198754', '#0d6efd', '#ffc107', '#dc3545']
                ]
            ]
        ];
    }

    private function gerarDadosTopCustosos()
    {
        // Dados simulados baseados nos equipamentos existentes
        $sql = "SELECT 
                    equipamento_id,
                    tipo_equipamento,
                    COUNT(*) as total_ordens,
                    MAX(data_conclusao) as ultima_manutencao
                FROM ordens_servico 
                WHERE equipamento_id IS NOT NULL
                GROUP BY equipamento_id, tipo_equipamento
                ORDER BY total_ordens DESC
                LIMIT 5";
        
        $result = $this->db->query($sql);
        
        if ($result && count($result) > 0) {
            $colunas = ['Equipamento', 'Tipo', 'Total de Ordens', 'Última Manutenção'];
            $dados = [];
            
            foreach ($result as $row) {
                $custo_estimado = $row['total_ordens'] * 1500; // R$ 1.500 por ordem
                $dados[] = [
                    $row['equipamento_id'] ?? 'N/A',
                    ucfirst($row['tipo_equipamento']),
                    'R$ ' . number_format($custo_estimado, 2, ',', '.'),
                    $row['ultima_manutencao'] ? date('d/m/Y', strtotime($row['ultima_manutencao'])) : 'N/A'
                ];
            }
            
            return [
                'tipo' => 'tabela',
                'colunas' => $colunas,
                'dados' => $dados
            ];
        }
        
        // Dados simulados como fallback
        return [
            'tipo' => 'tabela',
            'colunas' => ['Ativo', 'Tipo', 'Custo Total', 'Última Manutenção'],
            'dados' => [
                ['Embarcação 001', 'Embarcação', 'R$ 15.000', '2024-01-15'],
                ['Implemento 002', 'Implemento', 'R$ 8.500', '2024-01-10'],
                ['Tanque 003', 'Tanque', 'R$ 12.300', '2024-01-08'],
                ['Veículo 004', 'Veículo', 'R$ 6.800', '2024-01-05'],
                ['Embarcação 005', 'Embarcação', 'R$ 9.200', '2024-01-03']
            ]
        ];
    }

    private function gerarDadosOrdensAtraso()
    {
        // Usar dados reais para ordens em atraso
        $sql = "SELECT 
                    numero_os,
                    equipamento_id,
                    DATEDIFF(CURDATE(), data_abertura) as dias_atraso,
                    prioridade
                FROM ordens_servico 
                WHERE status IN ('pendente', 'em_andamento')
                AND data_abertura < DATE_SUB(CURDATE(), INTERVAL 3 DAY)
                ORDER BY dias_atraso DESC
                LIMIT 10";
        
        $result = $this->db->query($sql);
        
        if ($result && count($result) > 0) {
            $colunas = ['Ordem', 'Equipamento', 'Dias Atraso', 'Prioridade'];
            $dados = [];
            
            foreach ($result as $row) {
                $dados[] = [
                    $row['numero_os'] ?? 'N/A',
                    $row['equipamento_id'] ?? 'N/A',
                    $row['dias_atraso'] . ' dias',
                    ucfirst($row['prioridade'] ?? 'Média')
                ];
            }
            
            return [
                'tipo' => 'tabela',
                'colunas' => $colunas,
                'dados' => $dados
            ];
        }
        
        // Dados simulados como fallback
        return [
            'tipo' => 'tabela',
            'colunas' => ['Ordem', 'Equipamento', 'Dias Atraso', 'Prioridade'],
            'dados' => [
                ['2025000001', 'Embarcação 001', '5 dias', 'Alta'],
                ['2025000003', 'Implemento 002', '3 dias', 'Média'],
                ['2025000005', 'Tanque 003', '7 dias', 'Alta'],
                ['2025000007', 'Veículo 004', '2 dias', 'Baixa']
            ]
        ];
    }
} 