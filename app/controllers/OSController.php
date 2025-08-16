<?php
/**
 * Controller de Ordens de Serviço
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

class OSController extends BaseController {
    
    public function index() {
        $user = $this->getCurrentUser();
        
        try {
            $ordersList = $this->getOrdersForUser($user);
            $assetsList = $this->getVehicles(); // Buscar todos os ativos para o filtro
            
            $this->view('os/index', [
                'orders' => $ordersList,
                'assets' => $assetsList,
                'userType' => $user['type']
            ]);
        } catch (Exception $e) {
            error_log("Error loading orders: " . $e->getMessage());
            $this->view('os/index', [
                'orders' => [],
                'error' => Language::t('error_database')
            ]);
        }
    }
    
    public function create() {
        $user = $this->getCurrentUser();
        
        try {
            $vehicles = $this->getVehicles();
            $users = $this->getUsers($user['type']);
            
            // Verificar se é para reabrir uma OS existente
            $reopenData = null;
            if (isset($_GET['reopen']) && !empty($_GET['reopen'])) {
                $reopenOsId = (int)$_GET['reopen'];
                $reopenData = $this->getOrderById($reopenOsId);
                
                // Verificar se a OS existe e se o usuário tem permissão para vê-la
                if ($reopenData && $this->canViewOrder($reopenData, $user)) {
                    // Buscar itens da OS original se existirem
                    $reopenItems = $this->getOrderItems($reopenOsId);
                    $reopenData['items'] = $reopenItems;
                } else {
                    $reopenData = null; // Não tem permissão ou OS não existe
                }
            }
            
            $this->view('os/create', [
                'vehicles' => $vehicles,
                'users' => $users,
                'userType' => $user['type'],
                'csrf_token' => $this->generateCsrf(),
                'reopenData' => $reopenData
            ]);
        } catch (Exception $e) {
            error_log("Error loading create form: " . $e->getMessage());
            $this->redirect('/dashboard');
        }
    }
    
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/dashboard');
        }
        
        $this->validateCsrf();
        
        $user = $this->getCurrentUser();
        $data = $this->sanitizeInput($_POST);
        
        try {
            // Validar dados obrigatórios
            $errors = $this->validateOrderData($data);
            if (!empty($errors)) {
                $_SESSION['form_errors'] = $errors;
                $_SESSION['form_data'] = $data;
                $this->redirect('/os/create');
            }
            
            $osId = $this->createOrder($data, $user);
            
            if ($osId) {
                if ($user['type'] === 'tecnico') {
                    $_SESSION['success_message'] = Language::t('os_created_pending');
                } else {
                    $_SESSION['success_message'] = Language::t('os_created_success');
                }
                
                $this->redirect('/os/view?id=' . $osId);
            } else {
                throw new Exception("Failed to create order");
            }
        } catch (Exception $e) {
            error_log("Error creating order: " . $e->getMessage());
            $_SESSION['form_error'] = Language::t('error_unknown');
            $_SESSION['form_data'] = $data;
            $this->redirect('/os/create');
        }
    }
    
    public function viewOS() {
        $osId = (int)($_GET['id'] ?? 0);
        
        if (!$osId) {
            $this->redirect('/dashboard');
        }
        
        $user = $this->getCurrentUser();
        
        try {
            $order = $this->getOrderById($osId);
            
            if (!$order || !$this->canViewOrder($order, $user)) {
                $_SESSION['error_message'] = Language::t('error_not_found');
                $this->redirect('/dashboard');
            }
            
            $timeline = $this->getOrderTimeline($osId);
            $items = $this->getOrderItems($osId);
            
            $this->view('os/view', [
                'order' => $order,
                'timeline' => $timeline,
                'items' => $items,
                'userType' => $user['type'],
                'canEdit' => $this->canEditOrder($order, $user),
                'csrf_token' => $this->generateCsrf(),
                'currentUser' => $user
            ]);
        } catch (Exception $e) {
            error_log("Error viewing order: " . $e->getMessage());
            $_SESSION['error_message'] = Language::t('error_database');
            $this->redirect('/dashboard');
        }
    }
    
    public function approve() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid method'], 405);
            return;
        }
        
        $this->requireRole('gestor');
        $this->validateCsrf();
        
        $osId = (int)($_POST['os_id'] ?? 0);
        $user = $this->getCurrentUser();
        
        try {
            $order = $this->getOrderById($osId);
            
            if (!$order || $order['id_gestor'] != $user['id']) {
                $this->jsonResponse(['error' => Language::t('error_permission')], 403);
                return;
            }
            
            $result = $this->approveAction($order, $user);
            
            if ($result) {
                $this->jsonResponse(['success' => true, 'message' => Language::t('os_approved_success')]);
            } else {
                $this->jsonResponse(['error' => Language::t('error_unknown')], 500);
            }
        } catch (Exception $e) {
            error_log("Error approving order: " . $e->getMessage());
            $this->jsonResponse(['error' => Language::t('error_database')], 500);
        }
    }
    
    public function reject() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid method'], 405);
            return;
        }
        
        $this->requireRole('gestor');
        $this->validateCsrf();
        
        $osId = (int)($_POST['os_id'] ?? 0);
        $justification = $this->sanitizeInput($_POST['justification'] ?? '');
        $user = $this->getCurrentUser();
        
        if (empty($justification)) {
            $this->jsonResponse(['error' => Language::t('reject_reason_required')], 400);
            return;
        }
        
        try {
            $order = $this->getOrderById($osId);
            
            if (!$order || $order['id_gestor'] != $user['id']) {
                $this->jsonResponse(['error' => Language::t('error_permission')], 403);
                return;
            }
            
            $result = $this->rejectAction($order, $user, $justification);
            
            if ($result) {
                $this->jsonResponse(['success' => true, 'message' => Language::t('os_rejected_success')]);
            } else {
                $this->jsonResponse(['error' => Language::t('error_unknown')], 500);
            }
        } catch (Exception $e) {
            error_log("Error rejecting order: " . $e->getMessage());
            $this->jsonResponse(['error' => Language::t('error_database')], 500);
        }
    }
    
    public function finish() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid method'], 405);
            return;
        }
        
        $this->validateCsrf();
        
        $osId = (int)($_POST['os_id'] ?? 0);
        $user = $this->getCurrentUser();
        
        try {
            $order = $this->getOrderById($osId);
            
            if (!$order) {
                $this->jsonResponse(['error' => Language::t('error_not_found')], 404);
                return;
            }
            
            // Verificar permissões
            if ($user['type'] === 'tecnico' && $order['id_responsavel'] != $user['id']) {
                $this->jsonResponse(['error' => Language::t('error_permission')], 403);
                return;
            }
            
            if ($user['type'] === 'gestor' && $order['id_gestor'] != $user['id']) {
                $this->jsonResponse(['error' => Language::t('error_permission')], 403);
                return;
            }
            
            // Verificar se a OS pode ser concluída
            if (!in_array($order['status'], ['em_andamento', 'editada'])) {
                $this->jsonResponse(['error' => Language::t('cannot_complete_os')], 400);
                return;
            }
            
            $result = $this->completeOrder($order, $user);
            
            if ($result) {
                $this->jsonResponse(['success' => true, 'message' => Language::t('os_completed_success')]);
            } else {
                $this->jsonResponse(['error' => Language::t('error_unknown')], 500);
            }
        } catch (Exception $e) {
            error_log("Error completing order: " . $e->getMessage());
            $this->jsonResponse(['error' => Language::t('error_database')], 500);
        }
    }
    
    public function cancel() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid method'], 405);
            return;
        }
        
        $this->validateCsrf();
        
        $osId = (int)($_POST['os_id'] ?? 0);
        $user = $this->getCurrentUser();
        
        try {
            $order = $this->getOrderById($osId);
            
            if (!$order) {
                $this->jsonResponse(['error' => Language::t('error_not_found')], 404);
                return;
            }
            
            // Verificar permissões
            if ($user['type'] === 'tecnico' && $order['id_responsavel'] != $user['id']) {
                $this->jsonResponse(['error' => Language::t('error_permission')], 403);
                return;
            }
            
            if ($user['type'] === 'gestor' && $order['id_gestor'] != $user['id']) {
                $this->jsonResponse(['error' => Language::t('error_permission')], 403);
                return;
            }
            
            // Verificar se a OS pode ser cancelada
            if (!in_array($order['status'], ['aberta', 'em_andamento', 'editada'])) {
                $this->jsonResponse(['error' => Language::t('cannot_cancel_os')], 400);
                return;
            }
            
            $result = $this->cancelOrder($order, $user);
            
            if ($result) {
                $this->jsonResponse(['success' => true, 'message' => Language::t('os_cancelled_success')]);
            } else {
                $this->jsonResponse(['error' => Language::t('error_unknown')], 500);
            }
        } catch (Exception $e) {
            error_log("Error cancelling order: " . $e->getMessage());
            $this->jsonResponse(['error' => Language::t('error_database')], 500);
        }
    }
    
    public function tryAgain() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid method'], 405);
            return;
        }
        
        $this->validateCsrf();
        
        $osId = (int)($_POST['os_id'] ?? 0);
        $user = $this->getCurrentUser();
        
        try {
            $order = $this->getOrderById($osId);
            
            if (!$order) {
                $this->jsonResponse(['error' => Language::t('error_not_found')], 404);
                return;
            }
            
            // Verificar permissões
            if ($user['type'] === 'tecnico' && $order['id_responsavel'] != $user['id']) {
                $this->jsonResponse(['error' => Language::t('error_permission')], 403);
                return;
            }
            
            if ($user['type'] === 'gestor' && $order['id_gestor'] != $user['id']) {
                $this->jsonResponse(['error' => Language::t('error_permission')], 403);
                return;
            }
            
            // Verificar se a OS pode ser tentada novamente
            if ($order['status'] !== 'rejeitada') {
                $this->jsonResponse(['error' => Language::t('cannot_try_again')], 400);
                return;
            }
            
            $result = $this->tryAgainOrder($order, $user);
            
            if ($result) {
                $this->jsonResponse(['success' => true, 'message' => Language::t('os_try_again_success')]);
            } else {
                $this->jsonResponse(['error' => Language::t('error_unknown')], 500);
            }
        } catch (Exception $e) {
            error_log("Error trying again order: " . $e->getMessage());
            $this->jsonResponse(['error' => Language::t('error_database')], 500);
        }
    }
    
    public function giveUp() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['error' => 'Invalid method'], 405);
            return;
        }
        
        $this->validateCsrf();
        
        $osId = (int)($_POST['os_id'] ?? 0);
        $user = $this->getCurrentUser();
        
        try {
            $order = $this->getOrderById($osId);
            
            if (!$order) {
                $this->jsonResponse(['error' => Language::t('error_not_found')], 404);
                return;
            }
            
            // Verificar permissões
            if ($user['type'] === 'tecnico' && $order['id_responsavel'] != $user['id']) {
                $this->jsonResponse(['error' => Language::t('error_permission')], 403);
                return;
            }
            
            if ($user['type'] === 'gestor' && $order['id_gestor'] != $user['id']) {
                $this->jsonResponse(['error' => Language::t('error_permission')], 403);
                return;
            }
            
            // Verificar se a OS pode ser desistida
            if ($order['status'] !== 'rejeitada') {
                $this->jsonResponse(['error' => Language::t('cannot_give_up')], 400);
                return;
            }
            
            $result = $this->giveUpOrder($order, $user);
            
            if ($result) {
                $this->jsonResponse(['success' => true, 'message' => Language::t('os_give_up_success')]);
            } else {
                $this->jsonResponse(['error' => Language::t('error_unknown')], 500);
            }
        } catch (Exception $e) {
            error_log("Error giving up order: " . $e->getMessage());
            $this->jsonResponse(['error' => Language::t('error_database')], 500);
        }
    }
    
    private function getOrdersForUser($user) {
        if ($user['type'] === 'tecnico') {
            $sql = "SELECT os.*, v.tag, v.modelo, v.cor, v.placa, u.nome as created_by_name
                    FROM ordem_servico os 
                    JOIN veiculo v ON os.id_ativo = v.id_ativo 
                    LEFT JOIN usuario u ON os.id_responsavel = u.id
                    WHERE os.id_responsavel = ? 
                    ORDER BY os.created_at DESC";
            $params = [$user['id']];
        } else {
            $sql = "SELECT os.*, v.tag, v.modelo, v.cor, v.placa, u.nome as created_by_name
                    FROM ordem_servico os 
                    JOIN veiculo v ON os.id_ativo = v.id_ativo 
                    LEFT JOIN usuario u ON os.id_responsavel = u.id
                    WHERE os.id_gestor = ? 
                    ORDER BY os.created_at DESC";
            $params = [$user['id']];
        }
        
        $stmt = $this->db->query($sql, $params);
        return $stmt->fetchAll();
    }
    
    private function getVehicles() {
        $sql = "SELECT * FROM veiculo WHERE status = 'ativo' ORDER BY tag";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    private function getUsers($currentUserType) {
        if ($currentUserType === 'tecnico') {
            // Técnico vê apenas gestores
            $sql = "SELECT id, nome, acesso FROM usuario WHERE acesso = 'gestor' AND ativo = 1 ORDER BY nome";
        } else {
            // Gestor vê apenas técnicos
            $sql = "SELECT id, nome, acesso FROM usuario WHERE acesso = 'tecnico' AND ativo = 1 ORDER BY nome";
        }
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    private function validateOrderData($data) {
        $user = $this->getCurrentUser();
        
        $required = [
            'id_ativo' => 'vehicle',
            'tipo_manutencao' => 'maintenance_type',
            'prioridade' => 'priority'
        ];
        
        // Adicionar validação específica baseada no tipo de usuário
        if ($user['type'] === 'gestor') {
            $required['id_responsavel'] = 'responsible';
        }
        // Para técnicos, não validamos o id_gestor pois ele não pode ser alterado
        
        return $this->validateRequired($required, $data);
    }
    
    private function createOrder($data, $user) {
        $this->db->getConnection()->beginTransaction();
        
        try {
            // Determinar gestor e responsável baseado no tipo de usuário
            if ($user['type'] === 'tecnico') {
                $idGestor = (int)$data['id_gestor'];
                $idResponsavel = $user['id'];
                $status = 'aberta';
                $autorizada = 0; // false como integer
                $dataAbertura = null;
                $dataAprovacao = null;
            } else {
                $idGestor = $user['id'];
                $idResponsavel = (int)$data['id_responsavel'];
                $status = 'em_andamento';
                $autorizada = 1; // true como integer
                $dataAbertura = date('Y-m-d H:i:s');
                $dataAprovacao = date('Y-m-d H:i:s');
            }
            
            // Inserir ordem de serviço
            $sql = "INSERT INTO ordem_servico (
                        id_ativo, tipo_manutencao, prioridade, status, autorizada,
                        id_gestor, id_responsavel, data_abertura, data_aprovacao,
                        sistemas_afetados, sintomas_detectados, causas_defeitos,
                        intervencoes_realizadas, acoes_realizadas, observacoes
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $this->db->query($sql, [
                $data['id_ativo'],
                $data['tipo_manutencao'],
                $data['prioridade'],
                $status,
                $autorizada,
                $idGestor,
                $idResponsavel,
                $dataAbertura,
                $dataAprovacao,
                json_encode($data['sistemas_afetados'] ?? []),
                json_encode($data['sintomas_detectados'] ?? []),
                json_encode($data['causas_defeitos'] ?? []),
                json_encode($data['intervencoes_realizadas'] ?? []),
                json_encode($data['acoes_realizadas'] ?? []),
                $data['observacoes'] ?? ''
            ]);
            
            $osId = $this->db->lastInsertId();
            
            // Inserir itens se existirem
            if (!empty($data['items'])) {
                $this->insertOrderItems($osId, $data['items']);
            }
            
            // Registrar no histórico
            if ($user['type'] === 'tecnico') {
                $this->logAction($osId, 'abertura', null, 'aberta');
            } else {
                $this->logAction($osId, 'abertura', null, 'aberta');
                $this->logAction($osId, 'aprovacao', 'aberta', 'em_andamento');
            }
            
            $this->db->getConnection()->commit();
            return $osId;
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            throw $e;
        }
    }
    
    private function insertOrderItems($osId, $items) {
        if (empty($items) || !is_array($items)) {
            return;
        }
        
        $sql = "INSERT INTO os_itens (id_os, descricao, quantidade, valor_unitario) VALUES (?, ?, ?, ?)";
        
        foreach ($items as $item) {
            if (!is_array($item)) {
                continue;
            }
            
            $descricao = trim($item['descricao'] ?? '');
            $quantidade = (int)($item['quantidade'] ?? 1);
            $valorUnitario = (float)($item['valor_unitario'] ?? 0);
            
            if (!empty($descricao) && $quantidade > 0) {
                $this->db->query($sql, [
                    $osId,
                    $descricao,
                    $quantidade,
                    $valorUnitario
                ]);
            }
        }
    }
    
    private function getOrderById($osId) {
        $sql = "SELECT os.*, v.tag, v.modelo, v.cor, v.placa, v.proprietario,
                       g.nome as gestor_nome, r.nome as responsavel_nome
                FROM ordem_servico os
                JOIN veiculo v ON os.id_ativo = v.id_ativo
                JOIN usuario g ON os.id_gestor = g.id
                JOIN usuario r ON os.id_responsavel = r.id
                WHERE os.id_os = ?";
        
        $stmt = $this->db->query($sql, [$osId]);
        return $stmt->fetch();
    }
    
    private function getOrderTimeline($osId) {
        $sql = "SELECT h.*, u.nome as usuario_nome
                FROM os_historico h
                JOIN usuario u ON h.usuario_id = u.id
                WHERE h.id_os = ?
                ORDER BY h.data_hora ASC";
        
        $stmt = $this->db->query($sql, [$osId]);
        return $stmt->fetchAll();
    }
    
    private function getOrderItems($osId) {
        $sql = "SELECT * FROM os_itens WHERE id_os = ? ORDER BY id";
        $stmt = $this->db->query($sql, [$osId]);
        return $stmt->fetchAll();
    }
    
    private function canViewOrder($order, $user) {
        return ($order['id_gestor'] == $user['id'] || $order['id_responsavel'] == $user['id']);
    }
    
    private function canEditOrder($order, $user) {
        // Lógica de permissão de edição baseada no status e tipo de usuário
        if ($user['type'] === 'gestor') {
            return in_array($order['status'], ['aberta', 'em_andamento', 'editada', 'concluida', 'cancelada']);
        } else {
            return ($order['status'] === 'em_andamento' && $order['id_responsavel'] == $user['id']);
        }
    }
    
    private function approveAction($order, $user) {
        $newStatus = $this->getApprovalStatus($order['status']);
        $updates = ['autorizada' => 1]; // true como integer
        
        // Adicionar datas específicas baseadas no status
        switch ($order['status']) {
            case 'aberta':
                $updates['data_aprovacao'] = date('Y-m-d H:i:s');
                break;
            case 'concluida':
                $updates['data_conclusao'] = date('Y-m-d H:i:s');
                break;
            case 'cancelada':
                $updates['data_cancelamento'] = date('Y-m-d H:i:s');
                break;
        }
        
        return $this->updateOrderStatus($order['id_os'], $newStatus, $updates, $user, 'aprovacao');
    }
    
    private function rejectAction($order, $user, $justification) {
        error_log("rejectAction chamado para OS: " . $order['id_os']);
        error_log("Status atual: " . $order['status'] . ", Ação rejeitada: " . ($order['acao_rejeitada'] ?? 'Nenhuma'));
        
        // Determinar para qual status voltar baseado na ação rejeitada
        $newStatus = 'em_andamento'; // Sempre volta para em_andamento
        
        $updates = [
            'status_anterior' => null, // Limpar status anterior
            'autorizada' => 1 // Aprovação automática ao voltar
        ];
        
        // Se a OS está no status 'editada', significa que foi editada por técnico
        // e precisa ter acao_rejeitada definida como 'edicao'
        if ($order['status'] === 'editada') {
            error_log("OS está no status 'editada', definindo acao_rejeitada = 'edicao'");
            $updates['acao_rejeitada'] = 'edicao';
        } else {
            error_log("OS não está no status 'editada', limpando acao_rejeitada");
            $updates['acao_rejeitada'] = null;
        }
        
        error_log("Updates iniciais: " . json_encode($updates));
        
        // Se a OS foi editada, precisamos restaurar os valores originais
        if ($order['status'] === 'editada') {
            error_log("OS foi editada, restaurando dados originais...");
            
            // Buscar a versão original da OS (antes da edição)
            $originalOrder = $this->getOriginalOrderData($order['id_os']);
            if ($originalOrder) {
                error_log("Dados originais encontrados, restaurando...");
                
                // Restaurar valores originais
                $updates = array_merge($updates, [
                    'tipo_manutencao' => $originalOrder['tipo_manutencao'],
                    'prioridade' => $originalOrder['prioridade'],
                    'sistemas_afetados' => $originalOrder['sistemas_afetados'],
                    'sintomas_detectados' => $originalOrder['sintomas_detectados'],
                    'causas_defeitos' => $originalOrder['causas_defeitos'],
                    'intervencoes_realizadas' => $originalOrder['intervencoes_realizadas'],
                    'acoes_realizadas' => $originalOrder['acoes_realizadas'],
                    'observacoes' => $originalOrder['observacoes']
                ]);
                
                error_log("Updates finais com restauração: " . json_encode($updates));
            } else {
                error_log("ERRO: Dados originais não encontrados para restauração!");
            }
        } else {
            error_log("OS não foi editada, apenas mudando status");
        }
        
        error_log("Chamando updateOrderStatus com status: $newStatus");
        return $this->updateOrderStatus($order['id_os'], $newStatus, $updates, $user, 'rejeicao', $justification);
    }
    
    private function getApprovalStatus($currentStatus) {
        $statusMap = [
            'aberta' => 'em_andamento',
            'editada' => 'em_andamento', // OS editada por técnico vai para em_andamento quando aprovada
            'concluida' => 'concluida',
            'cancelada' => 'cancelada'
        ];
        
        return $statusMap[$currentStatus] ?? $currentStatus;
    }
    
    private function getActionFromStatus($status) {
        $actionMap = [
            'aberta' => 'abertura',
            'editada' => 'edicao',
            'concluida' => 'conclusao',
            'cancelada' => 'cancelamento'
        ];
        
        return $actionMap[$status] ?? null;
    }
    
    private function updateOrderStatus($osId, $newStatus, $updates, $user, $action, $justification = null) {
        $this->db->getConnection()->beginTransaction();
        
        try {
            // Buscar status atual
            $currentOrder = $this->getOrderById($osId);
            $currentStatus = $currentOrder['status'];
            
            // Construir query de update
            $updates['status'] = $newStatus;
            $updateFields = [];
            $updateValues = [];
            
            foreach ($updates as $field => $value) {
                $updateFields[] = "$field = ?";
                $updateValues[] = $value;
            }
            
            $updateValues[] = $osId;
            
            $sql = "UPDATE ordem_servico SET " . implode(', ', $updateFields) . " WHERE id_os = ?";
            $this->db->query($sql, $updateValues);
            
            // Registrar no histórico
            $this->logAction($osId, $action, $currentStatus, $newStatus, $justification);
            
            $this->db->getConnection()->commit();
            return true;
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            throw $e;
        }
    }
    
    private function completeOrder($order, $user) {
        $updates = [
            'data_conclusao' => date('Y-m-d H:i:s')
        ];
        
        // Se for técnico, precisa de aprovação
        if ($user['type'] === 'tecnico') {
            $newStatus = 'concluida';
            $updates['autorizada'] = 0; // Precisa de aprovação
        } else {
            // Se for gestor, é automaticamente aprovada
            $newStatus = 'concluida';
            $updates['autorizada'] = 1; // Automática
        }
        
        return $this->updateOrderStatus($order['id_os'], $newStatus, $updates, $user, 'conclusao');
    }
    
    private function cancelOrder($order, $user) {
        $updates = [
            'data_cancelamento' => date('Y-m-d H:i:s')
        ];
        
        // Se for técnico, precisa de aprovação
        if ($user['type'] === 'tecnico') {
            $newStatus = 'cancelada';
            $updates['autorizada'] = 0; // Precisa de aprovação
        } else {
            // Se for gestor, é automaticamente aprovada
            $newStatus = 'cancelada';
            $updates['autorizada'] = 1; // Automática
        }
        
        return $this->updateOrderStatus($order['id_os'], $newStatus, $updates, $user, 'cancelamento');
    }
    
    private function tryAgainOrder($order, $user) {
        // Sempre voltar para em_andamento com aprovação automática
        $newStatus = 'em_andamento';
        $updates = [
            'status_anterior' => null,
            'acao_rejeitada' => null,
            'autorizada' => 1 // Aprovação automática
        ];
        
        // Se a OS foi editada e rejeitada, restaurar valores originais
        if ($order['acao_rejeitada'] === 'edicao') {
            $originalOrder = $this->getOriginalOrderData($order['id_os']);
            if ($originalOrder) {
                // Restaurar valores originais
                $updates = array_merge($updates, [
                    'tipo_manutencao' => $originalOrder['tipo_manutencao'],
                    'prioridade' => $originalOrder['prioridade'],
                    'sistemas_afetados' => $originalOrder['sistemas_afetados'],
                    'sintomas_detectados' => $originalOrder['sintomas_detectados'],
                    'causas_defeitos' => $originalOrder['causas_defeitos'],
                    'intervencoes_realizadas' => $originalOrder['intervencoes_realizadas'],
                    'acoes_realizadas' => $originalOrder['acoes_realizadas'],
                    'observacoes' => $originalOrder['observacoes']
                ]);
            }
        }
        
        return $this->updateOrderStatus($order['id_os'], $newStatus, $updates, $user, 'tentar_novamente');
    }
    
    private function giveUpOrder($order, $user) {
        // Desistência = Cancelamento da OS
        // Precisa de aprovação do gestor
        $updates = [
            'data_cancelamento' => date('Y-m-d H:i:s'),
            'autorizada' => 0 // Precisa de aprovação do gestor
        ];
        
        return $this->updateOrderStatus($order['id_os'], 'cancelada', $updates, $user, 'desistencia');
    }
    
    public function edit() {
        $osId = (int)($_GET['id'] ?? 0);
        
        if (!$osId) {
            $this->redirect('/dashboard');
        }
        
        $user = $this->getCurrentUser();
        
        try {
            $order = $this->getOrderById($osId);
            
            if (!$order) {
                $_SESSION['error_message'] = Language::t('error_not_found');
                $this->redirect('/dashboard');
            }
            
            // Verificar permissões
            if ($user['type'] === 'tecnico' && $order['id_responsavel'] != $user['id']) {
                $_SESSION['error_message'] = Language::t('access_denied');
                $this->redirect('/dashboard');
            }
            
            if ($user['type'] === 'gestor' && $order['id_gestor'] != $user['id']) {
                $_SESSION['error_message'] = Language::t('access_denied');
                $this->redirect('/dashboard');
            }
            
            // Verificar se a OS pode ser editada
            if (!in_array($order['status'], ['em_andamento', 'editada'])) {
                $_SESSION['error_message'] = Language::t('cannot_edit_os');
                $this->redirect('/os/view?id=' . $osId);
            }
            
            // Buscar dados necessários
            $vehicles = $this->getVehicles();
            $users = $this->getUsers($user['type']);
            $timeline = $this->getOrderTimeline($osId);
            
            // Preparar dados para a view
            $data = [
                'order' => $order,
                'vehicles' => $vehicles,
                'users' => $users,
                'timeline' => $timeline,
                'userType' => $user['type'],
                'csrf_token' => $_SESSION['csrf_token']
            ];
            
            $this->view('os/edit', $data);
            
        } catch (Exception $e) {
            error_log("Error editing order: " . $e->getMessage());
            $_SESSION['error_message'] = Language::t('error_unknown');
            $this->redirect('/dashboard');
        }
    }
    
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/dashboard');
        }
        
        $this->validateCsrf();
        
        $user = $this->getCurrentUser();
        $data = $this->sanitizeInput($_POST);
        $osId = (int)($data['id_os'] ?? 0);
        
        if (!$osId) {
            $this->redirect('/dashboard');
        }
        
        try {
            $order = $this->getOrderById($osId);
            
            if (!$order) {
                $_SESSION['error_message'] = Language::t('error_not_found');
                $this->redirect('/dashboard');
            }
            
            // Verificar permissões
            if ($user['type'] === 'tecnico' && $order['id_responsavel'] != $user['id']) {
                $_SESSION['error_message'] = Language::t('access_denied');
                $this->redirect('/dashboard');
            }
            
            if ($user['type'] === 'gestor' && $order['id_gestor'] != $user['id']) {
                $_SESSION['error_message'] = Language::t('access_denied');
                $this->redirect('/dashboard');
            }
            
            // Verificar se a OS pode ser editada
            if (!in_array($order['status'], ['em_andamento', 'editada'])) {
                $_SESSION['error_message'] = Language::t('cannot_edit_os');
                $this->redirect('/os/view?id=' . $osId);
            }
            
            // Validar dados obrigatórios
            error_log("Validating data for OS update: " . json_encode($data));
            $errors = $this->validateOrderData($data);
            if (!empty($errors)) {
                error_log("Validation errors: " . json_encode($errors));
                $_SESSION['form_errors'] = $errors;
                $_SESSION['form_data'] = $data;
                $this->redirect('/os/edit?id=' . $osId);
            }
            
            $result = $this->updateOrder($osId, $data, $user);
            
            if ($result) {
                if ($user['type'] === 'tecnico') {
                    $_SESSION['success_message'] = Language::t('os_updated_pending');
                } else {
                    $_SESSION['success_message'] = Language::t('os_updated_success');
                }
                $this->redirect('/dashboard');
            } else {
                throw new Exception("Failed to update order");
            }
        } catch (Exception $e) {
            error_log("Error updating order: " . $e->getMessage() . " - Stack trace: " . $e->getTraceAsString());
            $_SESSION['form_error'] = Language::t('error_unknown') . " - " . $e->getMessage();
            $_SESSION['form_data'] = $data;
            $this->redirect('/os/edit?id=' . $osId);
        }
    }
    
    private function updateOrder($osId, $data, $user) {
        $this->db->getConnection()->beginTransaction();
        
        try {
            // Se for técnico editando, fazer backup dos dados originais antes da edição
            if ($user['type'] === 'tecnico') {
                $this->backupOriginalData($osId);
            }
            
            // Determinar gestor e responsável baseado no tipo de usuário
            if ($user['type'] === 'tecnico') {
                $idGestor = (int)($data['id_gestor'] ?? 0);
                $idResponsavel = $user['id'];
            } else {
                $idGestor = $user['id'];
                $idResponsavel = (int)($data['id_responsavel'] ?? 0);
            }
            
            // Determinar status e autorização baseado no tipo de usuário
            if ($user['type'] === 'tecnico') {
                // Técnico: OS vai para estado "editada" e precisa de aprovação
                $status = 'editada';
                $autorizada = 0; // false como integer
            } else {
                // Gestor: OS permanece no estado "em_andamento" e é automaticamente autorizada
                $status = 'em_andamento';
                $autorizada = 1; // true como integer
            }
            
            // Atualizar ordem de serviço
            $sql = "UPDATE ordem_servico SET 
                        id_ativo = ?, tipo_manutencao = ?, prioridade = ?,
                        id_gestor = ?, id_responsavel = ?,
                        sistemas_afetados = ?, sintomas_detectados = ?, causas_defeitos = ?,
                        intervencoes_realizadas = ?, acoes_realizadas = ?, observacoes = ?,
                        status = ?, autorizada = ?, updated_at = CURRENT_TIMESTAMP
                    WHERE id_os = ?";
            
            $this->db->query($sql, [
                $data['id_ativo'],
                $data['tipo_manutencao'],
                $data['prioridade'],
                $idGestor,
                $idResponsavel,
                json_encode($data['sistemas_afetados'] ?? []),
                json_encode($data['sintomas_detectados'] ?? []),
                json_encode($data['causas_defeitos'] ?? []),
                json_encode($data['intervencoes_realizadas'] ?? []),
                json_encode($data['acoes_realizadas'] ?? []),
                $data['observacoes'] ?? '',
                $status,
                $autorizada,
                $osId
            ]);
            
            // Atualizar itens se existirem
            if (isset($data['itens'])) {
                // Remover itens existentes
                $this->db->query("DELETE FROM os_itens WHERE id_os = ?", [$osId]);
                
                // Inserir novos itens
                if (!empty($data['itens'])) {
                    $this->insertOrderItems($osId, $data['itens']);
                }
            }
            
            // Registrar no histórico
            $this->logAction($osId, 'edicao', null, $status);
            
            $this->db->getConnection()->commit();
            return true;
        } catch (Exception $e) {
            $this->db->getConnection()->rollback();
            throw $e;
        }
    }
    
    private function getOriginalOrderData($osId) {
        // Buscar os dados originais da OS do backup
        // Precisamos do backup ANTES da edição que está sendo rejeitada
        // Por isso buscamos o penúltimo backup (o último é a edição atual)
        
        $sql = "SELECT * FROM os_backup WHERE id_os = ? ORDER BY data_backup DESC LIMIT 1,1";
        $stmt = $this->db->query($sql, [$osId]);
        $originalData = $stmt->fetch();
        
        // Se não encontrar o penúltimo, buscar o mais antigo
        if (!$originalData) {
            $sql = "SELECT * FROM os_backup WHERE id_os = ? ORDER BY data_backup ASC LIMIT 1";
            $stmt = $this->db->query($sql, [$osId]);
            $originalData = $stmt->fetch();
        }
        
        error_log("getOriginalOrderData para OS $osId - Dados originais: " . json_encode($originalData));
        
        return $originalData;
    }
    
    private function backupOriginalData($osId) {
        error_log("backupOriginalData chamado para OS: $osId");
        
        // Buscar dados atuais da OS
        $sql = "SELECT tipo_manutencao, prioridade, sistemas_afetados, sintomas_detectados, 
                       causas_defeitos, intervencoes_realizadas, acoes_realizadas, observacoes
                FROM ordem_servico WHERE id_os = ?";
        
        error_log("SQL backup: $sql");
        
        $stmt = $this->db->query($sql, [$osId]);
        $currentData = $stmt->fetch();
        
        error_log("Dados atuais encontrados: " . json_encode($currentData));
        
        if ($currentData) {
            // Inserir backup dos dados originais
            $sql = "INSERT INTO os_backup (id_os, tipo_manutencao, prioridade, sistemas_afetados, 
                                          sintomas_detectados, causas_defeitos, intervencoes_realizadas, 
                                          acoes_realizadas, observacoes)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            error_log("SQL insert backup: $sql");
            error_log("Valores para backup: " . json_encode([
                $osId,
                $currentData['tipo_manutencao'],
                $currentData['prioridade'],
                $currentData['sistemas_afetados'],
                $currentData['sintomas_detectados'],
                $currentData['causas_defeitos'],
                $currentData['intervencoes_realizadas'],
                $currentData['acoes_realizadas'],
                $currentData['observacoes']
            ]));
            
            try {
                $this->db->query($sql, [
                    $osId,
                    $currentData['tipo_manutencao'],
                    $currentData['prioridade'],
                    $currentData['sistemas_afetados'],
                    $currentData['sintomas_detectados'],
                    $currentData['causas_defeitos'],
                    $currentData['intervencoes_realizadas'],
                    $currentData['acoes_realizadas'],
                    $currentData['observacoes']
                ]);
                error_log("Backup criado com sucesso para OS: $osId");
            } catch (Exception $e) {
                error_log("Erro ao criar backup: " . $e->getMessage());
                throw $e;
            }
        } else {
            error_log("Nenhum dado encontrado para backup da OS: $osId");
        }
    }


}