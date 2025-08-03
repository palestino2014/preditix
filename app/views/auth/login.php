<?php
$pageTitle = Language::t('login_title');
$showHeader = false;
ob_start();
?>

<div class="login-container" style="
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--light) 0%, var(--light-gray) 100%);
">
    <div class="login-card" style="
        background: var(--white);
        padding: 40px;
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        max-width: 400px;
        width: 90%;
    ">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="logo_preditix.jpeg" alt="Preditix" style="height: 60px; margin-bottom: 20px;">
            <h1 style="color: var(--dark); margin-bottom: 10px;"><?= Language::t('login_title') ?></h1>
            <p style="color: var(--gray);"><?= Language::t('app_name') ?></p>
        </div>
        
        <!-- Mensagens de erro/sucesso -->
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="alert alert-error mb-3" style="
                background: #fee; 
                border: 1px solid #fcc; 
                color: #c33; 
                padding: 15px; 
                border-radius: var(--border-radius);
                margin-bottom: 20px;
            ">
                <?= htmlspecialchars($_SESSION['login_error']) ?>
            </div>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>
        

        
        <!-- Formulário de login -->
        <form method="POST" action="authenticate" id="login-form">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <div class="form-group">
                <label for="email" class="form-label">
                    <?= Language::t('email') ?>
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-control" 
                    required 
                    autocomplete="email"
                    placeholder="seu@email.com"
                >
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">
                    <?= Language::t('password') ?>
                </label>  
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-control" 
                    required 
                    autocomplete="current-password"
                    placeholder="••••••••"
                >
            </div>
            
            <button type="submit" class="btn btn-primary btn-lg w-full" id="login-btn">
                <span id="login-text"><?= Language::t('login_button') ?></span>
                <span id="login-loading" class="loading" style="display: none;"></span>
            </button>
        </form>
        

        
        <!-- Seletor de idioma na tela de login -->
        <div class="text-center mt-4">
            <div class="language-selector" onclick="toggleLanguageDropdown()" style="display: inline-flex; cursor: pointer;">
                <?php 
                $currentLangData = $availableLanguages[$currentLang];
                echo $currentLangData['flag'];
                ?>
                <span><?= $currentLangData['name'] ?></span>
                <span>▼</span>
            </div>
            
            <div id="language-dropdown" class="user-dropdown-content" style="display: none; position: absolute; margin-top: 5px; right: 50%; transform: translateX(50%);">
                <?php foreach ($availableLanguages as $langCode => $langData): ?>
                    <div class="dropdown-item" onclick="changeLanguage('<?= $langCode ?>')" style="padding: 8px 15px; cursor: pointer;">
                        <?= $langData['flag'] ?> <?= $langData['name'] ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Animação do formulário
document.getElementById('login-form').addEventListener('submit', function(e) {
    const btn = document.getElementById('login-btn');
    const text = document.getElementById('login-text');
    const loading = document.getElementById('login-loading');
    
    btn.disabled = true;
    text.style.display = 'none';
    loading.style.display = 'inline-block';
});

// Funções do seletor de idioma (reutilizadas do header)
function toggleLanguageDropdown() {
    const dropdown = document.getElementById('language-dropdown');
    dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
}

function changeLanguage(lang) {
    // Mostrar feedback visual
    const languageSelector = document.querySelector('.language-selector');
    const originalContent = languageSelector.innerHTML;
    languageSelector.innerHTML = '⟳ Alterando...';
    languageSelector.style.pointerEvents = 'none';
    
    // Para a tela de login, apenas recarregar com o novo idioma
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'change-language';
    
    const langInput = document.createElement('input');
    langInput.type = 'hidden';
    langInput.name = 'language';
    langInput.value = lang;
    form.appendChild(langInput);
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = 'csrf_token';
    csrfInput.value = '<?= $csrf_token ?>';
    form.appendChild(csrfInput);
    
    document.body.appendChild(form);
    form.submit();
    
    // Timeout de segurança para restaurar se algo der errado
    setTimeout(() => {
        languageSelector.innerHTML = originalContent;
        languageSelector.style.pointerEvents = 'auto';
    }, 5000);
}

// Fechar dropdown ao clicar fora
document.addEventListener('click', function(event) {
    if (!event.target.closest('.language-selector')) {
        document.getElementById('language-dropdown').style.display = 'none';
    }
});

// PWA install prompt
let deferredPrompt;

window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    
    // Mostrar botão de instalação após login bem-sucedido
    // (implementar se necessário)
});
</script>

<?php
$content = ob_get_clean();
include 'views/layouts/app.php';
?>