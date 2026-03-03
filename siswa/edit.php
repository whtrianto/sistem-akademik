<?php
$page_title = 'Edit Siswa';
require_once '../config/database.php';

$nis = $conn->real_escape_string($_GET['nis'] ?? '');
$siswa = $conn->query("SELECT * FROM siswa WHERE NIS = '$nis'")->fetch_assoc();

if (!$siswa) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($conn->real_escape_string($_POST['nama']));
    $alamat = trim($conn->real_escape_string($_POST['alamat']));

    if (empty($nama)) {
        $error = 'Nama wajib diisi!';
    } else {
        $conn->query("UPDATE siswa SET Nama = '$nama', Alamat = '$alamat' WHERE NIS = '$nis'");
        header("Location: index.php?msg=updated");
        exit;
    }
}

require_once '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1>✏️ Edit Siswa</h1>
        <p>Perbarui data siswa</p>
    </div>
    <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger">❌ <?= $error ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3>📝 Form Edit Siswa</h3>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="text" id="nis" class="form-control" value="<?= htmlspecialchars($siswa['NIS']) ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control" required maxlength="50"
                           value="<?= htmlspecialchars($siswa['Nama']) ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" class="form-control" maxlength="100"><?= htmlspecialchars($siswa['Alamat']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
