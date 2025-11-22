@extends('layouts.app')
@section('title', 'Notifikasi')
@section('content')

    <style>
        .page-header {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(17, 153, 142, 0.3);
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
            border-left-color: #11998e;
        }

        .notif-card.unread {
            background: #f0fff9;
            border-left-color: #11998e;
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
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
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
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
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
                    <button type="button" class="btn active">Semua ({{ $totalCount }})</button>
                    <button type="button" class="btn">Belum Dibaca ({{ $unreadCount }})</button>
                    <button type="button" class="btn">Sudah Dibaca ({{ $readCount }})</button>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div id="notifContainer">
            @forelse ($notifikasi as $notif)
                @php
                    $isBerita = str_contains($notif->pesan, 'Berita Baru:');
                    $beritaJudul = null;
                    $beritaIsi = null;
                    if ($isBerita) {
                        $parts = explode("\n\n", $notif->pesan, 2);
                        $beritaJudul = str_replace('Berita Baru: ', '', $parts[0]);
                        $beritaIsi = $parts[1] ?? '';
                    }

                    $iconMap = [
                        'pelanggaran' => ['icon' => 'exclamation-triangle', 'class' => 'warning'],
                        'penghargaan' => ['icon' => 'trophy', 'class' => 'success'],
                        'denda' => ['icon' => 'cash-coin', 'class' => 'warning'],
                        'umum' => ['icon' => 'info-circle', 'class' => 'info'],
                    ];
                    $iconData = $iconMap[$notif->jenis] ?? $iconMap['umum'];
                @endphp

                @php
                    $posterUrl = '';
                    if ($isBerita && $notif->berita && $notif->berita->poster) {
                        $posterUrl = asset('storage/' . $notif->berita->poster);
                    }
                @endphp

                <div class="notif-card {{ $notif->status_baca ? '' : 'unread' }}"
                    data-status="{{ $notif->status_baca ? 'read' : 'unread' }}"
                    @if ($isBerita) style="cursor: pointer;" 
                        data-berita="true"
                        data-judul="{{ $beritaJudul }}"
                        data-isi="{{ $beritaIsi }}"
                        data-tanggal="{{ \Carbon\Carbon::parse($notif->tanggal)->format('d M Y H:i') }}"
                        data-poster="{{ $posterUrl }}"
                        data-has-poster="{{ $posterUrl ? 'yes' : 'no' }}" @endif>
                    <div class="d-flex align-items-start">
                        <div class="notif-icon {{ $iconData['class'] }}">
                            <i class="bi bi-{{ $isBerita ? 'newspaper' : $iconData['icon'] }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="notif-title">
                                @if ($isBerita)
                                    📰 {{ $beritaJudul }}
                                @else
                                    {{ ucfirst($notif->jenis) }}
                                @endif
                            </div>
                            <div class="notif-message">
                                @if ($isBerita)
                                    {{ Str::limit($beritaIsi, 100) }}
                                    <span class="text-success fw-semibold">Klik untuk lihat detail...</span>
                                @else
                                    {{ $notif->pesan }}
                                @endif
                            </div>
                            <div class="notif-time">
                                <i class="bi bi-clock"></i>
                                {{ \Carbon\Carbon::parse($notif->tanggal)->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    @if (!$notif->status_baca)
                        <span class="unread-badge">BARU</span>
                    @endif
                    @if (!$isBerita)
                        <div class="d-flex gap-2 mt-3">
                            @if (!$notif->status_baca)
                                <a href="{{ route('petugas.notifikasi.read', $notif->id_notifikasi) }}"
                                    class="btn btn-sm btn-success">
                                    <i class="bi bi-check me-1"></i>Tandai Dibaca
                                </a>
                            @endif
                            <form action="{{ route('petugas.notifikasi.destroy', $notif->id_notifikasi) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                    onclick="return confirm('Yakin ingin menghapus notifikasi ini?')">
                                    <i class="bi bi-trash me-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <i class="bi bi-bell"></i>
                    <h4>Tidak Ada Notifikasi</h4>
                    <p>Anda belum memiliki notifikasi baru</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Detail Berita -->
    <div class="modal fade" id="beritaModal" tabindex="-1" aria-labelledby="beritaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold" id="beritaModalLabel">
                        <i class="bi bi-newspaper me-2"></i><span id="modalTitle"></span>
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="bi bi-calendar3 me-1"></i>
                            <span id="modalDate"></span>
                        </small>
                    </div>
                    <div id="modalPoster" class="mb-3"></div>
                    <div id="modalContent" style="line-height: 1.8; white-space: pre-wrap; color: #333;"></div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #e0e0e0;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 8px;">
                        <i class="bi bi-x-circle me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filter tabs functionality
        const filterButtons = document.querySelectorAll('.filter-tabs .btn-group .btn');
        const notifCards = document.querySelectorAll('.notif-card');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                // Add active class to clicked button
                this.classList.add('active');

                const filterText = this.textContent.trim();
                notifCards.forEach(card => {
                    const status = card.getAttribute('data-status');
                    if (filterText.includes('Semua')) {
                        card.style.display = 'block';
                    } else if (filterText.includes('Belum Dibaca') && status === 'unread') {
                        card.style.display = 'block';
                    } else if (filterText.includes('Sudah Dibaca') && status === 'read') {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Check if no cards are visible
                const visibleCards = Array.from(notifCards).filter(card => card.style.display !== 'none');
                const emptyState = document.querySelector('.empty-state');
                if (visibleCards.length === 0 && emptyState) {
                    emptyState.style.display = 'block';
                } else if (emptyState) {
                    emptyState.style.display = 'none';
                }
            });
        });

        // Add click event listeners to berita cards
        document.querySelectorAll('.notif-card[data-berita="true"]').forEach(card => {
            card.addEventListener('click', function() {
                const judul = this.dataset.judul;
                const isi = this.dataset.isi;
                const tanggal = this.dataset.tanggal;
                const poster = this.dataset.poster;

                document.getElementById('modalTitle').textContent = judul;
                document.getElementById('modalContent').textContent = isi;
                document.getElementById('modalDate').textContent = tanggal;

                // Show/hide poster
                const posterContainer = document.getElementById('modalPoster');
                if (poster && poster.trim() !== '') {
                    posterContainer.innerHTML = '<img src="' + poster +
                        '" alt="Poster Berita" class="img-fluid rounded shadow-sm" style="max-height: 400px; width: 100%; object-fit: cover; border-radius: 12px;" onerror="this.parentElement.innerHTML=\'<div class=\\\'alert alert-warning\\\' style=\\\'border-radius: 10px;\\\'><i class=\\\'bi bi-exclamation-triangle me-2\\\'></i>Gambar tidak dapat dimuat.</div>\'">';
                    posterContainer.style.display = 'block';
                } else {
                    posterContainer.innerHTML = '';
                    posterContainer.style.display = 'none';
                }

                const modal = new bootstrap.Modal(document.getElementById('beritaModal'));
                modal.show();
            });
        });
    </script>

@endsection
