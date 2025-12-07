@extends('auth.layouts.app')
@section('title', 'Register Petugas')
@section('content')
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header">
                            <h3 class="text-center font-weight-light my-4">Registrasi Petugas</h3>
                        </div>
                        <div class="card-body">

                            {{-- Pesan sukses --}}
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            {{-- Pesan error umum --}}
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            {{-- Pesan error dari validasi --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('register.petugas') }}" method="POST">
                                @csrf
                                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputNama" type="text" name="nama"
                                                placeholder="Nama Lengkap" value="{{ old('nama') }}" required />
                                            <label for="inputNama">Nama Lengkap</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" id="inputNIP" type="text" name="nip"
                                                placeholder="NIP" value="{{ old('nip') }}" required />
                                            <label for="inputNIP">NIP</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputEmail" type="email" name="email"
                                        placeholder="name@example.com" value="{{ old('email') }}" required />
                                    <label for="inputEmail">Email</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputJabatan" type="text" name="jabatan"
                                        placeholder="Jabatan" value="{{ old('jabatan') }}" required />
                                    <label for="inputJabatan">Jabatan</label>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <select class="form-select" id="inputRole" name="role" required>
                                                <option value="">-- Pilih Role --</option>
                                                <option value="pelaksana" {{ old('role') == 'pelaksana' ? 'selected' : '' }}>Pelaksana</option>
                                                <option value="eselon_iv" {{ old('role') == 'eselon_iv' ? 'selected' : '' }}>Eselon IV</option>
                                                <option value="eselon_iii" {{ old('role') == 'eselon_iii' ? 'selected' : '' }}>Eselon III</option>
                                                <option value="eselon_ii" {{ old('role') == 'eselon_ii' ? 'selected' : '' }}>Eselon II</option>
                                            </select>
                                            <label for="inputRole">Role</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select" id="inputKantor" name="kantor_id" required>
                                                <option value="">-- Pilih Kantor --</option>
                                                @foreach($kantorList as $kantor)
                                                    <option value="{{ $kantor->id }}" {{ old('kantor_id') == $kantor->id ? 'selected' : '' }}>
                                                        {{ $kantor->nama_kantor }} ({{ strtoupper($kantor->jenis_kantor) }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <label for="inputKantor">Kantor</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3 mb-md-0">
                                            <input class="form-control" id="inputPassword" type="password" name="password"
                                                placeholder="Password" required />
                                            <label for="inputPassword">Password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input class="form-control" id="inputPasswordConfirmation" type="password"
                                                name="password_confirmation" placeholder="Konfirmasi Password" required />
                                            <label for="inputPasswordConfirmation">Konfirmasi Password</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <button class="btn btn-primary btn-block" type="submit">Daftar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center py-3">
                            <div class="small">
                                Sudah punya akun? <a href="{{ route('login.petugas.view') }}">Login disini!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
