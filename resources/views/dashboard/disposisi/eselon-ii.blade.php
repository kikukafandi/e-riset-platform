@extends('dashboard.layouts.app')
@section('title', 'Persetujuan Final Eselon II')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Persetujuan Final - Eselon II</h1>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Dokumen Menunggu Persetujuan Final</h5>
        </div>
        <div class="card-body">
            @if($documents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Judul Riset</th>
                                <th>Peneliti</th>
                                <th>Tanggal Disposisi</th>
                                <th>Catatan</th>
                                <th>File Proposal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $doc)
                                <tr>
                                    <td>{{ $loop->iteration + ($documents->currentPage() - 1) * $documents->perPage() }}</td>
                                    <td>
                                        <strong>{{ Str::limit($doc->judul_riset, 40) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $doc->topik_tujuan_riset }}</small>
                                    </td>
                                    <td>
                                        {{ $doc->user->nama_lengkap }}
                                        <br>
                                        <small class="text-muted">{{ $doc->user->email }}</small>
                                        <br>
                                        <small class="text-info">{{ $doc->user->jenis_peneliti }}</small>
                                    </td>
                                    <td>{{ $doc->updated_at->format('d M Y H:i') }}</td>
                                    <td>
                                        @if($doc->admin_validation_message)
                                            <small class="text-muted">{{ Str::limit($doc->admin_validation_message, 40) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($doc->file_proposal_penelitian)
                                            <a href="{{ Storage::url($doc->file_proposal_penelitian) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-file-pdf"></i> Lihat Proposal
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-success btn-sm" onclick="approveDocument({{ $doc->id }})">
                                                <i class="fas fa-stamp"></i> Setujui & Generate Surat
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="rejectDocument({{ $doc->id }})">
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
                    {{ $documents->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-stamp fa-3x text-muted mb-3"></i>
                    <h5>Tidak ada dokumen untuk persetujuan</h5>
                    <p class="text-muted">Dokumen yang diteruskan dari Eselon III akan muncul di sini untuk persetujuan final.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal for Rejection Notes -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Tolak Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="rejectNotes" class="form-label">Alasan Penolakan *</label>
                    <textarea class="form-control" id="rejectNotes" rows="4" 
                              placeholder="Masukkan alasan penolakan yang jelas..." required></textarea>
                </div>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian:</strong> Dokumen yang ditolak akan dikembalikan ke pemohon dengan alasan ini.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="confirmReject()">Tolak Dokumen</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentDocumentId = null;

function approveDocument(docId) {
    Swal.fire({
        title: 'Setujui Dokumen?',
        text: 'Dokumen akan disetujui dan surat persetujuan akan digenerate otomatis.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Setujui!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            processApproval(docId);
        }
    });
}

function rejectDocument(docId) {
    currentDocumentId = docId;
    document.getElementById('rejectNotes').value = '';
    new bootstrap.Modal(document.getElementById('rejectModal')).show();
}

function confirmReject() {
    const notes = document.getElementById('rejectNotes').value.trim();
    
    if (!notes) {
        alert('Alasan penolakan harus diisi!');
        return;
    }

    processRejection(currentDocumentId, notes);
    bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
}

async function processApproval(docId) {
    try {
        const response = await fetch(`/dokumen/disposisi/${docId}/forward`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                forward_to: 'final_approval',
                notes: 'Disetujui oleh Eselon II'
            })
        });

        const data = await response.json();
        
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil Disetujui!',
                text: 'Dokumen telah disetujui dan surat persetujuan akan digenerate.',
                showConfirmButton: false,
                timer: 2000
            });
            location.reload();
        } else {
            throw new Error(data.message || 'Gagal menyetujui dokumen');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: error.message || 'Terjadi kesalahan saat menyetujui dokumen'
        });
    }
}

async function processRejection(docId, notes) {
    try {
        const response = await fetch(`/dokumen/disposisi/${docId}/forward`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                forward_to: 'reject',
                notes: notes
            })
        });

        const data = await response.json();
        
        if (data.success) {
            Swal.fire({
                icon: 'info',
                title: 'Dokumen Ditolak',
                text: 'Dokumen telah ditolak dan pemohon akan diberitahu.',
                showConfirmButton: false,
                timer: 2000
            });
            location.reload();
        } else {
            throw new Error(data.message || 'Gagal menolak dokumen');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: error.message || 'Terjadi kesalahan saat menolak dokumen'
        });
    }
}
</script>
@endsection