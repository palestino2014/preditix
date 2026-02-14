-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS preditix_v1;
USE preditix_v1;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nivel_acesso ENUM('gestor', 'responsavel') DEFAULT 'responsavel',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de embarcações
CREATE TABLE IF NOT EXISTS embarcacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('balsa_simples', 'balsa_motorizada', 'empurrador') NOT NULL,
    tag VARCHAR(50) UNIQUE,
    inscricao VARCHAR(50),
    nome VARCHAR(100) NOT NULL,
    armador VARCHAR(100),
    ano_fabricacao INT,
    capacidade_volumetrica DECIMAL(10,2),
    foto VARCHAR(255),
    status ENUM('ativo', 'inativo', 'manutencao') DEFAULT 'ativo',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de implementos
CREATE TABLE IF NOT EXISTS implementos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('semirreboque_tanque_2_eixos', 'semirreboque_tanque_3_eixos', 
              'semirreboque_tanque_5a_roda_traseira_3_eixos', 'comboio_abastecimento', 
              'bau', 'outro') NOT NULL,
    tag VARCHAR(50) UNIQUE,
    placa VARCHAR(10) UNIQUE,
    fabricante VARCHAR(100),
    modelo VARCHAR(100),
    ano_fabricacao INT,
    chassi VARCHAR(50),
    renavam VARCHAR(50),
    proprietario VARCHAR(100),
    tara DECIMAL(10,2),
    lotacao DECIMAL(10,2),
    peso_bruto_total DECIMAL(10,2),
    capacidade_maxima_tracao DECIMAL(10,2),
    capacidade_volumetrica DECIMAL(10,2),
    cor VARCHAR(50),
    foto VARCHAR(255),
    status ENUM('ativo', 'inativo', 'manutencao') DEFAULT 'ativo',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de tanques
CREATE TABLE IF NOT EXISTS tanques (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tag VARCHAR(50) UNIQUE,
    fabricante_responsavel VARCHAR(100),
    ano_fabricacao INT,
    localizacao VARCHAR(255),
    capacidade_volumetrica DECIMAL(10,2),
    foto VARCHAR(255),
    status ENUM('ativo', 'inativo', 'manutencao') DEFAULT 'ativo',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de veículos
CREATE TABLE IF NOT EXISTS veiculos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo ENUM('caminhao_toco', 'cavalo_mecanico_eixo_simples', 
              'cavalo_mecanico_trucado', 'veiculo_leve_administrativo', 
              'veiculo_leve_operacional') NOT NULL,
    tag VARCHAR(50) UNIQUE,
    placa VARCHAR(10) UNIQUE,
    fabricante VARCHAR(100),
    modelo VARCHAR(100),
    ano_fabricacao INT,
    chassi VARCHAR(50),
    renavam VARCHAR(50),
    proprietario VARCHAR(100),
    tara DECIMAL(10,2),
    lotacao DECIMAL(10,2),
    peso_bruto_total DECIMAL(10,2),
    peso_bruto_total_combinado DECIMAL(10,2),
    capacidade_maxima_tracao DECIMAL(10,2),
    cor VARCHAR(50),
    foto VARCHAR(255),
    status ENUM('ativo', 'inativo', 'manutencao') DEFAULT 'ativo',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de manutenções
CREATE TABLE IF NOT EXISTS manutencoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_equipamento ENUM('embarcacao', 'implemento', 'tanque', 'veiculo') NOT NULL,
    equipamento_id INT NOT NULL,
    data_manutencao DATE NOT NULL,
    descricao TEXT NOT NULL,
    custo DECIMAL(10,2),
    status ENUM('pendente', 'em_andamento', 'concluido') DEFAULT 'pendente',
    usuario_id INT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabela de ordens de serviço
CREATE TABLE IF NOT EXISTS ordens_servico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_os VARCHAR(20) UNIQUE NOT NULL,
    tipo_equipamento ENUM('embarcacao', 'implemento', 'tanque', 'veiculo') NOT NULL,
    equipamento_id INT NOT NULL,
    data_abertura DATE NOT NULL,
    data_prevista DATE,
    data_conclusao DATE,
    descricao_problema TEXT NOT NULL,
    descricao_solucao TEXT,
    status ENUM('aberta', 'em_andamento', 'concluida', 'cancelada') DEFAULT 'aberta',
    prioridade ENUM('baixa', 'media', 'alta', 'urgente') DEFAULT 'media',
    custo_estimado DECIMAL(10,2),
    custo_final DECIMAL(10,2),
    usuario_abertura_id INT NOT NULL,
    usuario_responsavel_id INT,
    FOREIGN KEY (usuario_abertura_id) REFERENCES usuarios(id),
    FOREIGN KEY (usuario_responsavel_id) REFERENCES usuarios(id),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de itens da ordem de serviço
CREATE TABLE IF NOT EXISTS itens_ordem_servico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ordem_servico_id INT NOT NULL,
    descricao TEXT NOT NULL,
    quantidade DECIMAL(10,2) NOT NULL,
    unidade VARCHAR(20) NOT NULL,
    valor_unitario DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (ordem_servico_id) REFERENCES ordens_servico(id),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Inserção do usuário administrador padrão
INSERT INTO usuarios (nome, email, senha, nivel_acesso) VALUES 
('Administrador', 'admin@preditix.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'gestor');
