@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #2496FF 0%, #4F90FF 50%, #65B5FF 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center gap-3 text-white">
                            <div
                                style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-graph-up-arrow" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Statistik Poin</h2>
                                <p class="mb-0 opacity-90">Pantau perkembangan poin pelanggaran dan penghargaan Anda</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #DC3545;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Total Poin Pelanggaran</p>
                                <h3 class="fw-bold mb-0 text-danger" id="totalPelanggaran">-</h3>
                            </div>
                            <div style="font-size: 2.5rem; color: #DC3545; opacity: 0.8;">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #28A745;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Total Poin Penghargaan</p>
                                <h3 class="fw-bold mb-0 text-success" id="totalPenghargaan">-</h3>
                            </div>
                            <div style="font-size: 2.5rem; color: #28A745; opacity: 0.8;">
                                <i class="bi bi-trophy"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100" style="border-left: 4px solid #2496FF;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Total Poin Bersih</p>
                                <h3 class="fw-bold mb-0" id="totalBersih" style="color: #2496FF;">-</h3>
                            </div>
                            <div style="font-size: 2.5rem; color: #2496FF; opacity: 0.8;">
                                <i class="bi bi-calculator"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart Section --}}
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0">
                                <i class="bi bi-bar-chart-line me-2" style="color: #2496FF;"></i>
                                Grafik Poin 6 Bulan Terakhir
                            </h5>
                            <div class="btn-group btn-group-sm" role="group">
                                <button type="button" class="btn btn-outline-primary active" id="btnLine">
                                    <i class="bi bi-graph-up"></i> Line
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="btnBar">
                                    <i class="bi bi-bar-chart"></i> Bar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="min-height: 400px;">
                        <canvas id="statistikChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .btn-group .btn {
            transition: all 0.3s ease;
        }

        .btn-outline-primary.active {
            background: linear-gradient(135deg, #2496FF 0%, #4F90FF 100%);
            border-color: #2496FF;
            color: white;
        }
    </style>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let chartInstance = null;
        let chartData = {
            labels: [],
            pelanggaran: [],
            penghargaan: []
        };
        let chartType = 'line';

        // Fetch data from API
        async function loadData() {
            try {
                const response = await fetch('/warga/statistik/data');
                const data = await response.json();

                chartData = data;

                // Format labels to month name
                chartData.labels = data.labels.map(label => {
                    const [year, month] = label.split('-');
                    const date = new Date(year, month - 1);
                    return date.toLocaleDateString('id-ID', {
                        month: 'short',
                        year: 'numeric'
                    });
                });

                // Update summary cards
                const totalPelanggaran = data.pelanggaran.reduce((a, b) => a + b, 0);
                const totalPenghargaan = data.penghargaan.reduce((a, b) => a + b, 0);
                const totalBersih = totalPenghargaan - totalPelanggaran;

                document.getElementById('totalPelanggaran').textContent = totalPelanggaran;
                document.getElementById('totalPenghargaan').textContent = totalPenghargaan;
                document.getElementById('totalBersih').textContent = totalBersih;

                // Apply color to total bersih
                const totalBersihEl = document.getElementById('totalBersih');
                if (totalBersih > 0) {
                    totalBersihEl.style.color = '#28A745';
                } else if (totalBersih < 0) {
                    totalBersihEl.style.color = '#DC3545';
                } else {
                    totalBersihEl.style.color = '#2496FF';
                }

                // Render chart
                renderChart();
            } catch (error) {
                console.error('Error loading data:', error);
            }
        }

        function renderChart() {
            const ctx = document.getElementById('statistikChart').getContext('2d');

            // Destroy existing chart if exists
            if (chartInstance) {
                chartInstance.destroy();
            }

            chartInstance = new Chart(ctx, {
                type: chartType,
                data: {
                    labels: chartData.labels,
                    datasets: [{
                            label: 'Poin Pelanggaran',
                            data: chartData.pelanggaran,
                            backgroundColor: chartType === 'line' ?
                                'rgba(220, 53, 69, 0.1)' : 'rgba(220, 53, 69, 0.8)',
                            borderColor: '#DC3545',
                            borderWidth: 2,
                            fill: chartType === 'line',
                            tension: 0.4
                        },
                        {
                            label: 'Poin Penghargaan',
                            data: chartData.penghargaan,
                            backgroundColor: chartType === 'line' ?
                                'rgba(40, 167, 69, 0.1)' : 'rgba(40, 167, 69, 0.8)',
                            borderColor: '#28A745',
                            borderWidth: 2,
                            fill: chartType === 'line',
                            tension: 0.4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    aspectRatio: 2,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12,
                                    weight: '600'
                                },
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            padding: 12,
                            titleFont: {
                                size: 13,
                                weight: 'bold'
                            },
                            bodyFont: {
                                size: 12
                            },
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + context.parsed.y + ' poin';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                callback: function(value) {
                                    return value + ' poin';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }

        // Toggle chart type
        document.getElementById('btnLine').addEventListener('click', function() {
            chartType = 'line';
            document.getElementById('btnLine').classList.add('active');
            document.getElementById('btnBar').classList.remove('active');
            renderChart();
        });

        document.getElementById('btnBar').addEventListener('click', function() {
            chartType = 'bar';
            document.getElementById('btnBar').classList.add('active');
            document.getElementById('btnLine').classList.remove('active');
            renderChart();
        });

        // Load data on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadData();
        });
    </script>
@endpush
