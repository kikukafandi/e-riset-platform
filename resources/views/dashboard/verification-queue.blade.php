@extends('dashboard.layouts.app')
@section('title', 'Queue Verifikasi Pejabat')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Queue Verifikasi Pejabat</h1>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-user-tie"></i> Paper Menunggu Verifikasi Substansi
                <span class="badge badge-info">{{ $pendingVerifications->total() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @if($pendingVerifications->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul Riset</th>
                                <th>Peneliti</th>
                                <th>Kantor Tujuan</th>
                                <th>Tanggal Validasi Admin</th>
                                <th>File Paper</th>
                                <th>DOI Number</th>
                                <th>Status Admin</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingVerifications as $dokumen)
                                <tr id="row-{{ $dokumen->id }}">
                                    <td>{{ $loop->iteration + ($pendingVerifications->currentPage() - 1) * $pendingVerifications->perPage() }}</td>
                                    <td>
                                        <strong>{{ Str::limit($dokumen->judul_riset, 40) }}</strong>
                                        <br><small class="text-muted">{{ $dokumen->topik_tujuan_riset }}</small>
                                    </td>
                                    <td>
                                        {{ $dokumen->user->nama_lengkap }}
                                        <br><small class="text-muted">{{ $dokumen->user->email }}</small>
                                        @if($dokumen->user->instansi)
                                            <br><small class="text-info">{{ $dokumen->user->instansi }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($dokumen->kantorBeaCukai)
                                            <span class="badge badge-info">{{ $dokumen->kantorBeaCukai->kode_kantor }}</span>
                                            <br><small>{{ $dokumen->kantorBeaCukai->nama_kantor }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $dokumen->paper_validated_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <div class="btn-group-vertical">
                                            <a href="{{ Storage::url($dokumen->paper_file) }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">
                                                <i class="fas fa-file-pdf"></i> Lihat Paper
                                            </a>
                                            <a href="{{ Storage::url($dokumen->proposal) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                                <i class="fas fa-file-alt"></i> Lihat Proposal
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $dokumen->doi_number ?: '-' }}
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            <i class="fas fa-check"></i> Valid
                                        </span>
                                        @if($dokumen->paper_validation_message)
                                            <br><small class="text-muted">{{ Str::limit($dokumen->paper_validation_message, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical" role="group">
                                            <button type="button" class="btn btn-success btn-sm mb-1" 
                                                    onclick="verifyDocument({{ $dokumen->id }}, 'approved')">
                                                <i class="fas fa-check"></i> Setujui
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="showVerificationModal({{ $dokumen->id }}, 'rejected')">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                            <button type="button" class="btn btn-info btn-sm mt-1" 
                                                    onclick="showDetailModal({{ $dokumen->id }})">
                                                <i class="fas fa-eye"></i> Detail
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $pendingVerifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                    <h5>Tidak ada paper yang menunggu verifikasi</h5>
                    <p class="text-muted">Semua paper telah diverifikasi atau belum ada yang perlu diverifikasi.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Verification Modal -->
<div class="modal fade" id="verificationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verificationModalTitle">Verifikasi Substansi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Status Verifikasi</label>
                    <div id="verification-status-display" class="form-control-plaintext"></div>
                </div>
                
                <div class="mb-3">
                    <label for="verification_message" class="form-label">Catatan/Pesan</label>
                    <textarea id="verification_message" class="form-control" rows="4" 
                              placeholder="Masukkan catatan atau alasan (opsional untuk persetujuan, wajib untuk penolakan)..."></textarea>
                </div>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <strong>Catatan:</strong> 
                    <span id="verification-note"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn" id="confirmVerificationBtn" onclick="confirmVerification()">
                    <span id="btn-icon"></span> <span id="btn-text"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Permohonan Riset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="detail-content">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentDokumenId = null;
let currentVerificationStatus = null;

// Quick approve without modal
function verifyDocument(dokumenId, status) {
    if (status === 'approved' && confirm('Yakin ingin menyetujui dokumen ini? Surat persetujuan akan digenerate otomatis.')) {
        submitVerification(dokumenId, status, '');
    }
}

// Show verification modal for rejection or detailed approval
function showVerificationModal(dokumenId, status) {
    currentDokumenId = dokumenId;
    currentVerificationStatus = status;
    
    const modal = document.getElementById('verificationModal');
    const title = document.getElementById('verificationModalTitle');
    const statusDisplay = document.getElementById('verification-status-display');
    const note = document.getElementById('verification-note');
    const btn = document.getElementById('confirmVerificationBtn');
    const btnIcon = document.getElementById('btn-icon');
    const btnText = document.getElementById('btn-text');
    
    if (status === 'approved') {
        title.textContent = 'Setujui Permohonan Riset';
        statusDisplay.textContent = 'Disetujui';
        statusDisplay.className = 'form-control-plaintext text-success fw-bold';
        note.textContent = 'Dokumen akan disetujui dan surat persetujuan akan digenerate otomatis.';
        btn.className = 'btn btn-success';
        btnIcon.innerHTML = '<i class="fas fa-check"></i>';
        btnText.textContent = 'Setujui Dokumen';
    } else {
        title.textContent = 'Tolak Permohonan Riset';
        statusDisplay.textContent = 'Ditolak';
        statusDisplay.className = 'form-control-plaintext text-danger fw-bold';
        note.textContent = 'Alasan penolakan wajib diisi untuk memberikan feedback kepada peneliti.';
        btn.className = 'btn btn-danger';
        btnIcon.innerHTML = '<i class="fas fa-times"></i>';
        btnText.textContent = 'Tolak Dokumen';
    }
    
    document.getElementById('verification_message').value = '';
    new bootstrap.Modal(modal).show();
}

// Confirm verification
function confirmVerification() {
    const message = document.getElementById('verification_message').value.trim();
    
    if (currentVerificationStatus === 'rejected' && !message) {
        alert('Alasan penolakan harus diisi!');
        return;
    }
    
    submitVerification(currentDokumenId, currentVerificationStatus, message);
}

// Submit verification
function submitVerification(dokumenId, status, message) {
    const submitBtn = document.getElementById('confirmVerificationBtn');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    submitBtn.disabled = true;
    
    fetch(`/timeline/official-verification/${dokumenId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            verification_status: status,
            verification_message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`row-${dokumenId}`).remove();
            
            // Close modal if it's open
            const modalElement = document.getElementById('verificationModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
            
            showAlert('success', data.message);
        } else {
            showAlert('error', 'Terjadi kesalahan saat verifikasi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat verifikasi.');
    })
    .finally(() => {
        if (submitBtn) {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }
    });
}

// Show detail modal
function showDetailModal(dokumenId) {
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    const content = document.getElementById('detail-content');
    
    content.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Memuat detail...</div>';
    modal.show();
    
    // Fetch detail data (you may need to create a separate endpoint for this)
    fetch(`/dokumen/${dokumenId}`)
        .then(response => response.text())
        .then(html => {
            // Extract relevant content or create a summary view
            content.innerHTML = `
                <div class="alert alert-info">
                    <strong>Note:</strong> Detail lengkap dapat dilihat dengan membuka file proposal dan paper.
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informasi Peneliti</h6>
                        <!-- Add researcher info -->
                    </div>
                    <div class="col-md-6">
                        <h6>Informasi Riset</h6>
                        <!-- Add research info -->
                    </div>
                </div>
            `;
        })
        .catch(error => {
            content.innerHTML = '<div class="alert alert-danger">Gagal memuat detail dokumen.</div>';
        });
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.container').firstChild.nextSibling);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}
</script>
@endsection