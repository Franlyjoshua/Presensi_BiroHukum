@extends('layouts.main')

@section('content')
    <div class="container my-4">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h4 class="card-title">
                            Tambah Kegiatan
                        </h4>
                    </div>
                    <div class="col text-end">
                        {{-- Menggunakan nama rute admin --}}
                        <a href="{{ route('admin.presence.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                {{-- Menggunakan nama rute admin --}}
                <form action="{{ route('admin.presence.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kegiatan" class="form-label">Nama kegiatan</label>
                        <input type="text" class="form-control @error('nama_kegiatan') is-invalid @enderror"
                            name="nama_kegiatan" id="nama_kegiatan" value="{{ old('nama_kegiatan') }}">
                        @error('nama_kegiatan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- BARIS-BARIS BERIKUT DIUBAH DAN DITAMBAHKAN --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_mulai_kegiatan" class="form-label">Tanggal Mulai Kegiatan</label> {{--
                                Label diubah --}}
                                <input type="date"
                                    class="form-control @error('tanggal_mulai_kegiatan') is-invalid @enderror"
                                    name="tanggal_mulai_kegiatan" id="tanggal_mulai_kegiatan"
                                    value="{{ old('tanggal_mulai_kegiatan') }}"> {{-- Atribut 'name' diubah --}}
                                @error('tanggal_mulai_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                <input type="time" class="form-control @error('waktu_mulai') is-invalid @enderror"
                                    name="waktu_mulai" id="waktu_mulai" value="{{ old('waktu_mulai') }}">
                                @error('waktu_mulai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_selesai_kegiatan" class="form-label">Tanggal Selesai Kegiatan</label>
                                {{-- Field BARU --}}
                                <input type="date"
                                    class="form-control @error('tanggal_selesai_kegiatan') is-invalid @enderror"
                                    name="tanggal_selesai_kegiatan" id="tanggal_selesai_kegiatan"
                                    value="{{ old('tanggal_selesai_kegiatan') }}">
                                @error('tanggal_selesai_kegiatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="waktu_selesai" class="form-label">Waktu Selesai</label> {{-- Field BARU --}}
                                <input type="time" class="form-control @error('waktu_selesai') is-invalid @enderror"
                                    name="waktu_selesai" id="waktu_selesai" value="{{ old('waktu_selesai') }}">
                                @error('waktu_selesai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    {{-- AKHIR DARI BARIS YANG DIUBAH DAN DITAMBAHKAN --}}

                    <button type="submit" class="btn btn-primary">
                        Simpan Data
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection