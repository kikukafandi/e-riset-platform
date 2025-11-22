@extends('dashboard.layouts.app')
@section('title', 'Tambah Kantor Bea Cukai')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Kantor Bea Cukai</h1>
    
    {{-- Tampilkan error validasi jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('manage.kantor.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama_kantor" class="form-label">Nama Kantor <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kantor" id="nama_kantor" class="form-control @error('nama_kantor') is-invalid @enderror" value="{{ old('nama_kantor') }}" required>
                            @error('nama_kantor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kode_kantor" class="form-label">Kode Kantor <span class="text-danger">*</span></label>
                            <input type="text" name="kode_kantor" id="kode_kantor" class="form-control @error('kode_kantor') is-invalid @enderror" value="{{ old('kode_kantor') }}" placeholder="contoh: JKT001" required>
                            @error('kode_kantor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="jenis_kantor" class="form-label">Jenis Kantor <span class="text-danger">*</span></label>
                            <select name="jenis_kantor" id="jenis_kantor" class="form-control @error('jenis_kantor') is-invalid @enderror" required>
                                <option value="">Pilih Jenis Kantor</option>
                                <option value="kanwil" {{ old('jenis_kantor') == 'kanwil' ? 'selected' : '' }}>Kanwil</option>
                                <option value="kppbc" {{ old('jenis_kantor') == 'kppbc' ? 'selected' : '' }}>KPPBC</option>
                                <option value="kpu" {{ old('jenis_kantor') == 'kpu' ? 'selected' : '' }}>KPU</option>
                            </select>
                            @error('jenis_kantor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="provinsi" class="form-label">Provinsi <span class="text-danger">*</span></label>
                            <input type="text" name="provinsi" id="provinsi" class="form-control @error('provinsi') is-invalid @enderror" value="{{ old('provinsi') }}" required>
                            @error('provinsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="kota" class="form-label">Kota <span class="text-danger">*</span></label>
                            <input type="text" name="kota" id="kota" class="form-control @error('kota') is-invalid @enderror" value="{{ old('kota') }}" required>
                            @error('kota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="1">
                        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">
                            Kantor Aktif
                        </label>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('manage.kantor.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection