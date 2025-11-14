@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Notifikasi')
    @section('content')
    @endif

    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .page-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 1.8rem;
        }

        .page-header p {
            margin-bottom: 0;
            opacity: 0.95;
        }

        .notif-card {
            background: white;
            border-radius: 15px;
            padding: 20px 25px;
            margin-bottom: 15px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            border-left: 4px solid transparent;
            position: relative;
        }

        .notif-card:hover {
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
            border-left-color: #667eea;
        }

        .notif-card.unread {
            background: #f0f4ff;
            border-left-color: #667eea;
        }

        .notif-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-right: 20px;
            flex-shrink: 0;
        }

        .notif-icon.info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .notif-icon.warning {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .notif-icon.success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .notif-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .notif-message {
            color: #666;
            font-size: 0.95rem;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .notif-time {
            color: #999;
            font-size: 0.85rem;
        }

        .notif-time i {
            margin-right: 5px;
        }

        .unread-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: #ef4444;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
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
            color: #e0e0e0;
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: #333;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
            margin-bottom: 0;
        }

        .filter-tabs {
            background: white;
            border-radius: 15px;
            padding: 15px 25px;
            margin-bottom: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .filter-tabs .btn {
            border-radius: 10px;
            padding: 10px 25px;
            border: 2px solid transparent;
            font-weight: 600;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .filter-tabs .btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .filter-tabs .btn:not(.active) {
            background: #f8f9fa;
            color: #666;
        }

        .filter-tabs .btn:not(.active):hover {
            background: #e9ecef;
            color: #333;
        }

        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .page-header {
                padding: 20px;
                margin-bottom: 20px;
                border-radius: 12px;
            }

            .page-header h2 {
                font-size: 1.5rem;
                margin-bottom: 5px;
            }

            .page-header h2 i {
                font-size: 1.3rem;
            }

            .page-header p {
                font-size: 0.9rem;
            }

            .filter-tabs {
                padding: 12px 15px;
                margin-bottom: 20px;
                border-radius: 12px;
            }

            .filter-tabs .d-flex {
                flex-direction: column;
                gap: 12px;
            }

            .filter-tabs .btn-group {
                width: 100%;
                display: flex;
                flex-wrap: wrap;
                gap: 8px;
            }

            .filter-tabs .btn {
                padding: 8px 16px;
                font-size: 0.85rem;
                flex: 1;
                min-width: 0;
            }

            .filter-tabs .btn-outline-primary {
                width: 100%;
                font-size: 0.9rem;
            }

            .notif-card {
                padding: 15px;
                margin-bottom: 12px;
                border-radius: 12px;
            }

            .notif-card:hover {
                transform: none;
            }

            .notif-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
                margin-right: 15px;
            }

            .notif-title {
                font-size: 0.95rem;
                margin-bottom: 5px;
                padding-right: 60px;
            }

            .notif-message {
                font-size: 0.85rem;
                margin-bottom: 8px;
            }

            .notif-time {
                font-size: 0.75rem;
            }

            .unread-badge {
                top: 15px;
                right: 15px;
                padding: 3px 10px;
                font-size: 0.7rem;
            }

            .empty-state {
                padding: 60px 20px;
                border-radius: 12px;
            }

            .empty-state i {
                font-size: 4rem;
                margin-bottom: 15px;
            }

            .empty-state h4 {
                font-size: 1.2rem;
                margin-bottom: 8px;
            }

            .empty-state p {
                font-size: 0.9rem;
            }
        }

        /* Small Mobile */
        @media (max-width: 480px) {
            .page-header {
                padding: 15px;
                margin-bottom: 15px;
            }

            .page-header h2 {
                font-size: 1.3rem;
            }

            .page-header p {
                font-size: 0.85rem;
            }

            .filter-tabs {
                padding: 10px 12px;
            }

            .filter-tabs .btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }

            .notif-card {
                padding: 12px;
            }

            .notif-icon {
                width: 35px;
                height: 35px;
                font-size: 1rem;
                margin-right: 12px;
            }

            .notif-title {
                font-size: 0.9rem;
                padding-right: 55px;
            }

            .notif-message {
                font-size: 0.8rem;
            }

            .notif-time {
                font-size: 0.7rem;
            }

            .unread-badge {
                padding: 2px 8px;
                font-size: 0.65rem;
            }

            .empty-state {
                padding: 40px 15px;
            }

            .empty-state i {
                font-size: 3rem;
            }

            .empty-state h4 {
                font-size: 1.1rem;
            }

            .empty-state p {
                font-size: 0.85rem;
            }
        }
    </style>

    <div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
        <!-- Page Header -->
        <div class="page-header">
            <h2><i class="bi bi-bell-fill"></i> Notifikasi</h2>
            <p>Semua pemberitahuan terkait aktivitas Anda</p>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group" role="group">
                    <button type="button" class="btn active">Semua</button>
                    <button type="button" class="btn">Belum Dibaca</button>
                    <button type="button" class="btn">Sudah Dibaca</button>
                </div>
                <button class="btn btn-outline-primary">
                    <i class="bi bi-check-all d-none d-md-inline"></i>
                    <span class="d-none d-md-inline">Tandai Semua Dibaca</span>
                    <span class="d-inline d-md-none">Tandai Semua</span>
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="empty-state">
            <i class="bi bi-bell"></i>
            <h4>Tidak Ada Notifikasi</h4>
            <p>Anda belum memiliki notifikasi baru</p>
        </div>

        <!-- Example of notification cards (will be populated from backend) -->
        <!-- <div class="notif-card unread">
                <div class="d-flex align-items-start">
                    <div class="notif-icon info">
                        <i class="bi bi-info-circle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="notif-title">Informasi Penting</div>
                        <div class="notif-message">Anda memiliki pelanggaran baru yang perlu ditindaklanjuti</div>
                        <div class="notif-time"><i class="bi bi-clock"></i> 2 jam yang lalu</div>
                    </div>
                </div>
                <span class="unread-badge">BARU</span>
            </div> -->
    </div>

    @if (!request()->ajax())
    @endsection
@endif
