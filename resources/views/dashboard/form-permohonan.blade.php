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
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('dokumen.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="topik" class="form-label">Topik</label>
                            <select name="topik" id="topik" class="form-select" required>
                                <option value="" disabled selected>Pilih Topik</option>
                                <option value="Kesehatan">Kesehatan</option>
                                <option value="Pendidikan">Pendidikan</option>
                                <option value="Ekonomi">Ekonomi</option>
                                <option value="Sosial">Sosial</option>
                                <option value="Lingkungan">Lingkungan</option>
                                <option value="Teknologi">Teknologi</option>
                                <option value="Budaya">Budaya</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="judul_riset" class="form-label">Judul Riset</label>
                            <input type="text" name="judul_riset" id="judul_riset" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="proposal" class="form-label">Proposal (PDF)</label>
                            <input type="file" name="proposal" id="proposal" class="form-control" accept=".pdf" required>
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
                            <label for="data_statistik_yang_diminta" class="form-label">Data Statistik yang Diminta</label>
                            <textarea name="data_statistik_yang_diminta" id="data_statistik_yang_diminta" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="kuisioner" class="form-label">Kuisioner (PDF/DOCX)</label>
                            <input type="file" name="kuisioner" id="kuisioner" class="form-control" accept=".pdf,.doc,.docx">
                        </div>

                        <div class="mb-3">
                            <label for="pedoman_wawancara" class="form-label">Pedoman Wawancara (PDF/DOCX)</label>
                            <input type="file" name="pedoman_wawancara" id="pedoman_wawancara" class="form-control" accept=".pdf,.doc,.docx">
                        </div>

                        <div class="mb-3">
                            <label for="proposal_fgd" class="form-label">Proposal FGD (PDF/DOCX)</label>
                            <input type="file" name="proposal_fgd" id="proposal_fgd" class="form-control" accept=".pdf,.doc,.docx">
                        </div>


                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Kirim Permohonan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
