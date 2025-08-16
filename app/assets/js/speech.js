/**
 * Reconhecimento de Voz (Speech Recognition)
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 * 
 * Compatibilidade testada:
 * - Chrome/Chromium no Ubuntu: ✅ (com possíveis erros de rede que são ignorados)
 * - Firefox: ❌ (não suportado)
 * - Safari: ✅ 
 * - Edge: ✅
 */

// Debug para Ubuntu/Chromium
if (navigator.userAgent.includes('Ubuntu') || navigator.userAgent.includes('Chromium')) {
    console.log('🐧 Sistema Ubuntu/Chromium detectado - aplicando configurações específicas');
    console.log('ℹ️ Erros de rede podem ser normais e serão ignorados automaticamente');
}

// Inicialização prévia para reduzir delay
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar speech recognition em background para reduzir delay
    if (window.speechRecognition && window.speechRecognition.isSupported()) {
        console.log('🚀 Inicializando speech recognition em background...');
        window.speechRecognition.init();
    }
});

window.speechRecognition = {
    recognition: null,
    isListening: false,
    currentTarget: null,
    isInitialized: false,
    lastError: null,
    manualStop: false,
    retryCount: 0,
    
    // Inicialização
    init() {
        if (this.isInitialized) {
            return true;
        }
        
        // Verificar suporte do navegador
        if ('webkitSpeechRecognition' in window) {
            this.recognition = new webkitSpeechRecognition();
        } else if ('SpeechRecognition' in window) {
            this.recognition = new SpeechRecognition();
        } else {
            console.log('Speech Recognition não suportado neste navegador');
            return false;
        }
        
        this.setupRecognition();
        this.isInitialized = true;
        console.log('Speech Recognition initialized successfully');
        return true;
    },
    
    // Configurar reconhecimento
    setupRecognition() {
        if (!this.recognition) return;
        
        // Configurações otimizadas para frases longas e resposta rápida
        this.recognition.continuous = true; // Permite frases mais longas
        this.recognition.interimResults = true; // Mostra resultados em tempo real
        this.recognition.maxAlternatives = 1;
        
        // Configurações para melhorar captura de frases longas
        if (this.recognition.grammars) {
            // Definir gramática para melhorar reconhecimento
            this.recognition.grammars = null; // Usar gramática padrão do navegador
        }
        
        // Configurações para frases longas
        if (this.recognition.serviceURI) {
            // Usar serviço padrão do navegador para melhor compatibilidade
            this.recognition.serviceURI = null;
        }
        
        // Definir idioma baseado na configuração (otimizado)
        const lang = window.app?.config?.language || 'pt-br';
        const langMap = {
            'pt-br': 'pt-BR',
            'en-gb': 'en-GB',
            'es-es': 'es-ES'
        };
        this.recognition.lang = langMap[lang] || 'pt-BR';
        
        // Configurações adicionais para reduzir delay
        if (this.recognition.audioContext) {
            this.recognition.audioContext.resume();
        }
        
        // Event listeners
        this.recognition.onstart = () => {
            console.log('✅ Speech recognition started successfully');
            this.isListening = true;
            this.lastError = null;
            this.retryCount = 0; // Reset retry count quando iniciar com sucesso
            this.updateMicButton(true);
            
            // Disparar evento customizado
            document.dispatchEvent(new CustomEvent('speechstart', { 
                detail: { target: this.currentTarget } 
            }));
            
            // Mostrar notificação apenas uma vez
            if (window.app && !this.notificationShown) {
                this.notificationShown = true;
                window.app.showNotification('🎤 Fale agora...', 'info', 3000);
                
                // Reset flag após um tempo
                setTimeout(() => {
                    this.notificationShown = false;
                }, 4000);
            }
        };
        
        this.recognition.onresult = (event) => {
            let finalTranscript = '';
            let interimTranscript = '';
            
            // Processar todos os resultados para frases longas
            for (let i = event.resultIndex; i < event.results.length; i++) {
                const transcript = event.results[i][0].transcript;
                const confidence = event.results[i][0].confidence;
                
                if (event.results[i].isFinal) {
                    // Para frases longas, acumular o texto final
                    if (finalTranscript && !finalTranscript.endsWith(' ')) {
                        finalTranscript += ' ';
                    }
                    finalTranscript += transcript;
                } else {
                    // Manter apenas o último resultado temporário
                    interimTranscript = transcript;
                }
            }
            
            // Atualizar campo de texto
            if (this.currentTarget) {
                const field = document.getElementById(this.currentTarget);
                if (field) {
                    if (finalTranscript) {
                        // Para frases longas, substituir o texto existente
                        // ou adicionar ao final dependendo do contexto
                        const currentText = field.value;
                        
                        // Se o usuário está falando uma nova frase, substituir
                        // Se está continuando, adicionar ao final
                        if (currentText && !currentText.endsWith('.') && !currentText.endsWith('!') && !currentText.endsWith('?')) {
                            // Continuando a frase - adicionar espaço se necessário
                            const separator = currentText.endsWith(' ') ? '' : ' ';
                            field.value = currentText + separator + finalTranscript;
                        } else {
                            // Nova frase - substituir
                            field.value = finalTranscript;
                        }
                        
                        // Trigger evento de input para validações
                        field.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                    
                    // Mostrar texto temporário em tempo real
                    if (interimTranscript) {
                        field.placeholder = interimTranscript;
                    }
                }
            }
        };
        
        this.recognition.onerror = (event) => {
            console.log('Speech recognition error event:', event.error, event);
            
            // Tratamento especial para erro de rede no Ubuntu/Chromium
            if (event.error === 'network' && 
                (navigator.userAgent.includes('Ubuntu') || navigator.userAgent.includes('Chromium'))) {
                
                console.log('🐧 Erro de rede no Ubuntu/Chromium detectado - preparando para retry...');
                
                // Definir erro para que o onend possa detectar
                this.lastError = 'network';
                
                // Mostrar notificação informativa
                if (window.app && !this.notificationShown) {
                    this.notificationShown = true;
                    window.app.showNotification('🔄 Reconhecimento continuará automaticamente', 'info', 2000);
                }
                
                // Não fazer cleanup aqui - deixar para o onend
                return;
            }
            
            // Para outros erros, processar normalmente
            console.error('Speech recognition error (processing):', event.error);
            this.isListening = false;
            this.updateMicButton(false);
            
            // Evitar mostrar múltiplas mensagens do mesmo erro
            if (this.lastError === event.error) {
                console.log('Erro duplicado ignorado:', event.error);
                return;
            }
            
            this.lastError = event.error;
            let errorMessage = '';
            let shouldShowError = true;
            
            switch (event.error) {
                case 'no-speech':
                    errorMessage = '🔇 Nenhuma fala detectada. Tente novamente.';
                    break;
                case 'audio-capture':
                    errorMessage = '🎤 Erro no microfone. Verifique as permissões.';
                    break;
                case 'not-allowed':
                    errorMessage = '🚫 Permissão de microfone negada. Clique no ícone de microfone na barra de endereços.';
                    break;
                case 'network':
                    // Este caso já foi tratado acima para Ubuntu/Chromium
                    errorMessage = '🌐 Erro de rede. Verifique sua conexão.';
                    break;
                case 'service-not-allowed':
                    errorMessage = '⚠️ Serviço de reconhecimento não disponível. Tente usar Chrome ou Edge.';
                    break;
                case 'aborted':
                    // Erro comum ao parar manualmente - não mostrar
                    shouldShowError = false;
                    break;
                default:
                    errorMessage = `❌ Erro no reconhecimento de voz: ${event.error}`;
            }
            
            if (window.app && shouldShowError && errorMessage) {
                // Delay para evitar conflito com outras mensagens
                setTimeout(() => {
                    window.app.showNotification(errorMessage, 'error', 4000);
                }, 100);
            }
            
            // Reset error after timeout
            setTimeout(() => {
                this.lastError = null;
            }, 5000);
        };
        
        this.recognition.onend = () => {
            console.log('🔚 Speech recognition ended');
            
            // Para frases longas, tentar continuar se não foi parado manualmente
            if (!this.manualStop && this.currentTarget && this.retryCount < 2) {
                // Verificar se há texto no campo para determinar se deve continuar
                const field = document.getElementById(this.currentTarget);
                if (field && field.value && field.value.length > 0) {
                    console.log('🔄 Continuando reconhecimento para frase longa...');
                    this.retryCount++;
                    
                    // Pequeno delay antes de continuar
                    setTimeout(() => {
                        if (!this.manualStop && this.currentTarget) {
                            try {
                                this.recognition.start();
                                return; // Não executar cleanup se conseguiu continuar
                            } catch (error) {
                                console.log('❌ Falha ao continuar reconhecimento:', error);
                            }
                        }
                    }, 300);
                }
            }
            
            // Se terminou por erro de rede no Ubuntu/Chromium, tentar reiniciar
            if (this.lastError === 'network' && 
                (navigator.userAgent.includes('Ubuntu') || navigator.userAgent.includes('Chromium')) &&
                this.currentTarget && !this.manualStop && this.retryCount < 3) {
                
                this.retryCount++;
                console.log(`🔄 Tentativa de restart ${this.retryCount}/3 após erro de rede...`);
                
                // Disparar evento de retry para feedback visual
                document.dispatchEvent(new CustomEvent('speechretry', { 
                    detail: { 
                        attempt: this.retryCount,
                        target: this.currentTarget 
                    } 
                }));
                
                // Delay progressivo antes de reiniciar
                const delay = this.retryCount * 500; // 500ms, 1s, 1.5s
                
                setTimeout(() => {
                    if (this.currentTarget && !this.manualStop) {
                        console.log(`🔄 Reiniciando reconhecimento (tentativa ${this.retryCount})...`);
                        this.lastError = null;
                        
                        try {
                            this.recognition.start();
                            
                            // Mostrar feedback de retry
                            if (window.app) {
                                window.app.showNotification(`🔄 Reconectando... (${this.retryCount}/3)`, 'info', 1500);
                            }
                            
                            return; // Não executar o resto se conseguiu reiniciar
                        } catch (error) {
                            console.log(`❌ Falha ao reiniciar (tentativa ${this.retryCount}):`, error);
                            
                            // Se foi a última tentativa, mostrar erro
                            if (this.retryCount >= 3 && window.app) {
                                window.app.showNotification('❌ Reconhecimento de voz indisponível', 'error', 3000);
                            }
                        }
                    }
                    
                    // Se chegou aqui, o restart falhou - limpar estado
                    this.isListening = false;
                    this.updateMicButton(false);
                    this.manualStop = false;
                    this.retryCount = 0;
                    
                    // Disparar evento customizado
                    document.dispatchEvent(new CustomEvent('speechend', { 
                        detail: { target: this.currentTarget } 
                    }));
                }, delay);
                
                return; // Não executar cleanup ainda
            }
            
            // Cleanup normal
            this.isListening = false;
            this.updateMicButton(false);
            this.manualStop = false;
            this.currentTarget = null; // Limpar target atual
            
            // Disparar evento customizado
            document.dispatchEvent(new CustomEvent('speechend', { 
                detail: { target: null } 
            }));
            
            // Limpar placeholder temporário
            if (this.currentTarget) {
                const field = document.getElementById(this.currentTarget);
                if (field && field.placeholder && !field.value) {
                    field.placeholder = field.dataset.originalPlaceholder || '';
                }
            }
        };
    },
    
    // Iniciar reconhecimento
    start(targetElementId) {
        console.log('Tentando iniciar reconhecimento de voz para:', targetElementId);
        
        if (!this.recognition) {
            if (!this.init()) {
                if (window.app) {
                    window.app.showNotification('❌ Reconhecimento de voz não disponível neste navegador', 'error');
                }
                return false;
            }
        }
        
        // Se já está ouvindo, parar primeiro e retornar
        if (this.isListening) {
            console.log('Já está ouvindo - parando primeiro');
            this.stop();
            return false;
        }
        
        this.currentTarget = targetElementId;
        
        // Verificar se o elemento existe
        const field = document.getElementById(targetElementId);
        if (!field) {
            console.error('Campo de destino não encontrado:', targetElementId);
            if (window.app) {
                window.app.showNotification('❌ Campo de texto não encontrado', 'error');
            }
            return false;
        }
        
        // Salvar placeholder original
        field.dataset.originalPlaceholder = field.placeholder;
        
        // Reset flags
        this.lastError = null;
        this.notificationShown = false;
        this.manualStop = false;
        this.retryCount = 0;
        
        try {
            console.log('Iniciando reconhecimento...');
            
            // Inicialização otimizada para reduzir delay
            if (this.recognition.audioContext && this.recognition.audioContext.state === 'suspended') {
                this.recognition.audioContext.resume();
            }
            
            this.recognition.start();
            return true;
        } catch (error) {
            console.error('Error starting speech recognition:', error);
            
            let errorMsg = '❌ Erro ao iniciar reconhecimento';
            if (error.name === 'InvalidStateError') {
                errorMsg = '⚠️ Reconhecimento já está ativo. Tente novamente em alguns segundos.';
                // Forçar limpeza do estado
                this.forceCleanup();
            } else if (error.name === 'NotAllowedError') {
                errorMsg = '🚫 Permissão de microfone necessária. Verifique as configurações.';
            }
            
            if (window.app) {
                window.app.showNotification(errorMsg, 'error', 4000);
            }
            return false;
        }
    },
    
    // Parar reconhecimento
    stop() {
        console.log('🛑 Parando reconhecimento...');
        
        // Sempre limpar o estado
        this.isListening = false;
        this.manualStop = true;
        this.updateMicButton(false);
        
        // Tentar parar o reconhecimento se estiver disponível
        if (this.recognition) {
            try {
                this.recognition.stop();
            } catch (error) {
                console.log('Erro ao parar reconhecimento:', error);
                // Se falhar ao parar, forçar limpeza
                this.forceCleanup();
            }
        }
    },
    
    // Atualizar botão do microfone
    updateMicButton(isRecording) {
        // Atualizar botão específico se houver target atual
        if (this.currentTarget) {
            const specificButton = document.querySelector(`.mic-button[onclick*="${this.currentTarget}"]`);
            if (specificButton) {
                if (isRecording) {
                    specificButton.classList.add('recording');
                    specificButton.innerHTML = '⏹️'; // Stop icon
                    specificButton.title = 'Parar gravação';
                    specificButton.style.background = '#dc3545'; // Vermelho quando gravando
                } else {
                    specificButton.classList.remove('recording');
                    specificButton.innerHTML = '🎤'; // Mic icon
                    specificButton.title = 'Começar gravação de voz';
                    specificButton.style.background = '#007bff'; // Azul quando parado
                }
                return;
            }
        }
        
        // Fallback: atualizar todos os botões
        const buttons = document.querySelectorAll('.mic-button');
        
        buttons.forEach(button => {
            if (isRecording) {
                button.classList.add('recording');
                button.innerHTML = '⏹️'; // Stop icon
                button.title = 'Parar gravação';
                button.style.background = '#dc3545'; // Vermelho quando gravando
            } else {
                button.classList.remove('recording');
                button.innerHTML = '🎤'; // Mic icon
                button.title = 'Começar gravação de voz';
                button.style.background = '#007bff'; // Azul quando parado
            }
        });
    },
    
    // Verificar suporte
    isSupported() {
        return 'webkitSpeechRecognition' in window || 'SpeechRecognition' in window;
    },
    
    // Forçar limpeza do estado
    forceCleanup() {
        console.log('🧹 Forçando limpeza do estado...');
        this.isListening = false;
        this.manualStop = false;
        this.currentTarget = null;
        this.retryCount = 0;
        this.lastError = null;
        this.updateMicButton(false);
        
        // Tentar parar o reconhecimento se estiver ativo
        if (this.recognition) {
            try {
                this.recognition.stop();
            } catch (error) {
                console.log('Erro ao forçar parada:', error);
            }
        }
    },
    
    // Alternar idioma
    setLanguage(lang) {
        if (!this.recognition) return;
        
        const langMap = {
            'pt-br': 'pt-BR',
            'en-gb': 'en-GB', 
            'es-es': 'es-ES'
        };
        
        this.recognition.lang = langMap[lang] || 'pt-BR';
        console.log('Speech recognition language set to:', this.recognition.lang);
    }
};

// Função global para iniciar reconhecimento (compatibilidade)
function startSpeechRecognition(targetId) {
    window.speechRecognition.start(targetId);
}

// Função global para parar reconhecimento
function stopSpeechRecognition() {
    window.speechRecognition.stop();
}

// Controle de inicialização - previne múltiplas inicializações
let speechInitialized = false;

// Inicializar quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    if (speechInitialized) return;
    speechInitialized = true;
    
    console.log('Inicializando sistema de reconhecimento de voz...');
    
    if (window.speechRecognition.isSupported()) {
        // Não inicializar automaticamente, apenas preparar
        console.log('Speech Recognition suportado - pronto para uso');
    } else {
        console.log('Speech Recognition não suportado - ocultando botões de microfone');
        
        // Ocultar botões de microfone se não suportado
        setTimeout(() => {
            const micButtons = document.querySelectorAll('.mic-button');
            micButtons.forEach(button => {
                button.style.display = 'none';
                button.title = 'Reconhecimento de voz não suportado neste navegador';
            });
        }, 100);
    }
});

// Atualizar idioma quando necessário
document.addEventListener('languageChanged', (e) => {
    if (window.speechRecognition.recognition) {
        window.speechRecognition.setLanguage(e.detail.language);
    }
});

// Cleanup quando sair da página
window.addEventListener('beforeunload', () => {
    if (window.speechRecognition.isListening) {
        window.speechRecognition.stop();
    }
});

console.log('Preditix OS - Speech.js loaded');