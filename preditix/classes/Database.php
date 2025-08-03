<?php
require_once __DIR__ . '/../includes/config.php';

class Database {
    private $pdo;
    
    public function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        } catch (PDOException $e) {
            error_log("Erro na conexão com o banco de dados: " . $e->getMessage());
            throw new Exception("Não foi possível conectar ao banco de dados. Por favor, tente novamente mais tarde.");
        }
    }
    
    /**
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return is_array($result) ? $result : [];
        } catch (PDOException $e) {
            error_log("Erro na consulta SQL: " . $e->getMessage() . "\nSQL: " . $sql . "\nParâmetros: " . print_r($params, true));
            throw new Exception("Erro ao buscar dados. Por favor, tente novamente mais tarde.");
        }
    }
    
    public function execute($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Erro na execução SQL: " . $e->getMessage() . "\nSQL: " . $sql . "\nParâmetros: " . print_r($params, true));
            
            // Tratamento específico para erros comuns
            $errorCode = $e->getCode();
            $errorMessage = $e->getMessage();
            
            // Erro de chave única duplicada
            if ($errorCode == 23000 && strpos($errorMessage, 'Duplicate entry') !== false) {
                if (strpos($errorMessage, 'tag') !== false) {
                    throw new Exception("Já existe um equipamento cadastrado com esta Tag.");
                } elseif (strpos($errorMessage, 'placa') !== false) {
                    throw new Exception("Já existe um equipamento cadastrado com esta Placa.");
                } else {
                    throw new Exception("Este registro já existe no sistema.");
                }
            }
            
            // Erro de valor muito grande
            if ($errorCode == 22001) {
                throw new Exception("Algum campo foi preenchido com um valor muito grande.");
            }
            
            // Erro de valor inválido
            if ($errorCode == 22007 || $errorCode == 22008) {
                throw new Exception("Algum campo foi preenchido com um valor inválido.");
            }
            
            // Erro genérico
            throw new Exception("Não foi possível salvar os dados. Por favor, verifique as informações e tente novamente.");
        }
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    /**
     * Inicia uma transação
     * @return bool
     */
    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    /**
     * Confirma uma transação
     * @return bool
     */
    public function commit() {
        return $this->pdo->commit();
    }

    /**
     * Desfaz uma transação
     * @return bool
     */
    public function rollBack() {
        return $this->pdo->rollBack();
    }
}