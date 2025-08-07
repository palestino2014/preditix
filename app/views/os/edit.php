<?php
$pageTitle = Language::t('edit');
ob_start();
?>

<div class="card" style="max-width: 900px; margin: 20px auto;">
    <div class="card-header">
        <h2>✏️ <?= Language::t('edit') ?> OS #<?= $order['id_os'] ?></h2>
        <p style="color: var(--gray); margin: 5px 0 0 0;">
            <?= Language::t('edit_basic_info') ?>
        </p>
        <div class="page-indicator" style="float: right; background: var(--primary); color: white; padding: 8px 16px; border-radius: 20px; font-weight: bold;">
            <span id="current-page">1</span>/8
        </div>
    </div>
    
    <div class="card-body">
        <!-- Mensagens de erro -->
        <?php if (isset($_SESSION['form_error'])): ?>
            <div class="alert alert-error mb-3" style="
                background: #fee; 
                border: 1px solid var(--danger); 
                color: var(--danger); 
                padding: 15px; 
                border-radius: var(--border-radius);
                margin-bottom: 20px;
            ">
                <?= htmlspecialchars($_SESSION['form_error']) ?>
            </div>
            <?php unset($_SESSION['form_error']); ?>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['form_errors']) && is_array($_SESSION['form_errors'])): ?>
            <div class="alert alert-error mb-3" style="
                background: #fee; 
                border: 1px solid var(--danger); 
                color: var(--danger); 
                padding: 15px; 
                border-radius: var(--border-radius);
                margin-bottom: 20px;
            ">
                <ul style="margin: 0; padding-left: 20px;">
                    <?php foreach ($_SESSION['form_errors'] as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['form_errors']); ?>
        <?php endif; ?>
        
        <form method="POST" action="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/os/update" id="edit-os-form">
            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
            <input type="hidden" name="id_os" value="<?= $order['id_os'] ?>">
            
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
                                <option value="<?= $vehicle['id_ativo'] ?>" <?= $order['id_ativo'] == $vehicle['id_ativo'] ? 'selected' : '' ?>>
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
                            <option value="preventiva" <?= $order['tipo_manutencao'] == 'preventiva' ? 'selected' : '' ?>><?= Language::t('maintenance_preventiva') ?></option>
                            <option value="corretiva" <?= $order['tipo_manutencao'] == 'corretiva' ? 'selected' : '' ?>><?= Language::t('maintenance_corretiva') ?></option>
                            <option value="preditiva" <?= $order['tipo_manutencao'] == 'preditiva' ? 'selected' : '' ?>><?= Language::t('maintenance_preditiva') ?></option>
                        </select>
                    </div>
                    
                    <!-- Prioridade -->
                    <div class="form-group">
                        <label for="prioridade" class="form-label required">
                            <?= Language::t('priority') ?>
                        </label>
                        <select name="prioridade" id="prioridade" class="form-control" required>
                            <option value=""><?= Language::t('select_priority') ?></option>
                            <option value="baixa" <?= $order['prioridade'] == 'baixa' ? 'selected' : '' ?>><?= Language::t('priority_baixa') ?></option>
                            <option value="media" <?= $order['prioridade'] == 'media' ? 'selected' : '' ?>><?= Language::t('priority_media') ?></option>
                            <option value="alta" <?= $order['prioridade'] == 'alta' ? 'selected' : '' ?>><?= Language::t('priority_alta') ?></option>
                            <option value="critica" <?= $order['prioridade'] == 'critica' ? 'selected' : '' ?>><?= Language::t('priority_critica') ?></option>
                        </select>
                    </div>
                    
                    <?php if ($userType === 'tecnico'): ?>
                    <!-- Gestor (somente leitura para técnicos) -->
                    <div class="form-group">
                        <label for="id_gestor" class="form-label">
                            <?= Language::t('manager') ?>
                        </label>
                        <input type="hidden" name="id_gestor" value="<?= $order['id_gestor'] ?>">
                        <input type="text" class="form-control" value="<?= htmlspecialchars($order['gestor_nome']) ?>" readonly style="background-color: #f8f9fa; cursor: not-allowed;">
                        <small style="color: var(--gray); font-size: 12px;"><?= Language::t('manager_cannot_be_changed') ?></small>
                    </div>
                    <?php else: ?>
                    <!-- Responsável (apenas para gestores) -->
                    <div class="form-group">
                        <label for="id_responsavel" class="form-label required">
                            <?= Language::t('responsible') ?>
                        </label>
                        <select name="id_responsavel" id="id_responsavel" class="form-control" required>
                            <option value=""><?= Language::t('select_responsible') ?></option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= $order['id_responsavel'] == $user['id'] ? 'selected' : '' ?>><?= htmlspecialchars($user['nome']) ?></option>
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
                    $sistemasAtivos = json_decode($order['sistemas_afetados'] ?? '[]', true) ?: [];
                    foreach ($sistemas as $sistema): ?>
                        <label class="checkbox-item" style="display: flex; align-items: center; gap: 8px; padding: 10px; border: 1px solid var(--light-gray); border-radius: 6px; cursor: pointer;">
                            <input type="checkbox" name="sistemas_afetados[]" value="<?= $sistema ?>" style="margin: 0;" <?= in_array($sistema, $sistemasAtivos) ? 'checked' : '' ?>>
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
                    $sintomasAtivos = json_decode($order['sintomas_detectados'] ?? '[]', true) ?: [];
                    foreach ($sintomas as $sintoma): ?>
                        <label class="checkbox-item" style="display: flex; align-items: center; gap: 8px; padding: 10px; border: 1px solid var(--light-gray); border-radius: 6px; cursor: pointer;">
                            <input type="checkbox" name="sintomas_detectados[]" value="<?= $sintoma ?>" style="margin: 0;" <?= in_array($sintoma, $sintomasAtivos) ? 'checked' : '' ?>>
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
                    $causasAtivas = json_decode($order['causas_defeitos'] ?? '[]', true) ?: [];
                    foreach ($causas as $causa): ?>
                        <label class="checkbox-item" style="display: flex; align-items: center; gap: 8px; padding: 10px; border: 1px solid var(--light-gray); border-radius: 6px; cursor: pointer;">
                            <input type="checkbox" name="causas_defeitos[]" value="<?= $causa ?>" style="margin: 0;" <?= in_array($causa, $causasAtivas) ? 'checked' : '' ?>>
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
                    $intervencoesAtivas = json_decode($order['intervencoes_realizadas'] ?? '[]', true) ?: [];
                    foreach ($intervencoes as $intervencao): ?>
                        <label class="checkbox-item" style="display: flex; align-items: center; gap: 8px; padding: 10px; border: 1px solid var(--light-gray); border-radius: 6px; cursor: pointer;">
                            <input type="checkbox" name="intervencoes_realizadas[]" value="<?= $intervencao ?>" style="margin: 0;" <?= in_array($intervencao, $intervencoesAtivas) ? 'checked' : '' ?>>
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
                    $acoesAtivas = json_decode($order['acoes_realizadas'] ?? '[]', true) ?: [];
                    foreach ($acoes as $acao): ?>
                        <label class="checkbox-item" style="display: flex; align-items: center; gap: 8px; padding: 10px; border: 1px solid var(--light-gray); border-radius: 6px; cursor: pointer;">
                            <input type="checkbox" name="acoes_realizadas[]" value="<?= $acao ?>" style="margin: 0;" <?= in_array($acao, $acoesAtivas) ? 'checked' : '' ?>>
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
                    ><?= htmlspecialchars($order['observacoes'] ?? '') ?></textarea>
                    
                    <!-- Botão de microfone sempre visível -->
                    <button 
                        type="button" 
                        class="mic-button" 
                        data-target="observacoes" 
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
                    <a href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/os/view?id=<?= $order['id_os'] ?>" class="btn btn-danger" id="btn-cancel">
                        <?= Language::t('cancel') ?>
                    </a>
                    
                    <button type="button" class="btn btn-primary" id="btn-next" onclick="nextPage()">
                        <?= Language::t('next') ?> →
                    </button>
                    
                    <button type="submit" class="btn btn-success" id="btn-finish" onclick="confirmFinish()" style="display: none;">
                        <span id="finish-text">✓ <?= Language::t('save_changes') ?></span>
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
        <?php if ($userType === 'gestor'): ?>
        requiredFields.push('id_responsavel');
        <?php endif; ?>
        // Para técnicos, não validamos o id_gestor pois ele não pode ser alterado
        
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
            <input type="number" name="itens[${itemCount}][quantidade]" class="form-control" min="1" step="1" value="1" onchange="calculateTotal(${itemCount}); detectChanges();" required>
        </td>
        <td>
            <input type="number" name="itens[${itemCount}][valor_unitario]" class="form-control" min="0" step="0.01" placeholder="0,00" onchange="calculateTotal(${itemCount}); detectChanges();" required>
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
    
    // Adicionar event listeners para detectar mudanças nos novos campos
    const newInputs = row.querySelectorAll('input[type="text"], input[type="number"]');
    newInputs.forEach(input => {
        if (!input.readOnly) {
            input.addEventListener('input', detectChanges);
            input.addEventListener('change', detectChanges);
        }
    });
    
    // Detectar mudança por adicionar item
    detectChanges();
}

function removeItem(button) {
    button.closest('tr').remove();
    // Detectar mudança por remover item
    detectChanges();
}

function calculateTotal(itemId) {
    const quantity = document.querySelector(`input[name="itens[${itemId}][quantidade]"]`).value;
    const unitPrice = document.querySelector(`input[name="itens[${itemId}][valor_unitario]"]`).value;
    const totalField = document.querySelector(`input[name="itens[${itemId}][total]"]`);
    
    const total = (parseFloat(quantity) || 0) * (parseFloat(unitPrice) || 0);
    totalField.value = total.toFixed(2);
}

// Modais de confirmação
function confirmFinish() {
    // Verificar se há mudanças antes de confirmar
    detectChanges();
    
    if (!hasChanges) {
        alert('<?= Language::t('no_changes_to_save') ?>');
        return false;
    }
    
    showModal(
        '<?= Language::t('save_changes') ?>', 
        '<?= Language::t('confirm_save_changes') ?>', 
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
    
    if (action === 'finishOS') {
        // Validar se há pelo menos um item na página 8
        const items = document.querySelectorAll('#itens-table tbody tr');
        if (items.length === 0) {
            closeModal();
            alert('<?= Language::t('add_at_least_one_item') ?>');
            return;
        }
        
        // Validar se os itens têm dados preenchidos
        let hasValidItems = false;
        items.forEach(item => {
            const descricao = item.querySelector('input[name*="[descricao]"]')?.value?.trim();
            const quantidade = item.querySelector('input[name*="[quantidade]"]')?.value;
            const valorUnitario = item.querySelector('input[name*="[valor_unitario]"]')?.value;
            
            if (descricao && quantidade && valorUnitario) {
                hasValidItems = true;
            }
        });
        
        if (!hasValidItems) {
            closeModal();
            alert('<?= Language::t('fill_item_fields') ?>');
            return;
        }
        
        // Submeter formulário
        const form = document.getElementById('edit-os-form');
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

// Variáveis para controle de mudanças
let originalFormData = {};
let hasChanges = false;

// Função para capturar dados originais do formulário
function captureOriginalData() {
    const form = document.getElementById('edit-os-form');
    const formData = new FormData(form);
    originalFormData = {};
    
    // Capturar campos de texto e select
    for (let [key, value] of formData.entries()) {
        if (originalFormData[key]) {
            // Se já existe, converter para array
            if (Array.isArray(originalFormData[key])) {
                originalFormData[key].push(value);
            } else {
                originalFormData[key] = [originalFormData[key], value];
            }
        } else {
            originalFormData[key] = value;
        }
    }
    
    // Capturar checkboxes desmarcados também
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        const name = checkbox.name.replace('[]', '');
        if (!originalFormData[name]) {
            originalFormData[name] = [];
        }
        if (checkbox.checked && Array.isArray(originalFormData[name])) {
            if (!originalFormData[name].includes(checkbox.value)) {
                originalFormData[name].push(checkbox.value);
            }
        }
    });
    
    console.log('Dados originais capturados:', originalFormData);
}

// Função para detectar mudanças
function detectChanges() {
    const form = document.getElementById('edit-os-form');
    const currentFormData = new FormData(form);
    let currentData = {};
    
    // Capturar dados atuais
    for (let [key, value] of currentFormData.entries()) {
        if (currentData[key]) {
            if (Array.isArray(currentData[key])) {
                currentData[key].push(value);
            } else {
                currentData[key] = [currentData[key], value];
            }
        } else {
            currentData[key] = value;
        }
    }
    
    // Capturar checkboxes atuais
    const checkboxes = form.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        const name = checkbox.name.replace('[]', '');
        if (!currentData[name]) {
            currentData[name] = [];
        }
        if (checkbox.checked && Array.isArray(currentData[name])) {
            if (!currentData[name].includes(checkbox.value)) {
                currentData[name].push(checkbox.value);
            }
        }
    });
    
    // Comparar dados
    let changed = false;
    
    // Verificar campos de texto e select
    for (let key in originalFormData) {
        if (key.includes('_afetados') || key.includes('_detectados') || key.includes('_defeitos') || key.includes('_realizadas')) {
            // Para arrays de checkboxes
            const original = Array.isArray(originalFormData[key]) ? originalFormData[key].sort() : [];
            const current = Array.isArray(currentData[key]) ? currentData[key].sort() : [];
            
            if (JSON.stringify(original) !== JSON.stringify(current)) {
                changed = true;
                console.log(`Mudança detectada em ${key}:`, { original, current });
                break;
            }
        } else {
            // Para campos simples
            // Ignorar campos que não devem ser considerados mudanças
            if (key === 'csrf_token' || key === 'id_os') {
                continue;
            }
            
            if (originalFormData[key] !== currentData[key]) {
                changed = true;
                console.log(`Mudança detectada em ${key}:`, { original: originalFormData[key], current: currentData[key] });
                break;
            }
        }
    }
    
    // Verificar se há novos campos
    for (let key in currentData) {
        if (!originalFormData.hasOwnProperty(key) && currentData[key] !== '') {
            changed = true;
            console.log(`Novo campo detectado: ${key}`, currentData[key]);
            break;
        }
    }
    
    // Verificação específica para itens
    const originalItems = {};
    const currentItems = {};
    
    // Organizar itens originais
    for (let key in originalFormData) {
        if (key.includes('itens[')) {
            const match = key.match(/itens\[(\d+)\]\[(\w+)\]/);
            if (match) {
                const itemId = match[1];
                const field = match[2];
                if (!originalItems[itemId]) originalItems[itemId] = {};
                originalItems[itemId][field] = originalFormData[key];
            }
        }
    }
    
    // Organizar itens atuais
    for (let key in currentData) {
        if (key.includes('itens[')) {
            const match = key.match(/itens\[(\d+)\]\[(\w+)\]/);
            if (match) {
                const itemId = match[1];
                const field = match[2];
                if (!currentItems[itemId]) currentItems[itemId] = {};
                currentItems[itemId][field] = currentData[key];
            }
        }
    }
    
    // Comparar itens
    const originalItemKeys = Object.keys(originalItems);
    const currentItemKeys = Object.keys(currentItems);
    
    // Verificar se número de itens mudou
    if (originalItemKeys.length !== currentItemKeys.length) {
        changed = true;
        console.log('Mudança detectada: número de itens alterado', { 
            original: originalItemKeys.length, 
            current: currentItemKeys.length 
        });
    } else {
        // Verificar se conteúdo dos itens mudou
        for (let itemId of currentItemKeys) {
            if (!originalItems[itemId]) {
                changed = true;
                console.log('Mudança detectada: novo item adicionado', itemId);
                break;
            }
            
            const originalItem = originalItems[itemId];
            const currentItem = currentItems[itemId];
            
            if (JSON.stringify(originalItem) !== JSON.stringify(currentItem)) {
                changed = true;
                console.log('Mudança detectada: conteúdo do item alterado', { 
                    itemId, 
                    original: originalItem, 
                    current: currentItem 
                });
                break;
            }
        }
    }
    
    hasChanges = changed;
    updateSaveButton();
    
    return changed;
}

// Função para atualizar o estado do botão salvar
function updateSaveButton() {
    const btnFinish = document.getElementById('btn-finish');
    const finishText = document.getElementById('finish-text');
    
    if (hasChanges) {
        btnFinish.disabled = false;
        btnFinish.style.opacity = '1';
        btnFinish.style.cursor = 'pointer';
        finishText.textContent = '✓ <?= Language::t('save_changes') ?>';
    } else {
        btnFinish.disabled = true;
        btnFinish.style.opacity = '0.5';
        btnFinish.style.cursor = 'not-allowed';
        finishText.textContent = '<?= Language::t('no_changes_to_save') ?>';
    }
}

// Inicializar página
document.addEventListener('DOMContentLoaded', function() {
    updateNavigationButtons();
    
    // Auto-focus no primeiro campo
    const firstField = document.getElementById('id_ativo');
    if (firstField) {
        firstField.focus();
    }
    
    // Carregar itens existentes da OS
    loadExistingItems();
    
    // Capturar dados originais após carregar tudo
    setTimeout(() => {
        captureOriginalData();
        updateSaveButton(); // Desabilitar botão inicialmente
        
        // Adicionar event listeners para detectar mudanças
        const form = document.getElementById('edit-os-form');
        
        // Event listeners para campos de texto e select
        const textFields = form.querySelectorAll('input[type="text"], input[type="number"], select, textarea');
        textFields.forEach(field => {
            field.addEventListener('input', detectChanges);
            field.addEventListener('change', detectChanges);
        });
        
        // Event listeners para checkboxes
        const checkboxes = form.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', detectChanges);
        });
        
        console.log('Event listeners para detecção de mudanças adicionados');
    }, 100);
    
    // Configurar botão de microfone - implementação unificada
    setTimeout(function() {
        const micButton = document.querySelector('.mic-button[data-target="observacoes"]');
        if (micButton) {
            console.log('Configurando botão de microfone da página OS');
            
            // Remover event listeners duplicados se existirem
            micButton.removeEventListener('click', micButton._clickHandler);
            
            // Criar novo handler
            micButton._clickHandler = function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const targetId = this.getAttribute('data-target');
                console.log('🎤 Clique no microfone para campo:', targetId);
                
                // Verificar se Speech Recognition está disponível
                if (window.speechRecognition && window.speechRecognition.isSupported()) {
                    if (window.speechRecognition.isListening) {
                        console.log('🛑 Parando reconhecimento de voz...');
                        window.speechRecognition.stop();
                    } else {
                        console.log('🎙️ Iniciando reconhecimento de voz...');
                        
                        // Feedback visual imediato
                        this.style.background = '#17a2b8';
                        this.innerHTML = '⏳';
                        this.disabled = true;
                        
                        // Tentar iniciar após pequeno delay
                        setTimeout(() => {
                            const success = window.speechRecognition.start(targetId);
                            if (!success) {
                                // Reverter visual se falhou
                                this.style.background = '#007bff';
                                this.innerHTML = '🎤';
                                this.disabled = false;
                            }
                        }, 200);
                    }
                } else {
                    // Fallback para navegadores sem suporte
                    console.warn('Speech Recognition não suportado');
                    if (window.app) {
                        window.app.showNotification('<?= Language::t('speech_not_supported') ?>', 'warning', 3000);
                    } else {
                        alert('<?= Language::t('speech_not_supported') ?>');
                    }
                }
            };
            
            // Adicionar event listener
            micButton.addEventListener('click', micButton._clickHandler);
            
            // Event listeners para feedback visual
            document.addEventListener('speechstart', function() {
                console.log('🎤 Visual: Reconhecimento iniciado');
                micButton.style.background = '#dc3545';
                micButton.innerHTML = '⏹️';
                micButton.title = 'Clique para parar';
                micButton.disabled = false;
            });
            
            document.addEventListener('speechend', function() {
                console.log('🔚 Visual: Reconhecimento finalizado');
                micButton.style.background = '#007bff';
                micButton.innerHTML = '🎤';
                micButton.title = 'Clique para iniciar gravação de voz';
                micButton.disabled = false;
            });
            
            // Listener adicional para retry feedback
            document.addEventListener('speechretry', function(e) {
                console.log('🔄 Visual: Tentando reconectar...');
                micButton.style.background = '#ffc107';
                micButton.innerHTML = '🔄';
                micButton.title = `Reconectando... (${e.detail.attempt}/3)`;
                micButton.disabled = true;
            });
            
        } else {
            console.error('❌ Botão de microfone não encontrado na página');
        }
    }, 500); // Delay reduzido
});

// Função para carregar itens existentes da OS
function loadExistingItems() {
    // Carregar itens existentes do servidor seria implementado aqui
    // Por enquanto, não adiciona nenhum item automaticamente
    // A lista começa vazia e o usuário pode adicionar itens conforme necessário
    console.log('Lista de itens iniciada vazia');
}
</script>

<?php
$content = ob_get_clean();
include 'views/layouts/app.php';
?>