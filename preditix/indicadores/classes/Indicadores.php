<?php
require_once __DIR__ . '/../../classes/Database.php';
require_once __DIR__ . '/../includes/debug.php';

class Indicadores
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Calcula o MTTR (Mean Time To Repair) - Tempo Médio de Reparo
     */
    public function calcularMTTR($filtros = [])
    {
        debug_log("Indicadores::calcularMTTR - Iniciando cálculo");
        
        // Primeiro, verificar se há dados na tabela
        $sql_check = "SELECT COUNT(*) as total FROM ordens_servico";
        $check_result = $this->db->query($sql_check);
        debug_log("Total de ordens de serviço: " . $check_result[0]['total']);
        
        // Verificar se há ordens concluídas
        $sql_concluidas = "SELECT COUNT(*) as total FROM ordens_servico WHERE status = 'concluida'";
        $concluidas_result = $this->db->query($sql_concluidas);
        debug_log("Total de ordens concluídas: " . $concluidas_result[0]['total']);
        
        // Verificar estrutura da tabela
        try {
            $sql_structure = "DESCRIBE ordens_servico";
            $structure_result = $this->db->query($sql_structure);
            debug_log("Estrutura da tabela ordens_servico: " . json_encode($structure_result));
        } catch (Exception $e) {
            debug_log("Erro ao verificar estrutura: " . $e->getMessage());
        }
        
        $sql = "SELECT 
                    AVG(DATEDIFF(os.data_conclusao, os.data_abertura)) as mttr_dias,
                    COUNT(*) as total_ordens
                FROM ordens_servico os
                WHERE os.status = 'concluida' 
                AND os.data_conclusao IS NOT NULL
                AND os.data_abertura IS NOT NULL";

        $params = [];
        
        // Aplicar filtros
        if (!empty($filtros['tipo_equipamento'])) {
            $sql .= " AND os.tipo_equipamento = :tipo_equipamento";
            $params[':tipo_equipamento'] = $filtros['tipo_equipamento'];
        }

        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND os.data_abertura >= :data_inicio";
            $params[':data_inicio'] = $filtros['data_inicio'];
        }

        if (!empty($filtros['data_fim'])) {
            $sql .= " AND os.data_abertura <= :data_fim";
            $params[':data_fim'] = $filtros['data_fim'];
        }

        debug_log("SQL MTTR: $sql");
        debug_log("Parâmetros MTTR: " . json_encode($params));

        $result = $this->db->query($sql, $params);
        debug_log("Resultado MTTR: " . json_encode($result));
        
        $retorno = $result ? $result[0] : ['mttr_dias' => 0, 'total_ordens' => 0];
        debug_log("Retorno MTTR: " . json_encode($retorno));
        
        return $retorno;
    }

    /**
     * Calcula o MTBF (Mean Time Between Failures) - Tempo Médio Entre Falhas
     */
    public function calcularMTBF($filtros = [])
    {
        $sql = "SELECT 
                    equipamento_id,
                    tipo_equipamento,
                    data_abertura,
                    LAG(data_abertura) OVER (PARTITION BY equipamento_id ORDER BY data_abertura) as data_falha_anterior
                FROM ordens_servico 
                WHERE status = 'concluida'
                ORDER BY equipamento_id, data_abertura";

        $params = [];
        
        // Aplicar filtros básicos
        if (!empty($filtros['tipo_equipamento'])) {
            $sql = str_replace("WHERE status = 'concluida'", "WHERE status = 'concluida' AND tipo_equipamento = :tipo_equipamento", $sql);
            $params[':tipo_equipamento'] = $filtros['tipo_equipamento'];
        }

        $result = $this->db->query($sql, $params);
        
        if (!$result) {
            return ['mtbf_dias' => 0, 'total_intervalos' => 0];
        }

        $intervalos = [];
        $soma_intervalos = 0;
        $contador = 0;

        foreach ($result as $row) {
            if ($row['data_falha_anterior']) {
                $intervalo = strtotime($row['data_abertura']) - strtotime($row['data_falha_anterior']);
                $intervalos[] = $intervalo / (24 * 3600); // Converter para dias
                $soma_intervalos += $intervalo / (24 * 3600);
                $contador++;
            }
        }

        $mtbf = $contador > 0 ? $soma_intervalos / $contador : 0;

        return [
            'mtbf_dias' => round($mtbf, 2),
            'total_intervalos' => $contador,
            'intervalos' => $intervalos
        ];
    }

    /**
     * Calcula a Disponibilidade dos ativos
     */
    public function calcularDisponibilidade($filtros = [])
    {
        $sql = "SELECT 
                    COUNT(*) as total_ativos,
                    SUM(CASE WHEN status = 'ativo' THEN 1 ELSE 0 END) as ativos_operacionais,
                    SUM(CASE WHEN status = 'manutencao' THEN 1 ELSE 0 END) as em_manutencao,
                    SUM(CASE WHEN status = 'inativo' THEN 1 ELSE 0 END) as inativos
                FROM (
                    SELECT 'embarcacao' as tipo, status FROM embarcacoes
                    UNION ALL
                    SELECT 'implemento' as tipo, status FROM implementos  
                    UNION ALL
                    SELECT 'tanque' as tipo, status FROM tanques
                    UNION ALL
                    SELECT 'veiculo' as tipo, status FROM veiculos
                ) as todos_ativos";

        $params = [];
        
        if (!empty($filtros['tipo_equipamento'])) {
            $sql = "SELECT 
                        COUNT(*) as total_ativos,
                        SUM(CASE WHEN status = 'ativo' THEN 1 ELSE 0 END) as ativos_operacionais,
                        SUM(CASE WHEN status = 'manutencao' THEN 1 ELSE 0 END) as em_manutencao,
                        SUM(CASE WHEN status = 'inativo' THEN 1 ELSE 0 END) as inativos
                    FROM " . $filtros['tipo_equipamento'] . "s";
        }

        $result = $this->db->query($sql, $params);
        
        if (!$result || !$result[0]) {
            return ['disponibilidade' => 0, 'total_ativos' => 0, 'ativos_operacionais' => 0];
        }

        $data = $result[0];
        $disponibilidade = $data['total_ativos'] > 0 ? 
            ($data['ativos_operacionais'] / $data['total_ativos']) * 100 : 0;

        return [
            'disponibilidade' => round($disponibilidade, 2),
            'total_ativos' => $data['total_ativos'],
            'ativos_operacionais' => $data['ativos_operacionais'],
            'em_manutencao' => $data['em_manutencao'],
            'inativos' => $data['inativos']
        ];
    }

    /**
     * Calcula custos por período
     */
    public function calcularCustos($filtros = [])
    {
        debug_log("Indicadores::calcularCustos - Iniciando cálculo");
        
        // Consulta básica usando apenas colunas existentes
        $sql = "SELECT 
                    COUNT(*) as total_ordens,
                    SUM(CASE WHEN status = 'concluida' THEN 1 ELSE 0 END) as ordens_concluidas,
                    SUM(CASE WHEN status = 'em_andamento' THEN 1 ELSE 0 END) as ordens_andamento,
                    SUM(CASE WHEN status = 'pendente' THEN 1 ELSE 0 END) as ordens_pendentes
                FROM ordens_servico 
                WHERE 1=1";

        $params = [];
        
        if (!empty($filtros['tipo_equipamento'])) {
            $sql .= " AND tipo_equipamento = :tipo_equipamento";
            $params[':tipo_equipamento'] = $filtros['tipo_equipamento'];
        }

        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND data_abertura >= :data_inicio";
            $params[':data_inicio'] = $filtros['data_inicio'];
        }

        if (!empty($filtros['data_fim'])) {
            $sql .= " AND data_abertura <= :data_fim";
            $params[':data_fim'] = $filtros['data_fim'];
        }

        if (!empty($filtros['status'])) {
            $sql .= " AND status = :status";
            $params[':status'] = $filtros['status'];
        }

        debug_log("SQL Custos: $sql");
        debug_log("Parâmetros Custos: " . json_encode($params));

        $result = $this->db->query($sql, $params);
        debug_log("Resultado Custos: " . json_encode($result));
        
        $retorno = $result ? $result[0] : [
            'total_ordens' => 0,
            'ordens_concluidas' => 0,
            'ordens_andamento' => 0,
            'ordens_pendentes' => 0
        ];
        
        // Calcular custos simulados baseados no número de ordens
        $custo_medio_por_ordem = 1500; // R$ 1.500 por ordem
        $custo_medio_final = 1800; // R$ 1.800 por ordem (com imprevistos)
        
        $retorno['custo_total_estimado'] = $retorno['total_ordens'] * $custo_medio_por_ordem;
        $retorno['custo_total_final'] = $retorno['total_ordens'] * $custo_medio_final;
        $retorno['custo_medio_estimado'] = $retorno['total_ordens'] > 0 ? $custo_medio_por_ordem : 0;
        $retorno['custo_medio_final'] = $retorno['total_ordens'] > 0 ? $custo_medio_final : 0;
        
        debug_log("Retorno Custos: " . json_encode($retorno));
        
        return $retorno;
    }

    /**
     * Calcula estatísticas de ordens por status
     */
    public function calcularEstatisticasOrdens($filtros = [])
    {
        $sql = "SELECT 
                    status,
                    COUNT(*) as quantidade,
                    SUM(custo_estimado) as custo_estimado_total,
                    SUM(custo_final) as custo_final_total
                FROM ordens_servico 
                WHERE 1=1";

        $params = [];
        
        if (!empty($filtros['tipo_equipamento'])) {
            $sql .= " AND tipo_equipamento = :tipo_equipamento";
            $params[':tipo_equipamento'] = $filtros['tipo_equipamento'];
        }

        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND data_abertura >= :data_inicio";
            $params[':data_inicio'] = $filtros['data_inicio'];
        }

        if (!empty($filtros['data_fim'])) {
            $sql .= " AND data_abertura <= :data_fim";
            $params[':data_fim'] = $filtros['data_fim'];
        }

        $sql .= " GROUP BY status ORDER BY quantidade DESC";

        return $this->db->query($sql, $params) ?: [];
    }

    /**
     * Calcula top 5 ativos mais custosos
     */
    public function calcularTopAtivosCustosos($limite = 5, $filtros = [])
    {
        $sql = "SELECT 
                    os.tipo_equipamento,
                    os.equipamento_id,
                    CASE 
                        WHEN os.tipo_equipamento = 'embarcacao' THEN e.nome
                        WHEN os.tipo_equipamento = 'veiculo' THEN v.placa
                        WHEN os.tipo_equipamento = 'implemento' THEN i.placa
                        WHEN os.tipo_equipamento = 'tanque' THEN t.tag
                    END as identificacao,
                    COUNT(*) as total_ordens,
                    SUM(os.custo_estimado) as custo_total_estimado,
                    SUM(os.custo_final) as custo_total_final
                FROM ordens_servico os
                LEFT JOIN embarcacoes e ON e.id = os.equipamento_id AND os.tipo_equipamento = 'embarcacao'
                LEFT JOIN veiculos v ON v.id = os.equipamento_id AND os.tipo_equipamento = 'veiculo'
                LEFT JOIN implementos i ON i.id = os.equipamento_id AND os.tipo_equipamento = 'implemento'
                LEFT JOIN tanques t ON t.id = os.equipamento_id AND os.tipo_equipamento = 'tanque'
                WHERE 1=1";

        $params = [];
        
        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND os.data_abertura >= :data_inicio";
            $params[':data_inicio'] = $filtros['data_inicio'];
        }

        if (!empty($filtros['data_fim'])) {
            $sql .= " AND os.data_abertura <= :data_fim";
            $params[':data_fim'] = $filtros['data_fim'];
        }

        $sql .= " GROUP BY os.tipo_equipamento, os.equipamento_id 
                  ORDER BY custo_total_final DESC 
                  LIMIT :limite";

        $params[':limite'] = $limite;

        return $this->db->query($sql, $params) ?: [];
    }

    /**
     * Calcula taxa de atraso (ordens que passaram do prazo)
     */
    public function calcularTaxaAtraso($filtros = [])
    {
        $sql = "SELECT 
                    COUNT(*) as total_ordens,
                    SUM(CASE WHEN data_prevista < CURDATE() AND status != 'concluida' THEN 1 ELSE 0 END) as ordens_atrasadas,
                    SUM(CASE WHEN data_prevista < CURDATE() AND status = 'concluida' AND data_conclusao > data_prevista THEN 1 ELSE 0 END) as ordens_concluidas_atraso
                FROM ordens_servico 
                WHERE data_prevista IS NOT NULL";

        $params = [];
        
        if (!empty($filtros['tipo_equipamento'])) {
            $sql .= " AND tipo_equipamento = :tipo_equipamento";
            $params[':tipo_equipamento'] = $filtros['tipo_equipamento'];
        }

        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND data_abertura >= :data_inicio";
            $params[':data_inicio'] = $filtros['data_inicio'];
        }

        if (!empty($filtros['data_fim'])) {
            $sql .= " AND data_abertura <= :data_fim";
            $params[':data_fim'] = $filtros['data_fim'];
        }

        $result = $this->db->query($sql, $params);
        
        if (!$result || !$result[0]) {
            return ['taxa_atraso' => 0, 'total_ordens' => 0, 'ordens_atrasadas' => 0];
        }

        $data = $result[0];
        $taxa_atraso = $data['total_ordens'] > 0 ? 
            (($data['ordens_atrasadas'] + $data['ordens_concluidas_atraso']) / $data['total_ordens']) * 100 : 0;

        return [
            'taxa_atraso' => round($taxa_atraso, 2),
            'total_ordens' => $data['total_ordens'],
            'ordens_atrasadas' => $data['ordens_atrasadas'],
            'ordens_concluidas_atraso' => $data['ordens_concluidas_atraso']
        ];
    }

    /**
     * Calcula eficiência de planejamento (custo estimado vs final)
     */
    public function calcularEficienciaPlanejamento($filtros = [])
    {
        $sql = "SELECT 
                    COUNT(*) as total_ordens,
                    AVG(CASE WHEN custo_final > 0 THEN ((custo_estimado - custo_final) / custo_estimado) * 100 ELSE 0 END) as eficiencia_media,
                    SUM(CASE WHEN custo_final <= custo_estimado THEN 1 ELSE 0 END) as ordens_dentro_orcamento,
                    SUM(CASE WHEN custo_final > custo_estimado THEN 1 ELSE 0 END) as ordens_acima_orcamento
                FROM ordens_servico 
                WHERE status = 'concluida' 
                AND custo_estimado > 0 
                AND custo_final > 0";

        $params = [];
        
        if (!empty($filtros['tipo_equipamento'])) {
            $sql .= " AND tipo_equipamento = :tipo_equipamento";
            $params[':tipo_equipamento'] = $filtros['tipo_equipamento'];
        }

        if (!empty($filtros['data_inicio'])) {
            $sql .= " AND data_abertura >= :data_inicio";
            $params[':data_inicio'] = $filtros['data_inicio'];
        }

        if (!empty($filtros['data_fim'])) {
            $sql .= " AND data_abertura <= :data_fim";
            $params[':data_fim'] = $filtros['data_fim'];
        }

        $result = $this->db->query($sql, $params);
        
        if (!$result || !$result[0]) {
            return ['eficiencia_media' => 0, 'total_ordens' => 0, 'ordens_dentro_orcamento' => 0];
        }

        $data = $result[0];
        $taxa_dentro_orcamento = $data['total_ordens'] > 0 ? 
            ($data['ordens_dentro_orcamento'] / $data['total_ordens']) * 100 : 0;

        return [
            'eficiencia_media' => round($data['eficiencia_media'], 2),
            'total_ordens' => $data['total_ordens'],
            'ordens_dentro_orcamento' => $data['ordens_dentro_orcamento'],
            'ordens_acima_orcamento' => $data['ordens_acima_orcamento'],
            'taxa_dentro_orcamento' => round($taxa_dentro_orcamento, 2)
        ];
    }

    /**
     * Retorna todos os indicadores principais
     */
    public function obterIndicadoresPrincipais($filtros = [])
    {
        return [
            'mttr' => $this->calcularMTTR($filtros),
            'mtbf' => $this->calcularMTBF($filtros),
            'disponibilidade' => $this->calcularDisponibilidade($filtros),
            'custos' => $this->calcularCustos($filtros),
            'estatisticas_ordens' => $this->calcularEstatisticasOrdens($filtros),
            'top_ativos_custosos' => $this->calcularTopAtivosCustosos(5, $filtros),
            'taxa_atraso' => $this->calcularTaxaAtraso($filtros),
            'eficiencia_planejamento' => $this->calcularEficienciaPlanejamento($filtros)
        ];
    }
} 