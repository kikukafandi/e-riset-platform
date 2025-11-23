@extends('dashboard.layouts.app')
@section('title', 'Monitor Penyelesaian Riset')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Monitor Penyelesaian Riset</h1>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $overdueResearch->total() }}</h4>
                            <p class="mb-0">Riset Terlambat</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $completedResearch->total() }}</h4>
                            <p class="mb-0">Riset Selesai</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="approvedCount">-</h4>
                            <p class="mb-0">Total Disetujui</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clipboard-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 id="bannedCount">-</h4>
                            <p class="mb-0">Peneliti Diblokir</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-slash fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="researchTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overdue-tab" data-bs-toggle="tab" data-bs-target="#overdue" type="button" role="tab" aria-controls="overdue" aria-selected="true">
                <i class="fas fa-exclamation-triangle text-danger"></i> Riset Terlambat
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab" aria-controls="completed" aria-selected="false">
                <i class="fas fa-check-circle text-success"></i> Riset Selesai
            </button>
        </li>
    </ul>

    <div class="tab-content" id="researchTabsContent">
        <!-- Overdue Research Tab -->
        <div class="tab-pane fade show active" id="overdue" role="tabpanel" aria-labelledby="overdue-tab">
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Penelitian yang Terlambat</h5>
                </div>
                <div class="card-body">
                    @if($overdueResearch->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul Riset</th>
                                        <th>Peneliti</th>
                                        <th>Kantor Tujuan</th>
                                        <th>Tanggal Persetujuan</th>
                                        <th>Deadline</th>
                                        <th>Terlambat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($overdueResearch as $research)
                                        <tr>
                                            <td>{{ $loop->iteration + ($overdueResearch->currentPage() - 1) * $overdueResearch->perPage() }}</td>
                                            <td>
                                                <strong>{{ Str::limit($research->judul_riset, 40) }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $research->topik_tujuan_riset }}</small>
                                            </td>
                                            <td>
                                                {{ $research->user->nama_lengkap }}
                                                <br>
                                                <small class="text-muted">{{ $research->user->email }}</small>
                                            </td>
                                            <td>
                                                @if($research->kantorBeaCukai)
                                                    <span class="badge badge-info">{{ $research->kantorBeaCukai->kode_kantor }}</span>
                                                    <br>
                                                    <small>{{ $research->kantorBeaCukai->nama_kantor }}</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $research->tanggal_persetujuan ? $research->tanggal_persetujuan->format('d M Y') : '-' }}
                                            </td>
                                            <td>
                                                {{ $research->deadline_penelitian ? $research->deadline_penelitian->format('d M Y') : '-' }}
                                            </td>
                                            <td>
                                                @if($research->deadline_penelitian)
                                                    <span class="badge badge-danger">
                                                        {{ $research->deadline_penelitian->diffForHumans() }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $research->status_penelitian == 'terlambat' ? 'danger' : 'warning' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $research->status_penelitian)) }}
                                                </span>
                                                @if(!$research->dapat_perijinan_lagi)
                                                    <br><small class="text-danger">Diblokir</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $overdueResearch->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5>Tidak ada penelitian yang terlambat</h5>
                            <p class="text-muted">Semua penelitian yang disetujui masih dalam batas waktu atau sudah selesai.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Completed Research Tab -->
        <div class="tab-pane fade" id="completed" role="tabpanel" aria-labelledby="completed-tab">
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">Penelitian yang Telah Selesai</h5>
                </div>
                <div class="card-body">
                    @if($completedResearch->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Judul Riset</th>
                                        <th>Peneliti</th>
                                        <th>Tanggal Selesai</th>
                                        <th>DOI Number</th>
                                        <th>File Paper</th>
                                        <th>Durasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($completedResearch as $research)
                                        <tr>
                                            <td>{{ $loop->iteration + ($completedResearch->currentPage() - 1) * $completedResearch->perPage() }}</td>
                                            <td>
                                                <strong>{{ Str::limit($research->judul_riset, 40) }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $research->topik_tujuan_riset }}</small>
                                            </td>
                                            <td>
                                                {{ $research->user->nama_lengkap }}
                                                <br>
                                                <small class="text-muted">{{ $research->user->email }}</small>
                                            </td>
                                            <td>{{ $research->updated_at->format('d M Y') }}</td>
                                            <td>
                                                @if($research->doi_number)
                                                    <span class="badge badge-success">{{ $research->doi_number }}</span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($research->file_paper_pdf)
                                                    <a href="{{ Storage::url($research->file_paper_pdf) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-file-pdf"></i> Lihat PDF
                                                    </a>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($research->tanggal_persetujuan && $research->updated_at)
                                                    <span class="badge badge-info">
                                                        {{ $research->tanggal_persetujuan->diffInDays($research->updated_at) }} hari
                                                    </span>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center">
                            {{ $completedResearch->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5>Belum ada penelitian yang selesai</h5>
                            <p class="text-muted">Penelitian yang telah diselesaikan akan muncul di sini.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h6>Aksi Sistem</h6>
                    <button type="button" class="btn btn-warning" onclick="updateOverdueResearch()">
                        <i class="fas fa-sync-alt"></i> Update Status Riset Terlambat
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Load additional statistics
document.addEventListener('DOMContentLoaded', function() {
    loadResearchStats();
});

function loadResearchStats() {
    fetch('{{ route("statistics.research.completion") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('approvedCount').textContent = data.total_approved_research;
            document.getElementById('bannedCount').textContent = data.banned_researchers.length;
        })
        .catch(error => {
            console.error('Error loading research stats:', error);
        });
}

function updateOverdueResearch() {
    if (confirm('Yakin ingin melakukan update status riset terlambat? Ini akan memperbarui status semua riset yang melewati deadline.')) {
        const button = event.target;
        const originalText = button.innerHTML;
        
        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
        button.disabled = true;
        
        fetch('{{ route("update.overdue.research") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            location.reload(); // Refresh page to show updated data
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memperbarui status riset.');
        })
        .finally(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        });
    }
}
</script>
@endsection