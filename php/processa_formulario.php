<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dados do Formulário</title>
</head>
<body>

<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    
	 //quais sistemas afetados 
     // Atribuir valores aos parâmetros antes de preparar a instrução
    $odometerValue = isset($_POST['odometerValue']) ? $_POST['odometerValue'] : '';
    $maintenanceStartDate = isset($_POST['maintenanceStartDate']) ? $_POST['maintenanceStartDate'] : '';
    $maintenanceStartTime = isset($_POST['maintenanceStartTime']) ? $_POST['maintenanceStartTime'] : '';
    $maintenanceEndDate = isset($_POST['maintenanceEndDate']) ? $_POST['maintenanceEndDate'] : '';
    $maintenanceFinishTime = isset($_POST['maintenanceFinishTime']) ? $_POST['maintenanceFinishTime'] : '';
    $maintenanceType = isset($_POST['radio-maintenance']) ? $_POST['radio-maintenance'] : '';    
    
$cabineCheckbox = isset($_POST['cabineCheckbox']) ? "Cabine: Sim" : "Cabine: Não";
$direcaoCheckbox = isset($_POST['direcaoCheckbox']) ? "Direção: Sim" : "Direção: Não";
$combustivelCheckbox = isset($_POST['combustivelCheckbox']) ? "Combustível: Sim" : "Combustível: Não";
$medicaoControleCheckbox = isset($_POST['medicaoControleCheckbox']) ? "Medição e Controle: Sim" : "Medição e Controle: Não";
$protecaoImpactosCheckbox = isset($_POST['protecaoImpactosCheckbox']) ? "Proteção contra Impactos: Sim" : "Proteção contra Impactos: Não";
$transmissaoCheckbox = isset($_POST['transmissaoCheckbox']) ? "Transmissão: Sim" : "Transmissão: Não";
$estruturalCheckbox = isset($_POST['estruturalCheckbox']) ? "Estrutural: Sim" : "Estrutural: Não";
$controleEletronicoCheckbox = isset($_POST['controleEletronicoCheckbox']) ? "Controle Eletrônico: Sim" : "Controle Eletrônico: Não";
$acoplamentoCheckbox = isset($_POST['acoplamentoCheckbox']) ? "Acoplamento: Sim" : "Acoplamento: Não";
$exaustaoCheckbox = isset($_POST['exaustaoCheckbox']) ? "Exaustão: Sim" : "Exaustão: Não";
$propulsaoCheckbox = isset($_POST['propulsaoCheckbox']) ? "Propulsão: Sim" : "Propulsão: Não";
$protecaoContraIncendioCheckbox = isset($_POST['protecaoContraIncendioCheckbox']) ? "Proteção contra Incêndio: Sim" : "Proteção contra Incêndio: Não";
$ventilacaoCheckbox = isset($_POST['ventilacaoCheckbox']) ? "Ventilação: Sim" : "Ventilação: Não";
$tanqueCheckbox = isset($_POST['tanqueCheckbox']) ? "Tanque: Sim" : "Tanque: Não";
$arrefecimentoCheckbox = isset($_POST['arrefecimentoCheckbox']) ? "Arrefecimento: Sim" : "Arrefecimento: Não";
$descargaCheckbox = isset($_POST['descargaCheckbox']) ? "Descarga: Sim" : "Descarga: Não";
$freiosCheckbox = isset($_POST['freiosCheckbox']) ? "Freios: Sim" : "Freios: Não";
$protecaoAmbientalCheckbox = isset($_POST['protecaoAmbientalCheckbox']) ? "Proteção Ambiental: Sim" : "Proteção Ambiental: Não";
$suspensaoCheckbox = isset($_POST['suspensaoCheckbox']) ? "Suspensão: Sim" : "Suspensão: Não";
$eletricoCheckbox = isset($_POST['eletricoCheckbox']) ? "Elétrico: Sim" : "Elétrico: Não";
$componentesAfetados = isset($_POST['componentesAfetados']) ? "Componentes Afetados: " . $_POST['componentesAfetados'] : '';

    
    
    
    //sintomas detectados
    
    $abertoCheckbox = isset($_POST["abertoCheckbox"]) ? $_POST["abertoCheckbox"] : "";
    $desvioLateralCheckbox = isset($_POST["desvioLateralCheckbox"]) ? $_POST["desvioLateralCheckbox"] : "";
    $queimadoCheckbox = isset($_POST["queimadoCheckbox"]) ? $_POST["queimadoCheckbox"] : "";
    $semFreioCheckbox = isset($_POST["semFreioCheckbox"]) ? $_POST["semFreioCheckbox"] : "";
    $sujoCheckbox = isset($_POST["sujoCheckbox"]) ? $_POST["sujoCheckbox"] : "";
    $vazandoCheckbox = isset($_POST["vazandoCheckbox"]) ? $_POST["vazandoCheckbox"] : "";
    $baixoRendimentoCheckbox = isset($_POST["baixoRendimentoCheckbox"]) ? $_POST["baixoRendimentoCheckbox"] : "";
    $empenadoCheckbox = isset($_POST["empenadoCheckbox"]) ? $_POST["empenadoCheckbox"] : "";
    $rompidoCheckbox = isset($_POST["rompidoCheckbox"]) ? $_POST["rompidoCheckbox"] : "";
    $semVelocidadeCheckbox = isset($_POST["semVelocidadeCheckbox"]) ? $_POST["semVelocidadeCheckbox"] : "";
    $travadoCheckbox = isset($_POST["travadoCheckbox"]) ? $_POST["travadoCheckbox"] : "";
    $vibrandoCheckbox = isset($_POST["vibrandoCheckbox"]) ? $_POST["vibrandoCheckbox"] : "";
    $desarmadoCheckbox = isset($_POST["desarmadoCheckbox"]) ? $_POST["desarmadoCheckbox"] : "";
    $preventivaPreditivaCheckbox = isset($_POST["preventivaPreditivaCheckbox"]) ? $_POST["preventivaPreditivaCheckbox"] : "";
    $ruidoAnormalCheckbox = isset($_POST["ruidoAnormalCheckbox"]) ? $_POST["ruidoAnormalCheckbox"] : "";
    $soltoCheckbox = isset($_POST["soltoCheckbox"]) ? $_POST["soltoCheckbox"] : "";
    $trincadoCheckbox = isset($_POST["trincadoCheckbox"]) ? $_POST["trincadoCheckbox"] : "";
    $othersCheckboxValue = isset($_POST["othersCheckboxValue"]) ? $_POST["othersCheckboxValue"] : "";

    // Exibe os dados na tela
    echo "<h2>Dados Recebidos:</h2>";
    echo "<p>Aberto: $abertoCheckbox</p>";
    echo "<p>Desvio Lateral: $desvioLateralCheckbox</p>";
    echo "<p>Queimado: $queimadoCheckbox</p>";
    echo "<p>Sem Freio: $semFreioCheckbox</p>";
    echo "<p>Sujo: $sujoCheckbox</p>";
    echo "<p>Vazando: $vazandoCheckbox</p>";
    echo "<p>Baixo Rendimento: $baixoRendimentoCheckbox</p>";
    echo "<p>Empenado: $empenadoCheckbox</p>";
    echo "<p>Rompido: $rompidoCheckbox</p>";
    echo "<p>Sem Velocidade: $semVelocidadeCheckbox</p>";
    echo "<p>Travado: $travadoCheckbox</p>";
    echo "<p>Vibrando: $vibrandoCheckbox</p>";
    echo "<p>Desarmado: $desarmadoCheckbox</p>";
    echo "<p>Preventiva ou Preditiva: $preventivaPreditivaCheckbox</p>";
    echo "<p>Ruído Anormal: $ruidoAnormalCheckbox</p>";
    echo "<p>Solto: $soltoCheckbox</p>";
    echo "<p>Trincado: $trincadoCheckbox</p>";
    echo "<p>Outros: $othersCheckboxValue</p>";
} else {
    echo "<p>Erro: O formulário não foi submetido corretamente.</p>";
}

function processaFormulario() {
    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Inicializa a string
        $dadosString = "";
			
        // Itera sobre todas as variáveis do formulário
        foreach ($_POST as $key => $value) {
            // Adiciona a variável e seu valor à string
            $dadosString .= "$key: $value, ";
        }
        
        // Remove a última vírgula e espaço da string
        $dadosString = rtrim($dadosString, ', ');
        echo $dadosString;
        // Conexão com o banco de dados (substitua pelos seus próprios dados)
        $host = "localhost";
        $usuario = "root";
        $senha = "";
        $bancoDeDados = "manutencao";

        $conexao = new mysqli($host, $usuario, $senha, $bancoDeDados);

        // Verifica a conexão
        if ($conexao->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
        }

        // Prepara a consulta SQL
        $sintomasDetectados = $conexao->real_escape_string($dadosString);
        echo $sintomasDetectados;
        $sql = "INSERT INTO veiculo_os (sintomas_detectados) VALUES ('$sintomasDetectados')";

        // Executa a consulta
        if ($conexao->query($sql) === TRUE) {
            echo "Dados inseridos com sucesso.";
        } else {
            echo "Erro na inserção dos dados: " . $conexao->error;
        }

        // Fecha a conexão
        $conexao->close();
    }
}

// Chama a função
processaFormulario();

?>






</body>
</html>
