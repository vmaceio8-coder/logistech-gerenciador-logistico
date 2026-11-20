<?php
require_once '../config/database.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE produtos SET nome = ?, descricao = ?, peso = ?, quantidade = ? WHERE id = ?");
    $stmt->execute([
        trim($_POST['nome']),
        trim($_POST['descricao']),
        (float)$_POST['peso'],
        (int)$_POST['quantidade'],
        $id
    ]);
    header('Location: index.php');
    exit;
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<h2 class="fw-bold mb-4">Editar Produto #<?= $produto['id'] ?></h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nome do Produto</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($produto['nome']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control" rows="3"><?= htmlspecialchars($produto['descricao']) ?></textarea>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.01" name="peso" class="form-control" value="<?= $produto['peso'] ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Quantidade em Estoque</label>
                    <input type="number" name="quantidade" class="form-control" value="<?= $produto['quantidade'] ?>" min="1" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Produto</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>