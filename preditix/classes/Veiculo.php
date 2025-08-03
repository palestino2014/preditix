<?php
require_once __DIR__ . '/Ativo.php';

class Veiculo extends Ativo {
    public function listar() {
        $sql = "SELECT * FROM veiculos ORDER BY tag";
        return $this->db->query($sql);
    }

    public function buscarPorId($id) {
        $sql = "SELECT * FROM veiculos WHERE id = :id";
        $params = [':id' => $id];
        $result = $this->db->query($sql, $params);
        return $result[0] ?? [];
    }

    public function cadastrar($dados) {
        // Verificar se já existe um veículo com esta tag
        $sql = "SELECT id FROM veiculos WHERE tag = :tag";
        $result = $this->db->query($sql, [':tag' => $dados['tag']]);
        if ($result) {
            throw new Exception("Já existe um veículo cadastrado com esta Tag.");
        }

        // Verificar se já existe um veículo com esta placa
        $sql = "SELECT id FROM veiculos WHERE placa = :placa";
        $result = $this->db->query($sql, [':placa' => $dados['placa']]);
        if ($result) {
            throw new Exception("Já existe um veículo cadastrado com esta Placa.");
        }

        $sql = "INSERT INTO veiculos (
            tipo, tag, placa, fabricante, modelo, ano_fabricacao,
            chassi, renavam, proprietario, tara, lotacao,
            peso_bruto_total, peso_bruto_total_combinado,
            capacidade_maxima_tracao, cor, foto, status
        ) VALUES (
            :tipo, :tag, :placa, :fabricante, :modelo, :ano_fabricacao,
            :chassi, :renavam, :proprietario, :tara, :lotacao,
            :peso_bruto_total, :peso_bruto_total_combinado,
            :capacidade_maxima_tracao, :cor, :foto, :status
        )";

        $params = [
            ':tipo' => $dados['tipo'],
            ':tag' => $dados['tag'],
            ':placa' => $dados['placa'],
            ':fabricante' => $dados['fabricante'],
            ':modelo' => $dados['modelo'],
            ':ano_fabricacao' => $dados['ano_fabricacao'],
            ':chassi' => $dados['chassi'] ?? null,
            ':renavam' => $dados['renavam'] ?? null,
            ':proprietario' => $dados['proprietario'],
            ':tara' => $dados['tara'],
            ':lotacao' => $dados['lotacao'],
            ':peso_bruto_total' => $dados['peso_bruto_total'],
            ':peso_bruto_total_combinado' => $dados['peso_bruto_total_combinado'],
            ':capacidade_maxima_tracao' => $dados['capacidade_maxima_tracao'],
            ':cor' => $dados['cor'] ?? null,
            ':foto' => isset($dados['foto']) ? $this->uploadFoto($dados['foto']) : null,
            ':status' => $dados['status'] ?? 'ativo'
        ];

        return $this->db->execute($sql, $params);
    }

    public function atualizar($id, $dados) {
        $veiculo = $this->buscarPorId($id);
        if (!$veiculo) {
            throw new Exception("Veículo não encontrado.");
        }

        // Verificar se já existe outro veículo com esta tag
        if ($dados['tag'] !== $veiculo['tag']) {
            $sql = "SELECT id FROM veiculos WHERE tag = :tag AND id != :id";
            $result = $this->db->query($sql, [
                ':tag' => $dados['tag'],
                ':id' => $id
            ]);
            if ($result) {
                throw new Exception("Já existe um veículo cadastrado com esta Tag.");
            }
        }

        // Verificar se já existe outro veículo com esta placa
        if ($dados['placa'] !== $veiculo['placa']) {
            $sql = "SELECT id FROM veiculos WHERE placa = :placa AND id != :id";
            $result = $this->db->query($sql, [
                ':placa' => $dados['placa'],
                ':id' => $id
            ]);
            if ($result) {
                throw new Exception("Já existe um veículo cadastrado com esta Placa.");
            }
        }

        $sql = "UPDATE veiculos SET
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
            peso_bruto_total_combinado = :peso_bruto_total_combinado,
            capacidade_maxima_tracao = :capacidade_maxima_tracao,
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
            ':chassi' => $dados['chassi'] ?? null,
            ':renavam' => $dados['renavam'] ?? null,
            ':proprietario' => $dados['proprietario'],
            ':tara' => $dados['tara'],
            ':lotacao' => $dados['lotacao'],
            ':peso_bruto_total' => $dados['peso_bruto_total'],
            ':peso_bruto_total_combinado' => $dados['peso_bruto_total_combinado'],
            ':capacidade_maxima_tracao' => $dados['capacidade_maxima_tracao'],
            ':cor' => $dados['cor'] ?? null,
            ':foto' => isset($dados['foto']) ? $this->uploadFoto($dados['foto']) : $veiculo['foto'],
            ':status' => $dados['status'] ?? 'ativo'
        ];

        return $this->db->execute($sql, $params);
    }
}