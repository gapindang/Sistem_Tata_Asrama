@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Riwayat Pelanggaran')
    @section('content')
    @endif

    <style>
        .page-header {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(240, 147, 251, 0.3);
        }

        .page-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-header p {
            opacity: 0.95;
            margin-bottom: 0;
        }

        .filter-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 15px;
        }

        .table thead th:first-child {
            border-radius: 10px 0 0 10px;
        }

        .table thead th:last-child {
            border-radius: 0 10px 10px 0;
        }

        .table tbody tr {
            transition: all 0.3s;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
            transform: scale(1.01);
        }

        .table tbody td {
            padding: 18px 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        .badge-severity {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .badge-critical {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .badge-high {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .badge-medium {
            background: linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%);
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
        }

        .empty-state i {
            font-size: 5rem;
            color: #e0e0e0;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #666;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
        }

        .search-box input {
            padding-left: 45px;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
        }

        .search-box input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
    </style>

    <div class="container mt-4">
        <!-- Page Header -->
        <div class="page-header">
            <h2><i class="bi bi-clock-history"></i> Riwayat Pelanggaran</h2>
            <p>Daftar lengkap pelanggaran yang pernah tercatat</p>
        </div>

        <!-- Filter Section -->
        <div class="filter-card">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="searchInput" class="form-control" placeholder="Cari pelanggaran...">
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <span class="text-muted">Total: <strong>{{ $riwayat->count() }}</strong> pelanggaran</span>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="table-card">
            @if ($riwayat->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-emoji-smile"></i>
                    <h4>Tidak Ada Pelanggaran</h4>
                    <p>Anda belum memiliki catatan pelanggaran. Pertahankan!</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL</th>
                                <th>JENIS PELANGGARAN</th>
                                <th>POIN</th>
                                <th>TINGKAT</th>
                                <th>STATUS DENDA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($riwayat as $index => $item)
                                <tr>
                                    <td><strong>{{ $index + 1 }}</strong></td>
                                    <td>
                                        <i class="bi bi-calendar3 text-muted"></i>
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                    </td>
                                    <td>
                                        <strong>{{ $item->pelanggaran->nama_pelanggaran ?? '-' }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ $item->pelanggaran->poin ?? 0 }} Poin</span>
                                    </td>
                                    <td>
                                        @php
                                            $poin = $item->pelanggaran->poin ?? 0;
                                            if ($poin >= 15) {
                                                $severity = 'critical';
                                                $label = 'Kritis';
                                            } elseif ($poin >= 10) {
                                                $severity = 'high';
                                                $label = 'Tinggi';
                                            } else {
                                                $severity = 'medium';
                                                $label = 'Sedang';
                                            }
                                        @endphp
                                        <span class="badge-severity badge-{{ $severity }}">{{ $label }}</span>
                                    </td>
                                    <td>
                                        @if ($item->denda)
                                            @if ($item->denda->status_bayar == 'dibayar')
                                                <span class="badge bg-success"><i class="bi bi-check-circle"></i>
                                                    Lunas</span>
                                            @else
                                                <span class="badge bg-warning text-dark"><i class="bi bi-clock"></i> Belum
                                                    Bayar</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">Tidak Ada Denda</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.getElementById('searchInput')?.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchValue) ? '' : 'none';
            });
        });
    </script>

    @if (!request()->ajax())
    @endsection
@endif
