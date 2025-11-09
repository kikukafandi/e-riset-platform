@extends('dashboard.layouts.app')
@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard Petugas</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard Petugas</li>
            </ol>

            {{-- Statistik --}}
            <div class="row">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            Total Permohonan
                            <h4>{{ $total }}</h4>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span>Lihat Detail</span>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">
                            Permohonan Pending
                            <h4>{{ $pending }}</h4>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span>Lihat Detail</span>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">
                            Permohonan Disetujui
                            <h4>{{ $disetujui }}</h4>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span>Lihat Detail</span>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">
                            Permohonan Ditolak
                            <h4>{{ $ditolak }}</h4>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span>Lihat Detail</span>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-secondary text-white mb-4">
                        <div class="card-body">
                            Dokumen Tidak Lengkap
                            <h4>{{ $dokumenTidakLengkap }}</h4>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <span>Lihat Detail</span>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card mt-4 mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    Statistik Permohonan
                </div>
                <div class="card-body">
                    <canvas id="permohonanChart" width="100%" height="40"></canvas>
                </div>
            </div>

            {{-- Data Permohonan --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i> Data Permohonan Riset
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
                            @foreach ($permohonans as $key => $permohonan)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $permohonan->judul_riset }}</td>
                                    <td>{{ $permohonan->user->nama_lengkap ?? '-' }}</td>
                                    <td>{{ $permohonan->user->instansi ?? '-' }}</td>
                                    <td>{{ $permohonan->jenis_permohonan_data }}</td>
                                    <td>
                                        <select
                                            class="form-select status-dropdown
                                    {{ $permohonan->status === 'diproses'
                                        ? 'bg-warning text-dark'
                                        : ($permohonan->status === 'diterima'
                                            ? 'bg-success text-white'
                                            : ($permohonan->status === 'ditolak'
                                                ? 'bg-danger text-white'
                                                : 'bg-secondary text-white')) }}"
                                            data-id="{{ $permohonan->id }}">
                                            <option value="dokumen_tidak_lengkap"
                                                {{ $permohonan->status == 'dokumen_tidak_lengkap' ? 'selected' : '' }}>
                                                Dokumen Tidak Lengkap
                                            </option>
                                            <option value="diproses"
                                                {{ $permohonan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="diterima"
                                                {{ $permohonan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                            <option value="ditolak"
                                                {{ $permohonan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </td>
                                    <td>{{ $permohonan->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('dokumen.show', $permohonan->id) }}"
                                            class="btn btn-info btn-sm text-white"><i class="fas fa-eye"></i></a>
                                    </td>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const dropdowns = document.querySelectorAll('.status-dropdown');

                dropdowns.forEach(dropdown => {
                    dropdown.addEventListener('change', async function() {
                        const id = this.dataset.id;
                        const newStatus = this.value;

                        try {
                            const res = await fetch(`/petugas/permohonan/${id}/status`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    status: newStatus
                                })
                            });

                            const data = await res.json();

                            if (res.ok && data.success) {
                                // Ubah warna dropdown
                                this.classList.remove('bg-warning', 'bg-success', 'bg-danger',
                                    'bg-secondary', 'text-dark', 'text-white');
                                if (newStatus === 'diproses') this.classList.add('bg-warning',
                                    'text-dark');
                                else if (newStatus === 'diterima') this.classList.add('bg-success',
                                    'text-white');
                                else if (newStatus === 'ditolak') this.classList.add('bg-danger',
                                    'text-white');
                                else this.classList.add('bg-secondary', 'text-white');

                                // Swal success
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Status permohonan berhasil diperbarui.',
                                    showConfirmButton: false,
                                    timer: 1800
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: data.message ||
                                        'Terjadi kesalahan saat memperbarui status.',
                                    showConfirmButton: true
                                });
                            }
                        } catch (err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Tidak dapat terhubung ke server.',
                                showConfirmButton: true
                            });
                        }
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#datatablesSimple').DataTable({
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('permohonanChart');
                if (!ctx) return;

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Total', 'Pending', 'Disetujui', 'Ditolak', 'Dokumen Tidak Lengkap'],
                        datasets: [{
                            label: 'Jumlah Permohonan', 
                            data: [{{ $total }}, {{ $pending }}, {{ $disetujui }},
                                {{ $ditolak }}, {{ $dokumenTidakLengkap }}
                            ],
                            backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545', '#6c757d'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true, // ubah ke true kalau mau tampil
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text: 'Distribusi Status Permohonan'
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection
