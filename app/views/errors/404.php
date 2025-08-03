<?php
$pageTitle = 'Página não encontrada';
$showHeader = false;
ob_start();
?>

<div style="
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--light) 0%, var(--light-gray) 100%);
    text-align: center;
    padding: 20px;
">
    <div style="max-width: 500px;">
        <!-- Logo -->
        <img src="/logo_preditix.jpeg" alt="Preditix" style="height: 60px; margin-bottom: 30px;">
        
        <!-- Erro 404 -->
        <div style="font-size: 120px; font-weight: bold; color: var(--gray); margin-bottom: 20px;">
            404
        </div>
        
        <h1 style="color: var(--dark); margin-bottom: 15px;">
            Página não encontrada
        </h1>
        
        <p style="color: var(--gray); margin-bottom: 30px; font-size: 18px;">
            A página que você está procurando não existe ou foi movida.
        </p>
        
        <!-- Botões de ação -->
        <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="/dashboard" class="btn btn-primary" style="text-decoration: none;">
                🏠 Ir para Dashboard
            </a>
            
            <button type="button" class="btn btn-secondary" onclick="history.back()">
                ← Voltar
            </button>
        </div>
        
        <!-- Informações adicionais -->
        <div style="margin-top: 40px; padding: 20px; background: var(--white); border-radius: var(--border-radius); text-align: left;">
            <h3 style="color: var(--dark); margin-bottom: 15px;">O que você pode fazer:</h3>
            <ul style="color: var(--gray); line-height: 1.8;">
                <li>Verificar se o URL está correto</li>
                <li>Usar o botão "Voltar" do navegador</li>
                <li>Ir para a página inicial do sistema</li>
                <li>Entrar em contato com o administrador se o problema persistir</li>
            </ul>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include 'views/layouts/app.php';
?>