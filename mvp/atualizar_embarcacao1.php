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
    $tipo_embarcacao = limpar_entrada($_POST["tipo_embarcacao"]);
    $tag = limpar_entrada($_POST["tag"]);
    $num_inscricao = limpar_entrada($_POST["num_inscricao"]);
    $nome = limpar_entrada($_POST["nome"]);
    $armador = limpar_entrada($_POST["armador"]);
    $ano_fabricacao = limpar_entrada($_POST["ano_fabricacao"]);
    $capacidade_volumetrica = limpar_entrada($_POST["capacidade_volumetrica"]);
    $foto = limpar_entrada($_POST["foto"]);

    // Query SQL para atualizar os dados da embarcação no banco de dados
    $sql = "UPDATE ativo_embarcacao SET 
            tipo_embarcacao = '$tipo_embarcacao', 
            tag = '$tag', 
            num_inscricao = '$num_inscricao', 
            nome = '$nome', 
            armador = '$armador', 
            ano_fabricacao = '$ano_fabricacao', 
            capacidade_volumetrica = '$capacidade_volumetrica', 
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
