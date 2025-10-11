<?php
require_once __DIR__ . '/Ativo.php';

class Embarcacao extends Ativo {
    public function cadastrar($dados) {
        // Validar subtipo_balsa para balsas
        if (($dados['tipo'] === 'balsa_simples' || $dados['tipo'] === 'balsa_motorizada') && empty($dados['subtipo_balsa'])) {
            throw new Exception("Subtipo da balsa é obrigatório.");
        }
        
        $sql = "INSERT INTO embarcacoes (tipo, subtipo_balsa, tag, inscricao, nome, armador, ano_fabricacao, capacidade_volumetrica, status, foto) 
                VALUES (:tipo, :subtipo_balsa, :tag, :inscricao, :nome, :armador, :ano_fabricacao, :capacidade_volumetrica, :status, :foto)";
        
        $params = [
            ':tipo' => $dados['tipo'],
            ':subtipo_balsa' => $dados['subtipo_balsa'] ?? null,
            ':tag' => $dados['tag'],
            ':inscricao' => $dados['inscricao'],
            ':nome' => $dados['nome'],
            ':armador' => $dados['armador'],
            ':ano_fabricacao' => $dados['ano_fabricacao'],
            ':capacidade_volumetrica' => $dados['capacidade_volumetrica'],
            ':status' => $dados['status'] ?? 'ativo',
            ':foto' => isset($dados['foto']) ? $this->uploadFoto($dados['foto']) : null
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    public function listar() {
        $sql = "SELECT * FROM embarcacoes ORDER BY nome";
        return $this->db->query($sql);
    }
    
    /**
     * @param mixed $id
     * @return array|null
     */
    public function buscarPorId($id) {
        $sql = "SELECT * FROM embarcacoes WHERE id = :id";
        $result = $this->db->query($sql, [':id' => $id]);
        return $result ? $result[0] : null;
    }
    
    public function atualizar($id, $dados) {
        $embarcacao = $this->buscarPorId($id);
        if (!$embarcacao) {
            throw new Exception("Embarcação não encontrada.");
        }
        
        // Validar subtipo_balsa para balsas
        if (($dados['tipo'] === 'balsa_simples' || $dados['tipo'] === 'balsa_motorizada') && empty($dados['subtipo_balsa'])) {
            throw new Exception("Subtipo da balsa é obrigatório.");
        }
        
        $sql = "UPDATE embarcacoes SET 
                tipo = :tipo,
                subtipo_balsa = :subtipo_balsa,
                tag = :tag,
                inscricao = :inscricao,
                nome = :nome,
                armador = :armador,
                ano_fabricacao = :ano_fabricacao,
                capacidade_volumetrica = :capacidade_volumetrica,
                status = :status,
                foto = :foto
                WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':tipo' => $dados['tipo'],
            ':subtipo_balsa' => $dados['subtipo_balsa'] ?? null,
            ':tag' => $dados['tag'],
            ':inscricao' => $dados['inscricao'],
            ':nome' => $dados['nome'],
            ':armador' => $dados['armador'],
            ':ano_fabricacao' => $dados['ano_fabricacao'],
            ':capacidade_volumetrica' => $dados['capacidade_volumetrica'],
            ':status' => $dados['status'] ?? $embarcacao['status'],
            ':foto' => isset($dados['foto']) ? $this->uploadFoto($dados['foto']) : $embarcacao['foto']
        ];
        
        return $this->db->execute($sql, $params);
    }
}