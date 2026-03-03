<?php
$page_title = 'Tambah Ujian';
require_once '../config/database.php';

$matpel_list = $conn->query("SELECT * FROM mata_pelajaran ORDER BY Nama_Matpel ASC");

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($conn->real_escape_string($_POST['nama_ujian']));
    $id_matpel = (int)$_POST['id_matpel'];
    $tanggal = $conn->real_escape_string($_POST['tanggal']);

    if (empty($nama) || $id_matpel <= 0 || empty($tanggal)) {
        $error = 'Semua field wajib diisi!';
    } else {
        $conn->query("INSERT INTO ujian (NAMA_UJIAN, ID_MATPEL, TANGGAL) VALUES ('$nama', $id_matpel, '$tanggal')");
        header("Location: index.php?msg=created");
        exit;
    }
}

require_once '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1>➕ Tambah Ujian</h1>
        <p>Buat ujian baru</p>
    </div>
    <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger">❌ <?= $error ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header"><h3>📝 Form Ujian</h3></div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="nama_ujian">Nama Ujian</label>
                <input type="text" id="nama_ujian" name="nama_ujian" class="form-control" required maxlength="50"
                       value="<?= isset($_POST['nama_ujian']) ? htmlspecialchars($_POST['nama_ujian']) : '' ?>"
                       placeholder="Contoh: UTS Matematika">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="id_matpel">Mata Pelajaran</label>
                    <select id="id_matpel" name="id_matpel" class="form-control" required>
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        <?php while ($mp = $matpel_list->fetch_assoc()): ?>
                            <option value="<?= $mp['ID_MATPEL'] ?>"
                                <?= (isset($_POST['id_matpel']) && $_POST['id_matpel'] == $mp['ID_MATPEL']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($mp['Nama_Matpel']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal & Waktu</label>
                    <input type="datetime-local" id="tanggal" name="tanggal" class="form-control" required
                           value="<?= isset($_POST['tanggal']) ? htmlspecialchars($_POST['tanggal']) : '' ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
