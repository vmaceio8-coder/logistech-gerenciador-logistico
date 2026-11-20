<?php
require_once '../config/database.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM transportadores WHERE id = ?");
$stmt->execute([$id]);
$transportador = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$transportador) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE transportadores SET nome = ?, documento = ?, telefone = ?, veiculo = ? WHERE id = ?");
    $stmt->execute([
        trim($_POST['nome']),
        trim($_POST['documento']),
        trim($_POST['telefone']),
        trim($_POST['veiculo']),
        $id
    ]);
    header('Location: index.php');
    exit;
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<h2 class="fw-bold mb-4">Editar Transportador #<?= $transportador['id'] ?></h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nome / Razão Social</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($transportador['nome']) ?>" required>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">CPF ou CNPJ</label>
                    <input type="text" name="documento" class="form-control" value="<?= htmlspecialchars($transportador['documento']) ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($transportador['telefone']) ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Veículo</label>
                <input type="text" name="veiculo" class="form-control" value="<?= htmlspecialchars($transportador['veiculo']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Transportador</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>