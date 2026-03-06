-- Ajusta tabela do almoxarifado para o novo formato
ALTER TABLE almoxarifado_itens
ADD COLUMN codigo_barras VARCHAR(100) NOT NULL FIRST,
CHANGE COLUMN descricao nome VARCHAR(255) NOT NULL,
CHANGE COLUMN estoque_atual quantidade DECIMAL(10,2) NOT NULL DEFAULT 0,
DROP COLUMN estoque_minimo,
DROP COLUMN unidade,
DROP COLUMN ativo;

-- Remove duplicidade de índice se existir
DROP INDEX codigo_barras ON almoxarifado_itens;
CREATE UNIQUE INDEX codigo_barras ON almoxarifado_itens (codigo_barras);

-- Ajusta itens da OS
ALTER TABLE itens_ordem_servico
ADD COLUMN almoxarifado_item_id INT NULL AFTER ordem_servico_id,
DROP COLUMN unidade;

CREATE INDEX idx_itens_os_almox ON itens_ordem_servico (almoxarifado_item_id);
