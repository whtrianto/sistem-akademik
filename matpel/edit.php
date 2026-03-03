<?php
$page_title = 'Edit Mata Pelajaran';
require_once '../config/database.php';

$id = (int)($_GET['id'] ?? 0);
$matpel = $conn->query("SELECT * FROM mata_pelajaran WHERE ID_MATPEL = $id")->fetch_assoc();

if (!$matpel) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($conn->real_escape_string($_POST['nama_matpel']));
    if (empty($nama)) {
        $error = 'Nama mata pelajaran wajib diisi!';
    } else {
        $conn->query("UPDATE mata_pelajaran SET Nama_Matpel = '$nama' WHERE ID_MATPEL = $id");
        header("Location: index.php?msg=updated");
        exit;
    }
}

require_once '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1>✏️ Edit Mata Pelajaran</h1>
        <p>Perbarui data mata pelajaran</p>
    </div>
    <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger">❌ <?= $error ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header"><h3>📝 Form Edit Mata Pelajaran</h3></div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="nama_matpel">Nama Mata Pelajaran</label>
                <input type="text" id="nama_matpel" name="nama_matpel" class="form-control" required maxlength="50"
                       value="<?= htmlspecialchars($matpel['Nama_Matpel']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
