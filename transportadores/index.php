<?php
require_once '../config/database.php';

$transportadores = $pdo->query("SELECT * FROM transportadores ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Transportadores</h2>
    <a href="cadastrar.php" class="btn btn-primary">+ Novo Transportador</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF / CNPJ</th>
                    <th>Telefone</th>
                    <th>Veículo</th>
                    <th width="160">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transportadores as $t): ?>
                <tr>
                    <td>#<?= $t['id'] ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($t['nome']) ?></td>
                    <td><?= htmlspecialchars($t['documento']) ?></td>
                    <td><?= htmlspecialchars($t['telefone']) ?></td>
                    <td><?= htmlspecialchars($t['veiculo']) ?></td>
                    <td>
                        <a href="editar.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="excluir.php?id=<?= $t['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este transportador?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($transportadores)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Nenhum transportador cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>v