# 🚀 Push to Deploy - Documentação Completa

## 📋 Como Funciona Atualmente

O sistema atual **NÃO é push to deploy automático**. O fluxo atual é:

```
1. Desenvolvimento Local
   ↓
2. git add . && git commit -m "mensagem"
   ↓
3. git push origin main
   ↓
4. 🔴 MANUAL: Executar ./deploy.sh <cliente> <ambiente>
   ↓
5. Deploy concluído
```

## 🔄 O que é Push to Deploy?

Push to Deploy é um sistema onde **apenas fazer `git push`** dispara automaticamente o deploy para produção, sem necessidade de executar scripts manualmente.

```
1. Desenvolvimento Local
   ↓
2. git add . && git commit -m "mensagem"
   ↓
3. git push origin main
   ↓
4. ✅ AUTOMÁTICO: CI/CD executa deploy.sh
   ↓
5. Deploy concluído
```

## 🛠️ Opções para Implementar Push to Deploy

### Opção 1: GitHub Actions (Recomendado) ⭐

**Vantagens:**
- ✅ Gratuito para repositórios públicos
- ✅ Integração nativa com GitHub
- ✅ Configuração simples
- ✅ Logs visíveis no GitHub
- ✅ Executa em ambiente isolado

**Como Configurar:**

1. **Criar Secrets no GitHub:**
   - Vá em: Settings → Secrets and variables → Actions
   - Adicione:
     - `FTP_HOST`: `ftp.hostgator.com`
     - `FTP_USERNAME`: seu usuário FTP
     - `FTP_PASSWORD`: sua senha FTP
     - `CLIENTE`: nome do cliente (ex: `metalmar`)

2. **O arquivo `.github/workflows/deploy.yml` já foi criado!**

3. **Configurar qual branch dispara o deploy:**
   Edite `.github/workflows/deploy.yml` e ajuste:
   ```yaml
   on:
     push:
       branches:
         - main  # Mude para a branch que você usa
   ```

4. **Fazer push:**
   ```bash
   git add .
   git commit -m "Atualização"
   git push origin main
   ```
   
   O deploy será executado automaticamente! 🎉

**Monitorar o Deploy:**
- Vá em: Actions (aba no GitHub)
- Veja o status e logs do deploy em tempo real

---

### Opção 2: GitLab CI/CD

Se você usa GitLab, crie `.gitlab-ci.yml`:

```yaml
stages:
  - deploy

deploy_production:
  stage: deploy
  image: alpine:latest
  before_script:
    - apk add --no-cache bash curl
    - chmod +x deploy/deploy.sh
  script:
    - deploy/deploy.sh $CLIENTE true $FTP_HOST $FTP_USERNAME
  environment:
    name: production
  only:
    - main
```

Configure as variáveis em: Settings → CI/CD → Variables

---

### Opção 3: Git Hook no Servidor (Post-Receive)

**Funciona assim:**
- Você faz push para um repositório Git no próprio servidor
- O hook `post-receive` executa automaticamente o deploy

**Configuração:**

1. **No servidor, criar repositório bare:**
   ```bash
   cd /var/www
   git clone --bare /caminho/do/repositorio.git
   ```

2. **Criar hook post-receive:**
   ```bash
   cd /var/www/repositorio.git/hooks
   nano post-receive
   ```

3. **Conteúdo do hook:**
   ```bash
   #!/bin/bash
   WORK_TREE=/var/www/html/preditix/preditix
   GIT_DIR=/var/www/repositorio.git
   
   git --git-dir=$GIT_DIR --work-tree=$WORK_TREE checkout -f
   cd $WORK_TREE
   ./deploy/deploy.sh metalmar true
   ```

4. **Tornar executável:**
   ```bash
   chmod +x post-receive
   ```

5. **Configurar remote no seu repositório local:**
   ```bash
   git remote add deploy ssh://usuario@servidor/var/www/repositorio.git
   ```

6. **Deploy automático:**
   ```bash
   git push deploy main
   ```

---

### Opção 4: Webhook + Script Local

Crie um servidor webhook simples que executa o deploy quando recebe um POST do GitHub/GitLab.

**Exemplo com PHP:**

```php
<?php
// webhook.php
$secret = 'seu_secret_aqui';
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];

if (hash_equals('sha1=' . hash_hmac('sha1', $payload, $secret), $signature)) {
    exec('cd /var/www/html/preditix/preditix && ./deploy/deploy.sh metalmar true > /tmp/deploy.log 2>&1 &');
    http_response_code(200);
} else {
    http_response_code(403);
}
```

Configure no GitHub: Settings → Webhooks → Add webhook

---

## 🔧 Melhorias no Script de Deploy

O script `deploy.sh` foi atualizado para:
- ✅ Aceitar senha via variável de ambiente (`FTP_PASSWORD`)
- ✅ Funcionar em modo não-interativo (CI/CD)
- ✅ Validar credenciais antes de tentar deploy

**Uso com variáveis de ambiente:**
```bash
export FTP_USERNAME="usuario"
export FTP_PASSWORD="senha"
./deploy.sh metalmar true
```

---

## 📊 Comparação das Opções

| Opção | Complexidade | Custo | Automação | Recomendado Para |
|-------|-------------|-------|-----------|------------------|
| GitHub Actions | ⭐⭐ Fácil | Grátis | ✅ Total | Projetos no GitHub |
| GitLab CI | ⭐⭐ Fácil | Grátis | ✅ Total | Projetos no GitLab |
| Git Hook | ⭐⭐⭐ Média | Grátis | ✅ Total | Servidor próprio |
| Webhook | ⭐⭐⭐⭐ Difícil | Grátis | ✅ Total | Integração customizada |

---

## 🚀 Próximos Passos

1. **Escolha uma opção** (recomendamos GitHub Actions)
2. **Configure as credenciais** como secrets/variáveis
3. **Teste fazendo um push**
4. **Monitore os logs** para garantir que está funcionando

---

## ❓ FAQ

**P: Posso usar várias opções ao mesmo tempo?**
R: Sim, mas cuidado para não fazer deploy duplicado!

**P: Como desabilitar temporariamente o deploy automático?**
R: Comente a seção `on:` no workflow do GitHub Actions ou remova o trigger.

**P: Como fazer deploy apenas de uma branch específica?**
R: Configure `branches:` no workflow para aceitar apenas a branch desejada.

**P: O deploy automático falhou. O que fazer?**
R: Verifique os logs no GitHub Actions/GitLab CI. O script mantém backups automáticos.

---

**🎉 Com Push to Deploy configurado, você economiza tempo e reduz erros!**

