@extends('layouts.app')
@section('title', 'Laporan')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-success text-white">
                        <h4 class="mb-0"><i class="bi bi-file-earmark-text"></i> Laporan & Ekspor Data</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('petugas.laporan.export') }}" method="GET" id="exportForm">
                            <div class="row g-3">
                                <!-- Pilih Jenis Laporan -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-file-text text-primary"></i> Jenis Laporan
                                    </label>
                                    <select name="type" class="form-select" required>
                                        <option value="">-- Pilih Jenis Laporan --</option>
                                        <option value="riwayat_pelanggaran">Riwayat Pelanggaran</option>
                                        <option value="riwayat_penghargaan">Riwayat Penghargaan</option>
                                        <option value="denda">Laporan Denda</option>
                                    </select>
                                </div>

                                <!-- Format Export -->
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-file-earmark-arrow-down text-success"></i> Format Export
                                    </label>
                                    <select name="format" class="form-select" required>
                                        <option value="csv">CSV (Excel Compatible)</option>
                                        <option value="excel">Excel (.xlsx)</option>
                                        <option value="pdf">PDF</option>
                                    </select>
                                </div>

                                <!-- Filter Periode Cepat -->
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-calendar-range text-info"></i> Filter Periode
                                    </label>
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check" name="periode" id="all" value=""
                                            checked>
                                        <label class="btn btn-outline-secondary" for="all">Semua</label>

                                        <input type="radio" class="btn-check" name="periode" id="today"
                                            value="today">
                                        <label class="btn btn-outline-secondary" for="today">Hari Ini</label>

                                        <input type="radio" class="btn-check" name="periode" id="this_week"
                                            value="this_week">
                                        <label class="btn btn-outline-secondary" for="this_week">Minggu Ini</label>

                                        <input type="radio" class="btn-check" name="periode" id="this_month"
                                            value="this_month">
                                        <label class="btn btn-outline-secondary" for="this_month">Bulan Ini</label>

                                        <input type="radio" class="btn-check" name="periode" id="last_month"
                                            value="last_month">
                                        <label class="btn btn-outline-secondary" for="last_month">Bulan Lalu</label>

                                        <input type="radio" class="btn-check" name="periode" id="this_semester"
                                            value="this_semester">
                                        <label class="btn btn-outline-secondary" for="this_semester">Semester Ini</label>

                                        <input type="radio" class="btn-check" name="periode" id="this_year"
                                            value="this_year">
                                        <label class="btn btn-outline-secondary" for="this_year">Tahun Ini</label>

                                        <input type="radio" class="btn-check" name="periode" id="custom"
                                            value="">
                                        <label class="btn btn-outline-secondary" for="custom">Custom</label>
                                    </div>
                                </div>

                                <!-- Custom Date Range -->
                                <div class="col-md-6" id="customDateRange" style="display: none;">
                                    <label class="form-label fw-bold">Tanggal Mulai</label>
                                    <input type="date" name="start_date" class="form-control">
                                </div>
                                <div class="col-md-6" id="customDateRange2" style="display: none;">
                                    <label class="form-label fw-bold">Tanggal Akhir</label>
                                    <input type="date" name="end_date" class="form-control">
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success btn-lg w-100">
                                        <i class="bi bi-download me-2"></i> Download Laporan
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- Info Box -->
                        <div class="alert alert-info mt-4" role="alert">
                            <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Informasi</h6>
                            <ul class="mb-0">
                                <li><strong>CSV:</strong> Bisa dibuka di Excel, ukuran file kecil, kolom otomatis
                                    menyesuaikan lebar</li>
                                <li><strong>Excel (.xlsx):</strong> Format native Excel dengan styling, kolom auto-width
                                </li>
                                <li><strong>PDF:</strong> Siap cetak, tampilan profesional</li>
                                <li><strong>Filter Periode:</strong> Pilih periode cepat atau custom tanggal sesuai
                                    kebutuhan</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customRadio = document.getElementById('custom');
            const dateRange1 = document.getElementById('customDateRange');
            const dateRange2 = document.getElementById('customDateRange2');
            const periodeRadios = document.querySelectorAll('input[name="periode"]');

            periodeRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (customRadio.checked) {
                        dateRange1.style.display = 'block';
                        dateRange2.style.display = 'block';
                    } else {
                        dateRange1.style.display = 'none';
                        dateRange2.style.display = 'none';
                        document.querySelector('input[name="start_date"]').value = '';
                        document.querySelector('input[name="end_date"]').value = '';
                    }
                });
            });
        });
    </script>
@endsection
