<?php
// Laporan 3a: Menampilkan Ujian berdasarkan TANGGAL
$page_title = 'Ujian per Tanggal';
require_once '../config/database.php';
require_once '../includes/header.php';

$tanggal_filter = $_GET['tanggal'] ?? '';

$where = '';
if (!empty($tanggal_filter)) {
    $tf = $conn->real_escape_string($tanggal_filter);
    $where = "WHERE DATE(u.TANGGAL) = '$tf'";
}

$result = $conn->query("
    SELECT u.ID_UJIAN, u.NAMA_UJIAN, m.Nama_Matpel, u.TANGGAL,
           COUNT(p.NIS) as jumlah_peserta
    FROM ujian u
    LEFT JOIN mata_pelajaran m ON u.ID_MATPEL = m.ID_MATPEL
    LEFT JOIN peserta p ON u.ID_UJIAN = p.ID_UJIAN
    $where
    GROUP BY u.ID_UJIAN
    ORDER BY u.TANGGAL DESC
");

// Get distinct dates for filter
$dates = $conn->query("SELECT DISTINCT DATE(TANGGAL) as tgl FROM ujian ORDER BY tgl DESC");
?>

<div class="page-header">
    <div>
        <h1>📅 Ujian Berdasarkan Tanggal</h1>
        <p>Laporan 3a - Filter dan lihat ujian berdasarkan tanggal</p>
    </div>
</div>

<!-- Filter -->
<div class="filter-bar">
    <div class="form-group">
        <label for="tanggal">Filter Tanggal</label>
        <input type="date" id="tanggal" name="tanggal" class="form-control"
               value="<?= htmlspecialchars($tanggal_filter) ?>"
               onchange="window.location.href='ujian_tanggal.php?tanggal=' + this.value">
    </div>
    <div class="form-group" style="flex:0;">
        <?php if (!empty($tanggal_filter)): ?>
            <a href="ujian_tanggal.php" class="btn btn-secondary">🔄 Reset</a>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($tanggal_filter)): ?>
    <div class="alert alert-info">📅 Menampilkan ujian pada tanggal: <strong><?= date('d M Y', strtotime($tanggal_filter)) ?></strong></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3>📋 Daftar Ujian</h3>
        <span class="badge badge-info"><?= $result->num_rows ?> ujian ditemukan</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ujian</th>
                        <th>Mata Pelajaran</th>
                        <th>Tanggal & Waktu</th>
                        <th>Jumlah Peserta</th>
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
                                <td><span class="badge badge-warning"><?= $row['jumlah_peserta'] ?> peserta</span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">📅</div>
                                    <h4>Tidak ada ujian ditemukan</h4>
                                    <p>Coba pilih tanggal lain</p>
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
