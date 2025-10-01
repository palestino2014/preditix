-- Criação das tabelas de indicadores MTTR e MTBF para cada tipo de ativo

-- Tabelas MTTR (Mean Time To Repair - Tempo Médio de Reparo)
CREATE TABLE IF NOT EXISTS mttr_embarcacao (
    id_ativo INT PRIMARY KEY,
    mttr FLOAT NOT NULL,
    num_os INT NOT NULL,
    data_registro DATETIME NOT NULL,
    INDEX idx_data_registro (data_registro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mttr_implemento (
    id_ativo INT PRIMARY KEY,
    mttr FLOAT NOT NULL,
    num_os INT NOT NULL,
    data_registro DATETIME NOT NULL,
    INDEX idx_data_registro (data_registro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mttr_tanque (
    id_ativo INT PRIMARY KEY,
    mttr FLOAT NOT NULL,
    num_os INT NOT NULL,
    data_registro DATETIME NOT NULL,
    INDEX idx_data_registro (data_registro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mttr_veiculo (
    id_ativo INT PRIMARY KEY,
    mttr FLOAT NOT NULL,
    num_os INT NOT NULL,
    data_registro DATETIME NOT NULL,
    INDEX idx_data_registro (data_registro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabelas MTBF (Mean Time Between Failures - Tempo Médio Entre Falhas)
CREATE TABLE IF NOT EXISTS mtbf_embarcacao (
    id_ativo INT PRIMARY KEY,
    mtbf FLOAT NOT NULL,
    num_os INT NOT NULL,
    data_registro DATETIME NOT NULL,
    INDEX idx_data_registro (data_registro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mtbf_implemento (
    id_ativo INT PRIMARY KEY,
    mtbf FLOAT NOT NULL,
    num_os INT NOT NULL,
    data_registro DATETIME NOT NULL,
    INDEX idx_data_registro (data_registro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mtbf_tanque (
    id_ativo INT PRIMARY KEY,
    mtbf FLOAT NOT NULL,
    num_os INT NOT NULL,
    data_registro DATETIME NOT NULL,
    INDEX idx_data_registro (data_registro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mtbf_veiculo (
    id_ativo INT PRIMARY KEY,
    mtbf FLOAT NOT NULL,
    num_os INT NOT NULL,
    data_registro DATETIME NOT NULL,
    INDEX idx_data_registro (data_registro)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
