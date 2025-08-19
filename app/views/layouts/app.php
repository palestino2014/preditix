<!DOCTYPE html>
<html lang="<?= substr($currentLang, 0, 2) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#495057">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="<?= Language::t('app_name') ?>">
    
    <title><?= $pageTitle ?? Language::t('app_name') ?></title>
    
    <!-- PWA -->
    <link rel="manifest" href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/manifest.json">
    <link rel="icon" type="image/jpeg" href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/logo_preditix.jpeg">
    <link rel="apple-touch-icon" href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/logo_preditix.jpeg">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/assets/css/app.css">
    <?php if (isset($additionalCSS)): ?>
        <?php foreach ($additionalCSS as $css): ?>
            <link rel="stylesheet" href="<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>
    <!-- Indicador offline -->
    <div id="offline-indicator" class="offline-indicator">
        📡 <?= Language::t('offline_mode') ?>
    </div>
    
    <div class="app-container">
        <?php if ($showHeader ?? true): ?>
            <?php include 'views/layouts/header.php'; ?>
        <?php endif; ?>
        
        <main class="main-content">
            <?php if (isset($content)): ?>
                <?= $content ?>
            <?php else: ?>
                <!-- Conteúdo da página será inserido aqui pelas views -->
                <?php if (isset($pageContent)) echo $pageContent; ?>
            <?php endif; ?>
        </main>
    </div>
    
    <!-- Modais globais -->
    <div id="global-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title"></h3>
            </div>
            <div class="modal-body" id="modal-body"></div>
            <div class="modal-footer" id="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal()"><?= Language::t('cancel') ?></button>
                <button type="button" class="btn btn-primary" id="modal-confirm"><?= Language::t('confirm') ?></button>
            </div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script>
        // Configurações globais
        window.appConfig = {
            language: '<?= $currentLang ?>',
            userType: '<?= $currentUser['type'] ?? '' ?>',
            csrfToken: '<?= $_SESSION['csrf_token'] ?? '' ?>',
            basePath: '<?= dirname($_SERVER['SCRIPT_NAME']) ?>',
            translations: {
                loading: '<?= Language::t('loading') ?>',
                error: '<?= Language::t('error') ?>',
                success: '<?= Language::t('success') ?>',
                confirm: '<?= Language::t('confirm') ?>',
                cancel: '<?= Language::t('cancel') ?>',
                ok: '<?= Language::t('ok') ?>'
            }
        };
        
        // Detecção de mudança de idioma para forçar refresh
        (function() {
            const urlParams = new URLSearchParams(window.location.search);
            const urlLang = urlParams.get('_lang');
            const currentLang = window.appConfig.language;
            
            // Se parâmetro de idioma na URL difere do sessão atual
            if (urlLang && urlLang !== currentLang) {
                console.log('Diferença de idioma detectada, forçando refresh...');
                
                // Limpar URL dos parâmetros de cache
                const cleanUrl = window.location.pathname;
                window.history.replaceState({}, document.title, cleanUrl);
                
                // Forçar refresh completo ignorando cache
                setTimeout(() => {
                    window.location.reload(true);
                }, 100);
            }
        })();
    </script>
    
    <script src="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/assets/js/app.js"></script>
    <script src="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/assets/js/offline.js"></script>
    <script src="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/assets/js/speech.js"></script>
    
    <?php if (isset($additionalJS)): ?>
        <?php foreach ($additionalJS as $js): ?>
            <script src="<?= $js ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    
    <!-- Registrar Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            console.log('✅ Service Worker suportado pelo navegador');
            
            window.addEventListener('load', () => {
                const swPath = '<?= dirname($_SERVER['SCRIPT_NAME']) ?>/sw.js';
                console.log('🔄 Tentando registrar Service Worker em:', swPath);
                
                navigator.serviceWorker.register(swPath)
                    .then(registration => {
                        console.log('✅ Service Worker registrado com sucesso:', registration);
                        console.log('📱 PWA instalável:', registration.installing ? 'Sim' : 'Não');
                        
                        // Verificar se está instalado
                        if (registration.installing) {
                            console.log('📥 Service Worker está sendo instalado...');
                        } else if (registration.waiting) {
                            console.log('⏳ Service Worker está aguardando...');
                        } else if (registration.active) {
                            console.log('✅ Service Worker está ativo!');
                        }
                    })
                    .catch(registrationError => {
                        console.error('❌ Falha no registro do Service Worker:', registrationError);
                        console.error('🔍 Detalhes do erro:', {
                            name: registrationError.name,
                            message: registrationError.message,
                            stack: registrationError.stack
                        });
                        
                        // Verificar se é problema de HTTPS
                        if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
                            console.warn('⚠️ Service Worker requer HTTPS (exceto localhost)');
                        }
                    });
            });
        } else {
            console.warn('⚠️ Service Worker não suportado pelo navegador');
        }
    </script>
</body>
</html>