-- Script para corrigir o ENUM da coluna acao_rejeitada
-- Inclui apenas ações que foram rejeitadas pelo gestor

-- Verificar o ENUM atual da coluna acao_rejeitada
SHOW COLUMNS FROM ordem_servico LIKE 'acao_rejeitada';

-- Atualizar o ENUM para incluir apenas ações que foram rejeitadas pelo gestor
ALTER TABLE ordem_servico 
MODIFY COLUMN acao_rejeitada ENUM('edicao', 'conclusao', 'cancelamento') NULL;

-- Verificar se a alteração foi aplicada
SHOW COLUMNS FROM ordem_servico LIKE 'acao_rejeitada';

-- Verificar se há dados na coluna
SELECT DISTINCT acao_rejeitada FROM ordem_servico WHERE acao_rejeitada IS NOT NULL;
