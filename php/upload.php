<?php 

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "manutencao"; 

$conn = new mysqli($servername, $username, $password, $dbname); 

if ($conn->connect_error) 

			{ 
				die("Conexão falhou: " . $conn->connect_error); 
										} 
										
										if ($_SERVER["REQUEST_METHOD"] == "POST") 
										
										{ if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) 
										
										{ $foto_nome = $_FILES["foto"]["name"]; 
													$foto_tmp = $_FILES["foto"]["tmp_name"]; 
													$foto_destino = "upload/" . $foto_nome; // diretório onde as imagens serão salvas 
													move_uploaded_file($foto_tmp, $foto_destino); 
													$sql = "INSERT INTO fotos (caminho) VALUES ('$foto_destino')"; 
										if ($conn->query($sql) === TRUE) { echo "Imagem enviada com sucesso."; } 
						
						else  { echo "Erro ao enviar imagem: " . $conn->error; } 
					} else { echo "Erro no envio do arquivo."; 
				} 
			} $conn->close(); ?>