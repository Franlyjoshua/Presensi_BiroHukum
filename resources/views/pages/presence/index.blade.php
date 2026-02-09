@extends('layouts.main')

@section('title', 'Manajemen Daftar Kegiatan Presensi')

@section('content')
    <div class="container my-4 py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Manajemen Daftar Kegiatan Presensi <u>Biro Hukum</u></h2>
            <a href="{{ route('admin.presence.create') }}" class="btn btn-primary shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-plus-circle-fill me-2" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                </svg>
                Tambah Kegiatan Baru
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Data Kegiatan</h5>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;" class="text-center">No.</th>
                                <th>Nama Kegiatan</th>
                                <th style="width: 25%;">Periode Kegiatan</th>
                                <th style="width: 10%;" class="text-center">Status Link</th>
                                <th class="text-center" style="width: 28%;">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($presences as $presence)
                                <tr>
                                    <td class="text-center">
                                        {{-- PERUBAHAN DI SINI: --}}
                                        {{-- Rumus ini membuat nomor urut 1, 2, 3... berurutan ke bawah --}}
                                        {{ ($presences->currentPage() - 1) * $presences->perPage() + $loop->iteration }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.presence.show', $presence->id) }}"
                                            class="text-decoration-none fw-bold">{{ $presence->nama_kegiatan }}</a>
                                    </td>
                                    <td>
                                        <div class="fw-bold">
                                            @if($presence->datetime_mulai->isSameDay($presence->datetime_selesai))
                                                {{ $presence->datetime_mulai->translatedFormat('d F Y') }}
                                            @else
                                                {{ $presence->datetime_mulai->translatedFormat('d M Y') }} s/d
                                                {{ $presence->datetime_selesai->translatedFormat('d M Y') }}
                                            @endif
                                        </div>
                                        <small class="text-muted">{{ $presence->datetime_mulai->format('H:i') }} -
                                            {{ $presence->datetime_selesai->format('H:i') }} WIB</small>
                                    </td>
                                    <td class="text-center">
                                        @if($presence->is_link_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Ditutup</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.presence.show', $presence->id) }}"
                                            class="btn btn-outline-info btn-sm mb-1" title="Lihat Detail">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-eye-fill" viewBox="0 0 16 16">
                                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                                                <path
                                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                                            </svg>
                                            <span class="d-none d-md-inline">Detail</span>
                                        </a>
                                        <a href="{{ route('admin.presence.edit', $presence->id) }}"
                                            class="btn btn-outline-warning btn-sm mb-1" title="Edit Kegiatan">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                                class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                            </svg>
                                            <span class="d-none d-md-inline">Edit</span>
                                        </a>
                                        <form action="{{ route('admin.presence.toggle-link', $presence->id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm {{ $presence->is_link_active ? 'btn-outline-secondary' : 'btn-outline-success' }} mb-1"
                                                title="{{ $presence->is_link_active ? 'Tutup Link Ini' : 'Aktifkan Link Ini' }}">
                                                @if($presence->is_link_active)
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2" />
                                                    </svg> <span class="d-none d-md-inline">Tutup</span>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                        fill="currentColor" class="bi bi-unlock-fill" viewBox="0 0 16 16">
                                                        <path
                                                            d="M11 1a2 2 0 0 0-2 2v4a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h5V3a3 3 0 0 1 6 0v4a.5.5 0 0 1-1 0V3a2 2 0 0 0-2-2" />
                                                    </svg> <span class="d-none d-md-inline">Aktifkan</span>
                                                @endif
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.presence.destroy', $presence->id) }}" method="post"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm mb-1"
                                                onclick="return confirm('Yakin ingin menghapus kegiatan ini beserta semua data absensinya?')"
                                                title="Hapus Kegiatan">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                    <path
                                                        d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                                </svg> <span class="d-none d-md-inline">Hapus</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                            class="bi bi-info-circle-fill text-muted mb-2" viewBox="0 0 16 16">
                                            <path
                                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                        </svg>
                                        <p class="mb-0">Belum ada data kegiatan yang tersedia.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-3">
                    {{ $presences->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- Tidak ada JS yang dibutuhkan untuk perbaikan ini --}}
@endpush