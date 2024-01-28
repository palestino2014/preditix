<?php
// Configurações do banco de dados
$servername = "seu_servidor_mysql";
$username = "seu_usuario_mysql";
$password = "sua_senha_mysql";
$dbname = "seu_banco_de_dados";

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Recuperar os dados do formulário
$odometerValue = $_POST['odometerValue'];
$maintenanceStartDate = $_POST['maintenanceStartDate'];
$maintenanceStartTime = $_POST['maintenanceStartTime'];
$maintenanceEndDate = $_POST['maintenanceEndDate'];
$maintenanceFinishTime = $_POST['maintenanceFinishTime'];

// Inserir os dados no banco de dados
$sql = "INSERT INTO tabela_veiculo (odometer, start_date, start_time, end_date, end_time)
        VALUES ('$odometerValue', '$maintenanceStartDate', '$maintenanceStartTime', '$maintenanceEndDate', '$maintenanceFinishTime')";

if ($conn->query($sql) === TRUE) {
    echo "Dados inseridos com sucesso!";
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
