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

   // quais são as causas 
$causaNaoIdentificadaCheckbox = isset($_POST["causaNaoIdentificadaCheckbox"]) ? $_POST["causaNaoIdentificadaCheckbox"] : "";
$causaDefeitoDeFabricaCheckbox = isset($_POST["causaDefeitoDeFabricaCheckbox"]) ? $_POST["causaDefeitoDeFabricaCheckbox"] : "";
$causaDesnivelamentoCheckbox = isset($_POST["causaDesnivelamentoCheckbox"]) ? $_POST["causaDesnivelamentoCheckbox"] : "";
$causaDestensionamentoCheckbox = isset($_POST["causaDestensionamentoCheckbox"]) ? $_POST["causaDestensionamentoCheckbox"] : "";
$causaFissuraCheckbox = isset($_POST["causaFissuraCheckbox"]) ? $_POST["causaFissuraCheckbox"] : "";
$causaGastoCheckbox = isset($_POST["causaGastoCheckbox"]) ? $_POST["causaGastoCheckbox"] : "";
$causaPreventivaPreditivaCheckbox = isset($_POST["causaPreventivaPreditivaCheckbox"]) ? $_POST["causaPreventivaPreditivaCheckbox"] : "";
$causaRotaDeInspecaoCheckbox = isset($_POST["causaRotaDeInspecaoCheckbox"]) ? $_POST["causaRotaDeInspecaoCheckbox"] : "";
$causaSobrecargaDeCorrenteCheckbox = isset($_POST["causaSobrecargaDeCorrenteCheckbox"]) ? $_POST["causaSobrecargaDeCorrenteCheckbox"] : "";
$causaDesalinhamentoCheckbox = isset($_POST["causaDesalinhamentoCheckbox"]) ? $_POST["causaDesalinhamentoCheckbox"] : "";
$causaFaltaDeProtecaoCheckbox = isset($_POST["causaFaltaDeProtecaoCheckbox"]) ? $_POST["causaFaltaDeProtecaoCheckbox"] : "";
$causaEngripamentoCheckbox = isset($_POST["causaEngripamentoCheckbox"]) ? $_POST["causaEngripamentoCheckbox"] : "";
$causaFolgaCheckbox = isset($_POST["causaFolgaCheckbox"]) ? $_POST["causaFolgaCheckbox"] : "";
$causaSobrecargaDePesoCheckbox = isset($_POST["causaSobrecargaDePesoCheckbox"]) ? $_POST["causaSobrecargaDePesoCheckbox"] : "";
$causaSubdimensionamentoCheckbox = isset($_POST["causaSubdimensionamentoCheckbox"]) ? $_POST["causaSubdimensionamentoCheckbox"] : "";
$causaDesbalanceamentoCheckbox = isset($_POST["causaDesbalanceamentoCheckbox"]) ? $_POST["causaDesbalanceamentoCheckbox"] : "";
$causaDesregulamentoCheckbox = isset($_POST["causaDesregulamentoCheckbox"]) ? $_POST["causaDesregulamentoCheckbox"] : "";
$causaFadigaCheckbox = isset($_POST["causaFadigaCheckbox"]) ? $_POST["causaFadigaCheckbox"] : "";
$causaForaDeEspecificacaoCheckbox = isset($_POST["causaForaDeEspecificacaoCheckbox"]) ? $_POST["causaForaDeEspecificacaoCheckbox"] : "";
$causaNivelBaixoCheckbox = isset($_POST["causaNivelBaixoCheckbox"]) ? $_POST["causaNivelBaixoCheckbox"] : "";
$causaRompidoCheckbox = isset($_POST["causaRompidoCheckbox"]) ? $_POST["causaRompidoCheckbox"] : "";
$causaSobrecargaDeTensaoCheckbox = isset($_POST["causaSobrecargaDeTensaoCheckbox"]) ? $_POST["causaSobrecargaDeTensaoCheckbox"] : "";
$causaOthersCheckboxValue = isset($_POST["causaOthersCheckboxValue"]) ? $_POST["causaOthersCheckboxValue"] : "";
$descricaoDefeitoFalha = isset($_POST["descricaoDefeitoFalha"]) ? $_POST["descricaoDefeitoFalha"] : "";

// Qual tipo de intervenção 
$intervencaoMecanicaCheckbox = isset($_POST["intervencaoMecanicaCheckbox"]) ? $_POST["intervencaoMecanicaCheckbox"] : "";
$intervencaoPinturaCheckbox = isset($_POST["intervencaoPinturaCheckbox"]) ? $_POST["intervencaoPinturaCheckbox"] : "";
$intervencaoUsinagemCheckbox = isset($_POST["intervencaoUsinagemCheckbox"]) ? $_POST["intervencaoUsinagemCheckbox"] : "";
$intervencaoEletricaCheckbox = isset($_POST["intervencaoEletricaCheckbox"]) ? $_POST["intervencaoEletricaCheckbox"] : "";
$intervencaoFunilariaCheckbox = isset($_POST["intervencaoFunilariaCheckbox"]) ? $_POST["intervencaoFunilariaCheckbox"] : "";
$intervencaoCaldeirariaCheckbox = isset($_POST["intervencaoCaldeirariaCheckbox"]) ? $_POST["intervencaoCaldeirariaCheckbox"] : "";
$intervencaoHidraulicoCheckbox = isset($_POST["intervencaoHidraulicoCheckbox"]) ? $_POST["intervencaoHidraulicoCheckbox"] : "";
$intervencaoSoldagemCheckbox = isset($_POST["intervencaoSoldagemCheckbox"]) ? $_POST["intervencaoSoldagemCheckbox"] : "";
$tipoIntervencaoOthersCheckboxValue = isset($_POST["tipoIntervencaoOthersCheckboxValue"]) ? $_POST["tipoIntervencaoOthersCheckboxValue"] : "";

// intervenção 
$intervencaoAcopladoCheckbox = isset($_POST["intervencaoAcopladoCheckbox"]) ? $_POST["intervencaoAcopladoCheckbox"] : "";
$intervencaoDesacopladoCheckbox = isset($_POST["intervencaoDesacopladoCheckbox"]) ? $_POST["intervencaoDesacopladoCheckbox"] : "";
$intervencaoInstaladoCheckbox = isset($_POST["intervencaoInstaladoCheckbox"]) ? $_POST["intervencaoInstaladoCheckbox"] : "";
$intervencaoRearmadoCheckbox = isset($_POST["intervencaoRearmadoCheckbox"]) ? $_POST["intervencaoRearmadoCheckbox"] : "";
$intervencaoSoldadoCheckbox = isset($_POST["intervencaoSoldadoCheckbox"]) ? $_POST["intervencaoSoldadoCheckbox"] : "";
$intervencaoAjustadoCheckbox = isset($_POST["intervencaoAjustadoCheckbox"]) ? $_POST["intervencaoAjustadoCheckbox"] : "";
$intervencaoFabricadoCheckbox = isset($_POST["intervencaoFabricadoCheckbox"]) ? $_POST["intervencaoFabricadoCheckbox"] : "";
$intervencaoLimpezaCheckbox = isset($_POST["intervencaoLimpezaCheckbox"]) ? $_POST["intervencaoLimpezaCheckbox"] : "";
$intervencaoRecuperacaoCheckbox = isset($_POST["intervencaoRecuperacaoCheckbox"]) ? $_POST["intervencaoRecuperacaoCheckbox"] : "";
$intervencaoSubstituidoCheckbox = isset($_POST["intervencaoSubstituidoCheckbox"]) ? $_POST["intervencaoSubstituidoCheckbox"] : "";
$intervencaoAlinhadoCheckbox = isset($_POST["intervencaoAlinhadoCheckbox"]) ? $_POST["intervencaoAlinhadoCheckbox"] : "";
$intervencaoFixadoCheckbox = isset($_POST["intervencaoFixadoCheckbox"]) ? $_POST["intervencaoFixadoCheckbox"] : "";
$intervencaoLubrificadoCheckbox = isset($_POST["intervencaoLubrificadoCheckbox"]) ? $_POST["intervencaoLubrificadoCheckbox"] : "";
$intervencaoRepostoCheckbox = isset($_POST["intervencaoRepostoCheckbox"]) ? $_POST["intervencaoRepostoCheckbox"] : "";
$intervencaoApertadoCheckbox = isset($_POST["intervencaoApertadoCheckbox"]) ? $_POST["intervencaoApertadoCheckbox"] : "";
$intervencaoInspecionadoCheckbox = isset($_POST["intervencaoInspecionadoCheckbox"]) ? $_POST["intervencaoInspecionadoCheckbox"] : "";
$intervencaoModificadoCheckbox = isset($_POST["intervencaoModificadoCheckbox"]) ? $_POST["intervencaoModificadoCheckbox"] : "";
$intervencaoRetiradoCheckbox = isset($_POST["intervencaoRetiradoCheckbox"]) ? $_POST["intervencaoRetiradoCheckbox"] : "";
$intervencaoOthersCheckboxValue = isset($_POST["intervencaoOthersCheckboxValue"]) ? $_POST["intervencaoOthersCheckboxValue"] : "";





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
echo "causaNaoIdentificadaCheckbox: " . $causaNaoIdentificadaCheckbox . "<br>";
echo "causaDefeitoDeFabricaCheckbox: " . $causaDefeitoDeFabricaCheckbox . "<br>";
echo "causaDesnivelamentoCheckbox: " . $causaDesnivelamentoCheckbox . "<br>";
echo "causaDestensionamentoCheckbox: " . $causaDestensionamentoCheckbox . "<br>";
echo "causaFissuraCheckbox: " . $causaFissuraCheckbox . "<br>";
echo "causaGastoCheckbox: " . $causaGastoCheckbox . "<br>";
echo "causaPreventivaPreditivaCheckbox: " . $causaPreventivaPreditivaCheckbox . "<br>";
echo "causaRotaDeInspecaoCheckbox: " . $causaRotaDeInspecaoCheckbox . "<br>";
echo "causaSobrecargaDeCorrenteCheckbox: " . $causaSobrecargaDeCorrenteCheckbox . "<br>";
echo "causaDesalinhamentoCheckbox: " . $causaDesalinhamentoCheckbox . "<br>";
echo "causaFaltaDeProtecaoCheckbox: " . $causaFaltaDeProtecaoCheckbox . "<br>";
echo "causaEngripamentoCheckbox: " . $causaEngripamentoCheckbox . "<br>";
echo "causaFolgaCheckbox: " . $causaFolgaCheckbox . "<br>";
echo "causaSobrecargaDePesoCheckbox: " . $causaSobrecargaDePesoCheckbox . "<br>";
echo "causaSubdimensionamentoCheckbox: " . $causaSubdimensionamentoCheckbox . "<br>";
echo "causaDesbalanceamentoCheckbox: " . $causaDesbalanceamentoCheckbox . "<br>";
echo "causaDesregulamentoCheckbox: " . $causaDesregulamentoCheckbox . "<br>";
echo "causaFadigaCheckbox: " . $causaFadigaCheckbox . "<br>";
echo "causaForaDeEspecificacaoCheckbox: " . $causaForaDeEspecificacaoCheckbox . "<br>";
echo "causaNivelBaixoCheckbox: " . $causaNivelBaixoCheckbox . "<br>";
echo "causaRompidoCheckbox: " . $causaRompidoCheckbox . "<br>";
echo "causaSobrecargaDeTensaoCheckbox: " . $causaSobrecargaDeTensaoCheckbox . "<br>";
echo "causaOthersCheckboxValue: " . $causaOthersCheckboxValue . "<br>";
echo "intervencaoMecanicaCheckbox: " . $intervencaoMecanicaCheckbox . "<br>";
echo "intervencaoPinturaCheckbox: " . $intervencaoPinturaCheckbox . "<br>";
echo "intervencaoUsinagemCheckbox: " . $intervencaoUsinagemCheckbox . "<br>";
echo "intervencaoEletricaCheckbox: " . $intervencaoEletricaCheckbox . "<br>";
echo "intervencaoFunilariaCheckbox: " . $intervencaoFunilariaCheckbox . "<br>";
echo "intervencaoCaldeirariaCheckbox: " . $intervencaoCaldeirariaCheckbox . "<br>";
echo "intervencaoHidraulicoCheckbox: " . $intervencaoHidraulicoCheckbox . "<br>";
echo "intervencaoSoldagemCheckbox: " . $intervencaoSoldagemCheckbox . "<br>";
echo "tipoIntervencaoOthersCheckboxValue: " . $tipoIntervencaoOthersCheckboxValue . "<br>";
echo "intervencaoAcopladoCheckbox: " . $intervencaoAcopladoCheckbox . "<br>";
echo "intervencaoDesacopladoCheckbox: " . $intervencaoDesacopladoCheckbox . "<br>";
echo "intervencaoInstaladoCheckbox: " . $intervencaoInstaladoCheckbox . "<br>";
echo "intervencaoRearmadoCheckbox: " . $intervencaoRearmadoCheckbox . "<br>";
echo "intervencaoSoldadoCheckbox: " . $intervencaoSoldadoCheckbox . "<br>";
echo "intervencaoAjustadoCheckbox: " . $intervencaoAjustadoCheckbox . "<br>";
echo "intervencaoFabricadoCheckbox: " . $intervencaoFabricadoCheckbox . "<br>";
echo "intervencaoLimpezaCheckbox: " . $intervencaoLimpezaCheckbox . "<br>";
echo "intervencaoRecuperacaoCheckbox: " . $intervencaoRecuperacaoCheckbox . "<br>";
echo "intervencaoSubstituidoCheckbox: " . $intervencaoSubstituidoCheckbox . "<br>";
echo "intervencaoAlinhadoCheckbox: " . $intervencaoAlinhadoCheckbox . "<br>";
echo "intervencaoFixadoCheckbox: " . $intervencaoFixadoCheckbox . "<br>";
echo "intervencaoLubrificadoCheckbox: " . $intervencaoLubrificadoCheckbox . "<br>";
echo "intervencaoRepostoCheckbox: " . $intervencaoRepostoCheckbox . "<br>";
echo "intervencaoApertadoCheckbox: " . $intervencaoApertadoCheckbox . "<br>";
echo "intervencaoInspecionadoCheckbox: " . $intervencaoInspecionadoCheckbox . "<br>";
echo "intervencaoModificadoCheckbox: " . $intervencaoModificadoCheckbox . "<br>";
echo "intervencaoRetiradoCheckbox: " . $intervencaoRetiradoCheckbox . "<br>";
echo "intervencaoOthersCheckboxValue: " . $intervencaoOthersCheckboxValue . "<br>";
echo "intervencaoOthersCheckboxValue: " . $descricaoDefeitoFalha  . "<br>";    
    
    
} else {
    echo "<p>Erro: O formulário não foi submetido corretamente.</p>";
}


function processaFormularioVeiculo() {
    // Verifica se o formulário foi submetido
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Inicializa a string
        $dadosString = "";

           //conexao com o banco de dados e os parametros
           include "conexao_bd.php";
           $conexao = $conn;

        // Verifica a conexão
        if ($conexao->connect_error) {
            die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
        }

        // Itera sobre todas as variáveis do formulário
        foreach ($_POST as $key => $value) {
            // Verifica se o valor não é nulo antes de adicioná-lo à string
            if ($value !== null) {
                // Adiciona a variável e seu valor à string
                $dadosString .= "$key: " . $conexao->real_escape_string($value) . " | ";
            }
        }

        // Remove a última vírgula e espaço da string
        $dadosString = rtrim($dadosString, '| ');

        // Prepara a consulta SQL 
        $sql = "INSERT INTO tanque_os (dados_tanque) VALUES ('$dadosString')";

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
processaFormularioVeiculo();
?>

</body>
</html>
