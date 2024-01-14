<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

     // Preparar e executar a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO ativo_embarcacao (tipo_embarcacao, num_inscricao, fabricante, armador, ano_fabricacao, capacidade_volumetrica, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssiss", $tipo_embarcacao, $num_inscricao, $fabricante, $armador, $ano_fabricacao, $capacidade_volumetrica, $foto);

    // Atribuir valores aos parâmetros
    $tipo_embarcacao = $_POST["tipo_embarcacao"];
    $num_inscricao = $_POST["num_inscricao"];
    $fabricante = $_POST["fabricante"];
    $armador = $_POST["armador"];
    $ano_fabricacao = $_POST["ano_fabricacao"];
    $capacidade_volumetrica = $_POST["capacidade_volumetrica"];
    $foto = $_FILES["foto"]["name"]; // Nome do arquivo de imagem

    // Executar a instrução preparada
    if ($stmt->execute()) {
        echo "<p>Dados inseridos com sucesso.</p>";
    } else {
        echo "<p>Erro ao inserir dados: " . $stmt->error . "</p>";
    }

    // Fechar a instrução preparada e a conexão
    $stmt->close();
    $conn->close();
}
?>

