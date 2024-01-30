<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário</title>
    <!-- Adicione aqui os links para os arquivos CSS e JavaScript necessários para o Bootstrap e Popper.js -->
    <!-- <link rel="stylesheet" href="link-para-bootstrap.css"> -->
    <!-- <script src="link-para-bootstrap-bundle.js"></script> -->
    <!-- <script src="link-para-popper.js"></script> -->
</head>
<body>
<br>
    <form method="post" action="processa_formulario.php">
    <div>
    						<label>Qual tipo de manutenção você pretende solicitar?</label>
    				<div>
        					<input type="radio" name="radio-maintenance" id="corretiva" value="corretiva">
        					<label for="corretiva">Corretiva</label>
    				</div>
    				<div>
        					<input type="radio" name="radio-maintenance" id="preditiva" value="preditiva">
        					<label for="preditiva">Preditiva</label>
    				</div>
    				<div>
        					<input type="radio" name="radio-maintenance" id="preventiva" value="preventiva">
        					<label for="preventiva">Preventiva</label>
    				</div>
					</div>
				<br> 
                                 <div>
                                      <label>Quais os sistemas afetados?</label>                                      
                                 <div>
                                    <input type="checkbox" id="cabineCheckbox" name="cabineCheckbox" value="cabine" >
                                    <label for="cabineCheckbox">Cabine</label>
                                 </div>     

                         			<div>
        										<input type="checkbox" id="direcaoCheckbox" name="direcaoCheckbox" value="direcao">
        										<label for="direcaoCheckbox">Dire&ccedil;&atilde;o</label>
    										</div>
    										
    										<div>
                                    <input type="checkbox" id="combustivelCheckbox" name="combustivelCheckbox" value="combustivel">
                                    <label for="combustivelCheckbox">Combust&iacute;vel</label>
                                 </div>
                                 
                             		<div>
    											<input type="checkbox" id="medicaoControleCheckbox" name="medicaoControleCheckbox" value="medicaoControle">
    											<label for="medicaoControleCheckbox">Medi&ccedil;&atilde;o de controle</label>
											</div>

                             	  	<div>
    											<input type="checkbox" id="protecaoImpactosCheckbox" name="protecaoImpactosCheckbox" value="protecaoImpactos">
    											<label for="protecaoImpactosCheckbox">Prote&ccedil;&atilde;o contra impactos</label>
											</div>
											<div>
    											<input type="checkbox" id="transmissaoCheckbox" name="transmissaoCheckbox" value="transmissaoCheckbox">
    											<label for="transmissaoCheckbox">Transmiss&atilde;o</label>
											</div>

											<div>
    											<input type="checkbox" id="estruturalCheckbox" name="estruturalCheckbox" value="estruturalCheckbox">
    											<label for="estruturalCheckbox">Estrutural</label>
											</div>

											<div>
    											<input type="checkbox" id="acoplamentoCheckbox" name="acoplamentoCheckbox" value="acoplamentoCheckbox">
    											<label for="acoplamentoCheckbox">Acomplamento</label>
											</div>

											<div>
    											<input type="checkbox" id="controleEletronicoCheckbox" name="controleEletronicoCheckbox" value="controleEletronicoCheckbox">
    											<label for="controleEletronicoCheckbox">Controle eletr&ocirc;nico</label>
											</div>

											<div>
    											<input type="checkbox" id="exaustaoCheckbox" name="exaustaoCheckbox" value="exaustaoCheckbox">
    											<label for="exaustaoCheckbox">Exaust&atilde;o</label>
											</div>

<div>
    <input type="checkbox" id="propulsaoCheckbox" name="propulsaoCheckbox" value="propulsaoCheckbox">
    <label for="propulsaoCheckbox">Propuls&atilde;o</label>
</div>

<div>
    <input type="checkbox" id="protecaoContraIncendioCheckbox" name="protecaoContraIncendioCheckbox" value="protecaoContraIncendioCheckbox">
    <label for="protecaoContraIncendioCheckbox">Porte&ccedil;&atilde;o contra inc&ecirc;ndio</label>
</div>

<div>
    <input type="checkbox" id="ventilacaoCheckbox" name="ventilacaoCheckbox" value="ventilacaoCheckbox">
    <label for="ventilacaoCheckbox">Ventila&ccedil;&atilde;o</label>
</div>

<div>
    <input type="checkbox" id="tanqueCheckbox" name="tanqueCheckbox" value="tanqueCheckbox">
    <label for="tanqueCheckbox">Tanque</label>
</div>

<div>
    <input type="checkbox" id="arrefecimentoCheckbox" name="arrefecimentoCheckbox" value="arrefecimentoCheckbox">
    <label for="arrefecimentoCheckbox">Arrefecimento</label>
</div>

<div>
    <input type="checkbox" id="descargaCheckbox" name="descargaCheckbox" value="descargaCheckbox">
    <label for="descargaCheckbox">Descarga</label>
</div>

<div>
    <input type="checkbox" id="freiosCheckbox" name="freiosCheckbox" value="freiosCheckbox">
    <label for="freiosCheckbox">Freios</label>
</div>

<div>
    <input type="checkbox" id="protecaoAmbientalCheckbox" name="protecaoAmbientalCheckbox" value="protecaoAmbientalCheckbox">
    <label for="protecaoAmbientalCheckbox">Prote&ccedil;&atilde;o ambiental</label>
</div>

<div>
    <input type="checkbox" id="suspensaoCheckbox" name="suspensaoCheckbox" value="suspensaoCheckbox">
    <label for="suspensaoCheckbox">Suspens&atilde;o</label>
</div>

<div>
    <input type="checkbox" id="eletricoCheckbox" name="eletricoCheckbox" value="eletricoCheckbox">
    <label for="eletricoCheckbox">El&eacute;trico</label>
</div>

<div>
    <input type="text" id="componentesAfetados" name="componentesAfetados" value="">
    <label for="eletricoCheckbox"> Quais os componentes afetados? </label>
</div>    	

<h2>Quais os sintomas detectados </h2>    
    
 <br> 
        <div>
            <input type="checkbox" id="abertoCheckbox" name="abertoCheckbox" value="Aberto">
            <label for="abertoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Descontinuidade em um circuito fechado">Aberto</label>
        </div>

        <div>
            <input type="checkbox" id="desvioLateralCheckbox" name="desvioLateralCheckbox" value="Desvio lateral">
            <label for="desvioLateralCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Durante a opera&ccedil;&atilde;o, &eacute; identificado equipamento
            “puxando” para um dos lados.">Desvio lateral</label>
        </div>

        <div>
    <input type="checkbox" id="queimadoCheckbox" name="queimadoCheckbox" value="Queimado">
    <label for="queimadoCheckbox"  data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Queima do equipamento ou componente">Queimado</label>
</div>

<div>
    <input type="checkbox" id="semFreioCheckbox" name="semFreioCheckbox" value="Sem freio">
    <label for="semFreioCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Impossibilidade de diminuir a velocidade de um equipamento
    at&eacute; sua parada total, por n&atilde;o funcionamento do sistema de freio.">Sem freio</label>
</div>

<div>
    <input type="checkbox" id="sujoCheckbox" name="sujoCheckbox" value="Sujo">
    <label for="sujoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Exist&ecirc;ncia de sujeira que comprometa funcionamento do
    equipamento.">Sujo</label>
</div>

<div>
    <input type="checkbox" id="vazandoCheckbox" name="vazandoCheckbox" value="Vazando">
    <label for="vazandoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Vazamento constante no equipamento.">Vazando</label>
</div>

<div>
    <input type="checkbox" id="baixoRendimentoCheckbox" name="baixoRendimentoCheckbox" value="Baixo Rendimento">
    <label for="baixoRendimentoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Queda no rendimento de maquin&aacute;rio. Exemplo: o
    equipamento levando 1 minuto para efetuar uma tarefa, quando
    normalmente a faria em 45 segundos.">Baixo Rendimento</label>
</div>

<div>
    <input type="checkbox" id="empenadoCheckbox" name="empenadoCheckbox" value="Empenado">
    <label for="empenadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Equipamento e/ou estrutura se constituindo em um empeno,
    ou seja, uma altera&ccedil;&atilde;o em seu corpo, impossibilitando seu ajuste em
    outro equipamento ou elemento.">Empenado</label>
</div>

<div>
    <input type="checkbox" id="rompidoCheckbox" name="rompidoCheckbox" value="Rompido">
    <label for="rompidoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Dano no equipamento provocando separa&ccedil;&atilde;o entre suas
    partes, que deveriam ser cont&iacute;nuas.">Rompido</label>
</div>

<div>
    <input type="checkbox" id="semVelocidadeCheckbox" name="semVelocidadeCheckbox" value="Sem velocidade">
    <label for="semVelocidadeCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Equipamento n&atilde;o atingindo velocidade necess&aacute;ria para
    seu funcionamento.">Sem velocidade</label>
</div>

<div>
    <input type="checkbox" id="travadoCheckbox" name="travadoCheckbox" value="Travado">
    <label for="travadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Equipamento se encontra travado, sem movimento.">Travado</label>
</div>

<div>
    <input type="checkbox" id="vibrandoCheckbox" name="vibrandoCheckbox" value="Vibrando">
    <label for="vibrandoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Vibra&ccedil;&atilde;o mec&acirc;nica, acima do normal do equipamento">Vibrando</label>
</div>

<div>
    <input type="checkbox" id="desarmadoCheckbox" name="desarmadoCheckbox" value="Desarmado">
    <label for="desarmadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Equipamento n&atilde;o recebendo alimenta&ccedil;&atilde;o de sua fonte de energia.">Desarmado</label>
</div>

<div>
    <input type="checkbox" id="preventivaPreditivaCheckbox" name="preventivaPreditivaCheckbox" value="Preventiva ou Preditiva">
    <label for="preventivaPreditivaCheckbox">Preventiva ou Preditiva</label>
</div>

<div>
    <input type="checkbox" id="ruidoAnormalCheckbox" name="ruidoAnormalCheckbox" value="Ru&iacute;do Anormal">
    <label for="ruidoAnormalCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Equipamento apresentando ru&iacute;do fora de sua
    normalidade.">Ru&iacute;do Anormal</label>
</div>

<div>
    <input type="checkbox" id="soltoCheckbox" name="soltoCheckbox" value="Solto">
    <label for="soltoCheckbox"  data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Inexist&ecirc;ncia de uni&atilde;o entre componentes que deveriam estar
    interligados.">Solto</label>
</div>

<div>
    <input type="checkbox" id="trincadoCheckbox" name="trincadoCheckbox" value="Trincado">
    <label for="trincadoCheckbox" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Dano no equipamento constitu&iacute;do por trinca, ou seja, uma
    fissura vis&iacute;vel.">Trincado</label>
</div>

<div>
    <input type="checkbox" id="othersCheckboxValue" name="othersCheckboxValue" value="Outros" onclick="let input = document.getElementById('othersCheckboxValue'); if(this.checked){ input.disabled = false;input.style = 'block'; input.focus();}else{input.disabled=true;input.style='display: none;';}">
    <label for="othersCheckboxValue" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="Em caso de sintoma n&atilde;o listado acima, o respons&aacute;vel por preencher o
    formul&aacute;rio poder&aacute; acrescentar outros sintomas nos campos em aberto.">Outros</label>
    <input id="othersCheckboxValue" name="othersCheckboxValue" disabled="disabled" style="display: none;">
</div>      

        <br>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
