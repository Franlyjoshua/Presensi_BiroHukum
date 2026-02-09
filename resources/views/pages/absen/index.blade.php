<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Absensi: {{ $presence->nama_kegiatan }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        /* Desain Anda dipertahankan sepenuhnya */
        :root {
            --primary-blue: #2E5C8A;
            --primary-blue-hover: #244A70;
            --primary-blue-rgb: 46, 92, 138;
            --accent-blue-light: #EFF5FA;
            --accent-blue-border: #C9DAEA;
            --background-gray: #F4F6F8;
            --card-background-color: #FFFFFF;
            --text-dark: #1A202C;
            --text-muted-custom: #5A6778;
            --card-border-radius: 0.75rem;
            --input-border-color: #D2D6DC;
            --input-focus-border-color: var(--primary-blue);
            --input-focus-box-shadow-color: rgba(var(--primary-blue-rgb), 0.2);
            --danger-red: #E53E3E;
            --success-green: #38A169;
        }

        body {
            background-color: var(--background-gray);
            font-family: 'Poppins', sans-serif;
            color: var(--text-dark);
            padding-top: 2.5rem;
            padding-bottom: 3.5rem;
        }

        .page-container {
            max-width: 850px;
            margin-left: auto;
            margin-right: auto;
        }

        .event-header-section {
            text-align: center;
            margin-bottom: 2.5rem;
            padding: 1.5rem;
            background-color: var(--card-background-color);
            border-radius: var(--card-border-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
        }

        .event-main-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-blue);
            margin-bottom: 0.75rem;
        }

        .event-meta-info {
            font-size: 1rem;
            color: var(--text-muted-custom);
        }

        .event-meta-info strong {
            color: var(--text-dark);
            font-weight: 500;
        }

        .event-meta-info .separator {
            margin: 0 0.75rem;
            color: #CBD5E0;
        }

        .main-form-card {
            background-color: var(--card-background-color);
            border: none;
            border-radius: var(--card-border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            margin-bottom: 2rem;
        }

        .main-form-card .card-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #4A8CCA 100%);
            color: white;
            padding: 1.5rem 2rem;
            border-bottom: none;
            border-top-left-radius: var(--card-border-radius);
            border-top-right-radius: var(--card-border-radius);
            text-align: center;
        }

        .main-form-card .card-header h5 {
            margin-bottom: 0;
            font-weight: 600;
            font-size: 1.25rem;
            letter-spacing: 0.5px;
        }

        .card-body-padded {
            padding: 2.5rem;
        }

        .form-label {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-label .text-danger {
            color: var(--danger-red) !important;
            font-weight: 600;
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
            padding: 0.8rem 1.1rem;
            font-size: 0.95rem;
            border: 1px solid var(--input-border-color);
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            background-color: #FDFDFD;
        }

        .form-control::placeholder {
            color: #A0AEC0;
            font-size: 0.9rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--input-focus-border-color);
            box-shadow: 0 0 0 0.2rem var(--input-focus-box-shadow-color);
            background-color: var(--card-background-color);
        }

        .signature-pad-container {
            border: 2px dashed var(--accent-blue-border);
            border-radius: 0.5rem;
            background-color: var(--accent-blue-light);
            padding: 0.25rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-blue) 0%, #4A8CCA 100%);
            border: none;
            padding: 0.85rem 2rem;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 15px rgba(var(--primary-blue-rgb), 0.15);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-blue-hover) 0%, #3A7CA5 100%);
            transform: translateY(-2px) scale(1.02);
            box-shadow: 0 6px 20px rgba(var(--primary-blue-rgb), 0.25);
        }

        .alert-info-custom {
            background-color: var(--accent-blue-light);
            border: 1px solid var(--accent-blue-border);
            color: var(--primary-blue);
        }

        hr {
            margin: 2.5rem 0;
            border-top: 1px solid #E2E8F0;
        }
    </style>
</head>

<body>
    <div class="container page-container">
        <div class="event-header-section">
            <h2 class="event-main-title">{{ $presence->nama_kegiatan }}</h2>
            <p class="event-meta-info">
                <span><strong>Tanggal Kegiatan:</strong>
                    @if($presence->datetime_mulai->isSameDay($presence->datetime_selesai))
                        {{ $presence->datetime_mulai->translatedFormat('d F Y') }}
                    @else
                        {{ $presence->datetime_mulai->translatedFormat('d M Y') }} -
                        {{ $presence->datetime_selesai->translatedFormat('d M Y') }}
                    @endif
                </span>
                <span class="separator d-none d-md-inline"></span>
                <span class="d-block d-md-inline"><strong>Waktu:</strong>
                    {{ $presence->datetime_mulai->format('H:i') }} - {{ $presence->datetime_selesai->format('H:i') }}
                    WIB</span>
            </p>
        </div>

        <div class="card main-form-card">
            <div class="card-header">
                <h5 class="mb-0">Formulir Kehadiran</h5>
            </div>
            <div class="card-body card-body-padded">
                @if(isset($identity_number) && $identity_number)
                    <div class="alert alert-info-custom mb-4" role="alert">
                        <div class="alert-content">Anda mengisi sebagai NIK: <strong>{{ $identity_number }}</strong></div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="form-absen" action="{{ route('absen.save', $presence) }}" method="post">
                    @csrf

                    <div class="alert alert-info-custom text-center mb-4">
                        Anda mengisi absensi untuk tanggal:
                        <strong>{{ \Carbon\Carbon::parse($tanggal_absensi)->translatedFormat('l, d F Y') }}</strong>
                    </div>
                    <input type="hidden" name="tanggal_absensi" value="{{ $tanggal_absensi }}">

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                                    name="nama" value="{{ old('nama', optional($lastSubmissionOverall)->nama) }}"
                                    required>
                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email', optional($lastSubmissionOverall)->email) }}"
                                    required>
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor HP (WhatsApp) <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp"
                                    name="no_hp" value="{{ old('no_hp', optional($lastSubmissionOverall)->no_hp) }}"
                                    required placeholder="Contoh: 08123456789">
                                @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="instansi" class="form-label">Instansi/Afiliasi <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('instansi') is-invalid @enderror"
                                    id="instansi" name="instansi"
                                    value="{{ old('instansi', optional($lastSubmissionOverall)->instansi) }}" required>
                                @error('instansi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="golongan" class="form-label">Golongan (Khusus PNS/ASN, jika ada)</label>
                                <input type="text" class="form-control @error('golongan') is-invalid @enderror"
                                    id="golongan" name="golongan"
                                    value="{{ old('golongan', optional($lastSubmissionOverall)->golongan) }}">
                                @error('golongan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_bank" class="form-label">Nama Bank <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_bank') is-invalid @enderror"
                                    id="nama_bank" name="nama_bank"
                                    value="{{ old('nama_bank', optional($lastSubmissionOverall)->nama_bank) }}"
                                    required>
                                @error('nama_bank') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="no_rekening" class="form-label">Nomor Rekening <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('no_rekening') is-invalid @enderror"
                                    id="no_rekening" name="no_rekening"
                                    value="{{ old('no_rekening', optional($lastSubmissionOverall)->no_rekening) }}"
                                    required onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                    placeholder="Hanya angka">
                                @error('no_rekening') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="atas_nama" class="form-label">Atas Nama (sesuai Rekening) <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('atas_nama') is-invalid @enderror"
                                    id="atas_nama" name="atas_nama"
                                    value="{{ old('atas_nama', optional($lastSubmissionOverall)->atas_nama) }}"
                                    required>
                                @error('atas_nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="npwp" class="form-label">NPWP (Nomor Pokok Wajib Pajak) <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('npwp') is-invalid @enderror" id="npwp"
                                    name="npwp" value="{{ old('npwp', optional($lastSubmissionOverall)->npwp) }}"
                                    required onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                    placeholder="Hanya angka, tanpa titik/strip">
                                @error('npwp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="signature-pad" class="form-label">Tanda Tangan <span
                                        class="text-danger">*</span></label>
                                <div class="signature-pad-container">
                                    <canvas id="signature-pad" style="width: 100%; height: 170px;"></canvas>
                                </div>

                                <textarea name="signature" id="signature64" style="display: none;"></textarea>

                                @error('signature') <div class="d-block invalid-feedback">{{ $message }}</div> @enderror
                                <div class="signature-tools" style="text-align: right; margin-top: 0.65rem;">
                                    <button type="button" id="clear-signature"
                                        class="btn btn-sm btn-outline-secondary">Bersihkan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-lg">Kirim Data Absensi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        $(function () {
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgba(255, 255, 255, 0)',
                penColor: 'rgb(0, 0, 0)'
            });

            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }
            window.addEventListener("resize", resizeCanvas);
            resizeCanvas();

            $('#clear-signature').on('click', function () {
                signaturePad.clear();
                $('#signature64').val('');
            });

            // Pastikan blok submit ini sudah benar
            $('#form-absen').on('submit', function (e) {
                // Validasi tanda tangan sekarang dilakukan oleh JavaScript
                if (signaturePad.isEmpty()) {
                    alert('Tanda tangan wajib diisi.');
                    e.preventDefault(); // Mencegah form untuk submit
                    return;
                }

                // Jika valid, simpan data dan nonaktifkan tombol
                $('#signature64').val(signaturePad.toDataURL());
                const button = $(this).find('button[type="submit"]');
                button.prop('disabled', true);
                button.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengirim Data...');
            });
        });
    </script>
</body>

</html>