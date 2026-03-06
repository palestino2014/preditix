<?php
require_once __DIR__ . '/Database.php';

class AlmoxarifadoItem
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function listar()
    {
        $sql = "SELECT id, codigo_barras, nome, quantidade, valor_unitario, data_criacao
                FROM almoxarifado_itens
                ORDER BY nome";
        return $this->db->query($sql);
    }

    public function buscarPorId($id)
    {
        $sql = "SELECT id, codigo_barras, nome, quantidade, valor_unitario
                FROM almoxarifado_itens
                WHERE id = :id";
        $result = $this->db->query($sql, [':id' => $id]);
        if (!$result) {
            throw new Exception("Item não encontrado.");
        }
        return $result[0];
    }

    public function cadastrar($dados)
    {
        $sql = "INSERT INTO almoxarifado_itens (
                    codigo_barras, nome, quantidade, valor_unitario
                ) VALUES (
                    :codigo_barras, :nome, :quantidade, :valor_unitario
                )";

        return $this->db->execute($sql, [
            ':codigo_barras' => $dados['codigo_barras'],
            ':nome' => $dados['nome'],
            ':quantidade' => $dados['quantidade'],
            ':valor_unitario' => $dados['valor_unitario']
        ]);
    }

    public function atualizar($id, $dados)
    {
        $sql = "UPDATE almoxarifado_itens SET
                    codigo_barras = :codigo_barras,
                    nome = :nome,
                    quantidade = :quantidade,
                    valor_unitario = :valor_unitario
                WHERE id = :id";

        return $this->db->execute($sql, [
            ':id' => $id,
            ':codigo_barras' => $dados['codigo_barras'],
            ':nome' => $dados['nome'],
            ':quantidade' => $dados['quantidade'],
            ':valor_unitario' => $dados['valor_unitario']
        ]);
    }

    public function excluir($id)
    {
        $sql = "DELETE FROM almoxarifado_itens WHERE id = :id";
        return $this->db->execute($sql, [':id' => $id]);
    }
}
