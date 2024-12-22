<?php 
     const host = "localhost";
     const usuario = "root";
     const senha = "";
     const banco = "todo_list";

     $conn = new mysqli(hostname: host, username : usuario, password : senha, database: banco);
     if($conn->connect_error){
        die("Falha na conexão com o banco". $conn->connect_error);
     }

   // Configurar o conjunto de caracteres para UTF-8 (opcional, mas recomendado)
    mysqli_set_charset($conn, "utf8");


    //excluir tarefa
    if($_SERVER['REQUEST_METHOD'] == "GET"  && isset($_GET['delete'])){
        $tarefaDelete = $_GET['delete'];
        $tarefaDeleteVerificada = $conn->real_escape_string($tarefaDelete);

        $query = "DELETE FROM tarefas WHERE id='$tarefaDeleteVerificada'";
        
       if($conn->query(query:$query)===true){
            header("Location: index.php");
            unset($_GET['delete']);
            exit();
       }
    }

    //criar tarefa

   

    if($_SERVER['REQUEST_METHOD'] == "POST"  && isset($_POST['descricao'])){

        $tarefa = $_POST['descricao'];
        // https://www.php.net/manual/en/mysqli.real-escape-string.php
        $tarefaVerificada = $conn->real_escape_string($tarefa);

       $query = "INSERT INTO tarefas (descricao) VALUES ('$tarefaVerificada')";
        
       if($conn->query(query:$query)===true){
            header("Location: index.php");
            unset($_POST['descricao']);
       }
        
    }

    // buscar tarefas

    $tarefas= [];

    $query = 'SELECT * FROM tarefas ORDER BY data_criacao DESC';
    $result = $conn->query(query:$query);

    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
           $tarefas[] =  $row; 
        }
    }
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
</head>
<body>
    <h1>Minhas Tarefas</h1>
    <!-- https://www.simplilearn.com/tutorials/php-tutorial/get-full-url-in-php -->
    <form method="POST" action="<?= $_SERVER['PHP_SELF'];?>">
       <label for="task">Sua tarefa</label> 
       <input type="text" name="descricao" placeholder="Qual sua tarefa..." required>
       <input type="submit" value="Adicionar">
    </form>

    <h2>Lista tarefas: </h2>
    <?php if(!empty($tarefas)): ?>
        <ul>
            <?php
            foreach ($tarefas as $value) {
               echo "<li>
                            <p style='display:inline;'>".$value["descricao"]. "</p>
                            <a  href='?delete=".$value["id"]."'>excluir</a>
                    </li>";
            }
        ?>
       </ul>
    <?php else: ?>
        <p>sem tarefas</p>
     <?php endif; ?>
</body>
</html>