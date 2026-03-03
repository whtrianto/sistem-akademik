<?php
$page_title = 'Peserta Ujian';
require_once '../config/database.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM peserta WHERE ID_PESERTA = $id");
    header("Location: index.php?msg=deleted");
    exit;
}

// Handle tentukan kelulusan otomatis (KKM = 65)
if (isset($_GET['action']) && $_GET['action'] === 'tentukan_kelulusan') {
    $kkm = 65;
    $conn->query("UPDATE peserta SET STATUS = CASE WHEN NILAI >= $kkm THEN 'Lulus' ELSE 'Tidak Lulus' END WHERE NILAI IS NOT NULL");
    header("Location: index.php?msg=kelulusan");
    exit;
}

require_once '../includes/header.php';

$result = $conn->query("
    SELECT p.*, s.Nama, u.NAMA_UJIAN, m.Nama_Matpel
    FROM peserta p
    JOIN siswa s ON p.NIS = s.NIS
    JOIN ujian u ON p.ID_UJIAN = u.ID_UJIAN
    JOIN mata_pelajaran m ON u.ID_MATPEL = m.ID_MATPEL
    ORDER BY u.NAMA_UJIAN ASC, s.Nama ASC
");
?>

<div class="page-header">
    <div>
        <h1>✍️ Peserta Ujian</h1>
        <p>Kelola peserta ujian &amp; penentuan kelulusan</p>
    </div>
    <div class="btn-group">
        <a href="index.php?action=tentukan_kelulusan" class="btn btn-success" onclick="return confirm('Tentukan kelulusan otomatis (KKM=65)?')">🏆 Tentukan Kelulusan (KKM=65)</a>
        <a href="create.php" class="btn btn-primary">+ Tambah Peserta</a>
    </div>
</div>

<?php if (isset($_GET['msg'])): ?>
    <?php
    $msgs = [
        'created' => ['success', '✅ Peserta berhasil ditambahkan!'],
        'updated' => ['success', '✅ Peserta berhasil diperbarui!'],
        'deleted' => ['danger', '🗑️ Peserta berhasil dihapus!'],
        'kelulusan' => ['success', '🏆 Status kelulusan berhasil ditentukan berdasarkan KKM=65!'],
    ];
    $m = $msgs[$_GET['msg']] ?? null;
    ?>
    <?php if ($m): ?>
        <div class="alert alert-<?= $m[0] ?>"><?= $m[1] ?></div>
    <?php endif; ?>
<?php endif; ?>

<div class="alert alert-info">
    ℹ️ <strong>Penentuan Kelulusan:</strong> Klik tombol "Tentukan Kelulusan" untuk otomatis menentukan status kelulusan berdasarkan KKM (Kriteria Ketuntasan Minimal) = 65. Atau edit masing-masing peserta untuk menentukan secara manual.
</div>

<div class="card">
    <div class="card-header">
        <h3>📋 Daftar Peserta Ujian</h3>
        <span class="badge badge-info"><?= $result->num_rows ?> peserta</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>NIS</th>
                        <th>Ujian</th>
                        <th>Mata Pelajaran</th>
                        <th>Nilai</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()):
                            $nilai = $row['NILAI'];
                            $fill_class = 'low';
                            if ($nilai >= 75) $fill_class = 'high';
                            elseif ($nilai >= 65) $fill_class = 'medium';
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($row['Nama']) ?></strong></td>
                                <td><?= htmlspecialchars($row['NIS']) ?></td>
                                <td><?= htmlspecialchars($row['NAMA_UJIAN']) ?></td>
                                <td><span class="badge badge-info"><?= htmlspecialchars($row['Nama_Matpel']) ?></span></td>
                                <td>
                                    <?php if ($nilai !== null): ?>
                                        <div class="nilai-bar">
                                            <span><?= number_format($nilai, 1) ?></span>
                                            <div class="bar"><div class="fill <?= $fill_class ?>" style="width:<?= $nilai ?>%"></div></div>
                                        </div>
                                    <?php else: ?>
                                        <span style="color:var(--gray)">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['STATUS'] === 'Lulus'): ?>
                                        <span class="badge badge-success">✅ Lulus</span>
                                    <?php elseif ($row['STATUS'] === 'Tidak Lulus'): ?>
                                        <span class="badge badge-danger">❌ Tidak Lulus</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">⏳ Belum Ditentukan</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="edit.php?id=<?= $row['ID_PESERTA'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                                        <button onclick="confirmDelete('index.php?delete=<?= $row['ID_PESERTA'] ?>', '<?= htmlspecialchars($row['Nama']) ?>')" class="btn btn-sm btn-danger">🗑️</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">
                                <div class="empty-state">
                                    <div class="empty-icon">✍️</div>
                                    <h4>Belum ada peserta ujian</h4>
                                    <p>Klik "Tambah Peserta" untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
