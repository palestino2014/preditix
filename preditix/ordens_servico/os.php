<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once 'includes/config_campos.php';
require_once '../classes/Database.php';

// Inicializa a conexão com o banco de dados
$db = new Database();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

// Determina se é edição ou criação
$modo_edicao = isset($_GET['id']);
$id_os = $modo_edicao ? (int)$_GET['id'] : null;

// Obtém o tipo de equipamento da URL ou da OS existente
$tipo_equipamento = isset($_GET['tipo']) ? $_GET['tipo'] : null;
$id_equipamento = isset($_GET['id_equipamento']) ? (int)$_GET['id_equipamento'] : null;

// Se for edição, busca os dados da OS
if ($modo_edicao) {
    $sql = "SELECT os.*, 
                   CASE 
                       WHEN os.tipo_equipamento = 'embarcacao' THEN e.nome
                       WHEN os.tipo_equipamento = 'veiculo' THEN v.placa
                       WHEN os.tipo_equipamento = 'implemento' THEN i.placa
                       WHEN os.tipo_equipamento = 'tanque' THEN t.tag
                   END as identificacao_equipamento
            FROM ordens_servico os
            LEFT JOIN embarcacoes e ON e.id = os.equipamento_id AND os.tipo_equipamento = 'embarcacao'
            LEFT JOIN veiculos v ON v.id = os.equipamento_id AND os.tipo_equipamento = 'veiculo'
            LEFT JOIN implementos i ON i.id = os.equipamento_id AND os.tipo_equipamento = 'implemento'
            LEFT JOIN tanques t ON t.id = os.equipamento_id AND os.tipo_equipamento = 'tanque'
            WHERE os.id = :id";

    $result = $db->query($sql, [':id' => $id_os]);
    if (empty($result)) {
        $_SESSION['erro'] = "Ordem de serviço não encontrada.";
        header('Location: ../ordens_servico.php');
        exit;
    }

    $os = $result[0];
    
    // Define o tipo e ID do equipamento a partir da OS
    $tipo_equipamento = $os['tipo_equipamento'];
    $id_equipamento = $os['equipamento_id'];
}

// Valida o tipo de equipamento
$tipos_permitidos = ['embarcacao', 'veiculo', 'implemento', 'tanque'];
if (!in_array($tipo_equipamento, $tipos_permitidos)) {
    die('Tipo de equipamento inválido');
}

// Carrega a configuração específica do tipo de equipamento
if (!isset($config_campos[$tipo_equipamento])) {
    die('Configuração não encontrada para este tipo de equipamento');
}

$config = $config_campos[$tipo_equipamento];

// Carrega os dados do equipamento
$equipamento = null;
switch ($tipo_equipamento) {
    case 'embarcacao':
        require_once '../classes/Embarcacao.php';
        $equipamento = new Embarcacao();
        $dados_equipamento = $equipamento->buscarPorId($id_equipamento);
        break;
    case 'veiculo':
        require_once '../classes/Veiculo.php';
        $equipamento = new Veiculo();
        $dados_equipamento = $equipamento->buscarPorId($id_equipamento);
        break;
    case 'implemento':
        require_once '../classes/Implemento.php';
        $equipamento = new Implemento();
        $dados_equipamento = $equipamento->buscarPorId($id_equipamento);
        break;
    case 'tanque':
        require_once '../classes/Tanque.php';
        $equipamento = new Tanque();
        $dados_equipamento = $equipamento->buscarPorId($id_equipamento);
        break;
}

if (!$dados_equipamento) {
    die('Equipamento não encontrado');
}

// Busca a lista de usuários para os campos de gestor e responsável
$sql_usuarios = "SELECT id, nome FROM usuarios ORDER BY nome";
$usuarios = $db->query($sql_usuarios);

// Inclui o cabeçalho
require_once '../includes/header.php';
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <?php echo $modo_edicao ? 'Editar' : 'Nova'; ?> Ordem de Serviço - <?php echo ucfirst($tipo_equipamento); ?>
                        <?php if ($modo_edicao): ?>
                            #<?php echo htmlspecialchars($os['numero_os']); ?>
                        <?php endif; ?>
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['erro'])): ?>
                        <div class="alert alert-danger"><?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
                    <?php endif; ?>

                    <?php
                    // Log para debug
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        error_log("Formulário enviado em os.php - Dados POST: " . print_r($_POST, true));
                    }
                    ?>

                    <form method="POST" action="processamento/processa_os.php" id="formOS" class="needs-validation" novalidate>
                        <?php if ($modo_edicao): ?>
                            <input type="hidden" name="id" value="<?php echo $id_os; ?>">
                        <?php endif; ?>
                        <input type="hidden" name="tipo_equipamento" value="<?php echo $tipo_equipamento; ?>">
                        <input type="hidden" name="equipamento_id" value="<?php echo $id_equipamento; ?>">

                        <!-- Dados do Equipamento -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4>Dados do Equipamento</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Identificação</th>
                                            <td><?php 
                                                switch ($tipo_equipamento) {
                                                    case 'embarcacao':
                                                        echo htmlspecialchars($dados_equipamento['nome'] ?? '');
                                                        break;
                                                    case 'veiculo':
                                                        echo htmlspecialchars($dados_equipamento['placa'] ?? '');
                                                        break;
                                                    case 'implemento':
                                                        echo htmlspecialchars($dados_equipamento['placa'] ?? '');
                                                        break;
                                                    case 'tanque':
                                                        echo htmlspecialchars($dados_equipamento['tag'] ?? '');
                                                        break;
                                                }
                                            ?></td>
                                            <th>Modelo</th>
                                            <td><?php 
                                                switch ($tipo_equipamento) {
                                                    case 'embarcacao':
                                                        echo htmlspecialchars($dados_equipamento['tipo'] ?? '');
                                                        break;
                                                    case 'veiculo':
                                                    case 'implemento':
                                                    case 'tanque':
                                                        echo htmlspecialchars($dados_equipamento['modelo'] ?? '');
                                                        break;
                                                }
                                            ?></td>
                                        </tr>
                                        <tr>
                                            <th>Fabricante</th>
                                            <td><?php 
                                                switch ($tipo_equipamento) {
                                                    case 'embarcacao':
                                                        echo htmlspecialchars($dados_equipamento['armador'] ?? '');
                                                        break;
                                                    case 'veiculo':
                                                    case 'implemento':
                                                        echo htmlspecialchars($dados_equipamento['fabricante'] ?? '');
                                                        break;
                                                    case 'tanque':
                                                        echo htmlspecialchars($dados_equipamento['fabricante_responsavel'] ?? '');
                                                        break;
                                                }
                                            ?></td>
                                            <th>Ano</th>
                                            <td><?php echo htmlspecialchars($dados_equipamento['ano_fabricacao'] ?? ''); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Dados da OS -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4>Dados da Ordem de Serviço</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipo_manutencao">Tipo de Manutenção</label>
                                            <select name="tipo_manutencao" id="tipo_manutencao" class="form-control" required>
                                                <option value="">Selecione...</option>
                                                <option value="preventiva" <?php echo ($modo_edicao && $os['tipo_manutencao'] === 'preventiva') ? 'selected' : ''; ?>>Preventiva</option>
                                                <option value="corretiva" <?php echo ($modo_edicao && $os['tipo_manutencao'] === 'corretiva') ? 'selected' : ''; ?>>Corretiva</option>
                                                <option value="preditiva" <?php echo ($modo_edicao && $os['tipo_manutencao'] === 'preditiva') ? 'selected' : ''; ?>>Preditiva</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecione o tipo de manutenção.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="prioridade">Prioridade</label>
                                            <select name="prioridade" id="prioridade" class="form-control" required>
                                                <option value="">Selecione...</option>
                                                <option value="baixa" <?php echo ($modo_edicao && $os['prioridade'] === 'baixa') ? 'selected' : ''; ?>>Baixa</option>
                                                <option value="media" <?php echo ($modo_edicao && $os['prioridade'] === 'media') ? 'selected' : ''; ?>>Média</option>
                                                <option value="alta" <?php echo ($modo_edicao && $os['prioridade'] === 'alta') ? 'selected' : ''; ?>>Alta</option>
                                                <option value="critica" <?php echo ($modo_edicao && $os['prioridade'] === 'critica') ? 'selected' : ''; ?>>Crítica</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecione a prioridade.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="data_abertura">Data de Abertura</label>
                                            <?php if ($modo_edicao): ?>
                                                <input type="datetime-local" name="data_abertura" id="data_abertura" class="form-control" 
                                                       value="<?php echo date('Y-m-d\TH:i', strtotime($os['data_abertura'])); ?>" 
                                                       readonly>
                                            <?php else: ?>
                                                <input type="datetime-local" name="data_abertura" id="data_abertura" class="form-control" 
                                                       value="<?php echo date('Y-m-d\TH:i'); ?>" 
                                                       required>
                                            <?php endif; ?>
                                            <div class="invalid-feedback">
                                                Por favor, selecione a data e hora de abertura.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($modo_edicao): ?>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="status">Status da OS</label>
                                            <select name="status" id="status" class="form-control" required>
                                                <option value="aberta" <?php echo ($os['status'] === 'aberta') ? 'selected' : ''; ?>>Aberta</option>
                                                <option value="em_andamento" <?php echo ($os['status'] === 'em_andamento') ? 'selected' : ''; ?>>Em Andamento</option>
                                                <option value="concluida" <?php echo ($os['status'] === 'concluida') ? 'selected' : ''; ?>>Concluída</option>
                                                <option value="cancelada" <?php echo ($os['status'] === 'cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecione o status da OS.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="gestor_id">Gestor *</label>
                                            <select name="gestor_id" id="gestor_id" class="form-control" required>
                                                <option value="">Selecione...</option>
                                                <?php foreach ($usuarios as $usuario): ?>
                                                    <option value="<?php echo $usuario['id']; ?>"
                                                        <?php echo ($modo_edicao && $os['gestor_id'] == $usuario['id']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($usuario['nome']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecione o gestor.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="usuario_responsavel_id">Responsável *</label>
                                            <select name="usuario_responsavel_id" id="usuario_responsavel_id" class="form-control" required>
                                                <option value="">Selecione...</option>
                                                <?php foreach ($usuarios as $usuario): ?>
                                                    <option value="<?php echo $usuario['id']; ?>"
                                                        <?php echo ($modo_edicao && $os['usuario_responsavel_id'] == $usuario['id']) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($usuario['nome']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecione o responsável.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gestor_id">Gestor *</label>
                                            <select name="gestor_id" id="gestor_id" class="form-control" required>
                                                <option value="">Selecione...</option>
                                                <?php foreach ($usuarios as $usuario): ?>
                                                    <option value="<?php echo $usuario['id']; ?>">
                                                        <?php echo htmlspecialchars($usuario['nome']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecione o gestor.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="usuario_responsavel_id">Responsável *</label>
                                            <select name="usuario_responsavel_id" id="usuario_responsavel_id" class="form-control" required>
                                                <option value="">Selecione...</option>
                                                <?php foreach ($usuarios as $usuario): ?>
                                                    <option value="<?php echo $usuario['id']; ?>">
                                                        <?php echo htmlspecialchars($usuario['nome']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                Por favor, selecione o responsável.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Sistemas Afetados -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4>Sistemas Afetados</h4>
                                <div class="row">
                                    <?php 
                                    $sistemas_afetados = $modo_edicao ? json_decode($os['sistemas_afetados'] ?? '[]', true) : [];
                                    foreach ($config['sistemas'] as $chave => $nome): 
                                    ?>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="sistemas_afetados[]" 
                                                       value="<?php echo $chave; ?>" 
                                                       class="form-check-input" id="sistema_<?php echo $chave; ?>"
                                                       <?php echo in_array($chave, $sistemas_afetados) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="sistema_<?php echo $chave; ?>">
                                                    <?php echo $nome; ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Sintomas Detectados -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4>Sintomas Detectados</h4>
                                <div class="row">
                                    <?php 
                                    $sintomas_detectados = $modo_edicao ? json_decode($os['sintomas_detectados'] ?? '[]', true) : [];
                                    foreach ($config['sintomas'] as $chave => $nome): 
                                    ?>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="sintomas_detectados[]" 
                                                       value="<?php echo $chave; ?>" 
                                                       class="form-check-input" id="sintoma_<?php echo $chave; ?>"
                                                       <?php echo in_array($chave, $sintomas_detectados) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="sintoma_<?php echo $chave; ?>">
                                                    <?php echo $nome; ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Causas dos Defeitos -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4>Causas dos Defeitos</h4>
                                <div class="row">
                                    <?php 
                                    $causas_defeitos = $modo_edicao ? json_decode($os['causas_defeitos'] ?? '[]', true) : [];
                                    foreach ($config['causas'] as $chave => $nome): 
                                    ?>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="causas_defeitos[]" 
                                                       value="<?php echo $chave; ?>" 
                                                       class="form-check-input" id="causa_<?php echo $chave; ?>"
                                                       <?php echo in_array($chave, $causas_defeitos) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="causa_<?php echo $chave; ?>">
                                                    <?php echo $nome; ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Intervenções Realizadas -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4>Intervenções Realizadas</h4>
                                <div class="row">
                                    <?php 
                                    $intervencoes_realizadas = $modo_edicao ? json_decode($os['tipo_intervencao'] ?? '[]', true) : [];
                                    foreach ($config['intervencoes'] as $chave => $nome): 
                                    ?>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="intervencoes_realizadas[]" 
                                                       value="<?php echo $chave; ?>" 
                                                       class="form-check-input" id="intervencao_<?php echo $chave; ?>"
                                                       <?php echo in_array($chave, $intervencoes_realizadas) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="intervencao_<?php echo $chave; ?>">
                                                    <?php echo $nome; ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Ações Realizadas -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4>Ações Realizadas</h4>
                                <div class="row">
                                    <?php 
                                    $acoes_realizadas = $modo_edicao ? json_decode($os['acoes_realizadas'] ?? '[]', true) : [];
                                    foreach ($config['acoes'] as $chave => $nome): 
                                    ?>
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" name="acoes_realizadas[]" 
                                                       value="<?php echo $chave; ?>" 
                                                       class="form-check-input" id="acao_<?php echo $chave; ?>"
                                                       <?php echo in_array($chave, $acoes_realizadas) ? 'checked' : ''; ?>>
                                                <label class="form-check-label" for="acao_<?php echo $chave; ?>">
                                                    <?php echo $nome; ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Observações -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="observacoes">Observações</label>
                                    <textarea name="observacoes" id="observacoes" class="form-control" rows="4"><?php echo $modo_edicao ? htmlspecialchars($os['observacoes'] ?? '') : ''; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Itens da OS -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h4>Itens da Ordem de Serviço</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="tabelaItens">
                                        <thead>
                                            <tr>
                                                <th>Descrição</th>
                                                <th>Quantidade</th>
                                                <th>Valor Unitário</th>
                                                <th>Total</th>
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if ($modo_edicao): 
                                                $sql_itens = "SELECT * FROM itens_ordem_servico WHERE ordem_servico_id = :id_os";
                                                $itens = $db->query($sql_itens, [':id_os' => $id_os]);
                                                foreach ($itens as $item):
                                            ?>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="itens[descricao][]" class="form-control" value="<?php echo htmlspecialchars($item['descricao']); ?>" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="itens[quantidade][]" class="form-control quantidade" value="<?php echo $item['quantidade']; ?>" step="0.01" min="0" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="itens[valor_unitario][]" class="form-control valor-unitario" value="<?php echo $item['valor_unitario']; ?>" step="0.01" min="0" required>
                                                    </td>
                                                    <td>
                                                        <span class="total-item"><?php echo number_format($item['quantidade'] * $item['valor_unitario'], 2, ',', '.'); ?></span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm remover-item">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5">
                                                    <button type="button" class="btn btn-success btn-sm" id="adicionarItem">
                                                        <i class="bi bi-plus"></i> Adicionar Item
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                                <td colspan="2">
                                                    <span id="total-geral">R$ 0,00</span>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="btnSalvar"><?php echo $modo_edicao ? 'Salvar Alterações' : 'Salvar OS'; ?></button>
                                <a href="ordens_servico.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </form>

                    <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const form = document.getElementById('formOS');
                        const btnSalvar = document.getElementById('btnSalvar');
                        const tabelaItens = document.getElementById('tabelaItens');
                        const btnAdicionarItem = document.getElementById('adicionarItem');
                        const totalGeral = document.getElementById('total-geral');

                        // Função para validar os campos de um item
                        function validarItem(row) {
                            const quantidade = parseInt(row.querySelector('.quantidade').value);
                            const valorUnitario = parseFloat(row.querySelector('.valor-unitario').value);
                            const descricao = row.querySelector('[name="itens[descricao][]"]').value.trim();

                            if (!descricao) {
                                alert('A descrição do item é obrigatória.');
                                return false;
                            }

                            if (isNaN(quantidade) || quantidade <= 0 || !Number.isInteger(quantidade)) {
                                alert('A quantidade deve ser um número inteiro maior que zero.');
                                return false;
                            }

                            if (isNaN(valorUnitario) || valorUnitario <= 0) {
                                alert('O valor unitário deve ser maior que zero.');
                                return false;
                            }

                            return true;
                        }

                        // Função para validar todos os itens
                        function validarItens() {
                            const rows = tabelaItens.querySelectorAll('tbody tr');
                            
                            // Se não houver itens, retorna true (não é obrigatório ter itens)
                            if (rows.length === 0) {
                                return true;
                            }

                            // Valida apenas os itens que existem
                            for (const row of rows) {
                                if (!validarItem(row)) {
                                    return false;
                                }
                            }
                            return true;
                        }

                        // Função para calcular o total de um item
                        function calcularTotalItem(row) {
                            const quantidade = parseInt(row.querySelector('.quantidade').value) || 0;
                            const valorUnitario = parseFloat(row.querySelector('.valor-unitario').value) || 0;
                            const total = quantidade * valorUnitario;
                            row.querySelector('.total-item').textContent = total.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }

                        // Função para calcular o total geral
                        function calcularTotalGeral() {
                            let total = 0;
                            document.querySelectorAll('#tabelaItens tbody tr').forEach(row => {
                                const quantidade = parseInt(row.querySelector('.quantidade').value) || 0;
                                const valorUnitario = parseFloat(row.querySelector('.valor-unitario').value) || 0;
                                total += quantidade * valorUnitario;
                            });
                            totalGeral.textContent = 'R$ ' + total.toLocaleString('pt-BR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }

                        // Adicionar novo item
                        btnAdicionarItem.addEventListener('click', function() {
                            const tbody = tabelaItens.querySelector('tbody');
                            const novaLinha = document.createElement('tr');
                            novaLinha.innerHTML = `
                                <td>
                                    <input type="text" name="itens[descricao][]" class="form-control" required>
                                </td>
                                <td>
                                    <input type="number" name="itens[quantidade][]" class="form-control quantidade" step="1" min="1" required>
                                </td>
                                <td>
                                    <input type="number" name="itens[valor_unitario][]" class="form-control valor-unitario" step="0.01" min="0.01" required>
                                </td>
                                <td>
                                    <span class="total-item">0,00</span>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm remover-item">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(novaLinha);

                            // Adiciona eventos aos novos campos
                            const inputs = novaLinha.querySelectorAll('input');
                            inputs.forEach(input => {
                                input.addEventListener('input', () => {
                                    calcularTotalItem(novaLinha);
                                    calcularTotalGeral();
                                });
                            });

                            novaLinha.querySelector('.remover-item').addEventListener('click', function() {
                                novaLinha.remove();
                                calcularTotalGeral();
                            });
                        });

                        // Adiciona eventos aos itens existentes
                        document.querySelectorAll('#tabelaItens tbody tr').forEach(row => {
                            const inputs = row.querySelectorAll('input');
                            inputs.forEach(input => {
                                input.addEventListener('input', () => {
                                    calcularTotalItem(row);
                                    calcularTotalGeral();
                                });
                            });

                            row.querySelector('.remover-item').addEventListener('click', function() {
                                row.remove();
                                calcularTotalGeral();
                            });
                        });

                        // Validação do formulário antes do envio
                        form.addEventListener('submit', function(e) {
                            // Validação dos itens
                            let ok = true;
                            document.querySelectorAll('.quantidade').forEach(function(input) {
                                // Verifica se é inteiro positivo
                                if (!input.value || isNaN(input.value) || parseInt(input.value) != input.value || parseInt(input.value) <= 0) {
                                    ok = false;
                                }
                            });
                            if (!ok) {
                                alert('A quantidade de todos os itens deve ser um número inteiro maior que zero.');
                                e.preventDefault();
                                return false;
                            }
                            // Validação do tipo de manutenção
                            const tipoManutencao = document.getElementById('tipo_manutencao');
                            if (!tipoManutencao.value) {
                                alert('Por favor, selecione o tipo de manutenção.');
                                tipoManutencao.focus();
                                e.preventDefault();
                                return false;
                            }
                            // Validação da prioridade
                            const prioridade = document.getElementById('prioridade');
                            if (!prioridade.value) {
                                alert('Por favor, selecione a prioridade da OS.');
                                prioridade.focus();
                                e.preventDefault();
                                return false;
                            }
                        });

                        // Calcula o total inicial
                        calcularTotalGeral();
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
