# 🚀 Guia de Instalação - Sistema Preditix OS

## 📋 Pré-requisitos

- **PHP**: 7.4 ou superior
- **MySQL**: 5.7 ou superior  
- **Servidor Web**: Apache com mod_rewrite ou Nginx
- **HTTPS**: Obrigatório para funcionalidades PWA

## ⚡ Instalação Rápida

### 1. **Upload dos Arquivos**
```bash
# Via FTP ou painel do hosting
# Fazer upload de todos os arquivos para o diretório web
```

### 2. **Criar Banco de Dados**
```sql
CREATE DATABASE preditix_os CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. **Configurar Conexão**
Edite o arquivo `config/database.php`:
```php
private $host = 'localhost';        // Host do MySQL
private $database = 'preditix_os';  // Nome do banco criado
private $username = 'seu_usuario';  // Usuário MySQL
private $password = 'sua_senha';    // Senha MySQL
```

### 4. **Importar Schema**
```bash
mysql -u usuario -p preditix_os < database/schema.sql
```

### 5. **Configurar Permissões**
```bash
chmod 755 -R ./
```

### 6. **Acessar Sistema**
- Navegue para: `https://seudominio.com/`
- **Login Gestor**: admin@preditix.com / password
- **Login Técnico**: joao@preditix.com / password

## 🔧 Instalação Assistida

Alternativamente, acesse: `https://seudominio.com/install.php`

O assistente irá guiá-lo através de:
1. Verificação de requisitos
2. Configuração do banco
3. Criação das tabelas
4. Finalização

## ⚙️ Configuração Hostgator

### Painel cPanel:
1. **MySQL Databases** → Criar banco `preditix_os`
2. **File Manager** → Upload dos arquivos
3. **SSL/TLS** → Ativar HTTPS (obrigatório)
4. Testar acesso

### Configurações Específicas:
```php
// config/database.php - Exemplo Hostgator
private $host = 'localhost';
private $database = 'cpanel_user_preditix_os';
private $username = 'cpanel_user_dbuser';
private $password = 'senha_gerada';
```

## 🌐 Configuração Apache

Certifique-se que o `.htaccess` funciona:
```apache
# Testar se mod_rewrite está ativo
Options +FollowSymLinks
RewriteEngine On
RewriteRule ^test$ /index.php [L]
```

## 🔒 Configuração HTTPS

**Obrigatório para PWA funcionar!**

### Let's Encrypt (cPanel):
1. SSL/TLS → Let's Encrypt
2. Ativar para domínio principal
3. Forçar HTTPS

### Cloudflare:
1. SSL → Full (Strict)
2. Always Use HTTPS → On
3. HSTS → Enable

## 📱 Teste PWA

Após instalação, testar:
1. **Manifest**: `/manifest.json` deve carregar
2. **Service Worker**: Console deve mostrar "SW registered"
3. **Install**: Banner de instalação deve aparecer
4. **Offline**: Desconectar internet e testar funcionalidades

## 👥 Usuários Padrão

**IMPORTANTE**: Alterar senhas em produção!

### Gestor:
- **Email**: admin@preditix.com
- **Senha**: password
- **Funcionalidades**: Aprovar/rejeitar OS, criar OS diretas

### Técnico:
- **Email**: joao@preditix.com  
- **Senha**: password
- **Funcionalidades**: Criar OS, editar, concluir (sujeito à aprovação)

## 🔍 Verificação da Instalação

### Checklist:
- [ ] Sistema carrega sem erros
- [ ] Login funciona com usuários padrão
- [ ] Dashboard mostra OS de exemplo
- [ ] PWA install prompt aparece
- [ ] Service Worker registra no console
- [ ] Funciona offline (testar criar OS)
- [ ] Troca de idioma funciona
- [ ] Responsivo em mobile
- [ ] Reconhecimento de voz funciona (Chrome)

### URLs Importantes:
- **Sistema**: `https://seudominio.com/`
- **Dashboard**: `https://seudominio.com/dashboard`
- **Manifest**: `https://seudominio.com/manifest.json`
- **API Test**: `https://seudominio.com/api/test`

## 🚨 Problemas Comuns

### **Erro 500 - Internal Server Error**
- Verificar permissões dos arquivos (755)
- Verificar .htaccess (mod_rewrite ativo)
- Checar logs do servidor

### **Erro de Conexão MySQL**
- Verificar credenciais em `config/database.php`
- Verificar se banco foi criado
- Testar conexão manual via phpMyAdmin

### **PWA não instala**
- HTTPS deve estar ativo
- Manifest.json deve ser válido
- Service Worker deve registrar sem erros

### **Offline não funciona**
- Verificar Service Worker no DevTools
- Verificar IndexedDB no navegador
- Testar apenas em HTTPS

### **Reconhecimento de voz falha**
- Funciona apenas em HTTPS
- Testar no Chrome/Edge
- Verificar permissões de microfone

## 📊 Monitoramento

### Logs Importantes:
- **PHP Errors**: `/logs/error.log`
- **Access Log**: `/logs/access.log`  
- **Browser Console**: Erros JavaScript
- **Network Tab**: Falhas de requisições

### Métricas Esperadas:
- **Load Time**: < 3 segundos
- **PWA Score**: > 90 (Lighthouse)
- **Mobile Friendly**: 100%
- **HTTPS**: A+ (SSL Labs)

## 🔄 Atualizações

Para atualizações futuras:
1. Backup do banco de dados
2. Backup dos arquivos
3. Upload novos arquivos
4. Executar migrations se necessário
5. Testar funcionalidades

## 📞 Suporte

### Auto-diagnóstico:
1. Verificar console do navegador
2. Testar em modo anônimo
3. Limpar cache do navegador
4. Verificar logs do servidor

### Informações para Suporte:
- Versão PHP: `<?php echo phpversion(); ?>`
- Versão MySQL: `SELECT VERSION();`
- Servidor Web: Apache/Nginx
- Sistema Operacional
- Navegador utilizado

---

**Sistema Preditix OS Manager v1.0**  
*Instalação completa e funcionando!* ✅