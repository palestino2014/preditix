<?php
$titulo = 'Ordens de Serviço';
require_once 'includes/init.php';
require_once 'classes/OrdemServico.php';
require_once 'classes/Embarcacao.php';
require_once 'classes/Implemento.php';
require_once 'classes/Tanque.php';
require_once 'classes/Veiculo.php';

$ordemServico = new OrdemServico();
$embarcacao = new Embarcacao();
$implemento = new Implemento();
$tanque = new Tanque();
$veiculo = new Veiculo();

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $dados = $_POST;
    
    switch ($action) {
        case 'cadastrar':
            $dados['usuario_abertura_id'] = $_SESSION['usuario_id'];
            $ordemServico->cadastrar($dados);
            break;
        case 'atualizar':
            $ordemServico->atualizar($dados['id'], $dados);
            break;
        case 'excluir':
            $ordemServico->excluir($dados['id']);
            break;
    }
    
    header('Location: ordens_servico.php');
    exit();
}

$ordens = $ordemServico->listar();
require_once 'includes/header.php';
?>

<!-- Adicionar link para os ícones do Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<!-- Adicionar jQuery e Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Ordens de Serviço</h2>
        <a href="form_ordem_servico.php" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nova Ordem
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Número OS</th>
                    <th>Equipamento</th>
                    <th>Data Abertura</th>
                    <th>Data Prevista</th>
                    <th>Data Conclusão</th>
                    <th>Status</th>
                    <th>Prioridade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ordens as $ordem): ?>
                <tr>
                    <td><?= htmlspecialchars($ordem['numero_os']) ?></td>
                    <td><?= htmlspecialchars($ordem['nome']) ?></td>
                    <td><?= date('d/m/Y', strtotime($ordem['data_abertura'])) ?></td>
                    <td><?= $ordem['data_prevista'] ? date('d/m/Y', strtotime($ordem['data_prevista'])) : '-' ?></td>
                    <td><?= $ordem['data_conclusao'] ? date('d/m/Y', strtotime($ordem['data_conclusao'])) : '-' ?></td>
                    <td>
                        <span class="badge bg-<?= $ordem['status'] === 'concluida' ? 'success' : 
                            ($ordem['status'] === 'em_andamento' ? 'warning' : 
                            ($ordem['status'] === 'cancelada' ? 'danger' : 'info')) ?>">
                            <?= ucfirst($ordem['status']) ?>
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-<?= $ordem['prioridade'] === 'urgente' ? 'danger' : 
                            ($ordem['prioridade'] === 'alta' ? 'warning' : 
                            ($ordem['prioridade'] === 'baixa' ? 'success' : 'info')) ?>">
                            <?= ucfirst($ordem['prioridade']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="detalhes_ordem_servico.php?id=<?= $ordem['id'] ?>" class="btn btn-sm btn-primary" title="Detalhes">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="form_ordem_servico.php?id=<?= $ordem['id'] ?>" class="btn btn-sm btn-warning" title="Editar">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="excluirOrdem(<?= $ordem['id'] ?>)" title="Excluir">
                            <i class="bi bi-trash"></i>
                        </button>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializa todos os dropdowns
    var dropdowns = document.querySelectorAll('.dropdown-toggle');
    dropdowns.forEach(function(dropdown) {
        new bootstrap.Dropdown(dropdown);
    });

    // Carrega equipamentos quando o tipo é selecionado
    document.getElementById('tipo_equipamento').addEventListener('change', function() {
        var tipo = this.value;
        var equipamentoSelect = document.getElementById('equipamento_id');
        
        // Limpa as opções atuais
        equipamentoSelect.innerHTML = '<option value="">Selecione o equipamento</option>';
        
        if (!tipo) return;

        // Faz a requisição AJAX
        fetch('api/equipamentos.php?tipo=' + tipo)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao buscar equipamentos');
                }
                return response.json();
            })
            .then(data => {
                if (Array.isArray(data)) {
                    data.forEach(function(item) {
                        var option = document.createElement('option');
                        option.value = item.id;
                        option.textContent = item.nome || item.identificacao;
                        equipamentoSelect.appendChild(option);
                    });
                } else {
                    console.error('Dados inválidos recebidos:', data);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao carregar equipamentos. Por favor, tente novamente.');
            });
    });

    // Reseta o formulário quando o modal é aberto
    var modal = document.getElementById('modalOrdem');
    modal.addEventListener('show.bs.modal', function() {
        document.getElementById('formOrdem').reset();
        document.getElementById('acao').value = 'cadastrar';
    });
});

function editarOrdem(id) {
    fetch(`api/ordem_servico.php?id=${id}`)
        .then(response => response.json())
        .then(ordem => {
            document.getElementById('ordem_id').value = ordem.id;
            document.querySelector('input[name="action"]').value = 'atualizar';
            document.querySelector('input[name="numero_os"]').value = ordem.numero_os;
            document.querySelector('select[name="tipo_equipamento"]').value = ordem.tipo_equipamento;
            document.querySelector('input[name="data_prevista"]').value = ordem.data_prevista;
            document.querySelector('textarea[name="descricao_problema"]').value = ordem.descricao_problema;
            document.querySelector('select[name="status"]').value = ordem.status;
            document.querySelector('select[name="prioridade"]').value = ordem.prioridade;
            document.querySelector('input[name="custo_estimado"]').value = ordem.custo_estimado;
            
            // Carrega os equipamentos do tipo selecionado
            carregarEquipamentos(ordem.tipo_equipamento, ordem.equipamento_id);
            
            // Atualiza o título do modal
            document.querySelector('#modalOrdem .modal-title').textContent = 'Editar Ordem de Serviço';
            
            // Abre o modal usando Bootstrap
            const modal = new bootstrap.Modal(document.getElementById('modalOrdem'));
            modal.show();
        });
}

function excluirOrdem(id) {
    if (confirm('Tem certeza que deseja excluir esta ordem de serviço?')) {
        fetch('ordens_servico.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `action=excluir&id=${id}`
        }).then(() => {
            window.location.reload();
        });
    }
}

function carregarEquipamentos(tipo, equipamentoId = null) {
    const select = document.getElementById('equipamento_id');
    select.innerHTML = '<option value="">Carregando...</option>';
    
    fetch(`api/equipamentos.php?tipo=${tipo}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar equipamentos');
            }
            return response.json();
        })
        .then(equipamentos => {
            let html = '<option value="">Selecione...</option>';
            if (Array.isArray(equipamentos)) {
                equipamentos.forEach(equip => {
                    const selected = equipamentoId && equip.id == equipamentoId ? 'selected' : '';
                    html += `<option value="${equip.id}" ${selected}>${equip.tag} - ${equip.nome || equip.modelo || ''}</option>`;
                });
            }
            select.innerHTML = html;
        })
        .catch(error => {
            console.error('Erro:', error);
            select.innerHTML = '<option value="">Erro ao carregar equipamentos</option>';
        });
}

// Limpar formulário ao abrir modal de nova ordem
document.getElementById('modalOrdem').addEventListener('show.bs.modal', function (event) {
    if (!event.relatedTarget) { // Se não foi aberto por um botão de edição
        document.getElementById('formOrdem').reset();
        document.querySelector('input[name="action"]').value = 'cadastrar';
        document.querySelector('#modalOrdem .modal-title').textContent = 'Nova Ordem de Serviço';
        document.getElementById('equipamento_id').innerHTML = '<option value="">Selecione o tipo primeiro</option>';
    }
});
</script>
