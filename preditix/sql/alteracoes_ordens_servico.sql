-- Adiciona coluna para registrar o usuário que concluiu a OS
USE preditix_v1;

ALTER TABLE ordens_servico
ADD COLUMN usuario_conclusao_id INT AFTER usuario_abertura_id;

-- Adiciona a chave estrangeira depois
ALTER TABLE ordens_servico
ADD CONSTRAINT fk_usuario_conclusao
FOREIGN KEY (usuario_conclusao_id) REFERENCES usuarios(id); 