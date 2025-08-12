-- Script simples para corrigir apenas o ENUM da tabela os_historico
-- Execute este script para resolver o erro 500

ALTER TABLE os_historico 
MODIFY COLUMN acao ENUM('abertura', 'edicao', 'conclusao', 'cancelamento', 'aprovacao', 'rejeicao', 'tentar_novamente', 'desistencia') NOT NULL;
