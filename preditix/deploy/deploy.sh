#!/bin/bash

# Script de Deploy Automático para HostGator
# Uso: ./deploy.sh <cliente> <ambiente> [host] [usuario]
# Exemplo: ./deploy.sh metalmar true ftp.hostgator.com usuario

set -e  # Para o script se houver erro

# Cores para output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Função para exibir mensagens coloridas
print_message() {
    echo -e "${2}${1}${NC}"
}

# Função para exibir ajuda
show_help() {
    echo "=== Script de Deploy Automático Preditix ==="
    echo ""
    echo "Uso: $0 <cliente> <ambiente> [host] [usuario]"
    echo ""
    echo "Parâmetros obrigatórios:"
    echo "  cliente    - Nome da pasta do cliente (ex: metalmar, cliente2)"
    echo "  ambiente   - true para remoto, false para local"
    echo ""
    echo "Parâmetros opcionais:"
    echo "  host       - Servidor FTP (padrão: ftp.hostgator.com)"
    echo "  usuario    - Usuário FTP (padrão: lê do arquivo .env)"
    echo ""
    echo "Exemplos:"
    echo "  $0 metalmar true"
    echo "  $0 cliente2 true ftp.hostgator.com usuario123"
    echo ""
    echo "Arquivos necessários:"
    echo "  .env        - Configurações FTP (criar se não existir)"
    echo "  .gitignore  - Para ignorar arquivos desnecessários"
    echo ""
}

# Verificar se foi passado o número mínimo de argumentos
if [ $# -lt 2 ]; then
    print_message "❌ Erro: Número insuficiente de argumentos!" $RED
    show_help
    exit 1
fi

# Parâmetros
CLIENTE=$1
AMBIENTE=$2
HOST=${3:-"ftp.hostgator.com"}
USUARIO=${4:-""}

# Validar ambiente
if [ "$AMBIENTE" != "true" ] && [ "$AMBIENTE" != "false" ]; then
    print_message "❌ Erro: Ambiente deve ser 'true' ou 'false'!" $RED
    exit 1
fi

print_message "🚀 Iniciando deploy para cliente: $CLIENTE" $BLUE
print_message "🌐 Ambiente: $([ "$AMBIENTE" = "true" ] && echo "Remoto" || echo "Local")" $BLUE
print_message "🖥️  Host: $HOST" $BLUE

# Verificar se os arquivos necessários existem
if [ ! -f "includes/config.php" ]; then
    print_message "❌ Erro: Arquivo includes/config.php não encontrado!" $RED
    exit 1
fi

if [ ! -f "includes/header.php" ]; then
    print_message "❌ Erro: Arquivo includes/header.php não encontrado!" $RED
    exit 1
fi

# Criar backup dos arquivos originais
print_message "📦 Criando backup dos arquivos de configuração..." $YELLOW
cp includes/config.php includes/config.php.backup
cp includes/header.php includes/header.php.backup

# Função para restaurar arquivos em caso de erro
restore_files() {
    print_message "🔄 Restaurando arquivos originais..." $YELLOW
    mv includes/config.php.backup includes/config.php
    mv includes/header.php.backup includes/header.php
}

# Configurar trap para restaurar arquivos em caso de erro
trap restore_files ERR

# Aplicar configurações
print_message "⚙️  Aplicando configurações..." $YELLOW

# Configurar config.php
if [ "$AMBIENTE" = "true" ]; then
    sed -i.bak "s/\$ambienteIsRemoto = .*/\$ambienteIsRemoto = true;/" includes/config.php
    sed -i.bak "s/session_name('sess_' . DB_NAME);/session_name('preditix_session');/" includes/config.php
else
    sed -i.bak "s/\$ambienteIsRemoto = .*/\$ambienteIsRemoto = false;/" includes/config.php
    sed -i.bak "s/session_name('preditix_session');/session_name('sess_' . DB_NAME);/" includes/config.php
fi

# Configurar header.php
if [ "$AMBIENTE" = "true" ]; then
    sed -i.bak "s/\$base_url = .*/\$base_url = '\/$CLIENTE';/" includes/header.php
else
    sed -i.bak "s/\$base_url = .*/\$base_url = '\/preditix\/preditix';/" includes/header.php
fi

# Remover arquivos .bak
rm -f includes/config.php.bak includes/header.php.bak

print_message "✅ Configurações aplicadas com sucesso!" $GREEN

# Verificar se existe arquivo .env para credenciais FTP
if [ -z "$USUARIO" ] && [ -f ".env" ]; then
    source .env
    USUARIO=${FTP_USERNAME:-""}
fi

# Verificar variáveis de ambiente (útil para CI/CD)
if [ -z "$USUARIO" ]; then
    USUARIO=${FTP_USERNAME:-""}
fi

SENHA=${FTP_PASSWORD:-""}

# Se não foi fornecido usuário, solicitar (apenas se não for modo não-interativo)
if [ -z "$USUARIO" ] && [ -t 0 ]; then
    read -p "Digite o usuário FTP: " USUARIO
fi

# Solicitar senha FTP (apenas se não for modo não-interativo e não estiver em variável de ambiente)
if [ -z "$SENHA" ] && [ -t 0 ]; then
    read -s -p "Digite a senha FTP: " SENHA
    echo ""
fi

# Verificar se tem credenciais
if [ -z "$USUARIO" ] || [ -z "$SENHA" ]; then
    print_message "❌ Erro: Usuário ou senha FTP não fornecidos!" $RED
    print_message "💡 Dica: Configure FTP_USERNAME e FTP_PASSWORD no arquivo .env ou como variáveis de ambiente" $YELLOW
    exit 1
fi

# Criar arquivo temporário com credenciais FTP
FTP_CONFIG=$(mktemp)
cat > "$FTP_CONFIG" << EOF
open $HOST
user $USUARIO $SENHA
binary
cd public_html
mkdir $CLIENTE
cd $CLIENTE
lcd .
mput -R *
quit
EOF

# Fazer upload via FTP
print_message "📤 Fazendo upload dos arquivos..." $YELLOW

if command -v ftp >/dev/null 2>&1; then
    ftp -n < "$FTP_CONFIG"
    print_message "✅ Upload concluído com sucesso!" $GREEN
else
    print_message "⚠️  FTP não encontrado. Usando alternativa..." $YELLOW
    
    # Alternativa usando curl (se disponível)
    if command -v curl >/dev/null 2>&1; then
        print_message "📤 Fazendo upload via curl..." $YELLOW
        # Criar arquivo ZIP temporário
        ZIP_FILE="preditix_${CLIENTE}_$(date +%Y%m%d_%H%M%S).zip"
        zip -r "$ZIP_FILE" . -x "*.git*" "*.backup" "*.bak" "deploy.sh" ".env*" "*.log"
        
        # Upload do ZIP
        curl -T "$ZIP_FILE" "ftp://$HOST/public_html/$CLIENTE/" --user "$USUARIO:$SENHA"
        
        # Instruções para descompactar no servidor
        print_message "📋 Instruções para completar o deploy:" $YELLOW
        echo "1. Acesse o cPanel do HostGator"
        echo "2. Vá em 'Gerenciador de Arquivos'"
        echo "3. Navegue até public_html/$CLIENTE/"
        echo "4. Extraia o arquivo $ZIP_FILE"
        echo "5. Mova os arquivos extraídos para a pasta $CLIENTE/"
        echo "6. Delete o arquivo $ZIP_FILE"
        
        # Limpar arquivo ZIP local
        rm -f "$ZIP_FILE"
    else
        print_message "❌ Nem FTP nem curl encontrados. Upload manual necessário." $RED
        print_message "📋 Instruções para upload manual:" $YELLOW
        echo "1. Compacte a pasta do projeto"
        echo "2. Faça upload via cPanel File Manager"
        echo "3. Extraia na pasta public_html/$CLIENTE/"
    fi
fi

# Limpar arquivo temporário
rm -f "$FTP_CONFIG"

# Restaurar arquivos originais
print_message "🔄 Restaurando configurações locais..." $YELLOW
mv includes/config.php.backup includes/config.php
mv includes/header.php.backup includes/header.php

# Remover trap
trap - ERR

# Exibir resumo do deploy
print_message "🎉 Deploy concluído com sucesso!" $GREEN
echo ""
print_message "📋 Resumo do deploy:" $BLUE
echo "  Cliente: $CLIENTE"
echo "  Ambiente: $([ "$AMBIENTE" = "true" ] && echo "Remoto" || echo "Local")"
echo "  Host: $HOST"
echo "  Pasta: public_html/$CLIENTE"
echo ""
print_message "🌐 URLs de acesso:" $BLUE
echo "  Local: http://localhost/preditix/preditix"
echo "  Remoto: https://seudominio.com/$CLIENTE"
echo ""
print_message "✅ Pronto para uso!" $GREEN
