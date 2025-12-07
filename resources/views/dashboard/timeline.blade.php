@extends('dashboard.layouts.app')
@section('title', 'Timeline Permohonan')
@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Timeline Permohonan Riset</h1>
        
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($documents->count() > 0)
            @foreach($documents as $dokumen)
                <div class="row mb-4">
                    <div class="col-md-10 mx-auto">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="fas fa-clock"></i> Timeline Permohonan
                                </h5>
                                <small class="text-muted">{{ $dokumen->judul_riset }}</small>
                            </div>
                    <div class="card-body">
                        <!-- Progress Bar -->
                        <div class="mb-4">
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    style="width: {{ $dokumen->getTimelinePercentage() }}%"
                                    aria-valuenow="{{ $dokumen->getTimelinePercentage() }}" aria-valuemin="0"
                                    aria-valuemax="100">
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <small class="text-muted">Progress: {{ $dokumen->getTimelinePercentage() }}%</small>
                            </div>
                        </div>

                        <!-- Timeline Steps -->
                        <div class="timeline">
                            <!-- Step 1: Draft -->
                            <div
                                class="timeline-item {{ $dokumen->tanggal_draft || $dokumen->created_at ? 'completed' : 'pending' }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Draft Permohonan</h6>
                                    <p class="text-muted mb-1">Permohonan telah dibuat</p>
                                    @if ($dokumen->created_at)
                                        <small class="text-success">
                                            <i class="fas fa-check"></i> {{ $dokumen->created_at->format('d M Y, H:i') }}
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 2: Processing -->
                            <div
                                class="timeline-item {{ $dokumen->tanggal_submit || $dokumen->status !== 'diproses' ? 'completed' : ($dokumen->status === 'diproses' ? 'active' : 'pending') }}">
                                <div class="timeline-marker">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6>Permohonan Diproses</h6>
                                    <p class="text-muted mb-1">Sedang dalam tahap review dan validasi</p>
                                    @if ($dokumen->tanggal_submit)
                                        <small class="text-success">
                                            <i class="fas fa-check"></i>
                                            {{ $dokumen->tanggal_submit->format('d M Y, H:i') }}
                                        </small>
                                    @elseif($dokumen->status === 'diproses')
                                        <small class="text-warning">
                                            <i class="fas fa-clock"></i> Sedang diproses
                                        </small>
                                    @endif
                                </div>
                            </div>

                            <!-- Step 3: Approved -->
                            <div
                                class="timeline-item {{ $dokumen->status === 'diterima' ? 'completed' : ($dokumen->status === 'ditolak' ? 'rejected' : 'pending') }}">
                                <div class="timeline-marker">
                                    @if ($dokumen->status === 'ditolak')
                                        <i class="fas fa-times"></i>
                                    @else
                                        <i class="fas fa-check"></i>
                                    @endif
                                </div>
                                <div class="timeline-content">
                                    <h6>Persetujuan TTE</h6>
                                    @if ($dokumen->status === 'diterima')
                                        <p class="text-success mb-1">Permohonan disetujui</p>
                                        @if ($dokumen->tanggal_persetujuan)
                                            <small class="text-success">
                                                <i class="fas fa-check"></i>
                                                {{ \Carbon\Carbon::parse($dokumen->tanggal_persetujuan)->format('d M Y') }}
                                            </small>
                                        @endif
                                        @if ($dokumen->deadline_penelitian)
                                            <br><small class="text-info">
                                                <i class="fas fa-calendar-alt"></i> Deadline:
                                                {{ \Carbon\Carbon::parse($dokumen->deadline_penelitian)->format('d M Y') }}
                                            </small>
                                        @endif

                                        {{-- Surat Persetujuan --}}
                                        @if ($dokumen->generated_letter_path)
                                            <div class="mt-3 p-3 bg-success bg-opacity-10 rounded border border-success">
                                                <h6 class="text-success mb-2">
                                                    <i class="fas fa-file-signature"></i> Surat Persetujuan Riset
                                                </h6>
                                                <p class="mb-2 small text-muted">Surat persetujuan riset Anda telah diterbitkan dan dapat diunduh.</p>
                                                <a href="{{ Storage::url($dokumen->generated_letter_path) }}" target="_blank" class="btn btn-success btn-sm">
                                                    <i class="fas fa-download"></i> Unduh Surat Persetujuan
                                                </a>
                                                @if($dokumen->letter_generated_at)
                                                    <br><small class="text-muted mt-2 d-block">
                                                        <i class="fas fa-clock"></i> Diterbitkan: {{ \Carbon\Carbon::parse($dokumen->letter_generated_at)->format('d M Y, H:i') }}
                                                    </small>
                                                @endif
                                            </div>
                                        @endif

                                    @elseif($dokumen->status === 'ditolak')
                                        <p class="text-danger mb-1">Permohonan ditolak</p>
                                        <small class="text-danger">
                                            <i class="fas fa-times"></i> {{ $dokumen->updated_at->format('d M Y, H:i') }}
                                        </small>
                                        @if($dokumen->admin_validation_message)
                                            <div class="mt-2 p-2 bg-danger bg-opacity-10 rounded">
                                                <small class="text-danger"><strong>Alasan:</strong> {{ $dokumen->admin_validation_message }}</small>
                                            </div>
                                        @endif

                                        {{-- Surat Penolakan --}}
                                        @if ($dokumen->generated_letter_path)
                                            <div class="mt-3 p-3 bg-danger bg-opacity-10 rounded border border-danger">
                                                <h6 class="text-danger mb-2">
                                                    <i class="fas fa-file-alt"></i> Surat Penolakan
                                                </h6>
                                                <a href="{{ Storage::url($dokumen->generated_letter_path) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                                    <i class="fas fa-download"></i> Unduh Surat Penolakan
                                                </a>
                                                @if($dokumen->letter_generated_at)
                                                    <br><small class="text-muted mt-2 d-block">
                                                        <i class="fas fa-clock"></i> Diterbitkan: {{ \Carbon\Carbon::parse($dokumen->letter_generated_at)->format('d M Y, H:i') }}
                                                    </small>
                                                @endif
                                            </div>
                                        @endif
                                    @else
                                        <p class="text-muted mb-1">Menunggu persetujuan pejabat</p>
                                        
                                        {{-- Status verifikasi --}}
                                        @if($dokumen->tanggal_validasi_admin)
                                            <small class="text-success d-block">
                                                <i class="fas fa-check-circle"></i> Verifikasi berkas: Selesai
                                            </small>
                                        @endif
                                        @if($dokumen->tanggal_verifikasi_pejabat)
                                            <small class="text-success d-block">
                                                <i class="fas fa-check-circle"></i> Verifikasi tema: Selesai
                                            </small>
                                        @endif
                                        @if($dokumen->tanggal_validasi_admin && $dokumen->tanggal_verifikasi_pejabat)
                                            <small class="text-info d-block mt-1">
                                                <i class="fas fa-hourglass-half"></i> Menunggu TTE pejabat...
                                            </small>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            @if ($dokumen->status === 'diterima')
                                <!-- Step 4: Research Period -->
                                <div
                                    class="timeline-item {{ $dokumen->tanggal_mulai_riset ? 'completed' : ($dokumen->status_penelitian === 'sedang_berjalan' ? 'active' : 'pending') }}">
                                    <div class="timeline-marker">
                                        <i class="fas fa-microscope"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Periode Riset</h6>
                                        @if ($dokumen->tanggal_mulai_riset)
                                            <p class="text-success mb-1">Riset sedang berjalan</p>
                                            <small class="text-success">
                                                <i class="fas fa-play"></i> Dimulai:
                                                {{ $dokumen->tanggal_mulai_riset->format('d M Y') }}
                                            </small>
                                        @else
                                            <p class="text-muted mb-1">Menunggu untuk memulai riset</p>
                                        @endif

                                        <!-- Paper Submission Section -->
                                        @if ($dokumen->canSubmitPaper())
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#paperSubmissionModal{{ $dokumen->id }}">
                                                    <i class="fas fa-upload"></i> Submit Paper
                                                </button>
                                            </div>
                                        @elseif($dokumen->paper_file)
                                            <div class="mt-3">
                                                <div class="alert alert-info">
                                                    <strong>Paper Status:</strong>
                                                    @if ($dokumen->paper_validation_status === 'pending')
                                                        <span class="badge badge-warning">Menunggu Validasi</span>
                                                    @elseif($dokumen->paper_validation_status === 'valid')
                                                        <span class="badge badge-success">Valid</span>
                                                    @elseif($dokumen->paper_validation_status === 'invalid')
                                                        <span class="badge badge-danger">Invalid</span>
                                                        @if ($dokumen->paper_validation_message)
                                                            <br><small>{{ $dokumen->paper_validation_message }}</small>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Step 5: Completion -->
                                <div
                                    class="timeline-item {{ $dokumen->status_penelitian === 'selesai' ? 'completed' : 'pending' }}">
                                    <div class="timeline-marker">
                                        <i class="fas fa-flag-checkered"></i>
                                    </div>
                                    <div class="timeline-content">
                                        <h6>Penyelesaian Riset</h6>
                                        @if ($dokumen->status_penelitian === 'selesai')
                                            <p class="text-success mb-1">Riset telah diselesaikan</p>
                                            <small class="text-success">
                                                <i class="fas fa-check"></i>
                                                {{ $dokumen->updated_at->format('d M Y, H:i') }}
                                            </small>
                                        @else
                                            <p class="text-muted mb-1">Menunggu penyelesaian riset</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('dokumen.show', $dokumen->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                    <small class="text-muted align-self-center">
                                        Diajukan: {{ $dokumen->created_at->format('d M Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                            <h5>Belum Ada Permohonan</h5>
                            <p class="text-muted">Anda belum memiliki permohonan riset. Silakan buat permohonan baru.</p>
                            <a href="{{ route('dashboardPengajuan') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Buat Permohonan Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    <!-- Paper Submission Modal (Dynamic per document) -->
    @if($documents->count() > 0)
        @foreach($documents as $dokumen)
            @if ($dokumen->canSubmitPaper())
                <div class="modal fade" id="paperSubmissionModal{{ $dokumen->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Submit Paper Riset</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('timeline.submit.paper', $dokumen->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <strong>{{ $dokumen->judul_riset }}</strong>
                                    </div>
                                    <div class="mb-3">
                                        <label for="paper_file{{ $dokumen->id }}" class="form-label">File Paper (PDF) <span
                                                class="text-danger">*</span></label>
                                        <input type="file" name="paper_file" id="paper_file{{ $dokumen->id }}" class="form-control"
                                            accept=".pdf" required>
                                        <small class="form-text text-muted">Upload paper riset dalam format PDF (maksimal
                                            10MB)</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="doi_number{{ $dokumen->id }}" class="form-label">DOI Number</label>
                                        <input type="text" name="doi_number" id="doi_number{{ $dokumen->id }}" class="form-control"
                                            placeholder="Contoh: 10.1234/example.2023.001">
                                        <small class="form-text text-muted">Opsional: Masukkan DOI number jika tersedia</small>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-upload"></i> Submit Paper
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

    <style>
        .timeline {
            position: relative;
            padding: 0;
            list-style: none;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 30px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #dee2e6;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            padding-left: 70px;
        }

        .timeline-marker {
            position: absolute;
            left: 20px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            z-index: 1;
        }

        .timeline-item.completed .timeline-marker {
            background: #28a745;
            color: white;
            border: 2px solid #28a745;
        }

        .timeline-item.active .timeline-marker {
            background: #ffc107;
            color: #212529;
            border: 2px solid #ffc107;
            animation: pulse 2s infinite;
        }

        .timeline-item.pending .timeline-marker {
            background: #6c757d;
            color: white;
            border: 2px solid #6c757d;
        }

        .timeline-item.rejected .timeline-marker {
            background: #dc3545;
            color: white;
            border: 2px solid #dc3545;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }
    </style>
@endsection
