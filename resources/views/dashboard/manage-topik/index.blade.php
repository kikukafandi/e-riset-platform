@extends('dashboard.layouts.app')
@section('title', 'Manage Topik Riset')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manage Topik Riset</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('manage.topik.create') }}" class="btn btn-primary mb-3">Tambah Topik</a>
    <table class="table table-bordered">
        <thead> <tr> <th>#</th> <th>Nama Topik</th> <th>Deskripsi</th> <th>Aksi</th> </tr> </thead>
        <tbody>
            @forelse($topikRiset as $topik)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $topik->nama_topik }}</td>
                    <td>{{ $topik->deskripsi ?? '-' }}</td>
                    <td>
                        <a href="{{ route('manage.topik.edit', $topik->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('manage.topik.destroy', $topik->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus topik ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr> <td colspan="4" class="text-center">Belum ada topik riset</td> </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection