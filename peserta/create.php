<?php
$page_title = 'Tambah Peserta Ujian';
require_once '../config/database.php';

$ujian_list = $conn->query("SELECT u.*, m.Nama_Matpel FROM ujian u JOIN mata_pelajaran m ON u.ID_MATPEL = m.ID_MATPEL ORDER BY u.TANGGAL DESC");
$siswa_list = $conn->query("SELECT * FROM siswa ORDER BY Nama ASC");

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_ujian = (int)$_POST['id_ujian'];
    $nis = $conn->real_escape_string($_POST['nis']);
    $nilai = $_POST['nilai'] !== '' ? (float)$_POST['nilai'] : null;

    if ($id_ujian <= 0 || empty($nis)) {
        $error = 'Ujian dan Siswa wajib dipilih!';
    } else {
        // Check duplicate
        $check = $conn->query("SELECT * FROM peserta WHERE ID_UJIAN = $id_ujian AND NIS = '$nis'");
        if ($check->num_rows > 0) {
            $error = 'Siswa sudah terdaftar di ujian ini!';
        } else {
            $status = 'NULL';
            if ($nilai !== null) {
                $status = $nilai >= 65 ? "'Lulus'" : "'Tidak Lulus'";
                $conn->query("INSERT INTO peserta (ID_UJIAN, NIS, NILAI, STATUS) VALUES ($id_ujian, '$nis', $nilai, $status)");
            } else {
                $conn->query("INSERT INTO peserta (ID_UJIAN, NIS, NILAI, STATUS) VALUES ($id_ujian, '$nis', NULL, NULL)");
            }
            header("Location: index.php?msg=created");
            exit;
        }
    }
}

require_once '../includes/header.php';
?>

<div class="page-header">
    <div>
        <h1>➕ Tambah Peserta Ujian</h1>
        <p>Daftarkan siswa ke ujian dan masukkan nilai</p>
    </div>
    <a href="index.php" class="btn btn-secondary">← Kembali</a>
</div>

<?php if ($error): ?>
    <div class="alert alert-danger">❌ <?= $error ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header"><h3>📝 Form Peserta Ujian</h3></div>
    <div class="card-body">
        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label for="id_ujian">Pilih Ujian</label>
                    <select id="id_ujian" name="id_ujian" class="form-control" required>
                        <option value="">-- Pilih Ujian --</option>
                        <?php while ($u = $ujian_list->fetch_assoc()): ?>
                            <option value="<?= $u['ID_UJIAN'] ?>"
                                <?= (isset($_POST['id_ujian']) && $_POST['id_ujian'] == $u['ID_UJIAN']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($u['NAMA_UJIAN']) ?> - <?= htmlspecialchars($u['Nama_Matpel']) ?> (<?= date('d/m/Y', strtotime($u['TANGGAL'])) ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nis">Pilih Siswa</label>
                    <select id="nis" name="nis" class="form-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php while ($s = $siswa_list->fetch_assoc()): ?>
                            <option value="<?= $s['NIS'] ?>"
                                <?= (isset($_POST['nis']) && $_POST['nis'] == $s['NIS']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['Nama']) ?> (<?= $s['NIS'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="nilai">Nilai (0-100, kosongkan jika belum ada)</label>
                <input type="number" id="nilai" name="nilai" class="form-control"
                       min="0" max="100" step="0.01"
                       value="<?= isset($_POST['nilai']) ? htmlspecialchars($_POST['nilai']) : '' ?>"
                       placeholder="Contoh: 85.50">
            </div>
            <div class="alert alert-info">ℹ️ Status kelulusan akan otomatis ditentukan berdasarkan KKM = 65. Nilai ≥ 65 = Lulus, Nilai &lt; 65 = Tidak Lulus.</div>
            <button type="submit" class="btn btn-primary">💾 Simpan</button>
        </form>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
