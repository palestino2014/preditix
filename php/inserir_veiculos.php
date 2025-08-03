<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atribuir valores aos parâmetros antes de preparar a instrução
    $tipo_veiculo = $_POST["tipo_veiculo"];
    $tag = $_POST["tag"];
    $placa = $_POST["placa"];
    $fabricante = $_POST["fabricante"];
    $modelo = $_POST["modelo"];
    $ano_fabricacao = $_POST["ano_fabricacao"]; // Corrigir o nome do campo
    $chassis = $_POST["chassis"];
    $renavam = $_POST["renavam"];
    $proprietario = $_POST["proprietario"];
    $tara = $_POST["tara"];
    $lotacao = $_POST["lotacao"];
    $PTB = $_POST["PTB"];
    $PBTC = $_POST["PBTC"];
    $CMT = $_POST["CMT"];
    $cor = $_POST["cor"];
    $foto = $_FILES["foto"]["name"];
    
    			{ if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) 
										
										{ $foto_nome = $_FILES["foto"]["name"]; 
													$foto_tmp = $_FILES["foto"]["tmp_name"]; 
													$foto_destino = "veiculo/" . $foto_nome; // diretório onde as imagens serão salvas 
													move_uploaded_file($foto_tmp, $foto_destino); 
													$sql = "INSERT INTO fotos (caminho) VALUES ('$foto_destino')"; //inserir na tabela fotos
										if ($conn->query($sql) === TRUE) { echo "Imagem enviada com sucesso."; } 
						
						else  { echo "Erro ao enviar imagem: " . $conn->error; } 
					} else { echo "Erro no envio do arquivo."; 
				} 
			}   

    // Preparar e executar a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO ativo_veiculo (tipo_veiculo, tag, placa, fabricante, modelo, ano_fabricacao, chassis, renavam, proprietario, tara, lotacao, PTB, PBTC, CMT , cor, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssissssssssss", $tipo_veiculo, $tag, $placa, $fabricante, $modelo, $ano_fabricacao, $chassis, $renavam, $proprietario, $tara, $lotacao, $PTB, $PBTC, $CMT , $cor, $foto);

    // Executar a instrução preparada
    if ($stmt->execute()) {
        echo "<p>Registro inserido com sucesso.</p>";
    } else {
        echo "<p>Erro ao inserir registro: " . $stmt->error . "</p>";
    }

    // Fechar a conexão
    $stmt->close();
    $conn->close();
}
?>
