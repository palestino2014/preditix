-- Criação da tabela ordens_servico
CREATE TABLE IF NOT EXISTS ordens_servico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_os VARCHAR(20) UNIQUE NOT NULL,
    tipo_equipamento ENUM('embarcacao', 'veiculo', 'implemento', 'tanque') NOT NULL,
    equipamento_id INT NOT NULL,
    
    -- Campos comuns a todos os tipos
    data_abertura DATETIME NOT NULL,
    data_prevista DATETIME,
    data_conclusao DATETIME,
    odometro DECIMAL(10,2),
    tipo_manutencao ENUM('preventiva', 'corretiva', 'preditiva') NOT NULL,
    
    -- Campos específicos em JSON
    sistemas_afetados JSON, -- Armazena os checkboxes marcados
    sintomas_detectados JSON, -- Armazena os checkboxes marcados
    causas_defeitos JSON, -- Armazena os checkboxes marcados
    tipo_intervencao JSON, -- Armazena os checkboxes marcados
    acoes_realizadas JSON, -- Armazena os checkboxes marcados
    
    -- Campos de texto
    observacoes TEXT,
    mantenedores TEXT,
    materiais_utilizados TEXT,
    
    -- Campos de controle
    status ENUM('aberta', 'em_andamento', 'concluida', 'cancelada') DEFAULT 'aberta',
    prioridade ENUM('baixa', 'media', 'alta', 'urgente') DEFAULT 'media',
    usuario_abertura_id INT NOT NULL,
    usuario_responsavel_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Índices
    INDEX idx_tipo_equipamento (tipo_equipamento),
    INDEX idx_equipamento_id (equipamento_id),
    INDEX idx_status (status),
    INDEX idx_data_abertura (data_abertura)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 