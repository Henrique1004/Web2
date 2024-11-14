CREATE DATABASE eventosys;
USE eventosys;
CREATE TABLE users(id INTEGER AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL,
senha VARCHAR(255) NOT NULL, tipo_usr VARCHAR(255) NOT NULL);
CREATE TABLE eventos(id INTEGER AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(255) NOT NULL, descricao VARCHAR(255),
data DATE NOT NULL, local VARCHAR(255) NOT NULL, participantes INTEGER, max_participantes INTEGER NOT NULL);
INSERT INTO users (nome, email, senha, tipo_usr) VALUES ('admin', 'admin@email.com', MD5('0000'), 'adm');
INSERT INTO users (nome, email, senha, tipo_usr) VALUES ('usr', 'usr@email.com', MD5('0000'), 'usr');