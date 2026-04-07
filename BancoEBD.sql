-- -----------------------
-- Tabela de usuários (alunos, professores, admins)
-- -----------------------
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(120) UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_nascimento DATE,
    telefone VARCHAR(20),
    role ENUM('aluno','professor','admin') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- -----------------------
-- Tabela de classes
-- -----------------------
CREATE TABLE classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    faixa_etaria VARCHAR(50)
);

-- -----------------------
-- Relacionamento professor → classe
-- Um professor só vê sua classe
-- -----------------------
CREATE TABLE professor_classe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    professor_id INT NOT NULL,
    classe_id INT NOT NULL,
    FOREIGN KEY (professor_id) REFERENCES usuarios(id),
    FOREIGN KEY (classe_id) REFERENCES classes(id)
);

-- -----------------------
-- Relacionamento aluno → classe
-- -----------------------
CREATE TABLE aluno_classe (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    classe_id INT NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES usuarios(id),
    FOREIGN KEY (classe_id) REFERENCES classes(id)
);

-- -----------------------
-- Tabela de presença
-- (sem lição, conforme pediu)
-- -----------------------
CREATE TABLE presenca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    classe_id INT NOT NULL,
    data DATE NOT NULL,
    status ENUM('presente', 'ausente') NOT NULL,
    FOREIGN KEY (aluno_id) REFERENCES usuarios(id),
    FOREIGN KEY (classe_id) REFERENCES classes(id)
);

CREATE TABLE datas_comemorativas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(120) NOT NULL,
    descricao TEXT,
    data_evento DATE NOT NULL,
    fixo ENUM('sim','nao') DEFAULT 'nao'
);



-- pegando aniversariantes da semana
SELECT nome, data_nascimento
FROM usuarios
WHERE 
    WEEKOFYEAR(data_nascimento) = WEEKOFYEAR(CURDATE());
-- -----------------------

-- insert de exemplo
-- Usuários
INSERT INTO usuarios (nome, email, senha, data_nascimento, telefone, role)
VALUES
('João Silva', 'joao@email.com', '123', '2005-02-14', '9999-9999', 'aluno'),
('Maria Santos', 'maria@email.com', '123', '1990-02-15', '9999-9999', 'professor'),
('Pedro Almeida', 'pedro@email.com', '123', '1985-02-16', '9999-9999', 'admin');

-- Classes
INSERT INTO classes (nome, faixa_etaria)
VALUES
('Classe Adolescentes', '12-17'),
('Classe Adultos', '18+');

-- Relacionar professor à classe
INSERT INTO professor_classe (professor_id, classe_id)
VALUES (2, 1); -- Maria → Adolescentes

-- Relacionar alunos à classe
INSERT INTO aluno_classe (aluno_id, classe_id)
VALUES (1, 1); -- João → Adolescentes

INSERT INTO datas_comemorativas (titulo, descricao, data_evento, fixo) VALUES
('Natal', 'Celebração do nascimento de Jesus', '2025-12-25', 'sim'),
('Páscoa', 'Ressurreição de Cristo', '2025-04-20', 'nao');


