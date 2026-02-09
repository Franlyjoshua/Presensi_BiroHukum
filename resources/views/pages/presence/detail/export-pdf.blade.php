<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Judul PDF lebih dinamis dengan nama kegiatan dan tanggal laporan --}}
    <title>{{ env('APP_NAME') }} - Laporan Presensi - {{ $presence->nama_kegiatan }} - {{ isset($exportDate) ? \Carbon\Carbon::parse($exportDate)->translatedFormat('d M Y') : \Carbon\Carbon::parse($presence->datetime_mulai)->translatedFormat('d M Y') }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px; 
            line-height: 1.4; 
            color: #000000;
            margin: 12px; 
            background-color: #ffffff;
        }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .page-title { font-size: 20px; font-weight: bold; color: #000000; margin-bottom: 15px; text-align: center; text-transform: uppercase; letter-spacing: 1px; }
        .info-table { width: 100%; margin-bottom: 20px; border-collapse: separate; border-spacing: 0 3px; font-size: 11px; }
        .info-table td { padding: 5px 0; vertical-align: top; }
        .info-table td.label { font-weight: bold; color: #000000; width: 170px; font-size: 11.5px; } /* Lebar disesuaikan sedikit */
        .info-table td.separator { width: 10px; text-align: center; color: #000000; font-weight: bold; }
        .info-table td.value { color: #000000; font-weight: 500; font-size: 11.5px; } /* Font weight value disesuaikan */
        .data-table { width: 100%; border-collapse: collapse; margin-top: 10px; border: 1px solid #000000; } /* Border lebih tipis */
        .data-table th,
        .data-table td { border: 1px solid #444444; padding: 6px 4px; vertical-align: middle; font-size: 9px; } /* Padding & font disesuaikan */
        .data-table th { background-color: #333333; color: #ffffff; font-weight: bold; text-align: center; font-size: 9.5px; text-transform: uppercase; letter-spacing: 0.5px; padding-top: 7px; padding-bottom: 7px; }
        .data-table td.golongan-cell { white-space: nowrap; text-align: left; }
        .data-table td.time-value { text-align: center; white-space: nowrap; }
        .data-table tbody tr:nth-child(even) { background-color: #f8f8f8; } /* Warna zebra striping lembut */
        .data-table td.email-col { word-break: break-all; }
        .data-table .signature-cell { height: 30px; text-align: center; vertical-align: middle; } /* Tinggi sel tanda tangan disesuaikan */
        .signature-cell img { max-width: 70px; max-height: 22px; display: block; margin-left: auto; margin-right: auto; } /* Ukuran gambar tanda tangan disesuaikan */
        .no-data-message { padding: 15px; color: #555555; font-style: italic; font-size: 10px; }
    </style>
</head>

<body>
    <h1 class="page-title">{{ env('APP_NAME') }}</h1>

    <table class="info-table">
        <tr>
            <td class="label">Nama Kegiatan</td>
            <td class="separator">:</td>
            <td class="value">{{ $presence->nama_kegiatan }}</td>
        </tr>
        <tr>
            {{-- DIUBAH: Menampilkan Tanggal Laporan Presensi (dari $exportDate) --}}
            <td class="label">Tanggal Laporan Presensi</td>
            <td class="separator">:</td>
            <td class="value">{{ isset($exportDate) ? \Carbon\Carbon::parse($exportDate)->translatedFormat('d F Y') : '-' }}</td>
        </tr>
        <tr>
            {{-- DIUBAH: Menampilkan Periode Pelaksanaan Kegiatan --}}
            <td class="label">Periode Pelaksanaan</td>
            <td class="separator">:</td>
            <td class="value">
                @if($presence->datetime_mulai->isSameDay($presence->datetime_selesai))
                    {{-- Kegiatan satu hari --}}
                    {{ $presence->datetime_mulai->translatedFormat('d F Y') }}
                    ({{ $presence->datetime_mulai->translatedFormat('H:i') }} - {{ $presence->datetime_selesai->translatedFormat('H:i') }} WIB)
                @else
                    {{-- Kegiatan multi-hari --}}
                    {{ $presence->datetime_mulai->translatedFormat('d') }} - {{ $presence->datetime_selesai->translatedFormat('d F Y') }}
                    ({{ $presence->datetime_mulai->translatedFormat('H:i') }} WIB - {{ $presence->datetime_selesai->translatedFormat('H:i') }} WIB)
                @endif
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 3%;">No.</th>
                {{-- DIUBAH: Header kolom untuk lebih jelas --}}
                <th style="width: 13%;">Waktu Absen (WIB)</th>
                <th style="width: 12%;">Nama</th> 
                <th style="width: 13%;">Email</th> 
                <th style="width: 7%;">No. Hp</th> 
                <th style="width: 8%;">Instansi</th> 
                <th style="width: 7%;">Nama Bank</th> 
                <th style="width: 8%;">No. Rekening</th> 
                <th style="width: 8%;">Atas Nama</th> 
                <th style="width: 6%;">NPWP</th> 
                <th style="width: 8%;">Gol.</th> 
                <th style="width: 7%;">Tanda Tangan</th>
            </tr>
        </thead>
        <tbody>
            @if ($presenceDetails->isEmpty())
                <tr>
                    <td colspan="12" class="text-center no-data-message">
                        Tidak ada data peserta yang melakukan absensi untuk tanggal {{ isset($exportDate) ? \Carbon\Carbon::parse($exportDate)->translatedFormat('d F Y') : 'ini' }}.
                    </td>
                </tr>
            @else
                @foreach ($presenceDetails as $detail)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="time-value">
                            {{-- DIUBAH: Format waktu absensi peserta agar konsisten --}}
                            {{ \Carbon\Carbon::parse($detail->created_at)->timezone(config('app.timezone', 'Asia/Jakarta'))->locale(config('app.locale', 'id'))->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="text-left">{{ $detail->nama }}</td>
                        <td class="text-left email-col">{{ $detail->email }}</td>
                        <td class="text-left">{{ $detail->no_hp }}</td>
                        <td class="text-left">{{ $detail->instansi }}</td>
                        <td class="text-left">{{ $detail->nama_bank }}</td>
                        <td class="text-left">{{ $detail->no_rekening }}</td>
                        <td class="text-left">{{ $detail->atas_nama }}</td>
                        <td class="text-left">{{ $detail->npwp }}</td>
                        <td class="golongan-cell">{{ $detail->golongan }}</td>
                        <td class="signature-cell">
                            @if ($detail->tanda_tangan)
                                @php
                                    $imgSrc = null;
                                    try {
                                        // Menggunakan Storage facade untuk mendapatkan path absolut jika diperlukan,
                                        // atau langsung base64 encode konten file dari storage.
                                        $pathForCheck = $detail->tanda_tangan; // Ini adalah path relatif dari root disk 'public_uploads'
                                        if (Storage::disk('public_uploads')->exists($pathForCheck)) {
                                            $fileContent = Storage::disk('public_uploads')->get($pathForCheck);
                                            // Dapatkan tipe MIME secara dinamis jika memungkinkan, atau default ke png
                                            $mimeType = Storage::disk('public_uploads')->mimeType($pathForCheck);
                                            if (strpos($mimeType, 'image/') === 0) { // Pastikan itu adalah gambar
                                                $imgSrc = 'data:' . $mimeType . ';base64,' . base64_encode($fileContent);
                                            } else {
                                                // Fallback jika tipe MIME tidak terdeteksi sebagai gambar, coba ekstensi
                                                $type = pathinfo($pathForCheck, PATHINFO_EXTENSION);
                                                if (in_array(strtolower($type), ['jpg', 'jpeg', 'png', 'gif'])) {
                                                     $imgSrc = 'data:image/' . $type . ';base64,' . base64_encode($fileContent);
                                                }
                                            }
                                        }
                                    } catch (Exception $e) {
                                        $imgSrc = null; // Tetap null jika ada error
                                    }
                                @endphp
                                @if ($imgSrc)
                                    <img src="{{ $imgSrc }}" alt="Tanda Tangan">
                                @else
                                <span style="font-size: 8.5px; color: #333;">Gbr. Tdk Valid</span>
                                @endif
                            @else
                            <span style="font-size: 9.5px; color: #555;">-</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>