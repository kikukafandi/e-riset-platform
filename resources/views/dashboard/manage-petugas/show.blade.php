@extends('dashboard.layouts.app')

@section('content')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Detail Dokumen Permohonan</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dokumen.index') }}">Data Dokumen</a></li>
            <li class="breadcrumb-item active">Detail Dokumen</li>
        </ol>

        <div class="card mb-4">
            <div class="card-header">
                <strong>{{ $dokumen->judul_riset }}</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Nama Pemohon</th>
                        <td>{{ $dokumen->user->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Instansi</th>
                        <td>{{ $dokumen->user->instansi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Unit Kerja / Lokasi Riset</th>
                        <td>{{ $dokumen->unit_kerja_lokasi_riset }}</td>
                    </tr>
                    <tr>
                        <th>Jenis Permohonan Data</th>
                        <td>{{ $dokumen->jenis_permohonan_data }}</td>
                    </tr>
                    <tr>
                        <th>Data Statistik yang Diminta</th>
                        <td>{{ $dokumen->data_statistik_yang_diminta ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($dokumen->status === 'diproses')
                                <span class="badge bg-warning text-dark">Diproses</span>
                            @elseif($dokumen->status === 'diterima')
                                <span class="badge bg-success">Diterima</span>
                            @elseif($dokumen->status === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">Dokumen Tidak Lengkap</span>
                            @endif
                        </td>
                    </tr>
                </table>

                <hr>
                <h5>📄 Dokumen Pendukung</h5>
                <ul class="list-group">
                    @if($dokumen->proposal)
                        <li class="list-group-item">
                            Proposal: 
                            <a href="{{ asset('storage/'.$dokumen->proposal) }}" target="_blank" class="btn btn-sm btn-primary">
                                Lihat PDF
                            </a>
                        </li>
                    @endif

                    @if($dokumen->kuisioner)
                        <li class="list-group-item">
                            Kuisioner: 
                            <a href="{{ asset('storage/'.$dokumen->kuisioner) }}" target="_blank" class="btn btn-sm btn-primary">
                                Lihat PDF
                            </a>
                        </li>
                    @endif

                    @if($dokumen->pedoman_wawancara)
                        <li class="list-group-item">
                            Pedoman Wawancara: 
                            <a href="{{ asset('storage/'.$dokumen->pedoman_wawancara) }}" target="_blank" class="btn btn-sm btn-primary">
                                Lihat PDF
                            </a>
                        </li>
                    @endif

                    @if($dokumen->proposal_fgd)
                        <li class="list-group-item">
                            Proposal FGD: 
                            <a href="{{ asset('storage/'.$dokumen->proposal_fgd) }}" target="_blank" class="btn btn-sm btn-primary">
                                Lihat PDF
                            </a>
                        </li>
                    @endif
                </ul>

                <div class="mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
