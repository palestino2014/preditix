-- Tabela para biblioteca de gráficos pré-definidos
CREATE TABLE IF NOT EXISTS biblioteca_graficos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    categoria VARCHAR(50) NOT NULL,
    tipo_grafico ENUM('linha', 'barras', 'pizza', 'indicador', 'tabela', 'gauge') NOT NULL,
    configuracao JSON NOT NULL,
    icone VARCHAR(50) DEFAULT 'bi-graph-up',
    cor_primaria VARCHAR(7) DEFAULT '#0d6efd',
    ativo BOOLEAN DEFAULT TRUE,
    ordem_exibicao INT DEFAULT 0,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Limpar dados existentes
DELETE FROM biblioteca_graficos;

-- Inserir gráficos da biblioteca atualizados
INSERT INTO biblioteca_graficos (nome, descricao, categoria, tipo_grafico, configuracao, icone, cor_primaria, ordem_exibicao) VALUES
-- Gráficos de Tendência Temporal
('Evolução do MTTR', 'Tempo médio de reparo ao longo dos meses', 'tendencias', 'linha', '{"metrica": "mttr_temporal", "periodo": "12m", "titulo": "Evolução do MTTR", "subtitulo": "Tempo Médio de Reparo (dias)"}', 'bi-graph-up', '#dc3545', 1),
('Evolução do MTBF', 'Tempo médio entre falhas ao longo dos meses', 'tendencias', 'linha', '{"metrica": "mtbf_temporal", "periodo": "12m", "titulo": "Evolução do MTBF", "subtitulo": "Tempo Entre Falhas (dias)"}', 'bi-graph-up', '#198754', 2),
('Custos de Manutenção', 'Evolução dos custos ao longo do tempo', 'financeiro', 'linha', '{"metrica": "custos_temporal", "periodo": "12m", "titulo": "Custos de Manutenção", "subtitulo": "Valor Total (R$)"}', 'bi-currency-dollar', '#fd7e14', 3),

-- Gráficos de Comparação
('MTTR por Tipo de Equipamento', 'Comparação do tempo de reparo entre tipos', 'analise', 'barras', '{"metrica": "mttr_por_tipo", "titulo": "MTTR por Tipo", "subtitulo": "Tempo Médio de Reparo (dias)"}', 'bi-bar-chart', '#20c997', 4),
('Custos por Categoria', 'Distribuição dos custos por categoria', 'financeiro', 'pizza', '{"metrica": "custos_por_categoria", "titulo": "Custos por Categoria", "subtitulo": "Distribuição Percentual"}', 'bi-pie-chart', '#6f42c1', 5),
('Ordens por Status', 'Distribuição das ordens de serviço', 'operacional', 'pizza', '{"metrica": "ordens_por_status", "titulo": "Ordens por Status", "subtitulo": "Distribuição Atual"}', 'bi-pie-chart-fill', '#6610f2', 6),

-- Indicadores Principais
('Disponibilidade Atual', 'Percentual de ativos operacionais', 'indicadores', 'gauge', '{"metrica": "disponibilidade", "titulo": "Disponibilidade", "subtitulo": "Ativos Operacionais"}', 'bi-speedometer2', '#0d6efd', 7),
('Custo Médio por Ordem', 'Valor médio gasto por ordem de serviço', 'indicadores', 'indicador', '{"metrica": "custo_medio_ordem", "formato": "moeda", "titulo": "Custo Médio", "subtitulo": "Por Ordem de Serviço"}', 'bi-calculator', '#e83e8c', 8),

-- Tabelas Informativas
('Top 5 Ativos Mais Custosos', 'Ranking dos ativos com maior custo', 'ranking', 'tabela', '{"metrica": "top_custosos", "limite": 5, "titulo": "Ativos Mais Custosos", "subtitulo": "Top 5"}', 'bi-list-ol', '#ffc107', 9),
('Ordens em Atraso', 'Lista de ordens que estão atrasadas', 'alertas', 'tabela', '{"metrica": "ordens_atraso", "titulo": "Ordens em Atraso", "subtitulo": "Requerem Atenção"}', 'bi-exclamation-triangle', '#dc3545', 10);

-- Tabela para gráficos favoritos do usuário
CREATE TABLE IF NOT EXISTS graficos_favoritos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    grafico_id INT NOT NULL,
    posicao_x INT DEFAULT 0,
    posicao_y INT DEFAULT 0,
    largura INT DEFAULT 1,
    altura INT DEFAULT 1,
    filtros JSON,
    ativo BOOLEAN DEFAULT TRUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (grafico_id) REFERENCES biblioteca_graficos(id) ON DELETE CASCADE,
    UNIQUE KEY unique_usuario_grafico (usuario_id, grafico_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci; 