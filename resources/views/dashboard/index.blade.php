@extends('dashboard.layouts.app')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt me-1"></i>
                    Data Permohonan Riset
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Riset</th>
                                <th>Nama Pemohon</th>
                                <th>Instansi</th>
                                <th>Jenis Permohonan Data</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permohonans as $index => $permohonan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $permohonan->judul_riset }}</td>
                                    <td>{{ $permohonan->user->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $permohonan->user->instansi ?? '-' }}</td>
                                    <td>{{ Str::limit($permohonan->jenis_permohonan_data, 50) }}</td>
                                    <td>
                                        @switch($permohonan->status)
                                            @case('dokumen_tidak_lengkap')
                                                <span class="badge bg-danger">Tidak Lengkap</span>
                                            @break

                                            @case('ditolak')
                                                <span class="badge bg-secondary">Ditolak</span>
                                            @break

                                            @case('diproses')
                                                <span class="badge bg-warning text-dark">Diproses</span>
                                            @break

                                            @case('diterima')
                                                <span class="badge bg-success">Diterima</span>
                                            @break

                                            @default
                                                <span class="badge bg-light text-dark">Unknown</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $permohonan->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('dokumen.show', $permohonan->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('dokumen.edit', $permohonan->id) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('dokumen.destroy', $permohonan->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin hapus data ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
@endsection
