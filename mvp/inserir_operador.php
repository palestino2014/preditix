<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Atribuir valores aos parâmetros antes de preparar a instrução
    $nome = $_POST["nome"];
    $funcao = $_POST["funcao"];
    $matricula = $_POST["matricula"];

    // Preparar a instrução SQL
    $stmt = $conn->prepare("INSERT INTO operador (nome, funcao, matricula) VALUES (?, ?, ?)");

    // Verificar se a preparação da instrução foi bem-sucedida
    if ($stmt === false) {
        die("Erro na preparação da instrução SQL: " . $conn->error);
    }

    // Vincular os parâmetros
    $bindResult = $stmt->bind_param("sss", $nome, $funcao, $matricula);

    // Verificar se a vinculação foi bem-sucedida
    if ($bindResult === false) {
        die("Erro ao vincular parâmetros: " . $stmt->error);
    }

    // Executar a instrução preparada
    $executeResult = $stmt->execute();

    // Verificar se a execução foi bem-sucedida
    if ($executeResult) {
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
