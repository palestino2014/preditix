<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once 'includes/config_campos.php';

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
    $db = new Database();
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
    
    // Verifica se a OS está aberta
    if ($os['status'] !== 'aberta') {
        $_SESSION['erro'] = "Não é possível editar uma ordem de serviço que não está aberta.";
        header('Location: visualiza_os.php?id=' . $id_os);
        exit;
    }

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
                    <?php if (isset($erro)): ?>
                        <div class="alert alert-danger"><?php echo $erro; ?></div>
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
                                                <option value="predial" <?php echo ($modo_edicao && $os['tipo_manutencao'] === 'predial') ? 'selected' : ''; ?>>Predial</option>
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
                                            <input type="date" name="data_abertura" id="data_abertura" class="form-control" 
                                                   value="<?php echo $modo_edicao ? date('Y-m-d', strtotime($os['data_abertura'])) : date('Y-m-d'); ?>" 
                                                   <?php echo $modo_edicao ? 'readonly' : 'required'; ?>>
                                            <div class="invalid-feedback">
                                                Por favor, selecione a data de abertura.
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

                        // Log dos dados do formulário
                        console.log('Dados iniciais do formulário:', {
                            tipo_equipamento: form.querySelector('[name="tipo_equipamento"]').value,
                            equipamento_id: form.querySelector('[name="equipamento_id"]').value,
                            modo_edicao: <?php echo $modo_edicao ? 'true' : 'false'; ?>
                        });

                        form.addEventListener('submit', function(event) {
                            event.preventDefault();
                            
                            // Coleta todos os dados do formulário
                            const formData = new FormData(form);
                            const formDataObj = {};
                            formData.forEach((value, key) => {
                                if (key.endsWith('[]')) {
                                    const baseKey = key.slice(0, -2);
                                    if (!formDataObj[baseKey]) {
                                        formDataObj[baseKey] = [];
                                    }
                                    formDataObj[baseKey].push(value);
                                } else {
                                    formDataObj[key] = value;
                                }
                            });
                            
                            console.log('Dados do formulário antes do envio:', formDataObj);
                            
                            if (!form.checkValidity()) {
                                event.stopPropagation();
                                form.classList.add('was-validated');
                                console.log('Formulário inválido');
                                return;
                            }

                            // Desabilita o botão para evitar duplo envio
                            btnSalvar.disabled = true;
                            btnSalvar.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Salvando...';

                            // Envia o formulário usando fetch para ter mais controle
                            fetch(form.action, {
                                method: 'POST',
                                body: formData
                            })
                            .then(response => {
                                console.log('Resposta do servidor:', response);
                                if (!response.ok) {
                                    throw new Error('Erro na resposta do servidor: ' + response.status);
                                }
                                return response.text();
                            })
                            .then(text => {
                                console.log('Resposta completa:', text);
                                // Redireciona para a página principal de ordens de serviço
                                window.location.href = 'ordens_servico.php';
                            })
                            .catch(error => {
                                console.error('Erro ao enviar formulário:', error);
                                alert('Erro ao salvar a OS. Por favor, tente novamente.');
                                btnSalvar.disabled = false;
                                btnSalvar.innerHTML = '<?php echo $modo_edicao ? 'Salvar Alterações' : 'Salvar OS'; ?>';
                            });
                        });

                        // Log quando o formulário é carregado
                        console.log('Formulário carregado:', form);
                    });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
