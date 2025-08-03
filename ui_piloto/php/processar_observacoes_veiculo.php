<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_veiculo = $_POST["id_veiculo"];
    $observacoes = $_POST["observacoes"];

    // Inserir as observações na tabela
    $stmt = $conn->prepare("INSERT INTO observacoes_veiculo (id_veiculo, observacoes) VALUES (?, ?)");
    $stmt->bind_param("is", $id_veiculo, $observacoes);

    // Executar a instrução preparada
    if ($stmt->execute()) {
        echo "<p>Observações adicionadas com sucesso.</p>";
    } else {
        echo "<p>Erro ao adicionar observações: " . $stmt->error . "</p>";
    }

    // Fechar a instrução preparada
    $stmt->close();
}

// Fechar a conexão
$conn->close();
?>
