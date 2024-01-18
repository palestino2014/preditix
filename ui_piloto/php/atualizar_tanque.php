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
        $stmt = $conn->prepare("SELECT tag, fabricante, anoFabricacao, localizacao, capacidadeVolumetrica, foto FROM ativo_tanque WHERE id = ?");
        $stmt->bind_param("i", $id);

        // Executar a instrução preparada
        $stmt->execute();

        // Bind das variáveis de resultado
        $stmt->bind_result($tag, $fabricante, $anoFabricacao, $localizacao, $capacidadeVolumetrica, $foto);

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
    <title>Atualizar Tanque</title>
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
    <h1>Atualizar Tanque</h1>

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

    <?php if (isset($tag)) { ?>
        <form action="atualizar_tanque.php" method="post" enctype="multipart/form-data">
            <label for="tag">TAG:</label>
            <input type="text" id="tag" name="tag" value="<?php echo $tag; ?>" required>

            <label for="fabricante">Fabricante:</label>
            <input type="text" id="fabricante" name="fabricante" value="<?php echo $fabricante; ?>" required>

            <label for="anoFabricacao">Ano de Fabricação:</label>
            <input type="date" id="anoFabricacao" name="anoFabricacao" value="<?php echo $anoFabricacao; ?>" required>

            <label for="localizacao">Localização:</label>
            <input type="text" id="localizacao" name="localizacao" value="<?php echo $localizacao; ?>" required>

            <label for="capacidadeVolumetrica">Capacidade Volumétrica:</label>
            <input type="text" id="capacidadeVolumetrica" name="capacidadeVolumetrica" value="<?php echo $capacidadeVolumetrica; ?>" required>

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
