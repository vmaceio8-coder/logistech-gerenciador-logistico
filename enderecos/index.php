<?php
require_once '../config/database.php';

$enderecos = $pdo->query("SELECT * FROM enderecos ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Endereços</h2>
    <a href="cadastrar.php" class="btn btn-primary">+ Novo Endereço</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Identificação</th>
                    <th>Logradouro</th>
                    <th>Cidade / UF</th>
                    <th>CEP</th>
                    <th width="160">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enderecos as $e): ?>
                <tr>
                    <td>#<?= $e['id'] ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($e['identificacao']) ?></td>
                    <td><?= htmlspecialchars($e['logradouro'] . ($e['numero'] ? ', ' . $e['numero'] : '')) ?></td>
                    <td><?= htmlspecialchars($e['cidade'] . '/' . $e['estado']) ?></td>
                    <td><?= htmlspecialchars($e['cep']) ?></td>
                    <td>
                        <a href="editar.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                        <a href="excluir.php?id=<?= $e['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja excluir este endereço?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($enderecos)): ?>
                <tr><td colspan="6" class="text-center text-muted py-4">Nenhum endereço cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>