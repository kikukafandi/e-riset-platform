@extends('dashboard.layouts.app')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Permohonan Ditolak</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{-- route('dashboard.petugas') --}}">Dashboard Petugas</a></li>
                <li class="breadcrumb-item active">Permohonan Ditolak</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Daftar Permohonan Ditolak
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Nama Pemohon</th>
                                <th>NIP/NIM</th>
                                <th>Judul Permohonan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama Pemohon</th>
                                <th>NIP/NIM</th>
                                <th>Judul Permohonan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            {{-- Data Sampel --}}
                            <tr>
                                <td>Budi Santoso</td>
                                <td>3000000003</td>
                                <td>Surat Observasi</td>
                                <td><span class="badge bg-danger">Ditolak</span></td>
                                <td>2025/09/22</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm" title="Lihat Detail Alasan">
                                        <i class="fas fa-eye"></i> Lihat Alasan
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
