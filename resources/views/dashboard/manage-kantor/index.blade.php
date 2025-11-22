@extends('dashboard.layouts.app')
@section('title', 'Manage Kantor Bea Cukai')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Manage Kantor Bea Cukai</h1>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('manage.kantor.create') }}" class="btn btn-primary mb-3">Tambah Kantor Bea Cukai</a>
    
    <!-- Filter Section -->
    <div class="row mb-3">
        <div class="col-md-4">
            <select class="form-control" id="filter-provinsi" placeholder="Filter Provinsi">
                <option value="">Semua Provinsi</option>
                @foreach(App\Http\Controllers\KantorBeaCukaiController::getProvinces() as $provinsi)
                    <option value="{{ $provinsi }}">{{ $provinsi }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select class="form-control" id="filter-jenis">
                <option value="">Semua Jenis</option>
                <option value="kanwil">Kanwil</option>
                <option value="kppbc">KPPBC</option>
                <option value="kpu">KPU</option>
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="kantorTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Kode Kantor</th>
                    <th>Nama Kantor</th>
                    <th>Jenis</th>
                    <th>Provinsi</th>
                    <th>Kota</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kantors as $kantor)
                    <tr data-provinsi="{{ $kantor->provinsi }}" data-jenis="{{ $kantor->jenis_kantor }}">
                        <td>{{ $loop->iteration + ($kantors->currentPage() - 1) * $kantors->perPage() }}</td>
                        <td><span class="badge badge-info">{{ $kantor->kode_kantor }}</span></td>
                        <td>{{ $kantor->nama_kantor }}</td>
                        <td>
                            @if($kantor->jenis_kantor == 'kanwil')
                                <span class="badge badge-primary">Kanwil</span>
                            @elseif($kantor->jenis_kantor == 'kppbc')
                                <span class="badge badge-success">KPPBC</span>
                            @else
                                <span class="badge badge-warning">KPU</span>
                            @endif
                        </td>
                        <td>{{ $kantor->provinsi }}</td>
                        <td>{{ $kantor->kota }}</td>
                        <td>{{ Str::limit($kantor->alamat, 50) }}</td>
                        <td>
                            <a href="{{ route('manage.kantor.edit', $kantor->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('manage.kantor.destroy', $kantor->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menonaktifkan kantor ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Nonaktifkan</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada kantor bea cukai</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $kantors->links() }}
    </div>
</div>

<script>
// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const provinsiFilter = document.getElementById('filter-provinsi');
    const jenisFilter = document.getElementById('filter-jenis');
    const tableRows = document.querySelectorAll('#kantorTable tbody tr');

    function filterTable() {
        const selectedProvinsi = provinsiFilter.value;
        const selectedJenis = jenisFilter.value;

        tableRows.forEach(row => {
            const provinsi = row.getAttribute('data-provinsi');
            const jenis = row.getAttribute('data-jenis');
            
            const provinsiMatch = !selectedProvinsi || provinsi === selectedProvinsi;
            const jenisMatch = !selectedJenis || jenis === selectedJenis;
            
            if (provinsiMatch && jenisMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    provinsiFilter.addEventListener('change', filterTable);
    jenisFilter.addEventListener('change', filterTable);
});
</script>
@endsection