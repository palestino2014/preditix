<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atribuir valores aos parâmetros antes de preparar a instrução
    $tipo_veiculo = $_POST["tipo_veiculo"];
    $tag = $_POST["tag"];
    $placa = $_POST["placa"];
    $fabricante = $_POST["fabricante"];
    $modelo = $_POST["modelo"];
    $ano_fabricacao = $_POST["ano_fabricacao"]; // Corrigir o nome do campo
    $chassis = $_POST["chassis"];
    $renavam = $_POST["renavam"];
    $proprietario = $_POST["proprietario"];
    $tara = $_POST["tara"];
    $lotacao = $_POST["lotacao"];
    $PTB = $_POST["PTB"];
    $PBTC = $_POST["PBTC"];
    $cor = $_POST["cor"];
    $foto = $_FILES["foto"]["name"];

    // Preparar e executar a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO ativo_veiculo (tipo_veiculo, tag, placa, fabricante, modelo, ano_fabricacao, chassis, renavam, proprietario, tara, lotacao, PTB, PBTC, cor, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssisssssssss", $tipo_veiculo, $tag, $placa, $fabricante, $modelo, $ano_fabricacao, $chassis, $renavam, $proprietario, $tara, $lotacao, $PTB, $PBTC, $cor, $foto);

    // Executar a instrução preparada
    if ($stmt->execute()) {
        echo "<p>Registro inserido com sucesso.</p>";
    } else {
        echo "<p>Erro ao inserir registro: " . $stmt->error . "</p>";
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
}
?>
