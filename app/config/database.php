<?php
/**
 * Configuração do Banco de Dados
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

class Database {
    private static $instance = null;
    private $connection;
    
    // ===== CONFIGURAÇÃO DE AMBIENTE =====
    // Altere esta variável para mudar entre ambientes
    private static $ambiente = 'remoto'; // 'local' ou 'remoto'
    
    // Configurações por ambiente
    private static $configs = [
        'local' => [
            'host' => 'localhost',
            'database' => 'preditix_v1',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8mb4'
        ],
        'remoto' => [
            'host' => 'localhost',
            'database' => 'autode51_preditix_v5',
            'username' => 'autode51_adm',
            'password' => 'bUd@36581259',
            'charset' => 'utf8mb4'
        ]
    ];
    
    private function __construct() {
        try {
            $config = self::$configs[self::$ambiente];
            
            $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (PDOException $e) {
            error_log("Erro de conexão: " . $e->getMessage());
            throw new Exception("Erro de conexão com o banco de dados");
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    public function query($sql, $params = []) {
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Erro na query: " . $e->getMessage());
            throw new Exception("Erro ao executar consulta");
        }
    }
    
    public function lastInsertId() {
        return $this->connection->lastInsertId();
    }
}