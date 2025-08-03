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
  <title>Implemento rodoviário</title>
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
    <h1>Implemento rodoviário</h1>

    <form action="inserir_implemento.php" method="post" enctype="multipart/form-data">
    
       <label for="tipo_implemento">Tipo de implemento rodoviário</label>
      		<select id="tipo_implemento" name="tipo_implemento" required>
        			<option value="Tanque semirreboque 2 eixos">Semirreboque tanque - 2 eixos</option>
        			<option value="tanque semirreboque 3 eixos">Semirreboque tanque - 3 eixos</option>
        			<option value="Tanque semirreboque com 5ª roda traseira">Semirreboque tanque com 5ª roda traseira - 3 eixos</option>
       			<option value="Comboio de abastecimento">Comboio de abastecimento</option>
       			<option value="Baú">Baú</option>
       		</select>
       		
    	<label for="vincular">Vincular:</label>
      <input type="text" id="vincular" name="vincular" required>   		
    
     
 		<label for="tag">TAG:</label>
      <input type="text" id="tag" name="tag" required>     
     
 		<label for="placa">Placa:</label>
      <input type="text" id="placa" name="placa" required>
      
      <label for="fabricante">Fabricante:</label>
      <input type="text" id="fabricante" name="fabricante" required>
      
      <label for="modelo">Modelo:</label>
      <input type="text" id="modelo" name="modelo" required>
      
     <label for="ano_fabricao">Ano de Fabricação:</label>
     <input type="number" id="ano_fabricao" name="ano_fabricao" required>

    
      <label for="chassis">Chassi:</label>
      <input type="text" id="chassis" name="chassis" required>

      <label for="renavam">Renavam:</label>
      <input type="text" id="renavam" name="renavam" required>
      
      <label for="proprietario">Proprietário:</label>
      <input type="text" id="proprietario" name="proprietario" required>
      
      <label for="Tara">Tara [kg]:</label>
      <input type="text" id="tara" name="tara">
      
      <label for="Lotação">Lotação [kg]:</label>
      <input type="text" id="lotacao" name="lotacao">   
      
      <label for="PTB">Peso Bruto Total (PBT) [kg]:</label>
      <input type="text" id="PTB" name="PTB">   
                
      <label for="capacidadeMaxTracao">Capacidade Máxima de Tração (CMT) [kg]:</label>
      <input type="text" id="capacidadeMaxTracao" name="capacidadeMaxTracao">  
      
      <label for="capacidadeVolumetrica">Capacidade Volumétrica [L]:</label>
      <input type="text" id="capacidadeVolumetrica" name="capacidadeVolumetrica"> 
      
      <label for="cor">Cor:</label>
      <input type="text" id="cor" name="cor" >     
      
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