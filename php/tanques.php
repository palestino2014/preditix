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
  <title>Tanque</title>
  <style>
    /* Adicione estilos conforme necessário */
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
    <h1>Tanques de armazenamento</h1>

    <form action="inserir_tanque.php" method="post" enctype="multipart/form-data">
    
      <label for="tag">TAG:</label>
      <input type="text" id="tag" name="tag" required>

      <label for="fabricante">Fabricante/Responsável técnico:</label>
      <input type="text" id="fabricante" name="fabricante" required>

      <label for="anoFabricacao">Ano de Fabricação:</label>
      <input type="number" id="anoFabricacao" name="anoFabricacao" required>
      
      <label for="localizacao">Localização:</label>
      <input type="text" id="localizacao" name="localizacao" required>

      <label for="capacidadeVolumetrica">Capacidade Volumétrica [L]:</label>
      <input type="text" id="capacidadeVolumetrica" name="capacidadeVolumetrica" required>

      <label for="foto">Foto:</label>
      <input type="file" id="foto" name="foto" accept="image/*">

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