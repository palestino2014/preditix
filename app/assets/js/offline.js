/**
 * Funcionalidades Offline - IndexedDB
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

window.offlineSync = {
    dbName: 'PreditixOSDB',
    dbVersion: 1,
    db: null,
    
    // Inicialização
    async init() {
        try {
            this.db = await this.openDB();
            console.log('Offline sync initialized');
            
            // Só sincronizar na inicialização se há dados pendentes
            if (navigator.onLine) {
                this.syncPendingDataQuietly();
            }
        } catch (error) {
            console.error('Error initializing offline sync:', error);
        }
    },
    
    // Sincronização silenciosa (sem notificação) na inicialização
    async syncPendingDataQuietly() {
        if (!this.db || !navigator.onLine) return;
        
        console.log('Checking for pending data to sync...');
        
        try {
            // Contar quantos dados realmente foram sincronizados
            const syncedOS = await this.syncPendingOS();
            const syncedRequests = await this.syncPendingRequests();
            
            const totalSynced = syncedOS + syncedRequests;
            
            console.log('Quiet sync completed', { syncedOS, syncedRequests, totalSynced });
            
            // Não mostrar notificação na inicialização
        } catch (error) {
            console.error('Error during quiet sync:', error);
        }
    },
    
    // Abrir conexão com IndexedDB
    openDB() {
        return new Promise((resolve, reject) => {
            const request = indexedDB.open(this.dbName, this.dbVersion);
            
            request.onerror = () => reject(request.error);
            request.onsuccess = () => resolve(request.result);
            
            request.onupgradeneeded = (event) => {
                const db = event.target.result;
                
                // Store para OS pendentes
                if (!db.objectStoreNames.contains('os_pendentes')) {
                    const osStore = db.createObjectStore('os_pendentes', { 
                        keyPath: 'id', 
                        autoIncrement: true 
                    });
                    osStore.createIndex('timestamp', 'timestamp');
                    osStore.createIndex('status', 'status');
                    osStore.createIndex('tipo', 'tipo');
                }
                
                // Store para requisições pendentes
                if (!db.objectStoreNames.contains('requests_pendentes')) {
                    const reqStore = db.createObjectStore('requests_pendentes', { 
                        keyPath: 'id', 
                        autoIncrement: true 
                    });
                    reqStore.createIndex('timestamp', 'timestamp');
                    reqStore.createIndex('method', 'method');
                }
                
                // Store para cache de dados
                if (!db.objectStoreNames.contains('cache_dados')) {
                    const cacheStore = db.createObjectStore('cache_dados', { 
                        keyPath: 'key' 
                    });
                    cacheStore.createIndex('timestamp', 'timestamp');
                    cacheStore.createIndex('type', 'type');
                }
            };
        });
    },
    
    // Salvar OS offline
    async saveOSOffline(osData) {
        if (!this.db) await this.init();
        
        try {
            const transaction = this.db.transaction(['os_pendentes'], 'readwrite');
            const store = transaction.objectStore('os_pendentes');
            
            const osRecord = {
                ...osData,
                timestamp: Date.now(),
                status: 'pending',
                tipo: 'create_os'
            };
            
            await store.add(osRecord);
            
            console.log('OS saved offline:', osRecord);
            
            // Mostrar notificação
            if (window.app) {
                window.app.showNotification('OS salva offline. Será enviada quando reconectar.', 'info');
            }
            
            return true;
        } catch (error) {
            console.error('Error saving OS offline:', error);
            return false;
        }
    },
    
    // Salvar requisição para sincronização posterior
    async queueRequest(url, options) {
        if (!this.db) await this.init();
        
        try {
            const transaction = this.db.transaction(['requests_pendentes'], 'readwrite');
            const store = transaction.objectStore('requests_pendentes');
            
            const request = {
                url,
                options: {
                    ...options,
                    headers: Object.fromEntries(new Headers(options.headers || {}))
                },
                timestamp: Date.now()
            };
            
            await store.add(request);
            console.log('Request queued for sync:', request);
            
            return true;
        } catch (error) {
            console.error('Error queuing request:', error);
            return false;
        }
    },
    
    // Sincronizar dados pendentes
    async syncPendingData() {
        if (!this.db || !navigator.onLine) return;
        
        console.log('Starting sync of pending data...');
        
        try {
            // Contar quantos dados realmente foram sincronizados
            const syncedOS = await this.syncPendingOS();
            const syncedRequests = await this.syncPendingRequests();
            
            const totalSynced = syncedOS + syncedRequests;
            
            console.log('Sync completed successfully', { syncedOS, syncedRequests, totalSynced });
            
            // Só mostrar notificação se realmente sincronizou algum dado
            if (totalSynced > 0 && window.app) {
                window.app.showNotification(`${totalSynced} item(ns) sincronizado(s)`, 'success', 2000);
            }
        } catch (error) {
            console.error('Error during sync:', error);
            
            if (window.app) {
                window.app.showNotification('Erro na sincronização', 'error');
            }
        }
    },
    
    // Sincronizar OS pendentes
    async syncPendingOS() {
        const transaction = this.db.transaction(['os_pendentes'], 'readwrite');
        const store = transaction.objectStore('os_pendentes');
        const request = store.getAll();
        
        return new Promise((resolve, reject) => {
            request.onsuccess = async () => {
                const pendingOS = request.result;
                let syncedCount = 0;
                
                for (const os of pendingOS) {
                    try {
                        await this.sendOSToServer(os);
                        
                        // Remover da store offline após sucesso
                        await store.delete(os.id);
                        syncedCount++;
                        
                        console.log('OS synced:', os.id);
                    } catch (error) {
                        console.error('Error syncing OS:', os.id, error);
                    }
                }
                
                resolve(syncedCount);
            };
            
            request.onerror = () => reject(request.error);
        });
    },
    
    // Sincronizar requisições pendentes
    async syncPendingRequests() {
        const transaction = this.db.transaction(['requests_pendentes'], 'readwrite');
        const store = transaction.objectStore('requests_pendentes');
        const request = store.getAll();
        
        return new Promise((resolve, reject) => {
            request.onsuccess = async () => {
                const pendingRequests = request.result;
                let syncedCount = 0;
                
                for (const req of pendingRequests) {
                    try {
                        await fetch(req.url, req.options);
                        
                        // Remover da store após sucesso
                        await store.delete(req.id);
                        syncedCount++;
                        
                        console.log('Request synced:', req.url);
                    } catch (error) {
                        console.error('Error syncing request:', req.url, error);
                    }
                }
                
                resolve(syncedCount);
            };
            
            request.onerror = () => reject(request.error);
        });
    },
    
    // Enviar OS para servidor
    async sendOSToServer(osData) {
        const formData = new FormData();
        
        // Converter dados da OS para FormData
        Object.keys(osData).forEach(key => {
            if (key !== 'id' && key !== 'timestamp' && key !== 'status' && key !== 'tipo') {
                if (Array.isArray(osData[key])) {
                    osData[key].forEach((item, index) => {
                        formData.append(`${key}[${index}]`, item);
                    });
                } else {
                    formData.append(key, osData[key]);
                }
            }
        });
        
        // Adicionar CSRF token
        if (window.app && window.app.config.csrfToken) {
            formData.append('csrf_token', window.app.config.csrfToken);
        }
        
        const response = await fetch('/os/store', {
            method: 'POST',
            body: formData
        });
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return await response.json();
    },
    
    // Cache de dados
    async cacheData(key, data, type = 'general') {
        if (!this.db) await this.init();
        
        try {
            const transaction = this.db.transaction(['cache_dados'], 'readwrite');
            const store = transaction.objectStore('cache_dados');
            
            const cacheRecord = {
                key,
                data,
                type,
                timestamp: Date.now()
            };
            
            await store.put(cacheRecord);
            console.log('Data cached:', key);
            
            return true;
        } catch (error) {
            console.error('Error caching data:', error);
            return false;
        }
    },
    
    // Recuperar dados do cache
    async getCachedData(key) {
        if (!this.db) await this.init();
        
        try {
            const transaction = this.db.transaction(['cache_dados'], 'readonly');
            const store = transaction.objectStore('cache_dados');
            const request = store.get(key);
            
            return new Promise((resolve, reject) => {
                request.onsuccess = () => {
                    const result = request.result;
                    
                    if (result) {
                        // Verificar se não está muito antigo (24 horas)
                        const maxAge = 24 * 60 * 60 * 1000; // 24 horas
                        if (Date.now() - result.timestamp < maxAge) {
                            resolve(result.data);
                        } else {
                            // Dados muito antigos, remover
                            store.delete(key);
                            resolve(null);
                        }
                    } else {
                        resolve(null);
                    }
                };
                
                request.onerror = () => reject(request.error);
            });
        } catch (error) {
            console.error('Error getting cached data:', error);
            return null;
        }
    },
    
    // Limpar cache antigo
    async clearOldCache() {
        if (!this.db) await this.init();
        
        try {
            const transaction = this.db.transaction(['cache_dados'], 'readwrite');
            const store = transaction.objectStore('cache_dados');
            const index = store.index('timestamp');
            
            const maxAge = 7 * 24 * 60 * 60 * 1000; // 7 dias
            const cutoffTime = Date.now() - maxAge;
            
            const range = IDBKeyRange.upperBound(cutoffTime);
            const request = index.openCursor(range);
            
            request.onsuccess = (event) => {
                const cursor = event.target.result;
                if (cursor) {
                    cursor.delete();
                    cursor.continue();
                }
            };
            
            console.log('Old cache cleared');
        } catch (error) {
            console.error('Error clearing old cache:', error);
        }
    },
    
    // Obter estatísticas do banco offline
    async getStats() {
        if (!this.db) await this.init();
        
        try {
            const stats = {
                pendingOS: 0,
                pendingRequests: 0,
                cachedItems: 0
            };
            
            // Contar OS pendentes
            const osTransaction = this.db.transaction(['os_pendentes'], 'readonly');
            const osStore = osTransaction.objectStore('os_pendentes');
            const osCount = await osStore.count();
            stats.pendingOS = osCount.result || 0;
            
            // Contar requisições pendentes
            const reqTransaction = this.db.transaction(['requests_pendentes'], 'readonly');
            const reqStore = reqTransaction.objectStore('requests_pendentes');
            const reqCount = await reqStore.count();
            stats.pendingRequests = reqCount.result || 0;
            
            // Contar itens em cache
            const cacheTransaction = this.db.transaction(['cache_dados'], 'readonly');
            const cacheStore = cacheTransaction.objectStore('cache_dados');
            const cacheCount = await cacheStore.count();
            stats.cachedItems = cacheCount.result || 0;
            
            return stats;
        } catch (error) {
            console.error('Error getting stats:', error);
            return null;
        }
    }
};

// Inicializar quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    window.offlineSync.init();
});

// Limpar cache antigo periodicamente
setInterval(() => {
    window.offlineSync.clearOldCache();
}, 60 * 60 * 1000); // A cada hora

console.log('Preditix OS - Offline.js loaded');