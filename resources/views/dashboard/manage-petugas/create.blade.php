@extends('dashboard.layouts.app')

@section('title', 'Tambah Petugas')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Tambah Petugas</h1>

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
                    <option value="super_user">Super User</option>
                    <option value="pelaksana">Pelaksana</option>
                    <option value="eselon_iv">Eselon IV</option>
                    <option value="eselon_iii">Eselon III</option>
                    <option value="eselon_ii">Eselon II</option>
                </select>
            </div>


            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('manage.petugas') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
