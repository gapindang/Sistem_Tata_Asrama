@extends('layouts.app')
@section('title', 'Data Pelanggaran')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center gap-3 text-white">
                            <div
                                style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h2 class="fw-bold mb-1">Jenis Pelanggaran</h2>
                                <p class="mb-0 opacity-75">Referensi jenis pelanggaran dan poin pelanggaran</p>
                            </div>
                            <div>
                                <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#catatModal">
                                    <i class="bi bi-plus-circle me-2"></i>Catat Pelanggaran
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                                <i class="bi bi-list-check"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 small">Total Jenis</p>
                                <h3 class="fw-bold mb-0">{{ $pelanggarans->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 small">Poin Tertinggi</p>
                                <h3 class="fw-bold mb-0">{{ $pelanggarans->max('poin') ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 small">Rata-rata Poin</p>
                                <h3 class="fw-bold mb-0">
                                    {{ $pelanggarans->count() > 0 ? number_format($pelanggarans->avg('poin'), 1) : 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Table Section --}}
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-table me-2" style="color: #f093fb;"></i>Daftar Pelanggaran
                    </h5>
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchPelanggaran" placeholder="Cari pelanggaran...">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 30%">Nama Pelanggaran</th>
                                <th style="width: 45%">Deskripsi</th>
                                <th class="text-center" style="width: 15%">Poin</th>
                                <th class="text-center" style="width: 5%">
                                    <i class="bi bi-info-circle" title="Informasi"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablePelanggaran">
                            @forelse ($pelanggarans as $index => $item)
                                <tr data-nama="{{ strtolower($item->nama_pelanggaran) }}">
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-x-circle text-danger"></i>
                                            <strong>{{ $item->nama_pelanggaran }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($item->deskripsi, 80) }}</small>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->poin >= 15)
                                            <span class="badge"
                                                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 8px 15px;">
                                                {{ $item->poin }} Poin
                                            </span>
                                        @elseif($item->poin >= 10)
                                            <span class="badge bg-warning text-dark" style="padding: 8px 15px;">
                                                {{ $item->poin }} Poin
                                            </span>
                                        @else
                                            <span class="badge bg-info" style="padding: 8px 15px;">
                                                {{ $item->poin }} Poin
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-primary btn-detail" data-bs-toggle="tooltip"
                                            title="Lihat Detail" data-id="{{ $item->id_pelanggaran }}"
                                            data-nama="{{ $item->nama_pelanggaran }}"
                                            data-deskripsi="{{ $item->deskripsi }}" data-poin="{{ $item->poin }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-3 mb-0">Tidak ada data pelanggaran</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Catat Pelanggaran --}}
    <div class="modal fade" id="catatModal" tabindex="-1" aria-labelledby="catatModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold" id="catatModalLabel">
                        <i class="bi bi-clipboard-plus me-2"></i>Catat Pelanggaran Baru
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <form id="formCatatPelanggaran" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.9rem;">
                                <i class="bi bi-person-fill me-1" style="color: #667eea;"></i>Warga Asrama
                                <span class="text-danger">*</span>
                            </label>
                            <select name="id_warga" class="form-select" id="selectWargaModal" required>
                                <option value="">-- Pilih Warga --</option>
                                @foreach (\App\Models\WargaAsrama::all() as $w)
                                    <option value="{{ $w->id_warga }}" data-nama="{{ $w->nama }}"
                                        data-nim="{{ $w->nim ?? '-' }}" data-kamar="{{ $w->kamar ?? '-' }}">
                                        {{ $w->nama }} - {{ $w->nim ?? 'Tanpa NIM' }} (Kamar {{ $w->kamar ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="wargaInfoModal" class="alert alert-info d-none mb-3 py-2"
                            style="border-radius: 8px; border-left: 3px solid #667eea;">
                            <div class="d-flex align-items-center gap-2">
                                <div
                                    style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1rem;">
                                    <span id="wargaInitialModal"></span>
                                </div>
                                <div>
                                    <div class="mb-0 fw-bold" style="font-size: 0.9rem;" id="wargaNamaModal"></div>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-card-text me-1"></i><span id="wargaNimModal"></span> |
                                        <i class="bi bi-door-closed ms-2 me-1"></i>Kamar <span
                                            id="wargaKamarModal"></span>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.9rem;">
                                <i class="bi bi-exclamation-triangle-fill me-1" style="color: #f093fb;"></i>Jenis
                                Pelanggaran
                                <span class="text-danger">*</span>
                            </label>
                            <select name="id_pelanggaran" class="form-select" id="selectPelanggaranModal" required>
                                <option value="">-- Pilih Pelanggaran --</option>
                                @foreach ($pelanggarans as $p)
                                    <option value="{{ $p->id_pelanggaran }}" data-poin="{{ $p->poin }}"
                                        data-deskripsi="{{ $p->deskripsi }}">
                                        {{ $p->nama_pelanggaran }} ({{ $p->poin }} Poin)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="pelanggaranInfoModal" class="alert alert-warning d-none mb-3 py-2"
                            style="border-radius: 8px; border-left: 3px solid #f093fb;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div style="flex: 1;">
                                    <div class="fw-bold mb-1" style="font-size: 0.85rem;"><i
                                            class="bi bi-info-circle me-1"></i>Detail Pelanggaran
                                    </div>
                                    <p class="mb-0" style="font-size: 0.75rem;" id="pelanggaranDeskripsiModal"></p>
                                </div>
                                <div class="text-end ms-2">
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Poin</small>
                                    <div class="fw-bold" style="color: #f5576c; font-size: 1.2rem;">
                                        <span id="pelanggaranPoinModal"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.9rem;">
                                <i class="bi bi-calendar-event me-1" style="color: #fa709a;"></i>Tanggal Kejadian
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal" class="form-control" id="inputTanggalModal"
                                value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.9rem;">
                                <i class="bi bi-camera me-1" style="color: #43e97b;"></i>Bukti Pelanggaran
                                <span class="text-muted small">(Opsional)</span>
                            </label>
                            <input type="file" name="bukti" class="form-control" id="inputBuktiModal"
                                accept="image/*,.pdf">
                            <small class="text-muted" style="font-size: 0.75rem;">Format: JPG, PNG, atau PDF (Maksimal
                                2MB)</small>
                            <div id="buktiPreviewModal" class="mt-2"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.9rem;">
                                <i class="bi bi-chat-left-text me-1" style="color: #667eea;"></i>Keterangan Tambahan
                                <span class="text-muted small">(Opsional)</span>
                            </label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Tambahkan keterangan detail..."
                                style="font-size: 0.9rem;"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="button" class="btn"
                        style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none;"
                        id="btnSimpanPelanggaran">
                        <span class="spinner-border spinner-border-sm d-none me-2" id="spinnerSubmit"></span>
                        <i class="bi bi-save me-1" id="iconSubmit"></i>Simpan Pelanggaran
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold" id="detailModalLabel">
                        <i class="bi bi-info-circle me-2"></i>Detail Pelanggaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="card border-0 bg-light" style="border-radius: 15px;">
                                <div class="card-body p-4">
                                    <div class="mb-4">
                                        <label class="text-muted small mb-2">Nama Pelanggaran</label>
                                        <h4 class="fw-bold mb-0" id="detailNama"></h4>
                                    </div>
                                    <div class="mb-4">
                                        <label class="text-muted small mb-2">Deskripsi</label>
                                        <p class="mb-0" id="detailDeskripsi"></p>
                                    </div>
                                    <div>
                                        <label class="text-muted small mb-2">Poin Pelanggaran</label>
                                        <h2 class="fw-bold mb-0" id="detailPoin"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn"
                        style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none;"
                        data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#catatModal">
                        <i class="bi bi-plus-circle me-1"></i>Catat Pelanggaran
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Tutup
                    </button>
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
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

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(240, 147, 251, 0.05);
        }

        #tablePelanggaran tr.hidden {
            display: none;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#selectWargaModal').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#catatModal'),
                placeholder: '-- Pilih Warga --',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Tidak ada data ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            $('#selectPelanggaranModal').select2({
                theme: 'bootstrap-5',
                dropdownParent: $('#catatModal'),
                placeholder: '-- Pilih Pelanggaran --',
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Tidak ada data ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Search functionality
            $('#searchPelanggaran').on('keyup', function() {
                const searchValue = $(this).val().toLowerCase();

                $('#tablePelanggaran tr').each(function() {
                    const nama = $(this).data('nama');
                    if (nama) {
                        if (nama.includes(searchValue)) {
                            $(this).removeClass('hidden');
                        } else {
                            $(this).addClass('hidden');
                        }
                    }
                });
            });

            // Detail button click
            $('.btn-detail').on('click', function() {
                const nama = $(this).data('nama');
                const deskripsi = $(this).data('deskripsi');
                const poin = $(this).data('poin');

                $('#detailNama').text(nama);
                $('#detailDeskripsi').text(deskripsi);

                let poinBadge = '';
                if (poin >= 15) {
                    poinBadge =
                        `<span class="badge fs-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">${poin} Poin</span>`;
                } else if (poin >= 10) {
                    poinBadge = `<span class="badge bg-warning text-dark fs-4">${poin} Poin</span>`;
                } else {
                    poinBadge = `<span class="badge bg-info fs-4">${poin} Poin</span>`;
                }
                $('#detailPoin').html(poinBadge);

                const modal = new bootstrap.Modal($('#detailModal')[0]);
                modal.show();
            });

            // Handle warga selection in modal
            $('#selectWargaModal').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const nama = selectedOption.data('nama');
                const nim = selectedOption.data('nim');
                const kamar = selectedOption.data('kamar');

                if (nama) {
                    $('#wargaInitialModal').text(nama.charAt(0).toUpperCase());
                    $('#wargaNamaModal').text(nama);
                    $('#wargaNimModal').text(nim);
                    $('#wargaKamarModal').text(kamar);
                    $('#wargaInfoModal').removeClass('d-none');
                } else {
                    $('#wargaInfoModal').addClass('d-none');
                }
            });

            // Handle pelanggaran selection in modal
            $('#selectPelanggaranModal').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const poin = selectedOption.data('poin');
                const deskripsi = selectedOption.data('deskripsi');

                if (poin) {
                    $('#pelanggaranPoinModal').text(poin + ' Poin');
                    $('#pelanggaranDeskripsiModal').text(deskripsi || 'Tidak ada deskripsi');
                    $('#pelanggaranInfoModal').removeClass('d-none');
                } else {
                    $('#pelanggaranInfoModal').addClass('d-none');
                }
            });

            // Handle file preview in modal
            $('#inputBuktiModal').on('change', function(e) {
                const file = e.target.files[0];
                const preview = $('#buktiPreviewModal');

                if (file) {
                    const fileType = file.type;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2);

                    if (fileSize > 2) {
                        alert('❌ Ukuran file terlalu besar! Maksimal 2MB');
                        $(this).val('');
                        preview.html('');
                        return;
                    }

                    if (fileType.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.html(`
                                <div class="alert alert-success p-2 mt-2" style="border-radius: 10px;">
                                    <img src="${e.target.result}" class="img-thumbnail" style="max-height: 80px;">
                                    <small class="d-block mt-1"><strong>${file.name}</strong> (${fileSize} MB)</small>
                                </div>
                            `);
                        };
                        reader.readAsDataURL(file);
                    } else if (fileType === 'application/pdf') {
                        preview.html(`
                            <div class="alert alert-success p-2 mt-2" style="border-radius: 10px;">
                                <i class="bi bi-file-pdf text-danger me-2"></i>
                                <small><strong>${file.name}</strong> (${fileSize} MB)</small>
                            </div>
                        `);
                    }
                } else {
                    preview.html('');
                }
            });

            // Handle form submit
            $('#btnSimpanPelanggaran').on('click', function() {
                const form = $('#formCatatPelanggaran')[0];
                const formData = new FormData(form);

                // Validation
                const warga = $('#selectWargaModal').val();
                const pelanggaran = $('#selectPelanggaranModal').val();
                const tanggal = $('#inputTanggalModal').val();

                if (!warga || !pelanggaran || !tanggal) {
                    alert('❌ Mohon lengkapi semua field yang wajib diisi!');
                    return;
                }

                const wargaNama = $('#selectWargaModal option:selected').data('nama');
                const pelanggaranNama = $('#selectPelanggaranModal option:selected').text();

                if (!confirm(
                        `Apakah Anda yakin ingin mencatat pelanggaran ini?\n\nWarga: ${wargaNama}\nPelanggaran: ${pelanggaranNama}\nTanggal: ${tanggal}`
                    )) {
                    return;
                }

                // Show loading
                $('#spinnerSubmit').removeClass('d-none');
                $('#iconSubmit').addClass('d-none');
                $(this).prop('disabled', true);

                // Submit via AJAX
                $.ajax({
                    url: '{{ route('petugas.riwayat_pelanggaran.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    success: function(response) {
                        // Hide loading
                        $('#spinnerSubmit').addClass('d-none');
                        $('#iconSubmit').removeClass('d-none');
                        $('#btnSimpanPelanggaran').prop('disabled', false);

                        if (response.success) {
                            // Show success alert
                            const alertHtml = `
                                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert"
                                    style="border-radius: 15px; border-left: 4px solid #43e97b;">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <strong>Berhasil!</strong> ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            `;
                            $('.container-fluid').prepend(alertHtml);

                            // Close modal and reset form
                            $('#catatModal').modal('hide');
                            $('#formCatatPelanggaran')[0].reset();
                            $('#selectWargaModal').val(null).trigger('change');
                            $('#selectPelanggaranModal').val(null).trigger('change');
                            $('#wargaInfoModal').addClass('d-none');
                            $('#pelanggaranInfoModal').addClass('d-none');
                            $('#buktiPreviewModal').html('');

                            // Scroll to top
                            window.scrollTo({
                                top: 0,
                                behavior: 'smooth'
                            });
                        }
                    },
                    error: function(xhr) {
                        // Hide loading
                        $('#spinnerSubmit').addClass('d-none');
                        $('#iconSubmit').removeClass('d-none');
                        $('#btnSimpanPelanggaran').prop('disabled', false);

                        let errorMsg = 'Terjadi kesalahan saat menyimpan data.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).flat().join(
                                '<br>');
                        }

                        alert('❌ ' + errorMsg);
                    }
                });
            });

            // Reset modal on close
            $('#catatModal').on('hidden.bs.modal', function() {
                $('#formCatatPelanggaran')[0].reset();
                $('#selectWargaModal').val(null).trigger('change');
                $('#selectPelanggaranModal').val(null).trigger('change');
                $('#wargaInfoModal').addClass('d-none');
                $('#pelanggaranInfoModal').addClass('d-none');
                $('#buktiPreviewModal').html('');
            });
        });
    </script>

    <style>
        /* Custom Select2 styling */
        .select2-container--bootstrap-5 .select2-selection {
            min-height: 38px;
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
            border-radius: 0.375rem;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            line-height: 1.5;
            padding-left: 0;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }

        .select2-container--bootstrap-5.select2-container--open .select2-selection {
            border-color: #f093fb;
            box-shadow: 0 0 0 0.25rem rgba(240, 147, 251, 0.25);
        }

        .select2-container--bootstrap-5 .select2-dropdown {
            border-color: #f093fb;
            font-size: 0.9rem;
        }

        .select2-container--bootstrap-5 .select2-results__option--highlighted {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .select2-container--bootstrap-5 .select2-search__field {
            font-size: 0.9rem;
        }
    </style>
@endpush
