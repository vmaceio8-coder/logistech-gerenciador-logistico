<?php
require_once '../config/database.php';

$dataFiltro = $_GET['data'] ?? date('Y-m-d');

$stmt = $pdo->prepare("
    SELECT f.id, f.data_frete, f.status, f.valor,
           t.nome AS transportador,
           CONCAT(eo.cidade, '/', eo.estado) AS origem,
           CONCAT(ed.cidade, '/', ed.estado) AS destino,
           GROUP_CONCAT(CONCAT(fp.quantidade, 'x ', p.nome) SEPARATOR ' | ') AS produtos
    FROM fretes f
    JOIN transportadores t ON f.transportador_id = t.id
    JOIN enderecos eo ON f.origem_id = eo.id
    JOIN enderecos ed ON f.destino_id = ed.id
    LEFT JOIN frete_produtos fp ON fp.frete_id = f.id
    LEFT JOIN produtos p ON p.id = fp.produto_id
    WHERE f.data_frete = ?
    GROUP BY f.id
    ORDER BY f.id DESC
");
$stmt->execute([$dataFiltro]);
$fretes = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['baixar']) && $_GET['baixar'] === '1') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="relatorio_fretes_' . $dataFiltro . '.csv"');

    $saida = fopen('php://output', 'w');
    fprintf($saida, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 para Excel

    fputcsv($saida, ['ID', 'Data', 'Transportador', 'Origem', 'Destino', 'Produtos', 'Valor (R$)', 'Status'], ';');

    foreach ($fretes as $f) {
        fputcsv($saida, [
            $f['id'],
            date('d/m/Y', strtotime($f['data_frete'])),
            $f['transportador'],
            $f['origem'],
            $f['destino'],
            $f['produtos'],
            number_format($f['valor'], 2, ',', '.'),
            $f['status']
        ], ';');
    }

    fclose($saida);
    exit;
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<h2 class="fw-bold mb-4">Relatório de Fretes por Data</h2>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Selecione a Data</label>
                <input type="date" name="data" class="form-control" value="<?= htmlspecialchars($dataFiltro) ?>" required>
            </div>
            <div class="col-md-6">
                <button type="submit" class="btn btn-primary">Consultar</button>
                <?php if (!empty($fretes)): ?>
                    <a href="?data=<?= urlencode($dataFiltro) ?>&baixar=1" class="btn btn-success ms-2">Baixar Relatório (.CSV)</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Transportador</th>
                    <th>Origem</th>
                    <th>Destino</th>
                    <th>Produtos</th>
                    <th>Valor</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fretes as $f): ?>
                <tr>
                    <td>#<?= $f['id'] ?></td>
                    <td><?= date('d/m/Y', strtotime($f['data_frete'])) ?></td>
                    <td><?= htmlspecialchars($f['transportador']) ?></td>
                    <td><?= htmlspecialchars($f['origem']) ?></td>
                    <td><?= htmlspecialchars($f['destino']) ?></td>
                    <td><?= htmlspecialchars($f['produtos']) ?></td>
                    <td>R$ <?= number_format($f['valor'], 2, ',', '.') ?></td>
                    <td><?= htmlspecialchars($f['status']) ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($fretes)): ?>
                <tr><td colspan="8" class="text-center text-muted py-4">Nenhum frete encontrado para esta data.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>