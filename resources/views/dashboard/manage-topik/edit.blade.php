@extends('dashboard.layouts.app')
@section('title', 'Edit Topik Riset')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Topik Riset</h1>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul> @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
        </div>
    @endif
    <form action="{{ route('manage.topik.update', $topik->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Penting untuk edit --}}
        <div class="mb-3">
            <label>Nama Topik</label>
            <input type="text" name="nama_topik" class="form-control" value="{{ old('nama_topik', $topik->nama_topik) }}" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi (Opsional)</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $topik->deskripsi) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Perbarui</button>
        <a href="{{ route('manage.topik.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection