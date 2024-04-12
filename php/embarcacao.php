<?php
// Verificar se os cookies de autenticação estão definidos
if(isset($_COOKIE['usuario']) && isset($_COOKIE['autenticado'])) {
    // Verificar se os cookies correspondem ao usuário autenticado
    $usuario = $_COOKIE['usuario'];
    $autenticado = $_COOKIE['autenticado'];

    // Verificar se o usuário está autenticado
    if ($autenticado === 'true') {
        // Conteúdo da página protegido
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inserir Embarcação</title>
  <!-- Adicione seus estilos e scripts aqui -->
   
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
    <h1>Inserir Embarcação</h1>

    <form action="inserir_embarcacao.php" method="post" enctype="multipart/form-data">
      <!-- Seu formulário aqui -->    
      <label for="tipoEmbarcacao">Tipo de Embarcação:</label>
      <select id="tipo_embarcacao" name="tipo_embarcacao" required>
        <option value="balsa simples">Balsa Simples</option>
        <option value="balsa motorizada">Balsa Motorizada</option>
        <option value="empurrador">Empurrador</option>
      </select>
      
      <label for="tag">TAG:</label>
      <input type="text" id="tag" name="tag" required>  

      <label for="numInscricao">Inscrição:</label>
      <input type="text" id="num_inscricao" name="num_inscricao" maxlength="35" required>

      <label for="nome">Nome da embarcação:</label>
      <input type="text" id="nome" name="nome" maxlength="40" required>

      <label for="armador">Armador:</label>
      <input type="text" id="armador" name="armador" maxlength="50" required>
 
      <label for="anoFabricacao">Ano de Fabricação:</label>
      <input type="number" id="ano_fabricacao" name="ano_fabricacao" maxlength="20" required>

      <label for="capacidadeVolumetrica">Capacidade Volumétrica [L]:</label>
      <input type="number" id="capacidade_volumetrica" name="capacidade_volumetrica" maxlength="5">

      <label for="foto">Foto:</label>
      <input type="file" id="foto" name="foto" accept="image/*" maxlength="250">

      <input type="submit" value="Enviar">      
    </form>
  </div>
</body>
</html>

<?php
        // Fim do conteúdo da página protegido
        exit();
    }
}

// Se os cookies não estiverem definidos ou não corresponderem ao usuário autenticado, redirecionar para a página de login
header("Location: login.php");
exit();
?>
