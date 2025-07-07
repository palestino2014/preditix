# Guia de Deploy - API NFE no Hostgator

Este guia detalha o processo de deploy da API de NFE no Hostgator, considerando as especificidades do plano P.

## 📋 Pré-requisitos

### 1. Conta Hostgator
- Plano P ativo
- Acesso ao cPanel
- SSL/HTTPS configurado (obrigatório para SEFAZ)

### 2. Certificado Digital
- Certificado digital válido (.p12 ou .pfx)
- Senha do certificado
- CNPJ/CPF do consultante

### 3. Credenciais SEFAZ
- Credenciais de acesso às APIs da SEFAZ
- Autorização para consulta de NFEs

## 🚀 Passo a Passo do Deploy

### 1. Preparação Local

```bash
# Clone o repositório
git clone https://github.com/seu-usuario/nfeapi.git
cd nfeapi

# Instale as dependências
composer install --no-dev --optimize-autoloader

# Crie o arquivo de configuração
cp env.example .env
```

### 2. Configuração do .env

Edite o arquivo `.env` com suas configurações:

```env
# Configurações da Aplicação
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seudominio.com

# Configurações da SEFAZ
CNPJ_CONSULTANTE=seu_cnpj_real_aqui
CERTIFICADO_PATH=/home/usuario/public_html/certificates/certificado.p12
CERTIFICADO_SENHA=sua_senha_real_aqui

# Configurações de Log
LOG_LEVEL=info
LOG_PATH=/home/usuario/public_html/logs/

# Configurações de Segurança
API_KEY=sua_api_key_segura_aqui
JWT_SECRET=seu_jwt_secret_seguro_aqui

# Configurações de Timeout
SEFAZ_TIMEOUT=30
HTTP_TIMEOUT=60
```

### 3. Upload para o Hostgator

#### Via FTP/SFTP:
1. Conecte-se ao seu servidor via FTP
2. Navegue até a pasta `public_html`
3. Faça upload de todos os arquivos do projeto
4. Certifique-se de que a estrutura esteja correta

#### Via cPanel File Manager:
1. Acesse o cPanel
2. Abra o File Manager
3. Navegue até `public_html`
4. Faça upload dos arquivos

### 4. Configuração do Document Root

No cPanel:
1. Vá em "Domains" ou "Domains Manager"
2. Clique em "Manage" no seu domínio
3. Configure o Document Root para apontar para a pasta `public/`
4. Salve as configurações

### 5. Configuração do Certificado

1. Crie uma pasta `certificates` na raiz do projeto
2. Faça upload do certificado digital (.p12) para esta pasta
3. Configure as permissões:
   ```bash
   chmod 600 certificates/certificado.p12
   chmod 700 certificates/
   ```

### 6. Configuração de Logs

1. Crie a pasta `logs` na raiz do projeto
2. Configure as permissões:
   ```bash
   chmod 755 logs/
   chmod 644 logs/*.log
   ```

### 7. Configuração do .htaccess

O arquivo `.htaccess` já está configurado na pasta `public/`. Verifique se está funcionando:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]

# Forçar HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 8. Configuração de Permissões

Configure as permissões corretas:

```bash
# Arquivos principais
chmod 644 public/.htaccess
chmod 644 composer.json
chmod 644 env.example

# Pastas
chmod 755 public/
chmod 755 src/
chmod 755 config/
chmod 755 logs/
chmod 755 certificates/

# Arquivo de configuração
chmod 600 .env
```

### 9. Teste da Instalação

1. Acesse: `https://seudominio.com/api/v1/health`
2. Verifique se retorna status "healthy"
3. Teste um endpoint de NFE com dados válidos

## 🔧 Configurações Específicas do Hostgator

### 1. PHP Configuration

No cPanel, vá em "PHP Selector" e configure:
- **PHP Version**: 7.4 ou superior
- **Memory Limit**: 256M
- **Max Execution Time**: 300
- **Upload Max Filesize**: 10M
- **Post Max Size**: 10M

### 2. SSL/HTTPS

Certifique-se de que o SSL está ativo:
1. No cPanel, vá em "SSL/TLS"
2. Ative o SSL para seu domínio
3. Configure redirecionamento HTTP para HTTPS

### 3. Cron Jobs (Opcional)

Para limpeza automática de logs:
```bash
# Limpar logs antigos (diariamente às 2h)
0 2 * * * find /home/usuario/public_html/logs/ -name "*.log" -mtime +30 -delete
```

## 🚨 Troubleshooting

### Erro 500 - Internal Server Error
1. Verifique os logs de erro do Apache
2. Verifique se o PHP está na versão correta
3. Verifique as permissões dos arquivos
4. Verifique se o `.env` está configurado

### Erro de Certificado
1. Verifique se o caminho do certificado está correto
2. Verifique se a senha está correta
3. Verifique as permissões do arquivo

### Erro de CORS
1. Verifique se o middleware CORS está funcionando
2. Verifique se o `.htaccess` está correto

### Erro de SEFAZ
1. Verifique se o CNPJ está correto
2. Verifique se o certificado é válido
3. Verifique se as credenciais da SEFAZ estão corretas

## 📊 Monitoramento

### 1. Logs
Monitore os logs em:
- `logs/error.log` - Erros da aplicação
- `logs/access.log` - Acessos à API
- `logs/sefaz.log` - Comunicação com SEFAZ

### 2. Health Check
Use o endpoint `/api/v1/health` para monitorar:
- Status da conexão com SEFAZ
- Validade do certificado
- Status geral da API

### 3. Métricas
Configure alertas para:
- Tempo de resposta > 30s
- Taxa de erro > 5%
- Certificado próximo do vencimento

## 🔒 Segurança

### 1. Proteção de Arquivos
- `.env` não deve ser acessível via web
- `composer.json` e `composer.lock` protegidos
- Certificados com permissões restritas

### 2. Rate Limiting
- Configure rate limiting no servidor
- Monitore tentativas de abuso

### 3. Logs de Auditoria
- Mantenha logs de todas as operações
- Configure rotação de logs

## 📞 Suporte

### Hostgator Support
- Chat online 24/7
- Ticket system
- Phone support

### Logs Úteis
- Error logs do Apache
- PHP error logs
- Logs da aplicação

---

**⚠️ Importante**: Sempre teste em ambiente de desenvolvimento antes de fazer deploy em produção. Mantenha backups regulares dos arquivos de configuração e certificados. 