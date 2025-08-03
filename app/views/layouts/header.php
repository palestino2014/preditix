<?php if ($currentUser): ?>
<header class="app-header">
    <div class="header-left">
        <img src="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/logo_preditix.jpeg" alt="Preditix" class="logo-img">
        
        <?php if (isset($showFilter) && $showFilter): ?>
            <button type="button" class="btn btn-secondary" id="filter-button">
                🔍 <?= Language::t('filter') ?>
            </button>
        <?php endif; ?>
    </div>
    
    <div class="header-right">
        <!-- Seletor de idioma -->
        <div class="language-selector" onclick="this.querySelector('#language-dropdown').style.display = this.querySelector('#language-dropdown').style.display === 'block' ? 'none' : 'block'">
            <?php 
            $availableLanguages = $availableLanguages ?? Language::getAvailableLanguages();
            $currentLang = $currentLang ?? Language::getCurrentLanguage();
            $currentLangData = $availableLanguages[$currentLang] ?? $availableLanguages['pt-br'];
            echo $currentLangData['flag'];
            ?>
            <span><?= $currentLangData['name'] ?></span>
            <span>▼</span>
            
            <!-- Dropdown de idiomas DENTRO do seletor -->
            <div id="language-dropdown" style="display: none; position: absolute; top: 100%; right: 0; background: white; border: 1px solid #ccc; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); z-index: 9999; min-width: 140px; margin-top: 2px;">
                <?php foreach ($availableLanguages as $langCode => $langData): ?>
                    <div onclick="event.stopPropagation(); changeLanguage('<?= $langCode ?>')" style="padding: 10px 15px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 14px; transition: background 0.2s;" onmouseover="this.style.background='#f8f9fa'" onmouseout="this.style.background='white'">
                        <?= $langData['flag'] ?> <?= $langData['name'] ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        

        
        <!-- Informações do usuário -->
        <div class="user-dropdown">
            <button type="button" class="user-button" onclick="toggleUserDropdown()">
                👤 <?= htmlspecialchars($currentUser['name']) ?>
                <span>▼</span>
            </button>
            
            <div class="user-dropdown-content">
                <div style="padding: 10px; border-bottom: 1px solid var(--light-gray);">
                    <div style="font-weight: 600;"><?= htmlspecialchars($currentUser['name']) ?></div>
                    <div style="color: var(--gray); font-size: 14px;"><?= htmlspecialchars($currentUser['email']) ?></div>
                    <div style="color: var(--gray); font-size: 14px;">
                        <?= Language::t('user_type_' . $currentUser['type']) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Botão de sair -->
                        <a href="logout" class="btn btn-secondary">
            🚪 <?= Language::t('logout') ?>
        </a>
    </div>
</header>

<script>
function toggleLanguageDropdown() {
    const dropdown = document.getElementById('language-dropdown');
    if (!dropdown) return;
    
    const isHidden = dropdown.style.display === 'none' || dropdown.style.display === '';
    dropdown.style.display = isHidden ? 'block' : 'none';
    
    // Fechar dropdown do usuário se estiver aberto
    const userDropdown = document.querySelector('.user-dropdown');
    if (userDropdown) {
        userDropdown.classList.remove('active');
    }
}

function toggleUserDropdown() {
    const userDropdown = document.querySelector('.user-dropdown');
    userDropdown.classList.toggle('active');
    
    // Fechar dropdown de idioma se estiver aberto
    document.getElementById('language-dropdown').style.display = 'none';
}

function changeLanguage(lang) {
    // Mostrar feedback visual
    const languageSelector = document.querySelector('.language-selector');
    const originalContent = languageSelector.innerHTML;
    languageSelector.innerHTML = '⟳ Alterando...';
    languageSelector.style.pointerEvents = 'none';
    
    // Fechar o dropdown
    const dropdown = document.getElementById('language-dropdown');
    if (dropdown) {
        dropdown.style.display = 'none';
    }
    
    // Criar formulário para mudança de idioma
    const form = document.createElement('form');
    form.method = 'POST';
    
    // Usar caminho correto para mudança de idioma
    form.action = '/preditix/app/change-language';
    form.style.display = 'none';
    
    const langInput = document.createElement('input');
    langInput.type = 'hidden';
    langInput.name = 'language';
    langInput.value = lang;
    form.appendChild(langInput);
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = 'csrf_token';
    csrfInput.value = window.appConfig.csrfToken || '';
    form.appendChild(csrfInput);
    
    document.body.appendChild(form);
    form.submit();
    
    // Timeout de segurança para restaurar se algo der errado
    setTimeout(() => {
        languageSelector.innerHTML = originalContent;
        languageSelector.style.pointerEvents = 'auto';
        if (dropdown) {
            dropdown.style.display = 'none';
        }
    }, 5000);
}

// Fechar dropdowns ao clicar fora
document.addEventListener('click', function(event) {
    if (!event.target.closest('.language-selector')) {
        const dropdown = document.getElementById('language-dropdown');
        if (dropdown) {
            dropdown.style.display = 'none';
        }
    }
    
    if (!event.target.closest('.user-dropdown')) {
        const userDropdown = document.querySelector('.user-dropdown');
        if (userDropdown) {
            userDropdown.classList.remove('active');
        }
    }
});


</script>
<?php endif; ?>