<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO produtos (nome, descricao, peso, quantidade) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        trim($_POST['nome']),
        trim($_POST['descricao']),
        (float)$_POST['peso'],
        (int)$_POST['quantidade']
    ]);
    header('Location: index.php');
    exit;
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<h2 class="fw-bold mb-4">Cadastrar Produto</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nome do Produto</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3"></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.01" name="peso" class="form-control" value="0" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Quantidade em Estoque</label>
                    <input type="number" name="quantidade" class="form-control" value="1" min="1" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Produto</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>