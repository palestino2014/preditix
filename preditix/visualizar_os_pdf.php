<?php
require_once 'includes/auth.php';
require_once 'classes/Database.php';

// Verificar se o usuário está logado
if (!Auth::isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Verificar se o ID da OS foi fornecido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('HTTP/1.0 400 Bad Request');
    echo "ID da OS inválido";
    exit;
}

$os_id = $_GET['id'];

try {
    $db = new Database();
    
    // Buscar o PDF da OS
    $sql = "SELECT pdf FROM ordens_servico WHERE id = ? AND pdf IS NOT NULL";
    $resultado = $db->query($sql, [$os_id]);
    
    if (!empty($resultado) && !empty($resultado[0]['pdf'])) {
        $pdf_conteudo = $resultado[0]['pdf'];
        
        // Configurar headers para visualização inline
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="OS_' . $os_id . '.pdf"');
        header('Content-Length: ' . strlen($pdf_conteudo));
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
        
        // Enviar o conteúdo do PDF
        echo $pdf_conteudo;
    } else {
        // PDF não encontrado
        header('HTTP/1.0 404 Not Found');
        echo "PDF não encontrado para esta OS";
    }
    
} catch (Exception $e) {
    header('HTTP/1.0 500 Internal Server Error');
    echo "Erro ao buscar PDF: " . $e->getMessage();
}
?>
