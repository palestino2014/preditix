-- Tabela para armazenar widgets customizáveis do dashboard
CREATE TABLE IF NOT EXISTS widgets_dashboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    tipo_widget VARCHAR(50) NOT NULL,
    configuracao JSON,
    posicao_x INT DEFAULT 0,
    posicao_y INT DEFAULT 0,
    largura INT DEFAULT 1,
    altura INT DEFAULT 1,
    ativo TINYINT(1) DEFAULT 1,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    INDEX idx_usuario (usuario_id),
    INDEX idx_tipo (tipo_widget),
    INDEX idx_ativo (ativo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela para templates de dashboard pré-definidos
CREATE TABLE IF NOT EXISTS templates_dashboard (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    categoria ENUM('executivo', 'operacional', 'financeiro', 'manutencao') NOT NULL,
    widgets JSON NOT NULL,
    ativo TINYINT(1) DEFAULT 1,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserir templates padrão
INSERT INTO templates_dashboard (nome, descricao, categoria, widgets) VALUES 
('Dashboard Executivo', 'Visão geral dos principais KPIs para gestão', 'executivo', 
'[
    {"tipo": "indicador_numerico", "titulo": "MTTR", "metrica": "mttr", "posicao_x": 0, "posicao_y": 0, "largura": 1, "altura": 1},
    {"tipo": "indicador_numerico", "titulo": "MTBF", "metrica": "mtbf", "posicao_x": 1, "posicao_y": 0, "largura": 1, "altura": 1},
    {"tipo": "indicador_numerico", "titulo": "Disponibilidade", "metrica": "disponibilidade", "posicao_x": 2, "posicao_y": 0, "largura": 1, "altura": 1},
    {"tipo": "indicador_numerico", "titulo": "Custos Totais", "metrica": "custos", "posicao_x": 3, "posicao_y": 0, "largura": 1, "altura": 1},
    {"tipo": "grafico_pizza", "titulo": "Distribuição de Ativos", "metrica": "distribuicao_ativos", "posicao_x": 0, "posicao_y": 1, "largura": 2, "altura": 2},
    {"tipo": "grafico_barras", "titulo": "Ordens por Status", "metrica": "ordens_por_status", "posicao_x": 2, "posicao_y": 1, "largura": 2, "altura": 2},
    {"tipo": "tabela", "titulo": "Top 5 Ativos Mais Custosos", "metrica": "top_ativos_custosos", "posicao_x": 0, "posicao_y": 3, "largura": 4, "altura": 2}
]'),

('Dashboard Operacional', 'Foco em operações e manutenções em andamento', 'operacional',
'[
    {"tipo": "alertas", "titulo": "Alertas", "posicao_x": 0, "posicao_y": 0, "largura": 1, "altura": 2},
    {"tipo": "grafico_linha", "titulo": "MTTR - Tendência", "metrica": "mttr", "posicao_x": 1, "posicao_y": 0, "largura": 3, "altura": 2},
    {"tipo": "tabela", "titulo": "Ordens Recentes", "metrica": "ordens_recentes", "posicao_x": 0, "posicao_y": 2, "largura": 4, "altura": 2},
    {"tipo": "gauge", "titulo": "Disponibilidade", "metrica": "disponibilidade", "posicao_x": 0, "posicao_y": 4, "largura": 2, "altura": 2},
    {"tipo": "gauge", "titulo": "Taxa de Atraso", "metrica": "taxa_atraso", "posicao_x": 2, "posicao_y": 4, "largura": 2, "altura": 2}
]'),

('Dashboard Financeiro', 'Foco em custos e eficiência financeira', 'financeiro',
'[
    {"tipo": "indicador_numerico", "titulo": "Custos Totais", "metrica": "custos", "posicao_x": 0, "posicao_y": 0, "largura": 1, "altura": 1},
    {"tipo": "indicador_numerico", "titulo": "Eficiência Planejamento", "metrica": "eficiencia_planejamento", "posicao_x": 1, "posicao_y": 0, "largura": 1, "altura": 1},
    {"tipo": "grafico_linha", "titulo": "Custos - Tendência", "metrica": "custos", "posicao_x": 0, "posicao_y": 1, "largura": 4, "altura": 2},
    {"tipo": "grafico_barras", "titulo": "Custos por Tipo de Ativo", "metrica": "custos_por_tipo", "posicao_x": 0, "posicao_y": 3, "largura": 2, "altura": 2},
    {"tipo": "tabela", "titulo": "Top 5 Ativos Mais Custosos", "metrica": "top_ativos_custosos", "posicao_x": 2, "posicao_y": 3, "largura": 2, "altura": 2}
]'),

('Dashboard Manutenção', 'Foco em detalhes técnicos de manutenção', 'manutencao',
'[
    {"tipo": "indicador_numerico", "titulo": "MTTR", "metrica": "mttr", "posicao_x": 0, "posicao_y": 0, "largura": 1, "altura": 1},
    {"tipo": "indicador_numerico", "titulo": "MTBF", "metrica": "mtbf", "posicao_x": 1, "posicao_y": 0, "largura": 1, "altura": 1},
    {"tipo": "indicador_numerico", "titulo": "Taxa de Atraso", "metrica": "taxa_atraso", "posicao_x": 2, "posicao_y": 0, "largura": 1, "altura": 1},
    {"tipo": "grafico_barras", "titulo": "MTTR por Categoria", "metrica": "mttr_por_categoria", "posicao_x": 0, "posicao_y": 1, "largura": 2, "altura": 2},
    {"tipo": "grafico_pizza", "titulo": "Ordens por Status", "metrica": "ordens_por_status", "posicao_x": 2, "posicao_y": 1, "largura": 2, "altura": 2},
    {"tipo": "tabela", "titulo": "Performance por Responsável", "metrica": "performance_usuarios", "posicao_x": 0, "posicao_y": 3, "largura": 4, "altura": 2}
]'); 