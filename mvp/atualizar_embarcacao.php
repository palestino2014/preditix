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

// Verifica se o ID da embarcação foi enviado via GET
if (isset($_GET['id'])) {
    $id = limpar_entrada($_GET['id']);

    // Consulta para obter os dados da embarcação a ser atualizada
    $sql = "SELECT * FROM ativo_embarcacao WHERE id = $id";
    $result = $conn->query($sql);

    // Verifica se encontrou algum resultado
    if ($result->num_rows > 0) {
        // Extrai os dados da consulta
        $row = $result->fetch_assoc();

        // Constrói o formulário com os dados da embarcação
        echo '<form action="atualizar_embarcacao1.php" method="post">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo 'Tipo de Embarcação: <input type="text" name="tipo_embarcacao" value="' . $row['tipo_embarcacao'] . '"><br>';
        echo 'Tag: <input type="text" name="tag" value="' . $row['tag'] . '"><br>';
        echo 'Número de Inscrição: <input type="text" name="num_inscricao" value="' . $row['num_inscricao'] . '"><br>';
        echo 'Nome: <input type="text" name="nome" value="' . $row['nome'] . '"><br>';
        echo 'Armador: <input type="text" name="armador" value="' . $row['armador'] . '"><br>';
        echo 'Ano de Fabricação: <input type="text" name="ano_fabricacao" value="' . $row['ano_fabricacao'] . '"><br>';
        echo 'Capacidade Volumétrica: <input type="text" name="capacidade_volumetrica" value="' . $row['capacidade_volumetrica'] . '"><br>';
        echo 'Foto: <input type="text" name="foto" value="' . $row['foto'] . '"><br>';
        echo '<input type="submit" value="Atualizar">';
        echo '</form>';
    } else {
        echo "Embarcação não encontrada.";
    }
} else {
    echo "ID da embarcação não fornecido.";
}

// Fecha a conexão
$conn->close();
?>
