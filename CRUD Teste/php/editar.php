<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Editar Usuário</title>
<!--
    <style>
        form {
            margin-bottom: 1em;
        }
        input[type="text"],
        input[type="date"],
        input[type="tel"],
        input[type="email"] {
            width: 100%;
            padding: 0.5em;
        }
    </style>
-->

</head>
<body>
    <h1>Editar Usuário</h1>

    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "crudBd";

        $conexao = new mysqli($servername, $username, $password, $dbname);

        if ($conexao->connect_error) {
            die("Falha na conexão: " . $conexao->connect_error);
        }

        if (isset($_GET['cpf'])) {
            $cpf = $conexao->real_escape_string($_GET['cpf']);

            $querySelect = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
            $result = $conexao->query($querySelect);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
            } else {
                echo "Nenhum usuário encontrado com o CPF: $cpf";
                exit();
            }
        } else {
            echo "CPF não fornecido.";
            exit();
        }
    ?>

<form action="crud.php" method="POST" class="form-input">
    <p>Nome completo: <input type="text" name="nome" value="<?php echo htmlspecialchars($row['nome']); ?>"></p>
    <p>CPF: <input type="text" name="cpf" value="<?php echo htmlspecialchars($row['cpf']); ?>" readonly></p>
    <p>Data de nascimento: <input type="date" name="nascimento" value="<?php echo htmlspecialchars($row['nascimento']); ?>"></p>
    <p>Telefone para contato: <input type="tel" name="tel" value="<?php echo htmlspecialchars($row['tel']); ?>"></p>
    <p>E-mail: <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"></p>

    <button type="submit" name="acao" value="atualizar">Salvar</button>
</form>

    <button>
        <a href="pesquisa.php">Voltar</a>
    </button>
    
</body>
</html>
