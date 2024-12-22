create table tarefas(
    id INT AUTO_INCREMENT PRIMARY KEY,
    descricao VARCHAR(255) NOT NULL,
    concluida BOOLEAN DEFAULT FALSE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

USE todo_list;

RENAME TABLE terefas TO tarefas; 

INSERT INTO tarefas (descricao)
VALUES ("compar arroz");

-- https://www.w3schools.com/sql/sql_insert.asp