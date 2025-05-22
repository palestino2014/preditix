<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../classes/Database.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../../login.php');
    exit;
}

// Verifica se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log("Método não permitido: " . $_SERVER['REQUEST_METHOD']);
    header('Content-Type: application/json');
    http_response_code(405);
    echo json_encode(['erro' => 'Método não permitido']);
    exit;
}

// Log dos dados recebidos
error_log("Dados POST recebidos em processa_os.php: " . print_r($_POST, true));
error_log("Dados FILES recebidos: " . print_r($_FILES, true));
error_log("Headers recebidos: " . print_r(getallheaders(), true));

// Inicializa a conexão com o banco de dados
try {
    $db = new Database();
} catch (Exception $e) {
    error_log("Erro ao conectar ao banco de dados: " . $e->getMessage());
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao conectar ao banco de dados']);
    exit;
}

try {
    // Determina se é uma criação ou edição
    $modo_edicao = isset($_POST['id']);
    error_log("Modo edição: " . ($modo_edicao ? 'Sim' : 'Não'));
    
    // Validação dos campos obrigatórios
    $campos_obrigatorios = [
        'tipo_equipamento' => 'Tipo de Equipamento',
        'equipamento_id' => 'Equipamento',
        'tipo_manutencao' => 'Tipo de Manutenção',
        'prioridade' => 'Prioridade'
    ];

    if (!$modo_edicao) {
        $campos_obrigatorios['data_abertura'] = 'Data de Abertura';
    } else {
        $campos_obrigatorios['status'] = 'Status';
    }

    $erros = [];
    foreach ($campos_obrigatorios as $campo => $nome) {
        if (empty($_POST[$campo])) {
            $erros[] = "O campo {$nome} é obrigatório.";
            error_log("Campo obrigatório faltando: {$campo}");
        }
    }

    if (!empty($erros)) {
        error_log("Erros de validação: " . implode(', ', $erros));
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(['erro' => implode('<br>', $erros)]);
        exit;
    }

    // Prepara os dados para inserção/atualização
    $dados = [
        ':tipo_equipamento' => $_POST['tipo_equipamento'],
        ':equipamento_id' => $_POST['equipamento_id'],
        ':tipo_manutencao' => $_POST['tipo_manutencao'],
        ':prioridade' => $_POST['prioridade'],
        ':observacoes' => $_POST['observacoes'] ?? '',
        ':sistemas_afetados' => json_encode($_POST['sistemas_afetados'] ?? []),
        ':sintomas_detectados' => json_encode($_POST['sintomas_detectados'] ?? []),
        ':causas_defeitos' => json_encode($_POST['causas_defeitos'] ?? []),
        ':tipo_intervencao' => json_encode($_POST['intervencoes_realizadas'] ?? []),
        ':acoes_realizadas' => json_encode($_POST['acoes_realizadas'] ?? []),
        ':data_prevista' => null,
        ':odometro' => null
    ];

    if ($modo_edicao) {
        $dados[':status'] = $_POST['status'];
        
        // Se o status for 'concluida', registra a data de conclusão e o usuário
        if ($_POST['status'] === 'concluida') {
            $dados[':data_conclusao'] = date('Y-m-d H:i:s');
            $dados[':usuario_conclusao_id'] = $_SESSION['usuario_id'];
        }
    }

    // Gera o número da OS apenas para novas OS
    if (!$modo_edicao) {
        $ano = date('Y');
        $sql = "SELECT MAX(CAST(SUBSTRING(numero_os, 5) AS UNSIGNED)) as ultimo_numero 
               FROM ordens_servico 
               WHERE numero_os LIKE :ano_prefix";
        $result = $db->query($sql, [':ano_prefix' => $ano . '%']);
        $sequencial = ($result[0]['ultimo_numero'] ?? 0) + 1;
        $numero_os = $ano . str_pad($sequencial, 6, '0', STR_PAD_LEFT);
        
        $dados[':numero_os'] = $numero_os;
    }

    error_log("Dados preparados para processamento: " . print_r($dados, true));

    if ($modo_edicao) {
        // Modo edição
        $id_os = (int)$_POST['id'];
        error_log("Editando OS ID: " . $id_os);
        
        // Verifica se a OS existe
        $sql_verifica = "SELECT status FROM ordens_servico WHERE id = :id";
        $result = $db->query($sql_verifica, [':id' => $id_os]);
        
        if (empty($result)) {
            error_log("OS não encontrada: " . $id_os);
            throw new Exception("Ordem de serviço não encontrada.");
        }

        // Inicia a transação
        $db->beginTransaction();

        try {
            // Adiciona campos específicos da edição
            if (!empty($_POST['data_prevista'])) {
                $dados[':data_prevista'] = $_POST['data_prevista'];
            }

            if (($_POST['tipo_equipamento'] === 'veiculo' || $_POST['tipo_equipamento'] === 'implemento') && 
                isset($_POST['odometro'])) {
                $dados[':odometro'] = (int)$_POST['odometro'];
            }

            // Prepara a query de atualização
            $sql = "UPDATE ordens_servico SET 
                    tipo_equipamento = :tipo_equipamento,
                    equipamento_id = :equipamento_id,
                    tipo_manutencao = :tipo_manutencao,
                    prioridade = :prioridade,
                    observacoes = :observacoes,
                    sistemas_afetados = :sistemas_afetados,
                    sintomas_detectados = :sintomas_detectados,
                    causas_defeitos = :causas_defeitos,
                    tipo_intervencao = :tipo_intervencao,
                    acoes_realizadas = :acoes_realizadas,
                    data_prevista = :data_prevista,
                    odometro = :odometro,
                    status = :status,
                    " . (isset($dados[':data_conclusao']) ? "data_conclusao = :data_conclusao," : "") . "
                    " . (isset($dados[':usuario_conclusao_id']) ? "usuario_conclusao_id = :usuario_conclusao_id," : "") . "
                    updated_at = NOW()
                    WHERE id = :id";

            // Adiciona o ID aos parâmetros
            $dados[':id'] = $id_os;

            error_log("SQL Update: " . $sql);
            error_log("Parâmetros Update: " . print_r($dados, true));

            // Executa a atualização
            $db->execute($sql, $dados);

            // Processa os itens da OS
            if (isset($_POST['itens']) && is_array($_POST['itens'])) {
                // Valida os itens apenas se existirem
                foreach ($_POST['itens']['descricao'] as $index => $descricao) {
                    if (empty($descricao)) continue; // Pula itens vazios

                    $quantidade = filter_var($_POST['itens']['quantidade'][$index], FILTER_VALIDATE_INT);
                    if ($quantidade === false || $quantidade <= 0) {
                        throw new Exception("A quantidade deve ser um número inteiro maior que zero.");
                    }

                    $valor_unitario = filter_var($_POST['itens']['valor_unitario'][$index], FILTER_VALIDATE_FLOAT);
                    if ($valor_unitario === false || $valor_unitario <= 0) {
                        throw new Exception("O valor unitário deve ser maior que zero.");
                    }
                }

                // Remove os itens existentes (em caso de edição)
                if ($modo_edicao) {
                    $sql_delete = "DELETE FROM itens_ordem_servico WHERE ordem_servico_id = :id_os";
                    $db->execute($sql_delete, [':id_os' => $id_os]);
                }

                // Insere os novos itens
                $sql_insert_item = "INSERT INTO itens_ordem_servico (ordem_servico_id, descricao, quantidade, valor_unitario) 
                                  VALUES (:ordem_servico_id, :descricao, :quantidade, :valor_unitario)";
                
                foreach ($_POST['itens']['descricao'] as $index => $descricao) {
                    if (empty($descricao)) continue; // Pula itens vazios
                    
                    $db->execute($sql_insert_item, [
                        ':ordem_servico_id' => $modo_edicao ? $id_os : $db->lastInsertId(),
                        ':descricao' => $descricao,
                        ':quantidade' => (int)$_POST['itens']['quantidade'][$index],
                        ':valor_unitario' => (float)$_POST['itens']['valor_unitario'][$index]
                    ]);
                }
            }

            // Commit da transação
            $db->commit();
            error_log("OS atualizada com sucesso: " . $id_os);

            $_SESSION['sucesso'] = "Ordem de serviço atualizada com sucesso!";
            header('Location: ../visualiza_os.php?id=' . $id_os);
            exit;

        } catch (Exception $e) {
            // Rollback em caso de erro
            $db->rollBack();
            throw $e;
        }

    } else {
        // Modo criação
        error_log("Criando nova OS");
        
        // Inicia a transação
        $db->beginTransaction();

        try {
            // Adiciona campos específicos para nova OS
            $dados[':data_abertura'] = $_POST['data_abertura'];
            $dados[':usuario_abertura_id'] = $_SESSION['usuario_id'];
            $dados[':status'] = 'aberta';

            // Se for veículo ou implemento, atualiza o odômetro
            if (in_array($_POST['tipo_equipamento'], ['veiculo', 'implemento'])) {
                $dados[':odometro'] = $_POST['odometro'] ?? null;
            }

            // Insere a nova OS
            $sql = "INSERT INTO ordens_servico (
                        numero_os, tipo_equipamento, equipamento_id, tipo_manutencao, prioridade,
                        observacoes, sistemas_afetados, sintomas_detectados,
                        causas_defeitos, tipo_intervencao, acoes_realizadas,
                        data_abertura, usuario_abertura_id, status, data_prevista, 
                        odometro, created_at, updated_at
                    ) VALUES (
                        :numero_os, :tipo_equipamento, :equipamento_id, :tipo_manutencao, :prioridade,
                        :observacoes, :sistemas_afetados, :sintomas_detectados,
                        :causas_defeitos, :tipo_intervencao, :acoes_realizadas,
                        :data_abertura, :usuario_abertura_id, :status, :data_prevista,
                        :odometro, NOW(), NOW()
                    )";

            error_log("SQL Insert: " . $sql);
            error_log("Parâmetros Insert: " . print_r($dados, true));
            
            $db->execute($sql, $dados);
            $id_os = $db->lastInsertId();

            // Processa os itens da OS
            if (isset($_POST['itens']) && is_array($_POST['itens'])) {
                $sql_insert_item = "INSERT INTO itens_ordem_servico (ordem_servico_id, descricao, quantidade, valor_unitario) 
                                  VALUES (:ordem_servico_id, :descricao, :quantidade, :valor_unitario)";
                
                foreach ($_POST['itens']['descricao'] as $index => $descricao) {
                    if (empty($descricao)) continue; // Pula itens vazios
                    
                    $db->execute($sql_insert_item, [
                        ':ordem_servico_id' => $id_os,
                        ':descricao' => $descricao,
                        ':quantidade' => $_POST['itens']['quantidade'][$index],
                        ':valor_unitario' => $_POST['itens']['valor_unitario'][$index]
                    ]);
                }
            }

            // Commit da transação
            $db->commit();
            error_log("Nova OS criada com sucesso. ID: " . $id_os);

            $_SESSION['sucesso'] = "Ordem de serviço criada com sucesso!";
            header('Location: ../visualiza_os.php?id=' . $id_os);
            exit;

        } catch (Exception $e) {
            // Rollback em caso de erro
            $db->rollBack();
            throw $e;
        }
    }

} catch (Exception $e) {
    error_log("Erro ao processar OS: " . $e->getMessage());
    error_log("Stack trace: " . $e->getTraceAsString());
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['erro' => 'Erro ao processar a ordem de serviço: ' . $e->getMessage()]);
    exit;
} 