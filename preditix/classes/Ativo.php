<?php
require_once __DIR__ . '/Database.php';

abstract class Ativo {
    protected $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    abstract public function cadastrar($dados);
    abstract public function listar();
    abstract public function buscarPorId($id);
    abstract public function atualizar($id, $dados);
    abstract public function excluir($id);
    
    protected function uploadFoto($file) {
        if ($file['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($file['name'], PATHINFO_EXTENSION);
            $nomeArquivo = uniqid() . '.' . $extensao;
            $caminhoDestino = UPLOAD_DIR . $nomeArquivo;
            
            if (move_uploaded_file($file['tmp_name'], $caminhoDestino)) {
                return $nomeArquivo;
            }
        }
        return null;
    }
    
    protected function removerFoto($nomeArquivo) {
        if ($nomeArquivo && file_exists(UPLOAD_DIR . $nomeArquivo)) {
            unlink(UPLOAD_DIR . $nomeArquivo);
        }
    }
}