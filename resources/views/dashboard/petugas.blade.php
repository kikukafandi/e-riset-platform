@extends('dashboard.layouts.app')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard Petugas</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard Petugas</li>
            </ol>
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">Total Permohonan</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('permohonan.total')}}">Lihat Detail</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Permohonan Pending</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('permohonan.pending')}}">Lihat Detail</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Permohonan Disetujui</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('permohonan.disetujui')}}">Lihat Detail</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">Permohonan Ditolak</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="{{ route('permohonan.ditolak')}}">Lihat Detail</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Chart Section --}}
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Statistik Permohonan
                        </div>
                        <div class="card-body"><canvas id="petugasAreaChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Distribusi Permohonan
                        </div>
                        <div class="card-body"><canvas id="petugasBarChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div>

            {{-- Data Table Section --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Daftar Permohonan Terbaru
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
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Nama Pemohon</th>
                                <th>NIP/NIM</th>
                                <th>Judul Permohonan</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>Andi Pratama</td>
                                <td>1000000001</td>
                                <td>Surat Izin Penelitian</td>
                                <td><span class="badge bg-warning">Pending</span></td>
                                <td>2025/09/20</td>
                            </tr>
                            <tr>
                                <td>Siti Aisyah</td>
                                <td>2000000002</td>
                                <td>Permohonan Data</td>
                                <td><span class="badge bg-success">Disetujui</span></td>
                                <td>2025/09/21</td>
                            </tr>
                            <tr>
                                <td>Budi Santoso</td>
                                <td>3000000003</td>
                                <td>Surat Observasi</td>
                                <td><span class="badge bg-danger">Ditolak</span></td>
                                <td>2025/09/22</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection