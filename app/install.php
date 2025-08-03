<?php
/**
 * Script de Instalação
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

// Verificar se já foi instalado
if (file_exists('config/installed.lock')) {
    die('Sistema já foi instalado. Remova o arquivo config/installed.lock para reinstalar.');
}

$step = $_GET['step'] ?? 1;
$error = '';
$success = '';

// Processar formulários
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'test_db':
            $result = testDatabase($_POST);
            if ($result['success']) {
                $success = 'Conexão com banco de dados bem-sucedida!';
                $step = 3;
            } else {
                $error = $result['error'];
            }
            break;
            
        case 'create_tables':
            $result = createTables($_POST);
            if ($result['success']) {
                $success = 'Tabelas criadas com sucesso!';
                $step = 4;
            } else {
                $error = $result['error'];
            }
            break;
            
        case 'finish_install':
            $result = finishInstallation($_POST);
            if ($result['success']) {
                header('Location: /login');
                exit;
            } else {
                $error = $result['error'];
            }
            break;
    }
}

function testDatabase($data) {
    try {
        $dsn = "mysql:host={$data['db_host']};dbname={$data['db_name']};charset=utf8mb4";
        $pdo = new PDO($dsn, $data['db_user'], $data['db_pass']);
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'error' => 'Erro de conexão: ' . $e->getMessage()];
    }
}

function createTables($data) {
    try {
        $dsn = "mysql:host={$data['db_host']};dbname={$data['db_name']};charset=utf8mb4";
        $pdo = new PDO($dsn, $data['db_user'], $data['db_pass']);
        
        $sql = file_get_contents('database/schema.sql');
        $pdo->exec($sql);
        
        // Salvar configuração do banco
        $config = "<?php\n";
        $config .= "// Configuração gerada automaticamente\n";
        $config .= "class Database {\n";
        $config .= "    private static \$instance = null;\n";
        $config .= "    private \$connection;\n";
        $config .= "    private \$host = '{$data['db_host']}';\n";
        $config .= "    private \$database = '{$data['db_name']}';\n";
        $config .= "    private \$username = '{$data['db_user']}';\n";
        $config .= "    private \$password = '{$data['db_pass']}';\n";
        $config .= "    private \$charset = 'utf8mb4';\n";
        $config .= "    // ... resto da classe permanece igual\n";
        $config .= "}\n";
        
        // Não sobrescrever, deixar que o usuário configure manualmente
        
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'error' => 'Erro ao criar tabelas: ' . $e->getMessage()];
    }
}

function finishInstallation($data) {
    try {
        // Criar arquivo de lock
        file_put_contents('config/installed.lock', date('Y-m-d H:i:s'));
        
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'error' => 'Erro na finalização: ' . $e->getMessage()];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instalação - Preditix OS Manager</title>
    <link rel="stylesheet" href="assets/css/app.css">
    <style>
        .install-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--light) 0%, var(--light-gray) 100%);
            padding: 20px;
        }
        .install-card {
            background: var(--white);
            padding: 40px;
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow-lg);
            max-width: 600px;
            width: 100%;
        }
        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }
        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            font-weight: bold;
            color: white;
        }
        .step.active {
            background: var(--primary);
        }
        .step.completed {
            background: var(--success);
        }
        .step.inactive {
            background: var(--gray);
        }
        .alert {
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        }
        .alert-error {
            background: #fee;
            border: 1px solid #fcc;
            color: #c33;
        }
        .alert-success {
            background: #efe;
            border: 1px solid #cfc;
            color: #363;
        }
    </style>
</head>
<body>
    <div class="install-container">
        <div class="install-card">
            <div class="text-center mb-4">
                <img src="logo_preditix.jpeg" alt="Preditix" style="height: 60px; margin-bottom: 20px;">
                <h1>Instalação do Sistema</h1>
                <p style="color: var(--gray);">Preditix OS Manager</p>
            </div>
            
            <div class="step-indicator">
                <div class="step <?= $step >= 1 ? 'active' : 'inactive' ?>">1</div>
                <div class="step <?= $step >= 2 ? 'active' : 'inactive' ?>">2</div>
                <div class="step <?= $step >= 3 ? 'active' : 'inactive' ?>">3</div>
                <div class="step <?= $step >= 4 ? 'active' : 'inactive' ?>">4</div>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>
            
            <?php if ($step == 1): ?>
                <h2>Bem-vindo!</h2>
                <p>Este assistente irá configurar o sistema Preditix OS Manager.</p>
                
                <h3>Requisitos:</h3>
                <ul>
                    <li>PHP 7.4 ou superior ✓</li>
                    <li>MySQL 5.7 ou superior</li>
                    <li>Servidor web com mod_rewrite (Apache) ou configuração equivalente (Nginx)</li>
                    <li>HTTPS configurado (para PWA)</li>
                </ul>
                
                <div class="text-center mt-4">
                    <a href="?step=2" class="btn btn-primary">Começar Instalação</a>
                </div>
                
            <?php elseif ($step == 2): ?>
                <h2>Configuração do Banco de Dados</h2>
                <p>Informe os dados de conexão com o MySQL:</p>
                
                <form method="POST">
                    <input type="hidden" name="action" value="test_db">
                    
                    <div class="form-group">
                        <label class="form-label">Host do Banco:</label>
                        <input type="text" name="db_host" class="form-control" value="localhost" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Nome do Banco:</label>
                        <input type="text" name="db_name" class="form-control" value="preditix_os" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Usuário:</label>
                        <input type="text" name="db_user" class="form-control" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Senha:</label>
                        <input type="password" name="db_pass" class="form-control">
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Testar Conexão</button>
                    </div>
                </form>
                
            <?php elseif ($step == 3): ?>
                <h2>Criar Tabelas</h2>
                <p>A conexão foi bem-sucedida! Agora vamos criar as tabelas necessárias.</p>
                
                <form method="POST">
                    <input type="hidden" name="action" value="create_tables">
                    <?php foreach ($_POST as $key => $value): ?>
                        <?php if ($key !== 'action'): ?>
                            <input type="hidden" name="<?= $key ?>" value="<?= htmlspecialchars($value) ?>">
                        <?php endif; ?>
                    <?php endforeach; ?>
                    
                    <div class="alert" style="background: #e7f3ff; border: 1px solid #b3d9ff; color: #0066cc;">
                        <strong>Atenção:</strong> Este processo irá criar todas as tabelas necessárias e inserir dados de exemplo.
                        Se o banco já contém dados, eles podem ser sobrescritos.
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Criar Tabelas</button>
                    </div>
                </form>
                
            <?php elseif ($step == 4): ?>
                <h2>Finalização</h2>
                <p>As tabelas foram criadas com sucesso!</p>
                
                <div class="alert alert-success">
                    <h4>Próximos passos:</h4>
                    <ol>
                        <li><strong>Configure o arquivo config/database.php</strong> com as informações do banco</li>
                        <li><strong>Configure o servidor web</strong> para apontar para este diretório</li>
                        <li><strong>Ative HTTPS</strong> para funcionalidades PWA</li>
                        <li><strong>Teste o sistema</strong> com os usuários padrão</li>
                    </ol>
                </div>
                
                <div style="background: var(--light); padding: 20px; border-radius: var(--border-radius); margin: 20px 0;">
                    <h4>Usuários para teste:</h4>
                    <p><strong>Gestor:</strong> admin@preditix.com / password</p>
                    <p><strong>Técnico:</strong> joao@preditix.com / password</p>
                </div>
                
                <form method="POST">
                    <input type="hidden" name="action" value="finish_install">
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg">
                            Finalizar Instalação
                        </button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>