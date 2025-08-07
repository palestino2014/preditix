<?php
$pageTitle = Language::t('os_number') . ' #' . $order['id_os'];
ob_start();
?>

<div class="os-view-container">
    <!-- Cabeçalho da OS -->
    <div class="os-header card mb-4">
        <div class="card-header d-flex justify-between items-center">
            <h1><?= Language::t('os_number') ?> #<?= $order['id_os'] ?></h1>
            <span class="status-badge status-<?= $order['status'] ?>">
                <?= Language::t('status_' . $order['status']) ?>
            </span>
        </div>
        
        <div class="card-body">
            <!-- Status de autorização -->
            <?php if (!$order['autorizada'] && $order['status'] !== 'rejeitada'): ?>
                <div class="alert" style="background: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: var(--border-radius); margin-bottom: 20px;">
                    ⏳ <?= Language::t('pending_approval') ?>
                </div>
            <?php endif; ?>
            
            <?php if ($order['status'] === 'rejeitada'): ?>
                <div class="alert" style="background: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: var(--border-radius); margin-bottom: 20px;">
                    ❌ <?= Language::t('status_rejeitada') ?>
                    <?php if (!empty($order['acao_rejeitada'])): ?>
                        - <?= Language::t($order['acao_rejeitada']) ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            
            <!-- Informações básicas em grid -->
            <div class="info-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div class="info-group">
                    <label><?= Language::t('vehicle') ?></label>
                    <div style="font-weight: 600; color: var(--dark);">
                        <?= htmlspecialchars($order['tag']) ?> - <?= htmlspecialchars($order['modelo']) ?>
                    </div>
                    <div style="color: var(--gray); font-size: 14px;">
                        <?= htmlspecialchars($order['cor']) ?> | <?= htmlspecialchars($order['placa']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <label><?= Language::t('maintenance_type') ?></label>
                    <div style="font-weight: 600; color: var(--dark);">
                        <?= Language::t('maintenance_' . $order['tipo_manutencao']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <label><?= Language::t('priority') ?></label>
                    <div style="font-weight: 600; color: var(--dark);">
                        <?= Language::t('priority_' . $order['prioridade']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <label><?= Language::t('manager') ?></label>
                    <div style="font-weight: 600; color: var(--dark);">
                        <?= htmlspecialchars($order['gestor_nome']) ?>
                    </div>
                </div>
                
                <div class="info-group">
                    <label><?= Language::t('responsible') ?></label>
                    <div style="font-weight: 600; color: var(--dark);">
                        <?= htmlspecialchars($order['responsavel_nome']) ?>
                    </div>
                </div>
                
                <!-- Datas (só mostrar se não estiverem vazias) -->
                <?php if ($order['data_abertura']): ?>
                    <div class="info-group">
                        <label><?= Language::t('opening_date') ?></label>
                        <div style="font-weight: 600; color: var(--dark);">
                            <?= Language::formatDate($order['data_abertura']) ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($order['data_aprovacao']): ?>
                    <div class="info-group">
                        <label><?= Language::t('approval_date') ?></label>
                        <div style="font-weight: 600; color: var(--dark);">
                            <?= Language::formatDate($order['data_aprovacao']) ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($order['data_conclusao']): ?>
                    <div class="info-group">
                        <label><?= Language::t('completion_date') ?></label>
                        <div style="font-weight: 600; color: var(--dark);">
                            <?= Language::formatDate($order['data_conclusao']) ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php if ($order['data_cancelamento']): ?>
                    <div class="info-group">
                        <label><?= Language::t('cancellation_date') ?></label>
                        <div style="font-weight: 600; color: var(--dark);">
                            <?= Language::formatDate($order['data_cancelamento']) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Sistemas, Sintomas, etc. -->
    <div class="details-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; margin-bottom: 30px;">
        
        <?php if (!empty($order['sistemas_afetados'])): ?>
            <?php $sistemas = json_decode($order['sistemas_afetados'], true); ?>
            <div class="card">
                <div class="card-header">
                    <h3><?= Language::t('affected_systems') ?></h3>
                </div>
                <div class="card-body">
                    <div class="checkbox-grid">
                        <?php foreach ($sistemas as $sistema): ?>
                            <span class="badge" style="background: var(--primary); color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; margin: 2px;">
                                <?= Language::t('system_' . $sistema) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($order['sintomas_detectados'])): ?>
            <?php $sintomas = json_decode($order['sintomas_detectados'], true); ?>
            <div class="card">
                <div class="card-header">
                    <h3><?= Language::t('detected_symptoms') ?></h3>
                </div>
                <div class="card-body">
                    <div class="checkbox-grid">
                        <?php foreach ($sintomas as $sintoma): ?>
                            <span class="badge" style="background: var(--warning); color: var(--dark); padding: 5px 10px; border-radius: 15px; font-size: 12px; margin: 2px;">
                                <?= Language::t('symptom_' . $sintoma) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($order['causas_defeitos'])): ?>
            <?php $causas = json_decode($order['causas_defeitos'], true); ?>
            <div class="card">
                <div class="card-header">
                    <h3><?= Language::t('defect_causes') ?></h3>
                </div>
                <div class="card-body">
                    <div class="checkbox-grid">
                        <?php foreach ($causas as $causa): ?>
                            <span class="badge" style="background: var(--danger); color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; margin: 2px;">
                                <?= Language::t('cause_' . $causa) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($order['intervencoes_realizadas'])): ?>
            <?php $intervencoes = json_decode($order['intervencoes_realizadas'], true); ?>
            <div class="card">
                <div class="card-header">
                    <h3><?= Language::t('interventions_performed') ?></h3>
                </div>
                <div class="card-body">
                    <div class="checkbox-grid">
                        <?php foreach ($intervencoes as $intervencao): ?>
                            <span class="badge" style="background: var(--info); color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; margin: 2px;">
                                <?= Language::t('intervention_' . $intervencao) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($order['acoes_realizadas'])): ?>
            <?php $acoes = json_decode($order['acoes_realizadas'], true); ?>
            <div class="card">
                <div class="card-header">
                    <h3><?= Language::t('actions_performed') ?></h3>
                </div>
                <div class="card-body">
                    <div class="checkbox-grid">
                        <?php foreach ($acoes as $acao): ?>
                            <span class="badge" style="background: var(--success); color: white; padding: 5px 10px; border-radius: 15px; font-size: 12px; margin: 2px;">
                                <?= Language::t('action_' . $acao) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Observações -->
    <?php if (!empty($order['observacoes'])): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h3><?= Language::t('observations') ?></h3>
            </div>
            <div class="card-body">
                <p style="margin: 0; white-space: pre-wrap;"><?= htmlspecialchars($order['observacoes']) ?></p>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Itens -->
    <?php if (!empty($items)): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h3><?= Language::t('items') ?></h3>
            </div>
            <div class="card-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th><?= Language::t('item_description') ?></th>
                                <th><?= Language::t('quantity') ?></th>
                                <th><?= Language::t('unit_value') ?></th>
                                <th><?= Language::t('total') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalGeral = 0; ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                    <td><?= htmlspecialchars($item['descricao']) ?></td>
                                    <td><?= $item['quantidade'] ?></td>
                                    <td>R$ <?= number_format($item['valor_unitario'], 2, ',', '.') ?></td>
                                    <td>R$ <?= number_format($item['total'], 2, ',', '.') ?></td>
                                </tr>
                                <?php $totalGeral += $item['total']; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: 600; background: var(--light);">
                                <td colspan="3"><?= Language::t('total') ?>:</td>
                                <td>R$ <?= number_format($totalGeral, 2, ',', '.') ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Timeline -->
    <?php if (!empty($timeline)): ?>
        <div class="card mb-4">
            <div class="card-header">
                <h3><?= Language::t('timeline_title') ?></h3>
            </div>
            <div class="card-body">
                <div class="timeline <?= count($timeline) === 1 ? 'timeline-single' : '' ?>">
                    <?php foreach ($timeline as $index => $event): ?>
                        <div class="timeline-item">
                            <div class="timeline-dot <?= $index === count($timeline) - 1 ? 'recent' : '' ?>"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">
                                    <?= Language::t('action_' . $event['acao']) ?>
                                </div>
                                <div class="timeline-date">
                                    <?= Language::formatDate($event['data_hora']) ?>
                                </div>
                                <?php if (!empty($event['justificativa'])): ?>
                                    <div class="timeline-description">
                                        "<?= htmlspecialchars($event['justificativa']) ?>"
                                    </div>
                                <?php endif; ?>
                                <div style="font-size: 12px; color: var(--gray); margin-top: 5px;">
                                    por <?= htmlspecialchars($event['usuario_nome']) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Botões de ação -->
    <div class="actions-container">
        <div class="actions-grid" style="display: flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
            
            <!-- Botão Voltar (sempre presente) -->
                            <a href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/dashboard" class="btn btn-secondary">
                ← <?= Language::t('back') ?>
            </a>
            
            <?php
            // Lógica dos botões baseada no tipo de usuário e status
            $user = $currentUser;
            $isManager = ($user['type'] === 'gestor');
            $isTechnician = ($user['type'] === 'tecnico');
            $isOwner = ($isManager && $order['id_gestor'] == $user['id']) || ($isTechnician && $order['id_responsavel'] == $user['id']);
            ?>
            
            <?php if ($isManager && $isOwner): ?>
                <!-- Botões para GESTOR -->
                <?php if ($order['status'] === 'aberta' && !$order['autorizada']): ?>
                    <button type="button" class="btn btn-success" onclick="approveOS(<?= $order['id_os'] ?>)">
                        ✓ <?= Language::t('approve') ?>
                    </button>
                    <button type="button" class="btn btn-danger" onclick="rejectOS(<?= $order['id_os'] ?>, 'abertura')">
                        ✗ <?= Language::t('reject') ?>
                    </button>
                    
                <?php elseif (in_array($order['status'], ['editada', 'concluida', 'cancelada']) && !$order['autorizada']): ?>
                    <button type="button" class="btn btn-success" onclick="approveOS(<?= $order['id_os'] ?>)">
                        ✓ <?= Language::t('approve') ?> <?= Language::t('status_' . $order['status']) ?>
                    </button>
                    <button type="button" class="btn btn-danger" onclick="rejectOS(<?= $order['id_os'] ?>, '<?= $order['status'] ?>')">
                        ✗ <?= Language::t('reject') ?>
                    </button>
                    
                <?php elseif ($order['status'] === 'em_andamento'): ?>
                    <button type="button" class="btn btn-warning" onclick="editOS(<?= $order['id_os'] ?>)">
                        ✏️ <?= Language::t('edit') ?>
                    </button>
                    <button type="button" class="btn btn-success" onclick="completeOS(<?= $order['id_os'] ?>)">
                        ✓ <?= Language::t('complete') ?>
                    </button>
                    <button type="button" class="btn btn-danger" onclick="cancelOS(<?= $order['id_os'] ?>)">
                        ❌ <?= Language::t('cancel') ?>
                    </button>
                <?php endif; ?>
                
            <?php elseif ($isTechnician && $isOwner): ?>
                <!-- Botões para TÉCNICO -->
                <?php if ($order['status'] === 'aberta'): ?>
                    <!-- Técnico só pode aguardar aprovação -->
                    
                <?php elseif ($order['status'] === 'em_andamento'): ?>
                    <button type="button" class="btn btn-warning" onclick="editOS(<?= $order['id_os'] ?>)">
                        ✏️ <?= Language::t('edit') ?>
                    </button>
                    <button type="button" class="btn btn-success" onclick="completeOS(<?= $order['id_os'] ?>)">
                        ✓ <?= Language::t('complete') ?>
                    </button>
                    <button type="button" class="btn btn-danger" onclick="cancelOS(<?= $order['id_os'] ?>)">
                        ❌ <?= Language::t('cancel') ?>
                    </button>
                    
                <?php elseif ($order['status'] === 'rejeitada'): ?>
                    <button type="button" class="btn btn-primary" onclick="tryAgain(<?= $order['id_os'] ?>)">
                        🔄 <?= Language::t('try_again') ?>
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="giveUp(<?= $order['id_os'] ?>)">
                        ❌ <?= Language::t('give_up') ?>
                    </button>
                <?php endif; ?>
            <?php endif; ?>
            
            <!-- Botão "Reabrir como Nova" para OS concluídas/canceladas -->
            <?php if (in_array($order['status'], ['concluida', 'cancelada']) && $order['autorizada']): ?>
                <button type="button" class="btn btn-info" onclick="reopenAsNew(<?= $order['id_os'] ?>)">
                    🔄 <?= Language::t('reopen_as_new') ?>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal de rejeição -->
<div id="reject-modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="reject-title"></h3>
        </div>
        <div class="modal-body">
            <label for="reject-reason" class="form-label"><?= Language::t('reject_reason') ?></label>
            <div class="speech-input-group">
                <textarea 
                    id="reject-reason" 
                    class="form-control textarea" 
                    placeholder="<?= Language::t('reject_reason') ?>..."
                    required
                ></textarea>
                <button type="button" class="mic-button" onclick="startSpeechRecognition('reject-reason')">
                    🎤
                </button>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeRejectModal()"><?= Language::t('cancel') ?></button>
            <button type="button" class="btn btn-danger" onclick="confirmReject()"><?= Language::t('reject') ?></button>
        </div>
    </div>
</div>

<script>
let currentRejectAction = null;
let currentOSId = null;

function approveOS(osId) {
    if (confirm('<?= Language::t('confirm_approve') ?>')) {
        fetch('/os/approve', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `os_id=${osId}&csrf_token=${window.appConfig.csrfToken}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess(data.message);
                setTimeout(() => location.reload(), 1500);
            } else {
                showError(data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('<?= Language::t('error_unknown') ?>');
        });
    }
}

function rejectOS(osId, action) {
    currentOSId = osId;
    currentRejectAction = action;
    
    document.getElementById('reject-title').textContent = 
        '<?= Language::t('reject_title') ?>'.replace('%s', '<?= Language::t('status_' . $order['status']) ?>');
    document.getElementById('reject-reason').value = '';
    document.getElementById('reject-modal').classList.add('active');
}

function closeRejectModal() {
    document.getElementById('reject-modal').classList.remove('active');
    currentOSId = null;
    currentRejectAction = null;
}

function confirmReject() {
    const reason = document.getElementById('reject-reason').value.trim();
    
    if (!reason) {
        showError('<?= Language::t('reject_reason_required') ?>');
        return;
    }
    
    fetch('/os/reject', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `os_id=${currentOSId}&justification=${encodeURIComponent(reason)}&csrf_token=${window.appConfig.csrfToken}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            closeRejectModal();
            showSuccess(data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showError(data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('<?= Language::t('error_unknown') ?>');
    });
}

function editOS(osId) {
    window.location.href = '<?= dirname($_SERVER['SCRIPT_NAME']) ?>/os/edit?id=' + osId;
}

function completeOS(osId) {
    if (confirm('<?= Language::t('confirm_complete') ?>')) {
        // Implementar lógica de conclusão
        console.log('Complete OS:', osId);
    }
}

function cancelOS(osId) {
    if (confirm('<?= Language::t('confirm_cancel_active_os') ?>')) {
        // Implementar lógica de cancelamento
        console.log('Cancel OS:', osId);
    }
}

function tryAgain(osId) {
    // Implementar lógica de tentar novamente
    console.log('Try again OS:', osId);
}

function giveUp(osId) {
    if (confirm('<?= Language::t('confirm_cancel_active_os') ?>')) {
        // Implementar lógica de desistir
        console.log('Give up OS:', osId);
    }
}

function reopenAsNew(osId) {
    window.location.href = '<?= dirname($_SERVER['SCRIPT_NAME']) ?>/os/create?reopen=' + osId;
}

function showSuccess(message) {
    // Implementar notificação de sucesso
    alert(message); 
}

function showError(message) {
    // Implementar notificação de erro
    alert(message);
}

// Função de reconhecimento de voz (será implementada no speech.js)
function startSpeechRecognition(targetId) {
    if (window.speechRecognition) {
        window.speechRecognition.start(targetId);
    } else {
        alert('Reconhecimento de voz não disponível');
    }
}
</script>

<?php
$content = ob_get_clean();
include 'views/layouts/app.php';
?>