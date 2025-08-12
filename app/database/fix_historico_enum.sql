-- Script para corrigir o ENUM da tabela os_historico
-- Execute este script para adicionar as ações 'tentar_novamente' e 'desistencia'

-- Verificar o ENUM atual
SHOW COLUMNS FROM os_historico LIKE 'acao';

-- Atualizar o ENUM para incluir as novas ações
ALTER TABLE os_historico 
MODIFY COLUMN acao ENUM('abertura', 'edicao', 'conclusao', 'cancelamento', 'aprovacao', 'rejeicao', 'tentar_novamente', 'desistencia') NOT NULL;

-- Verificar se a alteração foi aplicada
SHOW COLUMNS FROM os_historico LIKE 'acao';

-- Verificar se a tabela os_backup existe, se não, criar
CREATE TABLE IF NOT EXISTS os_backup (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_os INT NOT NULL,
    tipo_manutencao ENUM('preventiva', 'corretiva', 'preditiva') NOT NULL,
    prioridade ENUM('baixa', 'media', 'alta', 'critica') NOT NULL,
    sistemas_afetados JSON,
    sintomas_detectados JSON,
    causas_defeitos JSON,
    intervencoes_realizadas JSON,
    acoes_realizadas JSON,
    observacoes TEXT,
    data_backup TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_os) REFERENCES ordem_servico(id_os) ON DELETE CASCADE,
    INDEX idx_os (id_os),
    INDEX idx_data_backup (data_backup)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Verificar se a tabela foi criada
SHOW TABLES LIKE 'os_backup';
DESCRIBE os_backup;
