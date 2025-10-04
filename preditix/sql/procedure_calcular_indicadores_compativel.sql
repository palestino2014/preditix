-- Procedure para calcular e alimentar indicadores MTTR e MTBF diariamente
-- VERSÃO COMPATÍVEL COM MYSQL ANTIGO (sem LAG/OVER)
-- Executa cálculos baseados nas ordens de serviço concluídas

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
        
        -- Calcular MTTR para cada equipamento do tipo atual
        -- MTTR = Tempo médio de reparo (diferença entre abertura e conclusão)
        
        -- MTTR Embarcações
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
            AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY equipamento_id
        ON DUPLICATE KEY UPDATE 
            mttr = VALUES(mttr),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
            
        -- MTTR Implementos
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
            
        -- MTTR Tanques
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
            
        -- MTTR Veículos
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
        -- VERSÃO COMPATÍVEL: Usa JOIN com condições mais específicas
        
        -- MTBF Embarcações
        INSERT INTO mtbf_embarcacao (id_ativo, mtbf, num_os, data_registro)
        SELECT 
            t1.equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, t1.data_conclusao, t2.data_abertura)) as mtbf,
            COUNT(*) as num_os,
            v_data_registro
        FROM ordens_servico t1
        JOIN ordens_servico t2 ON t1.equipamento_id = t2.equipamento_id 
            AND t1.tipo_equipamento = t2.tipo_equipamento
            AND t2.data_abertura > t1.data_conclusao
            AND t2.data_abertura = (
                SELECT MIN(t3.data_abertura)
                FROM ordens_servico t3
                WHERE t3.equipamento_id = t1.equipamento_id
                    AND t3.tipo_equipamento = t1.tipo_equipamento
                    AND t3.tipo_manutencao = 'corretiva'
                    AND t3.status = 'concluida'
                    AND t3.data_abertura > t1.data_conclusao
            )
        WHERE t1.tipo_equipamento = 'embarcacao'
            AND t1.tipo_manutencao = 'corretiva'
            AND t1.status = 'concluida' 
            AND t1.data_conclusao IS NOT NULL
            AND t2.tipo_manutencao = 'corretiva'
            AND t2.status = 'concluida'
            AND t1.data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY t1.equipamento_id
        ON DUPLICATE KEY UPDATE 
            mtbf = VALUES(mtbf),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
            
        -- MTBF Implementos
        INSERT INTO mtbf_implemento (id_ativo, mtbf, num_os, data_registro)
        SELECT 
            t1.equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, t1.data_conclusao, t2.data_abertura)) as mtbf,
            COUNT(*) as num_os,
            v_data_registro
        FROM ordens_servico t1
        JOIN ordens_servico t2 ON t1.equipamento_id = t2.equipamento_id 
            AND t1.tipo_equipamento = t2.tipo_equipamento
            AND t2.data_abertura > t1.data_conclusao
            AND t2.data_abertura = (
                SELECT MIN(t3.data_abertura)
                FROM ordens_servico t3
                WHERE t3.equipamento_id = t1.equipamento_id
                    AND t3.tipo_equipamento = t1.tipo_equipamento
                    AND t3.tipo_manutencao = 'corretiva'
                    AND t3.status = 'concluida'
                    AND t3.data_abertura > t1.data_conclusao
            )
        WHERE t1.tipo_equipamento = 'implemento'
            AND t1.tipo_manutencao = 'corretiva'
            AND t1.status = 'concluida' 
            AND t1.data_conclusao IS NOT NULL
            AND t2.tipo_manutencao = 'corretiva'
            AND t2.status = 'concluida'
            AND t1.data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY t1.equipamento_id
        ON DUPLICATE KEY UPDATE 
            mtbf = VALUES(mtbf),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
            
        -- MTBF Tanques
        INSERT INTO mtbf_tanque (id_ativo, mtbf, num_os, data_registro)
        SELECT 
            t1.equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, t1.data_conclusao, t2.data_abertura)) as mtbf,
            COUNT(*) as num_os,
            v_data_registro
        FROM ordens_servico t1
        JOIN ordens_servico t2 ON t1.equipamento_id = t2.equipamento_id 
            AND t1.tipo_equipamento = t2.tipo_equipamento
            AND t2.data_abertura > t1.data_conclusao
            AND t2.data_abertura = (
                SELECT MIN(t3.data_abertura)
                FROM ordens_servico t3
                WHERE t3.equipamento_id = t1.equipamento_id
                    AND t3.tipo_equipamento = t1.tipo_equipamento
                    AND t3.tipo_manutencao = 'corretiva'
                    AND t3.status = 'concluida'
                    AND t3.data_abertura > t1.data_conclusao
            )
        WHERE t1.tipo_equipamento = 'tanque'
            AND t1.tipo_manutencao = 'corretiva'
            AND t1.status = 'concluida' 
            AND t1.data_conclusao IS NOT NULL
            AND t2.tipo_manutencao = 'corretiva'
            AND t2.status = 'concluida'
            AND t1.data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY t1.equipamento_id
        ON DUPLICATE KEY UPDATE 
            mtbf = VALUES(mtbf),
            num_os = VALUES(num_os),
            data_registro = VALUES(data_registro);
            
        -- MTBF Veículos
        INSERT INTO mtbf_veiculo (id_ativo, mtbf, num_os, data_registro)
        SELECT 
            t1.equipamento_id,
            AVG(TIMESTAMPDIFF(HOUR, t1.data_conclusao, t2.data_abertura)) as mtbf,
            COUNT(*) as num_os,
            v_data_registro
        FROM ordens_servico t1
        JOIN ordens_servico t2 ON t1.equipamento_id = t2.equipamento_id 
            AND t1.tipo_equipamento = t2.tipo_equipamento
            AND t2.data_abertura > t1.data_conclusao
            AND t2.data_abertura = (
                SELECT MIN(t3.data_abertura)
                FROM ordens_servico t3
                WHERE t3.equipamento_id = t1.equipamento_id
                    AND t3.tipo_equipamento = t1.tipo_equipamento
                    AND t3.tipo_manutencao = 'corretiva'
                    AND t3.status = 'concluida'
                    AND t3.data_abertura > t1.data_conclusao
            )
        WHERE t1.tipo_equipamento = 'veiculo'
            AND t1.tipo_manutencao = 'corretiva'
            AND t1.status = 'concluida' 
            AND t1.data_conclusao IS NOT NULL
            AND t2.tipo_manutencao = 'corretiva'
            AND t2.status = 'concluida'
            AND t1.data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
        GROUP BY t1.equipamento_id
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
