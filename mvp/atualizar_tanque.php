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

// Verifica se o ID do tanque foi enviado via GET
if (isset($_GET['id'])) {
    $id = limpar_entrada($_GET['id']);

    // Consulta para obter os dados do tanque a ser atualizado
    $sql = "SELECT * FROM ativo_tanque WHERE id = $id";
    $result = $conn->query($sql);

    // Verifica se encontrou algum resultado
    if ($result->num_rows > 0) {
        // Extrai os dados da consulta
        $row = $result->fetch_assoc();

        // Constrói o formulário com os dados do tanque
        echo '<form action="atualizar_tanque1.php" method="post">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo 'Tag: <input type="text" name="tag" value="' . $row['tag'] . '"><br>';
        echo 'Fabricante: <input type="text" name="fabricante" value="' . $row['fabricante'] . '"><br>';
        echo 'Ano de Fabricação: <input type="text" name="anoFabricacao" value="' . $row['anoFabricacao'] . '"><br>';
        echo 'Localização: <input type="text" name="localizacao" value="' . $row['localizacao'] . '"><br>';
        echo 'Capacidade Volumétrica: <input type="text" name="capacidadeVolumetrica" value="' . $row['capacidadeVolumetrica'] . '"><br>';
        echo 'Foto: <input type="text" name="foto" value="' . $row['foto'] . '"><br>';
        echo '<input type="submit" value="Atualizar">';
        echo '</form>';
    } else {
        echo "Tanque não encontrado.";
    }
} else {
    echo "ID do tanque não fornecido.";
}

// Fecha a conexão
$conn->close();
?>
