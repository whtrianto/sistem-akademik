<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 4 - Pencari Angka Ganda</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0d1117, #161b22, #21262d);
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
            background: linear-gradient(135deg, #f7971e, #ffd200);
            color: #1a1a2e;
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
            border-color: #ffd200;
            box-shadow: 0 0 0 3px rgba(255, 210, 0, 0.2);
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
            background: linear-gradient(135deg, #f7971e, #ffd200);
            color: #1a1a2e;
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
            box-shadow: 0 8px 25px rgba(255, 210, 0, 0.4);
        }

        button:active { transform: translateY(0); }

        .result-box {
            margin-top: 28px;
            background: rgba(255, 210, 0, 0.06);
            border: 1px solid rgba(255, 210, 0, 0.2);
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

        .input-display {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .num-chip {
            padding: 6px 14px;
            border-radius: 20px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .num-chip.duplicate {
            background: rgba(255, 210, 0, 0.2);
            border: 1px solid rgba(255, 210, 0, 0.4);
            color: #ffd200;
        }

        .num-chip.unique {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.4);
        }

        .divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 16px 0;
        }

        .dup-result {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            align-items: center;
        }

        .dup-chip {
            background: linear-gradient(135deg, rgba(247, 151, 30, 0.2), rgba(255, 210, 0, 0.2));
            border: 1px solid rgba(255, 210, 0, 0.4);
            color: #ffd200;
            padding: 10px 20px;
            border-radius: 12px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 18px;
            font-weight: 600;
        }

        .count-badge {
            background: rgba(255, 210, 0, 0.15);
            color: rgba(255, 210, 0, 0.8);
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 10px;
            margin-left: 4px;
            font-family: 'JetBrains Mono', monospace;
        }

        .no-dup {
            color: rgba(255, 255, 255, 0.5);
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

        .back-link:hover { color: #ffd200; }
    </style>
</head>
<body>

<div class="card">
    <span class="badge">Soal 4</span>
    <h1>Pencari Angka Ganda</h1>
    <p class="subtitle">Menemukan angka yang muncul lebih dari satu kali (duplikat) dalam daftar angka yang diberikan.</p>

    <form method="post">
        <label for="inputNumbers">MASUKKAN DAFTAR ANGKA</label>
        <input type="text" id="inputNumbers" name="inputNumbers"
               placeholder="contoh: 3, 7, 3, 5, 9, 3, 5, 8, 5"
               value="<?= htmlspecialchars($_POST['inputNumbers'] ?? '') ?>"
               autocomplete="off" required>
        <p class="hint">Pisahkan angka dengan koma (,)</p>
        <button type="submit">Cari Angka Ganda &rarr;</button>
    </form>

    <?php
    // Cek apakah form dikirim dengan metode POST dan input tidak kosong
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['inputNumbers'])):

        // Fungsi untuk mencari angka yang muncul lebih dari satu kali (duplikat)
        function findDuplicates($arr) {
            $count = [];      // Array untuk menghitung kemunculan setiap angka
            $duplicates = [];  // Array untuk menyimpan angka duplikat

            // Hitung kemunculan setiap angka
            foreach ($arr as $num) {
                $num = trim($num);          // Hapus spasi
                if ($num === '') continue;   // Lewati jika kosong
                $num = (int) $num;           // Konversi ke integer

                // Jika angka belum pernah dihitung, inisialisasi ke 0
                if (!isset($count[$num])) {
                    $count[$num] = 0;
                }
                $count[$num]++; // Tambah 1 ke counter
            }

            // Ambil angka yang muncul lebih dari 1 kali
            foreach ($count as $num => $cnt) {
                if ($cnt > 1) {
                    $duplicates[$num] = $cnt;
                }
            }
            foreach ($arr as $num) {
    $num = trim($num);
    if ($num === '') continue;

    $num = (int) $num;

    // Tambahkan ini
    if ($num < 0) continue; // Lewati jika negatif

    if (!isset($count[$num])) {
        $count[$num] = 0;
    }
    $count[$num]++;
}

            return $duplicates;
        }

        // Ambil input dari form
        $inputRaw = $_POST['inputNumbers'];
        // Pecah string menjadi array berdasarkan koma
        $numbers = explode(',', $inputRaw);
        // Bersihkan array: hapus spasi dan konversi ke integer
        $cleanNumbers = array_map(function($n) { return (int) trim($n); }, array_filter($numbers, function($n) { return trim($n) !== ''; }));
        // Cari angka duplikat
        $duplicates = findDuplicates($numbers);
        // Ambil daftar angka duplikat untuk highlight di tampilan
        $dupKeys = array_keys($duplicates);
    ?>
        <div class="result-box">
            <div class="result-label">Input yang Dianalisis</div>
            <div class="input-display">
                <?php foreach ($cleanNumbers as $num): ?>
                    <span class="num-chip <?= in_array($num, $dupKeys) ? 'duplicate' : 'unique' ?>">
                        <?= $num ?>
                    </span>
                <?php endforeach; ?>
            </div>

            <div class="divider"></div>

            <div class="result-label">Angka Ganda / Duplikat</div>
            <?php if (count($duplicates) > 0): ?>
                <div class="dup-result">
                    <?php foreach ($duplicates as $num => $cnt): ?>
                        <div class="dup-chip">
                            <?= $num ?>
                            <span class="count-badge">&times;<?= $cnt ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-dup">Tidak ada angka ganda ditemukan.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <a href="../" class="back-link">&larr; Kembali ke Daftar Soal</a>
</div>

</body>
</html>
