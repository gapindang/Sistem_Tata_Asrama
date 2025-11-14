@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-gradient"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-receipt text-white" style="font-size: 24px;"></i>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-1">Manajemen Denda</h1>
                        <p class="text-muted mb-0">Kelola denda pelanggaran asrama dengan mudah</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 d-flex justify-content-end align-items-center gap-2">
                <button type="button" class="btn btn-primary btn-lg" id="btnTambahDenda">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Denda
                </button>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid #667eea;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Total Denda</p>
                                <h3 class="fw-bold mb-0">{{ $denda->total() }}</h3>
                            </div>
                            <div style="font-size: 2rem; color: #667eea;"><i class="bi bi-list-check"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid #f093fb;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Belum Dibayar</p>
                                <h3 class="fw-bold mb-0">
                                    {{ $denda->count() ? $denda->getCollection()->where('status_bayar', 'belum')->count() : 0 }}
                                </h3>
                            </div>
                            <div style="font-size: 2rem; color: #f093fb;"><i class="bi bi-clock"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid #4facfe;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Sudah Dibayar</p>
                                <h3 class="fw-bold mb-0">
                                    {{ $denda->count() ? $denda->getCollection()->where('status_bayar', 'dibayar')->count() : 0 }}
                                </h3>
                            </div>
                            <div style="font-size: 2rem; color: #4facfe;"><i class="bi bi-check-circle"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid #43e97b;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Total Pendapatan</p>
                                <h3 class="fw-bold mb-0" style="font-size: 1.2rem;">Rp
                                    {{ number_format($denda->count() ? $denda->getCollection()->where('status_bayar', 'dibayar')->sum('nominal') : 0, 0, ',', '.') }}
                                </h3>
                            </div>
                            <div style="font-size: 2rem; color: #43e97b;"><i class="bi bi-currency-dollar"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-0"><i class="bi bi-table me-2"></i>Daftar Denda</h5>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control form-control-sm" id="searchDenda"
                            placeholder="🔍 Cari berdasarkan nama, pelanggaran...">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 18%">Warga</th>
                                <th style="width: 18%">Pelanggaran</th>
                                <th class="text-end" style="width: 15%">Nominal</th>
                                <th class="text-center" style="width: 12%">Status</th>
                                <th class="text-center" style="width: 15%">Tanggal Bayar</th>
                                <th class="text-center" style="width: 17%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tableDenda">
                            @forelse ($denda as $index => $item)
                                <tr id="row{{ $item->id_denda }}" class="denda-row"
                                    data-warga="{{ strtolower($item->riwayatPelanggaran?->warga?->nama ?? '') }}"
                                    data-pelanggaran="{{ strtolower($item->riwayatPelanggaran?->pelanggaran?->nama_pelanggaran ?? '') }}">
                                    <td class="text-center fw-bold col-index">
                                        {{ ($denda->currentPage() - 1) * $denda->perPage() + $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2"
                                                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-person text-primary"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $item->riwayatPelanggaran?->warga?->nama ?? '-' }}</strong>
                                                <br>
                                                <small
                                                    class="text-muted">{{ $item->riwayatPelanggaran?->warga?->nim ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                            {{ $item->riwayatPelanggaran?->pelanggaran?->nama_pelanggaran ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="text-end fw-semibold">
                                        <span class="text-danger">Rp
                                            {{ number_format($item->nominal, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->status_bayar == 'dibayar')
                                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i>Dibayar
                                            </span>
                                        @else
                                            <span class="badge bg-warning-subtle text-warning px-3 py-2">
                                                <i class="bi bi-clock me-1"></i>Belum Dibayar
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            @if ($item->status_bayar == 'belum' && $item->bukti_bayar)
                                                <button class="btn btn-outline-success btn-approve"
                                                    data-id="{{ $item->id_denda }}" title="Approve"
                                                    data-bs-toggle="tooltip">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                                <button class="btn btn-outline-danger btn-reject"
                                                    data-id="{{ $item->id_denda }}" title="Reject"
                                                    data-bs-toggle="tooltip">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            @endif
                                            <button class="btn btn-outline-info btn-detail"
                                                data-id="{{ $item->id_denda }}" title="Lihat Detail"
                                                data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-warning btn-edit"
                                                data-id="{{ $item->id_denda }}" title="Edit" data-bs-toggle="tooltip">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-outline-danger btn-delete"
                                                data-id="{{ $item->id_denda }}" title="Hapus" data-bs-toggle="tooltip">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                        </div>
                                        <p class="text-muted mb-0">Belum ada data denda</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                @if ($denda->hasPages())
                    <div class="border-top p-3">
                        {{ $denda->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div class="modal fade" id="modalDendaDetail" tabindex="-1" aria-labelledby="modalDendaDetailLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-gradient"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="modal-title text-white" id="modalDendaDetailLabel">
                        <i class="bi bi-info-circle me-2"></i>Detail Denda
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailBody">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div class="modal fade" id="modalDenda" tabindex="-1" aria-labelledby="modalDendaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <form id="formDenda" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-gradient"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        <h5 class="modal-title text-white" id="modalTitle">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Denda
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_denda" name="id_denda">
                        <input type="hidden" id="edit_mode" name="_method" value="">

                        <div class="mb-4">
                            <label for="id_riwayat_pelanggaran" class="form-label fw-semibold">
                                <i class="bi bi-person-check me-2"></i>Riwayat Pelanggaran <span
                                    class="text-danger">*</span>
                            </label>
                            <select id="id_riwayat_pelanggaran" name="id_riwayat_pelanggaran"
                                class="form-select form-select-lg" required>
                                <option value="">-- Pilih Riwayat Pelanggaran --</option>
                                @if (isset($allRiwayat) && $allRiwayat->count() > 0)
                                    @foreach ($allRiwayat as $r)
                                        @php $hasDenda = isset($r->denda) && $r->denda; @endphp
                                        <option value="{{ $r->id_riwayat_pelanggaran }}"
                                            {{ $hasDenda ? 'disabled' : '' }}>
                                            {{ $r->warga->nama ?? 'Warga' }} -
                                            {{ $r->pelanggaran->nama_pelanggaran ?? 'Pelanggaran' }}
                                            ({{ $r->tanggal ? \Carbon\Carbon::parse($r->tanggal)->format('d/m/Y') : '-' }})
                                            {!! $hasDenda ? ' &mdash; <em>(sudah didenda)</em>' : '' !!}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" disabled>Tidak ada riwayat pelanggaran</option>
                                @endif
                            </select>
                            @if (isset($allRiwayat) && $allRiwayat->whereNull('denda')->count() == 0)
                                <div class="alert alert-warning mt-2 mb-0">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Semua riwayat sudah memiliki denda atau belum ada riwayat.
                                </div>
                            @endif
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="nominal" class="form-label fw-semibold">
                                    <i class="bi bi-currency-dollar me-2"></i>Nominal Denda <span
                                        class="text-danger">*</span>
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text fw-semibold">Rp</span>
                                    <input type="number" id="nominal" name="nominal" class="form-control"
                                        min="0" step="1000" required placeholder="0"
                                        onInput="formatNominal(this)">
                                </div>
                                <small class="text-muted d-block mt-2">Masukkan nominal dalam rupiah</small>
                            </div>
                            <div class="col-md-6">
                                <label for="status_bayar" class="form-label fw-semibold">
                                    <i class="bi bi-flag me-2"></i>Status Bayar
                                </label>
                                <select id="status_bayar" name="status_bayar" class="form-select form-select-lg">
                                    <option value="belum">Belum Dibayar</option>
                                    <option value="dibayar">Sudah Dibayar</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4" id="tanggalBayarWrapper">
                            <label for="tanggal_bayar" class="form-label fw-semibold">
                                <i class="bi bi-calendar-event me-2"></i>Tanggal Bayar
                            </label>
                            <input type="date" id="tanggal_bayar" name="tanggal_bayar"
                                class="form-control form-control-lg">
                        </div>

                        <div class="mb-4">
                            <label for="bukti_bayar" class="form-label fw-semibold">
                                <i class="bi bi-file-earmark-arrow-up me-2"></i>Bukti Bayar
                            </label>
                            <div class="input-group">
                                <input type="file" id="bukti_bayar" name="bukti_bayar" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf" onchange="previewBukti(this)">
                            </div>
                            <small class="text-muted d-block mt-2">Format: JPG, PNG, PDF (Max: 5MB)</small>
                            <div id="buktiPreview" class="mt-3"></div>
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary btn-lg" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-lg" id="btnSubmit">
                            <span class="spinner-border spinner-border-sm d-none me-2" role="status"
                                id="loadingSpinner"></span>
                            <i class="bi bi-save me-2" id="saveIcon"></i>
                            <span id="submitText">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }

        .bg-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.1) !important;
        }

        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }

        /* Ensure modals appear above backdrop with correct z-index */
        .modal-backdrop {
            z-index: 1040;
        }

        .modal {
            z-index: 1050;
        }

        /* Center modal dialog properly */
        .modal-dialog {
            margin: 1.75rem auto;
        }

        /* Ensure modal is responsive */
        @media (min-width: 576px) {
            .modal-dialog {
                max-width: 500px;
            }

            .modal-dialog-lg {
                max-width: 800px;
            }
        }
    </style>
@endsection

@push('scripts')
    <script>
        // ==================== Variables ====================
        let isEdit = false;
        let dendaMap = {};
        let currentModal = null;

        // Load data denda ke JavaScript object
        @foreach ($denda as $item)
            dendaMap['{{ $item->id_denda }}'] = {
                id_denda: '{{ $item->id_denda }}',
                id_riwayat_pelanggaran: '{{ $item->id_riwayat_pelanggaran }}',
                nominal: {{ $item->nominal }},
                status_bayar: '{{ $item->status_bayar }}',
                tanggal_bayar: '{{ $item->tanggal_bayar ?? '' }}',
                bukti_bayar: '{{ $item->bukti_bayar ?? '' }}',
                riwayat_pelanggaran: {
                    pelanggaran: {
                        nama_pelanggaran: @json($item->riwayatPelanggaran?->pelanggaran?->nama_pelanggaran ?? '-')
                    },
                    warga: {
                        nama: @json($item->riwayatPelanggaran?->warga?->nama ?? '-')
                    }
                }
            };
        @endforeach

        console.log('✅ Data denda loaded:', Object.keys(dendaMap).length, 'records');

        // ==================== Utility Functions ====================
        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(angka);
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            return new Date(dateString).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
        }

        function formatNominal(input) {
            let value = input.value.replace(/[^\d]/g, '');
            if (value) {
                input.value = parseInt(value).toLocaleString('id-ID');
            }
        }

        function previewBukti(input) {
            const preview = document.getElementById('buktiPreview');
            preview.innerHTML = '';

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const ext = file.name.split('.').pop().toLowerCase();

                if (['jpg', 'jpeg', 'png'].includes(ext)) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML = `
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="bi bi-file-earmark-image me-2"></i>
                                <div>
                                    <small class="d-block mb-1"><strong>File dipilih:</strong> ${file.name}</small>
                                    <img src="${e.target.result}" class="img-thumbnail" style="max-height: 120px; cursor: pointer;" 
                                         onclick="window.open('${e.target.result}', '_blank')">
                                </div>
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.innerHTML = `
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-file-earmark-pdf me-2"></i>
                            <strong>${file.name}</strong> dipilih (PDF)
                        </div>
                    `;
                }
            }
        }

        function showLoading(show = true) {
            const spinner = document.getElementById('loadingSpinner');
            const icon = document.getElementById('saveIcon');
            const text = document.getElementById('submitText');
            const btn = document.getElementById('btnSubmit');

            if (show) {
                spinner.classList.remove('d-none');
                icon.classList.add('d-none');
                text.textContent = 'Menyimpan...';
                btn.disabled = true;
            } else {
                spinner.classList.add('d-none');
                icon.classList.remove('d-none');
                text.textContent = 'Simpan';
                btn.disabled = false;
            }
        }

        function updateRowNumbers() {
            document.querySelectorAll('.col-index').forEach((td, index) => {
                td.textContent = index + 1;
            });
        }

        function showAlert(message, type = 'success') {
            // Bisa diganti dengan toast notification
            const alertType = type === 'success' ? 'success' : 'danger';
            const alertHtml = `
                <div class="alert alert-${alertType} alert-dismissible fade show" role="alert">
                    <i class="bi ${type === 'success' ? 'bi-check-circle' : 'bi-exclamation-circle'} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            // Insert ke top of page
            const container = document.querySelector('.container-fluid');
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = alertHtml;
            container.insertBefore(tempDiv.firstElementChild, container.firstChild);
        }

        // ==================== Modal Functions ====================
        function btnTambahDenda() {
            console.log('🔵 btnTambahDenda called');

            try {
                isEdit = false;
                document.getElementById('modalTitle').innerHTML = '<i class="bi bi-plus-circle me-2"></i>Tambah Denda';
                document.getElementById('formDenda').reset();
                document.getElementById('id_denda').value = '';
                document.getElementById('edit_mode').value = '';
                document.getElementById('buktiPreview').innerHTML = '';

                // Enable riwayat pelanggaran select
                const selectRiwayat = document.getElementById('id_riwayat_pelanggaran');
                if (selectRiwayat) {
                    selectRiwayat.disabled = false;
                }

                // Show modal with proper Bootstrap 5 method
                const modalElement = document.getElementById('modalDenda');
                if (modalElement) {
                    console.log('✅ Modal element found, showing modal...');

                    // Get or create modal instance
                    let modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (!modalInstance) {
                        modalInstance = new bootstrap.Modal(modalElement);
                    }

                    currentModal = modalInstance;
                    currentModal.show();

                    console.log('✅ Modal shown successfully');
                } else {
                    console.error('❌ Modal element not found!');
                    alert('Error: Modal tidak ditemukan!');
                }
            } catch (error) {
                console.error('❌ Error in btnTambahDenda:', error);
                alert('Terjadi kesalahan saat membuka modal: ' + error.message);
            }
        }

        function showDendaById(id) {
            const data = dendaMap[id];
            if (!data) {
                showAlert('Data tidak ditemukan!', 'error');
                return;
            }

            const pelanggaran = data.riwayat_pelanggaran?.pelanggaran?.nama_pelanggaran || '-';
            const warga = data.riwayat_pelanggaran?.warga?.nama || '-';
            const tanggal = formatDate(data.tanggal_bayar);

            let buktiHtml =
                '<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>Tidak ada bukti bayar</div>';

            if (data.bukti_bayar) {
                const ext = data.bukti_bayar.split('.').pop().toLowerCase();
                const isImage = ['jpg', 'jpeg', 'png'].includes(ext);

                if (isImage) {
                    buktiHtml = `
                        <div class="text-center">
                            <img src="/storage/${data.bukti_bayar}" 
                                 class="img-fluid rounded shadow-sm" 
                                 style="max-height: 400px; cursor: pointer;"
                                 onclick="window.open('/storage/${data.bukti_bayar}', '_blank')">
                            <p class="mt-2 small text-muted">Klik gambar untuk memperbesar</p>
                        </div>
                    `;
                } else {
                    buktiHtml = `
                        <a href="/storage/${data.bukti_bayar}" target="_blank" class="btn btn-primary">
                            <i class="bi bi-file-pdf me-2"></i>Lihat Bukti Bayar (PDF)
                        </a>
                    `;
                }
            }

            const statusBadge = data.status_bayar === 'dibayar' ?
                '<span class="badge bg-success fs-6"><i class="bi bi-check-circle me-1"></i>Dibayar</span>' :
                '<span class="badge bg-warning fs-6"><i class="bi bi-clock me-1"></i>Belum Dibayar</span>';

            document.getElementById('detailBody').innerHTML = `
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="bi bi-info-circle me-2"></i>Informasi Denda
                                </h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td class="text-muted" style="width: 40%">Pelanggaran</td>
                                        <td class="fw-semibold">: ${pelanggaran}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Warga</td>
                                        <td class="fw-semibold">: ${warga}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Nominal</td>
                                        <td class="fw-semibold text-danger">: Rp ${formatRupiah(data.nominal)}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Status</td>
                                        <td>: ${statusBadge}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted">Tanggal Bayar</td>
                                        <td class="fw-semibold">: ${tanggal}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-3">
                                    <i class="bi bi-file-earmark-text me-2"></i>Bukti Bayar
                                </h6>
                                ${buktiHtml}
                            </div>
                        </div>
                    </div>
                </div>
            `;

            const modalElement = document.getElementById('modalDendaDetail');
            let modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (!modalInstance) {
                modalInstance = new bootstrap.Modal(modalElement);
            }
            modalInstance.show();
        }

        function openEditModalById(id) {
            const data = dendaMap[id];
            if (!data) {
                showAlert('Data tidak ditemukan!', 'error');
                return;
            }

            isEdit = true;
            document.getElementById('modalTitle').innerHTML = '<i class="bi bi-pencil me-2"></i>Edit Denda';
            document.getElementById('id_denda').value = data.id_denda;
            document.getElementById('edit_mode').value = 'PUT';
            document.getElementById('nominal').value = data.nominal;
            document.getElementById('status_bayar').value = data.status_bayar;
            document.getElementById('tanggal_bayar').value = data.tanggal_bayar || '';

            // Populate riwayat pelanggaran
            const selectRiwayat = document.getElementById('id_riwayat_pelanggaran');
            selectRiwayat.value = data.id_riwayat_pelanggaran;
            selectRiwayat.disabled = true; // Disable saat edit

            // Show existing bukti bayar
            const preview = document.getElementById('buktiPreview');
            if (data.bukti_bayar) {
                const ext = data.bukti_bayar.split('.').pop().toLowerCase();
                const isImage = ['jpg', 'jpeg', 'png'].includes(ext);

                preview.innerHTML = `
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-file-earmark-check me-2"></i>
                        <div class="flex-grow-1">
                            <small class="d-block mb-1"><strong>Bukti saat ini:</strong></small>
                            ${isImage 
                                ? `<img src="/storage/${data.bukti_bayar}" class="img-thumbnail" style="max-height: 80px; cursor: pointer;" onclick="window.open('/storage/${data.bukti_bayar}', '_blank')">`
                                : `<a href="/storage/${data.bukti_bayar}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                                        <i class="bi bi-file-pdf me-1"></i>Lihat PDF
                                                                       </a>`
                            }
                        </div>
                    </div>
                `;
            } else {
                preview.innerHTML = '';
            }

            const modalElement = document.getElementById('modalDenda');
            let modalInstance = bootstrap.Modal.getInstance(modalElement);
            if (!modalInstance) {
                modalInstance = new bootstrap.Modal(modalElement);
            }
            currentModal = modalInstance;
            currentModal.show();
        }

        // ==================== CRUD Operations ====================
        function deleteDenda(id) {
            if (!confirm('⚠️ Apakah Anda yakin ingin menghapus denda ini?\n\nTindakan ini tidak dapat dibatalkan.')) return;

            fetch(`/petugas/denda/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        const row = document.getElementById(`row${id}`);
                        if (row) {
                            row.style.transition = 'opacity 0.3s';
                            row.style.opacity = '0';
                            setTimeout(() => {
                                row.remove();
                                delete dendaMap[id];
                                updateRowNumbers();
                                showAlert('✅ Denda berhasil dihapus', 'success');
                            }, 300);
                        }
                    } else {
                        showAlert('❌ Gagal menghapus: ' + (result.message || 'Terjadi kesalahan'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('❌ Terjadi kesalahan jaringan', 'error');
                });
        }

        function approveDenda(id) {
            if (!confirm('✅ Approve pembayaran denda ini?')) return;

            fetch(`/petugas/denda/${id}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showAlert('✅ Pembayaran berhasil diapprove', 'success');
                        setTimeout(() => location.reload(), 500);
                    } else {
                        showAlert('❌ ' + (result.message || 'Gagal approve'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('❌ Terjadi kesalahan', 'error');
                });
        }

        function rejectDenda(id) {
            if (!confirm('❌ Reject pembayaran denda ini?\n\nBukti pembayaran akan dihapus.')) return;

            fetch(`/petugas/denda/${id}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        showAlert('✅ Pembayaran berhasil direject', 'success');
                        setTimeout(() => location.reload(), 500);
                    } else {
                        showAlert('❌ ' + (result.message || 'Gagal reject'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('❌ Terjadi kesalahan', 'error');
                });
        }

        // ==================== Event Listeners ====================
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 DOM loaded, initializing...');

            // Check if Bootstrap is loaded
            if (typeof bootstrap === 'undefined') {
                console.error('❌ Bootstrap JS not loaded!');
                alert('Error: Bootstrap JavaScript tidak ditemukan. Pastikan Bootstrap JS sudah diload di layout.');
            } else {
                console.log('✅ Bootstrap JS loaded');
            }

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            // Button Tambah Denda
            const btnTambah = document.getElementById('btnTambahDenda');
            if (btnTambah) {
                console.log('✅ Button Tambah Denda found');
                btnTambah.addEventListener('click', function(e) {
                    console.log('🔵 Button clicked!');
                    e.preventDefault();
                    btnTambahDenda();
                });
            } else {
                console.error('❌ Button Tambah Denda not found!');
            }

            // Check if modal exists
            const modalElement = document.getElementById('modalDenda');
            if (modalElement) {
                console.log('✅ Modal element found');
            } else {
                console.error('❌ Modal element not found!');
            }

            // Form Submit
            const formDenda = document.getElementById('formDenda');
            if (formDenda) {
                formDenda.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const id = document.getElementById('id_denda').value;
                    const url = isEdit ? `/petugas/denda/${id}` : '/petugas/denda';
                    const method = isEdit ? 'POST' : 'POST'; // Laravel uses POST with _method

                    const formData = new FormData(this);

                    // Add _method for PUT request
                    if (isEdit) {
                        formData.append('_method', 'PUT');
                    }

                    showLoading(true);

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Network response was not ok');
                            return response.json();
                        })
                        .then(result => {
                            showLoading(false);

                            if (result.success) {
                                showAlert(isEdit ? '✅ Denda berhasil diupdate' :
                                    '✅ Denda berhasil ditambahkan', 'success');

                                // Close modal
                                if (currentModal) {
                                    currentModal.hide();
                                }

                                // Reload page after short delay
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            } else {
                                showAlert('❌ Gagal menyimpan: ' + (result.message ||
                                    'Terjadi kesalahan'), 'error');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showLoading(false);
                            showAlert('❌ Terjadi kesalahan jaringan', 'error');
                        });
                });
            }

            // Status bayar change handler
            const statusBayar = document.getElementById('status_bayar');
            if (statusBayar) {
                statusBayar.addEventListener('change', function() {
                    const tanggalWrapper = document.getElementById('tanggalBayarWrapper');
                    if (this.value === 'dibayar') {
                        tanggalWrapper.style.display = 'block';
                        document.getElementById('tanggal_bayar').required = true;
                    } else {
                        tanggalWrapper.style.display = 'block';
                        document.getElementById('tanggal_bayar').required = false;
                    }
                });
            }

            // Search functionality
            const searchDenda = document.getElementById('searchDenda');
            if (searchDenda) {
                searchDenda.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();
                    document.querySelectorAll('.denda-row').forEach(row => {
                        const warga = row.dataset.warga;
                        const pelanggaran = row.dataset.pelanggaran;

                        if (warga.includes(searchTerm) || pelanggaran.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }

            // Event delegation for action buttons  
            document.body.addEventListener('click', function(e) {
                const target = e.target.closest('button');
                if (!target) return;

                const id = target.dataset.id;
                if (!id) return;

                if (target.classList.contains('btn-detail')) {
                    e.preventDefault();
                    console.log('Detail button clicked for ID:', id);
                    showDendaById(id);
                } else if (target.classList.contains('btn-edit')) {
                    e.preventDefault();
                    console.log('Edit button clicked for ID:', id);
                    openEditModalById(id);
                } else if (target.classList.contains('btn-delete')) {
                    e.preventDefault();
                    console.log('Delete button clicked for ID:', id);
                    deleteDenda(id);
                } else if (target.classList.contains('btn-approve')) {
                    e.preventDefault();
                    console.log('Approve button clicked for ID:', id);
                    approveDenda(id);
                } else if (target.classList.contains('btn-reject')) {
                    e.preventDefault();
                    console.log('Reject button clicked for ID:', id);
                    rejectDenda(id);
                }
            });

            console.log('✅ Initialization complete');
        });
    </script>
@endpush
