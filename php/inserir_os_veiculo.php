<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Atribuir valores aos parâmetros antes de preparar a instrução
    $odometerValue = isset($_POST['odometerValue']) ? $_POST['odometerValue'] : '';
    echo "odometerValue: " . $odometerValue . "<br>";

    $maintenanceStartDate = isset($_POST['maintenanceStartDate']) ? $_POST['maintenanceStartDate'] : '';
    echo "maintenanceStartDate: " . $maintenanceStartDate . "<br>";

    $maintenanceStartTime = isset($_POST['maintenanceStartTime']) ? $_POST['maintenanceStartTime'] : '';
    echo "maintenanceStartTime: " . $maintenanceStartTime . "<br>";

    $maintenanceEndDate = isset($_POST['maintenanceEndDate']) ? $_POST['maintenanceEndDate'] : '';
    echo "maintenanceEndDate: " . $maintenanceEndDate . "<br>";

    $maintenanceFinishTime = isset($_POST['maintenanceFinishTime']) ? $_POST['maintenanceFinishTime'] : '';
    echo "maintenanceFinishTime: " . $maintenanceFinishTime . "<br>";

    $maintenanceType = isset($_POST['radio-maintenance']) ? $_POST['radio-maintenance'] : '';
    echo "maintenanceType: " . $maintenanceType . "<br>";

    $sistemasAfetados = [];

    $checkboxes = [
        'cabineCheckbox', 'combustivelCheckbox', 'direcaoCheckbox', 'medicaoControleCheckbox', 'protecaoImpactosCheckbox',
        'transmissaoCheckbox', 'estruturalCheckbox', 'acoplamentoCheckbox', 'controleEletronicoCheckbox', 'exaustaoCheckbox',
        'propulsaoCheckbox', 'protecaoContraIncendioCheckbox', 'ventilacaoCheckbox', 'tanqueCheckbox', 'arrefecimentoCheckbox',
        'descargaCheckbox', 'freiosCheckbox', 'protecaoAmbientalCheckbox', 'suspensaoCheckbox', 'eletricoCheckbox'
    ];

    foreach ($checkboxes as $checkbox) {
        if (isset($_POST[$checkbox])) {
            $sistemasAfetados[] = $checkbox;
        }
    }

    // Converter o vetor em uma string separada por vírgula
    $sistemasAfetadosString = implode(", ", $sistemasAfetados);

    echo "String sistemas afetados: " . $sistemasAfetadosString . "<br>";

    // Preparar e executar a instrução de inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO os_veiculo (
        odometer, start_date, start_time, end_date, end_time, maintenance_type, sistema_afetado) VALUES (
        ?, ?, ?, ?, ?, ?, ?)");

    // Verificar se a preparação da instrução foi bem-sucedida
    if ($stmt === false) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    // Modificar a string de definição de tipo para corresponder ao número correto de parâmetros
    $stmt->bind_param("sssssss",
        $odometerValue, $maintenanceStartDate, $maintenanceStartTime, $maintenanceEndDate, $maintenanceFinishTime, $maintenanceType, $sistemasAfetadosString);

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
