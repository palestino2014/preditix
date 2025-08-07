<?php
/**
 * Controller Base
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

class BaseController {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
        $this->checkSession();
    }
    
    protected function checkSession() {
        // Páginas que não precisam de autenticação
        $publicPages = ['login', 'authenticate'];
        $currentPage = $this->getCurrentPage();
        
        if (!in_array($currentPage, $publicPages) && !$this->isAuthenticated()) {
            $this->redirect('/login');
        }
    }
    
    protected function isAuthenticated() {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_type']);
    }
    
    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            http_response_code(401);
            $this->jsonResponse(['error' => Language::t('session_expired')]);
            exit;
        }
    }
    
    protected function requireRole($role) {
        $this->requireAuth();
        
        if ($_SESSION['user_type'] !== $role) {
            http_response_code(403);
            $this->jsonResponse(['error' => Language::t('error_permission')]);
            exit;
        }
    }
    
    protected function getCurrentUser() {
        if (!$this->isAuthenticated()) {
            return null;
        }
        
        return [
            'id' => $_SESSION['user_id'],
            'name' => $_SESSION['user_name'],
            'email' => $_SESSION['user_email'],
            'type' => $_SESSION['user_type']
        ];
    }
    
    protected function getCurrentPage() {
        $uri = trim($_GET['url'] ?? '', '/');
        return explode('/', $uri)[0];
    }
    
    protected function redirect($url) {
        // Se a URL começar com /, adicionar o base path
        if (strpos($url, '/') === 0) {
            $basePath = dirname($_SERVER['SCRIPT_NAME']);
            if ($basePath === '/' || $basePath === '\\') {
                $basePath = '';
            }
            $url = $basePath . $url;
        }
        
        // Para URLs dinâmicas, adicionar parâmetro anti-cache se ainda não tiver
        if (!strpos($url, '?') && !strpos($url, '#') && 
            (strpos($url, 'dashboard') || strpos($url, 'os/') || strpos($url, 'login'))) {
            $url .= '?_r=' . time();
        }
        
        header("Location: $url");
        exit;
    }
    
    protected function jsonResponse($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
    
    protected function view($view, $data = []) {
        // Dados globais disponíveis em todas as views
        $data['currentUser'] = $this->getCurrentUser();
        $data['currentLang'] = Language::getCurrentLanguage();
        $data['availableLanguages'] = Language::getAvailableLanguages();
        
        // Extrair variáveis para a view
        extract($data);
        
        // Incluir a view
        $viewFile = "views/$view.php";
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new Exception("View not found: $view");
        }
    }
    
    protected function validateCsrf() {
        $token = $_POST['csrf_token'] ?? $_GET['csrf_token'] ?? '';
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        
        if (!hash_equals($sessionToken, $token)) {
            http_response_code(403);
            $this->jsonResponse(['error' => 'Invalid CSRF token']);
            exit;
        }
    }
    
    protected function generateCsrf() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    protected function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return trim(htmlspecialchars($input, ENT_QUOTES, 'UTF-8'));
    }
    
    protected function validateRequired($fields, $data) {
        $errors = [];
        
        foreach ($fields as $field => $label) {
            if (!isset($data[$field]) || $data[$field] === '' || $data[$field] === null) {
                $errors[$field] = sprintf(Language::t('field_required'), Language::t($label));
            }
        }
        
        return $errors;
    }
    
    protected function logAction($osId, $action, $statusFrom = null, $statusTo = null, $justification = null) {
        $user = $this->getCurrentUser();
        
        $sql = "INSERT INTO os_historico (id_os, usuario_id, acao, status_de, status_para, justificativa, data_hora) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        
        $this->db->query($sql, [
            $osId,
            $user['id'],
            $action,
            $statusFrom,
            $statusTo,
            $justification
        ]);
    }
}