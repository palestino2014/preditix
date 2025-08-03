<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Consulta SQL para obter todos os dados da tabela
$consulta = $conn->query("SELECT * FROM ativo_veiculo");

// Verifica se há resultados
if ($consulta->num_rows > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Veículos</title>
    </head>
    <body>
        <h1>Lista de Veículos</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Veículo</th>
                    <th>TAG</th>
                    <th>Placa</th>
                    <th>Fabricante</th>
                    <th>Modelo</th>
                    <th>Ano de Fabricação</th>
                    <th>Chassis</th>
                    <th>Renavam</th>
                    <th>Proprietário</th>
                    <th>Tara</th>
                    <th>Lotação</th>
                    <th>PBT</th>
                    <th>PBTC</th>
                    <th>Cor</th>
                    <!-- Adicione mais colunas conforme necessário -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop através dos resultados e exibir cada linha na tabela
                while ($row = $consulta->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= $row["tipo_veiculo"] ?></td>
                        <td><?= $row["tag"] ?></td>
                        <td><?= $row["placa"] ?></td>
                        <td><?= $row["fabricante"] ?></td>
                        <td><?= $row["modelo"] ?></td>
                        <td><?= $row["ano_fabricacao"] ?></td>
                        <td><?= $row["chassis"] ?></td>
                        <td><?= $row["renavam"] ?></td>
                        <td><?= $row["proprietario"] ?></td>
                        <td><?= $row["tara"] ?></td>
                        <td><?= $row["lotacao"] ?></td>
                        <td><?= $row["PTB"] ?></td>
                        <td><?= $row["PBTC"] ?></td>
                        <td><?= $row["cor"] ?></td>
                        <!-- Adicione mais colunas conforme necessário -->
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </body>
    </html>
    <?php
} else {
    echo "Nenhum veículo encontrado.";
}

// Fechar a consulta
$consulta->close();

// Fechar a conexão
$conn->close();
?>
