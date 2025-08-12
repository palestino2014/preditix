# Solução para Funções "Tentar Novamente" e "Rejeitar" Não Funcionando

## Problema Identificado
As funções "tentar novamente" e "rejeitar" não estavam funcionando devido a uma limitação na estrutura da tabela `os_historico` no banco de dados.

## Causa Raiz
A tabela `os_historico` tinha um ENUM limitado para o campo `acao` que não incluía as ações:
- `tentar_novamente`
- `desistencia`

## Solução Implementada

### 1. Atualização do Schema
O arquivo `database/schema.sql` foi atualizado para incluir as novas ações no ENUM.

### 2. Script de Atualização
Foi criado o arquivo `database/update_historico.sql` com o comando SQL necessário para atualizar a tabela existente.

### 3. Nova Funcionalidade de Backup e Restauração
Foi implementado um sistema de backup automático que:
- **Faz backup** dos dados originais antes de qualquer edição por técnico
- **Restaura os dados originais** quando uma edição é rejeitada
- **Volta a OS para "em_andamento"** com aprovação automática

## Como Resolver

### Passo 1: Atualizar a tabela os_historico
Execute o seguinte comando no seu banco de dados MySQL:

```sql
ALTER TABLE os_historico 
MODIFY COLUMN acao ENUM('abertura', 'edicao', 'conclusao', 'cancelamento', 'aprovacao', 'rejeicao', 'tentar_novamente', 'desistencia') NOT NULL;
```

### Passo 2: Criar a tabela de backup
Execute o arquivo `database/create_backup_table.sql` ou execute:

```sql
CREATE TABLE os_backup (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_os INT NOT NULL,
    tipo_manutencao ENUM('preventiva', 'corretiva', 'preditiva') NOT NULL,
    prioridade ENUM('baixa', 'media', 'alta', 'critica') NOT NULL,
    sistemas_afetados JSON,
    sintomas_detectados JSON,
    causas_defeitos JSON,
    intervencoes_realizadas JSON,
    acoes_realizadas JSON,
    observacoes TEXT,
    data_backup TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (id_os) REFERENCES ordem_servico(id_os) ON DELETE CASCADE,
    INDEX idx_os (id_os),
    INDEX idx_data_backup (data_backup)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

## Verificação
Após a atualização, verifique se as alterações foram aplicadas:

```sql
DESCRIBE os_historico;
SHOW TABLES LIKE 'os_backup';
```

## Funcionalidades Agora Disponíveis

### 1. Tentar Novamente
- **Função**: Reabrir uma OS rejeitada
- **Status**: Volta para "em_andamento" com **aprovação automática**
- **Dados**: Restaura os valores originais (antes da edição)
- **Ação**: Registra `tentar_novamente` no histórico

### 2. Rejeitar Edição
- **Função**: Rejeitar uma edição de técnico
- **Status**: Volta para "em_andamento" com **aprovação automática**
- **Dados**: Restaura os valores originais (antes da edição)
- **Ação**: Registra `rejeicao` no histórico

### 3. Desistir
- **Função**: Marcar uma OS rejeitada como desistida
- **Status**: Mantém como "rejeitada"
- **Ação**: Registra `desistencia` no histórico

## Fluxo de Trabalho Implementado

1. **Técnico edita OS em andamento**
   - Sistema faz backup automático dos dados originais
   - OS vai para status "editada" (aguardando aprovação)

2. **Gestor rejeita a edição**
   - Sistema restaura os dados originais
   - OS volta para "em_andamento" com aprovação automática
   - Técnico pode continuar trabalhando normalmente

3. **Técnico tenta novamente**
   - Sistema restaura os dados originais
   - OS volta para "em_andamento" com aprovação automática
   - Técnico pode fazer nova edição se necessário

## Arquivos Modificados
- `database/schema.sql` - Schema atualizado
- `database/update_historico.sql` - Script de atualização
- `database/create_backup_table.sql` - Script para tabela de backup
- `controllers/OSController.php` - Métodos implementados com backup/restauração
- `views/os/view.php` - Funções JavaScript implementadas
- `config/routes.php` - Rotas adicionadas
- `lang/pt-br.php` - Traduções adicionadas

## Teste
Após aplicar as correções:
1. Acesse uma OS com status "em_andamento"
2. Edite a OS como técnico (deve ir para "editada")
3. Rejeite a edição como gestor (deve voltar para "em_andamento" com dados originais)
4. Teste "Tentar Novamente" (deve voltar para "em_andamento" com dados originais)
5. Verifique se as ações são registradas no histórico
6. Confirme se o status da OS é atualizado corretamente
