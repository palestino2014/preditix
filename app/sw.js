/**
 * Service Worker - PWA
 * Sistema de Gerenciamento de Ordens de Serviço - Preditix
 */

const CACHE_NAME = 'preditix-os-v1.0.1';
const STATIC_CACHE = 'static-v1.0.1';
const DYNAMIC_CACHE = 'dynamic-v1.0.1';

// Arquivos para cache estático
const STATIC_FILES = [
    '/',
    '/login',
    '/dashboard',
    '/assets/css/app.css',
    '/assets/js/app.js',
    '/assets/js/offline.js',
    '/assets/js/speech.js',
    '/logo_preditix.jpeg',
    '/manifest.json'
];

// Instalação do Service Worker
self.addEventListener('install', event => {
    console.log('Service Worker: Instalando...');
    
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => {
                console.log('Service Worker: Cache criado');
                return cache.addAll(STATIC_FILES);
            })
            .catch(err => console.log('Erro ao criar cache:', err))
    );
});

// Ativação do Service Worker
self.addEventListener('activate', event => {
    console.log('Service Worker: Ativando...');
    
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cache => {
                    // Limpar TODOS os caches antigos, forçando refresh
                    if (cache !== STATIC_CACHE && cache !== DYNAMIC_CACHE) {
                        console.log('Service Worker: Removendo cache antigo', cache);
                        return caches.delete(cache);
                    }
                })
            );
        }).then(() => {
            // Forçar refresh de todos os clientes
            return self.clients.matchAll().then(clients => {
                clients.forEach(client => {
                    client.postMessage({
                        type: 'CACHE_UPDATED',
                        message: 'Cache atualizado, recarregando...'
                    });
                });
            });
        })
    );
});

// Interceptar requisições
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);
    
    // API requests - Network first
    if (url.pathname.startsWith('/api/')) {
        event.respondWith(networkFirst(request));
        return;
    }
    
    // Páginas dinâmicas - Network first
    if (url.pathname.includes('/os/') || url.pathname === '/dashboard') {
        event.respondWith(networkFirst(request));
        return;
    }
    
    // Recursos estáticos - Cache first
    event.respondWith(cacheFirst(request));
});

// Estratégia Cache First
async function cacheFirst(request) {
    try {
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        const networkResponse = await fetch(request);
        
        // Cache recursos GET bem-sucedidos
        if (request.method === 'GET' && networkResponse.status === 200) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, networkResponse.clone());
        }
        
        return networkResponse;
    } catch (error) {
        console.log('Erro cache first:', error);
        
        // Retorna página offline para navegação
        if (request.destination === 'document') {
            return caches.match('/offline.html');
        }
        
        throw error;
    }
}

// Estratégia Network First
async function networkFirst(request) {
    try {
        const networkResponse = await fetch(request);
        
        // Cache respostas bem-sucedidas
        if (networkResponse.status === 200) {
            const cache = await caches.open(DYNAMIC_CACHE);
            cache.put(request, networkResponse.clone());
        }
        
        return networkResponse;
    } catch (error) {
        console.log('Network first fallback to cache:', error);
        
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        
        throw error;
    }
}

// Sincronização em background
self.addEventListener('sync', event => {
    if (event.tag === 'sync-os') {
        console.log('Service Worker: Sincronizando OS offline...');
        event.waitUntil(syncOfflineOS());
    }
});

// Função para sincronizar OS offline
async function syncOfflineOS() {
    try {
        // Esta função será implementada junto com o IndexedDB
        console.log('Sincronização de OS offline...');
    } catch (error) {
        console.error('Erro na sincronização:', error);
    }
}

// Notificações Push
self.addEventListener('push', event => {
    if (event.data) {
        const data = event.data.json();
        
        const options = {
            body: data.body,
            icon: '/logo_preditix.jpeg',
            badge: '/logo_preditix.jpeg',
            vibrate: [200, 100, 200],
            data: {
                url: data.url
            },
            actions: [
                {
                    action: 'view',
                    title: 'Ver OS'
                },
                {
                    action: 'close',
                    title: 'Fechar'
                }
            ]
        };
        
        event.waitUntil(
            self.registration.showNotification(data.title, options)
        );
    }
});

// Clique em notificação
self.addEventListener('notificationclick', event => {
    event.notification.close();
    
    if (event.action === 'view') {
        event.waitUntil(
            clients.openWindow(event.notification.data.url)
        );
    }
});