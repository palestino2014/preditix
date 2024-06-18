<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Atribuir valores aos parâmetros antes de preparar a instrução
    $tipo_implemento = $_POST["tipo_implemento"];
    $vincular = $_POST["vincular"];
    $tag = $_POST["tag"];
    $placa = $_POST["placa"];
    $fabricante = $_POST["fabricante"];
    $modelo = $_POST["modelo"];
    $ano_fabricao = $_POST["ano_fabricao"];
    $chassis = $_POST["chassis"];
    $renavam = $_POST["renavam"];
    $proprietario = $_POST["proprietario"];
    $tara = $_POST["tara"];
    $lotacao = $_POST["lotacao"];
    $PTB = $_POST["PTB"];   
    $capacidadeMaxTracao = $_POST["capacidadeMaxTracao"];
    $capacidadeVolumetrica = $_POST["capacidadeVolumetrica"];
    $cor = $_POST["cor"];
    $foto = $_FILES["foto"]["name"];
    
    		{ if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) 
										
										{ $foto_nome = $_FILES["foto"]["name"]; 
													$foto_tmp = $_FILES["foto"]["tmp_name"]; 
													$foto_destino = "implemento/" . $foto_nome; // diretório onde as imagens serão salvas 
													move_uploaded_file($foto_tmp, $foto_destino); 
													$sql = "INSERT INTO fotos (caminho) VALUES ('$foto_destino')"; //inserir na tabela fotos
										if ($conn->query($sql) === TRUE) { echo "Imagem enviada com sucesso."; } 
						
						else  { echo "Erro ao enviar imagem: " . $conn->error; } 
					} else { echo "Erro no envio do arquivo."; 
				} 
			}    

    // Chamar a função para inserção no banco de dados
    if (inserirImplemento($conn, $tipo_implemento, $vincular, $tag, $placa, $fabricante, $modelo, $ano_fabricao, $chassis, $renavam, $proprietario, $tara, $lotacao, $PTB, $capacidadeMaxTracao, $capacidadeVolumetrica, $cor, $foto)) {
        echo "<p>Registro inserido com sucesso.</p>";
        echo "<a href='http://auto.dev.br/mvp/index.php' class='btn btn-primary'>Voltar para home</a>";

    } else {
        echo "<p>Erro ao inserir registro.</p>";
        echo "<a href='http://auto.dev.br/mvp/index.php' class='btn btn-primary'>Voltar para home</a>";

    }

    // Fechar a conexão (se necessário)
    $conn->close();
}

// Função para inserir um implemento no banco de dados
function inserirImplemento($conexao, $tipo_implemento,$vincular , $tag, $placa, $fabricante, $modelo, $ano_fabricao, $chassis, $renavam, $proprietario, $tara, $lotacao, $PTB, $capacidadeMaxTracao, $capacidadeVolumetrica, $cor, $foto) {
    $stmt = $conexao->prepare("INSERT INTO ativo_implemento (tipo_implemento, vincular , tag, placa, fabricante, modelo, ano_fabricao, chassis, renavam, proprietario, tara, lotacao, PTB, capacidadeMaxTracao, capacidadeVolumetrica, cor, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    $stmt->bind_param("ssssssissssssssss", $tipo_implemento, $vincular ,$tag, $placa, $fabricante, $modelo, $ano_fabricao, $chassis, $renavam, $proprietario, $tara, $lotacao, $PTB, $capacidadeMaxTracao, $capacidadeVolumetrica, $cor, $foto);
    	
	   	
    	
    return $stmt->execute();
}
?>
