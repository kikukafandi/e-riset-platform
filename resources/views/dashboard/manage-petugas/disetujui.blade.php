@extends('dashboard.layouts.app')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Permohonan Disetujui</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{-- route('dashboard.petugas') --}}">Dashboard Petugas</a></li>
                <li class="breadcrumb-item active">Permohonan Disetujui</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Daftar Permohonan Disetujui
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
                                <td>Siti Aisyah</td>
                                <td>2000000002</td>
                                <td>Permohonan Data</td>
                                <td><span class="badge bg-success">Disetujui</span></td>
                                                                <td><span class="badge bg-success">{{ App\Helpers\ResearchStatus::APPROVED ? 'Disetujui' : '' }}</span></td>
                                <td>2025/09/21</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-success btn-sm" title="Cetak Surat">
                                        <i class="fas fa-print"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Dewi Lestari</td>
                                <td>4000000004</td>
                                <td>Izin Wawancara Narasumber</td>
                                <td><span class="badge bg-success">Disetujui</span></td>
                                <td>2025/09/23</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#" class="btn btn-success btn-sm" title="Cetak Surat">
                                        <i class="fas fa-print"></i>
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
