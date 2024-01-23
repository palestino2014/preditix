<?php
    // Incluir o script de conexão
    include "conexao_bd.php";

    // Consulta SQL para obter todos os dados da tabela
    $ativo_embarcacao = $conn->query("SELECT * FROM ativo_embarcacao");
    $ativo_implemento = $conn->query("SELECT * FROM ativo_implemento");
    $ativo_tanque = $conn->query("SELECT * FROM ativo_tanque");
    $ativo_veiculo = $conn->query("SELECT * FROM ativo_veiculo");

    // Verifica se há resultados
    if ($ativo_embarcacao || $ativo_implemento || $ativo_tanque || $ativo_veiculo -> num_rows > 0) {
?>
  <!DOCTYPE html>
    <html lang="pt-br">
      <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HOME</title>
        <style>
        body {
            font-family: Arial, sans-serif;
          }

          .form-container {
            width: 80%;
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
          ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #e0dfdf;
          }
          
          li {
            float: left;
          }

          li a {
            display: block;
            color: rgb(75, 75, 75);
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
          }
          
          li a:hover:not(.active) {
            background-color: #b4b4b4;
            color: rgb(255, 255, 255);
          }
          
          .active {
            background-color: #4CAF50;
            color: rgb(255, 255, 255);

          }

          .view {
            margin: auto;
            width: auto;
          }
          
          .wrapper {
            position: relative;
            overflow: auto;
            white-space: nowrap;
          }
          
          .sticky-col {
            position: -webkit-sticky;
            position: sticky;
            background-color: rgb(245, 245, 245);
          }
          
          .first-col {
            left: 0px;
          }
          
          .second-col {
            left: 100px;
          }

          tr:nth-child(even) {
            background-color: #f2f2f2;
          }

          table, th, td {
            border: 1px solid rgb(219, 219, 219);
            border-collapse: collapse;
          }

          .center {
            margin-left: auto;
            margin-right: auto;
          }

          .disabled{
            pointer-events: none;
          }
        </style>
      </head>
      <body>

        <div class="form-container">
          <ul>
            <li><a class="active" href="index.php">Home</a></li>
            <li><a href="ativos.html">Ativos</a></li>
            <li><a href="#contact">Ordens de serviço</a></li>
            <li><a class="disabled">|</a></li>
            <li><a href="index.html">Solicitar manutenção</a></li>
            <li><a href="ativos.html">Cadastrar ativos</a></li>
          </ul>
          <br>
          <div style="overflow-x: auto;" class="view">
            <div class="wrapper">
              <h2>Embarcações</h2>
              <table class="center">
                <thead>
                  <tr>
                    <th class="sticky-col first-col">ID</th>
                    <th>Tipo de Embarcação</th>
                    <th>Número de Inscrição</th>
                    <th>Fabricante</th>
                    <th>Armador</th>
                    <th>Ano de Fabricação</th>
                    <th>Capacidade Volumétrica</th>
                    <th>Foto</th>
                    <th>Editar</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="sticky-col first-col">ID</th>
                    <th>Tipo de Embarcação</th>
                    <th>Número de Inscrição</th>
                    <th>Fabricante</th>
                    <th>Armador</th>
                    <th>Ano de Fabricação</th>
                    <th>Capacidade Volumétrica</th>
                    <th>Foto</th>
                    <th>Editar</th>
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                    // Loop através dos resultados e exibir cada linha na tabela
                    while ($row = $ativo_embarcacao->fetch_assoc()) {
                      ?>
                        <tr>
                            <td class="sticky-col first-col"><?= $row["id"] ?></td>
                            <td><?= $row["tipo_embarcacao"] ?></td>
                            <td><?= $row["num_inscricao"] ?></td>
                            <td><?= $row["fabricante"] ?></td>
                            <td><?= $row["armador"] ?></td>
                            <td><?= $row["ano_fabricacao"] ?></td>
                            <td><?= $row["capacidade_volumetrica"] ?></td>
                            <td><?= $row["foto"] ?></td>
                            <th><a href="./atualizar_embarcacao.php">&#9998;</a></th>
                            <!-- Adicione mais colunas conforme necessário -->
                        </tr>
                      <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>

            <div class="wrapper">
              <h2>Implementos</h2>
              <table class="center">
                <thead>
                    <tr>
                        <th class="sticky-col first-col">ID</th>
                        <th>Tipo de Implemento</th>
                        <th>TAG</th>
                        <th>Placa</th>
                        <th>Fabricante</th>
                        <th>Modelo</th>
                        <th>Ano de Fabricação</th>
                        <th>Editar</th>
                        <!-- Adicione mais colunas conforme necessário -->
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="sticky-col first-col">ID</th>
                        <th>Tipo de Implemento</th>
                        <th>TAG</th>
                        <th>Placa</th>
                        <th>Fabricante</th>
                        <th>Modelo</th>
                        <th>Ano de Fabricação</th>
                        <th>Editar</th>
                        <!-- Adicione mais colunas conforme necessário -->
                    </tr>
                </tfoot>
                <tbody>
                  <?php
                    // Loop através dos resultados e exibir cada linha na tabela
                    while ($row = $ativo_implemento->fetch_assoc()) {
                      ?>
                        <tr>
                            <td class="sticky-col first-col"><?= $row["id"] ?></td>
                            <td><?= $row["tipo_implemento"] ?></td>
                            <td><?= $row["tag"] ?></td>
                            <td><?= $row["placa"] ?></td>
                            <td><?= $row["fabricante"] ?></td>
                            <td><?= $row["modelo"] ?></td>
                            <td><?= $row["ano_fabricao"] ?></td>
                            <th><a href="./atualizar_implemento.php">&#9998;</a></th>
                            <!-- Adicione mais colunas conforme necessário -->
                        </tr>
                      <?php
                    }
                  ?>
                </tbody>
              </table>
            </div>

            <div class="wrapper">
              <h2>Tanques</h2>
              <table class="center">
                <thead>
                  <tr>
                      <th class="sticky-col first-col">ID</th>
                      <th>TAG</th>
                      <th>Fabricante</th>
                      <th>Ano de Fabricação</th>
                      <th>Localização</th>
                      <th>Capacidade Volumétrica</th>
                      <th>Foto</th>
                      <th>Editar</th>
                      <!-- Adicione mais colunas conforme necessário -->
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                      <th class="sticky-col first-col">ID</th>
                      <th>TAG</th>
                      <th>Fabricante</th>
                      <th>Ano de Fabricação</th>
                      <th>Localização</th>
                      <th>Capacidade Volumétrica</th>
                      <th>Foto</th>
                      <th>Editar</th>
                      <!-- Adicione mais colunas conforme necessário -->
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  // Loop através dos resultados e exibir cada linha na tabela
                  while ($row = $ativo_tanque->fetch_assoc()) {
                      ?>
                      <tr>
                          <td class="sticky-col first-col"><?= $row["id"] ?></td>
                          <td><?= $row["tag"] ?></td>
                          <td><?= $row["fabricante"] ?></td>
                          <td><?= $row["anoFabricacao"] ?></td>
                          <td><?= $row["localizacao"] ?></td>
                          <td><?= $row["capacidadeVolumetrica"] ?></td>
                          <td><?= $row["foto"] ?></td>
                          <th><a href="./atualizar_tanque.php">&#9998;</a></th>
                          <!-- Adicione mais colunas conforme necessário -->
                      </tr>
                      <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
            
            <div class="wrapper">
              <h2>Veículos</h2>
              <table class="center">
                <thead>
                  <tr>
                      <th class="sticky-col first-col">ID</th>
                      <th>Tipo de Veículo</th>
                      <th>TAG</th>
                      <th>Placa</th>
                      <th>Fabricante</th>
                      <th>Modelo</th>
                      <th>Ano de Fabricação</th>
                      <th>Chassis</th>
                      <th>Renavam</th>
                      <th>Proprietário</th>
                      <th>Tara</th>
                      <th>Lotação</th>
                      <th>PBT</th>
                      <th>PBTC</th>
                      <th>Cor</th>
                      <th>Editar</th>
                      <!-- Adicione mais colunas conforme necessário -->
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                      <th class="sticky-col first-col">ID</th>
                      <th>Tipo de Veículo</th>
                      <th>TAG</th>
                      <th>Placa</th>
                      <th>Fabricante</th>
                      <th>Modelo</th>
                      <th>Ano de Fabricação</th>
                      <th>Chassis</th>
                      <th>Renavam</th>
                      <th>Proprietário</th>
                      <th>Tara</th>
                      <th>Lotação</th>
                      <th>PBT</th>
                      <th>PBTC</th>
                      <th>Cor</th>
                      <th>Editar</th>
                      <!-- Adicione mais colunas conforme necessário -->
                  </tr>
                </tfoot>
                <tbody>
                  <?php
                  // Loop através dos resultados e exibir cada linha na tabela
                  while ($row = $ativo_veiculo->fetch_assoc()) {
                      ?>
                          <tr>
                              <td class="sticky-col first-col"><?= $row["id"] ?></td>
                              <td><?= $row["tipo_veiculo"] ?></td>
                              <td><?= $row["tag"] ?></td>
                              <td><?= $row["placa"] ?></td>
                              <td><?= $row["fabricante"] ?></td>
                              <td><?= $row["modelo"] ?></td>
                              <td><?= $row["ano_fabricacao"] ?></td>
                              <td><?= $row["chassis"] ?></td>
                              <td><?= $row["renavam"] ?></td>
                              <td><?= $row["proprietario"] ?></td>
                              <td><?= $row["tara"] ?></td>
                              <td><?= $row["lotacao"] ?></td>
                              <td><?= $row["PTB"] ?></td>
                              <td><?= $row["PBTC"] ?></td>
                              <td><?= $row["cor"] ?></td>
                              <th><a href="./atualizar_veiculo.php">&#9998;</a></th>
                              <!-- Adicione mais colunas conforme necessário -->
                          </tr>
                      <?php
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </body>
    </html>
<?php
    } else {
        echo "Dados não encontrados.";
    }

    // Fechar a consulta
    $ativo_embarcacao->close();
    $ativo_implemento->close();
    $ativo_tanque->close();
    $ativo_veiculo->close();

    // Fechar a conexão
    $conn->close();
?>
