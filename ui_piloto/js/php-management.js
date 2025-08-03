//função para carregar o script PHP
function carregarScriptPHP() {
    // Substitua "seuscript.php" pelo caminho real do seu script PHP
    const url = 'C:/Users/acrif/OneDrive/Documentos/GitHub/preditix/ui_piloto/js/demo/datatables-demo.js';

    // Fazer uma solicitação usando a Fetch API
    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erro na requisição: ${response.status}`);
            }
            return response.text();
        })
        .then(data => {
            // O conteúdo do script PHP estará em 'data'
            console.log('Conteúdo do script PHP:', data);
        })
        .catch(error => {
            console.error('Erro:', error);
        });
}
