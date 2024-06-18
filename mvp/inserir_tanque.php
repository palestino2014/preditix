<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Atribuir valores aos parâmetros antes de preparar a instrução
    $tag = $_POST["tag"];
    $fabricante = $_POST["fabricante"];
    $anoFabricacao = $_POST["anoFabricacao"];
    $localizacao = $_POST["localizacao"];
    $capacidadeVolumetrica = $_POST["capacidadeVolumetrica"];
    $foto = $_FILES["foto"]["name"];

    // Preparar e executar a inserção no banco de dados
    $stmt = $conn->prepare("INSERT INTO ativo_tanque (tag, fabricante, anoFabricacao, localizacao, capacidadeVolumetrica, foto) VALUES (?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("ssssss", $tag, $fabricante, $anoFabricacao, $localizacao, $capacidadeVolumetrica, $foto);
    
    { if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) 
										
										{ $foto_nome = $_FILES["foto"]["name"]; 
													$foto_tmp = $_FILES["foto"]["tmp_name"]; 
													$foto_destino = "tanque/" . $foto_nome; // diretório onde as imagens serão salvas 
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
        echo "<a href='http://auto.dev.br/mvp/index.php' class='btn btn-primary'>Voltar para home</a>";

    } else {
        echo "<p>Erro ao inserir dados: " . $stmt->error . "</p>";
        echo "<a href='http://auto.dev.br/mvp/index.php' class='btn btn-primary'>Voltar para home</a>";

    }

    // Fechar a instrução preparada
    $stmt->close();
}

// Fechar a conexão
$conn->close();
?>
