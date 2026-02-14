ALTER TABLE usuarios
MODIFY nivel_acesso ENUM('admin','usuario','gestor','responsavel') DEFAULT 'usuario';

UPDATE usuarios
SET nivel_acesso = CASE
    WHEN nivel_acesso = 'admin' THEN 'gestor'
    WHEN nivel_acesso = 'usuario' THEN 'responsavel'
    ELSE nivel_acesso
END
WHERE id > 0 AND nivel_acesso IN ('admin','usuario');

ALTER TABLE usuarios
MODIFY nivel_acesso ENUM('gestor','responsavel') DEFAULT 'responsavel';
