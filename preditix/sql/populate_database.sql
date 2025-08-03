USE preditix_v1;

-- Inserção de embarcações
INSERT INTO embarcacoes (tipo, tag, inscricao, nome, armador, ano_fabricacao, capacidade_volumetrica) VALUES
('balsa_simples', 'BLS001', 'BR123456', 'Balsa Rio Grande', 'Transportes Fluviais Ltda', 2018, 5000.00),
('balsa_motorizada', 'BLS002', 'BR123457', 'Balsa Amazonas', 'Navegação Norte S.A', 2020, 7500.00),
('empurrador', 'EMP001', 'BR123458', 'Empurrador Tietê', 'Hidrovias do Brasil', 2019, 3000.00);

-- Inserção de implementos
INSERT INTO implementos (tipo, tag, placa, fabricante, modelo, ano_fabricacao, chassi, renavam, proprietario, tara, lotacao, peso_bruto_total, capacidade_maxima_tracao, capacidade_volumetrica, cor) VALUES
('semirreboque_tanque_2_eixos', 'IMP001', 'ABC1234', 'Schmitz', 'CargoBull', 2021, '9BWZZZ377VT004251', '12345678901', 'Transportes ABC Ltda', 8000.00, 20000.00, 28000.00, 40000.00, 30000.00, 'Branco'),
('semirreboque_tanque_3_eixos', 'IMP002', 'DEF5678', 'CIMC', 'Tank', 2022, '9BWZZZ377VT004252', '12345678902', 'Logística XYZ S.A', 10000.00, 25000.00, 35000.00, 50000.00, 40000.00, 'Azul'),
('comboio_abastecimento', 'IMP003', 'GHI9012', 'Fras-le', 'Fuel', 2020, '9BWZZZ377VT004253', '12345678903', 'Combustíveis Brasil Ltda', 12000.00, 30000.00, 42000.00, 60000.00, 50000.00, 'Vermelho');

-- Inserção de tanques
INSERT INTO tanques (tag, fabricante_responsavel, ano_fabricacao, localizacao, capacidade_volumetrica) VALUES
('TNK001', 'Tanques Brasil S.A', 2019, 'Terminal Portuário de Santos', 100000.00),
('TNK002', 'Metalúrgica ABC Ltda', 2020, 'Terminal de Paranaguá', 150000.00),
('TNK003', 'Indústria de Tanques XYZ', 2021, 'Terminal de Rio Grande', 200000.00);

-- Inserção de veículos
INSERT INTO veiculos (tipo, tag, placa, fabricante, modelo, ano_fabricacao, chassi, renavam, proprietario, tara, lotacao, peso_bruto_total, peso_bruto_total_combinado, capacidade_maxima_tracao, cor) VALUES
('cavalo_mecanico_trucado', 'VCL001', 'JKL3456', 'Volvo', 'FH 540', 2022, '9BWZZZ377VT004254', '12345678904', 'Transportes ABC Ltda', 12000.00, 30000.00, 42000.00, 74000.00, 60000.00, 'Prata'),
('caminhao_toco', 'VCL002', 'MNO7890', 'Mercedes-Benz', 'Actros 2651', 2021, '9BWZZZ377VT004255', '12345678905', 'Logística XYZ S.A', 8000.00, 20000.00, 28000.00, 28000.00, 20000.00, 'Branco'),
('veiculo_leve_administrativo', 'VCL003', 'PQR1234', 'Toyota', 'Hilux', 2023, '9BWZZZ377VT004256', '12345678906', 'Combustíveis Brasil Ltda', 2000.00, 1000.00, 3000.00, 3000.00, 1000.00, 'Preto');

-- Inserção de manutenções
INSERT INTO manutencoes (tipo_equipamento, equipamento_id, data_manutencao, descricao, custo, status, usuario_id) VALUES
('embarcacao', 1, '2024-03-15', 'Manutenção preventiva do motor', 15000.00, 'concluido', 1),
('implemento', 1, '2024-03-20', 'Troca de pneus e revisão do sistema de freios', 8000.00, 'em_andamento', 1),
('tanque', 1, '2024-04-01', 'Limpeza e inspeção de segurança', 5000.00, 'pendente', 1),
('veiculo', 1, '2024-03-25', 'Revisão geral e troca de óleo', 3000.00, 'concluido', 1); 