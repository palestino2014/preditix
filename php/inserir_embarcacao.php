<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Atribuir valores aos parâmetros
    $tipo_embarcacao = $_POST["tipo_embarcacao"];
    $tag = $_POST["tag"];
    $num_inscricao = $_POST["num_inscricao"];
    $nome = $_POST["nome"];
    $armador = $_POST["armador"];
    $ano_fabricacao = $_POST["ano_fabricacao"];
    $fabricante = $_POST["fabricante"];
    $capacidade_volumetrica = $_POST["capacidade_volumetrica"];
    $foto = $_FILES["foto"]["name"]; // Nome do arquivo de imagem

    // Preparar e executar a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO ativo_embarcacao (tipo_embarcacao, tag, num_inscricao, nome, armador, fabricante, ano_fabricacao, capacidade_volumetrica, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verificar se a preparação foi bem-sucedida
    if ($stmt) {
        // Vincular parâmetros
        $stmt->bind_param("ssssssiss", $tipo_embarcacao, $tag, $num_inscricao, $nome, $armador, $fabricante, $ano_fabricacao, $capacidade_volumetrica, $foto);

        // Executar a instrução preparada
        if ($stmt->execute()) {
            echo "<p>Dados inseridos com sucesso.</p>";
        } else {
            echo "<p>Erro ao inserir dados: " . $stmt->error . "</p>";
        }

        // Fechar a instrução preparada
        $stmt->close();
    } else {
        echo "<p>Erro na preparação da instrução: " . $conn->error . "</p>";
    }

    // Fechar a conexão
    $conn->close();
}
?>

