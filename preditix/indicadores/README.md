# Sistema de Indicadores Customizáveis - Preditix

## 📊 Visão Geral

O sistema de indicadores customizáveis permite que os usuários criem dashboards personalizados com widgets interativos baseados nos dados de manutenção do sistema Preditix.

## 🏗️ Estrutura do Projeto

```
indicadores/
├── classes/
│   ├── Indicadores.php      # Classe principal para cálculos de KPIs
│   └── Widget.php           # Classe para gerenciar widgets
├── api/
│   ├── widget_data.php      # API para carregar dados dos widgets
│   ├── salvar_widget.php    # API para salvar widgets
│   └── aplicar_template.php # API para aplicar templates
├── sql/
│   └── widgets_dashboard.sql # Estrutura do banco de dados
├── dashboard.php            # Página principal do dashboard
└── README.md               # Esta documentação
```

## 🎯 KPIs Implementados

### 1. MTTR (Mean Time To Repair)
- **Descrição**: Tempo médio de reparo
- **Cálculo**: Soma dos tempos de reparo ÷ Número de reparos
- **Filtros**: Tipo de equipamento, período, status

### 2. MTBF (Mean Time Between Failures)
- **Descrição**: Tempo médio entre falhas
- **Cálculo**: Soma dos intervalos entre falhas ÷ Número de intervalos
- **Filtros**: Tipo de equipamento, período

### 3. Disponibilidade
- **Descrição**: Percentual de ativos operacionais
- **Cálculo**: (Ativos operacionais ÷ Total de ativos) × 100
- **Filtros**: Tipo de equipamento

### 4. Custos
- **Descrição**: Custos totais de manutenção
- **Cálculo**: Soma dos custos finais das ordens
- **Filtros**: Tipo de equipamento, período, status

### 5. Taxa de Atraso
- **Descrição**: Percentual de ordens atrasadas
- **Cálculo**: (Ordens atrasadas ÷ Total de ordens) × 100
- **Filtros**: Tipo de equipamento, período

### 6. Eficiência de Planejamento
- **Descrição**: Precisão dos orçamentos
- **Cálculo**: (Custo estimado - Custo final) ÷ Custo estimado
- **Filtros**: Tipo de equipamento, período

## 🎨 Tipos de Widgets

### 1. Indicador Numérico
- Mostra um valor numérico com título e ícone
- Configurável: métrica, título, cor, formato

### 2. Gráfico de Linha
- Gráfico de linha para mostrar tendências
- Configurável: métrica, período, agrupamento, cor

### 3. Gráfico de Barras
- Gráfico de barras para comparações
- Configurável: métrica, agrupamento, limite, cores

### 4. Gráfico de Pizza
- Gráfico de pizza para distribuições
- Configurável: métrica, agrupamento, mostrar percentual

### 5. Tabela
- Tabela com dados detalhados
- Configurável: métrica, colunas, limite, ordenação

### 6. Medidor (Gauge)
- Medidor circular para valores percentuais
- Configurável: métrica, limites, cores

### 7. Alertas
- Lista de alertas e notificações
- Configurável: tipos de alerta, limite, auto-atualização

## 📋 Templates Disponíveis

### 1. Dashboard Executivo
- Visão geral dos principais KPIs para gestão
- Widgets: MTTR, MTBF, Disponibilidade, Custos, Distribuição de Ativos

### 2. Dashboard Operacional
- Foco em operações e manutenções em andamento
- Widgets: Alertas, MTTR - Tendência, Ordens Recentes, Gauge de Disponibilidade

### 3. Dashboard Financeiro
- Foco em custos e eficiência financeira
- Widgets: Custos Totais, Eficiência Planejamento, Tendência de Custos

### 4. Dashboard Manutenção
- Foco em detalhes técnicos de manutenção
- Widgets: MTTR, MTBF, Taxa de Atraso, Performance por Responsável

## 🚀 Como Usar

### 1. Acessar o Dashboard
- Navegue para `/indicadores/dashboard.php`
- Ou clique em "Dashboard" no menu principal

### 2. Aplicar um Template
- Clique em "Templates" na barra superior
- Escolha um template (Executivo, Operacional, Financeiro, Manutenção)
- Confirme a aplicação

### 3. Adicionar Widgets Personalizados
- Clique em "Adicionar Widget"
- Escolha o tipo de widget
- Configure as opções
- Salve o widget

### 4. Personalizar Layout
- Arraste e solte widgets para reorganizar
- Use os controles de cada widget para configurar ou remover
- Salve as alterações

## 🔧 Configuração do Banco de Dados

Execute o arquivo SQL para criar as tabelas necessárias:

```sql
-- Execute o arquivo indicadores/sql/widgets_dashboard.sql
```

## 📈 Funcionalidades Avançadas

### Filtros Dinâmicos
- Por tipo de equipamento (Embarcação, Implemento, Tanque, Veículo)
- Por período (Últimos 7 dias, 30 dias, 90 dias, 1 ano)
- Por status de ordem (Aberta, Em Andamento, Concluída, Cancelada)
- Por prioridade (Baixa, Média, Alta, Urgente)

### Atualização Automática
- Widgets podem ser configurados para atualização automática
- Intervalos: 5 minutos, 1 hora, manual

### Responsividade
- Layout adaptável para diferentes tamanhos de tela
- Widgets redimensionáveis
- Grid system flexível

## 🎨 Personalização Visual

### Temas
- Interface moderna com gradientes
- Efeitos de glassmorphism
- Animações suaves
- Ícones Bootstrap

### Cores
- Paleta de cores consistente
- Indicadores visuais por prioridade
- Cores configuráveis por widget

## 🔒 Segurança

- Autenticação obrigatória
- Validação de permissões por usuário
- Sanitização de dados
- Proteção contra SQL injection

## 📱 Compatibilidade

- Navegadores modernos (Chrome, Firefox, Safari, Edge)
- Responsivo para desktop, tablet e mobile
- Suporte a touch para dispositivos móveis

## 🚀 Próximas Funcionalidades

- [ ] Exportação de dashboards em PDF
- [ ] Compartilhamento de dashboards
- [ ] Alertas por email
- [ ] Integração com outros sistemas
- [ ] Mais tipos de gráficos
- [ ] Drill-down em widgets
- [ ] Modo escuro
- [ ] Análise preditiva

## 🐛 Suporte

Para reportar bugs ou solicitar funcionalidades, entre em contato com a equipe de desenvolvimento. 