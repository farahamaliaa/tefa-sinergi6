<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan | Sistem Manajemen Sekolah</title>
    <style>
        :root {
            --primary: #2b6cb0;
            --accent: #3182ce;
            --bg: #f7fafc;
            --text: #1a202c;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', 'Poppins', sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            padding: 60px 40px;
            max-width: 420px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        .image {
            width: 140px;
            height: auto;
            margin-bottom: 25px;
            opacity: 0.95;
            transition: opacity 0.3s ease;
        }

        .card:hover .image {
            opacity: 1;
        }

        h1 {
            font-size: 3.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 10px;
        }

        p {
            font-size: 1rem;
            color: #4a5568;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            background-color: var(--accent);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.25s ease;
        }

        .button:hover {
            background-color: #2c5282;
        }

        footer {
            margin-top: 40px;
            font-size: 0.9rem;
            color: #a0aec0;
        }

        @media (max-width: 500px) {
            .card {
                padding: 40px 25px;
            }

            h1 {
                font-size: 2.8rem;
            }

            .image {
                width: 110px;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="{{ asset('assets/images/alyaerror.png') }}" alt="Error Illustration" class="image">
        <h1>404</h1>
        <p>Halaman yang Anda cari tidak ditemukan.<br>
           Mungkin link sudah berubah atau dihapus.</p>
        <a href="{{ url('/') }}" class="button">Kembali ke Beranda</a>
    </div>

    <footer>© {{ date('Y') }} Sinergi6</footer>
</body>
</html>
