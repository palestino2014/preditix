-- Script para criar a tabela de backup dos dados originais
-- Execute este script no seu banco de dados

-- Criar tabela de backup para dados originais antes de edições
CREATE TABLE os_backup (
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
