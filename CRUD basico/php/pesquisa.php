<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Pesquisa</title>
</head>
<body>
    <h1>Resultado da Pesquisa</h1>

    <form action="../php/crud.php" method="POST">
        <p>Insira o CPF: <input type="number" name="cpf" required></p>
        <button type="submit" name="acao" value="pesquisar">Pesquisar</button>
    </form>

    <form action="../php/crud.php" method="POST">
        <button type="submit" name="acao" value="pesquisarTudo">Mostrar todos usuários</button>
    </form>
 
    <a href="../html/index.html">
        <button type="button">Voltar</button>
    </a>

    <div>
        <?php
            if (isset($_GET['nome_completo']) && isset($_GET['cpf'])) 
            {
                echo '<h2>Resultado da Pesquisa:</h2>';
                echo '<table border="1">';
                    echo '<tr><th>Nome Completo</th><th>CPF</th><th>Data de Nascimento</th><th>Telefone</th><th>Email</th><th>Ação</th></tr>';
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($_GET['nome_completo']) . '</td>';
                    echo '<td>' . htmlspecialchars($_GET['cpf']) . '</td>';
                    echo '<td>' . htmlspecialchars($_GET['data_nascimento']) . '</td>';
                    echo '<td>' . htmlspecialchars($_GET['telefone']) . '</td>';
                    echo '<td>' . htmlspecialchars($_GET['email']) . '</td>';
                    echo '<td>
                            <form action="../php/crud.php" method="POST" style="display:inline;">
                                <input type="hidden" name="cpf" value="' . htmlspecialchars($_GET['cpf']) . '">
                                <button type="submit" name="acao" value="excluir">Excluir</button>
                            </form>
                            <form action="editar.php" method="GET" style="display:inline;">
                                <input type="hidden" name="cpf" value="' . htmlspecialchars($_GET['cpf']) . '">
                                <button type="submit">Editar</button>
                            </form>
                        </td>';
                    echo '</tr>';
                echo '</table>';
            }
            
            if (isset($_GET['data'])) 
            {
                $data = json_decode(urldecode($_GET['data']), true);

                if (!empty($data)) 
                {
                    echo '<h2>Todos os Usuários:</h2>';
                    echo '<table border="1">';

                        echo '<tr><th>Nome Completo</th><th>CPF</th><th>Data de Nascimento</th><th>Telefone</th><th>Email</th><th>Ação</th></tr>';

                        foreach ($data as $row) 
                        {
                            echo '<tr>';
                                echo '<td>' . htmlspecialchars($row['nome']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['cpf']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['nascimento']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['tel']) . '</td>';
                                echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                                echo '<td>
                                    <form action="../php/crud.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="cpf" value="' . htmlspecialchars($row['cpf']) . '">
                                        <button type="submit" name="acao" value="excluir">Excluir</button>
                                    </form>
                                    <form action="editar.php" method="GET" style="display:inline;">
                                        <input type="hidden" name="cpf" value="' . htmlspecialchars($row['cpf']) . '">
                                        <button type="submit">Editar</button>
                                    </form>
                                </td>';
                            echo '</tr>';
                        }
                    
                    echo '</table>';
                }
                else 
                {
                    echo "Nenhum usuário encontrado.";
                }
            }
        ?>
    </div>
</body>
</html>
