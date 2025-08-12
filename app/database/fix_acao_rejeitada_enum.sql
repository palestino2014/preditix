-- Script para corrigir o ENUM da coluna acao_rejeitada na tabela ordem_servico
-- Execute este script para resolver o erro de "Data truncated for column 'acao_rejeitada'"

-- Verificar o ENUM atual da coluna acao_rejeitada
SHOW COLUMNS FROM ordem_servico LIKE 'acao_rejeitada';

-- Atualizar o ENUM para incluir 'desistencia'
ALTER TABLE ordem_servico 
MODIFY COLUMN acao_rejeitada ENUM('edicao', 'conclusao', 'cancelamento', 'desistencia') NULL;

-- Verificar se a alteração foi aplicada
SHOW COLUMNS FROM ordem_servico LIKE 'acao_rejeitada';

-- Verificar se há dados na coluna que possam causar problemas
SELECT DISTINCT acao_rejeitada FROM ordem_servico WHERE acao_rejeitada IS NOT NULL;
