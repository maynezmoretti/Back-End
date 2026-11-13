-- Tabela para armazenar os usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id BIGSERIAL PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    perfil VARCHAR(20) NOT NULL
        CHECK (perfil IN ('ADMIN', 'OPERADOR')),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela para registrar as tentativas de login
CREATE TABLE IF NOT EXISTS auditoria_logins (
    id BIGSERIAL PRIMARY KEY,
    email VARCHAR(180) NOT NULL,
    ip VARCHAR(45) NOT NULL,
    user_agent TEXT NOT NULL,
    sucesso BOOLEAN NOT NULL,
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Índice para facilitar a busca dos registros
CREATE INDEX IF NOT EXISTS idx_auditoria_email
ON auditoria_logins(email);