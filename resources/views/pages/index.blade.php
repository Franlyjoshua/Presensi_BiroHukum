@extends('layouts.main')

@section('title', 'Selamat Datang di Presensi Rapat')

@push('css') 
<style>
    :root {
        --primary-blue: #2E5C8A; 
        --primary-blue-light: #5C8DBC; 
        --primary-blue-hover: #244A70; 
        --primary-blue-rgb: 46, 92, 138;

        --accent-gold: #FFC107; 
        --page-background-color: #F4F6F8; 
        
        --text-dark: #1A202C; 
        --text-light: #FFFFFF;
        --text-muted-custom: #5A6778;
        --hero-card-background: #FFFFFF;
        --hero-card-shadow: rgba(0, 0, 0, 0.08);
    }


    .welcome-hero-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 160px); /* Perkiraan tinggi navbar + footer + padding main */
        /* 100vh dikurangi tinggi elemen lain agar hero section bisa mengisi ruang vertikal yang tersedia */
        padding: 2rem 0; /* Padding atas bawah untuk keseluruhan section di dalam container main */
        position: relative;
        width: 100%; /* Memastikan mengambil lebar penuh dari .container di layouts.main */
    }

    .welcome-hero-card {
        background-color: var(--hero-card-background);
        padding: 3rem 2rem;
        border-radius: 12px; /* Sudut lebih rounded */
        box-shadow: 0 10px 35px var(--hero-card-shadow);
        text-align: center;
        position: relative; /* Untuk elemen dekoratif absolut */
        overflow: hidden; /* Agar ::before dan ::after tidak keluar card */
        max-width: 750px; /* Lebar maksimum card */
        width: 100%;
        animation: fadeInScaleUp 0.8s ease-out;
    }

    /* Elemen dekoratif di dalam card */
    .welcome-hero-card::before,
    .welcome-hero-card::after {
        content: '';
        position: absolute;
        border-radius: 50%;
        opacity: 0.08;
        z-index: 0; /* Di belakang konten card */
        pointer-events: none; /* Agar tidak mengganggu interaksi */
        animation: slowPulse 20s infinite ease-in-out alternate;
    }

    .welcome-hero-card::before {
        width: 250px;
        height: 250px;
        background: radial-gradient(circle, var(--primary-blue-light) 0%, transparent 70%);
        top: -80px;
        left: -100px;
    }

    .welcome-hero-card::after {
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, var(--accent-gold) 0%, transparent 70%);
        bottom: -70px;
        right: -90px;
        animation-delay: 3s;
    }
    
    @keyframes slowPulse {
        0% { transform: scale(0.95); opacity: 0.06; }
        100% { transform: scale(1.05); opacity: 0.1; }
    }


    .welcome-content {
        position: relative; 
        z-index: 1; 
    }

    .welcome-logo {
        margin-bottom: 1.5rem; /* Jarak dari logo ke judul dikurangi sedikit */
    }

    .welcome-logo img {
        max-width: 100px;  /* LOGO DIPERKECIL: Lebar maksimum 100px */
        height: auto;       /* Tinggi otomatis menyesuaikan */
        max-height: 100px; /* Batas tinggi tambahan jika perlu */
        display: block;     /* Agar margin auto bekerja untuk centering */
        margin-left: auto;
        margin-right: auto;
        margin-bottom: 1.5rem; /* Jarak spesifik di bawah logo */
        filter: drop-shadow(0 3px 5px rgba(0,0,0,0.07));
        transition: transform 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .welcome-logo img:hover {
        transform: scale(1.1); /* Efek hover lebih terasa */
    }

    .welcome-title {
        font-size: clamp(2rem, 4.5vw, 3rem); /* Ukuran sedikit disesuaikan */
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.2;
        margin-bottom: 0.5rem; 
        letter-spacing: -0.5px; /* Sedikit merapatkan huruf */
    }

    .welcome-subtitle {
        font-size: clamp(1.2rem, 3.5vw, 1.7rem); 
        font-weight: 400; /* Lebih ringan dari judul utama */
        color: var(--primary-blue);
        margin-bottom: 1.5rem; 
        letter-spacing: 0.2px;
    }

    .welcome-text {
        font-size: clamp(0.95rem, 2.2vw, 1.05rem);
        color: var(--text-muted-custom);
        margin-bottom: 2rem; 
        max-width: 500px; 
        margin-left: auto; 
        margin-right: auto;
        line-height: 1.7; /* Spasi antar baris lebih nyaman */
    }
    
    .welcome-cta a {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-light) 100%);
        color: var(--text-light); 
        padding: 0.9rem 2.2rem; /* Padding tombol lebih besar */
        font-weight: 500; 
        font-size: clamp(0.9rem, 2vw, 1rem);
        border-radius: 8px; /* Tombol dengan sudut sedikit rounded, lebih formal */
        text-decoration: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 12px rgba(var(--primary-blue-rgb), 0.18);
        display: inline-block; 
        letter-spacing: 0.3px;
    }
    .welcome-cta a:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 7px 18px rgba(var(--primary-blue-rgb), 0.28);
    }

    /* Animasi masuk untuk card utama */
    @keyframes fadeInScaleUp {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }


    /* Penyesuaian Responsif */
    @media (max-width: 768px) {
        .welcome-hero-card {
            padding: 2.5rem 1.5rem;
        }
        .welcome-logo img {
            max-width: 90px; 
            max-height: 90px;
        }
        .welcome-hero-card::before {
            width: 200px; height: 200px; top: -60px; left: -80px;
        }
        .welcome-hero-card::after {
            width: 150px; height: 150px; bottom: -50px; right: -70px;
        }
    }
    @media (max-width: 576px) {
        .welcome-hero-container {
            min-height: calc(100vh - 120px); /* Sesuaikan jika navbar + footer lebih tinggi/pendek di mobile */
            padding: 1rem 0;
        }
        .welcome-hero-card {
            padding: 2rem 1rem;
            margin-left: 0.75rem; /* Beri sedikit margin horizontal */
            margin-right: 0.75rem;
        }
        .welcome-logo img {
            max-width: 80px; 
            max-height: 80px;
        }
        .welcome-hero-card::before,
        .welcome-hero-card::after { 
            display: none; /* Sembunyikan shape di mobile agar fokus ke konten */
        }
    }
</style>
@endpush

@section('content')
    <div class="welcome-hero-container">
        <div class="welcome-hero-card">
            <div class="welcome-content">
                <div class="welcome-logo">
                    <img src="{{ asset('images/logo-kemdikbud.jpg') }}" alt="Logo Kemdikbud Tut Wuri Handayani">
                </div>

                <h1 class="welcome-title">Selamat Datang</h1>
                <h2 class="welcome-subtitle">di Aplikasi Presensi Rapat <u>Biro Hukum</u></h2> {{-- Sedikit variasi teks --}}
                
                <p class="welcome-text">
                    Sistem presensi digital untuk efisiensi dan akurasi data kehadiran rapat Anda.
                </p>

                <div class="welcome-cta">
                    @auth 
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}">Masuk ke Dashboard Admin</a> 
                        @else
                            {{-- Jika ada halaman spesifik untuk user non-admin yang login --}}
                            {{-- <a href="{{ route('user.dashboard') }}">Lihat Presensi Saya</a>  --}}
                        @endif
                    @else 
                        {{-- Tombol jika user adalah tamu dan ada halaman login peserta atau halaman info --}}
                        {{-- <a href="#">Mulai Presensi</a> --}}
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection