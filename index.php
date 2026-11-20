<?php
require_once 'config/database.php';

$totalProdutos = $pdo->query("SELECT COUNT(*) FROM produtos")->fetchColumn();
$totalTransportadores = $pdo->query("SELECT COUNT(*) FROM transportadores")->fetchColumn();
$totalFretes = $pdo->query("SELECT COUNT(*) FROM fretes")->fetchColumn();
$fretesPendentes = $pdo->query("SELECT COUNT(*) FROM fretes WHERE status = 'Pendente'")->fetchColumn();

require_once 'includes/header.php';
require_once 'includes/sidebar.php';
?>

<h2 class="fw-bold mb-4">Painel Principal</h2>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm p-3 border-start border-primary border-4">
            <span class="text-muted small">Total de Produtos</span>
            <h2 class="fw-bold mt-1 mb-0"><?= $totalProdutos ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm p-3 border-start border-info border-4">
            <span class="text-muted small">Transportadores</span>
            <h2 class="fw-bold mt-1 mb-0"><?= $totalTransportadores ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm p-3 border-start border-success border-4">
            <span class="text-muted small">Total de Fretes</span>
            <h2 class="fw-bold mt-1 mb-0"><?= $totalFretes ?></h2>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm p-3 border-start border-warning border-4">
            <span class="text-muted small">Fretes Pendentes</span>
            <h2 class="fw-bold mt-1 mb-0"><?= $fretesPendentes ?></h2>
        </div>
    </div>
</div>

<div class="card shadow-sm p-4">
    <h5 class="fw-bold mb-3">Acesso Rápido</h5>
    <div class="d-flex flex-wrap gap-2">
        <a href="/logistech/produtos/cadastrar.php" class="btn btn-primary">+ Novo Produto</a>
        <a href="/logistech/enderecos/cadastrar.php" class="btn btn-outline-primary">+ Novo Endereço</a>
        <a href="/logistech/transportadores/cadastrar.php" class="btn btn-outline-primary">+ Novo Transportador</a>
        <a href="/logistech/fretes/cadastrar.php" class="btn btn-success">+ Novo Frete</a>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>