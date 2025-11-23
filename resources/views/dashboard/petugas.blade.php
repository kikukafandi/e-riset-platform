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
                            <h4 id="stat-total">{{ $total }}</h4>
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
                            <h4 id="stat-pending">{{ $pending }}</h4>
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
                            <h4 id="stat-disetujui">{{ $disetujui }}</h4>
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
                            <h4 id="stat-ditolak">{{ $ditolak }}</h4>
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
                            <h4 id="stat-dokumenTidakLengkap">{{ $dokumenTidakLengkap }}</h4>
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
                                <th>Status Permohonan</th>
                                <th>Paper Status</th>
                                <th>Validasi Admin</th>
                                <th>Verifikasi Pejabat</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permohonans as $key => $permohonan)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <strong>{{ Str::limit($permohonan->judul_riset, 40) }}</strong>
                                        <br><small class="text-muted">{{ $permohonan->topik_tujuan_riset }}</small>
                                    </td>
                                    <td>
                                        {{ $permohonan->user->nama_lengkap ?? '-' }}
                                        <br><small class="text-muted">{{ $permohonan->user->email }}</small>
                                    </td>
                                    <td>{{ $permohonan->user->instansi ?? 'Peneliti Mandiri' }}</td>
                                    <td>
                                        <select class="form-select form-select-sm status-dropdown
                                            {{ $permohonan->status === 'diproses' ? 'bg-warning text-dark' : 
                                               ($permohonan->status === 'diterima' ? 'bg-success text-white' : 
                                                ($permohonan->status === 'ditolak' ? 'bg-danger text-white' : 'bg-secondary text-white')) }}"
                                            data-id="{{ $permohonan->id }}">
                                            <option value="dokumen_tidak_lengkap" {{ $permohonan->status == 'dokumen_tidak_lengkap' ? 'selected' : '' }}>Dokumen Tidak Lengkap</option>
                                            <option value="diproses" {{ $permohonan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="diterima" {{ $permohonan->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                            <option value="ditolak" {{ $permohonan->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </td>
                                    <td>
                                        @if($permohonan->paper_file)
                                            <div class="d-flex align-items-center">
                                                <span class="badge 
                                                    {{ $permohonan->paper_validation_status === 'pending' ? 'bg-warning' : 
                                                       ($permohonan->paper_validation_status === 'valid' ? 'bg-success' : 
                                                        ($permohonan->paper_validation_status === 'invalid' ? 'bg-danger' : 'bg-secondary')) }} me-2">
                                                    {{ $permohonan->paper_validation_status === 'pending' ? 'Menunggu' : 
                                                       ($permohonan->paper_validation_status === 'valid' ? 'Valid' : 
                                                        ($permohonan->paper_validation_status === 'invalid' ? 'Invalid' : 'Belum Submit')) }}
                                                </span>
                                                @if($permohonan->paper_file)
                                                    <a href="{{ Storage::url($permohonan->paper_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </a>
                                                @endif
                                            </div>
                                            @if($permohonan->doi_number)
                                                <small class="text-muted d-block">DOI: {{ $permohonan->doi_number }}</small>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Belum Submit</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($permohonan->paper_file && $permohonan->paper_validation_status === 'pending')
                                            <div class="btn-group-vertical" role="group">
                                                <button type="button" class="btn btn-success btn-sm mb-1" 
                                                        onclick="validatePaper({{ $permohonan->id }}, 'valid')">
                                                    <i class="fas fa-check"></i> Terima
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" 
                                                        onclick="showRejectModal({{ $permohonan->id }})">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>
                                            </div>
                                        @elseif($permohonan->paper_validation_status === 'valid')
                                            <span class="badge bg-success"><i class="fas fa-check"></i> Tervalidasi</span>
                                            <small class="text-success d-block">{{ $permohonan->paper_validated_at ? $permohonan->paper_validated_at->format('d M Y') : '' }}</small>
                                        @elseif($permohonan->paper_validation_status === 'invalid')
                                            <span class="badge bg-danger"><i class="fas fa-times"></i> Ditolak</span>
                                            @if($permohonan->paper_validation_message)
                                                <small class="text-danger d-block">{{ Str::limit($permohonan->paper_validation_message, 30) }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($permohonan->paper_validation_status === 'valid')
                                            @if($permohonan->admin_validation_status === 'pending' || !$permohonan->admin_validation_status)
                                                <div class="btn-group-vertical" role="group">
                                                    <button type="button" class="btn btn-success btn-sm mb-1" 
                                                            onclick="verifyDocument({{ $permohonan->id }}, 'approved')">
                                                        <i class="fas fa-check"></i> Setujui
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm" 
                                                            onclick="showVerifyRejectModal({{ $permohonan->id }})">
                                                        <i class="fas fa-times"></i> Tolak
                                                    </button>
                                                </div>
                                            @elseif($permohonan->admin_validation_status === 'approved')
                                                <div class="text-center">
                                                    <span class="badge bg-success"><i class="fas fa-check"></i> Disetujui</span>
                                                    <small class="text-success d-block">{{ $permohonan->admin_validated_at ? $permohonan->admin_validated_at->format('d M Y') : '' }}</small>
                                                    @if($permohonan->approval_letter_path)
                                                        <a href="{{ Storage::url($permohonan->approval_letter_path) }}" target="_blank" class="btn btn-sm btn-outline-success mt-1">
                                                            <i class="fas fa-download"></i> Surat
                                                        </a>
                                                    @endif
                                                </div>
                                            @elseif($permohonan->admin_validation_status === 'rejected')
                                                <div class="text-center">
                                                    <span class="badge bg-danger"><i class="fas fa-times"></i> Ditolak</span>
                                                    @if($permohonan->admin_validation_message)
                                                        <small class="text-danger d-block">{{ Str::limit($permohonan->admin_validation_message, 30) }}</small>
                                                    @endif
                                                    @if($permohonan->rejection_letter_path)
                                                        <a href="{{ Storage::url($permohonan->rejection_letter_path) }}" target="_blank" class="btn btn-sm btn-outline-danger mt-1">
                                                            <i class="fas fa-download"></i> Surat
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted">Menunggu Validasi Admin</span>
                                        @endif
                                    </td>
                                    <td>{{ $permohonan->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group-vertical" role="group">
                                            <a href="{{ route('dokumen.show', $permohonan->id) }}" class="btn btn-info btn-sm text-white mb-1">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                            @if($permohonan->admin_validation_status === 'approved' && !$permohonan->approval_letter_path)
                                                <button type="button" class="btn btn-warning btn-sm" 
                                                        onclick="generateLetter({{ $permohonan->id }})">
                                                    <i class="fas fa-file-alt"></i> Generate Surat
                                                </button>
                                            @endif
                                        </div>
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

    <!-- Paper Rejection Modal -->
    <div class="modal fade" id="rejectPaperModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Validasi Paper</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="paperRejectMessage" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea id="paperRejectMessage" class="form-control" rows="4" 
                                  placeholder="Masukkan alasan penolakan paper..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" onclick="confirmRejectPaper()">
                        <i class="fas fa-times"></i> Tolak Paper
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Verification Rejection Modal -->
    <div class="modal fade" id="rejectVerificationModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tolak Verifikasi Pejabat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="verifyRejectMessage" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea id="verifyRejectMessage" class="form-control" rows="4" 
                                  placeholder="Masukkan alasan penolakan verifikasi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" onclick="confirmRejectVerification()">
                        <i class="fas fa-times"></i> Tolak Verifikasi
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        {{-- Script untuk DataTable --}}
        <script>
            $(document.ready(function() {
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

        {{-- Script untuk Update Status dan Chart --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('permohonanChart');
                if (!ctx) return;

                // Variabel untuk menyimpan object chart
                let permohonanChart;

                // == FUNGSI UNTUK UPDATE STATISTIK (KARTU & CHART) ==
                async function updateStatistikData() {
                    try {
                        const res = await fetch('{{ route('petugas.statistik') }}');
                        if (!res.ok) throw new Error('Gagal mengambil data statistik');

                        const data = await res.json();

                        // 1. Update Kartu Statistik
                        document.getElementById('stat-total').textContent = data.total;
                        document.getElementById('stat-pending').textContent = data.pending;
                        document.getElementById('stat-disetujui').textContent = data.disetujui;
                        document.getElementById('stat-ditolak').textContent = data.ditolak;
                        document.getElementById('stat-dokumenTidakLengkap').textContent = data.dokumenTidakLengkap;

                        // 2. Siapkan data baru untuk chart
                        const newData = [
                            data.total,
                            data.pending,
                            data.disetujui,
                            data.ditolak,
                            data.dokumenTidakLengkap
                        ];

                        // 3. Update Chart
                        if (permohonanChart) {
                            permohonanChart.data.datasets[0].data = newData;
                            permohonanChart.update();
                        }

                    } catch (err) {
                        console.error('Gagal update statistik:', err);
                    }
                }

                // == INISIALISASI CHART AWAL ==
                // Ambil data awal dari Blade untuk render pertama kali
                const initialData = [
                    {{ $total }},
                    {{ $pending }},
                    {{ $disetujui }},
                    {{ $ditolak }},
                    {{ $dokumenTidakLengkap }}
                ];

                // Buat chart-nya dan simpan ke variabel
                permohonanChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Total', 'Pending', 'Disetujui', 'Ditolak', 'Dokumen Tidak Lengkap'],
                        datasets: [{
                            label: 'Jumlah Permohonan',
                            data: initialData,
                            backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545',
                                '#6c757d'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom'
                            },
                            title: {
                                display: true,
                                text: 'Distribusi Status Permohonan'
                            }
                        },
                        animation: {
                            duration: 300 // Animasi update
                        }
                    }
                });

                // == EVENT LISTENER UNTUK GANTI STATUS ==
                document.addEventListener('change', async function(e) {
                    if (e.target.classList.contains('status-dropdown')) {
                        const id = e.target.dataset.id;
                        const newStatus = e.target.value;

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
                                // Atur ulang kelas warna pada <select>
                                e.target.classList.remove('bg-warning', 'bg-success', 'bg-danger',
                                    'bg-secondary', 'text-dark', 'text-white');
                                if (newStatus === 'diproses') e.target.classList.add(
                                    'bg-warning', 'text-dark');
                                else if (newStatus === 'diterima') e.target.classList.add(
                                    'bg-success', 'text-white');
                                else if (newStatus === 'ditolak') e.target.classList.add(
                                    'bg-danger', 'text-white');
                                else e.target.classList.add('bg-secondary', 'text-white');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil!',
                                    text: 'Status permohonan berhasil diperbarui.',
                                    showConfirmButton: false,
                                    timer: 1500
                                });

                                // == INI BAGIAN PENTING ==
                                // Panggil fungsi update statistik SEKARANG JUGA
                                await updateStatistikData();

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
                    }
                });

                // (Opsional) Anda tetap bisa menggunakan polling jika ingin data
                // tetap sinkron jika ada petugas lain yang mengubah data.
                setInterval(updateStatistikData, 10000); // Update setiap 10 detik
            });

            // Variables for modal handling
            let currentDocumentId = null;

            // === PAPER VALIDATION FUNCTIONS ===
            
            // Validate paper (accept)
            async function validatePaper(documentId, status) {
                if (status === 'valid' && !confirm('Yakin ingin menerima paper ini?')) {
                    return;
                }

                try {
                    const response = await fetch(`/timeline/validate-paper/${documentId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            validation_status: status,
                            validation_message: ''
                        })
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Paper berhasil divalidasi.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload(); // Refresh page to show updated status
                    } else {
                        throw new Error(data.message || 'Gagal memvalidasi paper');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message || 'Terjadi kesalahan saat memvalidasi paper'
                    });
                }
            }

            // Show reject modal for paper
            function showRejectModal(documentId) {
                currentDocumentId = documentId;
                document.getElementById('paperRejectMessage').value = '';
                new bootstrap.Modal(document.getElementById('rejectPaperModal')).show();
            }

            // Confirm reject paper
            async function confirmRejectPaper() {
                const message = document.getElementById('paperRejectMessage').value.trim();
                
                if (!message) {
                    alert('Alasan penolakan harus diisi!');
                    return;
                }

                try {
                    const response = await fetch(`/timeline/validate-paper/${currentDocumentId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            validation_status: 'invalid',
                            validation_message: message
                        })
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('rejectPaperModal')).hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Paper berhasil ditolak.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Gagal menolak paper');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message || 'Terjadi kesalahan saat menolak paper'
                    });
                }
            }

            // === OFFICIAL VERIFICATION FUNCTIONS ===
            
            // Verify document (approve)
            async function verifyDocument(documentId, status) {
                if (status === 'approved' && !confirm('Yakin ingin menyetujui dokumen ini? Surat persetujuan akan digenerate otomatis.')) {
                    return;
                }

                try {
                    const response = await fetch(`/timeline/official-verification/${documentId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            verification_status: status,
                            verification_message: ''
                        })
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Gagal memverifikasi dokumen');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message || 'Terjadi kesalahan saat memverifikasi dokumen'
                    });
                }
            }

            // Show reject modal for verification
            function showVerifyRejectModal(documentId) {
                currentDocumentId = documentId;
                document.getElementById('verifyRejectMessage').value = '';
                new bootstrap.Modal(document.getElementById('rejectVerificationModal')).show();
            }

            // Confirm reject verification
            async function confirmRejectVerification() {
                const message = document.getElementById('verifyRejectMessage').value.trim();
                
                if (!message) {
                    alert('Alasan penolakan harus diisi!');
                    return;
                }

                try {
                    const response = await fetch(`/timeline/official-verification/${currentDocumentId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            verification_status: 'rejected',
                            verification_message: message
                        })
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        bootstrap.Modal.getInstance(document.getElementById('rejectVerificationModal')).hide();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Verifikasi berhasil ditolak.',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                    } else {
                        throw new Error(data.message || 'Gagal menolak verifikasi');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message || 'Terjadi kesalahan saat menolak verifikasi'
                    });
                }
            }

            // === LETTER GENERATION FUNCTION ===
            
            async function generateLetter(documentId) {
                if (!confirm('Generate surat persetujuan untuk dokumen ini?')) {
                    return;
                }

                try {
                    const response = await fetch(`/timeline/generate-letter/${documentId}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: data.message,
                            showConfirmButton: true,
                            confirmButtonText: 'Download Surat',
                            showCancelButton: true,
                            cancelButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed && data.download_url) {
                                window.open(data.download_url, '_blank');
                            }
                            location.reload();
                        });
                    } else {
                        throw new Error(data.message || 'Gagal generate surat');
                    }
                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: error.message || 'Terjadi kesalahan saat generate surat'
                    });
                }
            }
        </script>
    @endpush

    <!-- Modal for Paper Rejection -->
    <div class="modal fade" id="rejectPaperModal" tabindex="-1" aria-labelledby="rejectPaperModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectPaperModalLabel">Tolak Paper</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="paperRejectMessage" class="form-label">Alasan Penolakan *</label>
                        <textarea class="form-control" id="paperRejectMessage" rows="4" 
                                  placeholder="Masukkan alasan penolakan paper..." required></textarea>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Alasan penolakan akan dikirimkan ke pemohon dan tidak dapat diubah setelah dikonfirmasi.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmRejectPaper()">
                        <i class="fas fa-ban me-1"></i>Tolak Paper
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Verification Rejection -->
    <div class="modal fade" id="rejectVerificationModal" tabindex="-1" aria-labelledby="rejectVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rejectVerificationModalLabel">Tolak Verifikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="verifyRejectMessage" class="form-label">Alasan Penolakan *</label>
                        <textarea class="form-control" id="verifyRejectMessage" rows="4" 
                                  placeholder="Masukkan alasan penolakan verifikasi..." required></textarea>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Alasan penolakan akan dikirimkan ke pemohon dan tidak dapat diubah setelah dikonfirmasi.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <button type="button" class="btn btn-danger" onclick="confirmRejectVerification()">
                        <i class="fas fa-ban me-1"></i>Tolak Verifikasi
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
