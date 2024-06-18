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
    $tipo_implemento = limpar_entrada($_POST["tipo_implemento"]);
    $vincular = limpar_entrada($_POST["vincular"]);
    $tag = limpar_entrada($_POST["tag"]);
    $placa = limpar_entrada($_POST["placa"]);
    $fabricante = limpar_entrada($_POST["fabricante"]);
    $modelo = limpar_entrada($_POST["modelo"]);
    $ano_fabricao = limpar_entrada($_POST["ano_fabricao"]);
    $chassis = limpar_entrada($_POST["chassis"]);
    $renavam = limpar_entrada($_POST["renavam"]);
    $proprietario = limpar_entrada($_POST["proprietario"]);
    $tara = limpar_entrada($_POST["tara"]);
    $lotacao = limpar_entrada($_POST["lotacao"]);
    $PTB = limpar_entrada($_POST["PTB"]);
    $capacidadeMaxTracao = limpar_entrada($_POST["capacidadeMaxTracao"]);
    $capacidadeVolumetrica = limpar_entrada($_POST["capacidadeVolumetrica"]);
    $cor = limpar_entrada($_POST["cor"]);
    $foto = limpar_entrada($_POST["foto"]);

    // Query SQL para atualizar os dados do implemento no banco de dados
    $sql = "UPDATE ativo_implemento SET 
            tipo_implemento = '$tipo_implemento', 
            vincular = '$vincular', 
            tag = '$tag', 
            placa = '$placa', 
            fabricante = '$fabricante', 
            modelo = '$modelo', 
            ano_fabricao = '$ano_fabricao', 
            chassis = '$chassis', 
            renavam = '$renavam', 
            proprietario = '$proprietario', 
            tara = '$tara', 
            lotacao = '$lotacao', 
            PTB = '$PTB', 
            capacidadeMaxTracao = '$capacidadeMaxTracao', 
            capacidadeVolumetrica = '$capacidadeVolumetrica', 
            cor = '$cor', 
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
