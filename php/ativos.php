<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ativos</title>
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
      <li><a href="index.html">Home</a></li>
      <li><a class="active" href="#news">Ativos</a></li>
      <li><a href="#contact">Ordens de serviço</a></li>
    </ul>
  <br>
    <ul>
      <li><a href="embarcacao.html">Cadastrar Embarcação</a></li>
      <li><a href="implemento.html">Cadastrar Implemento</a></li>
      <li><a href="tanques.html">Cadastrar Tanque</a></li>
      <li><a href="veiculo.html">Cadastrar Veículo</a></li>
    </ul>
    <br>
    <div style="overflow-x: auto;" class="view">
      <div class="wrapper">
      <table class="center">
        <thead>
          <tr>
            <th class="sticky-col first-col">First Name</th>
            <th>Last Name</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <th class="sticky-col first-col">First Name</th>
            <th>Last Name</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
            <th>Points</th>
          </tr>
        </tfoot>
        <tr>
          <td class="sticky-col first-col">Jill</td>
          <td>Smith</td>
          <td>50</td>
          <td>50</td>
          <td>50</td>
          <td>50</td>
          <td>50</td>
          <td>50</td>
          <td>50</td>
          <td>50</td>
          <td>50</td>
          <td>50</td>
        </tr>
        <tr>
          <td class="sticky-col first-col">Eve</td>
          <td>Jackson</td>
          <td>94</td>
          <td>94</td>
          <td>94</td>
          <td>94</td>
          <td>94</td>
          <td>94</td>
          <td>94</td>
          <td>94</td>
          <td>94</td>
          <td>94</td>
        </tr>
        <tr>
          <td class="sticky-col first-col">Adam</td>
          <td>Johnson</td>
          <td>67</td>
          <td>67</td>
          <td>67</td>
          <td>67</td>
          <td>67</td>
          <td>67</td>
          <td>67</td>
          <td>67</td>
          <td>67</td>
          <td>67</td>
        </tr>
      </table>
    </div>
    </div>
  </div>

</body>
</html>

