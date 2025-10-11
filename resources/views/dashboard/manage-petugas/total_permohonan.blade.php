@extends('dashboard.layouts.app')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Total Permohonan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{-- route('dashboard.petugas') --}}">Dashboard Petugas</a></li>
                <li class="breadcrumb-item active">Total Permohonan</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Semua Daftar Permohonan
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatablesSimple" class="table table-striped table-hover table-bordered align-middle">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>Nama Pemohon</th>
                                    <th>NIP/NIM</th>
                                    <th>Judul Permohonan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Data Sampel --}}
                                <tr>
                                    <td>Andi Pratama</td>
                                    <td>1000000001</td>
                                    <td>Surat Izin Penelitian</td>
                                    <td class="text-center">
                                        <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                    </td>
                                    <td class="text-center">2025/09/20</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Siti Aisyah</td>
                                    <td>2000000002</td>
                                    <td>Permohonan Data</td>
                                    <td class="text-center">
                                        <span class="badge bg-success px-3 py-2">Disetujui</span>
                                    </td>
                                    <td class="text-center">2025/09/21</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Budi Santoso</td>
                                    <td>3000000003</td>
                                    <td>Surat Observasi</td>
                                    <td class="text-center">
                                        <span class="badge bg-danger px-3 py-2">Ditolak</span>
                                    </td>
                                    <td class="text-center">2025/09/22</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Dewi Lestari</td>
                                    <td>4000000004</td>
                                    <td>Izin Wawancara Narasumber</td>
                                    <td class="text-center">
                                        <span class="badge bg-success px-3 py-2">Disetujui</span>
                                    </td>
                                    <td class="text-center">2025/09/23</td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="table-light text-center">
                                <tr>
                                    <th>Nama Pemohon</th>
                                    <th>NIP/NIM</th>
                                    <th>Judul Permohonan</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
