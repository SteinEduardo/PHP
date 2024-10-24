<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "crudBd";

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $conexao = new mysqli($servername, $username, $password, $dbname);

    if ($conexao->connect_error) 
    {
        die("Falha na conexão: " . $conexao->connect_error);
    } 

    if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {
        $acao = $_POST['acao'] ?? null;

        // Certifique-se de que 'acao' está sendo enviado
        if (!$acao) {
            http_response_code(400);
            echo "Ação não fornecida.";
            exit();
        }

        if ($acao == "cadastrar") {
            $nome = $conexao->real_escape_string($_POST['nome'] ?? '');
            $cpf = $conexao->real_escape_string($_POST['cpf'] ?? '');
            $nascimento = $conexao->real_escape_string($_POST['nascimento'] ?? '');
            $tel = $conexao->real_escape_string($_POST['tel'] ?? '');
            $email = $conexao->real_escape_string($_POST['email'] ?? '');
        
            // Validação dos campos obrigatórios
            if (empty($nome) || empty($cpf) || empty($nascimento) || empty($tel)) {
                http_response_code(400); // Resposta de erro 400
                echo "Por favor, preencha todos os campos obrigatórios.";
                exit();
            }
        
            $queryInsert = "INSERT INTO usuarios (nome, cpf, nascimento, tel, email)
                            VALUES ('$nome', '$cpf', '$nascimento', '$tel', '$email')";
        
            if ($conexao->query($queryInsert) === TRUE) {
                http_response_code(200);
                echo "Cadastro realizado com sucesso!";
            } else {
                http_response_code(500);
                echo "Erro ao cadastrar: " . $conexao->error;
            }
        }

        if ($acao == "pesquisar") 
        {
            $cpf = $conexao->real_escape_string($_POST['cpf']);

            $querySelect = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
            $result = $conexao->query($querySelect);

            if ($result->num_rows > 0) 
            {
                $row = $result->fetch_assoc();

                header("Location: ../php/pesquisa.php?nome_completo=" . urlencode($row['nome']) . "&cpf=" . urlencode($row['cpf']) .
                       "&data_nascimento=" . urlencode($row['nascimento']) . "&telefone=" . urlencode($row['tel']) .
                       "&email=" . urlencode($row['email']));
                exit();
            } 
            else 
            {
                echo "Nenhum usuário encontrado com o CPF: $cpf";
            }
        }

        if ($acao == "pesquisarTudo")
        {
            $querySelect = "SELECT * FROM usuarios";
            $result = $conexao->query($querySelect);

            if ($result->num_rows > 0) 
            {
                $data = [];
                while ($row = $result->fetch_assoc()) 
                {
                    $data[] = $row;
                }
                $dataJson = urlencode(json_encode($data));
                header("Location: ../php/pesquisa.php?data=$dataJson");
                exit();
            } 
            else 
            {
                echo "Nenhum usuário encontrado.";
            }
        }

        if ($acao == "excluir")
        {
            $cpf = $conexao->real_escape_string($_POST['cpf']);

            $queryDelete = "DELETE FROM usuarios WHERE cpf = '$cpf'";

            if ($conexao->query($queryDelete) === TRUE) 
            {
                echo "Usuário excluído com sucesso";
            } 
            else 
            {
                echo "Erro ao excluir usuário: " . $conexao->error;
            }

            header("Location: ../php/pesquisa.php?acao=pesquisarTudo");
            exit();
        }

        if ($acao == "atualizar") 
        {
            $nome = $conexao->real_escape_string($_POST['nome']);
            $cpf = $conexao->real_escape_string($_POST['cpf']);
            $nascimento = $conexao->real_escape_string($_POST['nascimento']);
            $tel = $conexao->real_escape_string($_POST['tel']);
            $email = $conexao->real_escape_string($_POST['email']);

            $queryUpdate = "UPDATE usuarios SET nome='$nome', nascimento='$nascimento', tel='$tel', email='$email' WHERE cpf='$cpf'";

            if ($conexao->query($queryUpdate) === TRUE) 
            {
                header("Location: pesquisa.php");
                exit();
            } 
            else 
            {
                echo "Erro ao atualizar: " . $conexao->error;
            }
        }
    }
?>
