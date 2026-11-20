<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO enderecos (identificacao, logradouro, numero, cidade, estado, cep) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        trim($_POST['identificacao']),
        trim($_POST['logradouro']),
        trim($_POST['numero']),
        trim($_POST['cidade']),
        strtoupper(trim($_POST['estado'])),
        trim($_POST['cep'])
    ]);
    header('Location: index.php');
    exit;
}

require_once '../includes/header.php';
require_once '../includes/sidebar.php';
?>

<h2 class="fw-bold mb-4">Cadastrar Endereço</h2>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Identificação (Ex: Origem - Matriz / Destino - Filial)</label>
                    <input type="text" name="identificacao" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">CEP</label>
                    <input type="text" name="cep" class="form-control" placeholder="00000-000">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-9">
                    <label class="form-label">Logradouro (Rua / Avenida)</label>
                    <input type="text" name="logradouro" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Número</label>
                    <input type="text" name="numero" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-9">
                    <label class="form-label">Cidade</label>
                    <input type="text" name="cidade" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Estado (UF)</label>
                    <select name="estado" class="form-select" required>
                        <option value="">Selecione...</option>
                        <?php
                        $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS','MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC','SP','SE','TO'];
                        foreach ($ufs as $uf) {
                            echo "<option value='$uf'>$uf</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Endereço</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>