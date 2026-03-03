<?php
$page_title = 'Dashboard';
require_once 'config/database.php';
require_once 'includes/header.php';

// Statistik
$total_siswa = $conn->query("SELECT COUNT(*) as total FROM siswa")->fetch_assoc()['total'];
$total_matpel = $conn->query("SELECT COUNT(*) as total FROM mata_pelajaran")->fetch_assoc()['total'];
$total_ujian = $conn->query("SELECT COUNT(*) as total FROM ujian")->fetch_assoc()['total'];
$total_peserta = $conn->query("SELECT COUNT(DISTINCT NIS) as total FROM peserta")->fetch_assoc()['total'];

// Siswa lulus semua ujian
$q_lulus = $conn->query("
    SELECT COUNT(*) as total FROM (
        SELECT p.NIS
        FROM peserta p
        GROUP BY p.NIS
        HAVING SUM(CASE WHEN p.STATUS = 'Tidak Lulus' THEN 1 ELSE 0 END) = 0
            AND COUNT(*) > 0
    ) as lulus
");
$total_lulus = $q_lulus->fetch_assoc()['total'];

// Siswa tidak lulus
$q_gagal = $conn->query("SELECT COUNT(DISTINCT NIS) as total FROM peserta WHERE STATUS = 'Tidak Lulus'");
$total_gagal = $q_gagal->fetch_assoc()['total'];

// Ujian terbaru
$ujian_terbaru = $conn->query("
    SELECT u.NAMA_UJIAN, m.Nama_Matpel, u.TANGGAL,
           COUNT(p.NIS) as jumlah_peserta
    FROM ujian u
    LEFT JOIN mata_pelajaran m ON u.ID_MATPEL = m.ID_MATPEL
    LEFT JOIN peserta p ON u.ID_UJIAN = p.ID_UJIAN
    GROUP BY u.ID_UJIAN
    ORDER BY u.TANGGAL DESC
    LIMIT 5
");
?>

<div class="page-header">
    <div>
        <h1>📊 Dashboard</h1>
        <p>Selamat datang di Sistem Informasi Akademik</p>
    </div>
</div>

<!-- Statistik -->
<div class="dashboard-grid">
    <div class="stat-card card-primary">
        <div class="card-icon">👨‍🎓</div>
        <div class="card-value"><?= $total_siswa ?></div>
        <div class="card-label">Total Siswa</div>
    </div>
    <div class="stat-card card-secondary">
        <div class="card-icon">📚</div>
        <div class="card-value"><?= $total_matpel ?></div>
        <div class="card-label">Mata Pelajaran</div>
    </div>
    <div class="stat-card card-warning">
        <div class="card-icon">📝</div>
        <div class="card-value"><?= $total_ujian ?></div>
        <div class="card-label">Total Ujian</div>
    </div>
    <div class="stat-card card-success">
        <div class="card-icon">🏆</div>
        <div class="card-value"><?= $total_lulus ?></div>
        <div class="card-label">Siswa Yang Lulus</div>
    </div>
</div>

<div class="dashboard-grid" style="grid-template-columns: repeat(2, 1fr);">
    <!-- Siswa Ikut Ujian -->
    <div class="stat-card card-secondary">
        <div class="card-icon">✍️</div>
        <div class="card-value"><?= $total_peserta ?></div>
        <div class="card-label">Siswa Ikut Ujian</div>
    </div>
    <!-- Siswa Tidak Lulus -->
    <div class="stat-card card-warning">
        <div class="card-icon">⚠️</div>
        <div class="card-value"><?= $total_gagal ?></div>
        <div class="card-label">Siswa Yang Ada Matkulnya Gagal</div>
    </div>
</div>

<!-- Ujian Terbaru -->
<div class="card">
    <div class="card-header">
        <h3>📝 Ujian Terbaru</h3>
        <a href="/soal/ujian/index.php" class="btn btn-sm btn-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Ujian</th>
                        <th>Mata Pelajaran</th>
                        <th>Tanggal</th>
                        <th>Jumlah Peserta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($ujian_terbaru->num_rows > 0): ?>
                        <?php while ($row = $ujian_terbaru->fetch_assoc()): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['NAMA_UJIAN']) ?></strong></td>
                                <td><span class="badge badge-info"><?= htmlspecialchars($row['Nama_Matpel']) ?></span></td>
                                <td><?= date('d M Y, H:i', strtotime($row['TANGGAL'])) ?></td>
                                <td><span class="badge badge-warning"><?= $row['jumlah_peserta'] ?> peserta</span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">📝</div>
                                    <h4>Belum ada data ujian</h4>
                                    <p>Silakan tambahkan ujian terlebih dahulu</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
