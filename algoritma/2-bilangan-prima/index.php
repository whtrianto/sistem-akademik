<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 2 - Bilangan Prima</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0a192f, #112240, #1a365d);
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
            background: linear-gradient(135deg, #00b4d8, #0077b6);
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

        input[type="number"] {
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

        input[type="number"]:focus {
            border-color: #00b4d8;
            box-shadow: 0 0 0 3px rgba(0, 180, 216, 0.2);
        }

        input[type="number"]::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 14px;
            background: linear-gradient(135deg, #00b4d8, #0077b6);
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
            box-shadow: 0 8px 25px rgba(0, 180, 216, 0.4);
        }

        button:active { transform: translateY(0); }

        .result-box {
            margin-top: 28px;
            background: rgba(0, 180, 216, 0.08);
            border: 1px solid rgba(0, 180, 216, 0.25);
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
            margin-bottom: 8px;
        }

        .primes-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 20px;
        }

        .prime-chip {
            background: rgba(0, 180, 216, 0.15);
            border: 1px solid rgba(0, 180, 216, 0.3);
            color: #64dfdf;
            padding: 6px 14px;
            border-radius: 20px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 14px;
            font-weight: 500;
        }

        .sum-box {
            background: rgba(0, 180, 216, 0.12);
            border-radius: 12px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .sum-label {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
        }

        .sum-value {
            color: #64dfdf;
            font-family: 'JetBrains Mono', monospace;
            font-size: 28px;
            font-weight: 700;
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

        .back-link:hover { color: #00b4d8; }
    </style>
</head>
<body>

<div class="card">
    <span class="badge">Soal 2</span>
    <h1>Bilangan Prima</h1>
    <p class="subtitle">Menghitung jumlah semua bilangan prima yang lebih kecil dari bilangan yang dimasukkan.</p>

    <form method="post">
        <label for="inputNumber">MASUKKAN BILANGAN (n)</label>
        <input type="number" id="inputNumber" name="inputNumber"
               placeholder="contoh: 12" min="2"
               value="<?= htmlspecialchars($_POST['inputNumber'] ?? '') ?>"
               autocomplete="off" required>
        <button type="submit">Hitung Bilangan Prima &rarr;</button>
    </form>

    <?php
    // Cek apakah form dikirim dengan metode POST dan input tidak kosong
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['inputNumber'])):

        // Fungsi untuk mengecek apakah suatu bilangan adalah bilangan prima
        // Prima = bilangan yang hanya bisa dibagi 1 dan dirinya sendiri
        function isPrime($num) {
            if ($num < 2) return false;       // Kurang dari 2 bukan prima
            if ($num == 2) return true;        // 2 adalah prima terkecil
            if ($num % 2 == 0) return false;   // Bilangan genap selain 2 bukan prima
            // Cek pembagi ganjil dari 3 sampai akar kuadrat dari $num
            for ($i = 3; $i <= sqrt($num); $i += 2) {
                if ($num % $i == 0) return false;
            }
            return true; // Jika tidak ada pembagi, berarti prima
        }

        // Fungsi untuk mencari semua bilangan prima yang lebih kecil dari n
        function getPrimesLessThan($n) {
            $primes = [];
            // Loop dari 2 sampai n-1, cek satu per satu
            for ($i = 2; $i < $n; $i++) {
                if (isPrime($i)) {
                    $primes[] = $i; // Tambahkan ke array jika prima
                }
            }
            return $primes;
        }

        // Ambil input dan konversi ke integer
        $n = (int) $_POST['inputNumber'];
        // Cari semua bilangan prima yang lebih kecil dari n
        $primes = getPrimesLessThan($n);
        // Jumlahkan semua bilangan prima yang ditemukan
        $sum = array_sum($primes);
    ?>
        <div class="result-box">
            <div class="result-label">Bilangan Prima &lt; <?= $n ?></div>
            <div class="primes-list">
                <?php if (count($primes) > 0): ?>
                    <?php foreach ($primes as $prime): ?>
                        <span class="prime-chip"><?= $prime ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span style="color: rgba(255,255,255,0.5); font-size: 14px;">Tidak ada bilangan prima yang ditemukan.</span>
                <?php endif; ?>
            </div>

            <div class="result-label">Deret: <?= implode(', ', $primes) ?></div>

            <div class="sum-box" style="margin-top: 12px;">
                <span class="sum-label">Jumlah Total</span>
                <span class="sum-value"><?= $sum ?></span>
            </div>
        </div>
    <?php endif; ?>

    <a href="../" class="back-link">&larr; Kembali ke Daftar Soal</a>
</div>

</body>
</html>
