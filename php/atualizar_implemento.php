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

// Verifica se o ID do implemento foi enviado via GET
if (isset($_GET['id'])) {
    $id = limpar_entrada($_GET['id']);

    // Consulta para obter os dados do implemento a ser atualizado
    $sql = "SELECT * FROM ativo_implemento WHERE id = $id";
    $result = $conn->query($sql);

    // Verifica se encontrou algum resultado
    if ($result->num_rows > 0) {
        // Extrai os dados da consulta
        $row = $result->fetch_assoc();

        // Constrói o formulário com os dados do implemento
        echo '<form action="atualizar_implemento1.php" method="post">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo 'Tipo de Implemento: <input type="text" name="tipo_implemento" value="' . $row['tipo_implemento'] . '"><br>';
        echo 'Vincular: <input type="text" name="vincular" value="' . $row['vincular'] . '"><br>';
        echo 'Tag: <input type="text" name="tag" value="' . $row['tag'] . '"><br>';
        echo 'Placa: <input type="text" name="placa" value="' . $row['placa'] . '"><br>';
        echo 'Fabricante: <input type="text" name="fabricante" value="' . $row['fabricante'] . '"><br>';
        echo 'Modelo: <input type="text" name="modelo" value="' . $row['modelo'] . '"><br>';
        echo 'Ano de Fabricação: <input type="text" name="ano_fabricao" value="' . $row['ano_fabricao'] . '"><br>';
        echo 'Chassis: <input type="text" name="chassis" value="' . $row['chassis'] . '"><br>';
        echo 'Renavam: <input type="text" name="renavam" value="' . $row['renavam'] . '"><br>';
        echo 'Proprietário: <input type="text" name="proprietario" value="' . $row['proprietario'] . '"><br>';
        echo 'Tara: <input type="text" name="tara" value="' . $row['tara'] . '"><br>';
        echo 'Lotação: <input type="text" name="lotacao" value="' . $row['lotacao'] . '"><br>';
        echo 'PTB: <input type="text" name="PTB" value="' . $row['PTB'] . '"><br>';
        echo 'Capacidade Máxima de Tração: <input type="text" name="capacidadeMaxTracao" value="' . $row['capacidadeMaxTracao'] . '"><br>';
        echo 'Capacidade Volumétrica: <input type="text" name="capacidadeVolumetrica" value="' . $row['capacidadeVolumetrica'] . '"><br>';
        echo 'Cor: <input type="text" name="cor" value="' . $row['cor'] . '"><br>';
        echo 'Foto: <input type="text" name="foto" value="' . $row['foto'] . '"><br>';
        echo '<input type="submit" value="Atualizar">';
        echo '</form>';
    } else {
        echo "Implemento não encontrado.";
    }
} else {
    echo "ID do implemento não fornecido.";
}

// Fecha a conexão
$conn->close();
?>
