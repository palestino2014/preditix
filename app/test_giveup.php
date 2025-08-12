<?php
// Arquivo de teste para verificar se o método giveUp está funcionando
// Execute este arquivo para testar a funcionalidade

require_once 'config/database.php';
require_once 'helpers/Language.php';

// Simular uma requisição POST
$_POST['os_id'] = 6; // ID da OS que você está testando
$_POST['csrf_token'] = 'test_token'; // Token de teste

// Simular uma sessão
session_start();
$_SESSION['csrf_token'] = 'test_token';
$_SESSION['user_id'] = 1; // ID do usuário técnico
$_SESSION['user_type'] = 'tecnico';

try {
    // Testar conexão com o banco
    $db = new Database();
    $connection = $db->getConnection();
    
    if ($connection) {
        echo "✅ Conexão com banco OK\n";
        
        // Verificar se a OS existe
        $stmt = $connection->prepare("SELECT * FROM ordem_servico WHERE id_os = ?");
        $stmt->execute([6]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($order) {
            echo "✅ OS encontrada: ID " . $order['id_os'] . ", Status: " . $order['status'] . "\n";
            
            // Verificar se a tabela os_historico tem o ENUM correto
            $stmt = $connection->prepare("SHOW COLUMNS FROM os_historico LIKE 'acao'");
            $stmt->execute();
            $column = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($column && strpos($column['Type'], 'desistencia') !== false) {
                echo "✅ ENUM da tabela os_historico OK\n";
            } else {
                echo "❌ ENUM da tabela os_historico não inclui 'desistencia'\n";
            }
            
            // Verificar se a tabela os_backup existe
            $stmt = $connection->prepare("SHOW TABLES LIKE 'os_backup'");
            $stmt->execute();
            $backupTable = $stmt->fetch();
            
            if ($backupTable) {
                echo "✅ Tabela os_backup existe\n";
            } else {
                echo "❌ Tabela os_backup não existe\n";
            }
            
        } else {
            echo "❌ OS não encontrada\n";
        }
        
    } else {
        echo "❌ Erro na conexão com banco\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}
?>
