<?php
require_once __DIR__ . '/Database.php';

class Cliente {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function cadastrar($dados) {
        $sql = "INSERT INTO clientes (nome, cnpj, telefone, email, endereco) 
                VALUES (:nome, :cnpj, :telefone, :email, :endereco)";
        
        $params = [
            ':nome' => $dados['nome'],
            ':cnpj' => $dados['cnpj'] ?? null,
            ':telefone' => $dados['telefone'] ?? null,
            ':email' => $dados['email'] ?? null,
            ':endereco' => $dados['endereco'] ?? null
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    public function listar() {
        $sql = "SELECT * FROM clientes ORDER BY nome";
        return $this->db->query($sql);
    }
    
    public function buscarPorId($id) {
        $sql = "SELECT * FROM clientes WHERE id = :id";
        $result = $this->db->query($sql, [':id' => $id]);
        return $result ? $result[0] : null;
    }
    
    public function atualizar($id, $dados) {
        $cliente = $this->buscarPorId($id);
        if (!$cliente) {
            throw new Exception("Cliente não encontrado.");
        }
        
        $sql = "UPDATE clientes SET 
                nome = :nome,
                cnpj = :cnpj,
                telefone = :telefone,
                email = :email,
                endereco = :endereco
                WHERE id = :id";
        
        $params = [
            ':id' => $id,
            ':nome' => $dados['nome'],
            ':cnpj' => $dados['cnpj'] ?? null,
            ':telefone' => $dados['telefone'] ?? null,
            ':email' => $dados['email'] ?? null,
            ':endereco' => $dados['endereco'] ?? null
        ];
        
        return $this->db->execute($sql, $params);
    }
    
    public function excluir($id) {
        // Verificar se o cliente está sendo usado em alguma OS
        $sql = "SELECT COUNT(*) as total FROM ordens_servico WHERE cliente_id = :id";
        $result = $this->db->query($sql, [':id' => $id]);
        
        if ($result && $result[0]['total'] > 0) {
            throw new Exception("Não é possível excluir o cliente pois ele está sendo usado em ordens de serviço.");
        }
        
        $sql = "DELETE FROM clientes WHERE id = :id";
        return $this->db->execute($sql, [':id' => $id]);
    }
    
    public function buscarAtivos() {
        $sql = "SELECT * FROM clientes ORDER BY nome";
        return $this->db->query($sql);
    }
}
