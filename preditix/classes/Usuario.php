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
}