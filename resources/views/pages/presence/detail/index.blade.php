@extends('layouts.main')

@section('title', 'Detail Absen: ' . $presence->nama_kegiatan)

@push('css')
    <style>
        /* Mengatur panel informasi */
        .info-panel dt {
            font-weight: 600;
            /* Label sedikit tebal */
            width: 180px;
            color: #495057;
            /* Warna abu-abu gelap untuk label */
        }

        .info-panel dd {
            margin-bottom: .75rem;
            /* Jarak antar baris sedikit lebih besar */
        }

        .input-group-text {
            background-color: #e9ecef;
        }

        /* Membuat semua teks di dalam tabel dan panel utama lebih gelap dan tegas */
        .card-body,
        .table {
            color: #212529;
            /* Warna teks hitam standar bootstrap */
            font-weight: 400;
            /* Berat font normal */
        }

        /* Kelas untuk membuat teks semi-tebal */
        .fw-semibold {
            font-weight: 600 !important;
        }
    </style>
@endpush

@section('content')
    <div class="container my-4 py-3">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <h2 class="mb-0 fw-bold">Detail Absen: {{ $presence->nama_kegiatan }}</h2>
            <a href="{{ route('admin.presence.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left-circle me-1"></i>Kembali ke Daftar
            </a>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <h5 class="mb-0 fw-bold"><i class="bi bi-info-circle-fill me-2"></i>Detail & Link Kegiatan</h5>
            </div>
            <div class="card-body">
                <h6 class="fw-bold text-dark">Informasi Kegiatan</h6>
                <dl class="row mb-4 info-panel">
                    <dt class="col-sm-3">Tanggal Pelaksanaan</dt>
                    <dd class="col-sm-9 fw-bold text-dark">:
                        @if($presence->datetime_mulai->isSameDay($presence->datetime_selesai))
                            {{ $presence->datetime_mulai->translatedFormat('d F Y') }}
                        @else
                            {{ $presence->datetime_mulai->translatedFormat('d M Y') }} s/d {{ $presence->datetime_selesai->translatedFormat('d M Y') }}
                        @endif
                    </dd>
                    <dt class="col-sm-3">Jam</dt>
                    <dd class="col-sm-9 fw-bold text-dark">: {{ $presence->datetime_mulai->format('H:i') }} - {{ $presence->datetime_selesai->format('H:i') }} WIB</dd>
                    <dt class="col-sm-3">Status Link</dt>
                    <dd class="col-sm-9">:
                        @if($presence->is_link_active)
                            <span class="badge bg-success fs-6">Aktif</span>
                        @else
                            <span class="badge bg-danger fs-6">Ditutup</span>
                        @endif
                    </dd>
                </dl>
                <hr>
                <h6 class="fw-bold text-dark mt-4">Link Absensi Peserta</h6>
                <div class="row g-3 mt-1">
                    <div class="col-lg-6">
                        <label for="globalLinkInput" class="form-label">Link Global (Absen Hari Ini)</label>
                        <div class="input-group">
                            <input type="text" id="globalLinkInput" class="form-control" value="{{ $globalLink }}" readonly>
                            <button class="btn btn-outline-primary copy-btn" data-clipboard-target="#globalLinkInput" title="Salin Link Global">Copy</button>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <label for="multiDayLinkInput" class="form-label">Link Multi-Hari (Peserta Pilih Tanggal)</label>
                        <div class="input-group">
                            {{-- ================================================================= --}}
                            {{-- --- PERBAIKAN DI SINI --- --}}
                            {{-- Menggunakan variabel $multiDayLink sesuai dengan yang dikirim dari controller --}}
                            {{-- ================================================================= --}}
                            <input type="text" id="multiDayLinkInput" class="form-control" value="{{ $multiDayLink }}" readonly>
                            <button class="btn btn-primary copy-btn" data-clipboard-target="#multiDayLinkInput" title="Salin Link Multi-Hari">Copy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="mb-0 fw-bold">Daftar Peserta Hadir</h5>
                    @if(isset($eventDates) && count($eventDates) > 1)
                        <form id="dateFilterForm" method="GET" action="{{ url()->current() }}">
                            <select name="view_date" id="view_date_select" class="form-select form-select-sm" onchange="this.form.submit()">
                                @foreach ($eventDates as $date)
                                    <option value="{{ $date }}" {{ $selectedDate == $date ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    @endif
                </div>
                <a href="{{ route('admin.presence-detail.export-pdf', ['id' => $presence->id, 'export_date' => $selectedDate]) }}" id="exportPdfLink" target="_blank" class="btn btn-danger btn-sm">
                    <i class="bi bi-file-earmark-pdf-fill me-1"></i>Export PDF ({{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d M') }})
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable-detail" class="table table-striped table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Waktu Absen</th>
                                <th>Nama</th>
                                <th>Email & No. Hp</th>
                                <th>Instansi</th>
                                <th class="text-center">Tanda Tangan</th>
                                <th class="text-center">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($presenceDetails as $detail)
                                <tr>
                                    <td class="fw-semibold">{{ $loop->iteration }}</td>
                                    <td class="fw-semibold">{{ $detail->created_at->translatedFormat('d M Y, H:i') }}</td>
                                    <td class="fw-bold text-dark">{{ $detail->nama }}</td>
                                    <td>{{ $detail->email }}<br><small class="text-muted">{{ $detail->no_hp }}</small></td>
                                    <td class="fw-semibold">{{ $detail->instansi }}</td>
                                    <td class="text-center">
                                        @if ($detail->tanda_tangan)
                                            <img src="{{ Storage::disk('public_uploads')->url($detail->tanda_tangan) }}" alt="TTD"
                                                class="img-thumbnail" style="max-height: 40px;">
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('admin.presence-detail.destroy', $detail->id) }}" method="post"
                                            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm d-inline-flex align-items-center"
                                                title="Hapus Data Absensi">
                                                <i class="bi bi-trash3-fill me-1"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">Belum ada data absensi untuk tanggal ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var clipboard = new ClipboardJS('.copy-btn');
            clipboard.on('success', function (e) {
                var originalText = e.trigger.innerHTML;
                e.trigger.innerHTML = 'Disalin!';
                e.trigger.classList.add('btn-success');
                setTimeout(() => {
                    e.trigger.innerHTML = originalText;
                    e.trigger.classList.remove('btn-success');
                }, 2000);
                e.clearSelection();
            });
        });
    </script>
@endpush
