@extends('dashboard.layouts.app')
@section('title', 'Kelola Kantor Bea Cukai')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-building me-2"></i>Kelola Kantor Bea Cukai
            </h1>
            <p class="text-muted small mb-0">Manajemen data kantor bea cukai seluruh Indonesia</p>
        </div>
        <a href="{{ route('manage.kantor.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus-circle me-1"></i> Tambah Kantor Baru
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kantor</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kantors->total() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Kanwil</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="kanwil-count">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-landmark fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">KPPBC</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="kppbc-count">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">KPU</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="kpu-count">-</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filter Data
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label small text-muted">Provinsi</label>
                    <select class="form-select" id="filter-provinsi">
                        <option value="">Semua Provinsi</option>
                        @foreach(App\Http\Controllers\KantorBeaCukaiController::getProvinces() as $provinsi)
                            <option value="{{ $provinsi }}">{{ $provinsi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label small text-muted">Jenis Kantor</label>
                    <select class="form-select" id="filter-jenis">
                        <option value="">Semua Jenis</option>
                        <option value="kanwil">Kanwil</option>
                        <option value="kppbc">KPPBC</option>
                        <option value="kpu">KPU</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label small text-muted">Pencarian</label>
                    <input type="text" class="form-control" id="search-input" placeholder="Cari nama atau kode kantor...">
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Daftar Kantor Bea Cukai
            </h6>
            <span class="badge bg-primary" id="visible-count">{{ $kantors->count() }} dari {{ $kantors->total() }}</span>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="kantorTable">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th width="120">Kode Kantor</th>
                            <th>Nama Kantor</th>
                            <th width="100">Jenis</th>
                            <th width="150">Provinsi</th>
                            <th width="150">Kota</th>
                            <th>Alamat</th>
                            <th width="180" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kantors as $kantor)
                            <tr data-provinsi="{{ $kantor->provinsi }}" data-jenis="{{ $kantor->jenis_kantor }}" data-search="{{ strtolower($kantor->nama_kantor . ' ' . $kantor->kode_kantor) }}">
                                <td class="align-middle">{{ $loop->iteration + ($kantors->currentPage() - 1) * $kantors->perPage() }}</td>
                                <td class="align-middle">
                                    <span class="badge bg-info text-white">{{ $kantor->kode_kantor }}</span>
                                </td>
                                <td class="align-middle">
                                    <strong>{{ $kantor->nama_kantor }}</strong>
                                </td>
                                <td class="align-middle">
                                    @if($kantor->jenis_kantor == 'kanwil')
                                        <span class="badge bg-primary">
                                            <i class="fas fa-landmark me-1"></i>Kanwil
                                        </span>
                                    @elseif($kantor->jenis_kantor == 'kppbc')
                                        <span class="badge bg-success">
                                            <i class="fas fa-warehouse me-1"></i>KPPBC
                                        </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-store me-1"></i>KPU
                                        </span>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <i class="fas fa-map-marker-alt text-muted me-1"></i>{{ $kantor->provinsi }}
                                </td>
                                <td class="align-middle">{{ $kantor->kota }}</td>
                                <td class="align-middle">
                                    <small class="text-muted">{{ Str::limit($kantor->alamat, 50) }}</small>
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('manage.kantor.edit', $kantor->id) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('manage.kantor.destroy', $kantor->id) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Yakin ingin menonaktifkan kantor {{ $kantor->nama_kantor }}?')">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Nonaktifkan">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data kantor bea cukai</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($kantors->hasPages())
        <div class="card-footer bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Menampilkan {{ $kantors->firstItem() }} - {{ $kantors->lastItem() }} dari {{ $kantors->total() }} data
                </div>
                <div>
                    {{ $kantors->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
// Enhanced filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const provinsiFilter = document.getElementById('filter-provinsi');
    const jenisFilter = document.getElementById('filter-jenis');
    const searchInput = document.getElementById('search');
    const tableRows = document.querySelectorAll('#kantorTable tbody tr');
    const visibleCountBadge = document.getElementById('visible-count');
    const totalCount = {{ $kantors->total() }};

    function filterTable() {
        const selectedProvinsi = provinsiFilter.value;
        const selectedJenis = jenisFilter.value;
        const searchValue = searchInput.value.toLowerCase();
        let visibleCount = 0;

        tableRows.forEach(row => {
            const provinsi = row.getAttribute('data-provinsi');
            const jenis = row.getAttribute('data-jenis');
            const searchData = row.getAttribute('data-search');
            
            // Skip empty rows
            if (!provinsi || !jenis || !searchData) {
                return;
            }
            
            const provinsiMatch = !selectedProvinsi || provinsi === selectedProvinsi;
            const jenisMatch = !selectedJenis || jenis === selectedJenis;
            const searchMatch = !searchValue || searchData.includes(searchValue);
            
            if (provinsiMatch && jenisMatch && searchMatch) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update visible count badge
        if (visibleCountBadge) {
            visibleCountBadge.textContent = visibleCount + ' dari ' + totalCount;
        }
    }

    // Add event listeners
    provinsiFilter.addEventListener('change', filterTable);
    jenisFilter.addEventListener('change', filterTable);
    searchInput.addEventListener('keyup', filterTable);
    
    // Add hover effect to table rows
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.classList.add('table-active');
        });
        row.addEventListener('mouseleave', function() {
            this.classList.remove('table-active');
        });
    });
});
</script>
@endsection