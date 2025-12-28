@extends('dashboard.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <div class="card shadow-lg border-0 rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3">
                                <i class="fas fa-user-edit fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">Edit Profil Saya</h4>
                                <p class="mb-0 small text-white-50">Perbarui informasi akun dan data pribadi Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-5">

                        @if (session('success'))
                            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                                <i class="fas fa-check-circle me-2 fs-4"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                                <ul class="mb-0 ps-3 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-5 mb-4 mb-md-0 border-end-md">
                                    <h6 class="text-primary fw-bold mb-4"><i class="fas fa-lock me-2"></i>Informasi Login
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Email Address</label>
                                        <input type="email" name="email" class="form-control bg-light"
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>

                                    <div class="alert alert-warning border-0 shadow-sm rounded-3 small mt-4">
                                        <i class="fas fa-key me-1"></i> <strong>Ganti Password</strong>
                                        <br>Biarkan kosong jika tidak ingin mengganti password.
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Password Baru</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Minimal 6 karakter">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Ulangi password baru">
                                    </div>
                                </div>

                                <div class="col-md-7 ps-md-4">
                                    <h6 class="text-primary fw-bold mb-4"><i class="fas fa-id-card me-2"></i>Data Pribadi
                                    </h6>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control bg-light"
                                            value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                                    </div>

                                    <div class="row g-3 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">NIK</label>
                                            <input type="text" name="nik" class="form-control bg-light"
                                                value="{{ old('nik', $user->nik) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">No. Telepon</label>
                                            <input type="text" name="no_telepon" class="form-control bg-light"
                                                value="{{ old('no_telepon', $user->no_telepon) }}" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Alamat</label>
                                        <textarea name="alamat" class="form-control bg-light" rows="3">{{ old('alamat', $user->alamat) }}</textarea>
                                    </div>

                                    @if ($user->kategori == 'mahasiswa')
                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">NIM</label>
                                                <input type="text" name="nim" class="form-control bg-light"
                                                    value="{{ old('nim', $user->nim) }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Universitas/Kampus</label>
                                                <input type="text" name="kampus" class="form-control bg-light"
                                                    value="{{ old('kampus', $user->kampus) }}">
                                            </div>
                                        </div>
                                    @endif

                                    @if ($user->kategori == 'non-mahasiswa')
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Instansi / Lembaga</label>
                                            <input type="text" name="instansi" class="form-control bg-light"
                                                value="{{ old('instansi', $user->instansi) }}">
                                        </div>
                                    @endif

                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4 pt-3 border-top">
                                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }

        /* Garis pemisah vertikal hanya di layar medium ke atas */
        @media (min-width: 768px) {
            .border-end-md {
                border-right: 1px solid #dee2e6;
            }
        }
    </style>
@endsection
