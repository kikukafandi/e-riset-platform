@extends('dashboard.layouts.app')

@section('title', 'Tambah Petugas')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Tambah Petugas</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('manage.petugas.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label>NIP</label>
                <input type="text" name="nip" class="form-control" value="{{ old('nip') }}" required>
            </div>

            <div class="mb-3">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="super_user" {{ old('role') == 'super_user' ? 'selected' : '' }}>Super User</option>
                    <option value="pelaksana" {{ old('role') == 'pelaksana' ? 'selected' : '' }}>Pelaksana</option>
                    <option value="eselon_iv" {{ old('role') == 'eselon_iv' ? 'selected' : '' }}>Eselon IV</option>
                    <option value="eselon_iii" {{ old('role') == 'eselon_iii' ? 'selected' : '' }}>Eselon III</option>
                    <option value="eselon_ii" {{ old('role') == 'eselon_ii' ? 'selected' : '' }}>Eselon II</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Kantor</label>
                <select name="kantor_id" class="form-control">
                    <option value="">-- Pilih Kantor (Opsional untuk Super User) --</option>
                    @foreach($kantorList as $kantor)
                        <option value="{{ $kantor->id }}" {{ old('kantor_id') == $kantor->id ? 'selected' : '' }}>
                            {{ $kantor->nama_kantor }} ({{ strtoupper($kantor->jenis_kantor) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Password (Kosongkan untuk default: password123)</label>
                <input type="password" name="password" class="form-control" minlength="8">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('manage.petugas') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
