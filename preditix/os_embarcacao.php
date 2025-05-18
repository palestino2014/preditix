<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verificar se foi recebido um ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta SQL para buscar o registro específico
    $sql = "SELECT * FROM ativo_embarcacao WHERE id = $id";
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
    <title>OS - Embarcação</title>
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

        /* Responsividade */
        @media (max-width: 768px) {
            th, td {
                padding: 5px; /* Reduzir padding */
            }

            table, th, td {
                font-size: 12px; /* Diminuir o tamanho da fonte */
            }

            textarea, input[type="text"], input[type="date"], input[type="time"] {
                width: 100%; /* Ajustar largura para caber na tela */
            }

            button {
                width: 100%; /* Ajustar botão para largura total */
                margin-top: 10px; /* Espaço acima do botão */
            }
        }
    </style>
</head>
<body>

<h2>OS - Embarcação</h2>

<table>
    <tr>
        <th>ID</th>
        <td><?php echo $row["id"]; ?></td>
    </tr>
    <tr>
        <th>Tipo de Embarcação</th>
        <td><?php echo $row["tipo_embarcacao"]; ?></td>
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
            <form action="processa_formulario_embarcacao.php" method="post">
                

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
            
            <td class="text-center col-sm-6">Controle</td>
            <td class="text-center col-sm-3 id">
            <input type="text" name="id" value="<?php echo $row["id"]; ?>" readonly>
            
        </tr>
    </tbody>
</table>
<br>
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
				<br><hr>
				
				<div>
    <label>Sistema(s) afetado(s) - Somente para manutenções corretivas</label>
    <div>
        <input type="checkbox" id="arrefecimentoCheckbox" name="arrefecimentoCheckbox" value="arrefecimentoCheckbox">
        <label for="arrefecimentoCheckbox">Sistema de arrefecimento</label>
    </div>
    <div>
        <input type="checkbox" id="medicaoControleCheckbox" name="medicaoControleCheckbox" value="medicaoControleCheckbox">
        <label for="medicaoControleCheckbox">Sistema de medição e controle</label>
    </div>
    <div>
        <input type="checkbox" id="protecaoAmbientalCheckbox" name="protecaoAmbientalCheckbox" value="protecaoAmbientalCheckbox">
        <label for="protecaoAmbientalCheckbox">Sistema de proteção ambiental</label>
    </div>
    <div>
        <input type="checkbox" id="estruturalCheckbox" name="estruturalCheckbox" value="estruturalCheckbox">
        <label for="estruturalCheckbox">Estrutura geral</label>
    </div>
    <div>
        <input type="checkbox" id="combustivelCheckbox" name="combustivelCheckbox" value="combustivelCheckbox">
        <label for="combustivelCheckbox">Sistema de combustível</label>
    </div>
    <div>
        <input type="checkbox" id="exaustaoCheckbox" name="exaustaoCheckbox" value="exaustaoCheckbox">
        <label for="exaustaoCheckbox">Sistema de exaustão</label>
    </div>
    <div>
        <input type="checkbox" id="protecaoIncendioCheckbox" name="protecaoIncendioCheckbox" value="protecaoIncendioCheckbox">
        <label for="protecaoIncendioCheckbox">Sistema de proteção contra incêndio</label>
    </div>
    <div>
        <input type="checkbox" id="tanqueCheckbox" name="tanqueCheckbox" value="tanqueCheckbox">
        <label for="tanqueCheckbox">Tanque de armazenamento</label>
    </div>
    <div>
        <input type="checkbox" id="hidraulicoCheckbox" name="hidraulicoCheckbox" value="hidraulicoCheckbox">
        <label for="hidraulicoCheckbox">Sistema hidráulico</label>
    </div>
    <div>
        <input type="checkbox" id="motorCheckbox" name="motorCheckbox" value="motorCheckbox">
        <label for="motorCheckbox">Motor</label>
    </div>
    <div>
        <input type="checkbox" id="eletricoCheckbox" name="eletricoCheckbox" value="eletricoCheckbox">
        <label for="eletricoCheckbox">Sistema elétrico</label>
    </div>
    <div>
        <input type="checkbox" id="outroCheckbox" name="outroCheckbox" value="outroCheckbox">
        <label for="outroCheckbox">Outro</label>
    </div>
</div><hr>

				
				
                                 <div><br>
                                      <label>Quais os sistemas afetados?</label> 		<br>										<br>

                                    
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
<br><hr> 
                           </div><br>
                             <br>Quais os sintomas detectados?<br>
                             <br><div>
    <div>
        <div>
            <input type="checkbox" id="abertoCheckbox" name="abertoCheckbox" value="Aberto">
            <label for="abertoCheckbox" >Aberto</label>
        </div>
        

        <div>
            <input type="checkbox" id="desvioLateralCheckbox" name="desvioLateralCheckbox" value="Desvio lateral">
            <label for="desvioLateralCheckbox">Desvio lateral</label>
        </div>
        

        <div>
    			<input type="checkbox" id="queimadoCheckbox" name="queimadoCheckbox" value="Queimado">
    			<label for="queimadoCheckbox" >Queimado</label>
			</div>

			<div>
    			<input type="checkbox" id="semFreioCheckbox" name="semFreioCheckbox" value="Sem freio">
    			<label for="semFreioCheckbox" >Sem freio</label>
			</div>

			<div>
    			<input type="checkbox" id="sujoCheckbox" name="sujoCheckbox" value="Sujo">
    			<label for="sujoCheckbox" >Sujo</label>
			</div>

			<div>
    			<input type="checkbox" id="vazandoCheckbox" name="vazandoCheckbox" value="Vazando">
    			<label for="vazandoCheckbox" >Vazando</label>
			</div>

			<div>
    			<input type="checkbox" id="baixoRendimentoCheckbox" name="baixoRendimentoCheckbox" value="Baixo Rendimento">
    			<label for="baixoRendimentoCheckbox" >Baixo Rendimento</label>
			</div>

			<div>
    			<input type="checkbox" id="empenadoCheckbox" name="empenadoCheckbox" value="Empenado">
    			<label for="empenadoCheckbox" >Empenado</label>
			</div>

			<div>
    			<input type="checkbox" id="rompidoCheckbox" name="rompidoCheckbox" value="Rompido">
   			<label for="rompidoCheckbox" >Rompido</label>
			</div>

			<div>
    			<input type="checkbox" id="semVelocidadeCheckbox" name="semVelocidadeCheckbox" value="Sem velocidade">
    			<label for="semVelocidadeCheckbox" >Sem velocidade</label>
			</div>

			<div>
    			<input type="checkbox" id="travadoCheckbox" name="travadoCheckbox" value="Travado">
    			<label for="travadoCheckbox" >Travado</label>
			</div>

			<div>
    			<input type="checkbox" id="vibrandoCheckbox" name="vibrandoCheckbox" value="Vibrando">
    			<label for="vibrandoCheckbox" >Vibrando</label>
			</div>

			<div>
    			<input type="checkbox" id="desarmadoCheckbox" name="desarmadoCheckbox" value="Desarmado">
   			<label for="desarmadoCheckbox" >Desarmado</label>
			</div>

			<div>
    			<input type="checkbox" id="preventivaPreditivaCheckbox" name="preventivaPreditivaCheckbox" value="Preventiva ou Preditiva">
    			<label for="preventivaPreditivaCheckbox">Preventiva ou Preditiva</label>
			</div>

			<div>
    			<input type="checkbox" id="ruidoAnormalCheckbox" name="ruidoAnormalCheckbox" value="Ru&iacute;do Anormal">
    			<label for="ruidoAnormalCheckbox" >Ruido Anormal</label>
			</div>

			<div>
    			<input type="checkbox" id="soltoCheckbox" name="soltoCheckbox" value="Solto">
    			<label for="soltoCheckbox" >Solto</label>
			</div>

			<div>
    			<input type="checkbox" id="trincadoCheckbox" name="trincadoCheckbox" value="Trincado">
    			<label for="trincadoCheckbox" >Trincado</label>
				</div>				  
    </div>
</div>
     <br><hr><br>        
		
    <label class="form-label">Quais s&atilde;o as causas do defeito/falha?</label><br>                              
                                
                                     
                                
                                <div>
                                    <div>
                                        <div ><br>
                                            <input type="checkbox" id="causaNaoIdentificadaCheckbox" name="causaNaoIdentificadaCheckbox" value="causaNaoIdentificadaCheckbox">
                                            <label for="causaNaoIdentificadaCheckbox" >N&atilde;o identificada </label>                                      
                                            
                                        </div>

                                        <div>
                                            <input type="checkbox" id="causaDefeitoDeFabricaCheckbox"name="causaDefeitoDeFabricaCheckbox" value="causaDefeitoDeFabricaCheckbox" >
                                            <label for="causaDefeitoDeFabricaCheckbox" >Defeito de f&aacute;brica </label>
                                        </div>


                                        <div >
                                            <input type="checkbox" class="form-check-input" id="causaDesnivelamentoCheckbox" name="causaDesnivelamentoCheckbox" value="causaDesnivelamentoCheckbox">
                                            <label for="causaDesnivelamentoCheckbox">Desnivelamento </label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaDestensionamentoCheckbox" name="causaDestensionamentoCheckbox" value="causaDestensionamentoCheckbox">
                                            <label for="causaDestensionamentoCheckbox" >Destensionamento </label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaFissuraCheckbox" name="causaFissuraCheckbox" value="causaFissuraCheckbox">
                                            <label for="causaFissuraCheckbox" >Fissura </label>
                                        </div>

                                        <div>
                                            <input type="checkbox" id="causaGastoCheckbox" name="causaGastoCheckbox" value="causaGastoCheckbox">
                                            <label for="causaGastoCheckbox" >Gasto</label>
                                        </div>

                                        <div>
                                            <input type="checkbox" id="causaPreventivaPreditivaCheckbox" name="causaPreventivaPreditivaCheckbox" value="causaPreventivaPreditivaCheckbox">
                                            <label for="causaPreventivaPreditivaCheckbox" >Preventiva ou Preditiva</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaRotaDeInspecaoCheckbox" name="causaRotaDeInspecaoCheckbox" value="causaRotaDeInspecaoCheckbox">
                                            <label for="causaRotaDeInspecaoCheckbox" >Rota de inspe&ccedil;&atilde;o</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaSobrecargaDeCorrenteCheckbox" name="causaSobrecargaDeCorrenteCheckbox" value="causaSobrecargaDeCorrenteCheckbox">
                                            <label for="causaSobrecargaDeCorrenteCheckbox" >Sobrecarga de corrente</label>
                                        </div>

                                        <div>
                                            <input type="checkbox" id="causaDesalinhamentoCheckbox" name="causaDesalinhamentoCheckbox" value="causaDesalinhamentoCheckbox">
                                            <label for="causaDesalinhamentoCheckbox" > Desalinhamento </label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaFaltaDeProtecaoCheckbox" name="causaFaltaDeProtecaoCheckbox" value="causaFaltaDeProtecaoCheckbox">
                                            <label for="causaFaltaDeProtecaoCheckbox" >Falta de prote&ccedil;&atilde;o</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaEngripamentoCheckbox" name="causaEngripamentoCheckbox" value="causaEngripamentoCheckbox">
                                            <label for="causaEngripamentoCheckbox" >Engripamento</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaFolgaCheckbox" name="causaFolgaCheckbox" value="causaFolgaCheckbox">
                                            <label for="causaFolgaCheckbox" >Folga</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaSobrecargaDePesoCheckbox" name="causaSobrecargaDePesoCheckbox" value="causaSobrecargaDePesoCheckbox">
                                            <label for="causaSobrecargaDePesoCheckbox" >Sobrecarga de peso</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaSubdimensionamentoCheckbox" name="causaSubdimensionamentoCheckbox" value="causaSubdimensionamentoCheckbox">
                                            <label for="causaSubdimensionamentoCheckbox" >Subdimensionamento</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaDesbalanceamentoCheckbox" name="causaDesbalanceamentoCheckbox" value="causaDesbalanceamentoCheckbox">
                                            <label for="causaDesbalanceamentoCheckbox" >Desbalanceamento</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaDesregulamentoCheckbox" name="causaDesregulamentoCheckbox" value="causaDesregulamentoCheckbox">
                                            <label for="causaDesregulamentoCheckbox">Desregulamento</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaFadigaCheckbox" name="causaFadigaCheckbox" value="causaFadigaCheckbox">
                                            <label for="causaFadigaCheckbox" >Fadiga</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaForaDeEspecificacaoCheckbox" name="causaForaDeEspecificacaoCheckbox" value="causaForaDeEspecificacaoCheckbox">
                                            <label for="causaForaDeEspecificacaoCheckbox" >Fora de especifica&ccedil;&atilde;o</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaNivelBaixoCheckbox" name="causaNivelBaixoCheckbox" value="causaNivelBaixoCheckbox">
                                            <label for="causaNivelBaixoCheckbox" >N&iacute;vel Baixo</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaRompidoCheckbox" name="causaRompidoCheckbox" value="causaRompidoCheckbox">
                                            <label for="causaRompidoCheckbox" >Rompido </label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="causaSobrecargaDeTensaoCheckbox" name="causaSobrecargaDeTensaoCheckbox" value="causaSobrecargaDeTensaoCheckbox">
                                            <label for="causaSobrecargaDeTensaoCheckbox" >Sobrecarga de tens&atilde;o</label>
                                        </div>
                                    <br><hr>
                                    </div>
                                </div><br>

                                <label class="form-label">Qual o tipo de interven&ccedil;&atilde;o?</label><br>

                                <div class="mb-3 form-check">
                                    <div class="row">

                                        <div ><br>
                                            <input type="checkbox" id="intervencaoMecanicaCheckbox" name="intervencaoMecanicaCheckbox" value="intervencaoMecanicaCheckbox">
                                            <label for="intervencaoMecanicaCheckbox">Mec&acirc;nica</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoPinturaCheckbox" name="intervencaoPinturaCheckbox" value="intervencaoPinturaCheckbox">
                                            <label for="intervencaoPinturaCheckbox">Pintura</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoUsinagemCheckbox" name="intervencaoUsinagemCheckbox" value="intervencaoUsinagemCheckbox">
                                            <label for="intervencaoUsinagemCheckbox">Usinagem</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoEletricaCheckbox" name="intervencaoEletricaCheckbox" value="intervencaoEletricaCheckbox">
                                            <label  for="intervencaoEletricaCheckbox">El&eacute;trica</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoFunilariaCheckbox" name="intervencaoFunilariaCheckbox" value="intervencaoFunilariaCheckbox">
                                            <label for="intervencaoFunilariaCheckbox">Funilaria</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoCaldeirariaCheckbox" name="intervencaoCaldeirariaCheckbox" value="intervencaoCaldeirariaCheckbox">
                                            <label for="intervencaoCaldeirariaCheckbox">Caldeiraria</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoHidraulicoCheckbox" name="intervencaoHidraulicoCheckbox" value="intervencaoHidraulicoCheckbox"> 
                                            <label for="intervencaoHidraulicoCheckbox">Hidraulico</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoSoldagemCheckbox" name="intervencaoSoldagemCheckbox" value="intervencaoSoldagemCheckbox">
                                            <label for="intervencaoSoldagemCheckbox">Soldagem</label><br>
                                        </div>
                                    </div>
                                </div>
										<br><hr><br> 

                                <label class="form-label">Interven&ccedil;&atilde;o:</label><br>

                                <div class="mb-3 form-check">
                                    <div class="row">

                                        <div ><br>
                                            <input type="checkbox" id="intervencaoAcopladoCheckbox" name="intervencaoAcopladoCheckbox" value="intervencaoAcopladoCheckbox">
                                            <label for="intervencaoAcopladoCheckbox" >Acoplado</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoDesacopladoCheckbox" name="intervencaoDesacopladoCheckbox" value="intervencaoDesacopladoCheckbox">
                                            <label for="intervencaoDesacopladoCheckbox" >Desacoplado</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoInstaladoCheckbox" name="intervencaoInstaladoCheckbox" value="intervencaoInstaladoCheckbox">
                                            <label for="intervencaoInstaladoCheckbox" >Instalado</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoRearmadoCheckbox" name="intervencaoRearmadoCheckbox" value="intervencaoRearmadoCheckbox">
                                            <label class="form-check-label" for="intervencaoRearmadoCheckbox" >Rearmado</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" id="intervencaoSoldadoCheckbox" name="intervencaoSoldadoCheckbox" value="intervencaoSoldadoCheckbox">
                                            <label for="intervencaoSoldadoCheckbox" >Soldado</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoAjustadoCheckbox" name="intervencaoAjustadoCheckbox" value="intervencaoAjustadoCheckbox">
                                            <label for="intervencaoAjustadoCheckbox" >Ajustado</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoFabricadoCheckbox" name="intervencaoFabricadoCheckbox" value="intervencaoFabricadoCheckbox">
                                            <label for="intervencaoFabricadoCheckbox" >Fabricado </label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoLimpezaCheckbox" name="intervencaoLimpezaCheckbox" value="intervencaoLimpezaCheckbox">
                                            <label for="intervencaoLimpezaCheckbox" >Limpeza</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoRecuperacaoCheckbox" name="intervencaoRecuperacaoCheckbox" value="intervencaoRecuperacaoCheckbox">
                                            <label for="intervencaoRecuperacaoCheckbox" >Recupera&ccedil;&atilde;o</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoSubstituidoCheckbox" name="intervencaoSubstituidoCheckbox" value="intervencaoSubstituidoCheckbox">
                                            <label for="intervencaoSubstituidoCheckbox" >Substitu&iacute;do</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoAlinhadoCheckbox" name="intervencaoAlinhadoCheckbox" value="intervencaoAlinhadoCheckbox">
                                            <label for="intervencaoAlinhadoCheckbox" >Alinhado</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoFixadoCheckbox" name="intervencaoFixadoCheckbox" value="intervencaoFixadoCheckbox">
                                            <label for="intervencaoFixadoCheckbox" >Fixado</label>
                                        </div>

                                        <div class="col-sm-4">
                                            <input type="checkbox" id="intervencaoLubrificadoCheckbox" name="intervencaoLubrificadoCheckbox" value="intervencaoLubrificadoCheckbox">
                                            <label for="intervencaoLubrificadoCheckbox" >Lubrificado</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoRepostoCheckbox" name="intervencaoRepostoCheckbox" value="intervencaoRepostoCheckbox">
                                            <label for="intervencaoRepostoCheckbox" >Reposto</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoApertadoCheckbox" name="intervencaoApertadoCheckbox" value="intervencaoApertadoCheckbox">
                                            <label for="intervencaoApertadoCheckbox" > Apertado</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoInspecionadoCheckbox" name="intervencaoInspecionadoCheckbox" value="intervencaoInspecionadoCheckbox">
                                            <label for="intervencaoInspecionadoCheckbox" >Inspecionado</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoModificadoCheckbox" name="intervencaoModificadoCheckbox" value="intervencaoModificadoCheckbox">
                                            <label for="intervencaoModificadoCheckbox" >Modificado</label>
                                        </div>

                                        <div >
                                            <input type="checkbox" id="intervencaoRetiradoCheckbox" name="intervencaoRetiradoCheckbox" value="intervencaoRetiradoCheckbox">
                                            <label for="intervencaoModificadoCheckbox" >Retirado</label>
                                        </div>

                                        <div >
                                       
                                        </div>
                                    </div>
                                </div>
                                
                                    <br> <label for="observacoes">Observações Gerais:</label><br>
    <textarea id="observacoes" name="observacoes" rows="6" cols="100"></textarea><hr>
    
    <br> <label for="mantenedores">Mantenedores:</label><br>
    <textarea id="mantenedores" name="mantenedores" rows="2" cols="100"></textarea><hr>
    
    <label for="materiaisUtilizados">Materiais utilizados:</label><br>
    <textarea id="materiaisUtilizados" name="materiaisUtilizados" rows="6" cols="100"></textarea><hr>
                                
                                
                                        <br> <br>
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
