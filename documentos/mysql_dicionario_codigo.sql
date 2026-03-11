-- 1. Criar o banco de dados (ajustado para aceitar acentos perfeitamente)
CREATE DATABASE IF NOT EXISTS dicionario 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE dicionario;

-- 2. Tabela de Professores (Para o Sistema de Login)
CREATE TABLE IF NOT EXISTS professores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL, -- O ideal é usar hash (password_hash)
    materia_responsavel ENUM('portugues', 'matematica', 'ambas') DEFAULT 'ambas'
) ENGINE=InnoDB;

-- 3. Tabela de Termos Técnicos (O Coração do Projeto)
CREATE TABLE IF NOT EXISTS termos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    termo VARCHAR(100) NOT NULL,
    definicao TEXT NOT NULL,
    disciplina ENUM('portugues', 'matematica') NOT NULL,
    imagem_url VARCHAR(255) DEFAULT NULL, -- Link ou caminho da imagem
    status ENUM('pendente', 'aprovado') DEFAULT 'pendente', -- Regra de validação
    data_sugestao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_professor_validador INT NULL, -- FK para saber quem aprovou
    FOREIGN KEY (id_professor_validador) REFERENCES professores(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 4. Dados Iniciais para Teste (Seed)
-- Senha de teste: 'senai123' (em um sistema real, use hash)
INSERT INTO professores (nome, email, senha, materia_responsavel) VALUES 
('Admin SENAI', 'professor@senai.com.br', 'senai123', 'ambas');

-- Termos de exemplo
INSERT INTO termos (termo, definicao, disciplina, status) VALUES 
('Derivada', 'A taxa de variação instantânea de uma função.', 'matematica', 'aprovado'),
('Oração Coordenada', 'Orações independentes que possuem sentido completo.', 'portugues', 'aprovado'),
('Hipotenusa', 'O lado oposto ao ângulo reto em um triângulo retângulo.', 'matematica', 'pendente');

