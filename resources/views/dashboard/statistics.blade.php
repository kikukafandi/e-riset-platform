@extends('dashboard.layouts.app')

@section('title', 'Dashboard Statistik')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Dashboard Statistik Penelitian</h1>
        </div>
    </div>

    <!-- Statistics Cards Row -->
    <div class="row">
        <!-- Applicant Type Statistics -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="font-weight-bold text-primary text-uppercase mb-1">
                        Statistik Pemohon (Pegawai vs Non-Pegawai)
                    </h6>
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div id="applicant-stats" class="text-xs font-weight-bold text-gray-800 mb-1">
                                Loading...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Research Completion -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <h6 class="font-weight-bold text-warning text-uppercase mb-1">
                        Status Penyelesaian Penelitian
                    </h6>
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div id="completion-stats" class="text-xs font-weight-bold text-gray-800 mb-1">
                                Loading...
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Period Statistics Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Pengajuan per Periode</h6>
                    <div class="dropdown no-arrow">
                        <select id="year-selector" class="form-control form-control-sm" style="width: auto;">
                            <option value="2025">2025</option>
                            <option value="2024">2024</option>
                            <option value="2023">2023</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="periodChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Topics Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">10 Topik Terpopuler</h6>
                </div>
                <div class="card-body">
                    <canvas id="topicsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Office Destinations Statistics -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistik Kantor Tujuan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="officeStatsTable">
                            <thead>
                                <tr>
                                    <th>Kode Kantor</th>
                                    <th>Nama Kantor</th>
                                    <th>Provinsi</th>
                                    <th>Kota</th>
                                    <th>Total Pengajuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded via AJAX -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load initial statistics
    loadApplicantTypeStats();
    loadResearchCompletionStats();
    loadPeriodStats();
    loadTopicUsageStats();
    loadOfficeStats();

    // Year selector change event
    document.getElementById('year-selector').addEventListener('change', function() {
        loadPeriodStats();
        loadTopicUsageStats();
        loadOfficeStats();
    });

    function loadApplicantTypeStats() {
        fetch('{{ route("statistics.applicant.types") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('applicant-stats').innerHTML = `
                    <div>Total Pengajuan: ${data.total_applications}</div>
                    <div>Pegawai: ${data.pegawai_count} (${data.pegawai_percentage}%)</div>
                    <div>Non-Pegawai: ${data.non_pegawai_count} (${data.non_pegawai_percentage}%)</div>
                `;
            });
    }

    function loadResearchCompletionStats() {
        fetch('{{ route("statistics.research.completion") }}')
            .then(response => response.json())
            .then(data => {
                document.getElementById('completion-stats').innerHTML = `
                    <div>Total Penelitian Disetujui: ${data.total_approved_research}</div>
                    <div>Penelitian Terlambat: ${data.overdue_research.length}</div>
                    <div>Penelitian Selesai: ${data.completed_with_output}</div>
                    <div>Peneliti Diblokir: ${data.banned_researchers.length}</div>
                `;
            });
    }

    function loadPeriodStats() {
        const year = document.getElementById('year-selector').value;
        fetch(`{{ route("statistics.period") }}?year=${year}`)
            .then(response => response.json())
            .then(data => {
                updatePeriodChart(data.monthly_stats);
            });
    }

    function loadTopicUsageStats() {
        const year = document.getElementById('year-selector').value;
        fetch(`{{ route("statistics.topic.usage") }}?year=${year}&limit=10`)
            .then(response => response.json())
            .then(data => {
                updateTopicsChart(data.top_topics);
            });
    }

    function loadOfficeStats() {
        const year = document.getElementById('year-selector').value;
        fetch(`{{ route("statistics.office.destinations") }}?year=${year}`)
            .then(response => response.json())
            .then(data => {
                updateOfficeTable(data.office_stats);
            });
    }

    let periodChart, topicsChart;

    function updatePeriodChart(data) {
        const ctx = document.getElementById('periodChart').getContext('2d');
        
        if (periodChart) {
            periodChart.destroy();
        }

        periodChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.map(item => item.month_name),
                datasets: [{
                    label: 'Jumlah Pengajuan',
                    data: data.map(item => item.application_count),
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    function updateTopicsChart(data) {
        const ctx = document.getElementById('topicsChart').getContext('2d');
        
        if (topicsChart) {
            topicsChart.destroy();
        }

        topicsChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: data.map(item => item.nama_topik.substring(0, 20) + '...'),
                datasets: [{
                    data: data.map(item => item.usage_count),
                    backgroundColor: [
                        '#FF6384', '#36A2EB', '#FFCE56', '#FF9F40',
                        '#FF6384', '#C9CBCF', '#4BC0C0', '#9966FF',
                        '#FF9F40', '#FF6384'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    function updateOfficeTable(data) {
        const tbody = document.querySelector('#officeStatsTable tbody');
        tbody.innerHTML = '';
        
        data.forEach(office => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td>${office.kode_kantor}</td>
                <td>${office.nama_kantor}</td>
                <td>${office.provinsi}</td>
                <td>${office.kota}</td>
                <td><span class="badge badge-primary">${office.total_applications}</span></td>
            `;
        });
    }
});
</script>
@endsection