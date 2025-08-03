# Sistema de Gerenciamento de Ordens de Serviço - Preditix

Sistema completo para gerenciamento de ordens de serviço com funcionalidades PWA, suporte offline e aprovação workflow entre técnicos e gestores.

## 🚀 Características

- **PWA (Progressive Web App)**: Funciona offline, instalável em dispositivos móveis
- **Responsivo**: Interface adaptada para mobile e desktop
- **Multilíngue**: Suporte a Português, Inglês e Espanhol
- **Workflow de Aprovação**: Sistema completo de aprovação/rejeição entre técnicos e gestores
- **Offline First**: Funciona sem internet, sincroniza quando reconecta
- **Reconhecimento de Voz**: Transcrição automática em formulários
- **Interface Neutra**: Design limpo e funcional para usuários de baixa escolaridade

## 🛠️ Tecnologias

- **Backend**: PHP 7.4+ puro (sem frameworks)
- **Frontend**: HTML5, CSS3, JavaScript ES6+
- **Banco de Dados**: MySQL 5.7+
- **PWA**: Service Workers, IndexedDB, Web App Manifest
- **Arquitetura**: MVC (Model-View-Controller)

## 📋 Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx)
- HTTPS (obrigatório para PWA)

## ⚙️ Instalação

### 1. Clone o repositório
```bash
git clone [url-do-repositorio]
cd preditix-os-system
```

### 2. Configure o banco de dados
```bash
# Crie um banco MySQL
mysql -u root -p -e "CREATE DATABASE preditix_os CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Importe o schema
mysql -u root -p preditix_os < database/schema.sql
```

### 3. Configure a conexão
Edite o arquivo `config/database.php`:
```php
private $host = 'localhost';
private $database = 'preditix_os';
private $username = 'seu_usuario';
private $password = 'sua_senha';
```

### 4. Configure o servidor web
Para Apache, certifique-se que o mod_rewrite está habilitado e o .htaccess está funcionando.

Para Nginx, adicione as regras de rewrite necessárias.

### 5. Permissões
```bash
chmod 755 -R ./
chmod 777 -R ./uploads/ # se necessário para uploads futuros
```

## 👥 Usuários Padrão

O sistema vem com usuários pré-cadastrados para teste:

**Gestor:**
- Email: admin@preditix.com
- Senha: password

**Técnico:**
- Email: joao@preditix.com  
- Senha: password

## 📱 Funcionalidades

### Para Técnicos
- Abrir novas ordens de serviço
- Editar OS em andamento
- Concluir ou cancelar OS
- Receber notificações de aprovação/rejeição
- Trabalhar offline

### Para Gestores
- Aprovar ou rejeitar ações dos técnicos
- Abrir OS diretamente (sem aprovação)
- Visualizar todas as OS sob sua gestão
- Justificar rejeições

### PWA Features
- Instalação em dispositivos
- Funcionamento offline
- Sincronização automática
- Cache inteligente
- Notificações push

### Responsividade
- **Mobile**: Interface simplificada, botões grandes
- **Desktop**: Interface completa, mais informações visíveis
- Adaptação automática baseada no tamanho da tela

## 🔄 Fluxo de Trabalho

### Status das OS
- **Aberta**: OS criada pelo técnico, aguardando aprovação
- **Em Andamento**: OS aprovada, técnico pode trabalhar
- **Editada**: Técnico editou OS, aguardando nova aprovação
- **Concluída**: OS finalizada (aguardando aprovação se feita por técnico)
- **Cancelada**: OS cancelada (aguardando aprovação se feita por técnico)
- **Rejeitada**: Gestor rejeitou uma ação, técnico deve revisar

### Workflow de Aprovação
1. Técnico cria/edita/conclui/cancela OS
2. Status fica "não autorizada"
3. Gestor aprova ou rejeita com justificativa
4. Se rejeitado, técnico pode tentar novamente
5. Se aprovado, status atualiza e fluxo continua

## 🌐 Multilíngue

O sistema suporta 3 idiomas:
- **pt-br**: Português (Brasil) - padrão
- **en-gb**: English (United Kingdom)
- **es-es**: Español (España)

Arquivos de tradução em: `lang/`

## 📊 Estrutura do Banco

### Tabelas Principais
- `usuario`: Gestores e técnicos
- `veiculo`: Cadastro de veículos/ativos
- `ordem_servico`: OS principais
- `os_itens`: Itens/materiais das OS
- `os_historico`: Log completo de ações

### Campos Principais da OS
- Informações básicas (tipo, prioridade, datas)
- Sistemas afetados (checkboxes)
- Sintomas detectados (checkboxes)
- Causas dos defeitos (checkboxes)
- Intervenções realizadas (checkboxes)
- Ações realizadas (checkboxes)
- Observações (texto livre + voz)
- Itens (tabela de materiais/custos)

## 🔧 Configuração Avançada

### Service Worker
O arquivo `sw.js` gerencia:
- Cache de recursos estáticos
- Estratégias de cache (cache-first, network-first)
- Sincronização em background
- Notificações push

### IndexedDB
Usado para armazenamento offline:
- OS pendentes de envio
- Requisições em fila
- Cache de dados importantes

### Reconhecimento de Voz
- Suporte nativo do navegador
- Funciona offline em alguns navegadores
- Transcrição em tempo real
- Suporte multilíngue

## 📈 Performance

### Otimizações Implementadas
- Compressão GZIP
- Cache de recursos estáticos
- Lazy loading de componentes
- Minificação automática (via .htaccess)
- Queries otimizadas com índices

### Métricas Esperadas
- **First Contentful Paint**: < 2s
- **Time to Interactive**: < 3s
- **Offline funcionality**: 100%

## 🔒 Segurança

### Implementações de Segurança
- Proteção CSRF em todos os formulários
- Sanitização de inputs
- Prepared statements (PDO)
- Headers de segurança
- Validação server-side
- Sessões seguras

## 🚀 Deploy em Produção

### Hostgator (Plano P)
1. Upload via FTP para public_html
2. Criar banco MySQL no painel
3. Importar schema.sql
4. Configurar database.php
5. Ativar HTTPS (obrigatório para PWA)

### Variáveis de Ambiente
```php
// Para produção, ajustar em config/database.php
private $host = 'localhost'; // ou IP do MySQL
private $database = 'nome_do_banco';
private $username = 'usuario_mysql';
private $password = 'senha_mysql';
```

## 🐛 Troubleshooting

### Problemas Comuns

**PWA não instala:**
- Verificar se HTTPS está ativo
- Validar manifest.json
- Checar console para erros do Service Worker

**Offline não funciona:**
- Verificar se IndexedDB está disponível
- Checar permissões do navegador
- Validar cache do Service Worker

**Reconhecimento de voz falha:**
- Verificar permissões de microfone
- Testar em navegador compatível (Chrome/Edge)
- Verificar conexão para idiomas que precisam de rede

## 📞 Suporte

Para suporte técnico ou dúvidas sobre implementação, consulte a documentação técnica ou entre em contato com a equipe de desenvolvimento.

## 📄 Licença

Este sistema foi desenvolvido especificamente para a Preditix. Todos os direitos reservados.

---

**Desenvolvido para Preditix** - Sistema de Gerenciamento de Ordens de Serviço v1.0