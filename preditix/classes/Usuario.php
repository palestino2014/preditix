<?php
require_once __DIR__ . '/Database.php';

class Usuario {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function listar() {
        $sql = "SELECT id, nome FROM usuarios ORDER BY nome";
        return $this->db->query($sql);
    }

    public function listarDetalhado() {
        $sql = "SELECT id, nome, email, nivel_acesso, data_criacao FROM usuarios ORDER BY nome";
        return $this->db->query($sql);
    }

    public function buscarPorId($id) {
        $sql = "SELECT id, nome, email, nivel_acesso FROM usuarios WHERE id = :id";
        $result = $this->db->query($sql, [':id' => $id]);
        if (!$result) {
            throw new Exception("Usuário não encontrado.");
        }
        return $result[0];
    }

    public function cadastrar($dados) {
        $sql = "INSERT INTO usuarios (nome, email, senha, nivel_acesso) VALUES (:nome, :email, :senha, :nivel_acesso)";
        return $this->db->execute($sql, [
            ':nome' => $dados['nome'],
            ':email' => $dados['email'],
            ':senha' => password_hash($dados['senha'], PASSWORD_DEFAULT),
            ':nivel_acesso' => $this->normalizarNivelAcesso($dados['nivel_acesso'])
        ]);
    }

    public function atualizar($id, $dados) {
        $params = [
            ':id' => $id,
            ':nome' => $dados['nome'],
            ':email' => $dados['email'],
            ':nivel_acesso' => $this->normalizarNivelAcesso($dados['nivel_acesso'])
        ];

        if (!empty($dados['senha'])) {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, nivel_acesso = :nivel_acesso WHERE id = :id";
            $params[':senha'] = password_hash($dados['senha'], PASSWORD_DEFAULT);
        } else {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email, nivel_acesso = :nivel_acesso WHERE id = :id";
        }

        return $this->db->execute($sql, $params);
    }

    public function excluir($id) {
        $sql = "DELETE FROM usuarios WHERE id = :id";
        return $this->db->execute($sql, [':id' => $id]);
    }

    private function normalizarNivelAcesso($nivel) {
        if ($nivel === 'admin') {
            return 'gestor';
        }
        if ($nivel === 'usuario') {
            return 'responsavel';
        }
        return $nivel;
    }
}