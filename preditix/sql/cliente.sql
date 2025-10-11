CREATE TABLE clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    cnpj VARCHAR(20),
    telefone VARCHAR(20),
    email VARCHAR(100),
    endereco TEXT,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE ordens_servico ADD COLUMN cliente_id INT NULL;
ALTER TABLE ordens_servico ADD FOREIGN KEY (cliente_id) REFERENCES clientes(id);