<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal Algoritma - PHP Native</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: #0a0a0f;
            color: #fff;
            overflow-x: hidden;
        }

        /* Animated gradient background */
        .bg-gradient {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse at 20% 50%, rgba(102, 126, 234, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at 80% 20%, rgba(240, 147, 251, 0.1) 0%, transparent 50%),
                radial-gradient(ellipse at 60% 80%, rgba(0, 180, 216, 0.1) 0%, transparent 50%);
            animation: bgShift 15s ease-in-out infinite alternate;
        }

        @keyframes bgShift {
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(30deg); }
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 900px;
            margin: 0 auto;
            padding: 60px 24px;
        }

        .header {
            text-align: center;
            margin-bottom: 60px;
        }

        .header-badge {
            display: inline-block;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 13px;
            color: rgba(255, 255, 255, 0.6);
            margin-bottom: 20px;
            letter-spacing: 1px;
        }

        .header h1 {
            font-size: 48px;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea, #f093fb, #00b4d8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1.2;
            margin-bottom: 16px;
        }

        .header p {
            color: rgba(255, 255, 255, 0.45);
            font-size: 16px;
            max-width: 500px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        @media (max-width: 640px) {
            .grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 32px; }
        }

        .soal-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 32px;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .soal-card::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 3px;
            border-radius: 20px 20px 0 0;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .soal-card:hover {
            background: rgba(255, 255, 255, 0.07);
            border-color: rgba(255, 255, 255, 0.15);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .soal-card:hover::before { opacity: 1; }

        /* Card accent colors */
        .soal-card:nth-child(1)::before { background: linear-gradient(90deg, #667eea, #764ba2); }
        .soal-card:nth-child(2)::before { background: linear-gradient(90deg, #00b4d8, #0077b6); }
        .soal-card:nth-child(3)::before { background: linear-gradient(90deg, #f093fb, #f5576c); }
        .soal-card:nth-child(4)::before { background: linear-gradient(90deg, #f7971e, #ffd200); }

        .card-number {
            font-size: 48px;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 16px;
        }

        .soal-card:nth-child(1) .card-number { color: rgba(102, 126, 234, 0.3); }
        .soal-card:nth-child(2) .card-number { color: rgba(0, 180, 216, 0.3); }
        .soal-card:nth-child(3) .card-number { color: rgba(240, 147, 251, 0.3); }
        .soal-card:nth-child(4) .card-number { color: rgba(247, 151, 30, 0.3); }

        .card-title {
            color: #fff;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .card-desc {
            color: rgba(255, 255, 255, 0.4);
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .card-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .tag {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.5);
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            letter-spacing: 0.5px;
        }

        .card-arrow {
            position: absolute;
            top: 32px;
            right: 32px;
            color: rgba(255, 255, 255, 0.15);
            font-size: 20px;
            transition: all 0.3s ease;
        }

        .soal-card:hover .card-arrow {
            color: rgba(255, 255, 255, 0.5);
            transform: translateX(4px);
        }

        .footer {
            text-align: center;
            margin-top: 60px;
            color: rgba(255, 255, 255, 0.2);
            font-size: 13px;
        }
    </style>
</head>
<body>

<div class="bg-gradient"></div>

<div class="container">
    <div class="header">
        <div class="header-badge">PHP NATIVE &bull; ALGORITMA</div>
        <h1>Soal Algoritma</h1>
        <p>Kumpulan solusi algoritma menggunakan PHP native. Pilih salah satu soal dibawah untuk melihat demo.</p>
    </div>

    <div class="grid">
        <a href="1-pembalik-string/" class="soal-card">
            <span class="card-arrow">&rarr;</span>
            <div class="card-number">01</div>
            <div class="card-title">Pembalik String</div>
            <div class="card-desc">Membalik string menggunakan fungsi rekursif — fungsi yang memanggil dirinya sendiri.</div>
            <div class="card-tags">
                <span class="tag">Rekursi</span>
                <span class="tag">String</span>
            </div>
        </a>

        <a href="2-bilangan-prima/" class="soal-card">
            <span class="card-arrow">&rarr;</span>
            <div class="card-number">02</div>
            <div class="card-title">Bilangan Prima</div>
            <div class="card-desc">Menghitung jumlah semua bilangan prima yang lebih kecil dari bilangan input (n).</div>
            <div class="card-tags">
                <span class="tag">Matematika</span>
                <span class="tag">Loop</span>
                <span class="tag">Prima</span>
            </div>
        </a>

        <a href="3-hitung-umur/" class="soal-card">
            <span class="card-arrow">&rarr;</span>
            <div class="card-number">03</div>
            <div class="card-title">Hitung Umur</div>
            <div class="card-desc">Menghitung umur dalam tahun, bulan, hari dan jumlah tahun kabisat yang terlewati.</div>
            <div class="card-tags">
                <span class="tag">DateTime</span>
                <span class="tag">Kabisat</span>
            </div>
        </a>

        <a href="4-angka-ganda/" class="soal-card">
            <span class="card-arrow">&rarr;</span>
            <div class="card-number">04</div>
            <div class="card-title">Pencari Angka Ganda</div>
            <div class="card-desc">Menemukan angka duplikat yang muncul lebih dari satu kali dalam daftar angka.</div>
            <div class="card-tags">
                <span class="tag">Array</span>
                <span class="tag">Duplikat</span>
            </div>
        </a>
    </div>

    <div class="footer">
        &copy; 2026 &mdash; Soal Algoritma PHP Native
    </div>
</div>

</body>
</html>
