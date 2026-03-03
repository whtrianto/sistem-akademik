<?php
$page_title = 'Mata Pelajaran';
require_once '../config/database.php';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM mata_pelajaran WHERE ID_MATPEL = $id");
    header("Location: index.php?msg=deleted");
    exit;
}

require_once '../includes/header.php';

$result = $conn->query("SELECT * FROM mata_pelajaran ORDER BY ID_MATPEL ASC");
?>

<div class="page-header">
    <div>
        <h1>📚 Mata Pelajaran</h1>
        <p>Kelola data mata pelajaran</p>
    </div>
    <a href="create.php" class="btn btn-primary">+ Tambah Matpel</a>
</div>

<?php if (isset($_GET['msg'])): ?>
    <?php
    $msgs = [
        'created' => ['success', '✅ Mata pelajaran berhasil ditambahkan!'],
        'updated' => ['success', '✅ Mata pelajaran berhasil diperbarui!'],
        'deleted' => ['danger', '🗑️ Mata pelajaran berhasil dihapus!'],
    ];
    $m = $msgs[$_GET['msg']] ?? null;
    ?>
    <?php if ($m): ?>
        <div class="alert alert-<?= $m[0] ?>"><?= $m[1] ?></div>
    <?php endif; ?>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3>📋 Daftar Mata Pelajaran</h3>
        <span class="badge badge-info"><?= $result->num_rows ?> matpel</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Nama Mata Pelajaran</th>
                        <th>Jumlah Ujian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()):
                            $jml = $conn->query("SELECT COUNT(*) as c FROM ujian WHERE ID_MATPEL = {$row['ID_MATPEL']}")->fetch_assoc()['c'];
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= $row['ID_MATPEL'] ?></strong></td>
                                <td><?= htmlspecialchars($row['Nama_Matpel']) ?></td>
                                <td><span class="badge badge-warning"><?= $jml ?> ujian</span></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="edit.php?id=<?= $row['ID_MATPEL'] ?>" class="btn btn-sm btn-warning">✏️ Edit</a>
                                        <button onclick="confirmDelete('index.php?delete=<?= $row['ID_MATPEL'] ?>', '<?= htmlspecialchars($row['Nama_Matpel']) ?>')" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">📚</div>
                                    <h4>Belum ada mata pelajaran</h4>
                                    <p>Klik "Tambah Matpel" untuk memulai</p>
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
