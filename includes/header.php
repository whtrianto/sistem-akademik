<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Informasi Akademik - Penentuan Kelulusan Siswa">
    <title><?= isset($page_title) ? $page_title . ' - ' : '' ?>SIA Akademik</title>
    <link rel="stylesheet" href="/soal/assets/css/style.css">
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-header">
        <h2><span class="icon">🎓</span> SIA Akademik</h2>
        <p>Sistem Informasi Akademik</p>
    </div>
    <nav class="sidebar-menu">
        <div class="menu-label">Menu Utama</div>
        <a href="/soal/index.php" class="<?= ($current_page == 'index' && $current_dir == 'soal') ? 'active' : '' ?>">
            <span class="menu-icon">📊</span> Dashboard
        </a>

        <div class="menu-label">Master Data</div>
        <a href="/soal/siswa/index.php" class="<?= $current_dir == 'siswa' ? 'active' : '' ?>">
            <span class="menu-icon">👨‍🎓</span> Data Siswa
        </a>
        <a href="/soal/matpel/index.php" class="<?= $current_dir == 'matpel' ? 'active' : '' ?>">
            <span class="menu-icon">📚</span> Mata Pelajaran
        </a>
        <a href="/soal/ujian/index.php" class="<?= $current_dir == 'ujian' ? 'active' : '' ?>">
            <span class="menu-icon">📝</span> Data Ujian
        </a>
        <a href="/soal/peserta/index.php" class="<?= $current_dir == 'peserta' ? 'active' : '' ?>">
            <span class="menu-icon">✍️</span> Peserta Ujian
        </a>

        <div class="menu-label">Laporan & Kelulusan</div>
        <a href="/soal/laporan/ujian_tanggal.php" class="<?= $current_page == 'ujian_tanggal' ? 'active' : '' ?>">
            <span class="menu-icon">📅</span> Ujian per Tanggal
        </a>
        <a href="/soal/laporan/rekap_ujian.php" class="<?= $current_page == 'rekap_ujian' ? 'active' : '' ?>">
            <span class="menu-icon">📋</span> Rekap Ujian
        </a>
        <a href="/soal/laporan/siswa_lulus.php" class="<?= $current_page == 'siswa_lulus' ? 'active' : '' ?>">
            <span class="menu-icon">🏆</span> Siswa Lulus
        </a>
        <a href="/soal/laporan/siswa_gagal.php" class="<?= $current_page == 'siswa_gagal' ? 'active' : '' ?>">
            <span class="menu-icon">⚠️</span> Siswa Tidak Lulus
        </a>
    </nav>
</aside>

<!-- Main Content -->
<main class="main-content">
