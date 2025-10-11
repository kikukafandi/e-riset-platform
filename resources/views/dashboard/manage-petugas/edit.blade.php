@extends('dashboard.layouts.app')

@section('title', 'Edit Petugas')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Petugas</h1>

        <form action="{{ route('manage.petugas.update', $petugas->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama', $petugas->nama) }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $petugas->email) }}"
                    required>
            </div>

            <div class="mb-3">
                <label>NIP</label>
                <input type="text" name="nip" class="form-control" value="{{ old('nip', $petugas->nip) }}" required>
            </div>

            <div class="mb-3">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $petugas->jabatan) }}"
                    required>
            </div>

            <div class="mb-3">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="super_user" {{ $petugas->role == 'super_user' ? 'selected' : '' }}>Super User</option>
                    <option value="pelaksana" {{ $petugas->role == 'pelaksana' ? 'selected' : '' }}>Pelaksana</option>
                    <option value="eselon_iv" {{ $petugas->role == 'eselon_iv' ? 'selected' : '' }}>Eselon IV</option>
                    <option value="eselon_iii" {{ $petugas->role == 'eselon_iii' ? 'selected' : '' }}>Eselon III</option>
                    <option value="eselon_ii" {{ $petugas->role == 'eselon_ii' ? 'selected' : '' }}>Eselon II</option>
                </select>
            </div>


            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('manage.petugas') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
