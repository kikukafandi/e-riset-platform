@extends('dashboard.layouts.app')
@section('title', 'Validasi Dokumen Pelaksana')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Validasi Dokumen - Pelaksana</h1>
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        <strong>Workflow:</strong> Pelaksana → Eselon IV → Eselon III → Eselon II (Final Approval)
    </div>
    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-clipboard-check"></i> Paper Menunggu Validasi
                <span class="badge badge-warning">{{ $pendingValidations->total() }}</span>
            </h5>
        </div>
        <div class="card-body">
            @if($pendingValidations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul Riset</th>
                                <th>Peneliti</th>
                                <th>Kantor Tujuan</th>
                                <th>Tanggal Submit</th>
                                <th>File Paper</th>
                                <th>DOI Number</th>
                                <th>Validasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingValidations as $dokumen)
                                <tr id="row-{{ $dokumen->id }}">
                                    <td>{{ $loop->iteration + ($pendingValidations->currentPage() - 1) * $pendingValidations->perPage() }}</td>
                                    <td>
                                        <strong>{{ Str::limit($dokumen->judul_riset, 40) }}</strong>
                                        <br><small class="text-muted">{{ $dokumen->topik_tujuan_riset }}</small>
                                    </td>
                                    <td>
                                        {{ $dokumen->user->nama_lengkap }}
                                        <br><small class="text-muted">{{ $dokumen->user->email }}</small>
                                    </td>
                                    <td>
                                        @if($dokumen->kantorBeaCukai)
                                            <span class="badge badge-info">{{ $dokumen->kantorBeaCukai->kode_kantor }}</span>
                                            <br><small>{{ $dokumen->kantorBeaCukai->nama_kantor }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $dokumen->paper_submitted_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <a href="{{ Storage::url($dokumen->paper_file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-file-pdf"></i> Lihat PDF
                                        </a>
                                    </td>
                                    <td>
                                        {{ $dokumen->doi_number ?: '-' }}
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input validation-checkbox" type="checkbox" 
                                                   id="check-{{ $dokumen->id }}" data-dokumen-id="{{ $dokumen->id }}">
                                            <label class="form-check-label" for="check-{{ $dokumen->id }}">
                                                Pilih untuk validasi
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-success btn-sm" 
                                                    onclick="validatePaper({{ $dokumen->id }}, 'valid')">
                                                <i class="fas fa-check"></i> Terima
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="showRejectModal({{ $dokumen->id }})">
                                                <i class="fas fa-times"></i> Tolak
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
                    {{ $pendingValidations->links() }}
                </div>

                <!-- Bulk Actions -->
                <div class="mt-3">
                    <div class="card">
                        <div class="card-body">
                            <h6>Aksi Massal</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-success" onclick="bulkValidate('valid')">
                                        <i class="fas fa-check"></i> Terima Paper Terpilih
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="showBulkRejectModal()">
                                        <i class="fas fa-times"></i> Tolak Paper Terpilih
                                    </button>
                                </div>
                                <div class="col-md-6 text-end">
                                    <button type="button" class="btn btn-secondary" onclick="selectAll()">
                                        <i class="fas fa-check-square"></i> Pilih Semua
                                    </button>
                                    <button type="button" class="btn btn-secondary" onclick="deselectAll()">
                                        <i class="fas fa-square"></i> Batal Pilih
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                    <h5>Tidak ada paper yang menunggu validasi</h5>
                    <p class="text-muted">Semua paper telah divalidasi atau belum ada submission baru.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Paper</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="reject_message" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea id="reject_message" class="form-control" rows="4" 
                              placeholder="Masukkan alasan penolakan paper..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmReject()">
                    <i class="fas fa-times"></i> Tolak Paper
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Reject Modal -->
<div class="modal fade" id="bulkRejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Paper Terpilih</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    Anda akan menolak <span id="selected-count">0</span> paper terpilih.
                </div>
                <div class="mb-3">
                    <label for="bulk_reject_message" class="form-label">Alasan Penolakan <span class="text-danger">*</span></label>
                    <textarea id="bulk_reject_message" class="form-control" rows="4" 
                              placeholder="Masukkan alasan penolakan untuk semua paper terpilih..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmBulkReject()">
                    <i class="fas fa-times"></i> Tolak Semua Paper Terpilih
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentDokumenId = null;
let selectedDokumens = [];

// Individual validation
function validatePaper(dokumenId, status) {
    if (status === 'valid' && !confirm('Yakin ingin menerima paper ini?')) {
        return;
    }
    
    fetch(`/timeline/validate-paper/${dokumenId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            validation_status: status,
            validation_message: null
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`row-${dokumenId}`).remove();
            showAlert('success', data.message);
        } else {
            showAlert('error', 'Terjadi kesalahan saat validasi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat validasi.');
    });
}

// Show reject modal
function showRejectModal(dokumenId) {
    currentDokumenId = dokumenId;
    document.getElementById('reject_message').value = '';
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

// Confirm reject
function confirmReject() {
    const message = document.getElementById('reject_message').value.trim();
    if (!message) {
        alert('Alasan penolakan harus diisi!');
        return;
    }

    fetch(`/timeline/validate-paper/${currentDokumenId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            validation_status: 'invalid',
            validation_message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`row-${currentDokumenId}`).remove();
            bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
            showAlert('success', data.message);
        } else {
            showAlert('error', 'Terjadi kesalahan saat validasi.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat validasi.');
    });
}

// Bulk operations
function updateSelectedDokumens() {
    selectedDokumens = Array.from(document.querySelectorAll('.validation-checkbox:checked'))
        .map(checkbox => checkbox.dataset.dokumenId);
    document.getElementById('selected-count').textContent = selectedDokumens.length;
}

function selectAll() {
    document.querySelectorAll('.validation-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
    updateSelectedDokumens();
}

function deselectAll() {
    document.querySelectorAll('.validation-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    updateSelectedDokumens();
}

function bulkValidate(status) {
    updateSelectedDokumens();
    if (selectedDokumens.length === 0) {
        alert('Pilih minimal satu paper untuk divalidasi!');
        return;
    }
    
    if (!confirm(`Yakin ingin ${status === 'valid' ? 'menerima' : 'menolak'} ${selectedDokumens.length} paper terpilih?`)) {
        return;
    }

    Promise.all(selectedDokumens.map(dokumenId => 
        fetch(`/timeline/validate-paper/${dokumenId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                validation_status: status,
                validation_message: null
            })
        })
    ))
    .then(responses => {
        selectedDokumens.forEach(dokumenId => {
            document.getElementById(`row-${dokumenId}`).remove();
        });
        showAlert('success', `${selectedDokumens.length} paper berhasil divalidasi.`);
        selectedDokumens = [];
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat validasi massal.');
    });
}

function showBulkRejectModal() {
    updateSelectedDokumens();
    if (selectedDokumens.length === 0) {
        alert('Pilih minimal satu paper untuk ditolak!');
        return;
    }
    document.getElementById('bulk_reject_message').value = '';
    new bootstrap.Modal(document.getElementById('bulkRejectModal')).show();
}

function confirmBulkReject() {
    const message = document.getElementById('bulk_reject_message').value.trim();
    if (!message) {
        alert('Alasan penolakan harus diisi!');
        return;
    }

    Promise.all(selectedDokumens.map(dokumenId => 
        fetch(`/timeline/validate-paper/${dokumenId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                validation_status: 'invalid',
                validation_message: message
            })
        })
    ))
    .then(responses => {
        selectedDokumens.forEach(dokumenId => {
            document.getElementById(`row-${dokumenId}`).remove();
        });
        bootstrap.Modal.getInstance(document.getElementById('bulkRejectModal')).hide();
        showAlert('success', `${selectedDokumens.length} paper berhasil ditolak.`);
        selectedDokumens = [];
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat penolakan massal.');
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
}

// Update selected count when checkboxes change
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('validation-checkbox')) {
        updateSelectedDokumens();
    }
});
</script>
@endsection