@if (!request()->ajax())
    @extends('layouts.app')
    @section('title', 'Denda Saya')
    @section('content')
    @endif

    <style>
        .page-header {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(250, 112, 154, 0.3);
        }

        .page-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-header p {
            opacity: 0.95;
            margin-bottom: 0;
        }

        .summary-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .summary-item {
            text-align: center;
            padding: 20px;
        }

        .summary-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .summary-value.total {
            color: #f59e0b;
        }

        .summary-value.paid {
            color: #22c55e;
        }

        .summary-value.unpaid {
            color: #ef4444;
        }

        .summary-label {
            color: #666;
            font-size: 0.9rem;
        }

        .denda-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        .denda-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 5px;
            height: 100%;
        }

        .denda-card.paid::before {
            background: linear-gradient(180deg, #43e97b 0%, #38f9d7 100%);
        }

        .denda-card.unpaid::before {
            background: linear-gradient(180deg, #f093fb 0%, #f5576c 100%);
        }

        .denda-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .denda-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 20px;
        }

        .denda-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .denda-date {
            color: #666;
            font-size: 0.9rem;
        }

        .status-badge {
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .status-paid {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .status-unpaid {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .denda-amount {
            font-size: 2rem;
            font-weight: 700;
            color: #f59e0b;
            margin: 20px 0;
        }

        .denda-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-top: 15px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-size: 0.9rem;
        }

        .detail-value {
            font-weight: 600;
            color: #333;
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

        .payment-proof {
            margin-top: 15px;
            padding: 15px;
            background: #f0fdf4;
            border-radius: 10px;
            border: 2px dashed #22c55e;
        }

        .payment-proof-title {
            font-weight: 600;
            color: #16a34a;
            margin-bottom: 10px;
        }

        .payment-proof-image {
            max-width: 200px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .filter-tabs {
            background: white;
            border-radius: 15px;
            padding: 15px 25px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .filter-tabs .btn-group {
            width: 100%;
        }

        .filter-tabs .btn {
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .filter-tabs .btn:not(.active) {
            background: #f8f9fa;
            color: #666;
        }

        .filter-tabs .btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: transparent;
        }

        .filter-tabs .btn:hover:not(.active) {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .page-header {
                padding: 20px;
                border-radius: 12px;
            }

            .page-header h2 {
                font-size: 1.5rem;
            }

            .page-header p {
                font-size: 0.85rem;
            }

            .summary-card {
                padding: 15px;
            }

            .summary-item {
                padding: 15px 10px;
                border: none !important;
                border-bottom: 1px solid #e0e0e0 !important;
            }

            .summary-item:last-child {
                border-bottom: none !important;
            }

            .summary-value {
                font-size: 1.5rem;
            }

            .filter-tabs {
                padding: 15px;
            }

            .filter-tabs h6 {
                font-size: 0.9rem;
                margin-bottom: 10px;
            }

            .filter-tabs .d-flex {
                flex-direction: column;
                align-items: stretch !important;
            }

            .filter-tabs .btn-group {
                display: flex;
                gap: 8px;
            }

            .filter-tabs .btn {
                flex: 1;
                padding: 8px 12px;
                font-size: 0.85rem;
            }

            .denda-card {
                padding: 15px;
                border-radius: 12px;
            }

            .denda-header {
                flex-direction: column;
                gap: 15px;
            }

            .denda-title {
                font-size: 1rem;
            }

            .denda-date {
                font-size: 0.85rem;
            }

            .denda-amount {
                font-size: 1.5rem;
            }

            .status-badge {
                padding: 6px 15px;
                font-size: 0.8rem;
                align-self: flex-start;
            }

            .detail-row {
                flex-direction: column;
                gap: 5px;
                padding: 8px 0;
            }

            .detail-label {
                font-size: 0.85rem;
            }

            .detail-value {
                font-size: 0.9rem;
            }

            .payment-proof-image {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 0 10px;
            }

            .page-header {
                padding: 15px;
                margin-bottom: 20px;
            }

            .page-header h2 {
                font-size: 1.25rem;
            }

            .page-header i {
                font-size: 1.25rem;
            }

            .summary-value {
                font-size: 1.25rem;
            }

            .summary-label {
                font-size: 0.8rem;
            }

            .filter-tabs {
                padding: 12px;
            }

            .filter-tabs .btn {
                padding: 8px 10px;
                font-size: 0.8rem;
            }

            .filter-tabs .btn i {
                display: none;
            }

            .denda-card {
                padding: 12px;
            }

            .denda-title {
                font-size: 0.95rem;
            }

            .denda-amount {
                font-size: 1.25rem;
                margin: 15px 0;
            }

            .empty-state {
                padding: 60px 15px;
            }

            .empty-state i {
                font-size: 3.5rem;
            }

            .empty-state h4 {
                font-size: 1.1rem;
            }
        }
    </style>

    <div class="container mt-4">
        <!-- Page Header -->
        <div class="page-header">
            <h2><i class="bi bi-wallet2"></i> Denda Saya</h2>
            <p>Informasi lengkap tentang denda dan status pembayaran</p>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($riwayat->isEmpty())
            <div class="empty-state">
                <i class="bi bi-emoji-smile"></i>
                <h4>Tidak Ada Denda</h4>
                <p>Anda tidak memiliki catatan denda. Pertahankan!</p>
            </div>
        @else
            <!-- Summary Card -->
            <div class="summary-card">
                <div class="row">
                    <div class="col-md-4 summary-item">
                        <div class="summary-value total">Rp {{ number_format($riwayat->sum('nominal'), 0, ',', '.') }}</div>
                        <div class="summary-label">Total Denda</div>
                    </div>
                    <div class="col-md-4 summary-item border-start border-end">
                        <div class="summary-value paid">Rp
                            {{ number_format($riwayat->where('status_bayar', 'dibayar')->sum('nominal'), 0, ',', '.') }}
                        </div>
                        <div class="summary-label">Sudah Dibayar</div>
                    </div>
                    <div class="col-md-4 summary-item">
                        <div class="summary-value unpaid">Rp
                            {{ number_format($riwayat->where('status_bayar', 'belum')->sum('nominal'), 0, ',', '.') }}</div>
                        <div class="summary-label">Belum Dibayar</div>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="bi bi-funnel"></i> Filter Status:</h6>
                    <div class="btn-group" role="group">
                        <button type="button" class="btn filter-btn active" data-filter="all">
                            <i class="bi bi-list"></i> Semua
                        </button>
                        <button type="button" class="btn filter-btn" data-filter="belum">
                            <i class="bi bi-clock"></i> Belum Bayar
                        </button>
                        <button type="button" class="btn filter-btn" data-filter="dibayar">
                            <i class="bi bi-check-circle"></i> Sudah Bayar
                        </button>
                    </div>
                </div>
            </div>

            <!-- Denda List -->
            @foreach ($riwayat as $denda)
                <div class="denda-card {{ $denda->status_bayar == 'dibayar' ? 'paid' : 'unpaid' }}"
                    data-status="{{ $denda->status_bayar }}">
                    <div class="denda-header">
                        <div>
                            <div class="denda-title">
                                <i class="bi bi-exclamation-circle text-danger"></i>
                                {{ $denda->riwayatPelanggaran->pelanggaran->nama_pelanggaran ?? 'Pelanggaran' }}
                            </div>
                            <div class="denda-date">
                                <i class="bi bi-calendar"></i>
                                {{ \Carbon\Carbon::parse($denda->created_at)->format('d F Y') }}
                            </div>
                        </div>
                        <div>
                            <span
                                class="status-badge {{ $denda->status_bayar == 'dibayar' ? 'status-paid' : 'status-unpaid' }}">
                                @if ($denda->status_bayar == 'dibayar')
                                    <i class="bi bi-check-circle"></i> Lunas
                                @else
                                    <i class="bi bi-clock"></i> Belum Bayar
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="denda-amount">
                        <i class="bi bi-cash-coin"></i> Rp {{ number_format($denda->nominal, 0, ',', '.') }}
                    </div>

                    <div class="denda-details">
                        <div class="detail-row">
                            <span class="detail-label">Poin Pelanggaran</span>
                            <span class="detail-value">{{ $denda->riwayatPelanggaran->pelanggaran->poin ?? 0 }} Poin</span>
                        </div>
                        <div class="detail-row">
                            <span class="detail-label">Petugas yang Mencatat</span>
                            <span class="detail-value">
                                <i class="bi bi-person-badge"></i> {{ $denda->riwayatPelanggaran->petugas->nama ?? 'N/A' }}
                            </span>
                        </div>
                        @if ($denda->status_bayar == 'dibayar' && $denda->tanggal_bayar)
                            <div class="detail-row">
                                <span class="detail-label">Tanggal Pembayaran</span>
                                <span
                                    class="detail-value">{{ \Carbon\Carbon::parse($denda->tanggal_bayar)->format('d F Y') }}</span>
                            </div>
                        @endif
                    </div>

                    @if ($denda->status_bayar == 'dibayar' && $denda->bukti_bayar)
                        <div class="payment-proof">
                            <div class="payment-proof-title">
                                <i class="bi bi-file-earmark-check"></i> Bukti Pembayaran (Terverifikasi)
                            </div>
                            <img src="{{ asset('storage/' . $denda->bukti_bayar) }}" alt="Bukti Pembayaran"
                                class="payment-proof-image">
                        </div>
                    @endif

                    @if ($denda->status_bayar == 'belum' && $denda->bukti_bayar)
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-clock-history me-2"></i>
                            <strong>Menunggu Verifikasi</strong>
                            <p class="mb-2 mt-2">Bukti pembayaran Anda sudah diupload dan sedang menunggu verifikasi dari
                                petugas.</p>
                            <div class="payment-proof mt-2">
                                <div class="payment-proof-title">
                                    <i class="bi bi-file-earmark-text"></i> Bukti yang Diupload
                                </div>
                                <img src="{{ asset('storage/' . $denda->bukti_bayar) }}" alt="Bukti Pembayaran"
                                    class="payment-proof-image" style="max-width: 300px;">
                                <p class="text-muted small mt-2">
                                    <i class="bi bi-calendar3"></i> Diupload:
                                    {{ \Carbon\Carbon::parse($denda->tanggal_bayar)->format('d F Y, H:i') }}
                                </p>
                            </div>
                        </div>
                    @endif

                    @if ($denda->status_bayar == 'belum' && !$denda->bukti_bayar)
                        <form action="{{ route('warga.denda.upload', $denda->id_denda) }}" method="POST"
                            enctype="multipart/form-data" class="mt-3">
                            @csrf
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title"><i class="bi bi-upload"></i> Upload Bukti Pembayaran</h6>
                                    <p class="text-muted small mb-3">Silakan upload bukti transfer pembayaran denda (JPG,
                                        PNG, PDF - Max 2MB)</p>

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                            <strong>Error!</strong>
                                            <ul class="mb-0 mt-2">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <input type="file"
                                            class="form-control @error('bukti_bayar') is-invalid @enderror"
                                            name="bukti_bayar" accept="image/*,.pdf" required
                                            onchange="validateFileSize(this)">
                                        @error('bukti_bayar')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted d-block mt-1">
                                            <i class="bi bi-info-circle"></i> Ukuran file maksimal 2MB
                                        </small>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-cloud-upload"></i> Upload Bukti Pembayaran
                                    </button>
                                </div>
                            </div>
                        </form>

                        <script>
                            function validateFileSize(input) {
                                if (input.files && input.files[0]) {
                                    const fileSize = input.files[0].size / 1024 / 1024; // in MB
                                    if (fileSize > 2) {
                                        alert('⚠️ Ukuran file terlalu besar!\n\nFile yang Anda pilih berukuran ' + fileSize.toFixed(2) +
                                            ' MB.\nMaksimal ukuran file adalah 2 MB.\n\nSilakan pilih file yang lebih kecil.');
                                        input.value = ''; // Clear the file input
                                        return false;
                                    }
                                    // Show file name and size
                                    const fileName = input.files[0].name;
                                    const fileInfo = document.createElement('div');
                                    fileInfo.className = 'alert alert-info mt-2 mb-0';
                                    fileInfo.innerHTML = '<i class="bi bi-file-earmark-check"></i> File dipilih: <strong>' + fileName +
                                        '</strong> (' + fileSize.toFixed(2) + ' MB)';

                                    // Remove previous file info if exists
                                    const existingInfo = input.parentElement.querySelector('.alert-info');
                                    if (existingInfo) {
                                        existingInfo.remove();
                                    }

                                    input.parentElement.appendChild(fileInfo);
                                }
                            }
                        </script>
                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="bi bi-info-circle"></i> <strong>Segera lakukan pembayaran</strong> untuk menghindari
                            sanksi lebih lanjut.
                        </div>
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const dendaCards = document.querySelectorAll('.denda-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Get filter value
                    const filter = this.getAttribute('data-filter');

                    // Filter denda cards
                    dendaCards.forEach(card => {
                        const status = card.getAttribute('data-status');

                        if (filter === 'all') {
                            card.style.display = 'block';
                        } else if (status === filter) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

    @if (!request()->ajax())
    @endsection
@endif
