@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Dashboard Admin')
    @section('content')
    @endif

    <div class="container-fluid py-4">
        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-md-8">
                <h2 class="fw-bold mb-1">📊 Dashboard Admin</h2>
                <p class="text-muted">Ringkasan statistik sistem asrama</p>
            </div>
        </div>

        {{-- Key Statistics Cards --}}
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm stat-card" style="border-left: 4px solid #667eea;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Total Pelanggaran</p>
                                <h3 class="fw-bold mb-0">{{ $data['totalPelanggaran'] }}</h3>
                            </div>
                            <div style="font-size: 2rem; color: #667eea;"><i class="bi bi-exclamation-circle-fill"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm stat-card" style="border-left: 4px solid #43e97b;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Total Penghargaan</p>
                                <h3 class="fw-bold mb-0">{{ $data['totalPenghargaan'] }}</h3>
                            </div>
                            <div style="font-size: 2rem; color: #43e97b;"><i class="bi bi-award-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm stat-card" style="border-left: 4px solid #f093fb;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Total Denda</p>
                                <h3 class="fw-bold mb-0" style="font-size: 1.3rem;">Rp
                                    {{ number_format($data['totalDenda'], 0, ',', '.') }}</h3>
                            </div>
                            <div style="font-size: 2rem; color: #f093fb;"><i class="bi bi-cash-coin"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm stat-card" style="border-left: 4px solid #4facfe;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Denda Terbayar</p>
                                <h3 class="fw-bold mb-0" style="font-size: 1.3rem;">Rp
                                    {{ number_format($data['totalDendaBayar'], 0, ',', '.') }}</h3>
                            </div>
                            <div style="font-size: 2rem; color: #4facfe;"><i class="bi bi-check-circle-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row 1 --}}
        <div class="row mb-4 g-3">
            {{-- Weekly Trend --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-graph-up me-2"></i>Trend Pelanggaran (7 Hari Terakhir)</h6>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="weeklyTrendChart" height="80"></canvas>
                    </div>
                </div>
            </div>

            {{-- Denda Status --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-pie-chart-fill me-2"></i>Status Pembayaran Denda</h6>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="dendaStatusChart" height="80"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row 2 --}}
        <div class="row mb-4 g-3">
            {{-- Pelanggaran per Jenis --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-bar-chart-fill me-2"></i>Top 10 Jenis Pelanggaran</h6>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="pelanggaranPerJenisChart" height="150"></canvas>
                    </div>
                </div>
            </div>

            {{-- Monthly Revenue --}}
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-line-chart me-2"></i>Pendapatan Denda (12 Bulan)</h6>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="monthlyRevenueChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Charts Row 3 --}}
        <div class="row g-3">
            {{-- Penghargaan Distribution --}}
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom py-3">
                        <h6 class="fw-bold mb-0"><i class="bi bi-star-fill me-2"></i>Distribusi Penghargaan</h6>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="penghargaanDistributionChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
    </style>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

    <script>
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    labels: {
                        font: {
                            family: "'Segoe UI', sans-serif",
                            size: 12
                        },
                        usePointStyle: true
                    }
                }
            }
        };

        // 1. Weekly Trend Chart
        const weeklyCtx = document.getElementById('weeklyTrendChart');
        if (weeklyCtx) {
            const weeklyData = @json($data['weeklyTrend']);
            new Chart(weeklyCtx, {
                type: 'line',
                data: {
                    labels: weeklyData.map(d => d.date),
                    datasets: [{
                        label: 'Pelanggaran',
                        data: weeklyData.map(d => d.count),
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // 2. Denda Status Chart (Pie)
        const dendaStatusCtx = document.getElementById('dendaStatusChart');
        if (dendaStatusCtx) {
            new Chart(dendaStatusCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Belum Dibayar', 'Sudah Dibayar'],
                    datasets: [{
                        data: [{{ $data['dendaBelumBayar'] }}, {{ $data['dendaSudahBayar'] }}],
                        backgroundColor: ['#ffc107', '#198754'],
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: chartOptions
            });
        }

        // 3. Pelanggaran per Jenis Chart (Horizontal Bar)
        const pelanggaranCtx = document.getElementById('pelanggaranPerJenisChart');
        if (pelanggaranCtx) {
            const pelanggaranData = @json($data['pelanggaranPerJenis']);
            new Chart(pelanggaranCtx, {
                type: 'bar',
                data: {
                    labels: pelanggaranData.map(p => p.nama),
                    datasets: [{
                        label: 'Jumlah Pelanggaran',
                        data: pelanggaranData.map(p => p.count),
                        backgroundColor: '#667eea',
                        borderRadius: 5,
                        borderSkipped: false
                    }]
                },
                options: {
                    ...chartOptions,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }

        // 4. Monthly Revenue Chart
        const revenueCtx = document.getElementById('monthlyRevenueChart');
        if (revenueCtx) {
            const monthlyData = @json($data['monthlyRevenue']);
            new Chart(revenueCtx, {
                type: 'bar',
                data: {
                    labels: monthlyData.map(m => m.month),
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: monthlyData.map(m => m.total),
                        backgroundColor: '#4facfe',
                        borderRadius: 5,
                        borderSkipped: false
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value / 1000000) + 'M';
                                }
                            }
                        }
                    }
                }
            });
        }

        // 5. Penghargaan Distribution Chart (Horizontal Bar)
        const penghargaanCtx = document.getElementById('penghargaanDistributionChart');
        if (penghargaanCtx) {
            const penghargaanData = @json($data['penghargaanDistribution']);
            new Chart(penghargaanCtx, {
                type: 'bar',
                data: {
                    labels: penghargaanData.map(p => p.nama),
                    datasets: [{
                        label: 'Jumlah Penghargaan',
                        data: penghargaanData.map(p => p.count),
                        backgroundColor: '#43e97b',
                        borderRadius: 5,
                        borderSkipped: false
                    }]
                },
                options: {
                    ...chartOptions,
                    indexAxis: 'y',
                    scales: {
                        x: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    </script>

    @if (!request()->ajax())
    @endsection
@endif
