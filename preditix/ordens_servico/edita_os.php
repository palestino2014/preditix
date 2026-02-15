<?php
$titulo = 'Editar Ordem de Serviço';
require_once '../includes/config.php';
require_once '../includes/auth.php';
require_once '../classes/Database.php';

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

// Verifica se o ID da OS foi fornecido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ../ordens_servico.php');
    exit;
}

$id_os = (int)$_GET['id'];

// Inicializa a conexão com o banco de dados
$db = new Database();

try {
    // Busca os dados da OS
    $sql = "SELECT os.*, 
                   u.nome as nome_usuario_abertura,
                   CASE 
                       WHEN os.tipo_equipamento = 'embarcacao' THEN e.nome
                       WHEN os.tipo_equipamento = 'veiculo' THEN v.placa
                       WHEN os.tipo_equipamento = 'implemento' THEN i.placa
                       WHEN os.tipo_equipamento = 'tanque' THEN t.tag
                   END as identificacao_equipamento
            FROM ordens_servico os
            LEFT JOIN usuarios u ON u.id = os.usuario_abertura_id
            LEFT JOIN embarcacoes e ON e.id = os.equipamento_id AND os.tipo_equipamento = 'embarcacao'
            LEFT JOIN veiculos v ON v.id = os.equipamento_id AND os.tipo_equipamento = 'veiculo'
            LEFT JOIN implementos i ON i.id = os.equipamento_id AND os.tipo_equipamento = 'implemento'
            LEFT JOIN tanques t ON t.id = os.equipamento_id AND os.tipo_equipamento = 'tanque'
            WHERE os.id = :id";

    $result = $db->query($sql, [':id' => $id_os]);
    $os = $result[0] ?? null;

    if (!$os) {
        header('Location: ../ordens_servico.php');
        exit;
    }

    // Verifica se a OS está aberta
    if ($os['status'] !== 'aberta') {
        $_SESSION['erro'] = "Não é possível editar uma ordem de serviço que não está aberta.";
        header('Location: visualiza_os.php?id=' . $id_os);
        exit;
    }

    // Busca os equipamentos disponíveis
    $equipamentos = [];
    
    // Embarcações
    $sql_embarcacoes = "SELECT id, nome FROM embarcacoes WHERE status = 'ativo' ORDER BY nome";
    $embarcacoes = $db->query($sql_embarcacoes);
    $equipamentos['embarcacao'] = $embarcacoes;

    // Veículos
    $sql_veiculos = "SELECT id, placa FROM veiculos WHERE status = 'ativo' ORDER BY placa";
    $veiculos = $db->query($sql_veiculos);
    $equipamentos['veiculo'] = $veiculos;

    // Implementos
    $sql_implementos = "SELECT id, placa FROM implementos WHERE status = 'ativo' ORDER BY placa";
    $implementos = $db->query($sql_implementos);
    $equipamentos['implemento'] = $implementos;

    // Tanques
    $sql_tanques = "SELECT id, tag FROM tanques WHERE status = 'ativo' ORDER BY tag";
    $tanques = $db->query($sql_tanques);
    $equipamentos['tanque'] = $tanques;

} catch (Exception $e) {
    error_log("Erro ao buscar dados da OS: " . $e->getMessage());
    die("Erro ao buscar dados da ordem de serviço. Por favor, tente novamente mais tarde.");
}

// Inclui o cabeçalho
require_once '../includes/header.php';
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Editar Ordem de Serviço #<?php echo htmlspecialchars($os['numero_os']); ?></h1>
        <div>
            <a href="visualiza_os.php?id=<?php echo $os['id']; ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <form action="processamento/processa_edicao_os.php" method="POST" class="needs-validation" novalidate>
        <input type="hidden" name="id" value="<?php echo $os['id']; ?>">
        
        <div class="row">
            <!-- Informações Principais -->
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informações da OS</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipo_equipamento" class="form-label">Tipo de Equipamento</label>
                                    <select class="form-select" id="tipo_equipamento" name="tipo_equipamento" required>
                                        <option value="">Selecione...</option>
                                        <option value="embarcacao" <?php echo $os['tipo_equipamento'] === 'embarcacao' ? 'selected' : ''; ?>>Embarcação</option>
                                        <option value="veiculo" <?php echo $os['tipo_equipamento'] === 'veiculo' ? 'selected' : ''; ?>>Veículo</option>
                                        <option value="implemento" <?php echo $os['tipo_equipamento'] === 'implemento' ? 'selected' : ''; ?>>Implemento</option>
                                        <option value="tanque" <?php echo $os['tipo_equipamento'] === 'tanque' ? 'selected' : ''; ?>>Tanque</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="equipamento_id" class="form-label">Equipamento</label>
                                    <select class="form-select" id="equipamento_id" name="equipamento_id" required>
                                        <option value="">Selecione...</option>
                                        <?php foreach ($equipamentos[$os['tipo_equipamento']] as $equipamento): ?>
                                            <option value="<?php echo $equipamento['id']; ?>" 
                                                    <?php echo $equipamento['id'] == $os['equipamento_id'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($equipamento[$os['tipo_equipamento'] === 'embarcacao' ? 'nome' : 'placa']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tipo_manutencao" class="form-label">Tipo de Manutenção</label>
                                    <select class="form-select" id="tipo_manutencao" name="tipo_manutencao" required>
                                        <option value="">Selecione...</option>
                                        <option value="preventiva" <?php echo $os['tipo_manutencao'] === 'preventiva' ? 'selected' : ''; ?>>Preventiva</option>
                                        <option value="corretiva" <?php echo $os['tipo_manutencao'] === 'corretiva' ? 'selected' : ''; ?>>Corretiva</option>
                                        <option value="preditiva" <?php echo $os['tipo_manutencao'] === 'preditiva' ? 'selected' : ''; ?>>Preditiva</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="prioridade" class="form-label">Prioridade</label>
                                    <select class="form-select" id="prioridade" name="prioridade" required>
                                        <option value="">Selecione...</option>
                                        <option value="baixa" <?php echo $os['prioridade'] === 'baixa' ? 'selected' : ''; ?>>Baixa</option>
                                        <option value="media" <?php echo $os['prioridade'] === 'media' ? 'selected' : ''; ?>>Média</option>
                                        <option value="alta" <?php echo $os['prioridade'] === 'alta' ? 'selected' : ''; ?>>Alta</option>
                                        <option value="urgente" <?php echo $os['prioridade'] === 'urgente' ? 'selected' : ''; ?>>Urgente</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="data_prevista" class="form-label">Estimativa de Conclusão</label>
                                    <input type="date" class="form-control" id="data_prevista" name="data_prevista" 
                                           value="<?php echo $os['data_prevista'] ? date('Y-m-d', strtotime($os['data_prevista'])) : ''; ?>">
                                </div>

                                <?php if ($os['tipo_equipamento'] === 'veiculo' || $os['tipo_equipamento'] === 'implemento'): ?>
                                    <div class="mb-3">
                                        <label for="odometro" class="form-label">Odômetro</label>
                                        <input type="number" class="form-control" id="odometro" name="odometro" 
                                               value="<?php echo $os['odometro'] ?? ''; ?>">
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descricao_problema" class="form-label">Descrição do Problema</label>
                            <textarea class="form-control" id="descricao_problema" name="descricao_problema" rows="3"><?php echo htmlspecialchars($os['descricao_problema'] ?? ''); ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="observacoes" class="form-label">Observações</label>
                            <textarea class="form-control" id="observacoes" name="observacoes" rows="3"><?php echo htmlspecialchars($os['observacoes'] ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalhes Técnicos -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Detalhes Técnicos</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Sistemas Afetados</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sistemas_afetados[]" value="motor" 
                                       <?php echo in_array('motor', json_decode($os['sistemas_afetados'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Motor</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sistemas_afetados[]" value="hidraulico" 
                                       <?php echo in_array('hidraulico', json_decode($os['sistemas_afetados'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Hidráulico</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sistemas_afetados[]" value="eletrico" 
                                       <?php echo in_array('eletrico', json_decode($os['sistemas_afetados'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Elétrico</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sistemas_afetados[]" value="estrutural" 
                                       <?php echo in_array('estrutural', json_decode($os['sistemas_afetados'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Estrutural</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Sintomas Detectados</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sintomas_detectados[]" value="vazamento" 
                                       <?php echo in_array('vazamento', json_decode($os['sintomas_detectados'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Vazamento</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sintomas_detectados[]" value="ruido" 
                                       <?php echo in_array('ruido', json_decode($os['sintomas_detectados'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Ruído</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sintomas_detectados[]" value="vibracao" 
                                       <?php echo in_array('vibracao', json_decode($os['sintomas_detectados'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Vibração</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="sintomas_detectados[]" value="falha" 
                                       <?php echo in_array('falha', json_decode($os['sintomas_detectados'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Falha</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Causas dos Defeitos</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="causas_defeitos[]" value="desgaste" 
                                       <?php echo in_array('desgaste', json_decode($os['causas_defeitos'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Desgaste</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="causas_defeitos[]" value="falha_manutencao" 
                                       <?php echo in_array('falha_manutencao', json_decode($os['causas_defeitos'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Falha na Manutenção</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="causas_defeitos[]" value="falha_operacao" 
                                       <?php echo in_array('falha_operacao', json_decode($os['causas_defeitos'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Falha na Operação</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="causas_defeitos[]" value="defeito_fabricacao" 
                                       <?php echo in_array('defeito_fabricacao', json_decode($os['causas_defeitos'] ?? '[]', true)) ? 'checked' : ''; ?>>
                                <label class="form-check-label">Defeito de Fabricação</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="visualiza_os.php?id=<?php echo $os['id']; ?>" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Atualiza a lista de equipamentos quando o tipo de equipamento muda
    const tipoEquipamento = document.getElementById('tipo_equipamento');
    const equipamentoSelect = document.getElementById('equipamento_id');
    
    tipoEquipamento.addEventListener('change', function() {
        const tipo = this.value;
        if (!tipo) {
            equipamentoSelect.innerHTML = '<option value="">Selecione...</option>';
            return;
        }

        // Busca os equipamentos do tipo selecionado
        fetch(`processamento/busca_equipamentos.php?tipo=${tipo}`)
            .then(response => response.json())
            .then(data => {
                equipamentoSelect.innerHTML = '<option value="">Selecione...</option>';
                data.forEach(equip => {
                    const option = document.createElement('option');
                    option.value = equip.id;
                    option.textContent = tipo === 'embarcacao' ? equip.nome : equip.placa;
                    equipamentoSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao buscar equipamentos:', error);
                alert('Erro ao buscar equipamentos. Por favor, tente novamente.');
            });
    });

    // Validação do formulário
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>

<!-- Scripts do Bootstrap e jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
