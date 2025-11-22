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
                                <th>Status Penelitian</th>
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
                                    <td>
                                        @if($permohonan->status === 'diterima')
                                            @if($permohonan->status_penelitian === 'selesai')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check-circle"></i> Selesai
                                                </span>
                                            @elseif($permohonan->status_penelitian === 'terlambat')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-exclamation-triangle"></i> Terlambat
                                                </span>
                                            @else
                                                <button class="btn btn-sm btn-primary" onclick="showCompletionModal({{ $permohonan->id }}, '{{ $permohonan->judul_riset }}')">
                                                    <i class="fas fa-upload"></i> Selesaikan
                                                </button>
                                                @if($permohonan->deadline_penelitian)
                                                    <br><small class="text-muted">Deadline: {{ $permohonan->deadline_penelitian->format('d M Y') }}</small>
                                                @endif
                                            @endif
                                        @endif
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

    <!-- Research Completion Modal -->
    <div class="modal fade" id="completionModal" tabindex="-1" aria-labelledby="completionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="completionModalLabel">Selesaikan Penelitian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="completionForm" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Judul Penelitian</label>
                            <input type="text" id="research-title" class="form-control" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label for="doi_number" class="form-label">DOI Number</label>
                            <input type="text" name="doi_number" id="doi_number" class="form-control" placeholder="Contoh: 10.1234/example.2023.001">
                            <small class="form-text text-muted">Masukkan DOI number jika sudah tersedia</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="file_paper_pdf" class="form-label">File Paper (PDF)</label>
                            <input type="file" name="file_paper_pdf" id="file_paper_pdf" class="form-control" accept=".pdf">
                            <small class="form-text text-muted">Upload file paper dalam format PDF (maksimal 10MB)</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Catatan:</strong> Minimal salah satu dari DOI Number atau File Paper PDF harus diisi untuk menyelesaikan penelitian.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Selesaikan Penelitian
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

            // Research completion functions
            let currentResearchId = null;
            
            function showCompletionModal(id, title) {
                currentResearchId = id;
                document.getElementById('research-title').value = title;
                document.getElementById('completionForm').reset();
                document.getElementById('research-title').value = title; // Reset after form reset
                
                const modal = new bootstrap.Modal(document.getElementById('completionModal'));
                modal.show();
            }

            // Handle form submission
            document.getElementById('completionForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                if (!currentResearchId) return;
                
                const formData = new FormData(this);
                const doiNumber = formData.get('doi_number');
                const pdfFile = formData.get('file_paper_pdf');
                
                // Validate that at least one field is filled
                if (!doiNumber && !pdfFile.name) {
                    alert('Minimal salah satu dari DOI Number atau File Paper PDF harus diisi.');
                    return;
                }
                
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
                submitBtn.disabled = true;
                
                fetch(`/dokumen/${currentResearchId}/complete-research`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        alert('Penelitian berhasil diselesaikan!');
                        location.reload();
                    } else {
                        return response.text().then(text => {
                            throw new Error(text);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyelesaikan penelitian.');
                })
                .finally(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                });
            });
        </script>
    @endpush
@endsection
