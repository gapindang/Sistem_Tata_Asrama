@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Dashboard Warga')
    @section('content')
    @endif

    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .welcome-banner h2 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
        }

        .welcome-banner p {
            font-size: 1.1rem;
            opacity: 0.95;
            margin-bottom: 0;
            position: relative;
        }

        .stats-card {
            border-radius: 15px;
            padding: 30px;
            height: 100%;
            transition: all 0.3s ease;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .stats-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }

        .stats-card.pelanggaran {
            background: linear-gradient(135deg, #fff5f5 0%, #ffe0e0 100%);
        }

        .stats-card.pelanggaran::before {
            background: linear-gradient(90deg, #f093fb 0%, #f5576c 100%);
        }

        .stats-card.penghargaan {
            background: linear-gradient(135deg, #f0fff4 0%, #dcfce7 100%);
        }

        .stats-card.penghargaan::before {
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
        }

        .stats-card.denda {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        }

        .stats-card.denda::before {
            background: linear-gradient(90deg, #fa709a 0%, #fee140 100%);
        }

        .stats-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        .stats-card.pelanggaran .stats-icon {
            background: rgba(245, 87, 108, 0.2);
            color: #f5576c;
        }

        .stats-card.penghargaan .stats-icon {
            background: rgba(67, 233, 123, 0.2);
            color: #22c55e;
        }

        .stats-card.denda .stats-icon {
            background: rgba(250, 112, 154, 0.2);
            color: #f59e0b;
        }

        .stats-label {
            font-size: 0.95rem;
            color: #666;
            font-weight: 500;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            line-height: 1;
        }

        .quick-actions {
            margin-top: 40px;
        }

        .action-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s;
            border: 2px solid #f0f0f0;
            text-decoration: none;
            display: block;
            color: inherit;
        }

        .action-card:hover {
            border-color: #667eea;
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.2);
        }

        .action-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            margin: 0 auto 15px;
        }

        .action-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .action-desc {
            font-size: 0.85rem;
            color: #666;
        }
    </style>

    <div class="container mt-4">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <h2><i class="bi bi-emoji-smile"></i> Halo, {{ Auth::user()->nama }}!</h2>
            <p>Selamat datang kembali di Sistem Informasi Tata Kelola Asrama</p>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stats-card pelanggaran shadow-sm">
                    <div class="stats-icon">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                    <div class="stats-label">Total Pelanggaran</div>
                    <div class="stats-value">{{ $data['pelanggaran'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card penghargaan shadow-sm">
                    <div class="stats-icon">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <div class="stats-label">Total Penghargaan</div>
                    <div class="stats-value">{{ $data['penghargaan'] ?? 0 }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card denda shadow-sm">
                    <div class="stats-icon">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div class="stats-label">Total Denda</div>
                    <div class="stats-value" style="font-size: 1.8rem;">Rp
                        {{ number_format($data['denda'] ?? 0, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h4 class="mb-4" style="font-weight: 600; color: #333;">Akses Cepat</h4>
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ route('warga.pelanggaran.riwayat') }}" class="action-card">
                        <div class="action-icon">
                            <i class="bi bi-file-text"></i>
                        </div>
                        <div class="action-title">Riwayat Pelanggaran</div>
                        <div class="action-desc">Lihat detail pelanggaran</div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('warga.penghargaan.riwayat') }}" class="action-card">
                        <div class="action-icon">
                            <i class="bi bi-award"></i>
                        </div>
                        <div class="action-title">Riwayat Penghargaan</div>
                        <div class="action-desc">Lihat penghargaan Anda</div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('warga.denda.riwayat') }}" class="action-card">
                        <div class="action-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <div class="action-title">Denda Saya</div>
                        <div class="action-desc">Cek status pembayaran</div>
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('warga.profil.index') }}" class="action-card">
                        <div class="action-icon">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="action-title">Profil Saya</div>
                        <div class="action-desc">Update informasi profil</div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if (!request()->ajax())
    @endsection
@endif
