<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Absensi Ditutup</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --background-color: #F8F9FA;
            --card-background: #FFFFFF;
            --card-shadow: rgba(0, 0, 0, 0.05);
            --text-primary: #212529;
            --text-secondary: #495057;
            --warning-color: #F59E0B;
            /* Warna kuning dari Tailwind CSS */
            --warning-background: #FFFBEB;
            /* Warna kuning muda */
            --warning-border: #FEEBC8;
            /* Warna border kuning */
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: var(--background-color);
            font-family: 'Poppins', sans-serif;
            color: var(--text-primary);
            padding: 1rem;
        }

        .message-card {
            background-color: var(--card-background);
            padding: 2.5rem;
            border-radius: 1rem;
            text-align: center;
            max-width: 550px;
            width: 100%;
            box-shadow: 0 8px 25px var(--card-shadow);
            border: 1px solid #E2E8F0;
        }

        .icon-container {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background-color: var(--warning-background);
        }

        .icon-container i {
            font-size: 2.75rem;
            color: var(--warning-color);
        }

        .message-card h4 {
            font-weight: 600;
            font-size: 1.5rem;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        .message-card p {
            color: var(--text-secondary);
            font-size: 1rem;
            line-height: 1.6;
        }

        .contact-info {
            margin-top: 1.5rem;
            padding: 1.25rem;
            background-color: var(--warning-background);
            border: 1px dashed var(--warning-border);
            border-radius: 0.75rem;
        }

        .contact-info p {
            margin-bottom: 0;
            font-size: 0.95rem;
        }
    </style>
</head>

<body>
    <div class="message-card">
        <!-- Ikon Peringatan Baru yang Lebih Menonjol -->
        <div class="icon-container">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>

        <!-- Judul dan Pesan yang Diperbarui -->
        <h4 class="mb-3">Link Absensi Telah Ditutup</h4>
        <p>
            Mohon maaf, link absensi harian untuk kegiatan <strong>{{ $presence->nama_kegiatan }}</strong> sudah tidak
            aktif atau periode kegiatan telah berakhir.
        </p>

        <!-- Kotak Informasi Kontak Panitia -->
        <div class="contact-info">
            <p>
                Untuk dapat mengisi absensi pada tanggal yang sudah terlewat, Hubungi Admin untuk memproses nya.
            </p>
        </div>

        <!-- Tombol dihapus sesuai permintaan -->
    </div>
</body>

</html>