<?php
require_once '../config/database.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM enderecos WHERE id = ?");
$stmt->execute([$id]);
$endereco = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$endereco) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("UPDATE enderecos SET identificacao = ?, logradouro = ?, numero = ?, cidade = ?, estado = ?, cep = ? WHERE id = ?");
    $stmt->execute([
        trim($_POST['identificacao']),
        trim($_POST['logradouro']),
        trim($_POST['numero']),
        trim($_POST['cidade']),
        strtoupper(trim($_POST['estado'])),
        trim($_POST['cep']),
        $id
    ]);
    header('Location: index.php');
    exit;
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<h2 class="fw-bold mb-4">Editar Endereço #<?= $endereco['id'] ?></h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Identificação</label>
                    <input type="text" name="identificacao" class="form-control" value="<?= htmlspecialchars($endereco['identificacao']) ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">CEP</label>
                    <input type="text" name="cep" class="form-control" value="<?= htmlspecialchars($endereco['cep']) ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-9">
                    <label class="form-label">Logradouro</label>
                    <input type="text" name="logradouro" class="form-control" value="<?= htmlspecialchars($endereco['logradouro']) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Número</label>
                    <input type="text" name="numero" class="form-control" value="<?= htmlspecialchars($endereco['numero']) ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-9">
                    <label class="form-label">Cidade</label>
                    <input type="text" name="cidade" class="form-control" value="<?= htmlspecialchars($endereco['cidade']) ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado (UF)</label>
                    <select name="estado" class="form-select" required>
                        <?php
                        $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
                        foreach ($ufs as $uf) {
                            $sel = ($endereco['estado'] === $uf) ? 'selected' : '';
                            echo "<option value='$uf' $sel>$uf</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar Endereço</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>