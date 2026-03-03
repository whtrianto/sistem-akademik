<?php
$page_title = 'Tambah Mata Pelajaran';
require_once '../config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($conn->real_escape_string($_POST['nama_matpel']));
    if (empty($nama)) {
        $error = 'Nama mata pelajaran wajib diisi!';
    } else {
        $conn->query("INSERT INTO mata_pelajaran (Nama_Matpel) VALUES ('$nama')");
        header("Location: index.php?msg=created");
        exit;
    }
}

require_once '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1>➕ Tambah Mata Pelajaran</h1>
        <p>Masukkan data mata pelajaran baru</p>
    </div>
    <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger">❌ <?= $error ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header"><h3>📝 Form Mata Pelajaran</h3></div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="nama_matpel">Nama Mata Pelajaran</label>
                <input type="text" id="nama_matpel" name="nama_matpel" class="form-control" required maxlength="50"
                       value="<?= isset($_POST['nama_matpel']) ? htmlspecialchars($_POST['nama_matpel']) : '' ?>"
                       placeholder="Contoh: Matematika">
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
