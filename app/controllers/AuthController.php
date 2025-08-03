<?php
/**
 * Controller de Autenticação
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

class AuthController extends BaseController {
    
    public function __construct() {
        $this->db = Database::getInstance();
        // Não chamar checkSession para permitir acesso às páginas de login
    }
    
    public function login() {
        // Redirecionar se já estiver logado
        if ($this->isAuthenticated()) {
            $this->redirect('/dashboard');
        }
        
        $this->view('auth/login', [
            'csrf_token' => $this->generateCsrf()
        ]);
    }
    
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }
        
        $this->validateCsrf();
        
        $email = $this->sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validar campos obrigatórios
        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = Language::t('invalid_credentials');
            $this->redirect('/login');
        }
        
        try {
            $user = $this->authenticateUser($email, $password);
            
            if ($user) {
                $this->createSession($user);
                // Redirecionar para dashboard com parâmetros anti-cache mais agressivos
                $timestamp = time();
                $language = $_SESSION['language'] ?? 'pt-br';
                $this->redirect("/dashboard?_login={$timestamp}&_lang={$language}&_nocache=" . rand(1000, 9999));
            } else {
                $_SESSION['login_error'] = Language::t('invalid_credentials');
                $this->redirect('/login');
            }
        } catch (Exception $e) {
            error_log("Authentication error: " . $e->getMessage());
            $_SESSION['login_error'] = Language::t('error_database');
            $this->redirect('/login');
        }
    }
    
    public function logout() {
        // Destruir sessão
        session_destroy();
        
        // Criar nova sessão para mensagem de sucesso
        session_start();
        $_SESSION['logout_success'] = Language::t('logout_success');
        
        $this->redirect('/login');
    }
    
    public function changeLanguage() {
        // Verificar se é POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }
        
        // Verificar CSRF token - mais flexível para mudança de idioma
        $token = $_POST['csrf_token'] ?? '';
        $sessionToken = $_SESSION['csrf_token'] ?? '';
        
        if (empty($token) || empty($sessionToken) || !hash_equals($sessionToken, $token)) {
            // Para mudança de idioma, permitir sem token se não estiver logado
            if (!$this->isAuthenticated()) {
                // OK, continuar
            } else {
                http_response_code(403);
                return;
            }
        }
        
        if (isset($_POST['language'])) {
            $language = $_POST['language'];
            
            // Validar idioma (apenas idiomas permitidos)
            $allowedLanguages = ['pt-br', 'en-gb', 'es-es'];
            if (in_array($language, $allowedLanguages)) {
                $_SESSION['language'] = $language;
            }
        }
        
        // Redirecionar de volta para a página anterior ou login
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if (strpos($referer, 'localhost') !== false || strpos($referer, $_SERVER['SERVER_NAME']) !== false) {
            // Adicionar parâmetro para forçar refresh
            $separator = strpos($referer, '?') !== false ? '&' : '?';
            $this->redirect($referer . $separator . '_lang_changed=' . time());
        } else {
            $this->redirect('/?_lang_changed=' . time());
        }
    }
    
    private function authenticateUser($email, $password) {
        $sql = "SELECT id, nome, email, senha, acesso 
                FROM usuario 
                WHERE email = ? AND ativo = 1";
        
        $stmt = $this->db->query($sql, [$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['senha'])) {
            return $user;
        }
        
        return false;
    }
    
    private function createSession($user) {
        // Regenerar ID da sessão por segurança
        session_regenerate_id(true);
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['nome'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_type'] = $user['acesso'];
        $_SESSION['login_time'] = time();
        
        // CSRF token
        $this->generateCsrf();
    }
}