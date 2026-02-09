<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Informasi Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f8f9fa;
            /* text-align: center; Hapus ini agar tabel tidak rata tengah teksnya */
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif;
            padding: 20px; /* Tambahan padding agar di HP tidak mepet */
        }

        .thank-you-container {
            padding: 2.5rem;
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Diperlebar agar tabel muat */
            width: 100%;
            text-align: center; /* Kembalikan text-align center untuk container utama */
        }

        .thank-you-container .icon-display {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .thank-you-container h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #343a40;
        }

        .thank-you-container p {
            font-size: 1rem;
            color: #495057;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .thank-you-container .btn-primary {
            font-size: 0.95rem;
            padding: 0.6rem 1.2rem;
            border-radius: 0.5rem;
        }

        /* Styling Tambahan untuk Tabel */
        .history-section {
            margin-top: 2rem;
            text-align: left; /* Tabel rata kiri */
            border-top: 1px solid #dee2e6;
            padding-top: 1.5rem;
        }
        
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid #dee2e6;
        }
        
        .table thead th {
            background-color: #f1f5f9;
            font-weight: 600;
            font-size: 0.9rem;
        }
        
        .table tbody td {
            font-size: 0.9rem;
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="thank-you-container">
        <div class="icon-display">
            <i class="bi bi-check-circle-fill text-success"></i>
        </div>
        <h1>Proses Selesai!</h1>

        <p>{!! $message ?? 'Terima kasih atas partisipasi Anda.' !!}</p>

        {{-- BLOK TOMBOL LANJUT ABSEN --}}
        @if(isset($continueUrl))
            <div class="mb-4">
                <p class="small text-muted mb-2">Masih ada tanggal kegiatan yang belum Anda ikuti.</p>
                <a href="{{ $continueUrl }}" class="btn btn-primary">
                    <i class="bi bi-calendar-plus-fill me-2"></i> Isi Absensi untuk Tanggal Lain
                </a>
            </div>
        @endif

        {{-- BLOK TABEL RIWAYAT (HISTORY) --}}
        @if(isset($history) && count($history) > 0)
            <div class="history-section">
                <h5 class="mb-3 text-start"><i class="bi bi-clock-history me-2"></i>Rekap Kehadiran Anda</h5>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Kegiatan</th>
                                <th>Tanggal Absen</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($history as $item)
                                {{-- Highlight baris pertama (yang baru saja submit) --}}
                                <tr class="{{ $loop->first ? 'table-success' : '' }}">
                                    <td>
                                        <strong>{{ $item->presence->nama_kegiatan ?? 'Kegiatan Tidak Ditemukan' }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $item->instansi }}</small>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($item->tanggal_absensi)->translatedFormat('d F Y') }}
                                        <br>
                                        <small class="text-muted">
                                            Diinput: {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        @if($loop->first)
                                            <span class="badge bg-success">Baru Saja</span>
                                        @else
                                            <span class="badge bg-secondary">Tercatat</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-2 text-muted small fst-italic">
                    *Menampilkan data berdasarkan NIK: {{ $history->first()->identity_number }}
                </div>
            </div>
        @endif

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>