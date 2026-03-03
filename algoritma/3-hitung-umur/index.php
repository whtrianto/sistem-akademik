<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 3 - Hitung Umur</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a0a2e, #2d1b69, #44318d);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 560px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        .badge {
            display: inline-block;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: #fff;
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        h1 {
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .subtitle {
            color: rgba(255, 255, 255, 0.5);
            font-size: 14px;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px;
            font-weight: 500;
            display: block;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 14px 18px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            color: #fff;
            font-size: 16px;
            font-family: 'JetBrains Mono', monospace;
            outline: none;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #f093fb;
            box-shadow: 0 0 0 3px rgba(240, 147, 251, 0.2);
        }

        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        .hint {
            color: rgba(255, 255, 255, 0.35);
            font-size: 12px;
            margin-top: 6px;
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 14px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.5px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(240, 147, 251, 0.4);
        }

        button:active { transform: translateY(0); }

        .result-box {
            margin-top: 28px;
            background: rgba(240, 147, 251, 0.08);
            border: 1px solid rgba(240, 147, 251, 0.25);
            border-radius: 16px;
            padding: 24px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .result-label {
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }

        .age-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .age-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
        }

        .age-number {
            color: #f5a5c8;
            font-family: 'JetBrains Mono', monospace;
            font-size: 32px;
            font-weight: 700;
        }

        .age-unit {
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        .leap-box {
            background: rgba(240, 147, 251, 0.12);
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .leap-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .leap-value {
            color: #f5a5c8;
            font-family: 'JetBrains Mono', monospace;
            font-size: 28px;
            font-weight: 700;
        }

        .leap-years-list {
            margin-top: 12px;
            color: rgba(255, 255, 255, 0.4);
            font-size: 12px;
            font-family: 'JetBrains Mono', monospace;
            line-height: 1.8;
        }

        .error-msg {
            margin-top: 20px;
            padding: 14px 18px;
            background: rgba(245, 87, 108, 0.15);
            border: 1px solid rgba(245, 87, 108, 0.3);
            border-radius: 12px;
            color: #f5576c;
            font-size: 14px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 24px;
            color: rgba(255, 255, 255, 0.4);
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s;
        }

        .back-link:hover { color: #f093fb; }
    </style>
</head>
<body>

<div class="card">
    <span class="badge">Soal 3</span>
    <h1>Hitung Umur</h1>
    <p class="subtitle">Menghitung umur dalam tahun, bulan, hari serta jumlah tahun kabisat yang terlewati.</p>

    <form method="post">
        <label for="inputDate">TANGGAL LAHIR</label>
        <input type="text" id="inputDate" name="inputDate"
               placeholder="mm-dd-yyyy" maxlength="10"
               value="<?= htmlspecialchars($_POST['inputDate'] ?? '') ?>"
               autocomplete="off" required>
        <p class="hint">Format: mm-dd-yyyy &nbsp; (contoh: 08-12-1990)</p>
        <button type="submit">Hitung Umur &rarr;</button>
    </form>

    <?php
    // Cek apakah form dikirim dengan metode POST dan input tidak kosong
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['inputDate'])):

        // Fungsi untuk mengecek apakah suatu tahun adalah tahun kabisat
        // Kabisat = habis dibagi 4 tapi tidak habis dibagi 100, ATAU habis dibagi 400
        function isLeapYear($year) {
            return ($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0);
        }

        // Fungsi untuk menghitung semua tahun kabisat dalam rentang waktu tertentu
        function countLeapYears($startYear, $endYear) {
            $leapYears = [];
            for ($y = $startYear; $y <= $endYear; $y++) {
                if (isLeapYear($y)) {
                    $leapYears[] = $y; // Tambahkan ke daftar jika kabisat
                }
            }
            return $leapYears;
        }

        // Ambil input dan hapus spasi di awal/akhir
        $inputDate = trim($_POST['inputDate']);

        // Variabel untuk menyimpan status validasi
        $valid = true;
        $errorMsg = '';

        // Validasi format tanggal menggunakan regex (harus mm-dd-yyyy)
        if (!preg_match('/^(\d{2})-(\d{2})-(\d{4})$/', $inputDate, $matches)) {
            $valid = false;
            $errorMsg = 'Format tanggal tidak valid. Gunakan format mm-dd-yyyy.';
        } else {
            // Ambil bulan, hari, tahun dari hasil regex
            $month = (int) $matches[1];
            $day = (int) $matches[2];
            $year = (int) $matches[3];

            // Validasi apakah tanggal benar-benar valid menggunakan checkdate()
            if (!checkdate($month, $day, $year)) {
                $valid = false;
                $errorMsg = 'Tanggal tidak valid. Periksa kembali input Anda.';
            }
        }

        if ($valid):
            // Buat objek DateTime untuk tanggal lahir dan tanggal hari ini
            $birthDate = new DateTime("$year-$month-$day");
            $today = new DateTime('2026-03-03');

            // Hitung selisih umur (tahun, bulan, hari)
            $diff = $birthDate->diff($today);
            $ageYears = $diff->y;
            $ageMonths = $diff->m;
            $ageDays = $diff->d;

            // Hitung tahun kabisat dari tahun lahir sampai sekarang
            $leapYears = countLeapYears($year, 2026);
    ?>
        <div class="result-box">
            <div class="result-label">Umur Anda</div>
            <div class="age-grid">
                <div class="age-item">
                    <div class="age-number"><?= $ageYears ?></div>
                    <div class="age-unit">Tahun</div>
                </div>
                <div class="age-item">
                    <div class="age-number"><?= $ageMonths ?></div>
                    <div class="age-unit">Bulan</div>
                </div>
                <div class="age-item">
                    <div class="age-number"><?= $ageDays ?></div>
                    <div class="age-unit">Hari</div>
                </div>
            </div>

            <div class="leap-box">
                <span class="leap-label">Tahun Kabisat Terlewati</span>
                <span class="leap-value"><?= count($leapYears) ?></span>
            </div>

            <div class="leap-years-list">
                <?= implode(', ', $leapYears) ?>
            </div>
        </div>
    <?php else: ?>
        <div class="error-msg"><?= htmlspecialchars($errorMsg) ?></div>
    <?php endif; ?>

    <?php endif; ?>

    <a href="../" class="back-link">&larr; Kembali ke Daftar Soal</a>
</div>

</body>
</html>
