<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Atribuir valores aos parâmetros antes de preparar a instrução
    $odometerValue = isset($_POST['odometerValue']) ? $_POST['odometerValue'] : '';
    $maintenanceStartDate = isset($_POST['maintenanceStartDate']) ? $_POST['maintenanceStartDate'] : '';
    $maintenanceStartTime = isset($_POST['maintenanceStartTime']) ? $_POST['maintenanceStartTime'] : '';
    $maintenanceEndDate = isset($_POST['maintenanceEndDate']) ? $_POST['maintenanceEndDate'] : '';
    $maintenanceFinishTime = isset($_POST['maintenanceFinishTime']) ? $_POST['maintenanceFinishTime'] : '';
    $maintenanceType = isset($_POST['radio-maintenance']) ? $_POST['radio-maintenance'] : '';

    // Verificar as checkboxes
    $cabineCheckbox = isset($_POST['cabineCheckbox']) ? 1 : 0;
    $direcaoCheckbox = isset($_POST['direcaoCheckbox']) ? 1 : 0;
    $combustivelCheckbox = isset($_POST['combustivelCheckbox']) ? 1 : 0;

    // Preparar e executar a instrução de inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO os_veiculo (
        odometer, start_date, start_time, end_date, end_time, maintenance_type, cabine, combustivel, direcao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verificar se a preparação da instrução foi bem-sucedida
    if (!$stmt) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    // Modificar a string de definição de tipo para corresponder ao número correto de parâmetros
    $stmt->bind_param("ssssssiii",
        $odometerValue, $maintenanceStartDate, $maintenanceStartTime, $maintenanceEndDate, $maintenanceFinishTime, $maintenanceType, $cabineCheckbox, $combustivelCheckbox, $direcaoCheckbox);

    // Executar a instrução preparada
    if ($stmt->execute()) {
        echo "<p>Dados inseridos com sucesso.</p>";
    } else {
        echo "<p>Erro ao inserir dados: " . $stmt->error . "</p>";
    }

    // Fechar a instrução preparada
    $stmt->close();
}
?>
