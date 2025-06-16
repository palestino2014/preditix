<?php
require_once __DIR__ . '/Database.php';

class Alertas
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Buscar alertas críticos (Seção 1)
     */
    public function getAlertasCriticos()
    {
        $alertas = [];

        // 1. Ordens urgentes/alta prioridade
        $sql = "SELECT 
                    id, numero_os, tipo_equipamento, equipamento_id, 
                    data_abertura, prioridade, status
                FROM ordens_servico 
                WHERE prioridade IN ('urgente', 'alta') 
                AND status IN ('aberta', 'em_andamento')
                ORDER BY prioridade DESC, data_abertura ASC
                LIMIT 10";
        
        $result = $this->db->query($sql);
        if ($result) {
            $alertas['ordens_urgentes'] = $result;
        }

        // 2. Ordens abertas há muito tempo (mais de 30 dias)
        $sql = "SELECT 
                    id, numero_os, tipo_equipamento, equipamento_id,
                    data_abertura, prioridade, status,
                    DATEDIFF(CURDATE(), data_abertura) as dias_aberta
                FROM ordens_servico 
                WHERE status IN ('aberta', 'em_andamento')
                AND DATEDIFF(CURDATE(), data_abertura) > 30
                ORDER BY data_abertura ASC
                LIMIT 10";
        
        $result = $this->db->query($sql);
        if ($result) {
            $alertas['ordens_antigas'] = $result;
        }

        // 3. Equipamentos parados (status inativo ou em manutenção há muito tempo)
        $sql = "SELECT 
                    'embarcacao' as tipo, id, nome as identificacao, status, 
                    data_criacao, DATEDIFF(CURDATE(), data_criacao) as dias_criado
                FROM embarcacoes 
                WHERE status = 'inativo'
                UNION ALL
                SELECT 
                    'veiculo' as tipo, id, placa as identificacao, status,
                    data_criacao, DATEDIFF(CURDATE(), data_criacao) as dias_criado
                FROM veiculos 
                WHERE status = 'inativo'
                UNION ALL
                SELECT 
                    'implemento' as tipo, id, placa as identificacao, status,
                    data_criacao, DATEDIFF(CURDATE(), data_criacao) as dias_criado
                FROM implementos 
                WHERE status = 'inativo'
                UNION ALL
                SELECT 
                    'tanque' as tipo, id, tag as identificacao, status,
                    data_criacao, DATEDIFF(CURDATE(), data_criacao) as dias_criado
                FROM tanques 
                WHERE status = 'inativo'
                ORDER BY dias_criado DESC
                LIMIT 10";
        
        $result = $this->db->query($sql);
        if ($result) {
            $alertas['equipamentos_parados'] = $result;
        }

        return $alertas;
    }

    /**
     * Buscar alertas de tempo (Seção 2)
     */
    public function getAlertasTempo()
    {
        $alertas = [];

        // 1. Ordens abertas há mais de 7 dias
        $sql = "SELECT 
                    id, numero_os, tipo_equipamento, equipamento_id,
                    data_abertura, prioridade, status,
                    DATEDIFF(CURDATE(), data_abertura) as dias_aberta
                FROM ordens_servico 
                WHERE status IN ('aberta', 'em_andamento')
                AND DATEDIFF(CURDATE(), data_abertura) > 7
                AND DATEDIFF(CURDATE(), data_abertura) <= 30
                ORDER BY data_abertura ASC
                LIMIT 10";
        
        $result = $this->db->query($sql);
        if ($result) {
            $alertas['ordens_7_dias'] = $result;
        }

        // 2. Ordens "em andamento" há muito tempo (mais de 15 dias)
        $sql = "SELECT 
                    id, numero_os, tipo_equipamento, equipamento_id,
                    data_abertura, prioridade, status,
                    DATEDIFF(CURDATE(), data_abertura) as dias_aberta
                FROM ordens_servico 
                WHERE status = 'em_andamento'
                AND DATEDIFF(CURDATE(), data_abertura) > 15
                ORDER BY data_abertura ASC
                LIMIT 10";
        
        $result = $this->db->query($sql);
        if ($result) {
            $alertas['ordens_andamento_longo'] = $result;
        }

        // 3. Ordens concluídas hoje
        $sql = "SELECT 
                    id, numero_os, tipo_equipamento, equipamento_id,
                    data_abertura, data_conclusao, prioridade,
                    DATEDIFF(data_conclusao, data_abertura) as dias_duracao
                FROM ordens_servico 
                WHERE status = 'concluida'
                AND DATE(data_conclusao) = CURDATE()
                ORDER BY data_conclusao DESC
                LIMIT 10";
        
        $result = $this->db->query($sql);
        if ($result) {
            $alertas['ordens_concluidas_hoje'] = $result;
        }

        return $alertas;
    }

    /**
     * Buscar estatísticas gerais
     */
    public function getEstatisticas()
    {
        $stats = [];

        // Total de ordens por status
        $sql = "SELECT 
                    status, COUNT(*) as total
                FROM ordens_servico 
                GROUP BY status";
        
        $result = $this->db->query($sql);
        if ($result) {
            $stats['ordens_por_status'] = $result;
        }

        // Ordens urgentes/alta prioridade
        $sql = "SELECT COUNT(*) as total
                FROM ordens_servico 
                WHERE prioridade IN ('urgente', 'alta') 
                AND status IN ('aberta', 'em_andamento')";
        
        $result = $this->db->query($sql);
        if ($result) {
            $stats['ordens_urgentes_total'] = $result[0]['total'];
        }

        // Ordens abertas há mais de 30 dias
        $sql = "SELECT COUNT(*) as total
                FROM ordens_servico 
                WHERE status IN ('aberta', 'em_andamento')
                AND DATEDIFF(CURDATE(), data_abertura) > 30";
        
        $result = $this->db->query($sql);
        if ($result) {
            $stats['ordens_antigas_total'] = $result[0]['total'];
        }

        // Equipamentos inativos
        $sql = "SELECT 
                    (SELECT COUNT(*) FROM embarcacoes WHERE status = 'inativo') +
                    (SELECT COUNT(*) FROM veiculos WHERE status = 'inativo') +
                    (SELECT COUNT(*) FROM implementos WHERE status = 'inativo') +
                    (SELECT COUNT(*) FROM tanques WHERE status = 'inativo') as total";
        
        $result = $this->db->query($sql);
        if ($result) {
            $stats['equipamentos_inativos_total'] = $result[0]['total'];
        }

        return $stats;
    }

    /**
     * Formatar data para exibição
     */
    public function formatarData($data)
    {
        if (!$data) return 'N/A';
        return date('d/m/Y', strtotime($data));
    }

    /**
     * Formatar dias para exibição
     */
    public function formatarDias($dias)
    {
        if ($dias == 1) return '1 dia';
        return $dias . ' dias';
    }

    /**
     * Obter cor baseada na prioridade
     */
    public function getCorPrioridade($prioridade)
    {
        switch ($prioridade) {
            case 'urgente': return 'danger';
            case 'alta': return 'warning';
            case 'media': return 'info';
            case 'baixa': return 'success';
            default: return 'secondary';
        }
    }

    /**
     * Obter ícone baseado no tipo de equipamento
     */
    public function getIconeEquipamento($tipo)
    {
        switch ($tipo) {
            case 'embarcacao': return 'bi-water';
            case 'veiculo': return 'bi-car-front';
            case 'implemento': return 'bi-truck';
            case 'tanque': return 'bi-droplet';
            default: return 'bi-gear';
        }
    }
} 