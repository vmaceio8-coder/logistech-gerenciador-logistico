<?php
require_once '../config/database.php';

$produtos = $pdo->query("SELECT * FROM produtos ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Produtos</h2>
    <a href="cadastrar.php" class="btn btn-primary">+ Novo Produto</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Peso (kg)</th>
                    <th>Quantidade</th>
                    <th width="160">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $p): ?>
                <tr>
                    <td>#<?= $p['id'] ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($p['nome']) ?></td>
                    <td><?= htmlspecialchars($p['descricao']) ?></td>
                    <td><?= number_format($p['peso'], 2, ',', '.') ?> kg</td>
                    <td><?= $p['quantidade'] ?></td>
                    <td>
                        <a href="editar.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="excluir.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este produto?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($produtos)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Nenhum produto cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>