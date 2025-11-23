@extends('dashboard.layouts.app')
@section('title', 'Disposisi Eselon IV')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Disposisi Dokumen - Eselon IV</h1>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Dokumen Menunggu Disposisi</h5>
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
                                <th>Tanggal Pengajuan</th>
                                <th>Status Paper</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($documents as $doc)
                                <tr>
                                    <td>{{ $loop->iteration + ($documents->currentPage() - 1) * $documents->perPage() }}</td>
                                    <td>
                                        <strong>{{ Str::limit($doc->judul_riset, 50) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $doc->topik_tujuan_riset }}</small>
                                    </td>
                                    <td>
                                        {{ $doc->user->nama_lengkap }}
                                        <br>
                                        <small class="text-muted">{{ $doc->user->email }}</small>
                                    </td>
                                    <td>{{ $doc->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($doc->paper_validation_status === 'valid')
                                            <span class="badge bg-success">Paper Valid</span>
                                        @else
                                            <span class="badge bg-warning">Paper Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" onclick="forwardDocument({{ $doc->id }}, 'eselon_iii')">
                                            <i class="fas fa-forward"></i> Teruskan ke Eselon III
                                        </button>
                                        <button class="btn btn-success btn-sm" onclick="approveDocument({{ $doc->id }})">
                                            <i class="fas fa-check"></i> Setujui Langsung
                                        </button>
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
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5>Tidak ada dokumen untuk didisposisi</h5>
                    <p class="text-muted">Dokumen yang perlu disposisi akan muncul di sini.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal for Notes -->
<div class="modal fade" id="forwardModal" tabindex="-1" aria-labelledby="forwardModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forwardModalLabel">Teruskan Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="forwardNotes" class="form-label">Catatan (Opsional)</label>
                    <textarea class="form-control" id="forwardNotes" rows="3" 
                              placeholder="Tambahkan catatan untuk penerima disposisi..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="confirmForward()">Teruskan</button>
            </div>
        </div>
    </div>
</div>

<script>
let currentDocumentId = null;
let forwardTarget = null;

function forwardDocument(docId, target) {
    currentDocumentId = docId;
    forwardTarget = target;
    document.getElementById('forwardNotes').value = '';
    new bootstrap.Modal(document.getElementById('forwardModal')).show();
}

function approveDocument(docId) {
    if (confirm('Yakin ingin menyetujui dokumen ini langsung?')) {
        forwardDocumentRequest(docId, 'final_approval', 'Disetujui langsung oleh Eselon IV');
    }
}

function confirmForward() {
    const notes = document.getElementById('forwardNotes').value;
    forwardDocumentRequest(currentDocumentId, forwardTarget, notes);
    bootstrap.Modal.getInstance(document.getElementById('forwardModal')).hide();
}

async function forwardDocumentRequest(docId, target, notes) {
    try {
        const response = await fetch(`/dokumen/disposisi/${docId}/forward`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                forward_to: target,
                notes: notes
            })
        });

        const data = await response.json();
        
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            });
            location.reload();
        } else {
            throw new Error(data.message || 'Gagal memproses disposisi');
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: error.message || 'Terjadi kesalahan saat memproses disposisi'
        });
    }
}
</script>
@endsection