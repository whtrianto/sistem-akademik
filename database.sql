-- ============================================
-- Database: akademik_db
-- Sistem Informasi Akademik Sederhana
-- ============================================

CREATE DATABASE IF NOT EXISTS akademik_db;
USE akademik_db;

-- Tabel SISWA
CREATE TABLE IF NOT EXISTS siswa (
    NIS VARCHAR(20) PRIMARY KEY,
    Nama VARCHAR(50) NOT NULL,
    Alamat VARCHAR(100)
) ENGINE=InnoDB;

-- Tabel MATA_PELAJARAN
CREATE TABLE IF NOT EXISTS mata_pelajaran (
    ID_MATPEL INT AUTO_INCREMENT PRIMARY KEY,
    Nama_Matpel VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- Tabel UJIAN
CREATE TABLE IF NOT EXISTS ujian (
    ID_UJIAN INT AUTO_INCREMENT PRIMARY KEY,
    NAMA_UJIAN VARCHAR(50) NOT NULL,
    ID_MATPEL INT NOT NULL,
    TANGGAL DATETIME NOT NULL,
    FOREIGN KEY (ID_MATPEL) REFERENCES mata_pelajaran(ID_MATPEL)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabel PESERTA (dimodifikasi: tambah NILAI dan STATUS untuk fitur kelulusan)
CREATE TABLE IF NOT EXISTS peserta (
    ID_PESERTA INT AUTO_INCREMENT PRIMARY KEY,
    ID_UJIAN INT NOT NULL,
    NIS VARCHAR(20) NOT NULL,
    NILAI DECIMAL(5,2) DEFAULT NULL,
    STATUS ENUM('Lulus','Tidak Lulus') DEFAULT NULL,
    FOREIGN KEY (ID_UJIAN) REFERENCES ujian(ID_UJIAN)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (NIS) REFERENCES siswa(NIS)
        ON DELETE CASCADE ON UPDATE CASCADE,
    UNIQUE KEY unique_peserta (ID_UJIAN, NIS)
) ENGINE=InnoDB;

-- ============================================
-- Data Sample
-- ============================================

INSERT INTO siswa (NIS, Nama, Alamat) VALUES
('2024001', 'Ahmad Fauzi', 'Jl. Merdeka No. 10, Jakarta'),
('2024002', 'Siti Nurhaliza', 'Jl. Sudirman No. 25, Bandung'),
('2024003', 'Budi Santoso', 'Jl. Diponegoro No. 5, Surabaya'),
('2024004', 'Dewi Lestari', 'Jl. Gatot Subroto No. 8, Yogyakarta'),
('2024005', 'Rizky Pratama', 'Jl. Ahmad Yani No. 15, Semarang');

INSERT INTO mata_pelajaran (Nama_Matpel) VALUES
('Matematika'),
('Bahasa Indonesia'),
('Bahasa Inggris'),
('Fisika'),
('Kimia');

INSERT INTO ujian (NAMA_UJIAN, ID_MATPEL, TANGGAL) VALUES
('UTS Matematika', 1, '2026-03-10 08:00:00'),
('UTS Bahasa Indonesia', 2, '2026-03-11 08:00:00'),
('UTS Bahasa Inggris', 3, '2026-03-12 08:00:00'),
('UAS Fisika', 4, '2026-03-15 08:00:00'),
('UAS Kimia', 5, '2026-03-16 08:00:00');

INSERT INTO peserta (ID_UJIAN, NIS, NILAI, STATUS) VALUES
(1, '2024001', 85.00, 'Lulus'),
(1, '2024002', 60.00, 'Tidak Lulus'),
(1, '2024003', 78.00, 'Lulus'),
(1, '2024004', 92.00, 'Lulus'),
(1, '2024005', 55.00, 'Tidak Lulus'),
(2, '2024001', 90.00, 'Lulus'),
(2, '2024002', 75.00, 'Lulus'),
(2, '2024003', 65.00, 'Lulus'),
(2, '2024004', 88.00, 'Lulus'),
(2, '2024005', 70.00, 'Lulus'),
(3, '2024001', 72.00, 'Lulus'),
(3, '2024002', 58.00, 'Tidak Lulus'),
(3, '2024003', 80.00, 'Lulus'),
(4, '2024001', 68.00, 'Lulus'),
(4, '2024003', 50.00, 'Tidak Lulus'),
(4, '2024004', 95.00, 'Lulus'),
(5, '2024002', 45.00, 'Tidak Lulus'),
(5, '2024005', 82.00, 'Lulus');
