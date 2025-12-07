@extends('dashboard.layouts.app')
@section('title', 'Validasi Paper - Pelaksana')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4"><i class="fas fa-clipboard-check"></i> Validasi Paper</h1>
    
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <strong>Info:</strong> Paper yang disubmit oleh peneliti setelah selesai riset perlu divalidasi. 
        Jika paper valid, status penelitian akan menjadi <strong>Selesai</strong> dan peneliti dapat mengajukan riset baru.
    </div>
    
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-warning text-dark">
            <h5 class="mb-0">
                <i class="fas fa-file-pdf"></i> Paper Menunggu Validasi
                <span class="badge bg-dark">{{ $pendingValidations->total() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @if($pendingValidations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Judul Riset</th>
                                <th>Peneliti</th>
                                <th>Tanggal Submit</th>
                                <th>File Paper</th>
                                <th>DOI</th>
                                <th>Aksi Validasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingValidations as $dokumen)
                                <tr>
                                    <td>{{ $loop->iteration + ($pendingValidations->currentPage() - 1) * $pendingValidations->perPage() }}</td>
                                    <td>
                                        <strong>{{ Str::limit($dokumen->judul_riset, 40) }}</strong>
                                        <br><small class="text-muted">Topik: {{ $dokumen->topik_tujuan_riset }}</small>
                                    </td>
                                    <td>
                                        {{ $dokumen->user->nama_lengkap ?? '-' }}
                                        <br><small class="text-muted">{{ $dokumen->user->email ?? '' }}</small>
                                        @if($dokumen->user->instansi ?? false)
                                            <br><small class="text-info">{{ $dokumen->user->instansi }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($dokumen->paper_submitted_at)
                                            {{ \Carbon\Carbon::parse($dokumen->paper_submitted_at)->format('d M Y, H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if($dokumen->paper_file)
                                            <a href="{{ Storage::url($dokumen->paper_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf"></i> Lihat Paper
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $dokumen->doi_number ?: '-' }}
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical" role="group">
                                            {{-- Form Terima --}}
                                            <form action="{{ route('timeline.validate.paper', $dokumen->id) }}" method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Yakin ingin menerima paper ini? Status penelitian akan menjadi SELESAI.')">
                                                @csrf
                                                <input type="hidden" name="validation_status" value="valid">
                                                <button type="submit" class="btn btn-success btn-sm mb-1">
                                                    <i class="fas fa-check"></i> Terima Paper
                                                </button>
                                            </form>
                                            
                                            {{-- Button Tolak - buka modal --}}
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="showRejectModal({{ $dokumen->id }}, '{{ addslashes($dokumen->judul_riset) }}')">
                                                <i class="fas fa-times"></i> Tolak Paper
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-3">
                    {{ $pendingValidations->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                    <h5>Tidak ada paper yang menunggu validasi</h5>
                    <p class="text-muted">Semua paper telah divalidasi atau belum ada submission baru.</p>
                    <a href="{{ route('dashboard.petugas') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-times-circle"></i> Tolak Paper</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <input type="hidden" name="validation_status" value="invalid">
                <div class="modal-body">
                    <div class="mb-3">
                        <strong>Judul Riset:</strong>
                        <p id="reject-judul-riset" class="text-muted"></p>
                    </div>
                    <div class="mb-3">
                        <label for="validation_message" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                        <textarea name="validation_message" id="validation_message" class="form-control" rows="4" 
                                  placeholder="Masukkan alasan penolakan paper (misal: format tidak sesuai, DOI tidak valid, dll.)..." required></textarea>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Perhatian:</strong> Peneliti akan menerima feedback ini dan dapat mengupload ulang paper yang sudah diperbaiki.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times"></i> Tolak Paper
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal(dokumenId, judulRiset) {
    document.getElementById('rejectForm').action = '/timeline/validate-paper/' + dokumenId;
    document.getElementById('reject-judul-riset').textContent = judulRiset;
    document.getElementById('validation_message').value = '';
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}
</script>
@endsection
