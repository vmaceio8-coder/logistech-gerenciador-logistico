<?php
require_once '../config/database.php';

$sql = "
    SELECT f.*,
           t.nome AS transportador_nome,
           eo.cidade AS origem_cidade, eo.estado AS origem_estado,
           ed.cidade AS destino_cidade, ed.estado AS destino_estado,
           (SELECT COUNT(*) FROM frete_produtos fp WHERE fp.frete_id = f.id) AS total_itens
    FROM fretes f
    JOIN transportadores t ON f.transportador_id = t.id
    JOIN enderecos eo ON f.origem_id = eo.id
    JOIN enderecos ed ON f.destino_id = ed.id
    ORDER BY f.id DESC
";
$fretes = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Fretes</h2>
    <a href="cadastrar.php" class="btn btn-success">+ Novo Frete</a>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Transportador</th>
                    <th>Origem → Destino</th>
                    <th>Produtos</th>
                    <th>Valor</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fretes as $f): ?>
                <tr>
                    <td>#<?= $f['id'] ?></td>
                    <td><?= date('d/m/Y', strtotime($f['data_frete'])) ?></td>
                    <td class="fw-semibold"><?= htmlspecialchars($f['transportador_nome']) ?></td>
                    <td>
                        <?= htmlspecialchars($f['origem_cidade'] . '/' . $f['origem_estado']) ?>
                        →
                        <?= htmlspecialchars($f['destino_cidade'] . '/' . $f['destino_estado']) ?>
                    </td>
                    <td><span class="badge bg-secondary"><?= $f['total_itens'] ?> item(ns)</span></td>
                    <td>R$ <?= number_format($f['valor'], 2, ',', '.') ?></td>
                    <td>
                        <?php
                        $cor = match($f['status']) {
                            'Entregue' => 'success',
                            'Em Trânsito' => 'primary',
                            default => 'warning text-dark'
                        };
                        ?>
                        <span class="badge bg-<?= $cor ?>"><?= htmlspecialchars($f['status']) ?></span>
                    </td>
                    <td>
                        <a href="detalhes.php?id=<?= $f['id'] ?>" class="btn btn-sm btn-info text-white">Detalhes</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($fretes)): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">Nenhum frete cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>