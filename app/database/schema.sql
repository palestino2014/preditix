-- Sistema de Gerenciamento de Ordens de Serviço - Preditix
-- Schema do Banco de Dados MySQL

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS os_historico;
DROP TABLE IF EXISTS os_itens;
DROP TABLE IF EXISTS ordem_servico;
DROP TABLE IF EXISTS veiculo;
DROP TABLE IF EXISTS usuario;
SET FOREIGN_KEY_CHECKS = 1;

-- Criar banco de dados (descomentar se necessário)
-- CREATE DATABASE IF NOT EXISTS preditix_os DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE preditix_os;

-- Tabela de usuários
CREATE TABLE usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    acesso ENUM('tecnico', 'gestor') NOT NULL,
    ativo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de veículos/ativos
CREATE TABLE veiculo (
    id_ativo INT AUTO_INCREMENT PRIMARY KEY,
    tag VARCHAR(10) NOT NULL, -- LLNN formato
    modelo VARCHAR(25) NOT NULL,
    proprietario VARCHAR(100),
    pbt INT(7),
    pbtc INT(7),
    cmt INT(7),
    tipo VARCHAR(50),
    ano_fabricacao YEAR,
    tara INT(6),
    placa VARCHAR(8), -- LLL NLNN ou LLL NNNN
    chassi VARCHAR(17),
    lotacao INT(6),
    cor VARCHAR(30),
    fabricante VARCHAR(25),
    renavam VARCHAR(11),
    capacidade_volumetrica INT(7),
    inscricao VARCHAR(5), -- LLLNN
    armador VARCHAR(30),
    localizacao VARCHAR(30),
    status VARCHAR(20) DEFAULT 'ativo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_tag (tag),
    INDEX idx_placa (placa),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela principal de ordens de serviço
CREATE TABLE ordem_servico (
    id_os INT AUTO_INCREMENT PRIMARY KEY,
    id_ativo INT NOT NULL,
    tipo_manutencao ENUM('preventiva', 'corretiva', 'preditiva') NOT NULL,
    prioridade ENUM('baixa', 'media', 'alta', 'critica') NOT NULL,
    data_abertura DATETIME,
    data_aprovacao DATETIME,
    data_conclusao DATETIME,
    data_cancelamento DATETIME,
    status ENUM('aberta', 'em_andamento', 'editada', 'concluida', 'cancelada', 'rejeitada') NOT NULL DEFAULT 'aberta',
    autorizada BOOLEAN DEFAULT FALSE,
    status_anterior VARCHAR(20), -- para rejeições
    acao_rejeitada ENUM('abertura', 'edicao', 'conclusao', 'cancelamento'),
    id_gestor INT NOT NULL,
    id_responsavel INT NOT NULL,
    
    -- Sistemas afetados (JSON ou campos separados)
    sistemas_afetados JSON,
    
    -- Sintomas detectados
    sintomas_detectados JSON,
    
    -- Causas dos defeitos
    causas_defeitos JSON,
    
    -- Intervenções realizadas
    intervencoes_realizadas JSON,
    
    -- Ações realizadas
    acoes_realizadas JSON,
    
    -- Observações
    observacoes TEXT,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_ativo) REFERENCES veiculo(id_ativo) ON DELETE RESTRICT,
    FOREIGN KEY (id_gestor) REFERENCES usuario(id) ON DELETE RESTRICT,
    FOREIGN KEY (id_responsavel) REFERENCES usuario(id) ON DELETE RESTRICT,
    
    INDEX idx_status (status),
    INDEX idx_autorizada (autorizada),
    INDEX idx_gestor (id_gestor),
    INDEX idx_responsavel (id_responsavel),
    INDEX idx_data_abertura (data_abertura),
    INDEX idx_prioridade (prioridade)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de itens da OS
CREATE TABLE os_itens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_os INT NOT NULL,
    descricao VARCHAR(255) NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    valor_unitario DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    total DECIMAL(10,2) GENERATED ALWAYS AS (quantidade * valor_unitario) STORED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_os) REFERENCES ordem_servico(id_os) ON DELETE CASCADE,
    INDEX idx_os (id_os)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de backup para dados originais antes de edições
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

-- Tabela de histórico/log
CREATE TABLE os_historico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_os INT NOT NULL,
    usuario_id INT NOT NULL,
    acao ENUM('abertura', 'edicao', 'conclusao', 'cancelamento', 'aprovacao', 'rejeicao', 'tentar_novamente', 'desistencia') NOT NULL,
    status_de VARCHAR(20),
    status_para VARCHAR(20),
    justificativa TEXT, -- obrigatória para rejeições
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_os) REFERENCES ordem_servico(id_os) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuario(id) ON DELETE RESTRICT,
    
    INDEX idx_os (id_os),
    INDEX idx_usuario (usuario_id),
    INDEX idx_acao (acao),
    INDEX idx_data (data_hora)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir usuários padrão para teste
INSERT INTO usuario (nome, email, senha, acesso) VALUES 
('Administrador', 'admin@preditix.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'gestor'), -- password
('João Silva', 'joao@preditix.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tecnico'), -- password
('Maria Santos', 'maria@preditix.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'gestor'), -- password
('Pedro Costa', 'pedro@preditix.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'tecnico'); -- password

-- Inserir alguns veículos para teste
INSERT INTO veiculo (tag, modelo, proprietario, placa, chassi, cor, fabricante, tipo) VALUES 
('AB12', 'Scania R440', 'Preditix Ltda', 'ABC-1234', '9BSRU4X5JBR123456', 'Branco', 'Scania', 'Caminhão'),
('CD34', 'Volvo FH', 'Preditix Ltda', 'DEF-5678', '9BVRU4X5JBR654321', 'Azul', 'Volvo', 'Caminhão'),
('EF56', 'Mercedes Actros', 'Preditix Ltda', 'GHI-9012', '9BMRU4X5JBR789123', 'Vermelho', 'Mercedes', 'Caminhão');

-- Inserir uma OS de exemplo
INSERT INTO ordem_servico (
    id_ativo, tipo_manutencao, prioridade, status, autorizada, 
    id_gestor, id_responsavel, sistemas_afetados, sintomas_detectados,
    causas_defeitos, intervencoes_realizadas, acoes_realizadas, observacoes
) VALUES (
    1, 'preventiva', 'media', 'aberta', FALSE,
    1, 2, 
    '["freios", "suspensao"]',
    '["ruido_anormal", "vibrando"]',
    '["gasto", "desalinhamento"]',
    '["mecanica"]',
    '["inspecionado", "ajustado"]',
    'Revisão preventiva programada'
);

-- Inserir histórico da OS de exemplo
INSERT INTO os_historico (id_os, usuario_id, acao, status_de, status_para) VALUES 
(1, 2, 'abertura', NULL, 'aberta');

-- Inserir itens da OS de exemplo
INSERT INTO os_itens (id_os, descricao, quantidade, valor_unitario) VALUES 
(1, 'Pastilha de freio dianteira', 1, 150.00),
(1, 'Óleo de freio DOT4', 2, 25.00),
(1, 'Mão de obra', 1, 100.00);