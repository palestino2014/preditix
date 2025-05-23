<?php
require_once __DIR__ . '/Ativo.php';

class Embarcacao extends Ativo {
    public function cadastrar($dados) {
        $sql = "INSERT INTO embarcacoes (tipo, tag, inscricao, nome, armador, ano_fabricacao, capacidade_volumetrica, status, foto) 
                VALUES (:tipo, :tag, :inscricao, :nome, :armador, :ano_fabricacao, :capacidade_volumetrica, :status, :foto)";
        
        $params = [
            ':tipo' => $dados['tipo'],
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
        
        $sql = "UPDATE embarcacoes SET 
                tipo = :tipo,
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