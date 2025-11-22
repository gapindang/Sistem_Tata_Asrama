@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Dashboard Petugas')
    @section('content')
    @endif

    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center gap-3 text-white">
                            <div
                                style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-person-badge" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Dashboard Petugas</h2>
                                <p class="mb-0 opacity-75">Selamat datang, <strong>{{ Auth::user()->nama }}</strong>! Kelola
                                    pelanggaran dan penghargaan warga asrama.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                style="width: 60px; height: 60px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-exclamation-triangle-fill text-white" style="font-size: 1.8rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1">Pelanggaran Dicatat</p>
                                <h2 class="fw-bold mb-0" style="color: #f093fb;">{{ $data['pelanggaranDicatat'] ?? 0 }}</h2>
                                <small class="text-muted">Hari ini: {{ $data['pelanggaranHariIni'] ?? 0 }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                style="width: 60px; height: 60px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-trophy-fill text-white" style="font-size: 1.8rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1">Penghargaan Diberikan</p>
                                <h2 class="fw-bold mb-0" style="color: #43e97b;">{{ $data['penghargaanDiberikan'] ?? 0 }}
                                </h2>
                                <small class="text-muted">Hari ini: {{ $data['penghargaanHariIni'] ?? 0 }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px; overflow: hidden;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                style="width: 60px; height: 60px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="bi bi-cash-coin text-white" style="font-size: 1.8rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="text-muted small mb-1">Total Denda</p>
                                <h2 class="fw-bold mb-0" style="color: #fa709a;">Rp
                                    {{ number_format($data['totalDenda'] ?? 0, 0, ',', '.') }}</h2>
                                <small class="text-muted">Dari pelanggaran Anda</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0"><i class="bi bi-lightning-charge-fill me-2"
                                style="color: #667eea;"></i>Menu Cepat</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="{{ route('petugas.riwayat_pelanggaran.create') }}" class="text-decoration-none">
                                    <div class="quick-action-card p-4 text-center">
                                        <div class="icon-circle mx-auto mb-3"
                                            style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                            <i class="bi bi-plus-circle-fill"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-1">Catat Pelanggaran</h6>
                                        <small class="text-muted">Tambah pelanggaran baru</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('petugas.riwayat-penghargaan.create') }}" class="text-decoration-none">
                                    <div class="quick-action-card p-4 text-center">
                                        <div class="icon-circle mx-auto mb-3"
                                            style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                            <i class="bi bi-award-fill"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-1">Beri Penghargaan</h6>
                                        <small class="text-muted">Tambah penghargaan</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('petugas.warga.index') }}" class="text-decoration-none">
                                    <div class="quick-action-card p-4 text-center">
                                        <div class="icon-circle mx-auto mb-3"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                            <i class="bi bi-people-fill"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-1">Data Warga</h6>
                                        <small class="text-muted">Lihat data warga</small>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('petugas.denda.index') }}" class="text-decoration-none">
                                    <div class="quick-action-card p-4 text-center">
                                        <div class="icon-circle mx-auto mb-3"
                                            style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                            <i class="bi bi-cash-coin"></i>
                                        </div>
                                        <h6 class="fw-semibold mb-1">Kelola Denda</h6>
                                        <small class="text-muted">Approve pembayaran</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Activities --}}
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0"><i class="bi bi-exclamation-triangle me-2"
                                style="color: #f093fb;"></i>Pelanggaran Terbaru</h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($data['recentPelanggaran']->isEmpty())
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                <p class="mt-2">Belum ada pelanggaran dicatat</p>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach ($data['recentPelanggaran'] as $item)
                                    <div class="list-group-item px-4 py-3">
                                        <div class="d-flex align-items-start gap-3">
                                            <div
                                                style="width: 40px; height: 40px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                <i class="bi bi-exclamation-triangle text-white"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->warga->user->nama ?? 'N/A' }}</h6>
                                                        <p class="text-muted mb-1 small">
                                                            {{ $item->pelanggaran->nama_pelanggaran ?? 'N/A' }}</p>
                                                        <small class="text-muted"><i class="bi bi-calendar"></i>
                                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</small>
                                                    </div>
                                                    <span class="badge bg-danger">{{ $item->pelanggaran->poin ?? 0 }}
                                                        Poin</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0"><i class="bi bi-trophy me-2" style="color: #43e97b;"></i>Penghargaan
                            Terbaru</h5>
                    </div>
                    <div class="card-body p-0">
                        @if ($data['recentPenghargaan']->isEmpty())
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                                <p class="mt-2">Belum ada penghargaan diberikan</p>
                            </div>
                        @else
                            <div class="list-group list-group-flush">
                                @foreach ($data['recentPenghargaan'] as $item)
                                    <div class="list-group-item px-4 py-3">
                                        <div class="d-flex align-items-start gap-3">
                                            <div
                                                style="width: 40px; height: 40px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                <i class="bi bi-trophy text-white"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->warga->user->nama ?? 'N/A' }}</h6>
                                                        <p class="text-muted mb-1 small">
                                                            {{ $item->penghargaan->nama_penghargaan ?? 'N/A' }}</p>
                                                        <small class="text-muted"><i class="bi bi-calendar"></i>
                                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</small>
                                                    </div>
                                                    <span
                                                        class="badge bg-success">{{ $item->penghargaan->poin_reward ?? 0 }}
                                                        Poin</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .quick-action-card {
            background: #ffffff;
            border: 2px solid #f0f0f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .quick-action-card:hover {
            transform: translateY(-5px);
            border-color: #667eea;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.2);
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header h2 {
                font-size: 1.5rem;
            }

            .page-header p {
                font-size: 0.85rem;
            }

            .stat-card h2 {
                font-size: 1.5rem;
            }

            .stat-card .summary-label,
            .stat-card small {
                font-size: 0.8rem;
            }

            .quick-action-card h6 {
                font-size: 0.9rem;
            }

            .quick-action-card small {
                font-size: 0.75rem;
            }

            .icon-circle {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .container-fluid {
                padding: 0 10px;
            }

            .page-header {
                padding: 15px;
            }

            .page-header h2 {
                font-size: 1.25rem;
            }

            .page-header .d-flex {
                gap: 10px !important;
            }

            .page-header div[style*="width: 60px"] {
                width: 50px !important;
                height: 50px !important;
            }

            .stat-card .card-body {
                padding: 15px !important;
            }

            .stat-card h2 {
                font-size: 1.25rem;
            }

            .stat-card p {
                font-size: 0.75rem;
            }

            .stat-card div[style*="width: 60px"] {
                width: 50px !important;
                height: 50px !important;
            }

            .quick-action-card {
                padding: 15px !important;
            }

            .quick-action-card h6 {
                font-size: 0.85rem;
            }

            .quick-action-card small {
                font-size: 0.7rem;
            }

            .list-group-item h6 {
                font-size: 0.9rem;
            }

            .list-group-item p {
                font-size: 0.8rem;
            }
        }
    </style>

    @if (!request()->ajax())
    @endsection
@endif
