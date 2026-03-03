<?php
$page_title = 'Edit Peserta Ujian';
require_once '../config/database.php';

$id = (int)($_GET['id'] ?? 0);
$peserta = $conn->query("
    SELECT p.*, s.Nama, u.NAMA_UJIAN
    FROM peserta p
    JOIN siswa s ON p.NIS = s.NIS
    JOIN ujian u ON p.ID_UJIAN = u.ID_UJIAN
    WHERE p.ID_PESERTA = $id
")->fetch_assoc();

if (!$peserta) {
    header("Location: index.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nilai = $_POST['nilai'] !== '' ? (float)$_POST['nilai'] : null;
    $status_manual = $_POST['status'] ?? '';

    if ($nilai !== null && $status_manual === '') {
        // Auto determine
        $status = $nilai >= 65 ? 'Lulus' : 'Tidak Lulus';
    } elseif ($status_manual !== '') {
        $status = $status_manual;
    } else {
        $status = null;
    }

    if ($nilai !== null) {
        $status_sql = $status ? "'$status'" : "NULL";
        $conn->query("UPDATE peserta SET NILAI = $nilai, STATUS = $status_sql WHERE ID_PESERTA = $id");
    } else {
        $status_sql = $status ? "'$status'" : "NULL";
        $conn->query("UPDATE peserta SET NILAI = NULL, STATUS = $status_sql WHERE ID_PESERTA = $id");
    }

    header("Location: index.php?msg=updated");
    exit;
}

require_once '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1>✏️ Edit Peserta Ujian</h1>
        <p>Perbarui nilai &amp; status kelulusan</p>
    </div>
    <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger">❌ <?= $error ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header"><h3>📝 Form Edit Peserta</h3></div>
    <div class="card-body">
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Ujian</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($peserta['NAMA_UJIAN']) ?>" disabled>
                </div>
                <div class="form-group">
                    <label>Siswa</label>
                    <input type="text" class="form-control" value="<?= htmlspecialchars($peserta['Nama']) ?> (<?= $peserta['NIS'] ?>)" disabled>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="nilai">Nilai (0-100)</label>
                    <input type="number" id="nilai" name="nilai" class="form-control"
                           min="0" max="100" step="0.01"
                           value="<?= $peserta['NILAI'] !== null ? $peserta['NILAI'] : '' ?>">
                </div>
                <div class="form-group">
                    <label for="status">Status Kelulusan (kosongkan untuk otomatis)</label>
                    <select id="status" name="status" class="form-control">
                        <option value="">-- Otomatis (berdasarkan KKM) --</option>
                        <option value="Lulus" <?= $peserta['STATUS'] === 'Lulus' ? 'selected' : '' ?>>Lulus</option>
                        <option value="Tidak Lulus" <?= $peserta['STATUS'] === 'Tidak Lulus' ? 'selected' : '' ?>>Tidak Lulus</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
