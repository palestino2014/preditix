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
        
        -- Calcular MTBF (Tractian):
        -- MTBF = (horas_disponiveis - horas_corretiva_unidas) / numero_paradas_corretivas
        -- onde horas_disponiveis = janela entre primeiro início e último término dentro do período

        -- Para compatibilidade com MySQL antigo, faremos via cursores por tipo e por equipamento

        -- MTBF Embarcações
        BEGIN
            DECLARE done_eq INT DEFAULT FALSE;
            DECLARE done_iv INT DEFAULT FALSE;
            DECLARE cur_eq_id INT;
            DECLARE iv_start DATETIME;
            DECLARE iv_end DATETIME;
            DECLARE prev_start DATETIME;
            DECLARE prev_end DATETIME;
            DECLARE total_downtime_seconds BIGINT DEFAULT 0;
            DECLARE janela_inicio DATETIME;
            DECLARE janela_fim DATETIME;
            DECLARE num_paradas INT;
            
            DECLARE cur_equip CURSOR FOR
                SELECT DISTINCT equipamento_id
                FROM ordens_servico
                WHERE tipo_equipamento = 'embarcacao'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH);

            DECLARE cur_intervals CURSOR FOR
                SELECT data_abertura, data_conclusao
                FROM ordens_servico
                WHERE tipo_equipamento = 'embarcacao'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                  AND equipamento_id = cur_eq_id
                ORDER BY data_abertura ASC;

            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done_eq = TRUE;

            OPEN cur_equip;
            eq_loop: LOOP
                FETCH cur_equip INTO cur_eq_id;
                IF done_eq THEN
                    LEAVE eq_loop;
                END IF;

                SET total_downtime_seconds = 0;
                SET prev_start = NULL;
                SET prev_end = NULL;
                SET done_iv = FALSE;

                -- Janela e contagem
                SELECT MIN(data_abertura), MAX(data_conclusao), COUNT(*)
                  INTO janela_inicio, janela_fim, num_paradas
                FROM ordens_servico
                WHERE tipo_equipamento = 'embarcacao'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                  AND equipamento_id = cur_eq_id;

                -- Iterar intervalos e unir sobreposições
                BEGIN
                    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done_iv = TRUE;
                    OPEN cur_intervals;
                    iv_loop: LOOP
                        FETCH cur_intervals INTO iv_start, iv_end;
                        IF done_iv THEN
                            LEAVE iv_loop;
                        END IF;

                        IF prev_start IS NULL THEN
                            SET prev_start = iv_start;
                            SET prev_end = iv_end;
                        ELSEIF iv_start <= prev_end THEN
                            IF iv_end > prev_end THEN
                                SET prev_end = iv_end;
                            END IF;
                        ELSE
                            SET total_downtime_seconds = total_downtime_seconds + TIMESTAMPDIFF(SECOND, prev_start, prev_end);
                            SET prev_start = iv_start;
                            SET prev_end = iv_end;
                        END IF;
                    END LOOP;
                    CLOSE cur_intervals;
                END;

                IF prev_start IS NOT NULL THEN
                    SET total_downtime_seconds = total_downtime_seconds + TIMESTAMPDIFF(SECOND, prev_start, prev_end);
                END IF;

                IF num_paradas > 0 AND janela_inicio IS NOT NULL AND janela_fim IS NOT NULL AND janela_fim > janela_inicio THEN
                    INSERT INTO mtbf_embarcacao (id_ativo, mtbf, num_os, data_registro)
                    VALUES (
                        cur_eq_id,
                        (TIMESTAMPDIFF(SECOND, janela_inicio, janela_fim) - total_downtime_seconds) / 3600 / num_paradas,
                        num_paradas,
                        v_data_registro
                    )
                    ON DUPLICATE KEY UPDATE
                        mtbf = VALUES(mtbf),
                        num_os = VALUES(num_os),
                        data_registro = VALUES(data_registro);
                END IF;
            END LOOP;
            CLOSE cur_equip;
        END;

        -- MTBF Implementos
        BEGIN
            DECLARE done_eq2 INT DEFAULT FALSE;
            DECLARE done_iv2 INT DEFAULT FALSE;
            DECLARE cur_eq_id2 INT;
            DECLARE iv_start2 DATETIME;
            DECLARE iv_end2 DATETIME;
            DECLARE prev_start2 DATETIME;
            DECLARE prev_end2 DATETIME;
            DECLARE total_downtime_seconds2 BIGINT DEFAULT 0;
            DECLARE janela_inicio2 DATETIME;
            DECLARE janela_fim2 DATETIME;
            DECLARE num_paradas2 INT;

            DECLARE cur_equip2 CURSOR FOR
                SELECT DISTINCT equipamento_id
                FROM ordens_servico
                WHERE tipo_equipamento = 'implemento'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH);

            DECLARE cur_intervals2 CURSOR FOR
                SELECT data_abertura, data_conclusao
                FROM ordens_servico
                WHERE tipo_equipamento = 'implemento'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                  AND equipamento_id = cur_eq_id2
                ORDER BY data_abertura ASC;

            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done_eq2 = TRUE;

            OPEN cur_equip2;
            eq_loop2: LOOP
                FETCH cur_equip2 INTO cur_eq_id2;
                IF done_eq2 THEN
                    LEAVE eq_loop2;
                END IF;

                SET total_downtime_seconds2 = 0;
                SET prev_start2 = NULL;
                SET prev_end2 = NULL;
                SET done_iv2 = FALSE;

                SELECT MIN(data_abertura), MAX(data_conclusao), COUNT(*)
                  INTO janela_inicio2, janela_fim2, num_paradas2
                FROM ordens_servico
                WHERE tipo_equipamento = 'implemento'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                  AND equipamento_id = cur_eq_id2;

                BEGIN
                    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done_iv2 = TRUE;
                    OPEN cur_intervals2;
                    iv_loop2: LOOP
                        FETCH cur_intervals2 INTO iv_start2, iv_end2;
                        IF done_iv2 THEN
                            LEAVE iv_loop2;
                        END IF;

                        IF prev_start2 IS NULL THEN
                            SET prev_start2 = iv_start2;
                            SET prev_end2 = iv_end2;
                        ELSEIF iv_start2 <= prev_end2 THEN
                            IF iv_end2 > prev_end2 THEN
                                SET prev_end2 = iv_end2;
                            END IF;
                        ELSE
                            SET total_downtime_seconds2 = total_downtime_seconds2 + TIMESTAMPDIFF(SECOND, prev_start2, prev_end2);
                            SET prev_start2 = iv_start2;
                            SET prev_end2 = iv_end2;
                        END IF;
                    END LOOP;
                    CLOSE cur_intervals2;
                END;

                IF prev_start2 IS NOT NULL THEN
                    SET total_downtime_seconds2 = total_downtime_seconds2 + TIMESTAMPDIFF(SECOND, prev_start2, prev_end2);
                END IF;

                IF num_paradas2 > 0 AND janela_inicio2 IS NOT NULL AND janela_fim2 IS NOT NULL AND janela_fim2 > janela_inicio2 THEN
                    INSERT INTO mtbf_implemento (id_ativo, mtbf, num_os, data_registro)
                    VALUES (
                        cur_eq_id2,
                        (TIMESTAMPDIFF(SECOND, janela_inicio2, janela_fim2) - total_downtime_seconds2) / 3600 / num_paradas2,
                        num_paradas2,
                        v_data_registro
                    )
                    ON DUPLICATE KEY UPDATE
                        mtbf = VALUES(mtbf),
                        num_os = VALUES(num_os),
                        data_registro = VALUES(data_registro);
                END IF;
            END LOOP;
            CLOSE cur_equip2;
        END;

        -- MTBF Tanques
        BEGIN
            DECLARE done_eq3 INT DEFAULT FALSE;
            DECLARE done_iv3 INT DEFAULT FALSE;
            DECLARE cur_eq_id3 INT;
            DECLARE iv_start3 DATETIME;
            DECLARE iv_end3 DATETIME;
            DECLARE prev_start3 DATETIME;
            DECLARE prev_end3 DATETIME;
            DECLARE total_downtime_seconds3 BIGINT DEFAULT 0;
            DECLARE janela_inicio3 DATETIME;
            DECLARE janela_fim3 DATETIME;
            DECLARE num_paradas3 INT;

            DECLARE cur_equip3 CURSOR FOR
                SELECT DISTINCT equipamento_id
                FROM ordens_servico
                WHERE tipo_equipamento = 'tanque'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH);

            DECLARE cur_intervals3 CURSOR FOR
                SELECT data_abertura, data_conclusao
                FROM ordens_servico
                WHERE tipo_equipamento = 'tanque'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                  AND equipamento_id = cur_eq_id3
                ORDER BY data_abertura ASC;

            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done_eq3 = TRUE;

            OPEN cur_equip3;
            eq_loop3: LOOP
                FETCH cur_equip3 INTO cur_eq_id3;
                IF done_eq3 THEN
                    LEAVE eq_loop3;
                END IF;

                SET total_downtime_seconds3 = 0;
                SET prev_start3 = NULL;
                SET prev_end3 = NULL;
                SET done_iv3 = FALSE;

                SELECT MIN(data_abertura), MAX(data_conclusao), COUNT(*)
                  INTO janela_inicio3, janela_fim3, num_paradas3
                FROM ordens_servico
                WHERE tipo_equipamento = 'tanque'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                  AND equipamento_id = cur_eq_id3;

                BEGIN
                    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done_iv3 = TRUE;
                    OPEN cur_intervals3;
                    iv_loop3: LOOP
                        FETCH cur_intervals3 INTO iv_start3, iv_end3;
                        IF done_iv3 THEN
                            LEAVE iv_loop3;
                        END IF;

                        IF prev_start3 IS NULL THEN
                            SET prev_start3 = iv_start3;
                            SET prev_end3 = iv_end3;
                        ELSEIF iv_start3 <= prev_end3 THEN
                            IF iv_end3 > prev_end3 THEN
                                SET prev_end3 = iv_end3;
                            END IF;
                        ELSE
                            SET total_downtime_seconds3 = total_downtime_seconds3 + TIMESTAMPDIFF(SECOND, prev_start3, prev_end3);
                            SET prev_start3 = iv_start3;
                            SET prev_end3 = iv_end3;
                        END IF;
                    END LOOP;
                    CLOSE cur_intervals3;
                END;

                IF prev_start3 IS NOT NULL THEN
                    SET total_downtime_seconds3 = total_downtime_seconds3 + TIMESTAMPDIFF(SECOND, prev_start3, prev_end3);
                END IF;

                IF num_paradas3 > 0 AND janela_inicio3 IS NOT NULL AND janela_fim3 IS NOT NULL AND janela_fim3 > janela_inicio3 THEN
                    INSERT INTO mtbf_tanque (id_ativo, mtbf, num_os, data_registro)
                    VALUES (
                        cur_eq_id3,
                        (TIMESTAMPDIFF(SECOND, janela_inicio3, janela_fim3) - total_downtime_seconds3) / 3600 / num_paradas3,
                        num_paradas3,
                        v_data_registro
                    )
                    ON DUPLICATE KEY UPDATE
                        mtbf = VALUES(mtbf),
                        num_os = VALUES(num_os),
                        data_registro = VALUES(data_registro);
                END IF;
            END LOOP;
            CLOSE cur_equip3;
        END;

        -- MTBF Veículos
        BEGIN
            DECLARE done_eq4 INT DEFAULT FALSE;
            DECLARE done_iv4 INT DEFAULT FALSE;
            DECLARE cur_eq_id4 INT;
            DECLARE iv_start4 DATETIME;
            DECLARE iv_end4 DATETIME;
            DECLARE prev_start4 DATETIME;
            DECLARE prev_end4 DATETIME;
            DECLARE total_downtime_seconds4 BIGINT DEFAULT 0;
            DECLARE janela_inicio4 DATETIME;
            DECLARE janela_fim4 DATETIME;
            DECLARE num_paradas4 INT;

            DECLARE cur_equip4 CURSOR FOR
                SELECT DISTINCT equipamento_id
                FROM ordens_servico
                WHERE tipo_equipamento = 'veiculo'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH);

            DECLARE cur_intervals4 CURSOR FOR
                SELECT data_abertura, data_conclusao
                FROM ordens_servico
                WHERE tipo_equipamento = 'veiculo'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                  AND equipamento_id = cur_eq_id4
                ORDER BY data_abertura ASC;

            DECLARE CONTINUE HANDLER FOR NOT FOUND SET done_eq4 = TRUE;

            OPEN cur_equip4;
            eq_loop4: LOOP
                FETCH cur_equip4 INTO cur_eq_id4;
                IF done_eq4 THEN
                    LEAVE eq_loop4;
                END IF;

                SET total_downtime_seconds4 = 0;
                SET prev_start4 = NULL;
                SET prev_end4 = NULL;
                SET done_iv4 = FALSE;

                SELECT MIN(data_abertura), MAX(data_conclusao), COUNT(*)
                  INTO janela_inicio4, janela_fim4, num_paradas4
                FROM ordens_servico
                WHERE tipo_equipamento = 'veiculo'
                  AND tipo_manutencao = 'corretiva'
                  AND status = 'concluida'
                  AND data_conclusao IS NOT NULL
                  AND data_conclusao >= DATE_SUB(NOW(), INTERVAL 12 MONTH)
                  AND equipamento_id = cur_eq_id4;

                BEGIN
                    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done_iv4 = TRUE;
                    OPEN cur_intervals4;
                    iv_loop4: LOOP
                        FETCH cur_intervals4 INTO iv_start4, iv_end4;
                        IF done_iv4 THEN
                            LEAVE iv_loop4;
                        END IF;

                        IF prev_start4 IS NULL THEN
                            SET prev_start4 = iv_start4;
                            SET prev_end4 = iv_end4;
                        ELSEIF iv_start4 <= prev_end4 THEN
                            IF iv_end4 > prev_end4 THEN
                                SET prev_end4 = iv_end4;
                            END IF;
                        ELSE
                            SET total_downtime_seconds4 = total_downtime_seconds4 + TIMESTAMPDIFF(SECOND, prev_start4, prev_end4);
                            SET prev_start4 = iv_start4;
                            SET prev_end4 = iv_end4;
                        END IF;
                    END LOOP;
                    CLOSE cur_intervals4;
                END;

                IF prev_start4 IS NOT NULL THEN
                    SET total_downtime_seconds4 = total_downtime_seconds4 + TIMESTAMPDIFF(SECOND, prev_start4, prev_end4);
                END IF;

                IF num_paradas4 > 0 AND janela_inicio4 IS NOT NULL AND janela_fim4 IS NOT NULL AND janela_fim4 > janela_inicio4 THEN
                    INSERT INTO mtbf_veiculo (id_ativo, mtbf, num_os, data_registro)
                    VALUES (
                        cur_eq_id4,
                        (TIMESTAMPDIFF(SECOND, janela_inicio4, janela_fim4) - total_downtime_seconds4) / 3600 / num_paradas4,
                        num_paradas4,
                        v_data_registro
                    )
                    ON DUPLICATE KEY UPDATE
                        mtbf = VALUES(mtbf),
                        num_os = VALUES(num_os),
                        data_registro = VALUES(data_registro);
                END IF;
            END LOOP;
            CLOSE cur_equip4;
        END;
        
    END LOOP;
    
    CLOSE tipo_cursor;
    
END$$

DELIMITER ;

-- Criar evento para executar a procedure diariamente às 02:00
DROP EVENT IF EXISTS EventoCalcularIndicadoresDiarios;

CREATE EVENT EventoCalcularIndicadoresDiarios
ON SCHEDULE EVERY 1 DAY
STARTS '2025-01-01 02:00:00'
DO
  CALL CalcularIndicadoresDiarios();
