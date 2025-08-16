<?php
$pageTitle = Language::t('open_os');
ob_start();
?>

<div class="card" style="max-width: 900px; margin: 20px auto;">
    <div class="card-header">
        <h2>
            <?php if (isset($reopenData)): ?>
                🔄 <?= Language::t('reopen_as_new') ?> - OS #<?= $reopenData['id_os'] ?>
            <?php else: ?>
                <?= Language::t('open_os') ?>
            <?php endif; ?>
        </h2>
        <p style="color: var(--gray); margin: 5px 0 0 0;">
            <?php if (isset($reopenData)): ?>
                <?= Language::t('reopening_os_description') ?>
            <?php else: ?>
                <?= Language::t('fill_basic_info') ?>
            <?php endif; ?>
        </p>
        <div class="page-indicator" style="float: right; background: var(--primary); color: white; padding: 8px 16px; border-radius: 20px; font-weight: bold;">
            <span id="current-page">1</span>/8
        </div>
    </div>
    
    <div class="card-body">
        <form method="POST" action="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/os/store" id="create-os-form">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            
            <!-- Página 1: Informações Básicas -->
            <div class="form-page active" id="page-1">
                <h4 style="margin-bottom: 20px; color: var(--primary);">Informações Básicas</h4>
                
                <div style="display: grid; grid-template-columns: 1fr; gap: 20px;">
                    <!-- Seleção de Ativo/Veículo -->
                    <div class="form-group">
                        <label for="id_ativo" class="form-label required">
                            <?= Language::t('vehicle') ?>
                        </label>
                        <select name="id_ativo" id="id_ativo" class="form-control" required>
                            <option value=""><?= Language::t('select_vehicle') ?></option>
                            <?php foreach ($vehicles as $vehicle): ?>
                                <option value="<?= $vehicle['id_ativo'] ?>" <?= (isset($reopenData) && $reopenData['id_ativo'] == $vehicle['id_ativo']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($vehicle['tag']) ?> - <?= htmlspecialchars($vehicle['modelo']) ?>
                                    <?php if (!empty($vehicle['placa'])): ?>
                                        (<?= htmlspecialchars($vehicle['placa']) ?>)
                                    <?php endif; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Tipo de Manutenção -->
                    <div class="form-group">
                        <label for="tipo_manutencao" class="form-label required">
                            <?= Language::t('maintenance_type') ?>
                        </label>
                        <select name="tipo_manutencao" id="tipo_manutencao" class="form-control" required>
                            <option value=""><?= Language::t('select_maintenance_type') ?></option>
                            <option value="preventiva" <?= (isset($reopenData) && $reopenData['tipo_manutencao'] == 'preventiva') ? 'selected' : '' ?>><?= Language::t('maintenance_preventiva') ?></option>
                            <option value="corretiva" <?= (isset($reopenData) && $reopenData['tipo_manutencao'] == 'corretiva') ? 'selected' : '' ?>><?= Language::t('maintenance_corretiva') ?></option>
                            <option value="preditiva" <?= (isset($reopenData) && $reopenData['tipo_manutencao'] == 'preditiva') ? 'selected' : '' ?>><?= Language::t('maintenance_preditiva') ?></option>
                        </select>
                    </div>
                    
                    <!-- Prioridade -->
                    <div class="form-group">
                        <label for="prioridade" class="form-label required">
                            <?= Language::t('priority') ?>
                        </label>
                        <select name="prioridade" id="prioridade" class="form-control" required>
                            <option value=""><?= Language::t('select_priority') ?></option>
                            <option value="baixa" <?= (isset($reopenData) && $reopenData['prioridade'] == 'baixa') ? 'selected' : '' ?>><?= Language::t('priority_baixa') ?></option>
                            <option value="media" <?= (isset($reopenData) && $reopenData['prioridade'] == 'media') ? 'selected' : '' ?>><?= Language::t('priority_media') ?></option>
                            <option value="alta" <?= (isset($reopenData) && $reopenData['prioridade'] == 'alta') ? 'selected' : '' ?>><?= Language::t('priority_alta') ?></option>
                            <option value="critica" <?= (isset($reopenData) && $reopenData['prioridade'] == 'critica') ? 'selected' : '' ?>><?= Language::t('priority_critica') ?></option>
                        </select>
                    </div>
                    
                    <?php if ($userType === 'tecnico'): ?>
                    <!-- Gestor (apenas para técnicos) -->
                    <div class="form-group">
                        <label for="id_gestor" class="form-label required">
                            <?= Language::t('manager') ?>
                        </label>
                        <select name="id_gestor" id="id_gestor" class="form-control" required>
                            <option value=""><?= Language::t('select_manager') ?></option>
                            <?php foreach ($users as $userItem): ?>
                                <option value="<?= $userItem['id'] ?>" <?= (isset($reopenData) && $reopenData['id_gestor'] == $userItem['id']) ? 'selected' : '' ?>><?= htmlspecialchars($userItem['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php else: ?>
                    <!-- Responsável (apenas para gestores) -->
                    <div class="form-group">
                        <label for="id_responsavel" class="form-label required">
                            <?= Language::t('responsible') ?>
                        </label>
                        <select name="id_responsavel" id="id_responsavel" class="form-control" required>
                            <option value=""><?= Language::t('select_responsible') ?></option>
                            <?php foreach ($users as $userItem): ?>
                                <option value="<?= $userItem['id'] ?>" <?= (isset($reopenData) && $reopenData['id_responsavel'] == $userItem['id']) ? 'selected' : '' ?>><?= htmlspecialchars($userItem['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Página 2: Sistemas Afetados -->
            <div class="form-page" id="page-2" style="display: none;">
                <h4 style="margin-bottom: 20px; color: var(--primary);">Sistemas Afetados</h4>
                
                <div class="checkbox-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <?php
                    $sistemas = ['cabine', 'direcao', 'combustivel', 'medicao_controle', 'protecao_impactos', 'transmissao', 'estrutural', 'acoplamento', 'controle_eletronico', 'exaustao', 'propulsao', 'protecao_incendio', 'ventilacao', 'tanque', 'arrefecimento', 'descarga', 'freios', 'protecao_ambiental', 'suspensao', 'eletrico'];
                    $sistemasSelecionados = isset($reopenData) && !empty($reopenData['sistemas_afetados']) ? json_decode($reopenData['sistemas_afetados'], true) : [];
                    foreach ($sistemas as $sistema): ?>
                        <label class="checkbox-item" style="display: flex; align-items: center; gap: 8px; padding: 10px; border: 1px solid var(--light-gray); border-radius: 6px; cursor: pointer;">
                            <input type="checkbox" name="sistemas_afetados[]" value="<?= $sistema ?>" <?= in_array($sistema, $sistemasSelecionados) ? 'checked' : '' ?> style="margin: 0;">
                            <span><?= Language::t('system_' . $sistema) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Página 3: Sintomas Detectados -->
            <div class="form-page" id="page-3" style="display: none;">
                <h4 style="margin-bottom: 20px; color: var(--primary);">Sintomas Detectados</h4>
                
                <div class="checkbox-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <?php
                    $sintomas = ['aberto', 'sujo', 'desvio_lateral', 'queimado', 'sem_freio', 'vazando', 'baixo_rendimento', 'empenado', 'rompido', 'sem_velocidade', 'travado', 'vibrando', 'desarmado', 'ruido_anormal', 'solto', 'trincando'];
                    $sintomasSelecionados = isset($reopenData) && !empty($reopenData['sintomas_detectados']) ? json_decode($reopenData['sintomas_detectados'], true) : [];
                    foreach ($sintomas as $sintoma): ?>
                        <label class="checkbox-item" style="display: flex; align-items: center; gap: 8px; padding: 10px; border: 1px solid var(--light-gray); border-radius: 6px; cursor: pointer;">
                            <input type="checkbox" name="sintomas_detectados[]" value="<?= $sintoma ?>" <?= in_array($sintoma, $sintomasSelecionados) ? 'checked' : '' ?> style="margin: 0;">
                            <span><?= Language::t('symptom_' . $sintoma) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Página 4: Causas dos Defeitos -->
            <div class="form-page" id="page-4" style="display: none;">
                <h4 style="margin-bottom: 20px; color: var(--primary);">Causas dos Defeitos</h4>
                
                <div class="checkbox-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <?php
                    $causas = ['nao_identificada', 'defeito_de_fabrica', 'desnivelamento', 'destensionamento', 'fissura', 'gasto', 'desalinhamento', 'falta_de_protecao', 'engripamento', 'folga', 'sobrecarga_de_peso', 'subdimensionamento', 'desbalanceamento', 'desregulamento', 'fadiga', 'fora_de_especificacao', 'nivel_baixo', 'rompido', 'sobrecarga_de_tensao'];
                    $causasSelecionadas = isset($reopenData) && !empty($reopenData['causas_defeitos']) ? json_decode($reopenData['causas_defeitos'], true) : [];
                    foreach ($causas as $causa): ?>
                        <label class="checkbox-item" style="display: flex; align-items: center; gap: 8px; padding: 10px; border: 1px solid var(--light-gray); border-radius: 6px; cursor: pointer;">
                            <input type="checkbox" name="causas_defeitos[]" value="<?= $causa ?>" <?= in_array($causa, $causasSelecionadas) ? 'checked' : '' ?> style="margin: 0;">
                            <span><?= Language::t('cause_' . $causa) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Página 5: Intervenções Realizadas -->
            <div class="form-page" id="page-5" style="display: none;">
                <h4 style="margin-bottom: 20px; color: var(--primary);">Intervenções Realizadas</h4>
                
                <div class="checkbox-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <?php
                    $intervencoes = ['mecanica', 'pintura', 'usinagem', 'eletrica', 'funilaria', 'caldeiraria', 'hidraulico', 'soldagem'];
                    $intervencoesSelecionadas = isset($reopenData) && !empty($reopenData['intervencoes_realizadas']) ? json_decode($reopenData['intervencoes_realizadas'], true) : [];
                    foreach ($intervencoes as $intervencao): ?>
                        <label class="checkbox-item" style="display: flex; align-items: center; gap: 8px; padding: 10px; border: 1px solid var(--light-gray); border-radius: 6px; cursor: pointer;">
                            <input type="checkbox" name="intervencoes_realizadas[]" value="<?= $intervencao ?>" <?= in_array($intervencao, $intervencoesSelecionadas) ? 'checked' : '' ?> style="margin: 0;">
                            <span><?= Language::t('intervention_' . $intervencao) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Página 6: Ações Realizadas -->
            <div class="form-page" id="page-6" style="display: none;">
                <h4 style="margin-bottom: 20px; color: var(--primary);">Ações Realizadas</h4>
                
                <div class="checkbox-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px;">
                    <?php
                    $acoes = ['acoplado', 'desacoplado', 'instalado', 'rearmado', 'soldado', 'ajustado', 'fabricado', 'limpeza', 'recuperacao', 'substituido', 'alinhado', 'fixado', 'lubrificado', 'reposto', 'apertado', 'inspecionado', 'modificado', 'retirado'];
                    $acoesSelecionadas = isset($reopenData) && !empty($reopenData['acoes_realizadas']) ? json_decode($reopenData['acoes_realizadas'], true) : [];
                    foreach ($acoes as $acao): ?>
                        <label class="checkbox-item" style="display: flex; align-items: center; gap: 8px; padding: 10px; border: 1px solid var(--light-gray); border-radius: 6px; cursor: pointer;">
                            <input type="checkbox" name="acoes_realizadas[]" value="<?= $acao ?>" <?= in_array($acao, $acoesSelecionadas) ? 'checked' : '' ?> style="margin: 0;">
                            <span><?= Language::t('action_' . $acao) ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <!-- Página 7: Observações -->
            <div class="form-page" id="page-7" style="display: none;">
                <h4 style="margin-bottom: 20px; color: var(--primary);"><?= Language::t('observations') ?></h4>
                
                <div class="form-group" style="position: relative;">
                    <textarea 
                        name="observacoes" 
                        id="observacoes" 
                        class="form-control" 
                        rows="8"
                        placeholder="<?= Language::t('describe_problem') ?>"
                        style="padding-right: 60px;"
                    ><?= isset($reopenData) && !empty($reopenData['observacoes']) ? htmlspecialchars($reopenData['observacoes']) : '' ?></textarea>
                    
                    <!-- Botão de microfone sempre visível -->
                    <button 
                        type="button" 
                        class="mic-button" 
                        onclick="startSpeechRecognition('observacoes')"
                        title="<?= Language::t('voice_input') ?>"
                        style="position: absolute !important; right: 10px !important; top: 10px !important; width: 40px !important; height: 40px !important; background: #007bff !important; color: white !important; border: none !important; border-radius: 50% !important; z-index: 9999 !important; display: block !important; cursor: pointer !important; font-size: 16px !important;"
                    >
                        🎤
                    </button>
                </div>
            </div>
            
            <!-- Página 8: Itens -->
            <div class="form-page" id="page-8" style="display: none;">
                <h4 style="margin-bottom: 20px; color: var(--primary);">Itens da Ordem de Serviço</h4>
                
                <div class="table-responsive">
                    <table class="table" id="itens-table">
                        <thead>
                            <tr>
                                <th><?= Language::t('description') ?></th>
                                <th><?= Language::t('quantity') ?></th>
                                <th><?= Language::t('unit_price') ?></th>
                                <th><?= Language::t('total') ?></th>
                                <th><?= Language::t('actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Itens serão adicionados dinamicamente -->
                        </tbody>
                    </table>
                </div>
                
                <button type="button" class="btn btn-secondary" onclick="addItem()" style="margin-top: 15px;">
                    ➕ <?= Language::t('add_item') ?>
                </button>
            </div>
            
            <!-- Botões de navegação -->
            <div class="form-navigation" style="display: flex; gap: 15px; justify-content: space-between; margin-top: 30px; flex-wrap: wrap;">
                <div>
                    <button type="button" class="btn btn-secondary" id="btn-back" onclick="previousPage()" style="display: none;">
                        ← <?= Language::t('back') ?>
                    </button>
                </div>
                
                <div style="display: flex; gap: 15px;">
                    <button type="button" class="btn btn-danger" id="btn-cancel" onclick="cancelOS()">
                        <?= Language::t('cancel') ?>
                    </button>
                    
                    <button type="button" class="btn btn-primary" id="btn-next" onclick="nextPage()">
                        <?= Language::t('next') ?> →
                    </button>
                    
                    <button type="submit" class="btn btn-success" id="btn-finish" onclick="confirmFinish()" style="display: none;">
                        <span id="finish-text">✓ <?= Language::t('finish') ?></span>
                        <span id="finish-loading" class="loading" style="display: none;"></span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Confirmação -->
<div id="confirm-modal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modal-title">Confirmação</h3>
        </div>
        <div class="modal-body">
            <p id="modal-message">Tem certeza que deseja prosseguir?</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeModal()">
                <?= Language::t('no') ?>
            </button>
            <button type="button" class="btn btn-primary" id="modal-confirm" onclick="confirmAction()">
                <?= Language::t('yes') ?>
            </button>
        </div>
    </div>
</div>

<style>
.form-label.required::after {
    content: ' *';
    color: var(--danger);
}

.form-page {
    min-height: 400px;
}

.checkbox-item {
    transition: all 0.2s ease;
}

.checkbox-item:hover {
    background: var(--light);
    border-color: var(--primary);
}

.checkbox-item input:checked + span {
    font-weight: bold;
    color: var(--primary);
}

.mic-button {
    position: absolute !important;
    right: 10px !important;
    top: 45px !important;
    background: var(--primary) !important;
    color: white !important;
    border: none !important;
    border-radius: 50% !important;
    width: 40px !important;
    height: 40px !important;
    cursor: pointer !important;
    font-size: 16px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    transition: all 0.3s ease;
    z-index: 1000 !important;
    visibility: visible !important;
    opacity: 1 !important;
}

/* Fallback para navegadores sem suporte às variáveis CSS */
.mic-button {
    background: #007bff !important;
}

.mic-button:hover {
    background: var(--primary-dark);
    transform: scale(1.1);
}

.mic-button.recording {
    background: var(--danger);
    animation: pulse 1s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.loading {
    width: 20px;
    height: 20px;
    border: 2px solid transparent;
    border-top: 2px solid currentColor;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: white;
    border-radius: 8px;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
}

.modal-header {
    padding: 20px 20px 0;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    padding: 0 20px 20px;
    display: flex;
    gap: 10px;
    justify-content: flex-end;
}

#itens-table th,
#itens-table td {
    padding: 12px;
    text-align: left;
    border-bottom: 1px solid var(--light-gray);
}

#itens-table input {
    width: 100%;
    min-width: 100px;
}
</style>

<script>
let currentPage = 1;
const totalPages = 8;
let itemCount = 0;

// Navegação entre páginas
function nextPage() {
    if (validateCurrentPage()) {
        if (currentPage < totalPages) {
            showPage(currentPage + 1);
        }
    }
}

function previousPage() {
    if (currentPage > 1) {
        showPage(currentPage - 1);
    }
}

function showPage(pageNumber) {
    // Ocultar página atual
    document.getElementById(`page-${currentPage}`).style.display = 'none';
    
    // Mostrar nova página
    currentPage = pageNumber;
    document.getElementById(`page-${currentPage}`).style.display = 'block';
    
    // Atualizar indicador
    document.getElementById('current-page').textContent = currentPage;
    
    // Atualizar botões
    updateNavigationButtons();
    
    // Scroll para o topo
    window.scrollTo(0, 0);
}

function updateNavigationButtons() {
    const btnBack = document.getElementById('btn-back');
    const btnNext = document.getElementById('btn-next');
    const btnFinish = document.getElementById('btn-finish');
    
    // Botão Voltar
    btnBack.style.display = currentPage > 1 ? 'block' : 'none';
    
    // Botão Avançar vs Finalizar
    if (currentPage === totalPages) {
        btnNext.style.display = 'none';
        btnFinish.style.display = 'block';
    } else {
        btnNext.style.display = 'block';
        btnFinish.style.display = 'none';
    }
}

function validateCurrentPage() {
    if (currentPage === 1) {
        // Validar campos obrigatórios da página 1
        const requiredFields = ['id_ativo', 'tipo_manutencao', 'prioridade'];
        <?php if ($userType === 'tecnico'): ?>
        requiredFields.push('id_gestor');
        <?php else: ?>
        requiredFields.push('id_responsavel');
        <?php endif; ?>
        
        for (let field of requiredFields) {
            const element = document.getElementById(field);
            if (!element || !element.value.trim()) {
                alert('<?= Language::t('fill_required_fields') ?>');
                if (element) element.focus();
                return false;
            }
        }
    }
    return true;
}

// Gerenciamento de itens na página 8
function addItem() {
    itemCount++;
    const tbody = document.querySelector('#itens-table tbody');
    const row = document.createElement('tr');
    
    row.innerHTML = `
        <td>
            <input type="text" name="itens[${itemCount}][descricao]" class="form-control" placeholder="<?= Language::t('item_description') ?>" required>
        </td>
        <td>
            <input type="number" name="itens[${itemCount}][quantidade]" class="form-control" min="1" step="1" value="1" onchange="calculateTotal(${itemCount})" required>
        </td>
        <td>
            <input type="number" name="itens[${itemCount}][valor_unitario]" class="form-control" min="0" step="0.01" placeholder="0,00" onchange="calculateTotal(${itemCount})" required>
        </td>
        <td>
            <input type="number" name="itens[${itemCount}][total]" class="form-control" readonly>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">
                🗑️
            </button>
        </td>
    `;
    
    tbody.appendChild(row);
}

function addItemWithData(itemData) {
    itemCount++;
    const tbody = document.querySelector('#itens-table tbody');
    const row = document.createElement('tr');
    
    row.innerHTML = `
        <td>
            <input type="text" name="itens[${itemCount}][descricao]" class="form-control" value="${itemData.descricao || ''}" placeholder="<?= Language::t('item_description') ?>" required>
        </td>
        <td>
            <input type="number" name="itens[${itemCount}][quantidade]" class="form-control" min="1" step="1" value="${itemData.quantidade || 1}" onchange="calculateTotal(${itemCount})" required>
        </td>
        <td>
            <input type="number" name="itens[${itemCount}][valor_unitario]" class="form-control" min="0" step="0.01" value="${itemData.valor_unitario || ''}" placeholder="0,00" onchange="calculateTotal(${itemCount})" required>
        </td>
        <td>
            <input type="number" name="itens[${itemCount}][total]" class="form-control" value="${itemData.total || ''}" readonly>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeItem(this)">
                🗑️
            </button>
        </td>
    `;
    
    tbody.appendChild(row);
}

function removeItem(button) {
    button.closest('tr').remove();
}

function calculateTotal(itemId) {
    const quantity = document.querySelector(`input[name="itens[${itemId}][quantidade]"]`).value;
    const unitPrice = document.querySelector(`input[name="itens[${itemId}][valor_unitario]"]`).value;
    const totalField = document.querySelector(`input[name="itens[${itemId}][total]"]`);
    
    const total = (parseFloat(quantity) || 0) * (parseFloat(unitPrice) || 0);
    totalField.value = total.toFixed(2);
}

// Função para cancelar OS
function cancelOS() {
    console.log('Botão cancelar clicado');
    
    // Confirmação direta
    if (confirm('<?= Language::t('confirm_cancel_os') ?>')) {
        console.log('Usuário confirmou cancelamento - redirecionando...');
        window.location.href = '<?= dirname($_SERVER['SCRIPT_NAME']) ?>/dashboard';
    } else {
        console.log('Usuário cancelou o cancelamento');
    }
}

// Modais de confirmação (mantido para outros usos)
function confirmCancel() {
    console.log('Botão cancelar clicado - abrindo modal de confirmação');
    showModal(
        '<?= Language::t('cancel_os') ?>', 
        '<?= Language::t('confirm_cancel_os') ?>', 
        'cancelOS_modal'
    );
}

function confirmFinish() {
    showModal(
        '<?= Language::t('finish_os') ?>', 
        '<?= Language::t('confirm_finish_os') ?>', 
        'finishOS'
    );
}

function showModal(title, message, action) {
    console.log('Mostrando modal:', { title, message, action });
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-message').textContent = message;
    document.getElementById('modal-confirm').setAttribute('data-action', action);
    document.getElementById('confirm-modal').style.display = 'flex';
    console.log('Modal exibido com sucesso');
}

function closeModal() {
    document.getElementById('confirm-modal').style.display = 'none';
}

function confirmAction() {
    const action = document.getElementById('modal-confirm').getAttribute('data-action');
    console.log('Ação confirmada:', action);
    
    if (action === 'cancelOS' || action === 'cancelOS_modal') {
        console.log('Cancelando OS - redirecionando para dashboard');
        // Fechar modal e redirecionar para dashboard
        closeModal();
        console.log('Redirecionando para:', '<?= dirname($_SERVER['SCRIPT_NAME']) ?>/dashboard');
        window.location.href = '<?= dirname($_SERVER['SCRIPT_NAME']) ?>/dashboard';
    } else if (action === 'finishOS') {
        // Submeter formulário
        const form = document.getElementById('create-os-form');
        const btnFinish = document.getElementById('btn-finish');
        const finishText = document.getElementById('finish-text');
        const finishLoading = document.getElementById('finish-loading');
        
        btnFinish.disabled = true;
        finishText.style.display = 'none';
        finishLoading.style.display = 'inline-block';
        
        form.submit();
    }
    
    closeModal();
}

// Inicializar página
document.addEventListener('DOMContentLoaded', function() {
    updateNavigationButtons();
    
    // Auto-focus no primeiro campo
    const firstField = document.getElementById('id_ativo');
    if (firstField) {
        firstField.focus();
    }
    
    // Se for para reabrir uma OS, preencher os itens existentes
    <?php if (isset($reopenData) && !empty($reopenData['items'])): ?>
    const reopenItems = <?= json_encode($reopenData['items']) ?>;
    if (reopenItems && reopenItems.length > 0) {
        // Adicionar os itens da OS original
        reopenItems.forEach(function(item) {
            addItemWithData(item);
        });
    }
    <?php endif; ?>
    
    // Configuração do botão de microfone removida - agora usa implementação unificada
});

// Função de reconhecimento de voz (implementação unificada)
function startSpeechRecognition(targetId) {
    console.log('🎤 startSpeechRecognition chamado para:', targetId);
    
    if (window.speechRecognition) {
        // Verificar se já está ativo
        if (window.speechRecognition.isListening) {
            console.log('🛑 Já está ativo, parando primeiro...');
            window.speechRecognition.stop();
            
            // Aguardar um pouco e tentar novamente
            setTimeout(() => {
                console.log('🔄 Tentando iniciar novamente...');
                const result = window.speechRecognition.start(targetId);
                if (!result) {
                    console.log('❌ Falha ao reiniciar speech recognition');
                    alert('Erro ao reiniciar reconhecimento de voz. Tente novamente.');
                }
            }, 300);
            return;
        }
        
        console.log('✅ Speech recognition disponível, iniciando...');
        const result = window.speechRecognition.start(targetId);
        console.log('📊 Resultado do start:', result);
        
        if (!result) {
            console.log('❌ Falha ao iniciar speech recognition');
            alert('Erro ao iniciar reconhecimento de voz. Tente novamente.');
        }
    } else {
        console.log('❌ Speech recognition não disponível');
        alert('Reconhecimento de voz não disponível');
    }
}
</script>

<?php
$content = ob_get_clean();
include 'views/layouts/app.php';
?>