<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verificar se foi recebido um ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para buscar o registro específico
    $sql = "SELECT * FROM ativo_veiculo WHERE id = $id";
    $resultado = $conn->query($sql);

    // Verificar se a consulta foi bem-sucedida
    if ($resultado === false) {
        die("Erro na consulta SQL: " . $conn->error);
    }

    // Verificar se o registro foi encontrado
    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();
    } else {
        die("Registro não encontrado.");
    }
} else {
    die("ID inválido.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OS- Veículo</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<h2>OS - Veículo</h2>

<table>
    <tr>
        <th>ID</th>
        <td><?php echo $row["id"]; ?></td>
    </tr>
    <tr>
        <th>Tipo de Veículo</th>
        <td><?php echo $row["tipo_veiculo"]; ?></td>
    </tr>
    <tr>
        <th>Tag</th>
        <td><?php echo $row["tag"]; ?></td>
    </tr>
    <!-- Adicionar mais colunas conforme necessário -->

    <!-- Campo para observações -->
    <tr>
        <th>Observações</th>
        <td>
            <form action="processar_observacoes_veiculo.php" method="post">
                

<div class="input-group mb-3"><div class="input-group-prepend">

                           <table class="table table-hover my-4">
    				<tbody>                      
        			   <tr>
           				<td class="maintenanceOdometer">Odômetro (KM):</td>
            				<td><input type="text" name="odometerValue" id="odometerValue" placeholder="Insira o valor do odômetro"></td>
        			   </tr>                                                                            
    				</tbody>
			    </table>

<table class="table table-hover my-4">
    <thead>
        <tr>
            <th colspan="3" class="text-center fs-5">Tempo de manutenção</th>
        </tr>
        <tr>
            <th class="text-center col-sm-6">Descrição</th>
            <th class="text-center col-sm-3">Data</th>
            <th class="text-center col-sm-3">Hora</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="text-center col-sm-6">Início de manutenção</td>
            <td class="text-center col-sm-3 maintenanceStartDate">
                <input type="date" name="maintenanceStartDate">
            </td>
            <td class="text-center col-sm-3 maintenanceStartTime">
                <input type="time" name="maintenanceStartTime">
            </td>
        </tr>
        <tr>
            <td class="text-center col-sm-6">Término de manutenção</td>
            <td class="text-center col-sm-3 maintenanceEndDate">
                <input type="date" name="maintenanceEndDate">
            </td>
            <td class="text-center col-sm-3 maintenanceFinishTime">
                <input type="time" name="maintenanceFinishTime">
            </td>
        </tr>
    </tbody>
</table>
                            <form class="mb-5">

                                <div class="mb-3">

                                    <label class="d-flex flex-column mb-2">Qual tipo de manuten&ccedil;&atilde;o voc&ecirc; pretende solicitar?</label>

                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input corretivaRadio" type="radio" name="radio-maintenance" id="radio-corrective-maintenance">
                                        <label class="form-check-label" for="radio-corrective-maintenance">
                                            Corretiva
                                        </label>
                                    </div>
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input preditivaRadio" type="radio" name="radio-maintenance" id="radio-predictive-maintenance">
                                        <label class="form-check-label" for="radio-predictive-maintenance">
                                            Preditiva
                                        </label>
                                    </div>
                                    <div class="form-check  form-check-inline">
                                        <input class="form-check-input preventivaRadio" type="radio" name="radio-maintenance" id="radio-preventive-maintenance">
                                        <label class="form-check-label" for="radio-preventive-maintenance">
                                            Preventiva
                                        </label>
                                    </div>
                                </div>

                                <label class="form-label">Quais os sistemas afetados?</label>

                                <div class="mb-3 form-check">

                                    <div class="row">

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="cabineCheckbox">
                                            <label class="form-check-label" for="cabineCheckbox">Cabine</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="combustivelCheckbox">
                                            <label class="form-check-label" for="combustivelCheckbox">Combust&iacute;vel</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="direcaoCheckbox">
                                            <label class="form-check-label" for="direcaoCheckbox">Dire&ccedil;&atilde;o</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="medicaoControleCheckbox">
                                            <label class="form-check-label" for="medicaoControleCheckbox">Medi&ccedil;&atilde;o de controle</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="protecaoImpactosCheckbox">
                                            <label class="form-check-label" for="protecaoImpactosCheckbox">Prote&ccedil;&atilde;o contra impactos</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="transmissaoCheckbox">
                                            <label class="form-check-label" for="transmissaoCheckbox">Transmiss&atilde;o</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="estruturalCheckbox">
                                            <label class="form-check-label" for="estruturalCheckbox">Estrutural</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="acoplamentoCheckbox">
                                            <label class="form-check-label" for="acoplamentoCheckbox">Acomplamento</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="controleEletronicoCheckbox">
                                            <label class="form-check-label" for="controleEletronicoCheckbox">Controle eletr&ocirc;nico</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="exaustaoCheckbox">
                                            <label class="form-check-label" for="exaustaoCheckbox">Exaust&atilde;o</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="propulsaoCheckbox">
                                            <label class="form-check-label" for="propulsaoCheckbox">Propuls&atilde;o</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="protecaoContraIncendioCheckbox">
                                            <label class="form-check-label" for="protecaoContraIncendioCheckbox">Porte&ccedil;&atilde;o contra inc&ecirc;ndio</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="ventilacaoCheckbox">
                                            <label class="form-check-label" for="ventilacaoCheckbox">Ventila&ccedil;&atilde;o</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="tanqueCheckbox">
                                            <label class="form-check-label" for="tanqueCheckbox">Tanque</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="arrefecimentoCheckbox">
                                            <label class="form-check-label" for="arrefecimentoCheckbox">Arrefecimento</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="descargaCheckbox">
                                            <label class="form-check-label" for="descargaCheckbox">Descarga</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="freiosCheckbox">
                                            <label class="form-check-label" for="freiosCheckbox">Freios</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="prote&ccedil;&atilde;oAmbientalCheckbox">
                                            <label class="form-check-label" for="prote&ccedil;&atilde;oAmbientalCheckbox">Prote&ccedil;&atilde;o ambiental</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="suspensaoCheckbox">
                                            <label class="form-check-label" for="suspensaoCheckbox">Suspens&atilde;o</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="eletricoCheckbox">
                                            <label class="form-check-label" for="eletricoCheckbox">El&eacute;trico</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="mb-2" for="componentesAfetados">Quais os componentes afetados?</label>
                                    <textarea class="form-control" rows="2"  id="componentesAfetados" aria-label="Componentes afetados"></textarea>
                                </div>

                                <label class="form-label">Quais s&atilde;o os sintomas detectados?</label>

                                <div class="mb-3 form-check">
                                    <div class="row">

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="abertoCheckbox">
                                            <label class="form-check-label" for="abertoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Descontinuidade em um circuito fechado">Aberto</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="desvioLateralCheckbox">
                                            <label class="form-check-label" for="desvioLateralCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Durante a opera&ccedil;&atilde;o, &eacute; identificado equipamento
“puxando” para um dos lados.">Desvio lateral</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="queimadoCheckbox">
                                            <label class="form-check-label" for="queimadoCheckbox"  data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Queima do equipamento ou componente">Queimado</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="semFreioCheckbox">
                                            <label class="form-check-label" for="semFreioCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Impossibilidade de diminuir a velocidade de um equipamento
at&eacute; sua parada total, por n&atilde;o funcionamento do sistema de freio.">Sem freio</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="sujoCheckbox">
                                            <label class="form-check-label" for="sujoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Exist&ecirc;ncia de sujeira que comprometa funcionamento do
equipamento.">Sujo</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="vazandoCheckbox">
                                            <label class="form-check-label" for="vazandoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Vazamento constante no equipamento.">Vazando</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="baixoRendimentoCheckbox">
                                            <label class="form-check-label" for="baixoRendimentoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Queda no rendimento de maquin&aacute;rio. Exemplo: o
equipamento levando 1 minuto para efetuar uma tarefa, quando
normalmente a faria em 45 segundos.">Baixo Rendimento</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="empenadoCheckbox">
                                            <label class="form-check-label" for="empenadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Equipamento e/ou estrutura se constituindo em um empeno,
ou seja, uma altera&ccedil;&atilde;o em seu corpo, impossibilitando seu ajuste em
outro equipamento ou elemento.">Empenado</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="rompidoCheckbox">
                                            <label class="form-check-label" for="rompidoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Dano no equipamento provocando separa&ccedil;&atilde;o entre suas
partes, que deveriam ser cont&iacute;nuas.">Rompido</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="semVelocidadeCheckbox">
                                            <label class="form-check-label" for="semVelocidadeCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Equipamento n&atilde;o atingindo velocidade necess&aacute;ria para
seu funcionamento.">Sem velocidade</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="travadoCheckbox">
                                            <label class="form-check-label" for="travadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Equipamento se encontra travado, sem movimento.">Travado</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="vibrandoCheckbox">
                                            <label class="form-check-label" for="vibrandoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Vibra&ccedil;&atilde;o mec&acirc;nica, acima do normal do equipamento">Vibrando</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="desarmadoCheckbox">
                                            <label class="form-check-label" for="desarmadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Equipamento n&atilde;o recebendo alimenta&ccedil;&atilde;o de sua fonte de energia.">Desarmado</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="preventivaPreditivaCheckbox">
                                            <label class="form-check-label" for="preventivaPreditivaCheckbox">Preventiva ou Preditiva</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="ruidoAnormalCheckbox">
                                            <label class="form-check-label" for="ruidoAnormalCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Equipamento apresentando ru&iacute;do fora de sua
normalidade.">Ru&iacute;do Anormal</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="soltoCheckbox">
                                            <label class="form-check-label" for="soltoCheckbox"  data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Inexist&ecirc;ncia de uni&atilde;o entre componentes que deveriam estar
interligados.">Solto</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="trincadoCheckbox">
                                            <label class="form-check-label" for="trincadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Dano no equipamento constitu&iacute;do por trinca, ou seja, uma
fissura vis&iacute;vel.">Trincado</label>
                                        </div>

                                        <div class="col-sm-12">
                                            <input type="checkbox" class="form-check-input"  onclick="let input = document.getElementById('othersCheckboxValue'); if(this.checked){ input.disabled = false;input.style = 'block'; input.focus();}else{input.disabled=true;input.style='display: none;';}"/>
                                            <label class="form-check-label" for="othersCheckboxValue" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Em caso de sintoma n&atilde;o listado acima, o respons&aacute;vel por preencher o
formul&aacute;rio poder&aacute; acrescentar outros sintomas nos campos em aberto.">Outros</label>
                                            <input class="col-12" id="othersCheckboxValue" name="othersCheckboxValue" disabled="disabled" style="display: none;"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="mb-2" for="descricaoDefeitoFalha">Descreva o defeito ou falha encontrado:</label>
                                    <textarea class="form-control" rows="2"  id="descricaoDefeitoFalha" aria-label="Descri&ccedil;&atilde;o do defeito ou falha"></textarea>
                                </div>

                                <label class="form-label">Quais s&atilde;o as causas do defeito/falha?</label>

                                <div class="mb-3 form-check">

                                    <div class="row">

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaNaoIdentificadaCheckbox">
                                            <label class="form-check-label" for="causaNaoIdentificadaCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Deve-se apontar essa causa quando n&atilde;o puder ser afirmado com exatid&atilde;o o que provocou a falha ou defeito do componente.">
                                                N&atilde;o identificada
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaDefeitoDeFabricaCheckbox">
                                            <label class="form-check-label" for="causaDefeitoDeFabricaCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Ocorr&ecirc;ncia de imperfei&ccedil;&atilde;o, defeito de fabrica&ccedil;&atilde;o de componente ou elemento. Exemplo: bobina com nº menor de espiras">
                                                Defeito de f&aacute;brica
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaDesnivelamentoCheckbox">
                                            <label class="form-check-label" for="causaDesnivelamentoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Componente ou elemento fora do nivelamento, ocasionando diferen&ccedil;a de n&iacute;vel entre elementos que interagem.">
                                                Desnivelamento
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaDestensionamentoCheckbox">
                                            <label class="form-check-label" for="causaDestensionamentoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Componente ou elemento se encontra sem tensionamento ou torque necess&aacute;rio (recomend&aacute;vel) para sua opera&ccedil;&atilde;o.">
                                                Destensionamento
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaFissuraCheckbox">
                                            <label class="form-check-label" for="causaFissuraCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Componente ou elemento com fissuras em seu corpo">
                                                Fissura
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaGastoCheckbox">
                                            <label class="form-check-label" for="causaGastoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Componente ou elemento deteriorado, consumido nas partes úteis de seu corpo.">
                                                Gasto
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaPreventivaPreditivaCheckbox">
                                            <label class="form-check-label" for="causaPreventivaPreditivaCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Interven&ccedil;&atilde;o proveniente de manuten&ccedil;&atilde;o preventiva ou preditiva.">
                                                Preventiva ou Preditiva
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaRotaDeInspecaoCheckbox">
                                            <label class="form-check-label" for="causaRotaDeInspecaoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="">
                                                Rota de inspe&ccedil;&atilde;o
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaSobrecargaDeCorrenteCheckbox">
                                            <label class="form-check-label" for="causaSobrecargaDeCorrenteCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Solicita&ccedil;&atilde;o do equipamento acima de sua capacidade m&aacute;xima de suportar corrente.">
                                                Sobrecarga de corrente
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaDesalinhamentoCheckbox">
                                            <label class="form-check-label" for="causaDesalinhamentoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Sem alinho, componente ou elemento fora do seu devido alinhamento.">
                                                Desalinhamento
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaFaltaDeProtecaoCheckbox">
                                            <label class="form-check-label" for="causaFaltaDeProtecaoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Falta de prote&ccedil;&atilde;o que deveria existir para salvaguardar equipamento, bem como a retirada intencional de tal prote&ccedil;&atilde;o. Exemplo: Danos a sistema hidr&aacute;ulico por falta de sistema de filtragem na suc&ccedil;&atilde;o.">
                                                Falta de prote&ccedil;&atilde;o
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaEngripamentoCheckbox">
                                            <label class="form-check-label" for="causaEngripamentoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Componente ou elemento com suas partes móveis sem mobilidade devido a alto coeficiente de atrito, devido a grande quantidade de oxida&ccedil;&atilde;o (ferrugem) etc.">
                                                Engripamento
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaFolgaCheckbox">
                                            <label class="form-check-label" for="causaFolgaCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Componente ou elemento com folga, ou seja, espa&ccedil;o entre partes de intera&ccedil;&atilde;o acima do permitido">
                                                Folga
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaSobrecargaDePesoCheckbox">
                                            <label class="form-check-label" for="causaSobrecargaDePesoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="">
                                                Sobrecarga de peso
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaSubdimensionamentoCheckbox">
                                            <label class="form-check-label" for="causaSubdimensionamentoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Especifica&ccedil;&atilde;o de projeto de componente ou elemento que n&atilde;o atende requisitos m&iacute;nimos para o bom funcionamento do conjunto.">
                                                Subdimensionamento
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaDesbalanceamentoCheckbox">
                                            <label class="form-check-label" for="causaDesbalanceamentoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="">
                                                Desbalanceamento
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaDesregulamentoCheckbox">
                                            <label class="form-check-label" for="causaDesregulamentoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Falta de ajuste, calibra&ccedil;&atilde;o, regulagem de um determinado componente/elemento e/ou equipamento.">
                                                Desregulamento
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaFadigaCheckbox">
                                            <label class="form-check-label" for="causaFadigaCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Componente ou elemento sob efeito de afadigamento, que consiste na diminui&ccedil;&atilde;o gradual de resist&ecirc;ncia de um material por efeito de solicita&ccedil;&otilde;es repetidas">
                                                Fadiga
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaForaDeEspecificacaoCheckbox">
                                            <label class="form-check-label" for="causaForaDeEspecificacaoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Componente ou elemento fora de especifica&ccedil;&atilde;o estabelecida para o trabalho. Exemplo: Rolamento blindado no lugar de um rolamento o que deveria ser do tipo aberto.">
                                                Fora de especifica&ccedil;&atilde;o
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaNivelBaixoCheckbox">
                                            <label class="form-check-label" for="causaNivelBaixoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Relacionado a lubrifica&ccedil;&atilde;o ou hidr&aacute;ulica, relacionado ao n&iacute;vel insuficiente de óleo ou graxa no sistema.">
                                                N&iacute;vel Baixo
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaRompidoCheckbox">
                                            <label class="form-check-label" for="causaRompidoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Componente ou elemento rompido, ou seja, interrompida sua continuidade estrutural.">
                                                Rompido
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="causaSobrecargaDeTensaoCheckbox">
                                            <label class="form-check-label" for="causaSobrecargaDeTensaoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Solicita&ccedil;&atilde;o do equipamento acima de sua capacidade m&aacute;xima de suportar tens&atilde;o.">
                                                Sobrecarga de tens&atilde;o
                                            </label>
                                        </div>

                                        <div class="col-sm-12">
                                            <input type="checkbox" class="form-check-input" onclick="let input = document.getElementById('causaOthersCheckboxValue'); if(this.checked){ input.disabled = false;input.style = 'block'; input.focus();}else{input.disabled=true;input.style='display: none;';}"/>
                                            <label class="form-check-label" for="causaOthersCheckboxValue">Outros</label>
                                            <input class="col-12" id="causaOthersCheckboxValue" name="causaOthersCheckboxValue" disabled="disabled" style="display: none;"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="mb-2" for="descricaoDefeitoFalha">Descreva a causa do defeito ou falha encontrado:</label>
                                    <textarea class="form-control" rows="2"  id="descricaoCausaDefeitoFalha" aria-label="Descri&ccedil;&atilde;o da causa do  defeito ou falha"></textarea>
                                </div>

                                <label class="form-label">Qual o tipo de interven&ccedil;&atilde;o?</label>

                                <div class="mb-3 form-check">
                                    <div class="row">

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoMecanicaCheckbox">
                                            <label class="form-check-label" for="intervencaoMecanicaCheckbox">Mec&acirc;nica</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoPinturaCheckbox">
                                            <label class="form-check-label" for="intervencaoPinturaCheckbox">Pintura</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoUsinagemCheckbox">
                                            <label class="form-check-label" for="intervencaoUsinagemCheckbox">Usinagem</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoEletricaCheckbox">
                                            <label class="form-check-label" for="intervencaoEletricaCheckbox">El&eacute;trica</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoFunilariaCheckbox">
                                            <label class="form-check-label" for="intervencaoFunilariaCheckbox">Funilaria</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoCaldeirariaCheckbox">
                                            <label class="form-check-label" for="intervencaoCaldeirariaCheckbox">Caldeiraria</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoHidraulicoCheckbox">
                                            <label class="form-check-label" for="intervencaoHidraulicoCheckbox">Hidraulico</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoSoldagemCheckbox">
                                            <label class="form-check-label" for="intervencaoSoldagemCheckbox">Soldagem</label>
                                        </div>

                                        <div class="col-sm-12">
                                            <input type="checkbox" class="form-check-input" onclick="let input = document.getElementById('tipoIntervencaoOthersCheckboxValue'); if(this.checked){ input.disabled = false;input.style = 'block'; input.focus();}else{input.disabled=true;input.style='display: none;';}"/>
                                            <label class="form-check-label" for="tipoIntervencaoOthersCheckboxValue">Outros</label>
                                            <input class="col-12" id="tipoIntervencaoOthersCheckboxValue" name="causaOthersCheckboxValue" disabled="disabled" style="display: none;"/>
                                        </div>
                                    </div>
                                </div>

                                <label class="form-label">Interven&ccedil;&atilde;o:</label>

                                <div class="mb-3 form-check">
                                    <div class="row">

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoAcopladoCheckbox">
                                            <label class="form-check-label" for="intervencaoAcopladoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Acoplamento de partes de um sistema.">
                                                Acoplado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoDesacopladoCheckbox">
                                            <label class="form-check-label" for="intervencaoDesacopladoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Desacoplamento de componente ou equipamento.">
                                                Desacoplado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoInstaladoCheckbox">
                                            <label class="form-check-label" for="intervencaoInstaladoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content=" Instala&ccedil;&atilde;o de um determinado componente ou equipamento pela primeira vez, ou seja, ele n&atilde;o existia na estrutura anteriormente.">
                                                Instalado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoRearmadoCheckbox">
                                            <label class="form-check-label" for="intervencaoRearmadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Reenergiza&ccedil;&atilde;o do equipamento.">
                                                Rearmado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoSoldadoCheckbox">
                                            <label class="form-check-label" for="intervencaoSoldadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Solda de um determinado componente ou equipamento.">
                                                Soldado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoAjustadoCheckbox">
                                            <label class="form-check-label" for="intervencaoAjustadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Ajuste, regula&ccedil;&atilde;o ou calibra&ccedil;&atilde;o do equipamento ou componente.">
                                                Ajustado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoFabricadoCheckbox">
                                            <label class="form-check-label" for="intervencaoFabricadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content=" Quando a OM tratar da fabrica&ccedil;&atilde;o de alguma pe&ccedil;a para reparo de ativo.">
                                                Fabricado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoLimpezaCheckbox">
                                            <label class="form-check-label" for="intervencaoLimpezaCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Limpeza do componente ou equipamento.">
                                                Limpeza
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoRecuperacaoCheckbox">
                                            <label class="form-check-label" for="intervencaoRecuperacaoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Recuperado determinado equipamento ou componente, reutilizando-o.">
                                                Recupera&ccedil;&atilde;o
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoSubstituidoCheckbox">
                                            <label class="form-check-label" for="intervencaoSubstituidoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Troca do equipamento ou componente.">
                                                Substitu&iacute;do
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoAlinhadoCheckbox">
                                            <label class="form-check-label" for="intervencaoAlinhadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Alinhamento do componente.">
                                                Alinhado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoFixadoCheckbox">
                                            <label class="form-check-label" for="intervencaoFixadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Fixa&ccedil;&atilde;o de determinado componente ou equipamento.">
                                                Fixado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoLubrificadoCheckbox">
                                            <label class="form-check-label" for="intervencaoLubrificadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Lubrifica&ccedil;&atilde;o, troca ou complementa&ccedil;&atilde;o de lubrificante.">
                                                Lubrificado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoRepostoCheckbox">
                                            <label class="form-check-label" for="intervencaoRepostoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Reposi&ccedil;&atilde;o de componente no equipamento, que se encontrava operando sem ele.">
                                                Reposto
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoApertadoCheckbox">
                                            <label class="form-check-label" for="intervencaoApertadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Aperto de determinado componente">
                                                Apertado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoInspecionadoCheckbox">
                                            <label class="form-check-label" for="intervencaoInspecionadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Execu&ccedil;&atilde;o de uma inspe&ccedil;&atilde;o">
                                                Inspecionado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoModificadoCheckbox">
                                            <label class="form-check-label" for="intervencaoModificadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Modifica&ccedil;&atilde;o (altera&ccedil;&atilde;o) do projeto anterior do equipamento">
                                                Modificado
                                            </label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" class="form-check-input" id="intervencaoRetiradoCheckbox">
                                            <label class="form-check-label" for="intervencaoModificadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Remo&ccedil;&atilde;o de um determinado elemento da estrutura, ele pertencendo ou n&atilde;o a ela.">
                                                Retirado
                                            </label>
                                        </div>

                                        <div class="col-sm-12">
                                            <input type="checkbox" class="form-check-input" onclick="let input = document.getElementById('intervencaoOthersCheckboxValue'); if(this.checked){ input.disabled = false;input.style = 'block'; input.focus();}else{input.disabled=true;input.style='display: none;';}"/>
                                            <label class="form-check-label" for="intervencaoOthersCheckboxValue" data-bs-toggle="popover" data-bs-trigger="hover"
                                                   data-bs-content="Em caso de interven&ccedil;&atilde;o n&atilde;o listada acima, o respons&aacute;vel por preencher o formul&aacute;rio poder&aacute; acrescentar outras interven&ccedil;&otilde;es nos campos em aberto.">
                                                Outros
                                            </label>
                                            <input class="col-12" id="intervencaoOthersCheckboxValue" name="causaOthersCheckboxValue" disabled="disabled" style="display: none;"/>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="mb-2" for="descricaoIntervencoes">Descri&ccedil;&atilde;o das interven&ccedil;&otilde;es:</label>
                                    <textarea class="form-control" rows="5"  id="descricaoIntervencoes" aria-label="Descri&ccedil;&atilde;o das interven&ccedil;&otilde;es" placeholder="Descreva de maneira detalhada"></textarea>
                                </div>

                                <table class="mantenedoresResponsaveis table table-hover">
                                    <thead>
                                    <tr>
                                        <th colspan="5" class="text-center fs-5">Mantenedores Respons&aacute;veis</th>
                                    </tr>
                                    <tr>
                                        <th rowspan="2" class="text-center align-middle" style="border-bottom-color: black;">Nome</th>
                                        <th colspan="2" class="text-center">In&iacute;cio do servi&ccedil;o</th>
                                        <th colspan="2" class="text-center">Fim do servi&ccedil;o</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Data</th>
                                        <th class="text-center">Hora</th>
                                        <th class="text-center">Data</th>
                                        <th class="text-center">Hora</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center maintenanceResponsible"></td>
                                        <td class="text-center maintenanceStartedDate"></td>
                                        <td class="text-center maintenanceStartedTime"></td>
                                        <td class="text-center maintenanceFinishedDate"></td>
                                        <td class="text-center maintenanceFinishedTime"></td>
                                    </tr>

                                    </tbody>
                                </table>

                                <table class="materiaisutilizados table table-hover">
                                    <thead>
                                    <tr>
                                        <th colspan="5" class="text-center fs-5">Materiais Utilizados</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center align-middle">Descri&ccedil;&atilde;o</th>
                                        <th class="text-center">Quantidade</th>
                                        <th class="text-center">Custo Unit&aacute;rio</th>
                                        <th class="text-center">Custo Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="text-center maintenanceProductUsed"></td>
                                        <td class="text-center maintenanceProductQuatity"></td>
                                        <td class="text-center maintenanceProductUnitCost"></td>
                                        <td class="text-center maintenanceProductTotalCost"></td>
                                    </tr>
                                    </tbody>
                                </table>
									     <input type="submit" value="ir">
                                <button type="submit" class="btn btn-primary">Solicitar</button>
                            </form>	
                        </div><br>
            </form>
        </td>
    </tr>
</table>

</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>
