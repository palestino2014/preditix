-- Script para popular o banco com mais ordens de serviço
-- Primeiro, vamos limpar as ordens existentes para evitar duplicatas
DELETE FROM itens_ordem_servico;
DELETE FROM ordens_servico;

-- Inserir novas ordens de serviço para embarcações
INSERT INTO ordens_servico (numero_os, tipo_equipamento, equipamento_id, data_abertura, data_prevista, data_conclusao, descricao_problema, status, prioridade, custo_estimado, usuario_abertura_id, usuario_responsavel_id)
VALUES 
-- Embarcação 1 (3 ordens)
('OS-2024-001', 'embarcacao', 1, '2024-01-15', '2024-01-16', '2024-01-16', 'Manutenção preventiva do motor', 'concluida', 'alta', 2500.00, 1, 1),
('OS-2024-002', 'embarcacao', 1, '2024-02-20', '2024-02-21', '2024-02-21', 'Troca de óleo e filtros', 'concluida', 'media', 800.00, 1, 1),
('OS-2024-003', 'embarcacao', 1, '2024-03-10', '2024-03-12', NULL, 'Reparo no sistema de navegação', 'em_andamento', 'alta', 1500.00, 1, 1),

-- Embarcação 2 (4 ordens)
('OS-2024-004', 'embarcacao', 2, '2024-01-05', '2024-01-07', '2024-01-07', 'Manutenção do casco', 'concluida', 'alta', 3500.00, 1, 1),
('OS-2024-005', 'embarcacao', 2, '2024-02-15', '2024-02-16', '2024-02-16', 'Reparo no sistema elétrico', 'concluida', 'alta', 2000.00, 1, 1),
('OS-2024-006', 'embarcacao', 2, '2024-03-01', '2024-03-01', '2024-03-01', 'Troca de baterias', 'concluida', 'media', 1200.00, 1, 1),
('OS-2024-007', 'embarcacao', 2, '2024-03-15', '2024-03-18', NULL, 'Manutenção do sistema de propulsão', 'aberta', 'alta', 2800.00, 1, 1),

-- Implemento 1 (3 ordens)
('OS-2024-008', 'implemento', 1, '2024-01-10', '2024-01-11', '2024-01-11', 'Reparo no sistema hidráulico', 'concluida', 'alta', 1800.00, 1, 1),
('OS-2024-009', 'implemento', 1, '2024-02-05', '2024-02-05', '2024-02-05', 'Troca de pneus', 'concluida', 'media', 1200.00, 1, 1),
('OS-2024-010', 'implemento', 1, '2024-03-12', '2024-03-14', NULL, 'Manutenção preventiva', 'em_andamento', 'baixa', 900.00, 1, 1),

-- Implemento 2 (2 ordens)
('OS-2024-011', 'implemento', 2, '2024-01-20', '2024-01-22', '2024-01-22', 'Reparo no sistema de elevação', 'concluida', 'alta', 2200.00, 1, 1),
('OS-2024-012', 'implemento', 2, '2024-03-08', '2024-03-10', NULL, 'Manutenção geral', 'aberta', 'media', 1500.00, 1, 1),

-- Tanque 1 (4 ordens)
('OS-2024-013', 'tanque', 1, '2024-01-08', '2024-01-09', '2024-01-09', 'Limpeza e inspeção', 'concluida', 'alta', 800.00, 1, 1),
('OS-2024-014', 'tanque', 1, '2024-02-10', '2024-02-11', '2024-02-11', 'Reparo no sistema de válvulas', 'concluida', 'alta', 1500.00, 1, 1),
('OS-2024-015', 'tanque', 1, '2024-02-25', '2024-02-25', '2024-02-25', 'Troca de sensores', 'concluida', 'media', 1200.00, 1, 1),
('OS-2024-016', 'tanque', 1, '2024-03-14', '2024-03-16', NULL, 'Manutenção preventiva', 'em_andamento', 'baixa', 900.00, 1, 1),

-- Tanque 2 (3 ordens)
('OS-2024-017', 'tanque', 2, '2024-01-12', '2024-01-13', '2024-01-13', 'Reparo no sistema de pressão', 'concluida', 'alta', 2000.00, 1, 1),
('OS-2024-018', 'tanque', 2, '2024-02-15', '2024-02-15', '2024-02-15', 'Limpeza interna', 'concluida', 'media', 600.00, 1, 1),
('OS-2024-019', 'tanque', 2, '2024-03-10', '2024-03-12', NULL, 'Manutenção do sistema de segurança', 'aberta', 'alta', 1800.00, 1, 1),

-- Veículo 1 (5 ordens)
('OS-2024-020', 'veiculo', 1, '2024-01-05', '2024-01-05', '2024-01-05', 'Troca de óleo e filtros', 'concluida', 'media', 400.00, 1, 1),
('OS-2024-021', 'veiculo', 1, '2024-01-20', '2024-01-20', '2024-01-20', 'Alinhamento e balanceamento', 'concluida', 'media', 300.00, 1, 1),
('OS-2024-022', 'veiculo', 1, '2024-02-10', '2024-02-11', '2024-02-11', 'Reparo no sistema de freios', 'concluida', 'alta', 1200.00, 1, 1),
('OS-2024-023', 'veiculo', 1, '2024-02-25', '2024-02-25', '2024-02-25', 'Manutenção preventiva', 'concluida', 'media', 800.00, 1, 1),
('OS-2024-024', 'veiculo', 1, '2024-03-12', '2024-03-14', NULL, 'Reparo no sistema de ar condicionado', 'em_andamento', 'baixa', 600.00, 1, 1),

-- Veículo 2 (4 ordens)
('OS-2024-025', 'veiculo', 2, '2024-01-15', '2024-01-15', '2024-01-15', 'Troca de pneus', 'concluida', 'media', 2000.00, 1, 1),
('OS-2024-026', 'veiculo', 2, '2024-02-05', '2024-02-06', '2024-02-06', 'Manutenção do motor', 'concluida', 'alta', 2500.00, 1, 1),
('OS-2024-027', 'veiculo', 2, '2024-02-20', '2024-02-21', '2024-02-21', 'Reparo no sistema elétrico', 'concluida', 'alta', 1500.00, 1, 1),
('OS-2024-028', 'veiculo', 2, '2024-03-08', '2024-03-10', NULL, 'Manutenção preventiva', 'aberta', 'media', 900.00, 1, 1);

-- Inserir itens para algumas ordens de serviço
INSERT INTO itens_ordem_servico (ordem_servico_id, descricao, quantidade, unidade, valor_unitario)
VALUES 
-- Itens para a primeira ordem de serviço da embarcação 1
(1, 'Kit de manutenção do motor', 1, 'unidade', 1500.00),
(1, 'Óleo lubrificante', 5, 'litros', 50.00),
(1, 'Mão de obra especializada', 8, 'horas', 100.00),

-- Itens para a primeira ordem de serviço da embarcação 2
(4, 'Tinta para casco', 10, 'litros', 80.00),
(4, 'Selante', 3, 'unidades', 45.00),
(4, 'Mão de obra especializada', 16, 'horas', 100.00),

-- Itens para a primeira ordem de serviço do implemento 1
(7, 'Kit de reparo hidráulico', 1, 'unidade', 1200.00),
(7, 'Óleo hidráulico', 4, 'litros', 60.00),
(7, 'Mão de obra especializada', 6, 'horas', 100.00),

-- Itens para a primeira ordem de serviço do tanque 1
(11, 'Kit de válvulas', 1, 'unidade', 800.00),
(11, 'Juntas e vedantes', 5, 'unidades', 30.00),
(11, 'Mão de obra especializada', 7, 'horas', 100.00),

-- Itens para a primeira ordem de serviço do veículo 1
(16, 'Kit de óleo e filtros', 1, 'unidade', 200.00),
(16, 'Óleo lubrificante', 1, 'litro', 50.00),
(16, 'Mão de obra', 3, 'horas', 50.00); 