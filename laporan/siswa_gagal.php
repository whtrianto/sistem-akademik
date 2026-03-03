<?php
// Laporan 3d: Menampilkan siswa yang tidak lulus dan gagal pada Mata pelajaran apa
$page_title = 'Siswa Tidak Lulus';
require_once '../config/database.php';
require_once '../includes/header.php';

$result = $conn->query("
    SELECT s.NIS, s.Nama, s.Alamat,
           u.NAMA_UJIAN, m.Nama_Matpel, p.NILAI, u.TANGGAL
    FROM peserta p
    JOIN siswa s ON p.NIS = s.NIS
    JOIN ujian u ON p.ID_UJIAN = u.ID_UJIAN
    JOIN mata_pelajaran m ON u.ID_MATPEL = m.ID_MATPEL
    WHERE p.STATUS = 'Tidak Lulus'
    ORDER BY s.Nama ASC, m.Nama_Matpel ASC
");

// Group by student
$siswa_gagal = [];
while ($row = $result->fetch_assoc()) {
    $nis = $row['NIS'];
    if (!isset($siswa_gagal[$nis])) {
        $siswa_gagal[$nis] = [
            'NIS' => $row['NIS'],
            'Nama' => $row['Nama'],
            'Alamat' => $row['Alamat'],
            'matpel_gagal' => []
        ];
    }
    $siswa_gagal[$nis]['matpel_gagal'][] = [
        'ujian' => $row['NAMA_UJIAN'],
        'matpel' => $row['Nama_Matpel'],
        'nilai' => $row['NILAI'],
        'tanggal' => $row['TANGGAL']
    ];
}

$total_gagal = count($siswa_gagal);
?>

<div class="page-header">
    <div>
        <h1>⚠️ Siswa Tidak Lulus</h1>
        <p>Laporan 3d - Detail siswa yang tidak lulus dan mata pelajaran yang gagal</p>
    </div>
</div>

<!-- Summary -->
<div class="dashboard-grid" style="grid-template-columns: repeat(2, 1fr);">
    <div class="stat-card card-warning">
        <div class="card-icon">⚠️</div>
        <div class="card-value"><?= $total_gagal ?></div>
        <div class="card-label">Siswa Tidak Lulus</div>
    </div>
    <div class="stat-card card-secondary">
        <div class="card-icon">📚</div>
        <div class="card-value"><?= $result->num_rows ?></div>
        <div class="card-label">Total Mata Pelajaran Gagal</div>
    </div>
</div>

<?php if ($total_gagal > 0): ?>
    <?php foreach ($siswa_gagal as $siswa): ?>
        <div class="card">
            <div class="card-header">
                <h3>👤 <?= htmlspecialchars($siswa['Nama']) ?> <span style="font-weight:400;color:var(--gray);font-size:13px;">(<?= htmlspecialchars($siswa['NIS']) ?>)</span></h3>
                <span class="badge badge-danger"><?= count($siswa['matpel_gagal']) ?> matpel gagal</span>
            </div>
            <div class="card-body">
                <p style="color:var(--gray);margin-bottom:16px;">📍 <?= htmlspecialchars($siswa['Alamat']) ?></p>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Nama Ujian</th>
                                <th>Mata Pelajaran</th>
                                <th>Tanggal</th>
                                <th>Nilai</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($siswa['matpel_gagal'] as $mg): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($mg['ujian']) ?></strong></td>
                                    <td><span class="badge badge-info"><?= htmlspecialchars($mg['matpel']) ?></span></td>
                                    <td><?= date('d M Y, H:i', strtotime($mg['tanggal'])) ?></td>
                                    <td>
                                        <div class="nilai-bar">
                                            <span style="color:var(--danger);font-weight:700;"><?= number_format($mg['nilai'], 1) ?></span>
                                            <div class="bar"><div class="fill low" style="width:<?= $mg['nilai'] ?>%"></div></div>
                                        </div>
                                    </td>
                                    <td><span class="badge badge-danger">❌ Tidak Lulus</span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="card">
        <div class="card-body">
            <div class="empty-state">
                <div class="empty-icon">🎉</div>
                <h4>Semua siswa lulus!</h4>
                <p>Tidak ada siswa yang tidak lulus pada ujian manapun</p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
