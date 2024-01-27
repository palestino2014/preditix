<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verificar se foi recebido um ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para buscar o registro específico
    $sql = "SELECT * FROM ativo_veiculo WHERE id = $id";
    $resultado = $conn->query($sql);

    // Verificar se a consulta foi bem-sucedida
    if ($resultado === false) {
        die("Erro na consulta SQL: " . $conn->error);
    }

    // Verificar se o registro foi encontrado
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
    } else {
        die("Registro não encontrado.");
    }
} else {
    die("ID inválido.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Veículo</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>Detalhes do Veículo</h2>

<table>
    <tr>
        <th>ID</th>
        <td><?php echo $row["id"]; ?></td>
    </tr>
    <tr>
        <th>Tipo de Veículo</th>
        <td><?php echo $row["tipo_veiculo"]; ?></td>
    </tr>
    <tr>
        <th>Tag</th>
        <td><?php echo $row["tag"]; ?></td>
    </tr>
    <!-- Adicionar mais colunas conforme necessário -->

    <!-- Campo para observações -->
    <tr>
        <th>Observações</th>
        <td>
            <form action="processar_observacoes_veiculo.php" method="post">
                <input type="hidden" name="id_veiculo" value="<?php echo $row["id"]; ?>">
                <textarea name="observacoes" rows="4" cols="50" placeholder="Digite suas observações aqui..."></textarea>
                <br>
                <input type="submit" value="Adicionar Observações">
            </form>
        </td>
    </tr>
</table>

</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>
