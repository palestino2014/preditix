<?php
require_once __DIR__ . '/../../classes/Database.php';

class Widget
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Salva um widget personalizado
     */
    public function salvar($dados)
    {
        $sql = "INSERT INTO widgets_dashboard (
                    usuario_id, titulo, tipo_widget, configuracao, 
                    posicao_x, posicao_y, largura, altura, 
                    ativo, data_criacao
                ) VALUES (
                    :usuario_id, :titulo, :tipo_widget, :configuracao,
                    :posicao_x, :posicao_y, :largura, :altura,
                    :ativo, NOW()
                )";

        $params = [
            ':usuario_id' => $dados['usuario_id'],
            ':titulo' => $dados['titulo'],
            ':tipo_widget' => $dados['tipo_widget'],
            ':configuracao' => json_encode($dados['configuracao']),
            ':posicao_x' => $dados['posicao_x'] ?? 0,
            ':posicao_y' => $dados['posicao_y'] ?? 0,
            ':largura' => $dados['largura'] ?? 1,
            ':altura' => $dados['altura'] ?? 1,
            ':ativo' => $dados['ativo'] ?? 1
        ];

        return $this->db->execute($sql, $params);
    }

    /**
     * Atualiza um widget existente
     */
    public function atualizar($id, $dados)
    {
        $sql = "UPDATE widgets_dashboard SET 
                    titulo = :titulo,
                    tipo_widget = :tipo_widget,
                    configuracao = :configuracao,
                    posicao_x = :posicao_x,
                    posicao_y = :posicao_y,
                    largura = :largura,
                    altura = :altura,
                    ativo = :ativo,
                    data_atualizacao = NOW()
                WHERE id = :id AND usuario_id = :usuario_id";

        $params = [
            ':id' => $id,
            ':usuario_id' => $dados['usuario_id'],
            ':titulo' => $dados['titulo'],
            ':tipo_widget' => $dados['tipo_widget'],
            ':configuracao' => json_encode($dados['configuracao']),
            ':posicao_x' => $dados['posicao_x'] ?? 0,
            ':posicao_y' => $dados['posicao_y'] ?? 0,
            ':largura' => $dados['largura'] ?? 1,
            ':altura' => $dados['altura'] ?? 1,
            ':ativo' => $dados['ativo'] ?? 1
        ];

        return $this->db->execute($sql, $params);
    }

    /**
     * Lista widgets de um usuário
     */
    public function listarPorUsuario($usuario_id)
    {
        $sql = "SELECT * FROM widgets_dashboard 
                WHERE usuario_id = :usuario_id AND ativo = 1 
                ORDER BY posicao_y, posicao_x";
        
        return $this->db->query($sql, [':usuario_id' => $usuario_id]) ?: [];
    }

    /**
     * Busca um widget específico
     */
    public function buscarPorId($id, $usuario_id)
    {
        $sql = "SELECT * FROM widgets_dashboard 
                WHERE id = :id AND usuario_id = :usuario_id";
        
        $result = $this->db->query($sql, [':id' => $id, ':usuario_id' => $usuario_id]);
        return $result ? $result[0] : null;
    }

    /**
     * Remove um widget
     */
    public function excluir($id, $usuario_id)
    {
        $sql = "DELETE FROM widgets_dashboard 
                WHERE id = :id AND usuario_id = :usuario_id";
        
        return $this->db->execute($sql, [':id' => $id, ':usuario_id' => $usuario_id]);
    }

    /**
     * Atualiza posições dos widgets
     */
    public function atualizarPosicoes($widgets)
    {
        foreach ($widgets as $widget) {
            $sql = "UPDATE widgets_dashboard SET 
                        posicao_x = :posicao_x,
                        posicao_y = :posicao_y,
                        largura = :largura,
                        altura = :altura
                    WHERE id = :id";
            
            $params = [
                ':id' => $widget['id'],
                ':posicao_x' => $widget['posicao_x'],
                ':posicao_y' => $widget['posicao_y'],
                ':largura' => $widget['largura'],
                ':altura' => $widget['altura']
            ];
            
            $this->db->execute($sql, $params);
        }
        
        return true;
    }

    /**
     * Lista templates disponíveis
     */
    public function listarTemplates()
    {
        $sql = "SELECT * FROM templates_dashboard WHERE ativo = 1 ORDER BY categoria, nome";
        return $this->db->query($sql) ?: [];
    }

    /**
     * Busca template por categoria
     */
    public function buscarTemplatePorCategoria($categoria)
    {
        $sql = "SELECT * FROM templates_dashboard 
                WHERE categoria = :categoria AND ativo = 1 
                LIMIT 1";
        
        $result = $this->db->query($sql, [':categoria' => $categoria]);
        return $result ? $result[0] : null;
    }

    /**
     * Retorna tipos de widgets disponíveis
     */
    public function obterTiposWidgets()
    {
        return [
            'indicador_numerico' => [
                'nome' => 'Indicador Numérico',
                'descricao' => 'Mostra um valor numérico com título e ícone',
                'icone' => 'bi-calculator',
                'configuracoes' => [
                    'metrica' => ['tipo' => 'select', 'opcoes' => ['mttr', 'mtbf', 'disponibilidade', 'custos']],
                    'titulo' => ['tipo' => 'text', 'padrao' => ''],
                    'cor' => ['tipo' => 'color', 'padrao' => '#0d6efd'],
                    'formato' => ['tipo' => 'select', 'opcoes' => ['numero', 'moeda', 'percentual', 'tempo']]
                ]
            ],
            'grafico_linha' => [
                'nome' => 'Gráfico de Linha',
                'descricao' => 'Gráfico de linha para mostrar tendências',
                'icone' => 'bi-graph-up',
                'configuracoes' => [
                    'metrica' => ['tipo' => 'select', 'opcoes' => ['mttr', 'mtbf', 'custos', 'ordens']],
                    'periodo' => ['tipo' => 'select', 'opcoes' => ['7d', '30d', '90d', '1a']],
                    'agrupamento' => ['tipo' => 'select', 'opcoes' => ['dia', 'semana', 'mes']],
                    'cor' => ['tipo' => 'color', 'padrao' => '#0d6efd']
                ]
            ],
            'grafico_barras' => [
                'nome' => 'Gráfico de Barras',
                'descricao' => 'Gráfico de barras para comparações',
                'icone' => 'bi-bar-chart',
                'configuracoes' => [
                    'metrica' => ['tipo' => 'select', 'opcoes' => ['custos_por_tipo', 'ordens_por_status', 'mttr_por_categoria']],
                    'agrupamento' => ['tipo' => 'select', 'opcoes' => ['tipo_equipamento', 'status', 'prioridade']],
                    'limite' => ['tipo' => 'number', 'padrao' => 10],
                    'cores' => ['tipo' => 'array', 'padrao' => ['#0d6efd', '#198754', '#ffc107', '#dc3545']]
                ]
            ],
            'grafico_pizza' => [
                'nome' => 'Gráfico de Pizza',
                'descricao' => 'Gráfico de pizza para distribuições',
                'icone' => 'bi-pie-chart',
                'configuracoes' => [
                    'metrica' => ['tipo' => 'select', 'opcoes' => ['distribuicao_ativos', 'ordens_por_status', 'custos_por_tipo']],
                    'agrupamento' => ['tipo' => 'select', 'opcoes' => ['tipo_equipamento', 'status', 'prioridade']],
                    'mostrar_percentual' => ['tipo' => 'boolean', 'padrao' => true],
                    'limite' => ['tipo' => 'number', 'padrao' => 5]
                ]
            ],
            'tabela' => [
                'nome' => 'Tabela',
                'descricao' => 'Tabela com dados detalhados',
                'icone' => 'bi-table',
                'configuracoes' => [
                    'metrica' => ['tipo' => 'select', 'opcoes' => ['top_ativos_custosos', 'ordens_recentes', 'performance_usuarios']],
                    'colunas' => ['tipo' => 'array', 'padrao' => ['nome', 'valor', 'status']],
                    'limite' => ['tipo' => 'number', 'padrao' => 10],
                    'ordenacao' => ['tipo' => 'select', 'opcoes' => ['asc', 'desc']]
                ]
            ],
            'gauge' => [
                'nome' => 'Medidor (Gauge)',
                'descricao' => 'Medidor circular para valores percentuais',
                'icone' => 'bi-speedometer2',
                'configuracoes' => [
                    'metrica' => ['tipo' => 'select', 'opcoes' => ['disponibilidade', 'taxa_atraso', 'eficiencia_planejamento']],
                    'min' => ['tipo' => 'number', 'padrao' => 0],
                    'max' => ['tipo' => 'number', 'padrao' => 100],
                    'limite_baixo' => ['tipo' => 'number', 'padrao' => 60],
                    'limite_medio' => ['tipo' => 'number', 'padrao' => 80],
                    'limite_alto' => ['tipo' => 'number', 'padrao' => 100]
                ]
            ],
            'alertas' => [
                'nome' => 'Alertas',
                'descricao' => 'Lista de alertas e notificações',
                'icone' => 'bi-exclamation-triangle',
                'configuracoes' => [
                    'tipos_alerta' => ['tipo' => 'array', 'padrao' => ['atraso', 'custo_alto', 'mttr_alto']],
                    'limite' => ['tipo' => 'number', 'padrao' => 5],
                    'mostrar_icone' => ['tipo' => 'boolean', 'padrao' => true],
                    'auto_atualizar' => ['tipo' => 'boolean', 'padrao' => true]
                ]
            ]
        ];
    }

    /**
     * Gera dados para um widget específico
     */
    public function gerarDadosWidget($tipo, $configuracao)
    {
        $indicadores = new Indicadores();
        
        switch ($tipo) {
            case 'indicador_numerico':
                return $this->gerarDadosIndicadorNumerico($configuracao, $indicadores);
            
            case 'grafico_linha':
                return $this->gerarDadosGraficoLinha($configuracao, $indicadores);
            
            case 'grafico_barras':
                return $this->gerarDadosGraficoBarras($configuracao, $indicadores);
            
            case 'grafico_pizza':
                return $this->gerarDadosGraficoPizza($configuracao, $indicadores);
            
            case 'tabela':
                return $this->gerarDadosTabela($configuracao, $indicadores);
            
            case 'gauge':
                return $this->gerarDadosGauge($configuracao, $indicadores);
            
            case 'alertas':
                return $this->gerarDadosAlertas($configuracao, $indicadores);
            
            default:
                return ['erro' => 'Tipo de widget não reconhecido'];
        }
    }

    private function gerarDadosIndicadorNumerico($config, $indicadores)
    {
        $metrica = $config['metrica'] ?? 'mttr';
        $filtros = $config['filtros'] ?? [];
        
        switch ($metrica) {
            case 'mttr':
                $dados = $indicadores->calcularMTTR($filtros);
                return [
                    'valor' => $dados['mttr_dias'],
                    'unidade' => 'dias',
                    'titulo' => $config['titulo'] ?? 'MTTR',
                    'descricao' => 'Tempo Médio de Reparo'
                ];
            
            case 'mtbf':
                $dados = $indicadores->calcularMTBF($filtros);
                return [
                    'valor' => $dados['mtbf_dias'],
                    'unidade' => 'dias',
                    'titulo' => $config['titulo'] ?? 'MTBF',
                    'descricao' => 'Tempo Médio Entre Falhas'
                ];
            
            case 'disponibilidade':
                $dados = $indicadores->calcularDisponibilidade($filtros);
                return [
                    'valor' => $dados['disponibilidade'],
                    'unidade' => '%',
                    'titulo' => $config['titulo'] ?? 'Disponibilidade',
                    'descricao' => 'Percentual de Ativos Operacionais'
                ];
            
            case 'custos':
                $dados = $indicadores->calcularCustos($filtros);
                return [
                    'valor' => $dados['custo_total_final'],
                    'unidade' => 'R$',
                    'titulo' => $config['titulo'] ?? 'Custos Totais',
                    'descricao' => 'Custo Total de Manutenções'
                ];
            
            default:
                return ['erro' => 'Métrica não reconhecida'];
        }
    }

    private function gerarDadosGraficoLinha($config, $indicadores)
    {
        // Implementação básica - pode ser expandida
        return [
            'labels' => ['Jan', 'Fev', 'Mar', 'Abr', 'Mai'],
            'datasets' => [
                [
                    'label' => $config['metrica'] ?? 'MTTR',
                    'data' => [2.1, 2.3, 1.9, 2.5, 2.2],
                    'borderColor' => $config['cor'] ?? '#0d6efd'
                ]
            ]
        ];
    }

    private function gerarDadosGraficoBarras($config, $indicadores)
    {
        $estatisticas = $indicadores->calcularEstatisticasOrdens($config['filtros'] ?? []);
        
        $labels = [];
        $dados = [];
        
        foreach ($estatisticas as $stat) {
            $labels[] = ucfirst($stat['status']);
            $dados[] = $stat['quantidade'];
        }
        
        return [
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Quantidade de Ordens',
                    'data' => $dados,
                    'backgroundColor' => $config['cores'] ?? ['#0d6efd', '#198754', '#ffc107', '#dc3545']
                ]
            ]
        ];
    }

    private function gerarDadosGraficoPizza($config, $indicadores)
    {
        $disponibilidade = $indicadores->calcularDisponibilidade($config['filtros'] ?? []);
        
        return [
            'labels' => ['Operacional', 'Em Manutenção', 'Inativo'],
            'datasets' => [
                [
                    'data' => [
                        $disponibilidade['ativos_operacionais'],
                        $disponibilidade['em_manutencao'],
                        $disponibilidade['inativos']
                    ],
                    'backgroundColor' => ['#198754', '#ffc107', '#dc3545']
                ]
            ]
        ];
    }

    private function gerarDadosTabela($config, $indicadores)
    {
        switch ($config['metrica'] ?? 'top_ativos_custosos') {
            case 'top_ativos_custosos':
                return $indicadores->calcularTopAtivosCustosos($config['limite'] ?? 5, $config['filtros'] ?? []);
            
            default:
                return [];
        }
    }

    private function gerarDadosGauge($config, $indicadores)
    {
        $disponibilidade = $indicadores->calcularDisponibilidade($config['filtros'] ?? []);
        
        return [
            'valor' => $disponibilidade['disponibilidade'],
            'min' => $config['min'] ?? 0,
            'max' => $config['max'] ?? 100,
            'limite_baixo' => $config['limite_baixo'] ?? 60,
            'limite_medio' => $config['limite_medio'] ?? 80,
            'limite_alto' => $config['limite_alto'] ?? 100
        ];
    }

    private function gerarDadosAlertas($config, $indicadores)
    {
        $alertas = [];
        
        // Verificar ordens atrasadas
        $taxa_atraso = $indicadores->calcularTaxaAtraso($config['filtros'] ?? []);
        if ($taxa_atraso['ordens_atrasadas'] > 0) {
            $alertas[] = [
                'tipo' => 'atraso',
                'titulo' => 'Ordens Atrasadas',
                'mensagem' => "{$taxa_atraso['ordens_atrasadas']} ordens estão atrasadas",
                'prioridade' => 'alta',
                'icone' => 'bi-exclamation-triangle-fill'
            ];
        }
        
        // Verificar MTTR alto
        $mttr = $indicadores->calcularMTTR($config['filtros'] ?? []);
        if ($mttr['mttr_dias'] > 3) {
            $alertas[] = [
                'tipo' => 'mttr_alto',
                'titulo' => 'MTTR Alto',
                'mensagem' => "MTTR atual: {$mttr['mttr_dias']} dias",
                'prioridade' => 'media',
                'icone' => 'bi-clock-fill'
            ];
        }
        
        return array_slice($alertas, 0, $config['limite'] ?? 5);
    }
} 