-- Procedure para calcular e alimentar indicadores MTTR e MTBF diariamente
-- Executa cálculos baseados nas ordens de serviço concluídas
-- VERSÃO CORRIGIDA: MTBF considera apenas OS corretivas (falhas)

DELIMITER $$

DROP PROCEDURE IF EXISTS CalcularIndicadoresDiarios$$

CREATE PROCEDURE CalcularIndicadoresDiarios()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_tipo_equipamento VARCHAR(20);
    DECLARE v_equipamento_id INT;
    DECLARE v_mttr FLOAT;
    DECLARE v_mtbf FLOAT;
    DECLARE v_num_os INT;
    DECLARE v_data_registro DATETIME DEFAULT NOW();
    
    -- Cursor para iterar sobre os tipos de equipamento
    DECLARE tipo_cursor CURSOR FOR 
        SELECT DISTINCT tipo_equipamento FROM ordens_servico 
        WHERE status = 'concluida' AND data_conclusao IS NOT NULL;
    
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
    
    -- Abrir cursor
    OPEN tipo_cursor;
    
    tipo_loop: LOOP
        FETCH tipo_cursor INTO v_tipo_equipamento;
        IF done THEN
            LEAVE tipo_loop;
        END IF;
        
        -- Calcular MTTR e MTBF para cada equipamento do tipo atual
        -- MTTR = Tempo médio de reparo (diferença entre abertura e conclusão)
        -- MTBF = Tempo médio entre falhas (tempo entre conclusão de uma OS corretiva e abertura da próxima OS corretiva)
        
        -- Para cada equipamento do tipo atual
        INSERT INTO mttr_embarcacao (id_ativo, mttr, num_os, data_registro)
        SELECT 
            equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, data_abertura, data_conclusao)) as mttr,
            COUNT(*) as num_os,
            v_data_registro
        FROM ordens_servico 
        WHERE tipo_equipamento = 'embarcacao' 
            AND status = 'concluida' 
            AND data_conclusao IS NOT NULL
            AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)  -- Filtro de período razoável
        GROUP BY equipamento_id
        ON DUPLICATE KEY UPDATE 
            mttr = VALUES(mttr),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
            
        INSERT INTO mttr_implemento (id_ativo, mttr, num_os, data_registro)
        SELECT 
            equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, data_abertura, data_conclusao)) as mttr,
            COUNT(*) as num_os,
            v_data_registro
        FROM ordens_servico 
        WHERE tipo_equipamento = 'implemento' 
            AND status = 'concluida' 
            AND data_conclusao IS NOT NULL
            AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY equipamento_id
        ON DUPLICATE KEY UPDATE 
            mttr = VALUES(mttr),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
            
        INSERT INTO mttr_tanque (id_ativo, mttr, num_os, data_registro)
        SELECT 
            equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, data_abertura, data_conclusao)) as mttr,
            COUNT(*) as num_os,
            v_data_registro
        FROM ordens_servico 
        WHERE tipo_equipamento = 'tanque' 
            AND status = 'concluida' 
            AND data_conclusao IS NOT NULL
            AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY equipamento_id
        ON DUPLICATE KEY UPDATE 
            mttr = VALUES(mttr),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
            
        INSERT INTO mttr_veiculo (id_ativo, mttr, num_os, data_registro)
        SELECT 
            equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, data_abertura, data_conclusao)) as mttr,
            COUNT(*) as num_os,
            v_data_registro
        FROM ordens_servico 
        WHERE tipo_equipamento = 'veiculo' 
            AND status = 'concluida' 
            AND data_conclusao IS NOT NULL
            AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY equipamento_id
        ON DUPLICATE KEY UPDATE 
            mttr = VALUES(mttr),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
        
        -- Calcular MTBF (Tempo médio entre falhas)
        -- CORREÇÃO: MTBF considera apenas OS corretivas (falhas)
        -- Usar LAG para pegar apenas a próxima OS corretiva após cada conclusão
        
        INSERT INTO mtbf_embarcacao (id_ativo, mtbf, num_os, data_registro)
        SELECT 
            equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, data_conclusao_anterior, data_abertura)) as mtbf,
            COUNT(*) as num_os,
            v_data_registro
        FROM (
            SELECT equipamento_id, data_abertura,
                   LAG(data_conclusao) OVER (PARTITION BY equipamento_id ORDER BY data_abertura) as data_conclusao_anterior
            FROM ordens_servico 
            WHERE tipo_equipamento = 'embarcacao'
                AND tipo_manutencao = 'corretiva'  -- APENAS OS corretivas
                AND status = 'concluida'
                AND data_conclusao IS NOT NULL
                AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)  -- Filtro de período razoável
        ) t
        WHERE data_conclusao_anterior IS NOT NULL
        GROUP BY equipamento_id
        ON DUPLICATE KEY UPDATE 
            mtbf = VALUES(mtbf),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
            
        INSERT INTO mtbf_implemento (id_ativo, mtbf, num_os, data_registro)
        SELECT 
            equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, data_conclusao_anterior, data_abertura)) as mtbf,
            COUNT(*) as num_os,
            v_data_registro
        FROM (
            SELECT equipamento_id, data_abertura,
                   LAG(data_conclusao) OVER (PARTITION BY equipamento_id ORDER BY data_abertura) as data_conclusao_anterior
            FROM ordens_servico 
            WHERE tipo_equipamento = 'implemento'
                AND tipo_manutencao = 'corretiva'  -- APENAS OS corretivas
                AND status = 'concluida'
                AND data_conclusao IS NOT NULL
                AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        ) t
        WHERE data_conclusao_anterior IS NOT NULL
        GROUP BY equipamento_id
        ON DUPLICATE KEY UPDATE 
            mtbf = VALUES(mtbf),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
            
        INSERT INTO mtbf_tanque (id_ativo, mtbf, num_os, data_registro)
        SELECT 
            equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, data_conclusao_anterior, data_abertura)) as mtbf,
            COUNT(*) as num_os,
            v_data_registro
        FROM (
            SELECT equipamento_id, data_abertura,
                   LAG(data_conclusao) OVER (PARTITION BY equipamento_id ORDER BY data_abertura) as data_conclusao_anterior
            FROM ordens_servico 
            WHERE tipo_equipamento = 'tanque'
                AND tipo_manutencao = 'corretiva'  -- APENAS OS corretivas
                AND status = 'concluida'
                AND data_conclusao IS NOT NULL
                AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        ) t
        WHERE data_conclusao_anterior IS NOT NULL
        GROUP BY equipamento_id
        ON DUPLICATE KEY UPDATE 
            mtbf = VALUES(mtbf),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
            
        INSERT INTO mtbf_veiculo (id_ativo, mtbf, num_os, data_registro)
        SELECT 
            equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, data_conclusao_anterior, data_abertura)) as mtbf,
            COUNT(*) as num_os,
            v_data_registro
        FROM (
            SELECT equipamento_id, data_abertura,
                   LAG(data_conclusao) OVER (PARTITION BY equipamento_id ORDER BY data_abertura) as data_conclusao_anterior
            FROM ordens_servico 
            WHERE tipo_equipamento = 'veiculo'
                AND tipo_manutencao = 'corretiva'  -- APENAS OS corretivas
                AND status = 'concluida'
                AND data_conclusao IS NOT NULL
                AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        ) t
        WHERE data_conclusao_anterior IS NOT NULL
        GROUP BY equipamento_id
        ON DUPLICATE KEY UPDATE 
            mtbf = VALUES(mtbf),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
        
    END LOOP;
    
    CLOSE tipo_cursor;
    
END$$

DELIMITER ;

-- Criar evento para executar a procedure diariamente às 02:00
DROP EVENT IF EXISTS CalcularIndicadoresDiario;

CREATE EVENT CalcularIndicadoresDiario
ON SCHEDULE EVERY 1 DAY
STARTS '2025-01-01 02:00:00'
DO
  CALL CalcularIndicadoresDiarios();
