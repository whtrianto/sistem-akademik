<?php
$page_title = 'Data Siswa';
require_once '../config/database.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $nis = $conn->real_escape_string($_GET['delete']);
    $conn->query("DELETE FROM siswa WHERE NIS = '$nis'");
    header("Location: index.php?msg=deleted");
    exit;
}

require_once '../includes/header.php';

// Fetch all siswa
$result = $conn->query("SELECT * FROM siswa ORDER BY NIS ASC");
?>

<div class="page-header">
    <div>
        <h1>👨‍🎓 Data Siswa</h1>
        <p>Kelola data siswa</p>
    </div>
    <a href="create.php" class="btn btn-primary">+ Tambah Siswa</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <?php
    $msgs = [
        'created' => ['success', '✅ Siswa berhasil ditambahkan!'],
        'updated' => ['success', '✅ Siswa berhasil diperbarui!'],
        'deleted' => ['danger', '🗑️ Siswa berhasil dihapus!'],
    ];
    $m = $msgs[$_GET['msg']] ?? null;
    ?>
    <?php if ($m): ?>
        <div class="alert alert-<?= $m[0] ?>"><?= $m[1] ?></div>
    <?php endif; ?>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3>📋 Daftar Siswa</h3>
        <span class="badge badge-info"><?= $result->num_rows ?> siswa</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($row['NIS']) ?></strong></td>
                                <td><?= htmlspecialchars($row['Nama']) ?></td>
                                <td><?= htmlspecialchars($row['Alamat']) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="edit.php?nis=<?= urlencode($row['NIS']) ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                                        <button onclick="confirmDelete('index.php?delete=<?= urlencode($row['NIS']) ?>', '<?= htmlspecialchars($row['Nama']) ?>')" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">👨‍🎓</div>
                                    <h4>Belum ada data siswa</h4>
                                    <p>Klik tombol "Tambah Siswa" untuk memulai</p>
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
