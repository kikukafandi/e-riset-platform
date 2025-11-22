@extends('dashboard.layouts.app')
@section('title', 'Detail Kantor Bea Cukai')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Detail Kantor Bea Cukai</h1>
    
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">{{ $kantor->nama_kantor }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Kode Kantor:</strong></td>
                            <td><span class="badge badge-info">{{ $kantor->kode_kantor }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Jenis Kantor:</strong></td>
                            <td>
                                @if($kantor->jenis_kantor == 'kanwil')
                                    <span class="badge badge-primary">Kanwil</span>
                                @elseif($kantor->jenis_kantor == 'kppbc')
                                    <span class="badge badge-success">KPPBC</span>
                                @else
                                    <span class="badge badge-warning">KPU</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                @if($kantor->is_active)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Tidak Aktif</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Provinsi:</strong></td>
                            <td>{{ $kantor->provinsi }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kota:</strong></td>
                            <td>{{ $kantor->kota }}</td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $kantor->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <div class="row mt-3">
                <div class="col-12">
                    <strong>Alamat Lengkap:</strong>
                    <p class="mt-2">{{ $kantor->alamat }}</p>
                </div>
            </div>

            @if($kantor->dokumenPermohonans->count() > 0)
                <div class="row mt-4">
                    <div class="col-12">
                        <h6>Statistik Penggunaan</h6>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Kantor ini telah menjadi tujuan untuk <strong>{{ $kantor->dokumenPermohonans->count() }}</strong> permohonan penelitian.
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-between">
                <a href="{{ route('manage.kantor.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
                <div>
                    <a href="{{ route('manage.kantor.edit', $kantor->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    @if($kantor->is_active)
                        <form action="{{ route('manage.kantor.destroy', $kantor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menonaktifkan kantor ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-ban"></i> Nonaktifkan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection