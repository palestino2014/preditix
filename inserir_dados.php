<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Preparar e executar a inserção no banco de dados
   $stmt = $conn->prepare("INSERT INTO ativo_caminhao (foto, placa, fabricante, modelo, ano_fabricacao, chassis, renavam, cor) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssisss", $foto, $placa, $fabricante, $modelo, $ano_fabricacao, $chassis, $renavam, $cor);

    // Atribuir valores aos parâmetros
    $foto = $_FILES["foto"]["name"]; // Nome do arquivo de imagem
    $placa = $_POST["placa"];
    $fabricante = $_POST["fabricante"];
    $modelo = $_POST["modelo"];
    $anoFabricacao = $_POST["ano_fabricacao"];
    $chassis = $_POST["chassis"];
    $renavam = $_POST["renavam"];
    $cor = $_POST["cor"];


    // Executar a instrução preparada
    if ($stmt->execute()) {
        echo "<p>Registro inserido com sucesso.</p>";
    } else {
        echo "<p>Erro ao inserir registro: " . $stmt->error . "</p>";
    }

    // Fechar a instrução preparada e a conexão
    $stmt->close();
    $conn->close();
}
?>
