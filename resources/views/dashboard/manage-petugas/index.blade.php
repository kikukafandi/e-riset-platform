@extends('dashboard.layouts.app')

@section('title', 'Manage Petugas')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Manage Petugas</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('manage.petugas.create') }}" class="btn btn-primary mb-3">Tambah Petugas</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($petugas as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->nip }}</td>
                        <td>{{ $p->jabatan }}</td>
                        <td>{{ $p->role }}</td>
                        <td>
                            <a href="{{ route('manage.petugas.edit', $p->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('manage.petugas.destroy', $p->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada petugas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
