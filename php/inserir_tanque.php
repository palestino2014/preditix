<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Atribuir valores aos parâmetros antes de preparar a instrução
    $tag = $_POST["tag"];
    $fabricante = $_POST["fabricante"];
    $anoFabricacao = $_POST["anoFabricacao"];
    $localizacao = $_POST["localizacao"];
    $capacidadeVolumetrica = $_POST["capacidadeVolumetrica"];
    $foto = $_FILES["foto"]["name"];

    // Preparar e executar a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO ativo_tanque (tag, fabricante, anoFabricacao, localizacao, capacidadeVolumetrica, foto) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssss", $tag, $fabricante, $anoFabricacao, $localizacao, $capacidadeVolumetrica, $foto);

    // Executar a instrução preparada
    if ($stmt->execute()) {
        echo "<p>Dados inseridos com sucesso.</p>";
    } else {
        echo "<p>Erro ao inserir dados: " . $stmt->error . "</p>";
    }

    // Fechar a instrução preparada
    $stmt->close();
}

// Fechar a conexão
$conn->close();
?>
