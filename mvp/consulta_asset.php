<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Consulta SQL para obter todos os dados da tabela
$consulta = $conn->query("SELECT * FROM ativo_embarcacao WHERE tag = ?");

// Verifica se há resultados
if ($consulta->num_rows > 0) {

} else {
    echo "Nenhum implemento encontrado.";
}

// Fechar a consulta
$consulta->close();

// Fechar a conexão
$conn->close();
?>

<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Variáveis para armazenar mensagens de erro e sucesso
$mensagem_erro = "";
$mensagem_sucesso = "";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o ID foi fornecido
    if (isset($_POST["id"])) {
        $id = $_POST["id"];

        // Consultar o banco de dados para obter os dados do registro
        $stmt = $conn->prepare("SELECT * FROM ativo_embarcacao WHERE id = ?");
        $stmt->bind_param("i", $id);

        // Executar a instrução preparada
        $stmt->execute();

        // Bind das variáveis de resultado
        $stmt->bind_result($tipo_veiculo, $tag, $placa, $fabricante, $modelo, $ano_fabricacao, $chassis, $renavam, $proprietario, $tara, $lotacao, $PTB, $PBTC, $cor, $foto);

        // Obter os resultados
        $stmt->fetch();

        // Fechar a instrução preparada
        $stmt->close();
    } else {
        $mensagem_erro = "Por favor, forneça um ID válido.";
    }
}

// Fechar a conexão
$conn->close();
?>