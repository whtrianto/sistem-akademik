<?php
// Laporan 3b: Menampilkan NAMA_UJIAN, NAMA_MATPEL, TANGGAL, JUMLAH_PESERTA
$page_title = 'Rekap Ujian';
require_once '../config/database.php';
require_once '../includes/header.php';

$result = $conn->query("
    SELECT u.NAMA_UJIAN, m.Nama_Matpel, u.TANGGAL,
           COUNT(p.NIS) as JUMLAH_PESERTA,
           AVG(p.NILAI) as rata_nilai,
           SUM(CASE WHEN p.STATUS = 'Lulus' THEN 1 ELSE 0 END) as jml_lulus,
           SUM(CASE WHEN p.STATUS = 'Tidak Lulus' THEN 1 ELSE 0 END) as jml_gagal
    FROM ujian u
    LEFT JOIN mata_pelajaran m ON u.ID_MATPEL = m.ID_MATPEL
    LEFT JOIN peserta p ON u.ID_UJIAN = p.ID_UJIAN
    GROUP BY u.ID_UJIAN
    ORDER BY u.TANGGAL DESC
");
?>

<div class="page-header">
    <div>
        <h1>📋 Rekap Ujian</h1>
        <p>Laporan 3b - NAMA_UJIAN, NAMA_MATPEL, TANGGAL, JUMLAH_PESERTA</p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>📊 Rekap Data Ujian</h3>
        <span class="badge badge-info"><?= $result->num_rows ?> ujian</span>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NAMA_UJIAN</th>
                        <th>NAMA_MATPEL</th>
                        <th>TANGGAL</th>
                        <th>JUMLAH_PESERTA</th>
                        <th>Rata-rata Nilai</th>
                        <th>Lulus / Gagal</th>
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
                                <td style="text-align:center;"><span class="badge badge-warning"><?= $row['JUMLAH_PESERTA'] ?></span></td>
                                <td>
                                    <?php if ($row['rata_nilai'] !== null): ?>
                                        <strong><?= number_format($row['rata_nilai'], 1) ?></strong>
                                    <?php else: ?>
                                        <span style="color:var(--gray)">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-success"><?= $row['jml_lulus'] ?? 0 ?> Lulus</span>
                                    <span class="badge badge-danger"><?= $row['jml_gagal'] ?? 0 ?> Gagal</span>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon">📋</div>
                                    <h4>Belum ada data ujian</h4>
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
