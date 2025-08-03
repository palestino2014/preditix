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
        $stmt = $conn->prepare("SELECT tipo_veiculo, tag, placa, fabricante, modelo, ano_fabricacao, chassis, renavam, proprietario, tara, lotacao, PTB, PBTC, cor, foto FROM ativo_veiculo WHERE id = ?");
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

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Veículo</title>
    <!-- Adicione estilos conforme necessário -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .form-container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="file"] {
            margin-top: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Atualizar Veículo</h1>

    <?php
    // Exibir mensagens de erro ou sucesso
    if ($mensagem_erro) {
        echo "<p style='color: red;'>$mensagem_erro</p>";
    } elseif ($mensagem_sucesso) {
        echo "<p style='color: green;'>$mensagem_sucesso</p>";
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" required>

        <input type="submit" value="Buscar">
    </form>

    <?php if (isset($tipo_veiculo)) { ?>
        <form action="atualizar_veiculo.php" method="post" enctype="multipart/form-data">
            <label for="tipo_veiculo">Tipo de Veículo:</label>
            <select id="tipo_veiculo" name="tipo_veiculo" required>
                <option value="caminhaoTocoComBau" <?php echo ($tipo_veiculo == "caminhaoTocoComBau") ? "selected" : ""; ?>>Caminhão toco com baú</option>
                <option value="cavaloMecanicoEixoSimples" <?php echo ($tipo_veiculo == "cavaloMecanicoEixoSimples") ? "selected" : ""; ?>>Cavalo mecânico - Eixo simples</option>
                <option value="VeiculoLeveAdm" <?php echo ($tipo_veiculo == "VeiculoLeveAdm") ? "selected" : ""; ?>>Veículo Leve ADM</option>
                <option value="VeiculoLeveDeCarga" <?php echo ($tipo_veiculo == "VeiculoLeveDeCarga") ? "selected" : ""; ?>>Veículo leve de carga</option>
            </select>

            <label for="tag">TAG:</label>
            <input type="text" id="tag" name="tag" value="<?php echo $tag; ?>" required>

            <!-- Outros campos do formulário... -->

            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*">
            <input type="hidden" name="foto_atual" value="<?php echo $foto; ?>">

            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" value="Atualizar">
        </form>
    <?php } ?>
</div>

</body>
</html>
