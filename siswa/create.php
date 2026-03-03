<?php
$page_title = 'Tambah Siswa';
require_once '../config/database.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nis = trim($conn->real_escape_string($_POST['nis']));
    $nama = trim($conn->real_escape_string($_POST['nama']));
    $alamat = trim($conn->real_escape_string($_POST['alamat']));

    if (empty($nis) || empty($nama)) {
        $error = 'NIS dan Nama wajib diisi!';
    } else {
        $check = $conn->query("SELECT NIS FROM siswa WHERE NIS = '$nis'");
        if ($check->num_rows > 0) {
            $error = 'NIS sudah terdaftar!';
        } else {
            $conn->query("INSERT INTO siswa (NIS, Nama, Alamat) VALUES ('$nis', '$nama', '$alamat')");
            header("Location: index.php?msg=created");
            exit;
        }
    }
}

require_once '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1>➕ Tambah Siswa</h1>
        <p>Masukkan data siswa baru</p>
    </div>
    <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger">❌ <?= $error ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3>📝 Form Siswa</h3>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="nis">NIS (Nomor Induk Siswa)</label>
                    <input type="text" id="nis" name="nis" class="form-control" required maxlength="20"
                           value="<?= isset($_POST['nis']) ? htmlspecialchars($_POST['nis']) : '' ?>"
                           placeholder="Contoh: 2024001">
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" class="form-control" required maxlength="50"
                           value="<?= isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : '' ?>"
                           placeholder="Contoh: Ahmad Fauzi">
                </div>
            </div>
            <div class="form-group">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" class="form-control" maxlength="100"
                          placeholder="Contoh: Jl. Merdeka No. 10, Jakarta"><?= isset($_POST['alamat']) ? htmlspecialchars($_POST['alamat']) : '' ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
