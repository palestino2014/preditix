<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Mobile - Preditix</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
        }
        
        .test-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .test-section {
            margin-bottom: 30px;
            padding: 20px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
        }
        
        .test-section h3 {
            margin-top: 0;
            color: #495057;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }
        
        .test-item {
            margin: 15px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #007bff;
        }
        
        .test-item.success {
            border-left-color: #28a745;
            background: #d4edda;
        }
        
        .test-item.warning {
            border-left-color: #ffc107;
            background: #fff3cd;
        }
        
        .test-item.error {
            border-left-color: #dc3545;
            background: #f8d7da;
        }
        
        .btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
            min-height: 44px;
        }
        
        .btn:hover {
            background: #0056b3;
        }
        
        .btn:active {
            transform: scale(0.98);
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 6px;
            font-size: 16px;
            margin: 10px 0;
            box-sizing: border-box;
        }
        
        .form-control:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 3px rgba(0,123,255,0.1);
        }
        
        .status-indicator {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
        
        .status-online { background: #28a745; }
        .status-offline { background: #dc3545; }
        
        @media (max-width: 768px) {
            .test-container {
                margin: 10px;
                padding: 15px;
            }
            
            .test-section {
                padding: 15px;
            }
            
            .btn {
                width: 100%;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>🧪 Teste Mobile - Preditix</h1>
        <p>Esta página testa funcionalidades específicas para dispositivos móveis.</p>
        
        <div class="test-section">
            <h3>📱 Responsividade</h3>
            
            <div class="test-item success">
                <strong>✅ Viewport:</strong> Meta tag configurada corretamente
            </div>
            
            <div class="test-item success">
                <strong>✅ CSS Responsivo:</strong> Media queries implementadas
            </div>
            
            <div class="test-item">
                <strong>🔍 Teste de Tamanho:</strong> 
                <span id="screen-size"></span>
            </div>
            
            <div class="test-item">
                <strong>📐 Orientação:</strong> 
                <span id="orientation"></span>
            </div>
        </div>
        
        <div class="test-section">
            <h3>🎯 Funcionalidades Touch</h3>
            
            <div class="test-item">
                <strong>👆 Botões Touch:</strong>
                <button class="btn" onclick="testTouch(this)">Testar Touch</button>
                <button class="btn" onclick="testTouch(this)">Botão 2</button>
            </div>
            
            <div class="test-item">
                <strong>📝 Formulário:</strong>
                <input type="text" class="form-control" placeholder="Digite algo (teste zoom iOS)">
                <input type="email" class="form-control" placeholder="Email">
            </div>
            
            <div class="test-item">
                <strong>🔄 Scroll:</strong>
                <div style="height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 10px;">
                    <p>Teste de scroll em dispositivos móveis. Role para baixo para verificar se funciona suavemente.</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                    <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
            </div>
        </div>
        
        <div class="test-section">
            <h3>🌐 PWA e Offline</h3>
            
            <div class="test-item">
                <strong>📱 PWA:</strong> 
                <span id="pwa-status">Verificando...</span>
            </div>
            
            <div class="test-item">
                <strong>📡 Conexão:</strong> 
                <span id="connection-status">
                    <span class="status-indicator status-online"></span>
                    Online
                </span>
            </div>
            
            <div class="test-item">
                <strong>💾 Service Worker:</strong> 
                <span id="sw-status">Verificando...</span>
            </div>
        </div>
        
        <div class="test-section">
            <h3>📊 Informações do Dispositivo</h3>
            
            <div class="test-item">
                <strong>📱 User Agent:</strong>
                <div style="font-size: 12px; word-break: break-all; background: #f1f3f4; padding: 10px; border-radius: 4px; margin-top: 10px;">
                    <span id="user-agent"></span>
                </div>
            </div>
            
            <div class="test-item">
                <strong>🖥️ Resolução:</strong> 
                <span id="resolution"></span>
            </div>
            
            <div class="test-item">
                <strong>🎨 Cores:</strong> 
                <span id="color-depth"></span>
            </div>
        </div>
        
        <div class="test-section">
            <h3>🧪 Testes Manuais</h3>
            
            <div class="test-item warning">
                <strong>⚠️ Teste Manual Necessário:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Gire o dispositivo (portrait/landscape)</li>
                    <li>Teste zoom (pinch to zoom)</li>
                    <li>Verifique se não há scroll horizontal</li>
                    <li>Teste navegação por toque</li>
                    <li>Verifique se botões são fáceis de tocar</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Funções de teste
        function testTouch(button) {
            button.style.background = '#28a745';
            button.textContent = '✅ Tocado!';
            setTimeout(() => {
                button.style.background = '#007bff';
                button.textContent = 'Testar Touch';
            }, 1000);
        }
        
        // Informações da tela
        function updateScreenInfo() {
            document.getElementById('screen-size').textContent = 
                `${window.innerWidth} x ${window.innerHeight}`;
            
            document.getElementById('orientation').textContent = 
                window.innerWidth > window.innerHeight ? 'Landscape' : 'Portrait';
            
            document.getElementById('resolution').textContent = 
                `${screen.width} x ${screen.height}`;
            
            document.getElementById('color-depth').textContent = 
                `${screen.colorDepth} bits`;
        }
        
        // Verificar PWA
        function checkPWA() {
            if ('serviceWorker' in navigator) {
                console.log('✅ Service Worker suportado pelo navegador');
                
                navigator.serviceWorker.getRegistrations().then(registrations => {
                    console.log('📋 Registros de SW encontrados:', registrations);
                    
                    if (registrations.length > 0) {
                        document.getElementById('pwa-status').innerHTML = 
                            '<span class="status-indicator status-online"></span> Service Worker ativo (' + registrations.length + ' registros)';
                    } else {
                        document.getElementById('pwa-status').innerHTML = 
                            '<span class="status-indicator status-offline"></span> Service Worker não encontrado';
                        
                        // Tentar registrar novamente
                        console.log('🔄 Tentando registrar Service Worker...');
                        navigator.serviceWorker.register('/app/sw.js')
                            .then(registration => {
                                console.log('✅ SW registrado com sucesso:', registration);
                                document.getElementById('pwa-status').innerHTML = 
                                    '<span class="status-indicator status-online"></span> Service Worker registrado agora!';
                            })
                            .catch(error => {
                                console.error('❌ Erro ao registrar SW:', error);
                                document.getElementById('pwa-status').innerHTML = 
                                    '<span class="status-indicator status-offline"></span> Erro: ' + error.message;
                            });
                    }
                }).catch(error => {
                    console.error('❌ Erro ao verificar registros:', error);
                    document.getElementById('pwa-status').innerHTML = 
                        '<span class="status-indicator status-offline"></span> Erro ao verificar: ' + error.message;
                });
            } else {
                console.log('❌ Service Worker não suportado pelo navegador');
                document.getElementById('pwa-status').innerHTML = 
                    '<span class="status-indicator status-offline"></span> Service Worker não suportado';
            }
        }
        
        // Verificar conexão
        function checkConnection() {
            if (navigator.onLine) {
                document.getElementById('connection-status').innerHTML = 
                    '<span class="status-indicator status-online"></span> Online';
            } else {
                document.getElementById('connection-status').innerHTML = 
                    '<span class="status-indicator status-offline"></span> Offline';
            }
        }
        
        // Verificar Service Worker
        function checkServiceWorker() {
            if ('serviceWorker' in navigator) {
                console.log('🔍 Verificando Service Worker...');
                
                navigator.serviceWorker.ready.then(registration => {
                    console.log('✅ Service Worker pronto:', registration);
                    document.getElementById('sw-status').innerHTML = 
                        '<span class="status-indicator status-online"></span> Ativo e pronto';
                }).catch(error => {
                    console.error('❌ Service Worker não está pronto:', error);
                    document.getElementById('sw-status').innerHTML = 
                        '<span class="status-indicator status-offline"></span> Não ativo: ' + error.message;
                });
            } else {
                console.log('❌ Service Worker não suportado');
                document.getElementById('sw-status').innerHTML = 
                    '<span class="status-indicator status-offline"></span> Não suportado';
            }
        }
        
        // Inicializar testes
        window.addEventListener('load', () => {
            updateScreenInfo();
            checkPWA();
            checkConnection();
            checkServiceWorker();
            
            document.getElementById('user-agent').textContent = navigator.userAgent;
            
            // Atualizar informações quando a tela mudar
            window.addEventListener('resize', updateScreenInfo);
            window.addEventListener('orientationchange', updateScreenInfo);
            
            // Monitorar mudanças de conexão
            window.addEventListener('online', checkConnection);
            window.addEventListener('offline', checkConnection);
        });
    </script>
</body>
</html>
