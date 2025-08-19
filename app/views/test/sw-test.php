<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste Service Worker - Preditix</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
        }
        
        .test-container {
            max-width: 800px;
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
        
        .log-area {
            background: #1e1e1e;
            color: #00ff00;
            padding: 15px;
            border-radius: 6px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            max-height: 300px;
            overflow-y: auto;
            white-space: pre-wrap;
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
        .status-warning { background: #ffc107; }
        
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
        <h1>🔧 Teste Service Worker - Preditix</h1>
        <p>Esta página testa especificamente o Service Worker e identifica problemas.</p>
        
        <div class="test-section">
            <h3>📱 Verificação do Navegador</h3>
            
            <div class="test-item">
                <strong>🌐 Protocolo:</strong> 
                <span id="protocol"></span>
            </div>
            
            <div class="test-item">
                <strong>🏠 Hostname:</strong> 
                <span id="hostname"></span>
            </div>
            
            <div class="test-item">
                <strong>📱 User Agent:</strong>
                <div style="font-size: 12px; word-break: break-all; background: #f1f3f4; padding: 10px; border-radius: 4px; margin-top: 10px;">
                    <span id="user-agent"></span>
                </div>
            </div>
            
            <div class="test-item">
                <strong>🔧 Service Worker Suportado:</strong> 
                <span id="sw-support"></span>
            </div>
        </div>
        
        <div class="test-section">
            <h3>🔄 Registro do Service Worker</h3>
            
            <div class="test-item">
                <strong>📁 Caminho do SW:</strong> 
                <span id="sw-path"></span>
            </div>
            
            <div class="test-item">
                <strong>📝 Status do Registro:</strong> 
                <span id="sw-status"></span>
            </div>
            
            <div class="test-item">
                <strong>🎯 Ações:</strong>
                <button class="btn" onclick="registerSW()">Registrar SW</button>
                <button class="btn" onclick="unregisterSW()">Remover SW</button>
                <button class="btn" onclick="checkRegistrations()">Verificar Registros</button>
            </div>
        </div>
        
        <div class="test-section">
            <h3>📊 Informações do Service Worker</h3>
            
            <div class="test-item">
                <strong>📋 Registros Ativos:</strong> 
                <span id="active-registrations"></span>
            </div>
            
            <div class="test-item">
                <strong>💾 Cache:</strong> 
                <span id="cache-status"></span>
            </div>
            
            <div class="test-item">
                <strong>📱 PWA:</strong> 
                <span id="pwa-status"></span>
            </div>
        </div>
        
        <div class="test-section">
            <h3>📝 Logs do Console</h3>
            
            <div class="test-item">
                <strong>🔍 Logs em Tempo Real:</strong>
                <button class="btn" onclick="clearLogs()">Limpar Logs</button>
                <button class="btn" onclick="copyLogs()">Copiar Logs</button>
            </div>
            
            <div class="log-area" id="log-area">
                Iniciando logs...\n
            </div>
        </div>
        
        <div class="test-section">
            <h3>🔧 Solução de Problemas</h3>
            
            <div class="test-item warning">
                <strong>⚠️ Problemas Comuns:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li><strong>HTTPS:</strong> Service Worker requer HTTPS (exceto localhost)</li>
                    <li><strong>Arquivo SW:</strong> Verificar se sw.js existe e é acessível</li>
                    <li><strong>Cache:</strong> Limpar cache do navegador</li>
                    <li><strong>Console:</strong> Verificar erros no console do navegador</li>
                </ul>
            </div>
            
            <div class="test-item">
                <strong>🧪 Teste de Arquivo:</strong>
                <button class="btn" onclick="testSWFile()">Testar Acesso ao SW</button>
                <span id="file-test-result"></span>
            </div>
        </div>
    </div>

    <script>
        let logArea;
        
        // Função para adicionar logs
        function addLog(message) {
            const timestamp = new Date().toLocaleTimeString();
            logArea.textContent += `[${timestamp}] ${message}\n`;
            logArea.scrollTop = logArea.scrollHeight;
            console.log(message);
        }
        
        // Verificar informações básicas
        function checkBasicInfo() {
            document.getElementById('protocol').textContent = location.protocol;
            document.getElementById('hostname').textContent = location.hostname;
            document.getElementById('user-agent').textContent = navigator.userAgent;
            
            if ('serviceWorker' in navigator) {
                document.getElementById('sw-support').innerHTML = 
                    '<span class="status-indicator status-online"></span> Sim';
                addLog('✅ Service Worker suportado pelo navegador');
            } else {
                document.getElementById('sw-support').innerHTML = 
                    '<span class="status-indicator status-offline"></span> Não';
                addLog('❌ Service Worker não suportado pelo navegador');
            }
            
            // Verificar se é HTTPS
            if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
                addLog('⚠️ ATENÇÃO: Service Worker requer HTTPS (exceto localhost)');
                addLog('🔧 Solução: Use localhost ou configure HTTPS');
            } else {
                addLog('✅ Protocolo adequado para Service Worker');
            }
        }
        
        // Registrar Service Worker
        function registerSW() {
            if (!('serviceWorker' in navigator)) {
                addLog('❌ Service Worker não suportado');
                return;
            }
            
            const swPath = '/app/sw.js';
            document.getElementById('sw-path').textContent = swPath;
            addLog(`🔄 Tentando registrar Service Worker em: ${swPath}`);
            
            navigator.serviceWorker.register(swPath)
                .then(registration => {
                    addLog('✅ Service Worker registrado com sucesso');
                    addLog(`📱 ID: ${registration.id}`);
                    addLog(`📱 Estado: ${registration.active ? 'Ativo' : 'Inativo'}`);
                    
                    document.getElementById('sw-status').innerHTML = 
                        '<span class="status-indicator status-online"></span> Registrado com sucesso';
                    
                    checkRegistrations();
                })
                .catch(error => {
                    addLog(`❌ Erro ao registrar Service Worker: ${error.message}`);
                    addLog(`🔍 Tipo de erro: ${error.name}`);
                    
                    document.getElementById('sw-status').innerHTML = 
                        '<span class="status-indicator status-offline"></span> Erro: ' + error.message;
                });
        }
        
        // Remover Service Worker
        function unregisterSW() {
            if (!('serviceWorker' in navigator)) {
                addLog('❌ Service Worker não suportado');
                return;
            }
            
            navigator.serviceWorker.getRegistrations().then(registrations => {
                if (registrations.length === 0) {
                    addLog('ℹ️ Nenhum Service Worker registrado para remover');
                    return;
                }
                
                registrations.forEach(registration => {
                    registration.unregister().then(() => {
                        addLog('✅ Service Worker removido com sucesso');
                        document.getElementById('sw-status').innerHTML = 
                            '<span class="status-indicator status-offline"></span> Removido';
                        checkRegistrations();
                    }).catch(error => {
                        addLog(`❌ Erro ao remover Service Worker: ${error.message}`);
                    });
                });
            });
        }
        
        // Verificar registros
        function checkRegistrations() {
            if (!('serviceWorker' in navigator)) {
                addLog('❌ Service Worker não suportado');
                return;
            }
            
            navigator.serviceWorker.getRegistrations().then(registrations => {
                addLog(`📋 Encontrados ${registrations.length} registros de Service Worker`);
                
                if (registrations.length === 0) {
                    document.getElementById('active-registrations').innerHTML = 
                        '<span class="status-indicator status-offline"></span> Nenhum registro ativo';
                } else {
                    document.getElementById('active-registrations').innerHTML = 
                        `<span class="status-indicator status-online"></span> ${registrations.length} registro(s) ativo(s)`;
                    
                    registrations.forEach((registration, index) => {
                        addLog(`📱 Registro ${index + 1}:`);
                        addLog(`   - ID: ${registration.id}`);
                        addLog(`   - Estado: ${registration.active ? 'Ativo' : 'Inativo'}`);
                        addLog(`   - Escopo: ${registration.scope}`);
                    });
                }
            }).catch(error => {
                addLog(`❌ Erro ao verificar registros: ${error.message}`);
            });
        }
        
        // Testar acesso ao arquivo SW
        function testSWFile() {
            const swPath = '/app/sw.js';
            addLog(`🔍 Testando acesso ao arquivo: ${swPath}`);
            
            fetch(swPath)
                .then(response => {
                    if (response.ok) {
                        addLog('✅ Arquivo sw.js acessível');
                        document.getElementById('file-test-result').innerHTML = 
                            '<span class="status-indicator status-online"></span> Arquivo acessível';
                    } else {
                        addLog(`❌ Arquivo sw.js não encontrado (${response.status})`);
                        document.getElementById('file-test-result').innerHTML = 
                            '<span class="status-indicator status-offline"></span> Arquivo não encontrado';
                    }
                })
                .catch(error => {
                    addLog(`❌ Erro ao acessar arquivo: ${error.message}`);
                    document.getElementById('file-test-result').innerHTML = 
                        '<span class="status-indicator status-offline"></span> Erro de acesso';
                });
        }
        
        // Verificar cache
        function checkCache() {
            if ('caches' in window) {
                caches.keys().then(cacheNames => {
                    addLog(`💾 Caches encontrados: ${cacheNames.length}`);
                    cacheNames.forEach(name => {
                        addLog(`   - ${name}`);
                    });
                    
                    if (cacheNames.length > 0) {
                        document.getElementById('cache-status').innerHTML = 
                            `<span class="status-indicator status-online"></span> ${cacheNames.length} cache(s)`;
                    } else {
                        document.getElementById('cache-status').innerHTML = 
                            '<span class="status-indicator status-offline"></span> Nenhum cache';
                    }
                });
            } else {
                addLog('❌ Cache API não suportada');
                document.getElementById('cache-status').innerHTML = 
                    '<span class="status-indicator status-offline"></span> Não suportado';
            }
        }
        
        // Verificar PWA
        function checkPWA() {
            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.ready.then(registration => {
                    addLog('✅ Service Worker pronto para PWA');
                    document.getElementById('pwa-status').innerHTML = 
                        '<span class="status-indicator status-online"></span> Pronto';
                }).catch(error => {
                    addLog(`❌ Service Worker não está pronto: ${error.message}`);
                    document.getElementById('pwa-status').innerHTML = 
                        '<span class="status-indicator status-offline"></span> Não pronto';
                });
            } else {
                addLog('❌ Service Worker não suportado para PWA');
                document.getElementById('pwa-status').innerHTML = 
                    '<span class="status-indicator status-offline"></span> Não suportado';
            }
        }
        
        // Limpar logs
        function clearLogs() {
            logArea.textContent = 'Logs limpos...\n';
        }
        
        // Copiar logs
        function copyLogs() {
            navigator.clipboard.writeText(logArea.textContent).then(() => {
                addLog('📋 Logs copiados para a área de transferência');
            }).catch(() => {
                addLog('❌ Erro ao copiar logs');
            });
        }
        
        // Inicializar
        window.addEventListener('load', () => {
            logArea = document.getElementById('log-area');
            
            addLog('🚀 Iniciando teste do Service Worker...');
            checkBasicInfo();
            checkRegistrations();
            checkCache();
            checkPWA();
            
            addLog('✅ Teste inicializado. Use os botões para testar funcionalidades.');
        });
    </script>
</body>
</html>
