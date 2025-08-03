<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Consulta SQL para buscar todos os registros na tabela
$sql = "SELECT * FROM ativo_implemento";
$resultado = $conn->query($sql);

// Verificar se a consulta foi bem-sucedida
if ($resultado === false) {
    die("Erro na consulta SQL: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados da Busca</title>
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

<h2>Resultados da Busca</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Tipo de Implemento</th>
        <th>Tag</th>
        <th>Placa</th>
        <th>Fabricante</th>
        <th>Modelo</th>
        <th>Ano de Fabricação</th>
        <th>Proprietário</th>
        <th>Ação</th>
    </tr>

    <?php
    // Exibir os resultados em uma tabela
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["tipo_implemento"] . "</td>";
        echo "<td>" . $row["tag"] . "</td>";
        echo "<td>" . $row["placa"] . "</td>";
        echo "<td>" . $row["fabricante"] . "</td>";
        echo "<td>" . $row["modelo"] . "</td>";
        echo "<td>" . $row["ano_fabricacao"] . "</td>";
        echo "<td>" . $row["proprietario"] . "</td>";
        echo "<td><button onclick=\"encaminharParaOutraPagina(" . $row["id"] . ")\">Encaminhar</button></td>";
        echo "</tr>";
    }
    ?>
</table>

<script>
    function encaminharParaOutraPagina(id) {
        // Redirecionar para outra página com base no ID
        window.location.href = "os_implemento.php?id=" + id;
    }
</script>

</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>
