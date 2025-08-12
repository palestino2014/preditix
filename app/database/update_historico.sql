-- Script para atualizar a tabela os_historico existente
-- Execute este script no seu banco de dados para adicionar as novas ações

-- Alterar o ENUM da coluna 'acao' para incluir as novas ações
ALTER TABLE os_historico 
MODIFY COLUMN acao ENUM('abertura', 'edicao', 'conclusao', 'cancelamento', 'aprovacao', 'rejeicao', 'tentar_novamente', 'desistencia') NOT NULL;

-- Verificar se a alteração foi aplicada
DESCRIBE os_historico;
