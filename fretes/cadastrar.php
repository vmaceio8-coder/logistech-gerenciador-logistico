<?php
require_once '../config/database.php';

$transportadores = $pdo->query("SELECT * FROM transportadores ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$enderecos = $pdo->query("SELECT * FROM enderecos ORDER BY identificacao")->fetchAll(PDO::FETCH_ASSOC);
$produtos = $pdo->query("SELECT * FROM produtos ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("
            INSERT INTO fretes (transportador_id, origem_id, destino_id, data_frete, status, valor)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            (int)$_POST['transportador_id'],
            (int)$_POST['origem_id'],
            (int)$_POST['destino_id'],
            $_POST['data_frete'],
            $_POST['status'],
            (float)$_POST['valor']
        ]);

        $freteId = $pdo->lastInsertId();

        $stmtItem = $pdo->prepare("
            INSERT INTO frete_produtos (frete_id, produto_id, quantidade)
            VALUES (?, ?, ?)
        ");

        if (!empty($_POST['produto_id'])) {
            foreach ($_POST['produto_id'] as $i => $prodId) {
                if (!empty($prodId)) {
                    $qtd = max(1, (int)($_POST['quantidade'][$i] ?? 1));
                    $stmtItem->execute([$freteId, (int)$prodId, $qtd]);
                }
            }
        }

        $pdo->commit();
        header('Location: index.php');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Erro ao salvar frete: " . $e->getMessage());
    }
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<h2 class="fw-bold mb-4">Cadastrar Novo Frete</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (empty($transportadores) || count($enderecos) < 2 || empty($produtos)): ?>
            <div class="alert alert-warning mb-0">
                Cadastre primeiro pelo menos <strong>1 Transportador</strong>, <strong>2 Endereços</strong> e <strong>1 Produto</strong> para gerar um frete.
            </div>
        <?php else: ?>
            <form method="POST">
                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Transportador</label>
                        <select name="transportador_id" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($transportadores as $t): ?>
                                <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['nome']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Endereço de Origem</label>
                        <select name="origem_id" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($enderecos as $e): ?>
                                <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['identificacao'] . ' - ' . $e['cidade'] . '/' . $e['estado']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Endereço de Destino</label>
                        <select name="destino_id" class="form-select" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($enderecos as $e): ?>
                                <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['identificacao'] . ' - ' . $e['cidade'] . '/' . $e['estado']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Data do Frete</label>
                        <input type="date" name="data_frete" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="Pendente">Pendente</option>
                            <option value="Em Trânsito">Em Trânsito</option>
                            <option value="Entregue">Entregue</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Valor do Frete (R$)</label>
                        <input type="number" step="0.01" name="valor" class="form-control" value="0.00" required>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Produtos do Frete</h5>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="adicionarProduto()">+ Adicionar Produto</button>
                </div>

                <div id="lista-produtos">
                    <div class="row g-2 mb-2 item-produto">
                        <div class="col-md-7">
                            <select name="produto_id[]" class="form-select" required>
                                <option value="">Selecione o produto...</option>
                                <?php foreach ($produtos as $p): ?>
                                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nome']) ?> (<?= $p['peso'] ?> kg)</option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="quantidade[]" class="form-control" min="1" value="1" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-danger w-100" onclick="removerProduto(this)">Remover</button>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4">Salvar Frete</button>
                    <a href="index.php" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>