@extends('dashboard.layouts.app')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Status Permohonan</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('petugas.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Status Permohonan</li>
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-clipboard-list me-1"></i> Daftar Status Permohonan
                </div>
                <div class="card-body">
                    <table id="statusTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Riset</th>
                                <th>Nama Pemohon</th>
                                <th>Instansi</th>
                                <th>Jenis Permohonan</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permohonans as $key => $permohonan)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $permohonan->judul_riset }}</td>
                                    <td>{{ $permohonan->user->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $permohonan->user->instansi ?? '-' }}</td>
                                    <td>{{ $permohonan->jenis_permohonan_data }}</td>
                                    <td>
                                        @php
                                            $statusClass = match($permohonan->status) {
                                                'diproses' => 'bg-warning text-dark',
                                                'diterima' => 'bg-success text-white',
                                                'ditolak' => 'bg-danger text-white',
                                                'dokumen_tidak_lengkap' => 'bg-secondary text-white',
                                                default => 'bg-light text-dark'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $permohonan->status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $permohonan->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-3">
                        {{ $permohonans->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#statusTable').DataTable({
                    pageLength: 10,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        paginate: {
                            first: "Pertama",
                            last: "Terakhir",
                            next: "→",
                            previous: "←"
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
