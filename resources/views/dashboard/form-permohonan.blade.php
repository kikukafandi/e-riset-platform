@extends('dashboard.layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Form Permohonan Riset</h4>
                    </div>
                    <div class="card-body">
                        {{-- Error Message --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-exclamation-triangle"></i> Terjadi Kesalahan:</h6>
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Database Error --}}
                        @error('database')
                            <div class="alert alert-danger">
                                <h6><i class="fas fa-database"></i> Error Database:</h6>
                                {{ $message }}
                            </div>
                        @enderror

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label>Topik/Tujuan Riset</label>
                                <select name="topik_tujuan_riset" id="topik_riset_select" class="form-control" required>
                                    <option value="">-- Pilih Topik Riset --</option>

                                    {{-- Loop data $topikRiset (dari langkah kita sebelumnya) --}}
                                    @foreach ($topikRiset as $topik)
                                        <option value="{{ $topik->nama_topik }}"
                                            {{ old('topik_tujuan_riset') == $topik->nama_topik ? 'selected' : '' }}>
                                            {{ $topik->nama_topik }}
                                        </option>
                                    @endforeach

                                    {{-- INI ADALAH OPSI BARU YANG KAMU MINTA --}}
                                    <option value="tambah_topik_baru"
                                        {{ old('topik_tujuan_riset') == 'tambah_topik_baru' ? 'selected' : '' }}>
                                        -- Lainnya (Tambah Topik Baru) --
                                    </option>
                                </select>
                                @error('topik_tujuan_riset')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3" id="kolom_topik_baru" style="display: none;">
                                <label>Nama Topik Riset Baru</label>
                                <input type="text" name="topik_tujuan_riset_baru" class="form-control"
                                    value="{{ old('topik_tujuan_riset_baru') }}">

                                {{-- Tampilkan error jika validasi gagal untuk input baru ini --}}
                                @error('topik_tujuan_riset_baru')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="judul_riset" class="form-label">Judul Riset</label>
                                <input type="text" name="judul_riset" id="judul_riset" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="proposal" class="form-label">Proposal (PDF) <span class="text-danger">*</span></label>
                                <input type="file" name="proposal" id="proposal" class="form-control" accept=".pdf"
                                    required>
                                <small class="form-text text-muted">
                                    Upload file proposal dalam format PDF (maksimal 2MB)
                                </small>
                                @error('proposal')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                                @error('upload')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="kantor_tujuan" class="form-label">Kantor Tujuan <span class="text-danger">*</span></label>
                                <select name="kantor_tujuan" id="kantor_tujuan" class="form-control" required>
                                    <option value="">-- Pilih Kantor Tujuan --</option>
                                    @if(isset($kantorCukai) && $kantorCukai->count() > 0)
                                        @php
                                            $kantorByProvinsi = $kantorCukai->groupBy('provinsi');
                                        @endphp
                                        @foreach ($kantorByProvinsi as $provinsi => $kantors)
                                            <optgroup label="{{ $provinsi }}">
                                                @foreach ($kantors as $kantor)
                                                    <option value="{{ $kantor->id }}"
                                                        {{ old('kantor_tujuan') == $kantor->id ? 'selected' : '' }}>
                                                        {{ $kantor->kode_kantor ? $kantor->kode_kantor . ' - ' : '' }}{{ $kantor->nama_kantor }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    @else
                                        <option disabled>Data kantor tidak tersedia</option>
                                    @endif
                                </select>
                                <small class="form-text text-muted">Pilih kantor bea cukai tujuan untuk penelitian Anda</small>
                            </div>

                            <div class="mb-3">
                                <label for="unit_kerja_lokasi_riset" class="form-label">Unit Kerja / Lokasi Riset</label>
                                <textarea name="unit_kerja_lokasi_riset" id="unit_kerja_lokasi_riset" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="jenis_permohonan_data" class="form-label">Jenis Permohonan Data</label>
                                <textarea name="jenis_permohonan_data" id="jenis_permohonan_data" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="data_statistik_yang_diminta" class="form-label">Data Statistik yang
                                    Diminta</label>
                                <textarea name="data_statistik_yang_diminta" id="data_statistik_yang_diminta" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="kuisioner" class="form-label">Kuisioner (PDF/DOCX)</label>
                                <input type="file" name="kuisioner" id="kuisioner" class="form-control"
                                    accept=".pdf,.doc,.docx">
                                <small class="form-text text-muted">Opsional: Upload kuisioner (maksimal 2MB)</small>
                                @error('kuisioner')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pedoman_wawancara" class="form-label">Pedoman Wawancara (PDF/DOCX)</label>
                                <input type="file" name="pedoman_wawancara" id="pedoman_wawancara" class="form-control"
                                    accept=".pdf,.doc,.docx">
                                <small class="form-text text-muted">Opsional: Upload pedoman wawancara (maksimal 2MB)</small>
                                @error('pedoman_wawancara')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="proposal_fgd" class="form-label">Proposal FGD (PDF/DOCX)</label>
                                <input type="file" name="proposal_fgd" id="proposal_fgd" class="form-control"
                                    accept=".pdf,.doc,.docx">
                                <small class="form-text text-muted">Opsional: Upload proposal FGD (maksimal 2MB)</small>
                                @error('proposal_fgd')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success" id="submitBtn">
                                    <span id="submitText">Kirim Permohonan</span>
                                    <span id="submitSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        // Pastikan skrip berjalan setelah halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {

            // Ambil elemen-elemen yang kita butuhkan
            const topikSelect = document.getElementById('topik_riset_select');
            const topikBaruDiv = document.getElementById('kolom_topik_baru');
            const topikBaruInput = topikBaruDiv.querySelector('input'); // Input teks di dalamnya

            // Buat fungsi untuk menampilkan/menyembunyikan input
            function toggleTopikBaru(selectedValue) {
                if (selectedValue === 'tambah_topik_baru') {
                    topikBaruDiv.style.display = 'block'; // Tampilkan div
                    topikBaruInput.setAttribute('required', 'true'); // Jadikan input teks ini wajib
                } else {
                    topikBaruDiv.style.display = 'none'; // Sembunyikan div
                    topikBaruInput.removeAttribute('required'); // Hapus kewajiban
                    topikBaruInput.value = ''; // Kosongkan nilainya
                }
            }

            // 1. Cek nilai saat halaman pertama kali dimuat 
            //    (penting jika ada error validasi dan halaman di-refresh)
            toggleTopikBaru(topikSelect.value);

            // 2. Tambahkan 'event listener' saat nilai dropdown berubah
            topikSelect.addEventListener('change', function() {
                toggleTopikBaru(this.value);
            });

            // Handle form submission with loading indicator
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');

            form.addEventListener('submit', function(e) {
                // Validate file size before submission
                const proposalFile = document.getElementById('proposal').files[0];
                if (proposalFile && proposalFile.size > 2 * 1024 * 1024) {
                    e.preventDefault();
                    alert('Ukuran file proposal tidak boleh lebih dari 2MB');
                    return;
                }

                // Show loading state
                submitBtn.disabled = true;
                submitText.textContent = 'Mengupload...';
                submitSpinner.classList.remove('d-none');
            });

            // Add file size validation for all file inputs
            document.querySelectorAll('input[type="file"]').forEach(input => {
                input.addEventListener('change', function() {
                    const maxSize = 2 * 1024 * 1024; // 2MB for all files
                    
                    if (this.files[0] && this.files[0].size > maxSize) {
                        alert(`Ukuran file tidak boleh lebih dari 2MB`);
                        this.value = '';
                    }
                });
            });
        });
    </script>
@endpush
