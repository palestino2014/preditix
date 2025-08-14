<?php
$pageTitle = Language::t('dashboard_title');
$showFilter = true;
ob_start();
?>

<div class="dashboard-container">
    <!-- Título e estatísticas -->
    <div class="dashboard-header" style="margin-bottom: 30px;">
        <h1 style="color: var(--dark); margin-bottom: 20px;">
            <?= Language::t('dashboard_title') ?>
        </h1>
        
        <?php if (!empty($orders)): ?>
            <div class="stats-grid" style="
                display: grid; 
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); 
                gap: 20px; 
                margin-bottom: 30px;
            ">
                <?php
                $totalOS = count($orders);
                $pendingApproval = count(array_filter($orders, fn($os) => !$os['autorizada']));
                $inProgress = count(array_filter($orders, fn($os) => $os['status'] === 'em_andamento'));
                ?>
                
                <div class="stat-card card">
                    <div class="card-body text-center">
                        <h3 style="color: var(--primary); margin-bottom: 5px;"><?= $totalOS ?></h3>
                        <p style="color: var(--gray); margin: 0;"><?= Language::t('total_os') ?></p>
                    </div>
                </div>
                
                <div class="stat-card card">
                    <div class="card-body text-center">
                        <h3 style="color: var(--warning); margin-bottom: 5px;"><?= $pendingApproval ?></h3>
                        <p style="color: var(--gray); margin: 0;"><?= Language::t('pending_approval') ?></p>
                    </div>
                </div>
                
                <div class="stat-card card">
                    <div class="card-body text-center">
                        <h3 style="color: var(--info); margin-bottom: 5px;"><?= $inProgress ?></h3>
                        <p style="color: var(--gray); margin: 0;"><?= Language::t('status_em_andamento') ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Mensagens -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success mb-3" style="
            background: var(--light); 
            border: 1px solid var(--success); 
            color: var(--success); 
            padding: 15px; 
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        ">
            <?= nl2br(htmlspecialchars($_SESSION['success_message'])) ?>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-error mb-3" style="
            background: #fee; 
            border: 1px solid var(--danger); 
            color: var(--danger); 
            padding: 15px; 
            border-radius: var(--border-radius);
            margin-bottom: 20px;
        ">
            <?= htmlspecialchars($_SESSION['error_message']) ?>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <!-- Painel de Filtros (inicialmente oculto) -->
    <div id="filter-panel" class="card" style="display: none; margin-bottom: 20px;">
        <div class="card-header">
            <h4>🔍 <?= Language::t('filter_options') ?></h4>
        </div>
        <div class="card-body">
            <div class="filter-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <!-- Filtro por Status -->
                <div class="form-group">
                    <label class="form-label"><?= Language::t('status') ?></label>
                    <select id="filter-status" class="form-control">
                        <option value=""><?= Language::t('all_status') ?></option>
                        <option value="aberta"><?= Language::t('status_aberta') ?></option>
                        <option value="em_andamento"><?= Language::t('status_em_andamento') ?></option>
                        <option value="editada"><?= Language::t('status_editada') ?></option>
                        <option value="concluida"><?= Language::t('status_concluida') ?></option>
                        <option value="cancelada"><?= Language::t('status_cancelada') ?></option>
                        <option value="rejeitada"><?= Language::t('status_rejeitada') ?></option>
                    </select>
                </div>
                
                <!-- Filtro por Autorização -->
                <div class="form-group">
                    <label class="form-label"><?= Language::t('authorization') ?></label>
                    <select id="filter-authorized" class="form-control">
                        <option value=""><?= Language::t('all_authorizations') ?></option>
                        <option value="1"><?= Language::t('authorized') ?></option>
                        <option value="0"><?= Language::t('pending_authorization') ?></option>
                    </select>
                </div>
                
                <!-- Filtro por Técnico -->
                <div class="form-group">
                    <label class="form-label"><?= Language::t('technician') ?></label>
                    <select id="filter-technician" class="form-control">
                        <option value=""><?= Language::t('all_technicians') ?></option>
                        <?php 
                        $technicians = array_unique(array_filter(array_column($orders, 'created_by_name')));
                        foreach ($technicians as $tech): 
                        ?>
                            <option value="<?= htmlspecialchars($tech) ?>"><?= htmlspecialchars($tech) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Filtro por Ativo -->
                <div class="form-group">
                    <label class="form-label"><?= Language::t('asset') ?></label>
                    <select id="filter-asset" class="form-control">
                        <option value=""><?= Language::t('all_assets') ?></option>
                        <?php 
                        if (isset($assets) && !empty($assets)): 
                            foreach ($assets as $asset): 
                        ?>
                            <option value="<?= htmlspecialchars($asset['tag']) ?>"><?= htmlspecialchars($asset['tag']) ?> - <?= htmlspecialchars($asset['modelo']) ?></option>
                        <?php 
                            endforeach; 
                        endif; 
                        ?>
                    </select>
                </div>
                
                <!-- Botão de Ação -->
                <div class="form-group d-flex align-items-end">
                    <button type="button" class="btn btn-secondary w-full" onclick="clearFilters()">
                        🔄 <?= Language::t('clear_filters') ?>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabela de OS -->
    <div class="card">
        <div class="card-header d-flex justify-between items-center">
            <h3><?= Language::t('dashboard_title') ?></h3>
            <a href="<?= dirname($_SERVER['SCRIPT_NAME']) ?>/os/create" class="btn btn-primary btn-mobile-round">
                ➕ <?= Language::t('open_os') ?>
            </a>
        </div>
        
        <div class="card-body" style="padding: 0;">
            <?php if (empty($orders)): ?>
                <div class="text-center" style="padding: 40px;">
                    <div style="font-size: 48px; margin-bottom: 20px;">📋</div>
                    <h3 style="color: var(--gray); margin-bottom: 10px;">Nenhuma OS encontrada</h3>
                    <p style="color: var(--gray);">Clique no botão "<?= Language::t('open_os') ?>" para criar sua primeira OS.</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table" id="os-table">
                        <thead>
                            <tr>
                                <th><?= Language::t('os_number') ?></th>
                                <th class="desktop-only"><?= Language::t('tag') ?></th>
                                <th class="desktop-only"><?= Language::t('model') ?></th>
                                <th class="desktop-only"><?= Language::t('color') ?></th>
                                <th class="desktop-only"><?= Language::t('plate') ?></th>
                                <th><?= Language::t('status') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr 
                                    onclick="viewOrder(<?= $order['id_os'] ?>)" 
                                    class="os-row <?= !$order['autorizada'] ? 'nao-autorizada' : '' ?>"
                                    data-os-id="<?= $order['id_os'] ?>"
                                    data-status="<?= htmlspecialchars($order['status']) ?>"
                                    data-authorized="<?= $order['autorizada'] ? '1' : '0' ?>"
                                    data-technician="<?= htmlspecialchars($order['created_by_name'] ?? 'N/A') ?>"
                                    data-asset="<?= htmlspecialchars($order['tag']) ?>"
                                >
                                    <td>
                                        <div class="os-cell-content">
                                            <strong>#<?= $order['id_os'] ?></strong>
                                            <div class="mobile-only" style="font-size: 14px; color: var(--gray); margin-top: 5px;">
                                                <?= htmlspecialchars($order['tag']) ?> - <?= htmlspecialchars($order['modelo']) ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="desktop-only"><?= htmlspecialchars($order['tag']) ?></td>
                                    <td class="desktop-only"><?= htmlspecialchars($order['modelo']) ?></td>
                                    <td class="desktop-only"><?= htmlspecialchars($order['cor']) ?></td>
                                    <td class="desktop-only"><?= htmlspecialchars($order['placa']) ?></td>
                                    <td>
                                        <span class="status-badge status-<?= $order['status'] ?>">
                                            <?= Language::t('status_' . $order['status']) ?>
                                        </span>
                                        <?php if (!$order['autorizada']): ?>
                                            <div style="font-size: 12px; color: var(--warning); margin-top: 5px;">
                                                ⏳ <?= Language::t('pending_approval') ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Esta função já foi definida mais abaixo, removendo duplicata

// Responsividade da tabela
function adjustTableForMobile() {
    const isMobile = window.innerWidth <= 767;
    const table = document.getElementById('os-table');
    
    if (table) {
        if (isMobile) {
            table.classList.add('table-mobile');
        } else {
            table.classList.remove('table-mobile');
        }
    }
}

// Executar no carregamento e redimensionamento
document.addEventListener('DOMContentLoaded', adjustTableForMobile);
window.addEventListener('resize', adjustTableForMobile);

// Auto-refresh desabilitado - causava recarregamentos indesejados
// setInterval(() => {
//     if (document.visibilityState === 'visible') {
//         // Apenas recarregar se não houver modais abertos
//         if (!document.querySelector('.modal.active')) {
//             location.reload();
//         }
//     }
// }, 30000);

// Indicador de sincronização offline
window.addEventListener('online', () => {
    document.getElementById('offline-indicator').classList.remove('show');
    // Sincronizar dados pendentes
    if (window.offlineSync) {
        window.offlineSync.syncPendingData();
    }
});

window.addEventListener('offline', () => {
    document.getElementById('offline-indicator').classList.add('show');
});
</script>

<script>
// Funcionalidade do Filtro de OS
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar funcionalidade do botão de filtro
    initializeFilterButton();
    
    // Aplicar filtros em tempo real quando valores mudarem
    const filterInputs = document.querySelectorAll('#filter-status, #filter-authorized, #filter-technician, #filter-asset');
    filterInputs.forEach(input => {
        input.addEventListener('change', applyFilters);
    });
});

// Inicializar botão de filtro
function initializeFilterButton() {
    const filterButton = document.getElementById('filter-button');
    if (filterButton) {
        filterButton.addEventListener('click', toggleFilterPanel);
    }
}

// Mostrar/ocultar painel de filtros
function toggleFilterPanel() {
    const panel = document.getElementById('filter-panel');
    const button = document.getElementById('filter-button');
    
    if (panel.style.display === 'none' || panel.style.display === '') {
        panel.style.display = 'block';
        button.innerHTML = '🔍 <?= Language::t('filter') ?> ▲';
        
        // Scroll suave para o painel
        panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    } else {
        // Limpar filtros automaticamente ao fechar
        clearFilters();
        panel.style.display = 'none';
        button.innerHTML = '🔍 <?= Language::t('filter') ?>';
    }
}

// Aplicar filtros
function applyFilters() {
    const statusFilter = document.getElementById('filter-status').value.toLowerCase();
    const authorizedFilter = document.getElementById('filter-authorized').value;
    const technicianFilter = document.getElementById('filter-technician').value.toLowerCase();
    const assetFilter = document.getElementById('filter-asset').value.toLowerCase();
    
    const rows = document.querySelectorAll('#os-table tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        let showRow = true;
        
        // Filtro por status
        if (statusFilter && row.dataset.status.toLowerCase() !== statusFilter) {
            showRow = false;
        }
        
        // Filtro por autorização
        if (authorizedFilter && row.dataset.authorized !== authorizedFilter) {
            showRow = false;
        }
        
        // Filtro por técnico
        if (technicianFilter && !row.dataset.technician.toLowerCase().includes(technicianFilter)) {
            showRow = false;
        }
        
        // Filtro por ativo
        if (assetFilter && row.dataset.asset.toLowerCase() !== assetFilter) {
            showRow = false;
        }
        
        if (showRow) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
}

// Limpar filtros
function clearFilters() {
    document.getElementById('filter-status').value = '';
    document.getElementById('filter-authorized').value = '';
    document.getElementById('filter-technician').value = '';
    document.getElementById('filter-asset').value = '';
    
    // Mostrar todas as linhas
    const rows = document.querySelectorAll('#os-table tbody tr');
    rows.forEach(row => {
        row.style.display = '';
    });
}



// Função global para abrir OS (já existente, mantendo)
function viewOrder(id) {
    window.location.href = '<?= dirname($_SERVER['SCRIPT_NAME']) ?>/os/view?id=' + id;
}
</script>

<?php
$content = ob_get_clean();
include 'views/layouts/app.php';
?>