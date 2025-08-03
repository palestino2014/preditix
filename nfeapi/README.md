# API de Autenticação de Notas Fiscais Eletrônicas (NFE)

Esta API serve como ponte entre sistemas e as APIs oficiais da SEFAZ (Secretaria da Fazenda) para autenticação e validação de Notas Fiscais Eletrônicas no Brasil.

## 🚀 Funcionalidades

- **Consulta de NFE**: Verificar status e validade de notas fiscais
- **Validação de Chave de Acesso**: Confirmar se a chave é válida
- **Consulta de Destinatário**: Verificar dados do destinatário
- **Status de Autorização**: Verificar se a NFE foi autorizada pela SEFAZ

## 📋 Pré-requisitos

### Requisitos Técnicos
- **PHP 7.4+** (compatível com Hostgator)
- **HTTPS obrigatório** (requisito da SEFAZ)
- **Certificado digital** para autenticação
- **Composer** para gerenciamento de dependências

### Informações Necessárias
- **CNPJ/CPF** do consultante
- **Certificado digital** (.p12 ou .pfx)
- **Credenciais** das APIs da SEFAZ
- **Chave de Acesso da NFE** (44 dígitos)

## 🛠️ Instalação

1. **Clone o repositório**
```bash
git clone https://github.com/seu-usuario/nfeapi.git
cd nfeapi
```

2. **Instale as dependências**
```bash
composer install
```

3. **Configure as variáveis de ambiente**
```bash
cp env.example .env
```

4. **Edite o arquivo .env com suas configurações**
```env
# Configurações da SEFAZ
CNPJ_CONSULTANTE=seu_cnpj_aqui
CERTIFICADO_PATH=/caminho/para/certificado.p12
CERTIFICADO_SENHA=sua_senha_aqui

# Configurações de Segurança
API_KEY=sua_api_key_aqui
JWT_SECRET=seu_jwt_secret_aqui
```

5. **Configure o servidor web**
   - Aponte o document root para a pasta `public/`
   - Configure HTTPS obrigatório
   - Configure as permissões de arquivo adequadas

## 📚 Endpoints da API

### 1. Health Check
```http
GET /api/v1/health
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "status": "healthy",
    "version": "1.0.0",
    "environment": "production",
    "timestamp": "2024-01-15 10:30:00",
    "services": {
      "sefaz_connection": {
        "status": "ok",
        "message": "Configurações da SEFAZ presentes"
      },
      "database": {
        "status": "ok",
        "message": "API não utiliza banco de dados"
      },
      "certificate": {
        "status": "ok",
        "message": "Certificado encontrado e válido"
      }
    }
  },
  "timestamp": "2024-01-15 10:30:00",
  "status_code": 200
}
```

### 2. Consultar NFE
```http
POST /api/v1/nfe/consultar
Content-Type: application/json

{
  "chave_acesso": "35150112345678901234567890123456789012345678"
}
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "success": true,
    "data": {
      "status": "AUTORIZADA",
      "protocolo": "123456789012345",
      "data_autorizacao": "2024-01-15T10:30:00-03:00"
    },
    "timestamp": "2024-01-15 10:30:00",
    "uf": "SP"
  },
  "timestamp": "2024-01-15 10:30:00",
  "status_code": 200
}
```

### 3. Validar NFE
```http
POST /api/v1/nfe/validar
Content-Type: application/json

{
  "chave_acesso": "35150112345678901234567890123456789012345678"
}
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "success": true,
    "valida": true,
    "motivo": "NFE válida",
    "timestamp": "2024-01-15 10:30:00",
    "uf": "SP"
  },
  "timestamp": "2024-01-15 10:30:00",
  "status_code": 200
}
```

### 4. Verificar Status
```http
POST /api/v1/nfe/status
Content-Type: application/json

{
  "chave_acesso": "35150112345678901234567890123456789012345678"
}
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "success": true,
    "status": "AUTORIZADA",
    "data_autorizacao": "2024-01-15T10:30:00-03:00",
    "protocolo": "123456789012345",
    "timestamp": "2024-01-15 10:30:00",
    "uf": "SP"
  },
  "timestamp": "2024-01-15 10:30:00",
  "status_code": 200
}
```

### 5. Consultar Destinatário
```http
POST /api/v1/nfe/destinatario
Content-Type: application/json

{
  "chave_acesso": "35150112345678901234567890123456789012345678"
}
```

**Resposta:**
```json
{
  "success": true,
  "data": {
    "success": true,
    "destinatario": {
      "cnpj": "12345678000195",
      "nome": "EMPRESA DESTINATARIO LTDA",
      "endereco": {
        "logradouro": "Rua Exemplo",
        "numero": "123",
        "bairro": "Centro",
        "municipio": "São Paulo",
        "uf": "SP",
        "cep": "01234-567"
      }
    },
    "timestamp": "2024-01-15 10:30:00",
    "uf": "SP"
  },
  "timestamp": "2024-01-15 10:30:00",
  "status_code": 200
}
```

## 🔧 Configuração no Hostgator

### 1. Upload dos Arquivos
- Faça upload de todos os arquivos para o diretório raiz do seu domínio
- Certifique-se de que a pasta `public/` seja o document root

### 2. Configuração do .htaccess
Crie um arquivo `.htaccess` na pasta `public/`:

```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^ index.php [QSA,L]

# Forçar HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

# Headers de segurança
Header always set X-Content-Type-Options nosniff
Header always set X-Frame-Options DENY
Header always set X-XSS-Protection "1; mode=block"
```

### 3. Configuração do Certificado
- Faça upload do certificado digital (.p12) para uma pasta segura
- Configure o caminho no arquivo `.env`
- Certifique-se de que as permissões estejam corretas

### 4. Configuração de Logs
- Crie a pasta `logs/` na raiz do projeto
- Configure as permissões adequadas (755)

## 🔒 Segurança

### Rate Limiting
A API implementa rate limiting para evitar sobrecarga:
- **Limite**: 100 requisições por hora por IP
- **Configurável** através das variáveis de ambiente

### Validação de Entrada
- Todas as entradas são validadas
- Chave de acesso deve ter exatamente 44 dígitos
- CNPJ deve ser válido
- Sanitização de dados

### Logs de Auditoria
- Todas as operações são logadas
- Logs incluem IP, timestamp, operação e resultado
- Logs são armazenados em arquivos separados por data

## 📊 Monitoramento

### Health Check
Use o endpoint `/api/v1/health` para monitorar:
- Status da conexão com SEFAZ
- Validade do certificado
- Status geral da API

### Logs
Os logs são armazenados em:
- `logs/error.log` - Erros da aplicação
- `logs/access.log` - Acessos à API
- `logs/sefaz.log` - Comunicação com SEFAZ

## 🚨 Tratamento de Erros

### Códigos de Status HTTP
- `200` - Sucesso
- `400` - Dados inválidos
- `401` - Não autorizado
- `403` - Acesso negado
- `404` - Recurso não encontrado
- `422` - Erro de validação
- `429` - Rate limit excedido
- `500` - Erro interno do servidor

### Formato de Erro
```json
{
  "success": false,
  "error": {
    "message": "Descrição do erro",
    "code": 400
  },
  "timestamp": "2024-01-15 10:30:00",
  "status_code": 400
}
```

## 🔧 Desenvolvimento

### Estrutura do Projeto
```
nfeapi/
├── public/
│   └── index.php
├── src/
│   ├── Controllers/
│   ├── Services/
│   ├── Utils/
│   ├── Validators/
│   └── Middleware/
├── logs/
├── composer.json
├── env.example
└── README.md
```

### Executando Localmente
```bash
composer install
cp env.example .env
# Configure o .env
php -S localhost:8000 -t public
```

## 📝 Licença

Este projeto está sob a licença MIT. Veja o arquivo LICENSE para mais detalhes.

## 🤝 Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📞 Suporte

Para suporte, envie um email para suporte@seudominio.com ou abra uma issue no GitHub.

---

**⚠️ Importante**: Esta API requer certificado digital válido e credenciais da SEFAZ para funcionar corretamente. Certifique-se de ter todas as autorizações necessárias antes de usar em produção. 