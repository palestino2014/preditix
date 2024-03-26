<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

     // Preparar e executar a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO ativo_embarcacao (tipo_embarcacao, tag , num_inscricao, nome, armador, ano_fabricacao, capacidade_volumetrica, foto) VALUES (?, ? , ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("sssssiss", $tipo_embarcacao,$tag , $num_inscricao, $nome, $armador, $ano_fabricacao, $capacidade_volumetrica, $foto);

    // Atribuir valores aos parâmetros
    $tipo_embarcacao = $_POST["tipo_embarcacao"];
    $tag = $_POST["tag"];
    $num_inscricao = $_POST["num_inscricao"];
    $nome = $_POST["nome"];
    $armador = $_POST["armador"];
    $ano_fabricacao = $_POST["ano_fabricacao"];
    $capacidade_volumetrica = $_POST["capacidade_volumetrica"];
    $foto = $_FILES["foto"]["name"]; // Nome do arquivo de imagem
    
    					{ if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) 
										
										{ $foto_nome = $_FILES["foto"]["name"]; 
													$foto_tmp = $_FILES["foto"]["tmp_name"]; 
													$foto_destino = "embarcacao/" . $foto_nome; // diretório onde as imagens serão salvas 
													move_uploaded_file($foto_tmp, $foto_destino); 
													$sql = "INSERT INTO fotos (caminho) VALUES ('$foto_destino')"; //inserir na tabela fotos
										if ($conn->query($sql) === TRUE) { echo "Imagem enviada com sucesso."; } 
						
						else  { echo "Erro ao enviar imagem: " . $conn->error; } 
					} else { echo "Erro no envio do arquivo."; 
				} 
			}
    

    // Executar a instrução preparada
    if ($stmt->execute()) {
        echo "<p>Dados inseridos com sucesso.</p>";
    } else {
        echo "<p>Erro ao inserir dados: " . $stmt->error . "</p>";
    }

    // Fechar a instrução preparada e a conexão
    $stmt->close();
    $conn->close();
}
?>
