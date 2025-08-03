<?php
// Incluir o script de conexão
include "conexao_bd.php";

// Verificar se foi recebido um ID válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    
    // Consulta SQL para excluir o registro com o ID especificado
    $sql = "DELETE FROM ativo_tanque WHERE id = $id";
    $resultado = $conn->query($sql);

    // Verificar se a consulta foi bem-sucedida
    if ($resultado === true) {
        echo "<p>Registro apagado com sucesso!</p>";
        echo "<a type='button' href='http://auto.dev.br/mvp/listar_tanque.php'>Voltar</a>";
    } else {
        die("Erro ao excluir registro: " . $conn->error);
    }
} else {
    die("ID inválido.");
}

$conn->close();

?>