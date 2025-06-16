<?php
require_once 'includes/auth.php';
require_once 'classes/OrdemServico.php';
require_once 'classes/Usuario.php';

Auth::checkAuth();

$ordem = new OrdemServico();
$usuario = new Usuario();

$id = $_GET['id'] ?? null;
$dados = null;
$itens = [];
$mensagem = '';
$tipo_mensagem = '';

if ($id) {
    $dados = $ordem->buscarPorId($id);
    if ($dados) {
        $itens = $ordem->listarItens($id);
    } else {
        header('Location: ordens_servico.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Validar datas
        $data_atual = date('Y-m-d');
        $data_prevista = $_POST['data_prevista'];
        $data_conclusao = !empty($_POST['data_conclusao']) ? $_POST['data_conclusao'] : null;

        if (strtotime($data_prevista) <= strtotime($data_atual)) {
            throw new Exception('A data prevista deve ser maior que a data atual.');
        }

        if ($data_conclusao && strtotime($data_conclusao) <= strtotime($data_atual)) {
            throw new Exception('A data de conclusão deve ser maior que a data atual.');
        }

        if ($id) {
            $dados_atualizados = [
                'data_prevista' => $_POST['data_prevista'],
                'data_conclusao' => !empty($_POST['data_conclusao']) ? $_POST['data_conclusao'] : null,
                'descricao_solucao' => $_POST['descricao_solucao'],
                'status' => $_POST['status'],
                'prioridade' => $_POST['prioridade'],
                'custo_final' => str_replace(['.', ','], ['', '.'], $_POST['custo_final']),
                'usuario_responsavel_id' => $_POST['usuario_responsavel_id']
            ];

            if ($ordem->atualizar($id, $dados_atualizados)) {
                // Processar itens da ordem de serviço
                if (isset($_POST['itens']) && is_array($_POST['itens'])) {
                    foreach ($_POST['itens'] as $item) {
                        if (!empty($item['descricao'])) {
                            $item_data = [
                                'descricao' => $item['descricao'],
                                'quantidade' => str_replace(['.', ','], ['', '.'], $item['quantidade']),
                                'unidade' => $item['unidade'],
                                'valor_unitario' => str_replace(['.', ','], ['', '.'], $item['valor_unitario'])
                            ];
                            
                            if (isset($item['id']) && !empty($item['id'])) {
                                // Atualizar item existente
                                $ordem->atualizarItem($item['id'], $item_data);
                            } else {
                                // Adicionar novo item
                                $ordem->adicionarItem($id, $item_data);
                            }
                        }
                    }
                }

                // Remover itens excluídos
                if (isset($_POST['itens_excluidos']) && !empty($_POST['itens_excluidos'])) {
                    $itens_excluidos = explode(',', $_POST['itens_excluidos']);
                    foreach ($itens_excluidos as $item_id) {
                        if (!empty($item_id)) {
                            $ordem->excluirItem($item_id);
                        }
                    }
                }

                $mensagem = 'Ordem de serviço atualizada com sucesso!';
                $tipo_mensagem = 'success';
                $dados = $ordem->buscarPorId($id);
                $itens = $ordem->listarItens($id);
            } else {
                throw new Exception('Erro ao atualizar a ordem de serviço.');
            }
        } else {
            // Lógica de cadastro de nova OS
            $dados_nova_os = [
                'numero_os' => 'OS-' . date('Y') . '-' . str_pad($ordem->obterProximoNumeroOS(), 3, '0', STR_PAD_LEFT),
                'tipo_equipamento' => $_POST['tipo_equipamento'],
                'equipamento_id' => $_POST['equipamento_id'],
                'data_abertura' => date('Y-m-d H:i:s'),
                'data_prevista' => $_POST['data_prevista'],
                'descricao_problema' => $_POST['descricao_problema'],
                'status' => $_POST['status'] ?? 'aberta',
                'prioridade' => $_POST['prioridade'] ?? 'media',
                'custo_estimado' => str_replace(['.', ','], ['', '.'], $_POST['custo_estimado']),
                'usuario_abertura_id' => $_SESSION['usuario_id'],
                'usuario_responsavel_id' => $_POST['usuario_responsavel_id']
            ];

            if ($ordem->cadastrar($dados_nova_os)) {
                $mensagem = 'Ordem de serviço cadastrada com sucesso!';
                $tipo_mensagem = 'success';
                header('Location: ordens_servico.php');
                exit();
            } else {
                throw new Exception('Erro ao cadastrar a ordem de serviço.');
            }
        }
    } catch (Exception $e) {
        $mensagem = 'Erro: ' . $e->getMessage();
        $tipo_mensagem = 'danger';
    }
}

$usuarios = $usuario->listar();

require_once 'includes/header.php';
?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?php echo $id ? 'Editar' : 'Nova'; ?> Ordem de Serviço</h1>
        <div>
            <a href="ordens_servico/ordens_servico.php" class="btn btn-secondary">Voltar</a>
        </div>
    </div>

    <?php if ($mensagem): ?>
        <div class="alert alert-<?php echo $tipo_mensagem; ?> alert-dismissible fade show" role="alert">
            <?php echo $mensagem; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" class="needs-validation" novalidate>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Informações Básicas</h5>
                <div class="row">
                    <?php if ($id): ?>
                    <div class="col-md-6 mb-3">
                        <label for="numero_os" class="form-label">Número OS</label>
                        <input type="text" class="form-control" id="numero_os" value="<?php echo htmlspecialchars($dados['numero_os'] ?? ''); ?>" readonly>
                    </div>
                    <?php else: ?>
                    <div class="col-md-6 mb-3">
                        <label for="tipo_equipamento" class="form-label">Tipo de Equipamento</label>
                        <select class="form-select" id="tipo_equipamento" name="tipo_equipamento" required>
                            <option value="">Selecione...</option>
                            <option value="embarcacao">Embarcação</option>
                            <option value="implemento">Implemento</option>
                            <option value="tanque">Tanque</option>
                            <option value="veiculo">Veículo</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="equipamento_id" class="form-label">Equipamento</label>
                        <select class="form-select" id="equipamento_id" name="equipamento_id" required>
                            <option value="">Selecione o tipo primeiro</option>
                        </select>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="aberta" <?php echo ($dados['status'] ?? '') === 'aberta' ? 'selected' : ''; ?>>Aberta</option>
                            <option value="em_andamento" <?php echo ($dados['status'] ?? '') === 'em_andamento' ? 'selected' : ''; ?>>Em Andamento</option>
                            <option value="concluida" <?php echo ($dados['status'] ?? '') === 'concluida' ? 'selected' : ''; ?>>Concluída</option>
                            <option value="cancelada" <?php echo ($dados['status'] ?? '') === 'cancelada' ? 'selected' : ''; ?>>Cancelada</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="prioridade" class="form-label">Prioridade</label>
                        <select class="form-select" id="prioridade" name="prioridade" required>
                            <option value="baixa" <?php echo ($dados['prioridade'] ?? '') === 'baixa' ? 'selected' : ''; ?>>Baixa</option>
                            <option value="media" <?php echo ($dados['prioridade'] ?? '') === 'media' ? 'selected' : ''; ?>>Média</option>
                            <option value="alta" <?php echo ($dados['prioridade'] ?? '') === 'alta' ? 'selected' : ''; ?>>Alta</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="usuario_responsavel_id" class="form-label">Responsável</label>
                        <select class="form-select" id="usuario_responsavel_id" name="usuario_responsavel_id" required>
                            <option value="">Selecione um responsável</option>
                            <?php foreach ($usuarios as $u): ?>
                                <option value="<?php echo $u['id']; ?>" <?php echo ($dados['usuario_responsavel_id'] ?? '') == $u['id'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($u['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Datas</h5>
                <div class="row">
                    <?php if ($id): ?>
                    <div class="col-md-4 mb-3">
                        <label for="data_abertura" class="form-label">Data de Abertura</label>
                        <input type="datetime-local" class="form-control" id="data_abertura" value="<?php echo date('Y-m-d\TH:i', strtotime($dados['data_abertura'] ?? '')); ?>" readonly>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-4 mb-3">
                        <label for="data_prevista" class="form-label">Data Prevista</label>
                        <input type="date" class="form-control" id="data_prevista" name="data_prevista" 
                               min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" 
                               value="<?php echo !empty($dados['data_prevista']) ? date('Y-m-d', strtotime($dados['data_prevista'])) : date('Y-m-d', strtotime('+1 day')); ?>" required>
                    </div>
                    <?php if ($id): ?>
                    <div class="col-md-4 mb-3">
                        <label for="data_conclusao" class="form-label">Data de Conclusão</label>
                        <input type="date" class="form-control" id="data_conclusao" name="data_conclusao" 
                               min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" 
                               value="<?php echo !empty($dados['data_conclusao']) ? date('Y-m-d', strtotime($dados['data_conclusao'])) : date('Y-m-d', strtotime('+1 day')); ?>">
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Descrições</h5>
                <?php if (!$id): ?>
                <div class="mb-3">
                    <label for="descricao_problema" class="form-label">Problema Reportado</label>
                    <textarea class="form-control" id="descricao_problema" name="descricao_problema" rows="3" required><?php echo htmlspecialchars($dados['descricao_problema'] ?? ''); ?></textarea>
                </div>
                <?php else: ?>
                <div class="mb-3">
                    <label for="descricao_problema" class="form-label">Problema Reportado</label>
                    <textarea class="form-control" id="descricao_problema" rows="3" readonly><?php echo htmlspecialchars($dados['descricao_problema'] ?? ''); ?></textarea>
                </div>
                <?php endif; ?>
                <div class="mb-3">
                    <label for="descricao_solucao" class="form-label">Solução Aplicada</label>
                    <textarea class="form-control" id="descricao_solucao" name="descricao_solucao" rows="3"><?php echo htmlspecialchars($dados['descricao_solucao'] ?? ''); ?></textarea>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Custos</h5>
                <div class="row">
                    <?php if (!$id): ?>
                    <div class="col-md-6 mb-3">
                        <label for="custo_estimado" class="form-label">Custo Estimado</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control money" id="custo_estimado" name="custo_estimado" value="<?php echo number_format($dados['custo_estimado'] ?? 0, 2, ',', '.'); ?>" required>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="col-md-6 mb-3">
                        <label for="custo_estimado" class="form-label">Custo Estimado</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control" id="custo_estimado" value="<?php echo number_format($dados['custo_estimado'] ?? 0, 2, ',', '.'); ?>" readonly>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($id): ?>
                    <div class="col-md-6 mb-3">
                        <label for="custo_final" class="form-label">Custo Final</label>
                        <div class="input-group">
                            <span class="input-group-text">R$</span>
                            <input type="text" class="form-control money" id="custo_final" name="custo_final" value="<?php echo number_format($dados['custo_final'] ?? 0, 2, ',', '.'); ?>">
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Itens da Ordem de Serviço</h5>
                    <button type="button" class="btn btn-primary btn-sm" onclick="adicionarItem()">
                        <i class="bi bi-plus-lg"></i> Adicionar Item
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered" id="tabela-itens">
                        <thead class="table-light">
                            <tr>
                                <th>Descrição</th>
                                <th style="width: 150px;">Quantidade</th>
                                <th style="width: 100px;">Unidade</th>
                                <th style="width: 150px;">Valor Unitário</th>
                                <th style="width: 150px;">Total</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itens as $item): ?>
                            <tr>
                                <td>
                                    <input type="hidden" name="itens[<?php echo $item['id']; ?>][id]" value="<?php echo $item['id']; ?>">
                                    <input type="text" class="form-control" name="itens[<?php echo $item['id']; ?>][descricao]" value="<?php echo htmlspecialchars($item['descricao']); ?>" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control money" name="itens[<?php echo $item['id']; ?>][quantidade]" value="<?php echo number_format($item['quantidade'], 2, ',', '.'); ?>" required onchange="calcularTotal(this)">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="itens[<?php echo $item['id']; ?>][unidade]" value="<?php echo htmlspecialchars($item['unidade']); ?>" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control money" name="itens[<?php echo $item['id']; ?>][valor_unitario]" value="<?php echo number_format($item['valor_unitario'], 2, ',', '.'); ?>" required onchange="calcularTotal(this)">
                                </td>
                                <td>
                                    <input type="text" class="form-control" value="<?php echo number_format($item['quantidade'] * $item['valor_unitario'], 2, ',', '.'); ?>" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="excluirItem(this, <?php echo $item['id']; ?>)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-light">
                                <th colspan="4" class="text-end">Total dos Itens:</th>
                                <th id="total-itens">R$ 0,00</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <input type="hidden" name="itens_excluidos" id="itens-excluidos" value="">
            </div>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="submit" class="btn btn-primary"><?php echo $id ? 'Salvar Alterações' : 'Cadastrar'; ?></button>
        </div>
    </form>
</div>

<script>
let itensExcluidos = [];

function adicionarItem() {
    const tbody = document.querySelector('#tabela-itens tbody');
    const novoId = 'novo_' + Date.now();
    
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <input type="text" class="form-control" name="itens[${novoId}][descricao]" required>
        </td>
        <td>
            <input type="text" class="form-control money" name="itens[${novoId}][quantidade]" required onchange="calcularTotal(this)">
        </td>
        <td>
            <input type="text" class="form-control" name="itens[${novoId}][unidade]" required>
        </td>
        <td>
            <input type="text" class="form-control money" name="itens[${novoId}][valor_unitario]" required onchange="calcularTotal(this)">
        </td>
        <td>
            <input type="text" class="form-control" readonly>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm" onclick="excluirItem(this)">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    `;
    
    tbody.appendChild(tr);
    inicializarMascaraDinheiro();
}

function excluirItem(button, itemId = null) {
    const tr = button.closest('tr');
    if (itemId) {
        itensExcluidos.push(itemId);
        document.getElementById('itens-excluidos').value = itensExcluidos.join(',');
    }
    tr.remove();
    calcularTotalGeral();
}

function calcularTotal(input) {
    const tr = input.closest('tr');
    const quantidade = parseFloat(tr.querySelector('input[name$="[quantidade]"]').value.replace('.', '').replace(',', '.')) || 0;
    const valorUnitario = parseFloat(tr.querySelector('input[name$="[valor_unitario]"]').value.replace('.', '').replace(',', '.')) || 0;
    const total = quantidade * valorUnitario;
    
    tr.querySelector('td:nth-last-child(2) input').value = total.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    
    calcularTotalGeral();
}

function calcularTotalGeral() {
    let total = 0;
    document.querySelectorAll('#tabela-itens tbody tr').forEach(tr => {
        const valorTotal = parseFloat(tr.querySelector('td:nth-last-child(2) input').value.replace('.', '').replace(',', '.')) || 0;
        total += valorTotal;
    });
    
    document.getElementById('total-itens').textContent = 'R$ ' + total.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function inicializarMascaraDinheiro() {
    document.querySelectorAll('.money').forEach(input => {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = (parseInt(value) / 100).toFixed(2);
            value = value.replace('.', ',');
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            e.target.value = value;
        });
    });
}

// Adicionar função para carregar equipamentos
function carregarEquipamentos(tipo) {
    const select = document.getElementById('equipamento_id');
    select.innerHTML = '<option value="">Carregando...</option>';
    
    fetch(`api/equipamentos.php?tipo=${tipo}`)
        .then(response => response.json())
        .then(equipamentos => {
            let html = '<option value="">Selecione...</option>';
            if (Array.isArray(equipamentos)) {
                equipamentos.forEach(equip => {
                    html += `<option value="${equip.id}">${equip.tag} - ${equip.nome || equip.modelo || ''}</option>`;
                });
            }
            select.innerHTML = html;
        })
        .catch(error => {
            console.error('Erro:', error);
            select.innerHTML = '<option value="">Erro ao carregar equipamentos</option>';
        });
}

document.addEventListener('DOMContentLoaded', function() {
    inicializarMascaraDinheiro();
    calcularTotalGeral();

    // Adicionar evento para carregar equipamentos quando o tipo é selecionado
    const tipoEquipamento = document.getElementById('tipo_equipamento');
    if (tipoEquipamento) {
        tipoEquipamento.addEventListener('change', function() {
            if (this.value) {
                carregarEquipamentos(this.value);
            } else {
                document.getElementById('equipamento_id').innerHTML = '<option value="">Selecione o tipo primeiro</option>';
            }
        });
    }

    // Adicionar validação de datas
    const dataPrevista = document.getElementById('data_prevista');
    const dataConclusao = document.getElementById('data_conclusao');
    const dataAtual = new Date();
    dataAtual.setHours(0, 0, 0, 0);

    if (dataPrevista) {
        dataPrevista.addEventListener('change', function() {
            const dataSelecionada = new Date(this.value);
            if (dataSelecionada <= dataAtual) {
                alert('A data prevista deve ser maior que a data atual.');
                this.value = '';
            }
        });
    }

    if (dataConclusao) {
        dataConclusao.addEventListener('change', function() {
            const dataSelecionada = new Date(this.value);
            if (dataSelecionada <= dataAtual) {
                alert('A data de conclusão deve ser maior que a data atual.');
                this.value = '';
            }
        });
    }
});
</script>
