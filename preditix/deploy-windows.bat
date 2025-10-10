@echo off
REM Script de Deploy Automático para Windows (HostGator)
REM Uso: deploy-windows.bat <cliente> <ambiente>
REM Exemplo: deploy-windows.bat metalmar true

setlocal enabledelayedexpansion

REM Verificar se foi passado o número mínimo de argumentos
if "%~2"=="" (
    echo ❌ Erro: Número insuficiente de argumentos!
    echo.
    echo === Script de Deploy Automático Preditix ===
    echo.
    echo Uso: %0 ^<cliente^> ^<ambiente^>
    echo.
    echo Parâmetros obrigatórios:
    echo   cliente    - Nome da pasta do cliente (ex: metalmar, cliente2)
    echo   ambiente   - true para remoto, false para local
    echo.
    echo Exemplos:
    echo   %0 metalmar true
    echo   %0 cliente2 false
    echo.
    pause
    exit /b 1
)

REM Parâmetros
set CLIENTE=%1
set AMBIENTE=%2

REM Validar ambiente
if not "%AMBIENTE%"=="true" if not "%AMBIENTE%"=="false" (
    echo ❌ Erro: Ambiente deve ser 'true' ou 'false'!
    pause
    exit /b 1
)

echo 🚀 Iniciando deploy para cliente: %CLIENTE%
if "%AMBIENTE%"=="true" (
    echo 🌐 Ambiente: Remoto
) else (
    echo 🌐 Ambiente: Local
)

REM Verificar se os arquivos necessários existem
if not exist "includes\config.php" (
    echo ❌ Erro: Arquivo includes\config.php não encontrado!
    pause
    exit /b 1
)

if not exist "includes\header.php" (
    echo ❌ Erro: Arquivo includes\header.php não encontrado!
    pause
    exit /b 1
)

REM Criar backup dos arquivos originais
echo 📦 Criando backup dos arquivos de configuração...
copy "includes\config.php" "includes\config.php.backup" >nul
copy "includes\header.php" "includes\header.php.backup" >nul

REM Aplicar configurações
echo ⚙️ Aplicando configurações...

REM Configurar config.php
if "%AMBIENTE%"=="true" (
    powershell -Command "(Get-Content 'includes\config.php') -replace '\$ambienteIsRemoto = .*', '\$ambienteIsRemoto = true;' | Set-Content 'includes\config.php'"
    powershell -Command "(Get-Content 'includes\config.php') -replace 'session_name\(''sess_'' . DB_NAME\);', 'session_name(''preditix_session'');' | Set-Content 'includes\config.php'"
) else (
    powershell -Command "(Get-Content 'includes\config.php') -replace '\$ambienteIsRemoto = .*', '\$ambienteIsRemoto = false;' | Set-Content 'includes\config.php'"
    powershell -Command "(Get-Content 'includes\config.php') -replace 'session_name\(''preditix_session''\);', 'session_name(''sess_'' . DB_NAME);' | Set-Content 'includes\config.php'"
)

REM Configurar header.php
if "%AMBIENTE%"=="true" (
    powershell -Command "(Get-Content 'includes\header.php') -replace '\$base_url = .*', '\$base_url = ''/%CLIENTE%'';' | Set-Content 'includes\header.php'"
) else (
    powershell -Command "(Get-Content 'includes\header.php') -replace '\$base_url = .*', '\$base_url = ''/preditix/preditix'';' | Set-Content 'includes\header.php'"
)

echo ✅ Configurações aplicadas com sucesso!

REM Solicitar credenciais FTP
set /p FTP_USER="Digite o usuário FTP: "
set /p FTP_PASS="Digite a senha FTP: "

REM Criar arquivo ZIP para upload
echo 📦 Criando arquivo ZIP...
set ZIP_FILE=preditix_%CLIENTE%_%date:~-4,4%%date:~-10,2%%date:~-7,2%_%time:~0,2%%time:~3,2%%time:~6,2%.zip
set ZIP_FILE=%ZIP_FILE: =0%

REM Usar PowerShell para criar ZIP (Windows 10+)
powershell -Command "Compress-Archive -Path '.\*' -DestinationPath '%ZIP_FILE%' -Force"

echo 📤 Arquivo ZIP criado: %ZIP_FILE%

REM Instruções para upload manual
echo.
echo 📋 Instruções para completar o deploy:
echo 1. Acesse o cPanel do HostGator
echo 2. Vá em 'Gerenciador de Arquivos'
echo 3. Navegue até public_html\%CLIENTE%\
echo 4. Faça upload do arquivo %ZIP_FILE%
echo 5. Extraia o arquivo ZIP
echo 6. Mova os arquivos extraídos para a pasta %CLIENTE%\
echo 7. Delete o arquivo %ZIP_FILE%
echo.

REM Restaurar arquivos originais
echo 🔄 Restaurando configurações locais...
move "includes\config.php.backup" "includes\config.php" >nul
move "includes\header.php.backup" "includes\header.php" >nul

REM Exibir resumo do deploy
echo 🎉 Deploy preparado com sucesso!
echo.
echo 📋 Resumo do deploy:
echo   Cliente: %CLIENTE%
if "%AMBIENTE%"=="true" (
    echo   Ambiente: Remoto
) else (
    echo   Ambiente: Local
)
echo   Arquivo: %ZIP_FILE%
echo.
echo 🌐 URLs de acesso:
echo   Local: http://localhost/preditix/preditix
echo   Remoto: https://seudominio.com/%CLIENTE%
echo.
echo ✅ Pronto para upload manual!
echo.
pause
