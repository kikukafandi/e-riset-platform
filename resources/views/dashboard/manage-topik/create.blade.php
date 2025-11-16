@extends('dashboard.layouts.app')
@section('title', 'Tambah Topik Riset')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tambah Topik Riset</h1>
    {{-- Tampilkan error validasi jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
        </div>
    @endif
    <form action="{{ route('manage.topik.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Topik</label>
            <input type="text" name="nama_topik" class="form-control" value="{{ old('nama_topik') }}" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi (Opsional)</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('manage.topik.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection