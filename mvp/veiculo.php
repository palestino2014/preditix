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
  <title>Veículo</title>
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
      font-size: 20px;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <a type="button" href="http://auto.dev.br/mvp/">Voltar</a>

    <h1>Veículo</h1>

    <form action="inserir_veiculos.php" method="post" enctype="multipart/form-data">
    
       <label for="tipo_veiculo">Tipo de Veículo:</label>
      		<select id="tipo_veiculo" name="tipo_veiculo" required>
        			<option value="caminhão toco">Caminhão toco</option>
        			<option value="cavalo mecânico eixo simples">Cavalo mecânico - Eixo simples</option>
        			<option value="cavalo mecânico trucado">Cavalo mecânico - Trucado</option>
       			<option value="Veiculo leve administrativo">Veículo leve administrativo</option>
       			<option value="Veiculo leve de carga">Veículo leve operacional</option>
      		</select>
    
     
 		<label for="tag">TAG:</label>
      <input type="text" id="tag" name="tag" required>     
     
 		<label for="placa">Placa:</label>
      <input type="text" id="placa" name="placa" required>
      
      <label for="fabricante">Fabricante:</label>
      <input type="text" id="fabricante" name="fabricante" required>
      
      <label for="modelo">Modelo:</label>
      <input type="text" id="modelo" name="modelo" required>
      
      <label for="ano_fabricacao">Ano de Fabricação:</label>
      <input type="text" id="ano_fabricacao" name="ano_fabricacao" required>
    
      <label for="chassis">Chassi:</label>
      <input type="text" id="chassis" name="chassis" required>

      <label for="renavam">Renavam:</label>
      <input type="text" id="renavam" name="renavam" required>
      
      <label for="proprietario">Proprietário:</label>
      <input type="text" id="proprietario" name="proprietario" required>
      
      <label for="Tara">Tara [kg]:</label>
      <input type="number" id="tara" name="tara" required>
      
      <label for="Lotação">Lotação [kg]:</label>
      <input type="number" id="lotacao" name="lotacao">   
      
      <label for="PTB">Peso Bruto Total (PBT) [kg]:</label>
      <input type="number" id="PTB" name="PTB">   
      
      <label for="PBTC">Peso Bruto Total Combinado (PBTC):</label>
      <input type="number" id="PBTC" name="PBTC">  
      
      <label for="CMT">Capacidade máxima de tração (CMT) [kg]:</label>
      <input type="number" id="CMT" name="CMT">  
      
      <label for="cor">Cor:</label>
      <input type="text" id="cor" name="cor">     
      
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
