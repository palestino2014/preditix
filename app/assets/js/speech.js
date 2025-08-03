/**
 * Reconhecimento de Voz (Speech Recognition)
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

window.speechRecognition = {
    recognition: null,
    isListening: false,
    currentTarget: null,
    
    // Inicialização
    init() {
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
        console.log('Speech Recognition initialized');
        return true;
    },
    
    // Configurar reconhecimento
    setupRecognition() {
        if (!this.recognition) return;
        
        // Configurações
        this.recognition.continuous = false;
        this.recognition.interimResults = true;
        this.recognition.maxAlternatives = 1;
        
        // Definir idioma baseado na configuração
        const lang = window.app?.config?.language || 'pt-br';
        const langMap = {
            'pt-br': 'pt-BR',
            'en-gb': 'en-GB',
            'es-es': 'es-ES'
        };
        this.recognition.lang = langMap[lang] || 'pt-BR';
        
        // Event listeners
        this.recognition.onstart = () => {
            console.log('Speech recognition started');
            this.isListening = true;
            this.updateMicButton(true);
            
            if (window.app) {
                window.app.showNotification('Fale agora...', 'info', 2000);
            }
        };
        
        this.recognition.onresult = (event) => {
            let finalTranscript = '';
            let interimTranscript = '';
            
            for (let i = event.resultIndex; i < event.results.length; i++) {
                const transcript = event.results[i][0].transcript;
                
                if (event.results[i].isFinal) {
                    finalTranscript += transcript;
                } else {
                    interimTranscript += transcript;
                }
            }
            
            // Atualizar campo de texto
            if (this.currentTarget) {
                const field = document.getElementById(this.currentTarget);
                if (field) {
                    if (finalTranscript) {
                        // Adicionar ao texto existente se houver
                        const currentText = field.value;
                        const separator = currentText && !currentText.endsWith(' ') ? ' ' : '';
                        field.value = currentText + separator + finalTranscript;
                        
                        // Trigger evento de input para validações
                        field.dispatchEvent(new Event('input', { bubbles: true }));
                    }
                    
                    // Mostrar texto temporário
                    if (interimTranscript) {
                        field.placeholder = interimTranscript;
                    }
                }
            }
        };
        
        this.recognition.onerror = (event) => {
            console.error('Speech recognition error:', event.error);
            this.isListening = false;
            this.updateMicButton(false);
            
            let errorMessage = 'Erro no reconhecimento de voz';
            
            switch (event.error) {
                case 'no-speech':
                    errorMessage = 'Nenhuma fala detectada. Tente novamente.';
                    break;
                case 'audio-capture':
                    errorMessage = 'Erro no microfone. Verifique as permissões.';
                    break;
                case 'not-allowed':
                    errorMessage = 'Permissão de microfone negada.';
                    break;
                case 'network':
                    errorMessage = 'Erro de rede. Verifique sua conexão.';
                    break;
            }
            
            if (window.app) {
                window.app.showNotification(errorMessage, 'error');
            }
        };
        
        this.recognition.onend = () => {
            console.log('Speech recognition ended');
            this.isListening = false;
            this.updateMicButton(false);
            
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
        if (!this.recognition) {
            if (!this.init()) {
                if (window.app) {
                    window.app.showNotification('Reconhecimento de voz não disponível', 'error');
                }
                return false;
            }
        }
        
        if (this.isListening) {
            this.stop();
            return false;
        }
        
        this.currentTarget = targetElementId;
        
        // Salvar placeholder original
        const field = document.getElementById(targetElementId);
        if (field) {
            field.dataset.originalPlaceholder = field.placeholder;
        }
        
        try {
            this.recognition.start();
            return true;
        } catch (error) {
            console.error('Error starting speech recognition:', error);
            if (window.app) {
                window.app.showNotification('Erro ao iniciar reconhecimento de voz', 'error');
            }
            return false;
        }
    },
    
    // Parar reconhecimento
    stop() {
        if (this.recognition && this.isListening) {
            this.recognition.stop();
        }
    },
    
    // Atualizar botão do microfone
    updateMicButton(isRecording) {
        const buttons = document.querySelectorAll('.mic-button');
        
        buttons.forEach(button => {
            if (isRecording) {
                button.classList.add('recording');
                button.innerHTML = '⏹️'; // Stop icon
                button.title = 'Parar gravação';
            } else {
                button.classList.remove('recording');
                button.innerHTML = '🎤'; // Mic icon
                button.title = 'Começar gravação de voz';
            }
        });
    },
    
    // Verificar suporte
    isSupported() {
        return 'webkitSpeechRecognition' in window || 'SpeechRecognition' in window;
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

// Event listener para botões de microfone
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('mic-button')) {
        const targetId = e.target.dataset.target || 
                        e.target.getAttribute('onclick')?.match(/startSpeechRecognition\('([^']+)'\)/)?.[1];
        
        if (targetId) {
            if (window.speechRecognition.isListening) {
                window.speechRecognition.stop();
            } else {
                window.speechRecognition.start(targetId);
            }
        }
    }
});

// Inicializar quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    if (window.speechRecognition.isSupported()) {
        window.speechRecognition.init();
    } else {
        console.log('Speech Recognition não suportado - ocultando botões de microfone');
        
        // Ocultar botões de microfone se não suportado
        const micButtons = document.querySelectorAll('.mic-button');
        micButtons.forEach(button => {
            button.style.display = 'none';
        });
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