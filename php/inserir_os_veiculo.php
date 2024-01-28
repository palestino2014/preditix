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
$maintenanceType = isset($_POST['radio-maintenance']) ? $_POST['radio-maintenance'] : '';
$cabineCheckbox = isset($_POST['cabineCheckbox']) ? 1 : 0;
$combustivelCheckbox = isset($_POST['combustivelCheckbox']) ? 1 : 0;
$direcaoCheckbox = isset($_POST['direcaoCheckbox']) ? 1 : 0;
// Adicione os demais checkboxes conforme necessário...

// Recuperar os dados adicionais
$componentesAfetados = $_POST['componentesAfetados'];
$sintomasDetectados = implode(", ", $_POST['sintomasDetectados']);
$descricaoDefeitoFalha = $_POST['descricaoDefeitoFalha'];
$causasDefeitoFalha = $_POST['causasDefeitoFalha'];

// Inserir os dados no banco de dados
$sql = "INSERT INTO tabela_veiculo (
    odometer, start_date, start_time, end_date, end_time, maintenance_type,
    cabine_checkbox, combustivel_checkbox, direcao_checkbox,
    componentes_afetados, sintomas_detectados, descricao_defeito_falha, causas_defeito_falha
) VALUES (
    '$odometerValue', '$maintenanceStartDate', '$maintenanceStartTime', '$maintenanceEndDate', '$maintenanceFinishTime', '$maintenanceType',
    '$cabineCheckbox', '$combustivelCheckbox', '$direcaoCheckbox',
    '$componentesAfetados', '$sintomasDetectados', '$descricaoDefeitoFalha', '$causasDefeitoFalha'
)";

if ($conn->query($sql) === TRUE) {
    echo "Dados inseridos com sucesso!";
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
