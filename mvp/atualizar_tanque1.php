<?php

// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se os dados do formulário foram submetidos via método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Função para evitar XSS
    function limpar_entrada($entrada) {
        $entrada = trim($entrada);
        $entrada = stripslashes($entrada);
        $entrada = htmlspecialchars($entrada);
        return $entrada;
    }

    // Limpar e validar os dados do formulário
    $id = limpar_entrada($_POST["id"]);
    $tag = limpar_entrada($_POST["tag"]);
    $fabricante = limpar_entrada($_POST["fabricante"]);
    $anoFabricacao = limpar_entrada($_POST["anoFabricacao"]);
    $localizacao = limpar_entrada($_POST["localizacao"]);
    $capacidadeVolumetrica = limpar_entrada($_POST["capacidadeVolumetrica"]);
    $foto = limpar_entrada($_POST["foto"]);

    // Query SQL para atualizar os dados do tanque no banco de dados
    $sql = "UPDATE ativo_tanque SET 
            tag = '$tag', 
            fabricante = '$fabricante', 
            anoFabricacao = '$anoFabricacao', 
            localizacao = '$localizacao', 
            capacidadeVolumetrica = '$capacidadeVolumetrica', 
            foto = '$foto'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Registro atualizado com sucesso.";
    } else {
        echo "Erro ao atualizar o registro: " . $conn->error;
    }
}

// Fecha a conexão
$conn->close();
?>
