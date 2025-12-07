@extends('dashboard.layouts.app')

@section('title', 'Edit Petugas')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit Petugas</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                    <option value="super_user" {{ old('role', $petugas->role) == 'super_user' ? 'selected' : '' }}>Super User</option>
                    <option value="pelaksana" {{ old('role', $petugas->role) == 'pelaksana' ? 'selected' : '' }}>Pelaksana</option>
                    <option value="eselon_iv" {{ old('role', $petugas->role) == 'eselon_iv' ? 'selected' : '' }}>Eselon IV</option>
                    <option value="eselon_iii" {{ old('role', $petugas->role) == 'eselon_iii' ? 'selected' : '' }}>Eselon III</option>
                    <option value="eselon_ii" {{ old('role', $petugas->role) == 'eselon_ii' ? 'selected' : '' }}>Eselon II</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Kantor</label>
                <select name="kantor_id" class="form-control">
                    <option value="">-- Pilih Kantor (Opsional untuk Super User) --</option>
                    @foreach($kantorList as $kantor)
                        <option value="{{ $kantor->id }}" {{ old('kantor_id', $petugas->kantor_id) == $kantor->id ? 'selected' : '' }}>
                            {{ $kantor->nama_kantor }} ({{ strtoupper($kantor->jenis_kantor) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" id="isActive" value="1"
                        {{ old('is_active', $petugas->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActive">
                        Akun Aktif
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label>Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" class="form-control" minlength="8">
            </div>

            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('manage.petugas') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
