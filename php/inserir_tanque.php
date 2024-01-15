<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

     // Preparar e executar a inserção no banco de dados
     
    $stmt = $conn->prepare("INSERT INTO ativo_tanque (tag, fabricante, anoFabricacao, capacidadeVolumetrica, foto) VALUES (?, ?, ?, ?, ?)");

    $stmt->bind_param("sssbs", $tag, $fabricante, $anoFabricacao, $capacidadeVolumetrica, $foto);

    // Atribuir valores aos parâmetros
    // Atribuir valores dos campos do formulário a variáveis
    $tag = $_POST["tag"];
    $fabricante = $_POST["fabricante"];
    $anoFabricacao = $_POST["anoFabricacao"];
    $capacidadeVolumetrica = $_POST["capacidadeVolumetrica"];
    $foto = $_FILES["foto"]["name"]; // Nome do arquivo de imagem

    // Executar a instrução preparada
    if ($stmt->execute()) {
        echo "<p>Dados inseridos com sucesso.</p>";
    } else {
        echo "<p>Erro ao inserir dados: " . $stmt->error . "</p>";
    }

    // Fechar a instrução preparada e a conexão
    $stmt->close();
}

// Fechar a conexão
$conn->close();
?>