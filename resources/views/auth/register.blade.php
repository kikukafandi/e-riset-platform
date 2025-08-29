@extends('auth.layouts.app')
@section('title', 'Register')
@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header text-center">
                        <h3 class="font-weight-light my-4">Pilih Status Anda</h3>
                        <ul class="nav nav-tabs justify-content-center" id="registerTab" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" id="mahasiswa-tab" data-bs-toggle="tab" data-bs-target="#mahasiswa" type="button" role="tab">Mahasiswa</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" id="nonmahasiswa-tab" data-bs-toggle="tab" data-bs-target="#nonmahasiswa" type="button" role="tab">Non Mahasiswa</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="registerTabContent">

                            {{-- FORM MAHASISWA --}}
                            <div class="tab-pane fade show active" id="mahasiswa" role="tabpanel" aria-labelledby="mahasiswa-tab">
                                <form action="{{ route('register') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="kategori" value="mahasiswa">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" placeholder="Nama Lengkap" value="{{ old('nama_lengkap') }}">
                                        <label>Nama Lengkap</label>
                                        @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" placeholder="Nomor NIK" value="{{ old('nik') }}">
                                        <label>Nomor NIK</label>
                                        @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}">
                                        <label>Email</label>
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon" placeholder="Nomor Handphone" value="{{ old('no_telepon') }}">
                                        <label>Nomor Handphone</label>
                                        @error('no_telepon') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" placeholder="Alamat">{{ old('alamat') }}</textarea>
                                        <label>Alamat</label>
                                        @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('jurusan') is-invalid @enderror" name="jurusan" placeholder="Jurusan" value="{{ old('jurusan') }}">
                                        <label>Jurusan</label>
                                        @error('jurusan') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('nim') is-invalid @enderror" name="nim" placeholder="NIM" value="{{ old('nim') }}">
                                        <label>Nomor Induk Mahasiswa</label>
                                        @error('nim') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select class="form-select @error('jenjang') is-invalid @enderror" name="jenjang">
                                            <option value="">Pilih Jenjang Pendidikan</option>
                                            <option value="D1">D1</option>
                                            <option value="D2">D2</option>
                                            <option value="D3">D3</option>
                                            <option value="S1">D4/S1</option>
                                            <option value="S2">S2</option>
                                            <option value="S3">S3</option>
                                        </select>
                                        <label>Jenjang Pendidikan</label>
                                        @error('jenjang') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('kampus') is-invalid @enderror" name="kampus" placeholder="Universitas" value="{{ old('kampus') }}">
                                        <label>Universitas</label>
                                        @error('kampus') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                                        <label>Password</label>
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Konfirmasi Password">
                                        <label>Konfirmasi Password</label>
                                        @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <button class="btn btn-primary w-100" type="submit">Submit</button>
                                </form>
                            </div>

                            {{-- FORM NON MAHASISWA --}}
                            <div class="tab-pane fade" id="nonmahasiswa" role="tabpanel" aria-labelledby="nonmahasiswa-tab">
                                <form action="{{ route('register') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="kategori" value="non-mahasiswa">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" name="nama_lengkap" placeholder="Nama Lengkap" value="{{ old('nama_lengkap') }}">
                                        <label>Nama Lengkap</label>
                                        @error('nama_lengkap') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" placeholder="Nomor NIK" value="{{ old('nik') }}">
                                        <label>Nomor NIK</label>
                                        @error('nik') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('npwp') is-invalid @enderror" name="npwp" placeholder="NPWP" value="{{ old('npwp') }}">
                                        <label>NPWP</label>
                                        @error('npwp') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('no_telepon') is-invalid @enderror" name="no_telepon" placeholder="Nomor Handphone" value="{{ old('no_telepon') }}">
                                        <label>Nomor Handphone</label>
                                        @error('no_telepon') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <textarea class="form-control @error('alamat') is-invalid @enderror" name="alamat" placeholder="Alamat">{{ old('alamat') }}</textarea>
                                        <label>Alamat</label>
                                        @error('alamat') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('instansi') is-invalid @enderror" name="instansi" placeholder="Instansi" value="{{ old('instansi') }}">
                                        <label>Instansi</label>
                                        @error('instansi') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('sponsor_riset') is-invalid @enderror" name="sponsor_riset" placeholder="Sponsor Riset" value="{{ old('sponsor_riset') }}">
                                        <label>Sponsor Riset</label>
                                        @error('sponsor_riset') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email" value="{{ old('email') }}">
                                        <label>Email</label>
                                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                                        <label>Password</label>
                                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Konfirmasi Password">
                                        <label>Konfirmasi Password</label>
                                        @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>

                                    <button class="btn btn-primary w-100" type="submit">Submit</button>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="{{ route('loginPage') }}">Sudah punya akun? Login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
