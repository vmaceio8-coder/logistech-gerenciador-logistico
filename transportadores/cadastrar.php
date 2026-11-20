<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO transportadores (nome, documento, telefone, veiculo) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        trim($_POST['nome']),
        trim($_POST['documento']),
        trim($_POST['telefone']),
        trim($_POST['veiculo'])
    ]);
    header('Location: index.php');
    exit;
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<h2 class="fw-bold mb-4">Cadastrar Transportador</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nome / Razão Social</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">CPF ou CNPJ</label>
                    <input type="text" name="documento" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-control" placeholder="(45) 99999-9999">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Veículo</label>
                <input type="text" name="veiculo" class="form-control" placeholder="Ex: Caminhão Baú - Placa ABC1D23">
            </div>
            <button type="submit" class="btn btn-primary">Salvar Transportador</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>