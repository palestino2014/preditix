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

    // Verificar as checkboxes - Sistemas afetados
    $cabineCheckbox = isset($_POST['cabineCheckbox']) ? 1 : 0;
    $direcaoCheckbox = isset($_POST['direcaoCheckbox']) ? 1 : 0;
    $combustivelCheckbox = isset($_POST['combustivelCheckbox']) ? 1 : 0;
    $medicaoControleCheckbox = isset($_POST['medicaoControleCheckbox']) ? 1 : 0;
    $protecaoImpactosCheckbox = isset($_POST['protecaoImpactosCheckbox']) ? 1 : 0;
    $transmissaoCheckbox = isset($_POST['transmissaoCheckbox']) ? 1 : 0;
    $estruturalCheckbox = isset($_POST['estruturalCheckbox']) ? 1 : 0; 
    $controleEletronicoCheckbox = isset($_POST['controleEletronicoCheckbox']) ? 1 : 0;  
    $acoplamentoCheckbox = isset($_POST['acoplamentoCheckbox']) ? 1 : 0;
    $exaustaoCheckbox = isset($_POST['exaustaoCheckbox']) ? 1 : 0;
    $propulsaoCheckbox = isset($_POST['propulsaoCheckbox']) ? 1 : 0;
    $protecaoContraIncendioCheckbox = isset($_POST['protecaoContraIncendioCheckbox']) ? 1 : 0;
    $ventilacaoCheckbox = isset($_POST['ventilacaoCheckbox']) ? 1 : 0;
    $tanqueCheckbox = isset($_POST['tanqueCheckbox']) ? 1 : 0;
    $arrefecimentoCheckbox = isset($_POST['arrefecimentoCheckbox']) ? 1 : 0;
    $descargaCheckbox = isset($_POST['descargaCheckbox']) ? 1 : 0;
    $freiosCheckbox = isset($_POST['freiosCheckbox']) ? 1 : 0;
    $protecaoAmbientalCheckbox = isset($_POST['protecaoAmbientalCheckbox']) ? 1 : 0;
    $suspensaoCheckbox = isset($_POST['suspensaoCheckbox']) ? 1 : 0; 
    $eletricoCheckbox = isset($_POST['eletricoCheckbox']) ? 1 : 0;   
    
    // Preparar e executar a instrução de inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO os_veiculo (
        odometer, start_date, start_time, end_date, end_time, maintenance_type, cabine, direcao, combustivel, medicao_controle, protecao_impactos, transmissao, estrutural, controle_eletronico, acoplamento,
        exaustao, propulsao, protecao_contra_incendio, ventilacao, tanque, arrefecimento, descarga, freios, protecao_ambiental,suspensao,eletrico)
         VALUES (? , ? , ? , ? , ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verificar se a preparação da instrução foi bem-sucedida
    if (!$stmt) {
        die('Erro na preparação da consulta: ' . $conn->error);
    }

    // Modificar a string de definição de tipo para corresponder ao número correto de parâmetros
    $stmt->bind_param("ssssssiiiiiiiiiiiiiiiiiiii",
        $odometerValue, $maintenanceStartDate, $maintenanceStartTime, $maintenanceEndDate, $maintenanceFinishTime, $maintenanceType, $cabineCheckbox, $direcaoCheckbox, $combustivelCheckbox, $medicaoControleCheckbox, $protecaoImpactosCheckbox,$transmissaoCheckbox,$estruturalCheckbox,$controleEletronicoCheckbox,
        $acoplamentoCheckbox , $exaustaoCheckbox , $propulsaoCheckbox , $protecaoContraIncendioCheckbox,$ventilacaoCheckbox, $tanqueCheckbox, $arrefecimentoCheckbox ,$descargaCheckbox,$freiosCheckbox,
        $protecaoAmbientalCheckbox,$suspensaoCheckbox,$eletricoCheckbox);

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
