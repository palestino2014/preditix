<?php
// Verificar se os dados do formulário foram enviados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se o usuário e senha estão corretos
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Verificar se o usuário é root@root e a senha é 123 (criptografada em MD5)
    if ($usuario === 'root@root' && md5($senha) === '202cb962ac59075b964b07152d234b70') {
        // Definir cookies de autenticação
        setcookie('usuario', $usuario, time() + 300); // Cookie expira em 5 minutos (300 segundos)
        setcookie('autenticado', 'true', time() + 300); // Cookie expira em 5 minutos (300 segundos)
        // Redirecionar para a página de inserir embarcação
        header("Location: index.php");
        exit();
    } else {
        // Se o usuário ou senha estiverem incorretos, exibir uma caixa de alerta em JavaScript
        echo "<script>alert('Usuário ou senha incorretos');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
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

    input[type="text"],
    input[type="password"],
    input[type="submit"] {
      width: 100%;
      padding: 8px;
      margin-bottom: 16px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      border: none;
      font-size: 16px;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h1>Login</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <label for="usuario">Usuário:</label>
      <input type="text" id="usuario" name="usuario" required>

      <label for="senha">Senha:</label>
      <input type="password" id="senha" name="senha" required>

      <input type="submit" value="Entrar">
    </form>
  </div>

</body>
</html>
