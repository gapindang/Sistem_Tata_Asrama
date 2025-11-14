@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Riwayat Penghargaan')
    @section('content')
    @endif

    <style>
        .page-header {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(67, 233, 123, 0.3);
        }

        .page-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-header p {
            opacity: 0.95;
            margin-bottom: 0;
        }

        .award-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            border-left: 5px solid transparent;
        }

        .award-card:hover {
            transform: translateX(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            border-left-color: #43e97b;
        }

        .award-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        .award-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 10px;
        }

        .award-date {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .award-description {
            color: #777;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .award-points {
            display: inline-block;
            padding: 8px 20px;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .empty-state i {
            font-size: 5rem;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
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

        .stats-summary {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .stat-item {
            text-align: center;
            padding: 15px;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
            margin-top: 5px;
        }
    </style>

    <div class="container mt-4">
        <!-- Page Header -->
        <div class="page-header">
            <h2><i class="bi bi-trophy-fill"></i> Riwayat Penghargaan</h2>
            <p>Pencapaian dan penghargaan yang telah Anda raih</p>
        </div>

        @if ($riwayat->isEmpty())
            <div class="empty-state">
                <i class="bi bi-trophy"></i>
                <h4>Belum Ada Penghargaan</h4>
                <p>Tingkatkan prestasi Anda untuk mendapatkan penghargaan!</p>
            </div>
        @else
            <!-- Stats Summary -->
            <div class="stats-summary">
                <div class="row">
                    <div class="col-md-4 stat-item">
                        <div class="stat-value">{{ $riwayat->count() }}</div>
                        <div class="stat-label">Total Penghargaan</div>
                    </div>
                    <div class="col-md-4 stat-item border-start border-end">
                        <div class="stat-value">
                            {{ $riwayat->sum(function ($item) {return $item->penghargaan->poin_reward ?? 0;}) }}</div>
                        <div class="stat-label">Total Poin Reward</div>
                    </div>
                    <div class="col-md-4 stat-item">
                        <div class="stat-value">{{ $riwayat->unique('id_penghargaan')->count() }}</div>
                        <div class="stat-label">Jenis Penghargaan</div>
                    </div>
                </div>
            </div>

            <!-- Awards List -->
            <div class="row">
                @foreach ($riwayat as $item)
                    <div class="col-md-6">
                        <div class="award-card">
                            <div class="d-flex">
                                <div class="award-icon">
                                    <i class="bi bi-award"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="award-title">{{ $item->penghargaan->nama_penghargaan ?? 'Penghargaan' }}
                                    </div>
                                    <div class="award-date">
                                        <i class="bi bi-calendar-check"></i>
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}
                                    </div>
                                    @if ($item->penghargaan->deskripsi)
                                        <div class="award-description">
                                            {{ $item->penghargaan->deskripsi }}
                                        </div>
                                    @endif
                                    <div class="award-points">
                                        <i class="bi bi-star-fill"></i> +{{ $item->penghargaan->poin_reward ?? 0 }} Poin
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if (!request()->ajax())
    @endsection
@endif
