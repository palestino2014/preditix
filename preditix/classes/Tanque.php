<?php
require_once __DIR__ . '/Ativo.php';

class Tanque extends Ativo {
    public function cadastrar($dados) {
        // Verificar se já existe um tanque com esta tag
        $sql = "SELECT id FROM tanques WHERE tag = :tag";
        $result = $this->db->query($sql, [':tag' => $dados['tag']]);
        if ($result) {
            throw new Exception("Já existe um tanque cadastrado com esta Tag.");
        }

        $sql = "INSERT INTO tanques (
                tag, fabricante_responsavel, ano_fabricacao, 
                localizacao, capacidade_volumetrica, foto, status
            ) VALUES (
                :tag, :fabricante_responsavel, :ano_fabricacao,
                :localizacao, :capacidade_volumetrica, :foto, :status
            )";
        
        $params = [
            ':tag' => $dados['tag'],
            ':fabricante_responsavel' => $dados['fabricante_responsavel'],
            ':ano_fabricacao' => $dados['ano_fabricacao'],
            ':localizacao' => $dados['localizacao'],
            ':capacidade_volumetrica' => $dados['capacidade_volumetrica'],
            ':foto' => isset($dados['foto']) ? $this->uploadFoto($dados['foto']) : null,
            ':status' => $dados['status'] ?? 'ativo'
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    public function listar() {
        $sql = "SELECT * FROM tanques ORDER BY tag";
        return $this->db->query($sql);
    }
    
    public function buscarPorId($id) {
        $sql = "SELECT * FROM tanques WHERE id = :id";
        $result = $this->db->query($sql, [':id' => $id]);
        return $result ? $result[0] : null;
    }
    
    public function atualizar($id, $dados) {
        $tanque = $this->buscarPorId($id);
        if (!$tanque) {
            throw new Exception("Tanque não encontrado.");
        }

        // Verificar se já existe outro tanque com esta tag
        if ($dados['tag'] !== $tanque['tag']) {
            $sql = "SELECT id FROM tanques WHERE tag = :tag AND id != :id";
            $result = $this->db->query($sql, [
                ':tag' => $dados['tag'],
                ':id' => $id
            ]);
            if ($result) {
                throw new Exception("Já existe um tanque cadastrado com esta Tag.");
            }
        }
        
        $sql = "UPDATE tanques SET 
                tag = :tag,
                fabricante_responsavel = :fabricante_responsavel,
                ano_fabricacao = :ano_fabricacao,
                localizacao = :localizacao,
                capacidade_volumetrica = :capacidade_volumetrica,
                foto = :foto,
                status = :status
                WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':tag' => $dados['tag'],
            ':fabricante_responsavel' => $dados['fabricante_responsavel'],
            ':ano_fabricacao' => $dados['ano_fabricacao'],
            ':localizacao' => $dados['localizacao'],
            ':capacidade_volumetrica' => $dados['capacidade_volumetrica'],
            ':foto' => isset($dados['foto']) ? $this->uploadFoto($dados['foto']) : $tanque['foto'],
            ':status' => $dados['status'] ?? 'ativo'
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    public function excluir($id) {
        $sql = "DELETE FROM tanques WHERE id = :id";
        $params = [':id' => $id];
        return $this->db->execute($sql, $params);
    }
}