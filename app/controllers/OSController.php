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
            
            $this->view('os/create', [
                'vehicles' => $vehicles,
                'users' => $users,
                'userType' => $user['type'],
                'csrf_token' => $this->generateCsrf()
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
                'csrf_token' => $this->generateCsrf()
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
    
    private function getOrdersForUser($user) {
        if ($user['type'] === 'tecnico') {
            $sql = "SELECT os.*, v.tag, v.modelo, v.cor, v.placa 
                    FROM ordem_servico os 
                    JOIN veiculo v ON os.id_ativo = v.id_ativo 
                    WHERE os.id_responsavel = ? 
                    ORDER BY os.created_at DESC";
            $params = [$user['id']];
        } else {
            $sql = "SELECT os.*, v.tag, v.modelo, v.cor, v.placa 
                    FROM ordem_servico os 
                    JOIN veiculo v ON os.id_ativo = v.id_ativo 
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
            $sql = "SELECT id, nome FROM usuario WHERE acesso = 'gestor' AND ativo = 1 ORDER BY nome";
        } else {
            // Gestor vê apenas técnicos
            $sql = "SELECT id, nome FROM usuario WHERE acesso = 'tecnico' AND ativo = 1 ORDER BY nome";
        }
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    private function validateOrderData($data) {
        $required = [
            'id_ativo' => 'vehicle',
            'tipo_manutencao' => 'maintenance_type',
            'prioridade' => 'priority'
        ];
        
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
                $autorizada = false;
                $dataAbertura = null;
                $dataAprovacao = null;
            } else {
                $idGestor = $user['id'];
                $idResponsavel = (int)$data['id_responsavel'];
                $status = 'em_andamento';
                $autorizada = true;
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
        $sql = "INSERT INTO os_itens (id_os, descricao, quantidade, valor_unitario) VALUES (?, ?, ?, ?)";
        
        foreach ($items as $item) {
            if (!empty($item['descricao'])) {
                $this->db->query($sql, [
                    $osId,
                    $item['descricao'],
                    (int)($item['quantidade'] ?? 1),
                    (float)($item['valor_unitario'] ?? 0)
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
        $updates = ['autorizada' => true];
        
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
        $updates = [
            'status_anterior' => $order['status'],
            'acao_rejeitada' => $this->getActionFromStatus($order['status'])
        ];
        
        return $this->updateOrderStatus($order['id_os'], 'rejeitada', $updates, $user, 'rejeicao', $justification);
    }
    
    private function getApprovalStatus($currentStatus) {
        $statusMap = [
            'aberta' => 'em_andamento',
            'editada' => 'em_andamento',
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
}