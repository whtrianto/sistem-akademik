<?php
$page_title = 'Data Ujian';
require_once '../config/database.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM ujian WHERE ID_UJIAN = $id");
    header("Location: index.php?msg=deleted");
    exit;
}

require_once '../includes/header.php';

$result = $conn->query("
    SELECT u.*, m.Nama_Matpel,
           (SELECT COUNT(*) FROM peserta p WHERE p.ID_UJIAN = u.ID_UJIAN) as jumlah_peserta
    FROM ujian u
    LEFT JOIN mata_pelajaran m ON u.ID_MATPEL = m.ID_MATPEL
    ORDER BY u.TANGGAL DESC
");
?>

<div class="page-header">
    <div>
        <h1>📝 Data Ujian</h1>
        <p>Kelola data ujian</p>
    </div>
    <a href="create.php" class="btn btn-primary">+ Tambah Ujian</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <?php
    $msgs = [
        'created' => ['success', '✅ Ujian berhasil ditambahkan!'],
        'updated' => ['success', '✅ Ujian berhasil diperbarui!'],
        'deleted' => ['danger', '🗑️ Ujian berhasil dihapus!'],
    ];
    $m = $msgs[$_GET['msg']] ?? null;
    ?>
    <?php if ($m): ?>
        <div class="alert alert-<?= $m[0] ?>"><?= $m[1] ?></div>
    <?php endif; ?>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3>📋 Daftar Ujian</h3>
        <span class="badge badge-info"><?= $result->num_rows ?> ujian</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ujian</th>
                        <th>Mata Pelajaran</th>
                        <th>Tanggal</th>
                        <th>Peserta</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($row['NAMA_UJIAN']) ?></strong></td>
                                <td><span class="badge badge-info"><?= htmlspecialchars($row['Nama_Matpel']) ?></span></td>
                                <td><?= date('d M Y, H:i', strtotime($row['TANGGAL'])) ?></td>
                                <td><span class="badge badge-warning"><?= $row['jumlah_peserta'] ?></span></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="edit.php?id=<?= $row['ID_UJIAN'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                                        <button onclick="confirmDelete('index.php?delete=<?= $row['ID_UJIAN'] ?>', '<?= htmlspecialchars($row['NAMA_UJIAN']) ?>')" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">📝</div>
                                    <h4>Belum ada data ujian</h4>
                                    <p>Klik "Tambah Ujian" untuk memulai</p>
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
