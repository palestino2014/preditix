<?php
// Incluir o script de conexão
    include "conexao_bd.php";

    // Consulta SQL para obter todos os dados da tabela
    $todos_ativos_consulta = $conn->query("SELECT * FROM ativo_veiculo, ativo_tanque, ativo_implemento, ativo_embarcacao");

    // Verifica se há resultados
    if ($todos_ativos_consulta->num_rows > 0) {
        
            while ($row = $consulta->fetch_assoc()) {
                
                if(tag == $row["tag"]){
                    //abrir modal com infor da linha

                } 
                else {
                
                }
            }
    }

// Fechar a consulta
$consulta->close();

// Fechar a conexão
$conn->close();
?>
