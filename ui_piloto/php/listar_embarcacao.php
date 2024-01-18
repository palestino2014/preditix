<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Consulta SQL para obter todos os dados da tabela
$consulta = $conn->query("SELECT * FROM ativo_embarcacao");

// Verifica se há resultados
if ($consulta->num_rows > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Embarcações</title>
    </head>
    <body>
        <h1>Lista de Embarcações</h1>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de Embarcação</th>
                    <th>Número de Inscrição</th>
                    <th>Fabricante</th>
                    <th>Armador</th>
                    <th>Ano de Fabricação</th>
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
                        <td><?= $row["tipo_embarcacao"] ?></td>
                        <td><?= $row["num_inscricao"] ?></td>
                        <td><?= $row["fabricante"] ?></td>
                        <td><?= $row["armador"] ?></td>
                        <td><?= $row["ano_fabricacao"] ?></td>
                        <td><?= $row["capacidade_volumetrica"] ?></td>
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
    echo "Nenhuma embarcação encontrada.";
}

// Fechar a consulta
$consulta->close();

// Fechar a conexão
$conn->close();
?>
