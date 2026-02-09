<!DOCTYPE html>
<html>

<head>
    <title>Konfirmasi Kehadiran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            max-width: 600px;
            margin: 0 auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #4A9D9C;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        .details {
            margin-bottom: 20px;
        }

        .details p {
            margin: 5px 0;
            color: #555;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 30px;
        }

        .btn {
            background-color: #4A9D9C;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Absensi Berhasil!</h2>
            <p>Terima kasih, kehadiran Anda telah tercatat.</p>
        </div>

        <p>Halo <strong>{{ $data['nama'] }}</strong>,</p>
        <p>Berikut adalah detail bukti kehadiran Anda:</p>

        <div class="details" style="background-color: #f9f9f9; padding: 15px; border-radius: 5px;">
            <p><strong>Kegiatan:</strong> {{ $eventName }}</p>
            <p><strong>Tanggal Absen:</strong>
                {{ \Carbon\Carbon::parse($data['tanggal_absensi'])->translatedFormat('d F Y') }}</p>
            <p><strong>Waktu Input:</strong> {{ date('H:i') }} WIB</p>
            <hr style="border: 0; border-top: 1px solid #eee;">
            <p><strong>Instansi:</strong> {{ $data['instansi'] }}</p>
            <p><strong>NIK:</strong> {{ $data['identity_number'] }}</p>
        </div>

        <p>Email ini adalah bukti sah bahwa Anda telah mengikuti kegiatan tersebut.</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Sistem Absensi Digital.</p>
        </div>
    </div>
</body>

</html>