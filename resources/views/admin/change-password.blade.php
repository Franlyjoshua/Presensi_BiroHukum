@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Ganti Password Admin</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Perubahan Password</h6>
                    </div>
                    <div class="card-body">

                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.password.update') }}">
                            @csrf

                            <div class="form-group">
                                <label for="current_password">Password Lama</label>
                                <input type="password" name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <hr>

                            <div class="form-group">
                                <label for="new_password">Password Baru</label>
                                <input type="password" name="new_password"
                                    class="form-control @error('new_password') is-invalid @enderror" required>
                                <small class="form-text text-muted">Minimal 8 karakter.</small>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="new_password_confirmation">Ulangi Password Baru</label>
                                <input type="password" name="new_password_confirmation" class="form-control" required>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save fa-sm text-white-50 mr-2"></i> Simpan Password Baru
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection