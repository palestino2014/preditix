<?php
require_once __DIR__ . '/Database.php';

class OrdemServico
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function cadastrar($dados)
    {
        // Processar PDF se enviado
        $pdf_conteudo = null;
        
        if (isset($_FILES['pdf_os']) && $_FILES['pdf_os']['error'] === UPLOAD_ERR_OK) {
            if ($_FILES['pdf_os']['type'] === 'application/pdf') {
                $pdf_conteudo = file_get_contents($_FILES['pdf_os']['tmp_name']);
            } else {
                throw new Exception("Apenas arquivos PDF são aceitos.");
            }
        }

        $sql = "INSERT INTO ordens_servico (
                numero_os, equipamento_id, data_abertura,
                data_prevista, descricao_problema, status, prioridade,
                custo_estimado, usuario_abertura_id, usuario_responsavel_id, pdf
            ) VALUES (
                :numero_os, :equipamento_id, :data_abertura,
                :data_prevista, :descricao_problema, :status, :prioridade,
                :custo_estimado, :usuario_abertura_id, :usuario_responsavel_id, :pdf
            )";

        $params = [
            ':numero_os' => $dados['numero_os'],
            ':equipamento_id' => $dados['equipamento_id'],
            ':data_abertura' => $dados['data_abertura'],
            ':data_prevista' => $dados['data_prevista'],
            ':descricao_problema' => $dados['descricao_problema'],
            ':status' => $dados['status'] ?? 'aberta',
            ':prioridade' => $dados['prioridade'] ?? 'media',
            ':custo_estimado' => $dados['custo_estimado'],
            ':usuario_abertura_id' => $dados['usuario_abertura_id'],
            ':usuario_responsavel_id' => $dados['usuario_responsavel_id'],
            ':pdf' => $pdf_conteudo
        ];

        return $this->db->execute($sql, $params);
    }

    public function listar()
    {
        $sql = "SELECT distinct os.id, os.numero_os, e.nome, os.data_abertura, os.data_prevista, os.data_conclusao, os.status, os.prioridade
                FROM ordens_servico as os
                INNER JOIN embarcacoes as e
                ON os.tipo_equipamento = 'embarcacao' and os.equipamento_id = e.id;";
        return $this->db->query($sql);

    }

    public function buscarPorId($id)
    {
        $sql = "SELECT os.*, 
                u1.nome as usuario_abertura_nome,
                u2.nome as usuario_responsavel_nome
                FROM ordens_servico os
                LEFT JOIN usuarios u1 ON os.usuario_abertura_id = u1.id
                LEFT JOIN usuarios u2 ON os.usuario_responsavel_id = u2.id
                WHERE os.id = :id";
        $result = $this->db->query($sql, [':id' => $id]);
        return $result ? $result[0] : null;
    }

    public function atualizar($id, $dados)
    {
        // Processar PDF se enviado
        $pdf_conteudo = null;
        $sql_pdf = "";
        
        if (isset($_FILES['pdf_os']) && $_FILES['pdf_os']['error'] === UPLOAD_ERR_OK) {
            if ($_FILES['pdf_os']['type'] === 'application/pdf') {
                $pdf_conteudo = file_get_contents($_FILES['pdf_os']['tmp_name']);
                $sql_pdf = ", pdf = :pdf";
            } else {
                throw new Exception("Apenas arquivos PDF são aceitos.");
            }
        }

        $sql = "UPDATE ordens_servico SET 
                data_prevista = :data_prevista,
                data_conclusao = :data_conclusao,
                descricao_solucao = :descricao_solucao,
                status = :status,
                prioridade = :prioridade,
                custo_final = :custo_final,
                usuario_responsavel_id = :usuario_responsavel_id
                $sql_pdf
                WHERE id = :id";

        $params = [
            ':id' => $id,
            ':data_prevista' => $dados['data_prevista'],
            ':data_conclusao' => $dados['data_conclusao'],
            ':descricao_solucao' => $dados['descricao_solucao'],
            ':status' => $dados['status'],
            ':prioridade' => $dados['prioridade'],
            ':custo_final' => $dados['custo_final'],
            ':usuario_responsavel_id' => $dados['usuario_responsavel_id']
        ];

        if ($pdf_conteudo !== null) {
            $params[':pdf'] = $pdf_conteudo;
        }

        return $this->db->execute($sql, $params);
    }

    public function adicionarItem($ordem_servico_id, $dados)
    {
        $sql = "INSERT INTO itens_ordem_servico (
                ordem_servico_id, descricao, quantidade,
                unidade, valor_unitario
            ) VALUES (
                :ordem_servico_id, :descricao, :quantidade,
                :unidade, :valor_unitario
            )";

        $params = [
            ':ordem_servico_id' => $ordem_servico_id,
            ':descricao' => $dados['descricao'],
            ':quantidade' => $dados['quantidade'],
            ':unidade' => $dados['unidade'],
            ':valor_unitario' => $dados['valor_unitario']
        ];

        return $this->db->execute($sql, $params);
    }

    public function listarItens($ordem_servico_id)
    {
        $sql = "SELECT * FROM itens_ordem_servico 
                WHERE ordem_servico_id = :ordem_servico_id
                ORDER BY id";
        return $this->db->query($sql, [':ordem_servico_id' => $ordem_servico_id]);
    }

    public function excluirItem($id)
    {
        $sql = "DELETE FROM itens_ordem_servico WHERE id = :id";
        return $this->db->execute($sql, [':id' => $id]);
    }

    public function excluir($id)
    {
        // Primeiro exclui os itens da ordem
        $sql = "DELETE FROM itens_ordem_servico WHERE ordem_servico_id = :id";
        $this->db->execute($sql, [':id' => $id]);

        // Depois exclui a ordem
        $sql = "DELETE FROM ordens_servico WHERE id = :id";
        return $this->db->execute($sql, [':id' => $id]);
    }

    public function atualizarItem($id, $dados) {
        $sql = "UPDATE itens_ordem_servico SET 
                descricao = :descricao,
                quantidade = :quantidade,
                unidade = :unidade,
                valor_unitario = :valor_unitario
                WHERE id = :id";

        $params = [
            ':id' => $id,
            ':descricao' => $dados['descricao'],
            ':quantidade' => $dados['quantidade'],
            ':unidade' => $dados['unidade'],
            ':valor_unitario' => $dados['valor_unitario']
        ];

        return $this->db->execute($sql, $params);
    }

    public function obterProximoNumeroOS() {
        $ano_atual = date('Y');
        $sql = "SELECT MAX(CAST(SUBSTRING_INDEX(numero_os, '-', -1) AS UNSIGNED)) as ultimo_numero 
                FROM ordens_servico 
                WHERE numero_os LIKE :padrao";
        
        $result = $this->db->query($sql, [':padrao' => "OS-{$ano_atual}-%"]);
        $ultimo_numero = $result[0]['ultimo_numero'] ?? 0;
        
        return $ultimo_numero + 1;
    }
}