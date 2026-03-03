<?php
$page_title = 'Edit Ujian';
require_once '../config/database.php';

$id = (int)($_GET['id'] ?? 0);
$ujian = $conn->query("SELECT * FROM ujian WHERE ID_UJIAN = $id")->fetch_assoc();

if (!$ujian) {
    header("Location: index.php");
    exit;
}

$matpel_list = $conn->query("SELECT * FROM mata_pelajaran ORDER BY Nama_Matpel ASC");

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($conn->real_escape_string($_POST['nama_ujian']));
    $id_matpel = (int)$_POST['id_matpel'];
    $tanggal = $conn->real_escape_string($_POST['tanggal']);

    if (empty($nama) || $id_matpel <= 0 || empty($tanggal)) {
        $error = 'Semua field wajib diisi!';
    } else {
        $conn->query("UPDATE ujian SET NAMA_UJIAN = '$nama', ID_MATPEL = $id_matpel, TANGGAL = '$tanggal' WHERE ID_UJIAN = $id");
        header("Location: index.php?msg=updated");
        exit;
    }
}

require_once '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1>✏️ Edit Ujian</h1>
        <p>Perbarui data ujian</p>
    </div>
    <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger">❌ <?= $error ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header"><h3>📝 Form Edit Ujian</h3></div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group">
                <label for="nama_ujian">Nama Ujian</label>
                <input type="text" id="nama_ujian" name="nama_ujian" class="form-control" required maxlength="50"
                       value="<?= htmlspecialchars($ujian['NAMA_UJIAN']) ?>">
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="id_matpel">Mata Pelajaran</label>
                    <select id="id_matpel" name="id_matpel" class="form-control" required>
                        <option value="">-- Pilih Mata Pelajaran --</option>
                        <?php while ($mp = $matpel_list->fetch_assoc()): ?>
                            <option value="<?= $mp['ID_MATPEL'] ?>"
                                <?= ($ujian['ID_MATPEL'] == $mp['ID_MATPEL']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($mp['Nama_Matpel']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tanggal">Tanggal & Waktu</label>
                    <input type="datetime-local" id="tanggal" name="tanggal" class="form-control" required
                           value="<?= date('Y-m-d\TH:i', strtotime($ujian['TANGGAL'])) ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
