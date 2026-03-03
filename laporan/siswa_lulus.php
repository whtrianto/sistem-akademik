<?php
// Laporan 3c: Menampilkan Jumlah SISWA yang Lulus dalam semua Ujian
$page_title = 'Siswa Lulus';
require_once '../config/database.php';
require_once '../includes/header.php';

// Siswa yang lulus di SEMUA ujian yang diikutinya
$result = $conn->query("
    SELECT s.NIS, s.Nama, s.Alamat,
           COUNT(p.ID_PESERTA) as total_ujian,
           AVG(p.NILAI) as rata_nilai,
           MIN(p.NILAI) as nilai_terendah,
           MAX(p.NILAI) as nilai_tertinggi
    FROM siswa s
    JOIN peserta p ON s.NIS = p.NIS
    WHERE p.STATUS IS NOT NULL
    GROUP BY s.NIS
    HAVING SUM(CASE WHEN p.STATUS = 'Tidak Lulus' THEN 1 ELSE 0 END) = 0
       AND COUNT(p.ID_PESERTA) > 0
    ORDER BY rata_nilai DESC
");

$total_lulus = $result->num_rows;

// Total siswa yang ikut ujian
$total_peserta = $conn->query("SELECT COUNT(DISTINCT NIS) as c FROM peserta WHERE STATUS IS NOT NULL")->fetch_assoc()['c'];
?>

<div class="page-header">
    <div>
        <h1>🏆 Siswa Lulus Semua Ujian</h1>
        <p>Laporan 3c - Siswa yang LULUS di semua ujian yang diikuti</p>
    </div>
</div>

<!-- Summary -->
<div class="dashboard-grid" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card card-success">
        <div class="card-icon">🏆</div>
        <div class="card-value"><?= $total_lulus ?></div>
        <div class="card-label">Siswa Lulus Semua Ujian</div>
    </div>
    <div class="stat-card card-primary">
        <div class="card-icon">👨‍🎓</div>
        <div class="card-value"><?= $total_peserta ?></div>
        <div class="card-label">Total Peserta Ujian</div>
    </div>
    <div class="stat-card card-warning">
        <div class="card-icon">📊</div>
        <div class="card-value"><?= $total_peserta > 0 ? round(($total_lulus / $total_peserta) * 100) : 0 ?>%</div>
        <div class="card-label">Persentase Kelulusan</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>✅ Daftar Siswa Lulus</h3>
        <span class="badge badge-success"><?= $total_lulus ?> siswa</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Siswa</th>
                        <th>Alamat</th>
                        <th>Jumlah Ujian</th>
                        <th>Rata-rata Nilai</th>
                        <th>Nilai Terendah</th>
                        <th>Nilai Tertinggi</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><strong><?= htmlspecialchars($row['NIS']) ?></strong></td>
                                <td><strong><?= htmlspecialchars($row['Nama']) ?></strong></td>
                                <td><?= htmlspecialchars($row['Alamat']) ?></td>
                                <td style="text-align:center;"><?= $row['total_ujian'] ?></td>
                                <td><strong><?= number_format($row['rata_nilai'], 1) ?></strong></td>
                                <td><?= number_format($row['nilai_terendah'], 1) ?></td>
                                <td><?= number_format($row['nilai_tertinggi'], 1) ?></td>
                                <td><span class="badge badge-success">✅ Lulus Semua</span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-icon">🏆</div>
                                    <h4>Belum ada siswa yang lulus semua ujian</h4>
                                    <p>Pastikan data nilai sudah diinput dan kelulusan sudah ditentukan</p>
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
