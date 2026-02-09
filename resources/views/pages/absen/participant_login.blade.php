<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Identifikasi Peserta - {{ $presence->nama_kegiatan }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --card-background-color: #ffffff;
            --text-dark: #34495e;
            --text-light: #ffffff;
            --input-border-color: #bdc3c7;
            --input-focus-border-color: var(--secondary-color);
            --button-hover-bg: #2980b9;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --card-border-radius: 1rem;
        }

        body {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            font-family: 'Poppins', sans-serif;
            padding: 1rem;
        }

        .main-container {
            width: 100%;
            max-width: 550px;
        }

        .logo-container {
            margin-bottom: 2rem;
            max-width: 120px;
        }

        .logo-container img {
            width: 100%;
            height: auto;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            background-color: white;
        }

        .login-card {
            border: none;
            border-radius: var(--card-border-radius);
            background-color: var(--card-background-color);
            box-shadow: var(--card-shadow);
            overflow: hidden;
        }

        .login-card .card-header {
            background-color: var(--primary-color);
            color: var(--text-light);
            padding: 1.5rem;
            border-bottom: none;
        }

        .card-body {
            padding: 2rem;
        }

        .kegiatan-info {
            background-color: #f8f9fa;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid #e9ecef;
            font-size: 0.9rem;
        }

        .form-label {
            font-weight: 500;
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
            padding: 0.8rem 1rem;
        }

        .form-control-lg:focus,
        .form-select-lg:focus {
            border-color: var(--input-focus-border-color);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background-color: var(--button-hover-bg);
            border-color: var(--button-hover-bg);
            transform: translateY(-2px);
        }

        .btn-primary:disabled {
            background-color: #95a5a6;
            border-color: #95a5a6;
            cursor: not-allowed;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="logo-container text-center mx-auto">
            <img src="{{ asset('images/logo-kemdikbud.jpg') }}" alt="Logo Kemdikbud">
        </div>
        <div class="card login-card shadow-lg">
            <div class="card-header text-center">
                <h4 class="mb-0">Identifikasi Peserta</h4>
            </div>
            <div class="card-body">
                <div class="kegiatan-info text-center">
                    Kegiatan: <strong>{{ $presence->nama_kegiatan }}</strong>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger py-2 small">
                        <ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('participant.login.submit', ['slug' => $presence->slug]) }}">
                    @csrf

                    <!-- ============================================= -->
                    <!-- === PERUBAHAN TATA LETAK DIMULAI DI SINI === -->
                    <!-- ============================================= -->

                    <!-- 1. Input NIK dipindahkan ke atas -->
                    <div class="mb-3">
                        <label for="identity_number" class="form-label">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" class="form-control form-control-lg" id="identity_number"
                            name="identity_number"
                            value="{{ old('identity_number', $identity_number_from_session ?? '') }}" required autofocus
                            pattern="\d{16}" title="NIK harus 16 digit angka"
                            placeholder="Masukkan 16 digit NIK Anda...">
                        <div id="nik-feedback" class="form-text mt-2 small"></div>
                    </div>

                    @if($isMultiDayLink)
                        <input type="hidden" name="is_multi_day_link" value="1">

                        <!-- 2. Pilihan Tanggal sekarang di bawah NIK -->
                        <div class="mb-3">
                            <label for="tanggal_absensi" class="form-label">Pilih Tanggal Presensi <span
                                    class="text-danger">*</span></label>
                            <select name="tanggal_absensi" id="tanggal_absensi" class="form-select form-control-lg" required
                                disabled>
                                <option value="" disabled selected>-- Masukkan 16 digit NIK terlebih dahulu --</option>
                            </select>
                        </div>
                    @else
                        <!-- Untuk link harian, input tanggal tetap tersembunyi -->
                        <input type="hidden" name="tanggal_absensi" value="{{ $today }}">
                        <div class="kegiatan-info text-center">
                            <span class="d-block">Anda akan melakukan presensi untuk tanggal:</span>
                            <strong>{{ \Carbon\Carbon::parse($today)->translatedFormat('l, d F Y') }}</strong>
                        </div>
                    @endif

                    <!-- =================================== -->
                    <!-- === AKHIR PERUBAHAN TATA LETAK === -->
                    <!-- =================================== -->

                    <div class="d-grid mt-4">
                        <button type="submit" id="submit-button" class="btn btn-primary btn-lg"
                            disabled>Lanjutkan</button>
                    </div>
                </form>
            </div>
        </div>
        <footer class="text-center mt-4">
            <small class="text-white-50">&copy; {{ date('Y') }} {{ config('app.name', 'Presensi Online') }}</small>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isMultiDay = {{ $isMultiDayLink ? 'true' : 'false' }};
            const submitButton = document.getElementById('submit-button');

            if (isMultiDay) {
                const nikInput = document.getElementById('identity_number');
                const dateSelect = document.getElementById('tanggal_absensi');
                const nikFeedback = document.getElementById('nik-feedback');
                const presenceSlug = '{{ $presence->slug }}';
                let fetchTimeout;

                function validateForm() {
                    const nikIsValid = nikInput.value.length === 16;
                    const dateIsSelected = dateSelect.value !== '';
                    submitButton.disabled = !(nikIsValid && dateIsSelected);
                }

                nikInput.addEventListener('input', function () {
                    const nik = this.value;

                    dateSelect.innerHTML = '<option value="" disabled selected>-- Masukkan 16 digit NIK terlebih dahulu --</option>';
                    dateSelect.disabled = true;
                    nikFeedback.textContent = '';
                    nikFeedback.classList.remove('text-danger', 'text-success');
                    clearTimeout(fetchTimeout);

                    if (nik.length === 16) {
                        nikFeedback.textContent = 'Memeriksa NIK...';
                        fetchTimeout = setTimeout(() => {
                            fetchAvailableDates(nik);
                        }, 500);
                    }
                    validateForm();
                });

                dateSelect.addEventListener('change', validateForm);

                function fetchAvailableDates(nik) {
                    const url = `/api/presence/${presenceSlug}/available-dates/${nik}`;
                    fetch(url)
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => { throw new Error(err.error || 'NIK tidak terdaftar atau terjadi kesalahan.') });
                            }
                            return response.json();
                        })
                        .then(data => {
                            dateSelect.innerHTML = '';
                            if (Object.keys(data).length === 0) {
                                nikFeedback.textContent = 'Semua tanggal telah terisi untuk NIK ini.';
                                nikFeedback.classList.add('text-success');
                                dateSelect.innerHTML = '<option value="" disabled selected>Anda sudah absen di semua tanggal</option>';
                            } else {
                                nikFeedback.textContent = 'NIK ditemukan. Silakan pilih tanggal.';
                                nikFeedback.classList.add('text-success');
                                dateSelect.innerHTML = '<option value="" disabled selected>-- Pilih salah satu tanggal --</option>';
                                for (const [value, text] of Object.entries(data)) {
                                    const option = document.createElement('option');
                                    option.value = value;
                                    option.textContent = text;
                                    dateSelect.appendChild(option);
                                }
                                dateSelect.disabled = false;
                            }
                            validateForm();
                        })
                        .catch(error => {
                            nikFeedback.textContent = error.message;
                            nikFeedback.classList.add('text-danger');
                            console.error('Error fetching dates:', error);
              
                            validateForm();
                        });
                }

                // Panggil sekali di awal untuk memastikan state tombol benar
                validateForm();

            } else {
                // Untuk link global, tombol aktif jika NIK sudah 16 digit
                const nikInput = document.getElementById('identity_number');
                nikInput.addEventListener('input', function () {
                    submitButton.disabled = this.value.length !== 16;
                });
                // Panggil sekali di awal
                submitButton.disabled = nikInput.value.length !== 16;
            }
        });
    </script>
</body>

</html>