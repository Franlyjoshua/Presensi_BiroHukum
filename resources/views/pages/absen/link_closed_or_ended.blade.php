@extends('layouts.minimal_status') {{-- Menggunakan layout minimalis baru --}}

@section('title', 'Informasi Akses')

@push('css')
<style>
    .status-card {
        max-width: 580px; /* Sedikit lebih lebar */
        width: 100%;
        padding: 3rem; /* Padding lebih besar */
        border-radius: 0.875rem;
        background-color: #ffffff;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1); /* Bayangan lebih menonjol */
        border: 1px solid #dee2e6;
    }
    .status-icon {
        font-size: 4.5rem;
        margin-bottom: 1.5rem; /* Jarak ikon ke judul */
    }
    .status-title {
        font-size: 1.85rem; /* Judul lebih besar */
        font-weight: 700; /* Lebih tebal */
        margin-bottom: 1rem;
        color: #212529; /* Warna lebih gelap */
    }
    .status-activity-name {
        font-size: 1.05rem;
        color: #495057;
        margin-bottom: 1.5rem; /* Jarak nama kegiatan ke pesan */
        font-weight: 500;
    }
    .status-message {
        font-size: 1.1rem;
        color: #343a40;
        margin-bottom: 0; /* Hilangkan margin bawah jika tidak ada tombol */
        line-height: 1.6;
    }
    /* Tidak ada style untuk tombol karena tombol dihilangkan */
</style>
@endpush

@section('content')
{{-- Container tidak lagi diperlukan di sini karena body sudah diatur untuk centering --}}
<div class="status-card text-center">
    <i class="bi bi-slash-circle-fill status-icon text-danger"></i> {{-- Ikon yang lebih generik untuk akses ditolak --}}

    <h2 class="status-title">Akses Tidak Diizinkan</h2>

    @if(isset($presenceName) && !empty($presenceName))
        <p class="status-activity-name">Untuk Kegiatan: <strong>{{ $presenceName }}</strong></p>
    @endif

    <p class="status-message">
        {{ $message ?? 'Mohon maaf, link absensi ini sudah tidak dapat diakses. Periode kegiatan mungkin telah berakhir atau link telah ditutup oleh panitia.' }}
    </p>

    {{-- Tombol "Tutup Halaman Ini" DIHILANGKAN --}}
</div>
@endsection