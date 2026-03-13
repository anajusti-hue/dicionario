-- 1. Nome do Banco de Dados
CREATE DATABASE IF NOT EXISTS dicionario 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE dicionario;

-- 2. Tabela de Professores
CREATE TABLE IF NOT EXISTS professores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nif VARCHAR(20) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    materia_responsavel ENUM('portugues', 'matematica', 'ambas') DEFAULT 'ambas'
) ENGINE=InnoDB;

-- 3. Inserindo os Professores Específicos
INSERT INTO professores (nome, nif, senha, materia_responsavel) VALUES 
('Gilmara', '12345689', '1234', 'portugues'),
('Felipe', '1234678', '5678', 'matematica');

-- 4. Tabela de Termos (Estrutura Completa)
CREATE TABLE IF NOT EXISTS termos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    termo VARCHAR(100) NOT NULL,
    definicao TEXT NOT NULL,
    disciplina ENUM('portugues', 'matematica') NOT NULL,
    imagem_url VARCHAR(255) DEFAULT NULL,
    status ENUM('pendente', 'aprovado') DEFAULT 'pendente',
    data_sugestao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_professor_validador INT NULL,
    FOREIGN KEY (id_professor_validador) REFERENCES professores(id) ON DELETE SET NULL
) ENGINE=InnoDB;