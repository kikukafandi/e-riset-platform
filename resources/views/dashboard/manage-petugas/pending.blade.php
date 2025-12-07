@extends('dashboard.layouts.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Permohonan Pending</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{-- route('dashboard.petugas') --}}">Dashboard Petugas</a></li>
            <li class="breadcrumb-item active">Permohonan Pending</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Daftar Permohonan Pending
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
                                    @php
                                        use App\Helpers\ResearchStatus;
                                        $statusLabels = [
                                            ResearchStatus::SUBMITTED => 'Diajukan',
                                            ResearchStatus::VERIFIED_DOCUMENTS => 'Verifikasi Dokumen',
                                            ResearchStatus::VERIFIED_THEME => 'Verifikasi Topik',
                                            ResearchStatus::CONFIRMED_DATA_NARASUMBER => 'Konfirmasi Data/Narasumber',
                                            ResearchStatus::APPROVED => 'Disetujui',
                                            ResearchStatus::RESEARCH_PERIOD => 'Periode Riset',
                                            ResearchStatus::SUBMITTED_PAPER => 'Paper Dikirim',
                                            ResearchStatus::COMPLETED => 'Selesai',
                                        ];
                                        $badgeClass = 'bg-warning text-dark';
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $statusLabels[ResearchStatus::SUBMITTED] }}</span>
                                </td>
                                <td class="text-center">2025/09/20</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-info" title="Verifikasi Permohonan">
                                        <i class="fas fa-check-circle"></i> Verifikasi
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Rian Hidayat</td>
                                <td>5000000005</td>
                                <td>Permohonan Data Internal</td>
                                <td class="text-center">
                                    <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                                </td>
                                <td class="text-center">2025/09/24</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-outline-info" title="Verifikasi Permohonan">
                                        <i class="fas fa-check-circle"></i> Verifikasi
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
