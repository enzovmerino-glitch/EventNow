CREATE DATABASE IF NOT EXISTS eventnow_db;
USE eventnow_db;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    cpf VARCHAR(14) UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('organizador', 'participante') DEFAULT 'participante',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    data_hora DATETIME NOT NULL,
    local VARCHAR(200) NOT NULL,
    vagas_total INT NOT NULL,
    organizador_id INT NOT NULL,
    categoria VARCHAR(50),
    imagem_url VARCHAR(255),
    FOREIGN KEY (organizador_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE inscricoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    evento_id INT NOT NULL,
    usuario_id INT NOT NULL,
    data_inscricao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('confirmada', 'cancelada') DEFAULT 'confirmada',
    FOREIGN KEY (evento_id) REFERENCES eventos(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

INSERT INTO usuarios (nome, email, senha, tipo) VALUES 
('Studio Imagens', 'contato@studioimagens.com.br', 'senha123', 'organizador'),
('João Participante', 'joao@email.com', 'senha123', 'participante');

INSERT INTO eventos (titulo, descricao, data_hora, local, vagas_total, organizador_id, categoria) VALUES 
('Workshop de Fotografia Digital', 'Aprenda técnicas essenciais...', '2026-10-15 19:30:00', 'Auditório SP', 50, 1, 'design'),
('Festival de Música Indie', 'Grandes artistas...', '2026-10-29 20:00:00', 'Rio de Janeiro', 500, 1, 'música');