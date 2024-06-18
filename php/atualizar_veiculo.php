<?php

// Incluir o script de conexão
include "conexao_bd.php";

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Função para evitar XSS
function limpar_entrada($entrada) {
    $entrada = trim($entrada);
    $entrada = stripslashes($entrada);
    $entrada = htmlspecialchars($entrada);
    return $entrada;
}

// Verifica se o ID do veículo foi enviado via GET
if (isset($_GET['id'])) {
    $id = limpar_entrada($_GET['id']);

    // Consulta para obter os dados do veículo a ser atualizado
    $sql = "SELECT * FROM ativo_veiculo WHERE id = $id";
    $result = $conn->query($sql);

    // Verifica se encontrou algum resultado
    if ($result->num_rows > 0) {
        // Extrai os dados da consulta
        $row = $result->fetch_assoc();

        // Constrói o formulário com os dados do veículo
        echo '<form action="atualizar_veiculo1.php" method="post">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo 'Tipo de Veículo: <input type="text" name="tipo_veiculo" value="' . $row['tipo_veiculo'] . '"><br>';
        echo 'Tag: <input type="text" name="tag" value="' . $row['tag'] . '"><br>';
        echo 'Placa: <input type="text" name="placa" value="' . $row['placa'] . '"><br>';
        echo 'Fabricante: <input type="text" name="fabricante" value="' . $row['fabricante'] . '"><br>';
        echo 'Modelo: <input type="text" name="modelo" value="' . $row['modelo'] . '"><br>';
        echo 'Ano de Fabricação: <input type="text" name="ano_fabricacao" value="' . $row['ano_fabricacao'] . '"><br>';
        echo 'Chassis: <input type="text" name="chassis" value="' . $row['chassis'] . '"><br>';
        echo 'Renavam: <input type="text" name="renavam" value="' . $row['renavam'] . '"><br>';
        echo 'Proprietário: <input type="text" name="proprietario" value="' . $row['proprietario'] . '"><br>';
        echo 'Tara: <input type="text" name="tara" value="' . $row['tara'] . '"><br>';
        echo 'Lotação: <input type="text" name="lotacao" value="' . $row['lotacao'] . '"><br>';
        echo 'PTB: <input type="text" name="PTB" value="' . $row['PTB'] . '"><br>';
        echo 'PBTC: <input type="text" name="PBTC" value="' . $row['PBTC'] . '"><br>';
        echo 'CMT: <input type="text" name="CMT" value="' . $row['CMT'] . '"><br>';
        echo 'Cor: <input type="text" name="cor" value="' . $row['cor'] . '"><br>';
        echo 'Foto: <input type="text" name="foto" value="' . $row['foto'] . '"><br>';
        echo '<input type="submit" value="Atualizar">';
        echo '</form>';
    } else {
        echo "Veículo não encontrado.";
    }
} else {
    echo "ID do veículo não fornecido.";
}

// Fecha a conexão
$conn->close();
?>
