<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atribuir valores aos parâmetros antes de preparar a instrução
    $tipo_implemento = $_POST["tipo_implemento"];
    $vincular = $_POST["vincular"];
    $tag = $_POST["tag"];
    $placa = $_POST["placa"];
    $fabricante = $_POST["fabricante"];
    $modelo = $_POST["modelo"];
    $ano_fabricao = $_POST["ano_fabricao"];
    $chassis = $_POST["chassis"];
    $renavam = $_POST["renavam"];
    $proprietario = $_POST["proprietario"];
    $tara = $_POST["tara"];
    $lotacao = $_POST["lotacao"];
    $PTB = $_POST["PTB"];
   
    $capacidadeMaxTracao = $_POST["capacidadeMaxTracao"];
    $capacidadeVolumetrica = $_POST["capacidadeVolumetrica"];
    $cor = $_POST["cor"];
    $foto = $_FILES["foto"]["name"];

    // Chamar a função para inserção no banco de dados
    if (inserirImplemento($conn, $tipo_implemento, $vincular, $tag, $placa, $fabricante, $modelo, $ano_fabricao, $chassis, $renavam, $proprietario, $tara, $lotacao, $PTB, $capacidadeMaxTracao, $capacidadeVolumetrica, $cor, $foto)) {
        echo "<p>Registro inserido com sucesso.</p>";
    } else {
        echo "<p>Erro ao inserir registro.</p>";
    }

    // Fechar a conexão (se necessário)
    $conn->close();
}

// Função para inserir um implemento no banco de dados
function inserirImplemento($conexao, $tipo_implemento,$vincular , $tag, $placa, $fabricante, $modelo, $ano_fabricao, $chassis, $renavam, $proprietario, $tara, $lotacao, $PTB, $capacidadeMaxTracao, $capacidadeVolumetrica, $cor, $foto) {
    $stmt = $conexao->prepare("INSERT INTO ativo_implemento (tipo_implemento, vincular , tag, placa, fabricante, modelo, ano_fabricao, chassis, renavam, proprietario, tara, lotacao, PTB, capacidadeMaxTracao, capacidadeVolumetrica, cor, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssssissssssssss", $tipo_implemento, $vincular ,$tag, $placa, $fabricante, $modelo, $ano_fabricao, $chassis, $renavam, $proprietario, $tara, $lotacao, $PTB, $capacidadeMaxTracao, $capacidadeVolumetrica, $cor, $foto);

    return $stmt->execute();
}
?>
