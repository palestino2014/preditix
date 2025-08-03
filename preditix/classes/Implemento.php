<?php
require_once __DIR__ . '/Ativo.php';

class Implemento extends Ativo {
    public function cadastrar($dados) {
        $sql = "INSERT INTO implementos (
                tipo, tag, placa, fabricante, modelo, ano_fabricacao, 
                chassi, renavam, proprietario, tara, lotacao, 
                peso_bruto_total, capacidade_maxima_tracao, 
                capacidade_volumetrica, cor, foto, status
            ) VALUES (
                :tipo, :tag, :placa, :fabricante, :modelo, :ano_fabricacao,
                :chassi, :renavam, :proprietario, :tara, :lotacao,
                :peso_bruto_total, :capacidade_maxima_tracao,
                :capacidade_volumetrica, :cor, :foto, :status
            )";
        
        $params = [
            ':tipo' => $dados['tipo'],
            ':tag' => $dados['tag'],
            ':placa' => $dados['placa'],
            ':fabricante' => $dados['fabricante'],
            ':modelo' => $dados['modelo'],
            ':ano_fabricacao' => $dados['ano_fabricacao'],
            ':chassi' => $dados['chassi'],
            ':renavam' => $dados['renavam'],
            ':proprietario' => $dados['proprietario'],
            ':tara' => $dados['tara'],
            ':lotacao' => $dados['lotacao'],
            ':peso_bruto_total' => $dados['peso_bruto_total'],
            ':capacidade_maxima_tracao' => $dados['capacidade_maxima_tracao'],
            ':capacidade_volumetrica' => $dados['capacidade_volumetrica'],
            ':cor' => $dados['cor'],
            ':foto' => isset($dados['foto']) ? $this->uploadFoto($dados['foto']) : null,
            ':status' => $dados['status'] ?? 'ativo'
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    public function listar() {
        $sql = "SELECT * FROM implementos ORDER BY tag";
        return $this->db->query($sql);
    }
    
    public function buscarPorId($id) {
        $sql = "SELECT * FROM implementos WHERE id = :id";
        $result = $this->db->query($sql, [':id' => $id]);
        return $result ? $result[0] : null;
    }
    
    public function atualizar($id, $dados) {
        $implemento = $this->buscarPorId($id);
        if (!$implemento) {
            return false;
        }
        
        $sql = "UPDATE implementos SET 
                tipo = :tipo,
                tag = :tag,
                placa = :placa,
                fabricante = :fabricante,
                modelo = :modelo,
                ano_fabricacao = :ano_fabricacao,
                chassi = :chassi,
                renavam = :renavam,
                proprietario = :proprietario,
                tara = :tara,
                lotacao = :lotacao,
                peso_bruto_total = :peso_bruto_total,
                capacidade_maxima_tracao = :capacidade_maxima_tracao,
                capacidade_volumetrica = :capacidade_volumetrica,
                cor = :cor,
                foto = :foto,
                status = :status
                WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':tipo' => $dados['tipo'],
            ':tag' => $dados['tag'],
            ':placa' => $dados['placa'],
            ':fabricante' => $dados['fabricante'],
            ':modelo' => $dados['modelo'],
            ':ano_fabricacao' => $dados['ano_fabricacao'],
            ':chassi' => $dados['chassi'],
            ':renavam' => $dados['renavam'],
            ':proprietario' => $dados['proprietario'],
            ':tara' => $dados['tara'],
            ':lotacao' => $dados['lotacao'],
            ':peso_bruto_total' => $dados['peso_bruto_total'],
            ':capacidade_maxima_tracao' => $dados['capacidade_maxima_tracao'],
            ':capacidade_volumetrica' => $dados['capacidade_volumetrica'],
            ':cor' => $dados['cor'],
            ':foto' => isset($dados['foto']) ? $this->uploadFoto($dados['foto']) : $implemento['foto'],
            ':status' => $dados['status'] ?? $implemento['status']
        ];
        
        return $this->db->execute($sql, $params);
    }

    public function buscar($id) {
        $sql = "SELECT * FROM implementos WHERE id = ?";
        $result = $this->db->query($sql, [$id]);
        return $result[0] ?? null;
    }
}