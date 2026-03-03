<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 1 - Pembalik String Rekursif</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
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
            background: linear-gradient(135deg, #667eea, #764ba2);
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
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        input[type="text"]::placeholder {
            color: rgba(255, 255, 255, 0.25);
        }

        button {
            width: 100%;
            margin-top: 20px;
            padding: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
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
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        button:active {
            transform: translateY(0);
        }

        .result-box {
            margin-top: 28px;
            background: rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.25);
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

        .result-value {
            color: #a78bfa;
            font-family: 'JetBrains Mono', monospace;
            font-size: 24px;
            font-weight: 600;
            word-break: break-all;
        }

        .steps {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .steps p {
            color: rgba(255, 255, 255, 0.4);
            font-size: 12px;
            font-family: 'JetBrains Mono', monospace;
            line-height: 1.8;
        }

        .steps span {
            color: rgba(255, 255, 255, 0.6);
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

        .back-link:hover { color: #667eea; }
    </style>
</head>
<body>

<div class="card">
    <span class="badge">Soal 1</span>
    <h1>Pembalik String</h1>
    <p class="subtitle">Membalik string menggunakan fungsi rekursif &mdash; fungsi yang memanggil dirinya sendiri.</p>

    <form method="post">
        <label for="inputString">MASUKKAN STRING</label>
        <input type="text" id="inputString" name="inputString"
               placeholder="contoh: INDONESIA"
               value="<?= htmlspecialchars($_POST['inputString'] ?? '') ?>"
               autocomplete="off" required>
        <button type="submit">Balikkan String &rarr;</button>
    </form>

    <?php
    // Cek apakah form dikirim dengan metode POST dan input tidak kosong
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['inputString'])):

        // Fungsi rekursif untuk membalik string
        // Rekursi = fungsi yang memanggil dirinya sendiri
        function reverseString($str) {
            // Base case: jika string kosong atau 1 karakter, langsung kembalikan
            if (strlen($str) <= 1) {
                return $str;
            }
            // Ambil karakter terakhir, lalu gabung dengan hasil rekursi sisa string
            // Contoh: "HALO" → "O" + reverseString("HAL")
            return $str[strlen($str) - 1] . reverseString(substr($str, 0, strlen($str) - 1));
        }

        // Fungsi untuk mencatat langkah-langkah rekursi (untuk ditampilkan ke user)
        function reverseSteps($str, $depth = 0) {
            $steps = [];
            // Base case
            if (strlen($str) <= 1) {
                $steps[] = str_repeat("  ", $depth) . "reverseString('$str') → '$str' (base case)";
                return $steps;
            }
            // Catat langkah: ambil karakter terakhir dan sisa string
            $lastChar = $str[strlen($str) - 1];
            $remaining = substr($str, 0, strlen($str) - 1);
            $steps[] = str_repeat("  ", $depth) . "reverseString('$str') → '$lastChar' + reverseString('$remaining')";
            // Gabungkan dengan langkah rekursi berikutnya
            $steps = array_merge($steps, reverseSteps($remaining, $depth + 1));
            return $steps;
        }

        // Ambil input dari form
        $input = $_POST['inputString'];
        // Jalankan fungsi pembalik string
        $result = reverseString($input);
        // Ambil langkah-langkah rekursi untuk ditampilkan
        $steps = reverseSteps($input);
    ?>
        <div class="result-box">
            <div class="result-label">Hasil</div>
            <div class="result-value"><?= htmlspecialchars($result) ?></div>
            <div class="steps">
                <div class="result-label" style="margin-bottom: 4px;">Langkah Rekursi</div>
                <?php foreach ($steps as $step): ?>
                    <p><span><?= htmlspecialchars($step) ?></span></p>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <a href="../" class="back-link">&larr; Kembali ke Daftar Soal</a>
</div>

</body>
</html>
