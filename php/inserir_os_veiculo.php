<?php
// Configurações do banco de dados
include "conexao_bd.php";

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
$componentesAfetados = $_POST['componentesAfetados'];
$sintomasDetectados = implode(", ", $_POST['sintomasDetectados']);
$descricaoDefeitoFalha = $_POST['descricaoDefeitoFalha'];
$causasDefeitoFalha = $_POST['causasDefeitoFalha'];
$causaNaoIdentificada = isset($_POST['causaNaoIdentificadaCheckbox']) ? 1 : 0;
$causaDefeitoDeFabrica = isset($_POST['causaDefeitoDeFabricaCheckbox']) ? 1 : 0;
$causaDesnivelamento = isset($_POST['causaDesnivelamentoCheckbox']) ? 1 : 0;
$causaDestensionamento = isset($_POST['causaDestensionamentoCheckbox']) ? 1 : 0;
$causaFissura = isset($_POST['causaFissuraCheckbox']) ? 1 : 0;
$causaGasto = isset($_POST['causaGastoCheckbox']) ? 1 : 0;
$causaPreventivaPreditiva = isset($_POST['causaPreventivaPreditivaCheckbox']) ? 1 : 0;
$causaRotaDeInspecao = isset($_POST['causaRotaDeInspecaoCheckbox']) ? 1 : 0;
$causaSobrecargaDeCorrente = isset($_POST['causaSobrecargaDeCorrenteCheckbox']) ? 1 : 0;
$causaDesalinhamento = isset($_POST['causaDesalinhamentoCheckbox']) ? 1 : 0;
$causaFaltaDeProtecao = isset($_POST['causaFaltaDeProtecaoCheckbox']) ? 1 : 0;
$causaEngripamento = isset($_POST['causaEngripamentoCheckbox']) ? 1 : 0;
$causaFolga = isset($_POST['causaFolgaCheckbox']) ? 1 : 0;
$causaSobrecargaDePeso = isset($_POST['causaSobrecargaDePesoCheckbox']) ? 1 : 0;
$causaSubdimensionamento = isset($_POST['causaSubdimensionamentoCheckbox']) ? 1 : 0;
$causaDesbalanceamento = isset($_POST['causaDesbalanceamentoCheckbox']) ? 1 : 0;
$causaDesregulamento = isset($_POST['causaDesregulamentoCheckbox']) ? 1 : 0;
$causaFadiga = isset($_POST['causaFadigaCheckbox']) ? 1 : 0;
$causaForaDeEspecificacao = isset($_POST['causaForaDeEspecificacaoCheckbox']) ? 1 : 0;
$causaNivelBaixo = isset($_POST['causaNivelBaixoCheckbox']) ? 1 : 0;
$causaRompido = isset($_POST['causaRompidoCheckbox']) ? 1 : 0;
$causaSobrecargaDeTensao = isset($_POST['causaSobrecargaDeTensaoCheckbox']) ? 1 : 0;

// Outros
$causaOthersCheckboxValue = isset($_POST['causaOthersCheckboxValue']) ? $_POST['causaOthersCheckboxValue'] : '';

$descricaoCausaDefeitoFalha = $_POST['descricaoCausaDefeitoFalha'];
$intervencaoMecanica = isset($_POST['intervencaoMecanicaCheckbox']) ? 1 : 0;
$intervencaoPintura = isset($_POST['intervencaoPinturaCheckbox']) ? 1 : 0;
$intervencaoUsinagem = isset($_POST['intervencaoUsinagemCheckbox']) ? 1 : 0;
$intervencaoEletrica = isset($_POST['intervencaoEletricaCheckbox']) ? 1 : 0;
$intervencaoFunilaria = isset($_POST['intervencaoFunilariaCheckbox']) ? 1 : 0;
$intervencaoCaldeiraria = isset($_POST['intervencaoCaldeirariaCheckbox']) ? 1 : 0;
$intervencaoHidraulico = isset($_POST['intervencaoHidraulicoCheckbox']) ? 1 : 0;
$intervencaoSoldagem = isset($_POST['intervencaoSoldagemCheckbox']) ? 1 : 0;
$tipoIntervencaoOutrosCheckboxValue = isset($_POST['tipoIntervencaoOthersCheckboxValue']) ? $_POST['tipoIntervencaoOthersCheckboxValue'] : '';

$intervencaoAcoplado = isset($_POST['intervencaoAcopladoCheckbox']) ? 1 : 0;
$intervencaoDesacoplado = isset($_POST['intervencaoDesacopladoCheckbox']) ? 1 : 0;
$intervencaoInstalado = isset($_POST['intervencaoInstaladoCheckbox']) ? 1 : 0;
$intervencaoRearmado = isset($_POST['intervencaoRearmadoCheckbox']) ? 1 : 0;
$intervencaoSoldado = isset($_POST['intervencaoSoldadoCheckbox']) ? 1 : 0;
$intervencaoAjustado = isset($_POST['intervencaoAjustadoCheckbox']) ? 1 : 0;
$intervencaoFabricado = isset($_POST['intervencaoFabricadoCheckbox']) ? 1 : 0;
$intervencaoLimpeza = isset($_POST['intervencaoLimpezaCheckbox']) ? 1 : 0;
$intervencaoRecuperacao = isset($_POST['intervencaoRecuperacaoCheckbox']) ? 1 : 0;
$intervencaoSubstituido = isset($_POST['intervencaoSubstituidoCheckbox']) ? 1 : 0;
$intervencaoAlinhado = isset($_POST['intervencaoAlinhadoCheckbox']) ? 1 : 0;
$intervencaoFixado = isset($_POST['intervencaoFixadoCheckbox']) ? 1 : 0;
$intervencaoLubrificado = isset($_POST['intervencaoLubrificadoCheckbox']) ? 1 : 0;
$intervencaoReposto = isset($_POST['intervencaoRepostoCheckbox']) ? 1 : 0;
$intervencaoApertado = isset($_POST['intervencaoApertadoCheckbox']) ? 1 : 0;
$intervencaoInspecionado = isset($_POST['intervencaoInspecionadoCheckbox']) ? 1 : 0;
$intervencaoModificado = isset($_POST['intervencaoModificadoCheckbox']) ? 1 : 0;
$intervencaoRetirado = isset($_POST['intervencaoRetiradoCheckbox']) ? 1 : 0;
$intervencaoOutrosCheckboxValue = isset($_POST['intervencaoOthersCheckboxValue']) ? $_POST['intervencaoOthersCheckboxValue'] : '';

$descricaoIntervencoes = $_POST['descricaoIntervencoes'];

// Inserir os dados no banco de dados
$sql = "INSERT INTO tabela_veiculo (
    odometer, start_date, start_time, end_date, end_time, maintenance_type,
    cabine_checkbox, combustivel_checkbox, direcao_checkbox,
    componentes_afetados, sintomas_detectados, descricao_defeito_falha, causas_defeito_falha, causa_nao_identificada, causa_defeito_fabrica, causa_desnivelamento, causa_destensionamento,
    causa_fissura, causa_gasto, causa_preventiva_preditiva, causa_rota_inspecao,
    causa_sobrecarga_corrente, causa_desalinhamento, causa_falta_protecao, causa_engripamento,
    causa_folga, causa_sobrecarga_peso, causa_subdimensionamento, causa_desbalanceamento,
    causa_desregulamento, causa_fadiga, causa_fora_especificacao, causa_nivel_baixo,
    causa_rompido, causa_sobrecarga_tensao, causa_outros , descricao_causa_defeito_falha,
    intervencao_mecanica, intervencao_pintura, intervencao_usinagem, intervencao_eletrica, intervencao_funilaria,
    intervencao_caldeiraria, intervencao_hidraulico, intervencao_soldagem, tipo_intervencao_outros,
    intervencao_acoplado, intervencao_desacoplado, intervencao_instalado, intervencao_rearmado, intervencao_soldado,
    intervencao_ajustado, intervencao_fabricado, intervencao_limpeza, intervencao_recuperacao, intervencao_substituido,
    intervencao_alinhado, intervencao_fixado, intervencao_lubrificado, intervencao_reposto, intervencao_apertado,
    intervencao_inspecionado, intervencao_modificado, intervencao_retirado, intervencao_outros, descricao_intervencoes
) VALUES (
    '$odometerValue', '$maintenanceStartDate', '$maintenanceStartTime', '$maintenanceEndDate', '$maintenanceFinishTime', '$maintenanceType',
    '$cabineCheckbox', '$combustivelCheckbox', '$direcaoCheckbox',
    '$componentesAfetados', '$sintomasDetectados', '$descricaoDefeitoFalha', '$causasDefeitoFalha', '$causaNaoIdentificada', '$causaDefeitoDeFabrica', '$causaDesnivelamento', '$causaDestensionamento',
    '$causaFissura', '$causaGasto', '$causaPreventivaPreditiva', '$causaRotaDeInspecao',
    '$causaSobrecargaDeCorrente', '$causaDesalinhamento', '$causaFaltaDeProtecao', '$causaEngripamento',
    '$causaFolga', '$causaSobrecargaDePeso', '$causaSubdimensionamento', '$causaDesbalanceamento',
    '$causaDesregulamento', '$causaFadiga', '$causaForaDeEspecificacao', '$causaNivelBaixo',
    '$causaRompido', '$causaSobrecargaDeTensao', '$causaOthersCheckboxValue' , '$descricaoCausaDefeitoFalha',
    '$intervencaoMecanica', '$intervencaoPintura', '$intervencaoUsinagem', '$intervencaoEletrica', '$intervencaoFunilaria',
    '$intervencaoCaldeiraria', '$intervencaoHidraulico', '$intervencaoSoldagem', '$tipoIntervencaoOutrosCheckboxValue',
    '$intervencaoAcoplado', '$intervencaoDesacoplado', '$intervencaoInstalado', '$intervencaoRearmado', '$intervencaoSoldado',
    '$intervencaoAjustado', '$intervencaoFabricado', '$intervencaoLimpeza', '$intervencaoRecuperacao', '$intervencaoSubstituido',
    '$intervencaoAlinhado', '$intervencaoFixado', '$intervencaoLubrificado', '$intervencaoReposto', '$intervencaoApertado',
    '$intervencaoInspecionado', '$intervencaoModificado', '$intervencaoRetirado', '$intervencaoOutrosCheckboxValue', '$descricaoIntervencoes'
)";

if ($conn->query($sql) === TRUE) {
    echo "Dados inseridos com sucesso!";
} else {
    echo "Erro ao inserir dados: " . $conn->error;
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
