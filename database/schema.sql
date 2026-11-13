SET NAMES utf8mb4;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  cpf CHAR(11) NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4;

CREATE TABLE eventos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  organizador_id INT NOT NULL,
  titulo VARCHAR(150) NOT NULL,
  descricao TEXT NOT NULL,
  categoria VARCHAR(30) NOT NULL,
  data_evento DATETIME NOT NULL,
  hora_fim TIME NULL,
  local_nome VARCHAR(120) NOT NULL,
  endereco VARCHAR(200) NOT NULL,
  cidade VARCHAR(80) NOT NULL,
  uf CHAR(2) NOT NULL,
  capacidade INT NOT NULL,
  preco DECIMAL(10,2) NOT NULL DEFAULT 0,
  imagem VARCHAR(255) NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (organizador_id) REFERENCES usuarios(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4;

CREATE TABLE inscricoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  evento_id INT NOT NULL,
  usuario_id INT NOT NULL,
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY uq_inscricao (evento_id, usuario_id),
  FOREIGN KEY (evento_id) REFERENCES eventos(id) ON DELETE CASCADE,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4;

-- Dados de demonstração. Senha de todos os usuários: 123456
SET @hash = '$2b$10$abcdefghijklmnopqrstuuxD0vCwu/f2ahNVJLL35ZYA2xuiRyPH6';
SET @mes_anterior = DATE_SUB(DATE_FORMAT(NOW(), '%Y-%m-01'), INTERVAL 10 DAY);

INSERT INTO usuarios (nome, email, cpf, senha) VALUES
('Studio Imagens', 'organizador@eventnow.com', '12345678909', @hash);

INSERT INTO usuarios (nome, email, senha)
WITH RECURSIVE n(i) AS (SELECT 1 UNION ALL SELECT i + 1 FROM n WHERE i < 40)
SELECT CONCAT('Participante ', i), CONCAT('participante', i, '@email.com'), @hash FROM n;

INSERT INTO eventos (organizador_id, titulo, descricao, categoria, data_evento, hora_fim, local_nome, endereco, cidade, uf, capacidade, preco) VALUES
(1, 'Workshop de Fotografia Digital', 'Aprenda técnicas essenciais para capturar imagens incríveis, desde composição básica até edição avançada. Ideal para entusiastas e iniciantes que desejam ativar suas habilidades.', 'design', DATE_ADD(CURDATE(), INTERVAL 14 DAY) + INTERVAL '19:30' HOUR_MINUTE, '21:30', 'Auditório SP', 'Rua Augusta, 1200, Consolação', 'São Paulo', 'SP', 50, 80.00),
(1, 'Feira de Design Criativo', 'Exposição de marcas, artistas e tendências do design.', 'design', DATE_ADD(CURDATE(), INTERVAL 20 DAY) + INTERVAL '10:00' HOUR_MINUTE, '18:00', 'Pavilhão Criativo', 'Av. Paulista, 900', 'São Paulo', 'SP', 300, 40.00),
(1, 'Festival de Música Indie', 'Grandes artistas, boa energia e muita música.', 'música', DATE_ADD(CURDATE(), INTERVAL 25 DAY) + INTERVAL '16:00' HOUR_MINUTE, '23:59', 'Club Arena', 'Rua da Lapa, 300', 'Rio de Janeiro', 'RJ', 40, 120.00),
(1, 'Summit de Tecnologia', 'Palestras, network e muito mais sobre o futuro da tecnologia.', 'tecnologia', DATE_ADD(CURDATE(), INTERVAL 30 DAY) + INTERVAL '09:00' HOUR_MINUTE, '18:00', 'Tech Hub', 'Rua Funchal, 500, Vila Olímpia', 'São Paulo', 'SP', 250, 150.00),
(1, 'Workshop de Marketing', 'Aprenda estratégias práticas com especialistas da área.', 'tecnologia', DATE_ADD(CURDATE(), INTERVAL 35 DAY) + INTERVAL '14:00' HOUR_MINUTE, '17:00', 'Sala de Reuniões', 'Rua Oscar Freire, 100', 'São Paulo', 'SP', 30, 60.00);

-- Inscrições: parte no mês anterior, parte neste mês (alimenta os percentuais do dashboard)
INSERT INTO inscricoes (evento_id, usuario_id, criado_em) SELECT 1, id, IF(id <= 15, @mes_anterior, NOW()) FROM usuarios WHERE id BETWEEN 2 AND 36;
INSERT INTO inscricoes (evento_id, usuario_id, criado_em) SELECT 2, id, IF(id <= 15, @mes_anterior, NOW()) FROM usuarios WHERE id BETWEEN 2 AND 21;
INSERT INTO inscricoes (evento_id, usuario_id, criado_em) SELECT 3, id, IF(id <= 15, @mes_anterior, NOW()) FROM usuarios WHERE id BETWEEN 2 AND 41;
INSERT INTO inscricoes (evento_id, usuario_id, criado_em) SELECT 4, id, IF(id <= 15, @mes_anterior, NOW()) FROM usuarios WHERE id BETWEEN 2 AND 31;
INSERT INTO inscricoes (evento_id, usuario_id, criado_em) SELECT 5, id, IF(id <= 15, @mes_anterior, NOW()) FROM usuarios WHERE id BETWEEN 2 AND 29;
