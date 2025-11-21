@extends('layouts.app')

@section('title', 'Notifikasi Sistem')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #2496FF 0%, #4F90FF 50%, #65B5FF 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3 text-white">
                                <div
                                    style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-bell" style="font-size: 2rem;"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">Notifikasi</h2>
                                    <p class="mb-0 opacity-90">Kelola dan lihat semua notifikasi Anda</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.berita.create') }}" class="btn btn-light"
                                style="border-radius: 10px; font-weight: 600;">
                                <i class="bi bi-newspaper me-2"></i>Buat Berita
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Statistics Cards --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div
                                    style="width: 50px; height: 50px; background: linear-gradient(135deg, #2496FF 0%, #4F90FF 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-inbox text-white" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted mb-0">Total Notifikasi</h6>
                                <h3 class="fw-bold mb-0">{{ $totalCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div
                                    style="width: 50px; height: 50px; background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-bell-fill text-white" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted mb-0">Belum Dibaca</h6>
                                <h3 class="fw-bold mb-0 text-danger">{{ $unreadCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div
                                    style="width: 50px; height: 50px; background: linear-gradient(135deg, #28a745 0%, #5dd879 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-check-circle text-white" style="font-size: 1.5rem;"></i>
                                </div>
                            </div>
                            <div class="ms-3">
                                <h6 class="text-muted mb-0">Sudah Dibaca</h6>
                                <h3 class="fw-bold mb-0 text-success">{{ $readCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom py-3">
                <ul class="nav nav-pills" id="notifikasiTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all"
                            type="button" role="tab" aria-controls="all" aria-selected="true"
                            style="border-radius: 10px;">
                            <i class="bi bi-list-ul me-1"></i>Semua
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="unread-tab" data-bs-toggle="pill" data-bs-target="#unread"
                            type="button" role="tab" aria-controls="unread" aria-selected="false"
                            style="border-radius: 10px;">
                            <i class="bi bi-bell me-1"></i>Belum Dibaca
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="read-tab" data-bs-toggle="pill" data-bs-target="#read"
                            type="button" role="tab" aria-controls="read" aria-selected="false"
                            style="border-radius: 10px;">
                            <i class="bi bi-check-circle me-1"></i>Sudah Dibaca
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-4">
                <div class="tab-content" id="notifikasiTabContent">
                    {{-- Tab Semua --}}
                    <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        @forelse ($notifikasi as $notif)
                            <div class="notif-item p-3 mb-3 border rounded"
                                style="background: {{ $notif->status_baca ? '#f8f9fa' : '#e7f3ff' }}; border-color: {{ $notif->status_baca ? '#dee2e6' : '#2496FF' }} !important; border-radius: 12px;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            @php
                                                $iconMap = [
                                                    'pelanggaran' => [
                                                        'icon' => 'exclamation-triangle',
                                                        'color' => '#dc3545',
                                                    ],
                                                    'penghargaan' => ['icon' => 'trophy', 'color' => '#ffc107'],
                                                    'denda' => ['icon' => 'cash-coin', 'color' => '#fd7e14'],
                                                    'umum' => ['icon' => 'info-circle', 'color' => '#2496FF'],
                                                ];
                                                $iconData = $iconMap[$notif->jenis] ?? $iconMap['umum'];
                                            @endphp
                                            <div
                                                style="width: 40px; height: 40px; background: {{ $iconData['color'] }}20; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-{{ $iconData['icon'] }}"
                                                    style="font-size: 1.2rem; color: {{ $iconData['color'] }};"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ ucfirst($notif->jenis) }}</h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    {{ \Carbon\Carbon::parse($notif->tanggal)->format('d M Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-dark ps-5" style="white-space: pre-wrap;">{{ $notif->pesan }}
                                        </p>
                                    </div>
                                    <div class="d-flex gap-2 ms-3">
                                        @if (!$notif->status_baca)
                                            <a href="{{ route('admin.notifikasi.read', $notif->id_notifikasi) }}"
                                                class="btn btn-sm btn-primary" title="Tandai sudah dibaca"
                                                style="border-radius: 8px;">
                                                <i class="bi bi-check"></i>
                                            </a>
                                        @endif
                                        <form action="{{ route('admin.notifikasi.destroy', $notif->id_notifikasi) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus notifikasi ini?')"
                                                title="Hapus" style="border-radius: 8px;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 4rem; color: #ddd;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada notifikasi</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Tab Belum Dibaca --}}
                    <div class="tab-pane fade" id="unread" role="tabpanel" aria-labelledby="unread-tab">
                        @php
                            $unreadNotif = $notifikasi->where('status_baca', 0);
                        @endphp
                        @forelse ($unreadNotif as $notif)
                            <div class="notif-item p-3 mb-3 border rounded"
                                style="background: #e7f3ff; border-color: #2496FF !important; border-radius: 12px;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            @php
                                                $iconMap = [
                                                    'pelanggaran' => [
                                                        'icon' => 'exclamation-triangle',
                                                        'color' => '#dc3545',
                                                    ],
                                                    'penghargaan' => ['icon' => 'trophy', 'color' => '#ffc107'],
                                                    'denda' => ['icon' => 'cash-coin', 'color' => '#fd7e14'],
                                                    'umum' => ['icon' => 'info-circle', 'color' => '#2496FF'],
                                                ];
                                                $iconData = $iconMap[$notif->jenis] ?? $iconMap['umum'];
                                            @endphp
                                            <div
                                                style="width: 40px; height: 40px; background: {{ $iconData['color'] }}20; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-{{ $iconData['icon'] }}"
                                                    style="font-size: 1.2rem; color: {{ $iconData['color'] }};"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ ucfirst($notif->jenis) }}</h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    {{ \Carbon\Carbon::parse($notif->tanggal)->format('d M Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-dark ps-5" style="white-space: pre-wrap;">{{ $notif->pesan }}
                                        </p>
                                    </div>
                                    <div class="d-flex gap-2 ms-3">
                                        <a href="{{ route('admin.notifikasi.read', $notif->id_notifikasi) }}"
                                            class="btn btn-sm btn-primary" title="Tandai sudah dibaca"
                                            style="border-radius: 8px;">
                                            <i class="bi bi-check"></i>
                                        </a>
                                        <form action="{{ route('admin.notifikasi.destroy', $notif->id_notifikasi) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus notifikasi ini?')"
                                                title="Hapus" style="border-radius: 8px;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-check-circle" style="font-size: 4rem; color: #ddd;"></i>
                                <p class="text-muted mt-3 mb-0">Semua notifikasi sudah dibaca</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Tab Sudah Dibaca --}}
                    <div class="tab-pane fade" id="read" role="tabpanel" aria-labelledby="read-tab">
                        @php
                            $readNotif = $notifikasi->where('status_baca', 1);
                        @endphp
                        @forelse ($readNotif as $notif)
                            <div class="notif-item p-3 mb-3 border rounded"
                                style="background: #f8f9fa; border-color: #dee2e6 !important; border-radius: 12px;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            @php
                                                $iconMap = [
                                                    'pelanggaran' => [
                                                        'icon' => 'exclamation-triangle',
                                                        'color' => '#dc3545',
                                                    ],
                                                    'penghargaan' => ['icon' => 'trophy', 'color' => '#ffc107'],
                                                    'denda' => ['icon' => 'cash-coin', 'color' => '#fd7e14'],
                                                    'umum' => ['icon' => 'info-circle', 'color' => '#2496FF'],
                                                ];
                                                $iconData = $iconMap[$notif->jenis] ?? $iconMap['umum'];
                                            @endphp
                                            <div
                                                style="width: 40px; height: 40px; background: {{ $iconData['color'] }}20; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-{{ $iconData['icon'] }}"
                                                    style="font-size: 1.2rem; color: {{ $iconData['color'] }};"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ ucfirst($notif->jenis) }}</h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar3 me-1"></i>
                                                    {{ \Carbon\Carbon::parse($notif->tanggal)->format('d M Y H:i') }}
                                                </small>
                                            </div>
                                        </div>
                                        <p class="mb-0 text-dark ps-5" style="white-space: pre-wrap;">{{ $notif->pesan }}
                                        </p>
                                    </div>
                                    <div class="d-flex gap-2 ms-3">
                                        <form action="{{ route('admin.notifikasi.destroy', $notif->id_notifikasi) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus notifikasi ini?')"
                                                title="Hapus" style="border-radius: 8px;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 4rem; color: #ddd;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada notifikasi yang dibaca</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .nav-pills .nav-link {
            color: #666;
            font-weight: 500;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }

        .nav-pills .nav-link:hover {
            background: rgba(36, 150, 255, 0.1);
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #2496FF 0%, #4F90FF 100%);
            color: white;
        }

        .notif-item {
            transition: all 0.3s ease;
        }

        .notif-item:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(36, 150, 255, 0.15);
        }

        .btn-sm {
            transition: all 0.2s ease;
        }

        .btn-sm:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
