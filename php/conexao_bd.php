<?php
// Configurações do banco de dados (ajuste conforme necessário)
$hostname = "localhost";
$username = "root";
$password = "Preditix@123";
$database = "manutencao_px";

// Conectar ao banco de dados
$conn = new mysqli($hostname, $username, $password, $database);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}
?>
