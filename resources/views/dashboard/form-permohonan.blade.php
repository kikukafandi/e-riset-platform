@extends('dashboard.layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-lg border-0 rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-gradient-primary text-white p-4">
                        <div class="d-flex align-items-center">
                            <div class="bg-white bg-opacity-25 rounded-circle p-3 me-3">
                                <i class="fas fa-file-signature fa-2x"></i>
                            </div>
                            <div>
                                <h4 class="mb-1 fw-bold">Form Permohonan Riset</h4>
                                <p class="mb-0 small text-white-50">Silakan lengkapi data riset dan dokumen pendukung di bawah ini.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow border-0 rounded-4">
                    <div class="card-body p-5">
                        
                        {{-- Alerts --}}
                        @if ($errors->any())
                            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-exclamation-circle me-2 fs-5"></i>
                                    <h6 class="mb-0 fw-bold">Mohon perbaiki kesalahan berikut:</h6>
                                </div>
                                <ul class="mb-0 ps-3 small">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                                <i class="fas fa-check-circle me-2 fs-4"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                        @endif

                        <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate id="formRiset">
                            @csrf

                            <h5 class="text-primary fw-bold mb-4 border-bottom pb-2"><i class="fas fa-info-circle me-2"></i>Detail Riset</h5>
                            
                            <div class="row g-4 mb-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold">Topik/Tujuan Riset <span class="text-danger">*</span></label>
                                    <select name="topik_tujuan_riset" id="topik_riset_select" class="form-select form-select-lg bg-light" required>
                                        <option value="">-- Pilih Topik Riset --</option>
                                        @foreach ($topikRiset as $topik)
                                            <option value="{{ $topik->nama_topik }}" {{ old('topik_tujuan_riset') == $topik->nama_topik ? 'selected' : '' }}>
                                                {{ $topik->nama_topik }}
                                            </option>
                                        @endforeach
                                        <option value="tambah_topik_baru" {{ old('topik_tujuan_riset') == 'tambah_topik_baru' ? 'selected' : '' }} class="fw-bold text-primary">
                                            + Lainnya (Tambah Topik Baru)
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-12" id="kolom_topik_baru" style="display: none;">
                                    <div class="card bg-light border-primary border-opacity-25">
                                        <div class="card-body">
                                            <label class="form-label fw-semibold text-primary">Nama Topik Riset Baru</label>
                                            <input type="text" name="topik_tujuan_riset_baru" class="form-control" placeholder="Tuliskan topik riset Anda..." value="{{ old('topik_tujuan_riset_baru') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="judul_riset" class="form-label fw-semibold">Judul Riset <span class="text-danger">*</span></label>
                                    <input type="text" name="judul_riset" id="judul_riset" class="form-control form-control-lg bg-light" placeholder="Masukkan judul lengkap riset" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="kantor_tujuan" class="form-label fw-semibold">Kantor Tujuan <span class="text-danger">*</span></label>
                                    <select name="kantor_tujuan" id="kantor_tujuan" class="form-select bg-light" required>
                                        <option value="">-- Pilih Kantor Tujuan --</option>
                                        @if(isset($kantorCukai) && $kantorCukai->count() > 0)
                                            @php $kantorByProvinsi = $kantorCukai->groupBy('provinsi'); @endphp
                                            @foreach ($kantorByProvinsi as $provinsi => $kantors)
                                                <optgroup label="{{ $provinsi }}">
                                                    @foreach ($kantors as $kantor)
                                                        <option value="{{ $kantor->id }}" {{ old('kantor_tujuan') == $kantor->id ? 'selected' : '' }}>
                                                            {{ $kantor->kode_kantor ? $kantor->kode_kantor . ' - ' : '' }}{{ $kantor->nama_kantor }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        @else
                                            <option disabled>Data kantor tidak tersedia</option>
                                        @endif
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="jenis_permohonan_data" class="form-label fw-semibold">Jenis Permohonan Data</label>
                                    <input type="text" name="jenis_permohonan_data" id="jenis_permohonan_data" class="form-control bg-light" placeholder="Contoh: Data Sekunder, Wawancara..." required>
                                </div>

                                <div class="col-md-12">
                                    <label for="data_statistik_yang_diminta" class="form-label fw-semibold">Data Statistik yang Diminta (Jika ada)</label>
                                    <textarea name="data_statistik_yang_diminta" id="data_statistik_yang_diminta" class="form-control bg-light" rows="3" placeholder="Jelaskan detail data statistik yang Anda butuhkan..."></textarea>
                                </div>
                            </div>

                            <div class="mt-5">
                                <h5 class="text-primary fw-bold mb-4 border-bottom pb-2"><i class="fas fa-folder-open me-2"></i>Dokumen Pendukung</h5>
                                
                                <div class="card bg-light border-0 rounded-3 p-4">
                                    <p class="mb-3 fw-bold text-dark">Daftar Dokumen yang akan dilampirkan:</p>
                                    
                                    <div class="row g-3 mb-4">
                                        <div class="col-md-12">
                                            <div class="p-3 bg-white border rounded shadow-sm h-100">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" checked disabled id="check_proposal_dummy">
                                                    <label class="form-check-label fw-bold opacity-100" for="check_proposal_dummy">
                                                        Proposal Riset <span class="badge bg-danger ms-2">Wajib</span>
                                                    </label>
                                                </div>
                                                <div class="ms-4 mt-2">
                                                    <input type="file" name="proposal" id="proposal" class="form-control" accept=".pdf" required>
                                                    <div class="form-text small text-muted"><i class="fas fa-info-circle me-1"></i>Format PDF (Maks. 2MB)</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="p-3 bg-white border rounded shadow-sm h-100">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" checked disabled id="check_surat_pengantar_dummy">
                                                    <label class="form-check-label fw-bold opacity-100" for="check_surat_pengantar_dummy">
                                                        Surat Pengantar Kampus/Instansi <span class="badge bg-danger ms-2">Wajib</span>
                                                    </label>
                                                </div>
                                                <div class="ms-4 mt-2">
                                                    <input type="file" name="surat_pengantar" id="surat_pengantar" class="form-control" accept=".pdf" required>
                                                    <div class="form-text small text-muted"><i class="fas fa-info-circle me-1"></i>Format PDF (Maks. 2MB)</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="p-3 bg-white border rounded shadow-sm h-100">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" checked disabled id="check_surat_pernyataan_dummy">
                                                    <label class="form-check-label fw-bold opacity-100" for="check_surat_pernyataan_dummy">
                                                        Surat Pernyataan <span class="badge bg-danger ms-2">Wajib</span>
                                                    </label>
                                                </div>
                                                <div class="ms-4 mt-1">
                                                    <small class="d-block text-muted mb-2 fst-italic">
                                                        *Bersedia menyerahkan hasil riset kepada DJBC
                                                    </small>
                                                    <input type="file" name="surat_pernyataan" id="surat_pernyataan" class="form-control" accept=".pdf" required>
                                                    <div class="form-text small text-muted"><i class="fas fa-info-circle me-1"></i>Format PDF (Maks. 2MB)</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="text-muted opacity-25 my-4">
                                    <p class="mb-3 fw-bold text-dark">Dokumen Tambahan (Opsional):</p>

                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <div class="p-3 bg-white border rounded shadow-sm transition-hover">
                                                <div class="form-check">
                                                    <input class="form-check-input doc-checkbox" type="checkbox" id="check_kuisioner" data-target="upload_kuisioner">
                                                    <label class="form-check-label fw-semibold cursor-pointer" for="check_kuisioner">
                                                        Lampirkan Kuisioner
                                                    </label>
                                                </div>
                                                <div id="upload_kuisioner" class="mt-3 ms-4" style="display: none;">
                                                    <input type="file" name="kuisioner" class="form-control" accept=".pdf,.doc,.docx">
                                                    <div class="form-text small">Format: PDF/DOCX (Maks. 2MB)</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="p-3 bg-white border rounded shadow-sm transition-hover">
                                                <div class="form-check">
                                                    <input class="form-check-input doc-checkbox" type="checkbox" id="check_wawancara" data-target="upload_wawancara">
                                                    <label class="form-check-label fw-semibold cursor-pointer" for="check_wawancara">
                                                        Lampirkan Pedoman Wawancara
                                                    </label>
                                                </div>
                                                <div id="upload_wawancara" class="mt-3 ms-4" style="display: none;">
                                                    <input type="file" name="pedoman_wawancara" class="form-control" accept=".pdf,.doc,.docx">
                                                    <div class="form-text small">Format: PDF/DOCX (Maks. 2MB)</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="p-3 bg-white border rounded shadow-sm transition-hover">
                                                <div class="form-check">
                                                    <input class="form-check-input doc-checkbox" type="checkbox" id="check_fgd" data-target="upload_fgd">
                                                    <label class="form-check-label fw-semibold cursor-pointer" for="check_fgd">
                                                        Lampirkan Proposal FGD
                                                    </label>
                                                </div>
                                                <div id="upload_fgd" class="mt-3 ms-4" style="display: none;">
                                                    <input type="file" name="proposal_fgd" class="form-control" accept=".pdf,.doc,.docx">
                                                    <div class="form-text small">Format: PDF/DOCX (Maks. 2MB)</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                                <button type="button" class="btn btn-light btn-lg me-3 px-4 border" onclick="window.history.back()">Batal</button>
                                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm" id="submitBtn">
                                    <span id="submitText"><i class="fas fa-paper-plane me-2"></i>Kirim Permohonan</span>
                                    <span id="submitSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
        }
        .form-control:focus, .form-select:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        }
        .transition-hover {
            transition: all 0.3s ease;
        }
        .transition-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 .5rem 1rem rgba(0,0,0,.05)!important;
            border-color: #0d6efd !important;
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // === 1. Logic Topik Riset Baru ===
            const topikSelect = document.getElementById('topik_riset_select');
            const topikBaruDiv = document.getElementById('kolom_topik_baru');
            const topikBaruInput = topikBaruDiv.querySelector('input');

            function toggleTopikBaru(val) {
                if (val === 'tambah_topik_baru') {
                    topikBaruDiv.style.display = 'block';
                    topikBaruInput.setAttribute('required', 'true');
                } else {
                    topikBaruDiv.style.display = 'none';
                    topikBaruInput.removeAttribute('required');
                    topikBaruInput.value = '';
                }
            }

            if (topikSelect) {
                toggleTopikBaru(topikSelect.value);
                topikSelect.addEventListener('change', function() {
                    toggleTopikBaru(this.value);
                });
            }

            // === 2. Logic Checkbox Dokumen (Expand/Collapse Manual) ===
            const checkboxes = document.querySelectorAll('.doc-checkbox');
            
            checkboxes.forEach(checkbox => {
                const targetId = checkbox.getAttribute('data-target');
                const targetDiv = document.getElementById(targetId);
                
                // Init State
                if (checkbox.checked) {
                    targetDiv.style.display = 'block';
                }

                // Event Listener
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        targetDiv.style.display = 'block';
                        targetDiv.style.opacity = 0;
                        setTimeout(() => {
                            targetDiv.style.transition = 'opacity 0.3s ease';
                            targetDiv.style.opacity = 1;
                        }, 10);
                    } else {
                        targetDiv.style.display = 'none';
                        const fileInput = targetDiv.querySelector('input[type="file"]');
                        if (fileInput) fileInput.value = ''; // Reset input
                    }
                });
            });

            // === 3. Validasi Ukuran File ===
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function() {
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    if (this.files[0] && this.files[0].size > maxSize) {
                        alert('Ukuran file terlalu besar! Maksimal 2MB.');
                        this.value = ''; 
                        this.classList.add('is-invalid');
                    } else {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    }
                });
            });

            // === 4. Loading State ===
            const form = document.getElementById('formRiset');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');

            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!form.checkValidity()) {
                        e.preventDefault();
                        e.stopPropagation();
                        form.classList.add('was-validated');
                        
                        // Scroll to error
                        const firstError = form.querySelector(':invalid');
                        if(firstError) {
                            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            firstError.focus();
                        }
                        return; 
                    }

                    submitBtn.disabled = true;
                    submitText.textContent = 'Sedang Mengirim...';
                    submitSpinner.classList.remove('d-none');
                });
            }
        });
    </script>
@endpush