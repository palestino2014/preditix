<?php

-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS ativos_caminhao;
USE ativos_caminhao;

-- Criar a tabela
CREATE TABLE IF NOT EXISTS ativos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    foto VARCHAR(255) NOT NULL,
    chassis VARCHAR(255) NOT NULL,
    renavam VARCHAR(255) NOT NULL,
    marca VARCHAR(255) NOT NULL,
    modelo VARCHAR(255) NOT NULL,
    placa VARCHAR(20) NOT NULL,
    cor VARCHAR(50) NOT NULL,
    fabricante VARCHAR(255) NOT NULL,
    ano_fabricacao DATE NOT NULL
);

?>
