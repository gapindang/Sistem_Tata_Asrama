@extends('layouts.app')

@section('content')
    <div class="container py-4">
        {{-- Header --}}
        <div class="card border-0 shadow-sm mb-4"
            style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 15px;">
            <div class="card-body py-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-3 text-white">
                        <div
                            style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-cash-coin" style="font-size: 2rem;"></i>
                        </div>
                        <div>
                            <h2 class="fw-bold mb-1">Kelola Denda</h2>
                            <p class="mb-0 opacity-75">Manajemen denda dan pembayaran</p>
                        </div>
                    </div>
                    <!-- Call initialization function first; do not use Bootstrap's data-bs auto-toggle -->
                    <button type="button" class="btn btn-light btn-lg shadow-sm" id="btnTambahDenda"
                        onclick="btnTambahDenda();">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Denda
                    </button>
                </div>
            </div>
        </div>
        <!-- Fallback for injected content: ensure click always calls btnTambahDenda -->
        <script>
            (function() {
                const btn = document.getElementById('btnTambahDenda');
                if (!btn) return;
                // Ensure handler exists even if DOMContentLoaded didn't run for injected HTML
                btn.addEventListener('click', function(e) {
                    try {
                        if (typeof btnTambahDenda === 'function') {
                            // btnTambahDenda will show the modal via bootstrap.Modal
                            btnTambahDenda();
                        }
                    } catch (err) {
                        console.error('btnTambahDenda fallback error:', err);
                    }
                });
            })();
        </script>
    </div>

    {{-- Table --}}
    <div class="card border-0 shadow-sm" style="border-radius: 15px;">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-table me-2" style="color: #fa709a;"></i>Daftar Denda
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th style="width: 20%">Pelanggaran</th>
                            <th style="width: 15%">Warga</th>
                            <th class="text-end" style="width: 15%">Nominal</th>
                            <th class="text-center" style="width: 12%">Status</th>
                            <th class="text-center" style="width: 13%">Tanggal Bayar</th>
                            <th class="text-center" style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tableDenda">
                        @forelse ($denda as $index => $item)
                            <tr id="row{{ $item->id_denda }}">
                                <td class="text-center col-index">{{ $index + 1 }}</td>
                                <td>{{ $item->riwayatPelanggaran?->pelanggaran?->nama_pelanggaran ?? '-' }}</td>
                                <td>{{ $item->riwayatPelanggaran?->warga?->nama ?? '-' }}</td>
                                <td class="text-end">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    @if ($item->status_bayar == 'dibayar')
                                        <span class="badge bg-success-subtle text-success border border-success"
                                            style="padding: 8px 12px;">
                                            <i class="bi bi-check-circle-fill me-1"></i>Dibayar
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning"
                                            style="padding: 8px 12px;">
                                            <i class="bi bi-clock-fill me-1"></i>Belum Dibayar
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') : '-' }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-info"
                                            onclick="showDendaById('{{ $item->id_denda }}')" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-warning"
                                            onclick="openEditModalById('{{ $item->id_denda }}')" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-outline-danger"
                                            onclick="deleteDenda('{{ $item->id_denda }}')" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    @if ($item->status_bayar == 'belum')
                                        <button class="btn btn-sm mt-1 w-100"
                                            style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border: none;"
                                            onclick="confirmPayment('{{ $item->id_denda }}')">
                                            <i class="bi bi-check-circle me-1"></i>Konfirmasi
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    Belum ada data denda
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    {{-- Modal Detail --}}
    <div class="modal fade" id="modalDendaDetail" tabindex="-1" aria-labelledby="modalDendaDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="modalDendaDetailLabel">
                        <i class="bi bi-info-circle me-2"></i>Detail Denda
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detailBody">
                    <div class="text-center py-3">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form --}}
    <div class="modal fade" id="modalDenda" tabindex="-1" aria-labelledby="modalDendaLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="formDenda" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title fw-bold" id="modalTitle">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Denda
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="id_denda" name="id_denda">
                        <input type="hidden" id="edit_mode" name="_method" value="">

                        <div class="mb-3">
                            <label for="id_riwayat_pelanggaran" class="form-label">
                                Riwayat Pelanggaran <span class="text-danger">*</span>
                            </label>
                            <select id="id_riwayat_pelanggaran" name="id_riwayat_pelanggaran" class="form-select"
                                required>
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
                                <div class="form-text text-warning">Semua riwayat sudah memiliki denda atau belum ada
                                    riwayat. Jika ingin menambahkan denda, pastikan ada riwayat pelanggaran yang belum
                                    didenda.</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="nominal" class="form-label">
                                Nominal Denda <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" id="nominal" name="nominal" class="form-control" min="0"
                                    step="1000" required placeholder="0">
                            </div>
                            <small class="text-muted">Masukkan nominal dalam rupiah</small>
                        </div>

                        <div class="mb-3">
                            <label for="status_bayar" class="form-label">Status Bayar</label>
                            <select id="status_bayar" name="status_bayar" class="form-select">
                                <option value="belum">Belum Dibayar</option>
                                <option value="dibayar">Sudah Dibayar</option>
                            </select>
                        </div>

                        <div class="mb-3" id="tanggalBayarWrapper">
                            <label for="tanggal_bayar" class="form-label">Tanggal Bayar</label>
                            <input type="date" id="tanggal_bayar" name="tanggal_bayar" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="bukti_bayar" class="form-label">Bukti Bayar</label>
                            <input type="file" id="bukti_bayar" name="bukti_bayar" class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf">
                            <small class="text-muted">Format: JPG, PNG, PDF (Max: 2MB)</small>
                            <div id="buktiPreview" class="mt-2"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="btnSubmit">
                            <span class="spinner-border spinner-border-sm d-none me-1" role="status"
                                id="loadingSpinner"></span>
                            <i class="bi bi-save me-1" id="saveIcon"></i>
                            <span id="submitText">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
                month: '2-digit',
                year: 'numeric'
            });
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
            alert(message); // Bisa diganti dengan toast notification yang lebih baik
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

                // Show modal
                const modalElement = document.getElementById('modalDenda');
                if (modalElement) {
                    console.log('✅ Modal element found, showing modal...');
                    currentModal = new bootstrap.Modal(modalElement);
                    currentModal.show();
                } else {
                    console.error('❌ Modal element not found!');
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

            new bootstrap.Modal(document.getElementById('modalDendaDetail')).show();
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

            currentModal = new bootstrap.Modal(document.getElementById('modalDenda'));
            currentModal.show();
        }

        // ==================== CRUD Operations ====================
        function deleteDenda(id) {
            if (!confirm('⚠️ Apakah Anda yakin ingin menghapus denda ini?\n\nTindakan ini tidak dapat dibatalkan.')) return;

            fetch(`/admin/denda/${id}`, {
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

        function confirmPayment(id) {
            const today = new Date().toISOString().split('T')[0];
            const tanggal = prompt('📅 Masukkan tanggal pembayaran:\n\nFormat: YYYY-MM-DD (contoh: 2024-10-30)', today);

            if (!tanggal) return;

            // Validasi format tanggal
            const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
            if (!dateRegex.test(tanggal)) {
                showAlert('❌ Format tanggal tidak valid! Gunakan format YYYY-MM-DD', 'error');
                return;
            }

            if (!confirm(`✅ Konfirmasi pembayaran denda pada tanggal ${formatDate(tanggal)}?`)) return;

            fetch(`/admin/denda/${id}/confirm`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        tanggal_bayar: tanggal
                    })
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(result => {
                    if (result.success) {
                        const denda = result.denda;

                        // Update dendaMap
                        dendaMap[id] = {
                            ...dendaMap[id],
                            status_bayar: 'dibayar',
                            tanggal_bayar: denda.tanggal_bayar
                        };

                        // Update table row
                        const row = document.getElementById(`row${id}`);
                        if (row) {
                            const badge = row.querySelector('.badge');
                            badge.className = 'badge bg-success';
                            badge.innerHTML = '<i class="bi bi-check-circle me-1"></i>Dibayar';

                            row.querySelector('td:nth-child(6)').textContent = formatDate(denda.tanggal_bayar);

                            const confirmBtn = row.querySelector('button[onclick*="confirmPayment"]');
                            if (confirmBtn) confirmBtn.remove();
                        }

                        showAlert('✅ Pembayaran berhasil dikonfirmasi', 'success');
                    } else {
                        showAlert('❌ Gagal mengonfirmasi: ' + (result.message || 'Terjadi kesalahan'), 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('❌ Terjadi kesalahan jaringan', 'error');
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
                    const url = isEdit ? `/admin/denda/${id}` : '/admin/denda';
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

            console.log('✅ Initialization complete');
        });
    </script>
@endpush
