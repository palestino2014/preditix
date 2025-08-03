/**
 * JavaScript Principal
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

// Configurações globais
window.app = {
    config: window.appConfig || {},
    modal: null,
    
    // Inicialização
    init() {
        this.setupModal();
        this.setupNetworkDetection();
        this.setupFormValidation();
        this.setupPWAPrompt();
        console.log('Preditix OS App initialized');
        
        // Escutar mensagens do Service Worker para cache updates
        navigator.serviceWorker?.addEventListener('message', event => {
            if (event.data?.type === 'CACHE_UPDATED') {
                console.log('Cache atualizado pelo Service Worker, recarregando...');
                setTimeout(() => window.location.reload(), 1000);
            }
        });
    },
    
    // Modal global
    setupModal() {
        this.modal = document.getElementById('global-modal');
        
        // Fechar modal com ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal && this.modal.classList.contains('active')) {
                this.closeModal();
            }
        });
        
        // Fechar modal clicando fora
        if (this.modal) {
            this.modal.addEventListener('click', (e) => {
                if (e.target === this.modal) {
                    this.closeModal();
                }
            });
        }
    },
    
    // Detecção de rede
    setupNetworkDetection() {
        window.addEventListener('online', () => {
            this.hideOfflineIndicator();
            
            // Só mostrar notificação se realmente estava offline antes
            if (this.wasOffline) {
                this.showNotification('Conexão restaurada', 'success', 2000);
                this.wasOffline = false;
            }
            
            // Sincronizar dados pendentes
            if (window.offlineSync) {
                window.offlineSync.syncPendingData();
            }
        });
        
        window.addEventListener('offline', () => {
            this.wasOffline = true;
            this.showOfflineIndicator();
            this.showNotification('Modo offline ativado', 'warning', 2000);
        });
        
        // Verificar estado inicial
        if (!navigator.onLine) {
            this.showOfflineIndicator();
        }
    },
    
    // Validação de formulários
    setupFormValidation() {
        document.addEventListener('submit', (e) => {
            const form = e.target;
            if (form.tagName === 'FORM') {
                // Validação básica
                const requiredFields = form.querySelectorAll('[required]');
                let hasErrors = false;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        this.showFieldError(field, 'Este campo é obrigatório');
                        hasErrors = true;
                    } else {
                        this.clearFieldError(field);
                    }
                });
                
                if (hasErrors) {
                    e.preventDefault();
                    return false;
                }
                
                // Mostrar loading no botão de submit
                const submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    this.setButtonLoading(submitBtn, true);
                }
            }
        });
    },
    
    // PWA Install Prompt
    setupPWAPrompt() {
        let deferredPrompt;
        
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Mostrar prompt personalizado após 5 segundos
            setTimeout(() => {
                this.showPWAInstallPrompt(deferredPrompt);
            }, 5000);
        });
        
        window.addEventListener('appinstalled', () => {
            console.log('PWA instalado com sucesso');
            this.showNotification('App instalado com sucesso!', 'success');
        });
    },
    
    // Mostrar/Ocultar indicador offline
    showOfflineIndicator() {
        const indicator = document.getElementById('offline-indicator');
        if (indicator) {
            indicator.classList.add('show');
        }
    },
    
    hideOfflineIndicator() {
        const indicator = document.getElementById('offline-indicator');
        if (indicator) {
            indicator.classList.remove('show');
        }
    },
    
    // Modal functions
    showModal(title, body, buttons = null) {
        if (!this.modal) return;
        
        const modalTitle = document.getElementById('modal-title');
        const modalBody = document.getElementById('modal-body');
        const modalFooter = document.getElementById('modal-footer');
        
        if (modalTitle) modalTitle.textContent = title;
        if (modalBody) modalBody.innerHTML = body;
        
        if (buttons && modalFooter) {
            modalFooter.innerHTML = buttons;
        }
        
        this.modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    },
    
    closeModal() {
        if (this.modal) {
            this.modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    },
    
    // Confirmação
    confirm(title, message, onConfirm, onCancel = null) {
        const buttons = `
            <button type="button" class="btn btn-secondary" onclick="window.app.closeModal(); ${onCancel ? onCancel + '()' : ''}">
                ${this.config.translations?.cancel || 'Cancelar'}
            </button>
            <button type="button" class="btn btn-primary" onclick="window.app.closeModal(); ${onConfirm}()">
                ${this.config.translations?.confirm || 'Confirmar'}
            </button>
        `;
        
        this.showModal(title, message, buttons);
    },
    
    // Notificações
    showNotification(message, type = 'info', duration = 3000) {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            z-index: 1002;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        // Cores por tipo
        const colors = {
            success: '#28a745',
            error: '#dc3545',
            warning: '#ffc107',
            info: '#17a2b8'
        };
        
        notification.style.backgroundColor = colors[type] || colors.info;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Remover após duração
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.parentElement.removeChild(notification);
                }
            }, 300);
        }, duration);
    },
    
    // Loading em botões
    setButtonLoading(button, loading) {
        if (loading) {
            button.disabled = true;
            button.dataset.originalText = button.innerHTML;
            button.innerHTML = `<span class="loading"></span> ${this.config.translations?.loading || 'Carregando...'}`;
        } else {
            button.disabled = false;
            button.innerHTML = button.dataset.originalText || button.innerHTML;
        }
    },
    
    // Validação de campos
    showFieldError(field, message) {
        this.clearFieldError(field);
        
        field.classList.add('field-error');
        field.style.borderColor = 'var(--danger)';
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error-message';
        errorDiv.style.cssText = `
            color: var(--danger);
            font-size: 14px;
            margin-top: 5px;
        `;
        errorDiv.textContent = message;
        
        field.parentElement.appendChild(errorDiv);
    },
    
    clearFieldError(field) {
        field.classList.remove('field-error');
        field.style.borderColor = '';
        
        const errorMsg = field.parentElement.querySelector('.field-error-message');
        if (errorMsg) {
            errorMsg.remove();
        }
    },
    
    // PWA Install Prompt
    showPWAInstallPrompt(deferredPrompt) {
        const message = `
            <div style="text-align: center;">
                <div style="font-size: 48px; margin-bottom: 15px;">📱</div>
                <p>Instale o app Preditix para uma melhor experiência!</p>
                <p style="color: var(--gray); font-size: 14px;">
                    Funciona offline e ocupa pouco espaço.
                </p>
            </div>
        `;
        
        const buttons = `
            <button type="button" class="btn btn-secondary" onclick="window.app.closeModal()">
                Agora não
            </button>
            <button type="button" class="btn btn-primary" onclick="window.app.installPWA()">
                Instalar
            </button>
        `;
        
        this.deferredPrompt = deferredPrompt;
        this.showModal('Instalar App', message, buttons);
    },
    
    installPWA() {
        if (this.deferredPrompt) {
            this.deferredPrompt.prompt();
            
            this.deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('PWA installation accepted');
                } else {
                    console.log('PWA installation dismissed');
                }
                this.deferredPrompt = null;
            });
        }
        this.closeModal();
    },
    
    // Utilitários
    formatDate(date, format = 'dd/mm/yyyy hh:mm') {
        if (!date) return '';
        
        const d = new Date(date);
        const day = d.getDate().toString().padStart(2, '0');
        const month = (d.getMonth() + 1).toString().padStart(2, '0');
        const year = d.getFullYear();
        const hours = d.getHours().toString().padStart(2, '0');
        const minutes = d.getMinutes().toString().padStart(2, '0');
        
        return format
            .replace('dd', day)
            .replace('mm', month)
            .replace('yyyy', year)
            .replace('hh', hours)
            .replace('mm', minutes);
    },
    
    // Requisições AJAX
    async request(url, options = {}) {
        const defaultOptions = {
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-Token': this.config.csrfToken
            }
        };
        
        const finalOptions = { ...defaultOptions, ...options };
        
        try {
            const response = await fetch(url, finalOptions);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const contentType = response.headers.get('content-type');
            if (contentType && contentType.includes('application/json')) {
                return await response.json();
            } else {
                return await response.text();
            }
        } catch (error) {
            console.error('Request error:', error);
            
            // Se offline, tentar salvar para sincronização posterior
            if (!navigator.onLine && window.offlineSync) {
                window.offlineSync.queueRequest(url, finalOptions);
            }
            
            throw error;
        }
    }
};

// Funções globais para compatibilidade
function closeModal() {
    window.app.closeModal();
}

function showSuccess(message) {
    window.app.showNotification(message, 'success');
}

function showError(message) {
    window.app.showNotification(message, 'error');
}

function showWarning(message) {
    window.app.showNotification(message, 'warning');
}

function showInfo(message) {
    window.app.showNotification(message, 'info');
}

// Inicializar quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    window.app.init();
});

// Scroll suave para elementos âncora
document.addEventListener('click', (e) => {
    if (e.target.tagName === 'A' && e.target.getAttribute('href')?.startsWith('#')) {
        e.preventDefault();
        const target = document.querySelector(e.target.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    }
});

// Auto-resize para textareas
document.addEventListener('input', (e) => {
    if (e.target.tagName === 'TEXTAREA') {
        e.target.style.height = 'auto';
        e.target.style.height = e.target.scrollHeight + 'px';
    }
});

// Formatação automática de campos
document.addEventListener('input', (e) => {
    const field = e.target;
    
    // Formatação de valores monetários
    if (field.classList.contains('money-input')) {
        let value = field.value.replace(/\D/g, '');
        value = (parseInt(value) / 100).toFixed(2);
        field.value = value.replace('.', ',');
    }
    
    // Formatação de placas (LLL-NNNN ou LLL-NLNN)
    if (field.classList.contains('plate-input')) {
        let value = field.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
        if (value.length >= 4) {
            value = value.substring(0, 3) + '-' + value.substring(3, 7);
        }
        field.value = value;
    }
});

console.log('Preditix OS - App.js loaded');