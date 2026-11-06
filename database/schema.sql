DROP DATABASE IF EXISTS eventnow;
CREATE DATABASE eventnow CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE eventnow;

CREATE TABLE usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  cpf VARCHAR(14) UNIQUE,
  senha_hash VARCHAR(255) NOT NULL,
  tipo ENUM('organizador','participante') NOT NULL DEFAULT 'participante',
  criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(60) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE eventos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(150) NOT NULL,
  descricao TEXT,
  data_inicio DATETIME NOT NULL,
  data_fim DATETIME NOT NULL,
  local VARCHAR(150) NOT NULL,
  cidade VARCHAR(80) NOT NULL,
  imagem VARCHAR(255),
  preco DECIMAL(10,2) NOT NULL DEFAULT 0,
  vagas_total INT NOT NULL,
  categoria_id INT NOT NULL,
  organizador_id INT NOT NULL,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id),
  FOREIGN KEY (organizador_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

CREATE TABLE inscricoes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  evento_id INT NOT NULL,
  usuario_id INT NOT NULL,
  data_inscricao DATETIME DEFAULT CURRENT_TIMESTAMP,
  status ENUM('ativa','cancelada') NOT NULL DEFAULT 'ativa',
  UNIQUE KEY uq_inscricao (evento_id, usuario_id),
  FOREIGN KEY (evento_id) REFERENCES eventos(id) ON DELETE CASCADE,
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE interesses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  categoria_id INT NOT NULL,
  UNIQUE KEY uq_interesse (usuario_id, categoria_id),
  FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
  FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- DADOS INICIAIS (senha de todos os usuários de teste: password)
INSERT INTO categorias (nome) VALUES ('Tecnologia'),('Design'),('Música'),('Marketing'),('Fotografia');

INSERT INTO usuarios (nome,email,cpf,senha_hash,tipo) VALUES
('Studio Imagens','studio@eventnow.com','111.111.111-11','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','organizador'),
('Tech Hub Eventos','techhub@eventnow.com','222.222.222-22','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','organizador'),
('Bruno Lima','bruno@email.com','333.333.333-33','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','participante'),
('Carla Dias','carla@email.com','444.444.444-44','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','participante'),
('Daniela Alves','daniela@email.com','555.555.555-55','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi','participante');

INSERT INTO eventos (titulo,descricao,data_inicio,data_fim,local,cidade,imagem,preco,vagas_total,categoria_id,organizador_id) VALUES
('Workshop de Fotografia Digital','Aprenda técnicas essenciais para capturar imagens incríveis, desde composição básica até edição avançada. Ideal para entusiastas e iniciantes que desejam aprimorar suas habilidades.','2026-11-18 19:30:00','2026-11-18 21:30:00','Auditório SP - Rua Augusta, 1200, Consolação','São Paulo-SP',NULL,80.00,120,5,1),
('Feira de Design Criativo','Exposição de marcas, artistas e tendências do design.','2026-11-25 10:00:00','2026-11-25 18:00:00','Pavilhão Criativo','São Paulo-SP',NULL,40.00,300,2,1),
('Festival de Música Indie','Grandes artistas, boa energia e muita música.','2026-11-28 16:00:00','2026-11-28 23:00:00','Arena Rio','Rio de Janeiro-RJ',NULL,150.00,500,3,2),
('Summit de Tecnologia','Palestras, network e muito mais sobre o futuro da tecnologia.','2026-12-12 09:00:00','2026-12-12 18:00:00','Tech Hub','São Paulo-SP',NULL,200.00,400,1,2),
('Workshop de Marketing','Aprenda estratégias práticas com especialistas da área.','2026-12-07 14:00:00','2026-12-07 17:00:00','Sala de Reuniões Centro','São Paulo-SP',NULL,60.00,30,4,1);

INSERT INTO inscricoes (evento_id,usuario_id,data_inscricao,status) VALUES
(1,3,'2026-09-20 10:00:00','ativa'),
(1,4,'2026-10-05 11:30:00','ativa'),
(1,5,NOW(),'ativa'),
(2,3,'2026-09-25 09:00:00','ativa'),
(2,4,NOW(),'ativa'),
(3,3,NOW(),'ativa'),
(3,5,NOW(),'cancelada'),
(4,4,'2026-10-10 15:00:00','ativa'),
(5,3,NOW(),'ativa');

INSERT INTO interesses (usuario_id,categoria_id) VALUES (3,1),(3,5),(4,2),(4,3),(5,4);
