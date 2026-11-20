<?php
require_once '../config/database.php';

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT f.*,
           t.nome AS transportador_nome, t.veiculo, t.telefone,
           eo.identificacao AS origem_ident, eo.logradouro AS origem_rua, eo.numero AS origem_num, eo.cidade AS origem_cidade, eo.estado AS origem_estado,
           ed.identificacao AS destino_ident, ed.logradouro AS destino_rua, ed.numero AS destino_num, ed.cidade AS destino_cidade, ed.estado AS destino_estado
    FROM fretes f
    JOIN transportadores t ON f.transportador_id = t.id
    JOIN enderecos eo ON f.origem_id = eo.id
    JOIN enderecos ed ON f.destino_id = ed.id
    WHERE f.id = ?
");
$stmt->execute([$id]);
$frete = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$frete) {
    header('Location: index.php');
    exit;
}

$stmtItens = $pdo->prepare("
    SELECT fp.quantidade, p.nome, p.peso
    FROM frete_produtos fp
    JOIN produtos p ON fp.produto_id = p.id
    WHERE fp.frete_id = ?
");
$stmtItens->execute([$id]);
$itens = $stmtItens->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Detalhes do Frete #<?= $frete['id'] ?></h2>
    <a href="index.php" class="btn btn-secondary">Voltar</a>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <strong>Data:</strong> <?= date('d/m/Y', strtotime($frete['data_frete'])) ?><br>
                <strong>Status:</strong> <?= htmlspecialchars($frete['status']) ?><br>
                <strong>Valor:</strong> R$ <?= number_format($frete['valor'], 2, ',', '.') ?>
            </div>
            <div class="col-md-4">
                <strong>Transportador:</strong> <?= htmlspecialchars($frete['transportador_nome']) ?><br>
                <strong>Veículo:</strong> <?= htmlspecialchars($frete['veiculo']) ?><br>
                <strong>Telefone:</strong> <?= htmlspecialchars($frete['telefone']) ?>
            </div>
            <div class="col-md-4">
                <strong>Origem:</strong> <?= htmlspecialchars($frete['origem_ident'] . ' - ' . $frete['origem_cidade'] . '/' . $frete['origem_estado']) ?><br>
                <strong>Destino:</strong> <?= htmlspecialchars($frete['destino_ident'] . ' - ' . $frete['destino_cidade'] . '/' . $frete['destino_estado']) ?>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-header bg-white fw-bold">Produtos Transportados neste Frete</div>
    <div class="card-body table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Produto</th>
                    <th>Peso Unitário</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($itens as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nome']) ?></td>
                    <td><?= number_format($item['peso'], 2, ',', '.') ?> kg</td>
                    <td><?= $item['quantidade'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>