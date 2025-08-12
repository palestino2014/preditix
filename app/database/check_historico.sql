-- Script para verificar o status da tabela os_historico
-- Execute este script para verificar se as alterações foram aplicadas

-- Verificar a estrutura da tabela os_historico
DESCRIBE os_historico;

-- Verificar se a coluna 'acao' tem o ENUM correto
SHOW COLUMNS FROM os_historico LIKE 'acao';

-- Verificar se a tabela os_backup existe
SHOW TABLES LIKE 'os_backup';

-- Se a tabela os_backup existir, verificar sua estrutura
DESCRIBE os_backup;

-- Verificar se há dados na tabela os_historico
SELECT COUNT(*) as total_registros FROM os_historico;

-- Verificar as ações disponíveis na tabela os_historico
SELECT DISTINCT acao FROM os_historico;
