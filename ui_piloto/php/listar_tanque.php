<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Consulta SQL para obter todos os dados da tabela
$consulta = $conn->query("SELECT * FROM ativo_tanque");

// Verifica se há resultados
if ($consulta->num_rows > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Tanques</title>
    </head>
    <body>
        <h1>Lista de Tanques</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TAG</th>
                    <th>Fabricante</th>
                    <th>Ano de Fabricação</th>
                    <th>Localização</th>
                    <th>Capacidade Volumétrica</th>
                    <th>Foto</th>
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
                        <td><?= $row["tag"] ?></td>
                        <td><?= $row["fabricante"] ?></td>
                        <td><?= $row["anoFabricacao"] ?></td>
                        <td><?= $row["localizacao"] ?></td>
                        <td><?= $row["capacidadeVolumetrica"] ?></td>
                        <td><?= $row["foto"] ?></td>
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
    echo "Nenhum tanque encontrado.";
}

// Fechar a consulta
$consulta->close();

// Fechar a conexão
$conn->close();
?>
