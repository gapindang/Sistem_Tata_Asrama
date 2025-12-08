@extends('layouts.app')
@section('title', 'Data Penghargaan')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center gap-3 text-white">
                            <div
                                style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-trophy-fill" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Jenis Penghargaan</h2>
                                <p class="mb-0 opacity-75">Referensi jenis penghargaan dan poin reward</p>
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
                            <div class="icon-circle" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                <i class="bi bi-list-check"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 small">Total Jenis</p>
                                <h3 class="fw-bold mb-0">{{ $penghargaans->count() }}</h3>
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
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 small">Poin Tertinggi</p>
                                <h3 class="fw-bold mb-0">{{ $penghargaans->max('poin_reward') ?? 0 }}</h3>
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
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 small">Rata-rata Poin</p>
                                <h3 class="fw-bold mb-0">
                                    {{ $penghargaans->count() > 0 ? number_format($penghargaans->avg('poin_reward'), 1) : 0 }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Table Section --}}
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-table me-2" style="color: #43e97b;"></i>Daftar Penghargaan
                    </h5>
                    <div class="d-flex gap-2 align-items-center">
                        {{-- <button type="button" class="btn btn-sm"
                            style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border: none;"
                            data-bs-toggle="modal" data-bs-target="#beriPenghargaanModal">
                            <i class="bi bi-plus-circle me-1"></i>Beri Penghargaan
                        </button> --}}
                        <div class="input-group" style="max-width: 250px;">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" id="searchPenghargaan"
                                placeholder="Cari penghargaan...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 30%">Nama Penghargaan</th>
                                <th style="width: 45%">Deskripsi</th>
                                <th class="text-center" style="width: 15%">Poin Reward</th>
                                <th class="text-center" style="width: 5%">
                                    <i class="bi bi-info-circle" title="Informasi"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablePenghargaan">
                            @forelse ($penghargaans as $index => $item)
                                <tr data-nama="{{ strtolower($item->nama_penghargaan) }}">
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-award-fill text-success"></i>
                                            <strong>{{ $item->nama_penghargaan }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($item->deskripsi, 80) }}</small>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->poin_reward >= 15)
                                            <span class="badge"
                                                style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); padding: 8px 15px;">
                                                +{{ $item->poin_reward }} Poin
                                            </span>
                                        @elseif($item->poin_reward >= 10)
                                            <span class="badge"
                                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 8px 15px;">
                                                +{{ $item->poin_reward }} Poin
                                            </span>
                                        @else
                                            <span class="badge"
                                                style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 8px 15px;">
                                                +{{ $item->poin_reward }} Poin
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-success btn-detail" data-bs-toggle="tooltip"
                                            title="Lihat Detail" data-id="{{ $item->id_penghargaan }}"
                                            data-nama="{{ $item->nama_penghargaan }}"
                                            data-deskripsi="{{ $item->deskripsi }}" data-poin="{{ $item->poin_reward }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-3 mb-0">Tidak ada data penghargaan</p>
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
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold" id="detailModalLabel">
                        <i class="bi bi-info-circle me-2"></i>Detail Penghargaan
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
                                        <label class="text-muted small mb-2">Nama Penghargaan</label>
                                        <h4 class="fw-bold mb-0" id="detailNama"></h4>
                                    </div>
                                    <div class="mb-4">
                                        <label class="text-muted small mb-2">Deskripsi</label>
                                        <p class="mb-0" id="detailDeskripsi"></p>
                                    </div>
                                    <div>
                                        <label class="text-muted small mb-2">Poin Reward</label>
                                        <h2 class="fw-bold mb-0" id="detailPoin"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn"
                        style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border: none;"
                        data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#beriPenghargaanModal">
                        <i class="bi bi-plus-circle me-1"></i>Beri Penghargaan
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Beri Penghargaan --}}
    <div class="modal fade" id="beriPenghargaanModal" tabindex="-1" aria-labelledby="beriPenghargaanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold" id="beriPenghargaanModalLabel">
                        <i class="bi bi-award-fill me-2"></i>Beri Penghargaan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <form id="formBeriPenghargaan">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.9rem;">
                                <i class="bi bi-person-fill me-1" style="color: #667eea;"></i>Warga Asrama
                                <span class="text-danger">*</span>
                            </label>
                            <select name="id_warga" class="form-select" id="selectWargaPenghargaan" required>
                                <option value="">-- Pilih Warga --</option>
                                @foreach (\App\Models\WargaAsrama::all() as $w)
                                    <option value="{{ $w->id_warga }}" data-nama="{{ $w->nama }}"
                                        data-nim="{{ $w->nim ?? '-' }}" data-kamar="{{ $w->nomor_kamar ?? '-' }}">
                                        {{ $w->nama }} - {{ $w->nim ?? 'Tanpa NIM' }} (Kamar
                                        {{ $w->nomor_kamar ?? '-' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="wargaInfoPenghargaan" class="alert alert-info d-none mb-3 py-2"
                            style="border-radius: 8px; border-left: 3px solid #43e97b;">
                            <div class="d-flex align-items-center gap-2">
                                <div
                                    style="width: 35px; height: 35px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1rem;">
                                    <span id="wargaInitialPenghargaan"></span>
                                </div>
                                <div>
                                    <div class="mb-0 fw-bold" style="font-size: 0.9rem;" id="wargaNamaPenghargaan"></div>
                                    <small class="text-muted" style="font-size: 0.75rem;">
                                        <i class="bi bi-card-text me-1"></i><span id="wargaNimPenghargaan"></span> |
                                        <i class="bi bi-door-closed ms-2 me-1"></i>Kamar <span
                                            id="wargaKamarPenghargaan"></span>
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.9rem;">
                                <i class="bi bi-trophy-fill me-1" style="color: #43e97b;"></i>Jenis Penghargaan
                                <span class="text-danger">*</span>
                            </label>
                            <select name="id_penghargaan" class="form-select" id="selectPenghargaanModal" required>
                                <option value="">-- Pilih Penghargaan --</option>
                                @foreach ($penghargaans as $p)
                                    <option value="{{ $p->id_penghargaan }}" data-poin="{{ $p->poin_reward }}"
                                        data-deskripsi="{{ $p->deskripsi }}">
                                        {{ $p->nama_penghargaan }} (+{{ $p->poin_reward }} Poin)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="penghargaanInfo" class="alert alert-success d-none mb-3 py-2"
                            style="border-radius: 8px; border-left: 3px solid #43e97b;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div style="flex: 1;">
                                    <div class="fw-bold mb-1" style="font-size: 0.85rem;">
                                        <i class="bi bi-info-circle me-1"></i>Detail Penghargaan
                                    </div>
                                    <p class="mb-0" style="font-size: 0.75rem;" id="penghargaanDeskripsiModal"></p>
                                </div>
                                <div class="text-end ms-2">
                                    <small class="text-muted d-block" style="font-size: 0.7rem;">Poin Reward</small>
                                    <div class="fw-bold" style="color: #43e97b; font-size: 1.2rem;">
                                        +<span id="penghargaanPoinModal"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold" style="font-size: 0.9rem;">
                                <i class="bi bi-calendar-event me-1" style="color: #667eea;"></i>Tanggal
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="tanggal" class="form-control" id="inputTanggalPenghargaan"
                                value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Batal
                    </button>
                    <button type="button" class="btn"
                        style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border: none;"
                        id="btnSubmitPenghargaan">
                        <i class="bi bi-check-circle me-1"></i>Beri Penghargaan
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
            background: rgba(67, 233, 123, 0.05);
        }

        #tablePenghargaan tr.hidden {
            display: none;
        }
    </style>
@endsection

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            $('#searchPenghargaan').on('keyup', function() {
                const searchValue = $(this).val().toLowerCase();

                $('#tablePenghargaan tr').each(function() {
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

            $('.btn-detail').on('click', function() {
                const nama = $(this).data('nama');
                const deskripsi = $(this).data('deskripsi');
                const poin = $(this).data('poin');

                $('#detailNama').text(nama);
                $('#detailDeskripsi').text(deskripsi);

                let poinBadge = '';
                if (poin >= 15) {
                    poinBadge =
                        `<span class="badge fs-4" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">+${poin} Poin</span>`;
                } else if (poin >= 10) {
                    poinBadge =
                        `<span class="badge fs-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">+${poin} Poin</span>`;
                } else {
                    poinBadge =
                        `<span class="badge fs-4" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">+${poin} Poin</span>`;
                }
                $('#detailPoin').html(poinBadge);

                const modal = new bootstrap.Modal($('#detailModal')[0]);
                modal.show();
            });

            // Initialize Select2 for Beri Penghargaan Modal
            $('#selectWargaPenghargaan').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Pilih Warga --',
                dropdownParent: $('#beriPenghargaanModal')
            });

            $('#selectPenghargaanModal').select2({
                theme: 'bootstrap-5',
                placeholder: '-- Pilih Penghargaan --',
                dropdownParent: $('#beriPenghargaanModal')
            });

            // Show warga info when selected
            $('#selectWargaPenghargaan').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const nama = selectedOption.data('nama');
                const nim = selectedOption.data('nim');
                const kamar = selectedOption.data('kamar');

                if (nama) {
                    const initial = nama.charAt(0).toUpperCase();
                    $('#wargaInitialPenghargaan').text(initial);
                    $('#wargaNamaPenghargaan').text(nama);
                    $('#wargaNimPenghargaan').text(nim);
                    $('#wargaKamarPenghargaan').text(kamar);
                    $('#wargaInfoPenghargaan').removeClass('d-none');
                } else {
                    $('#wargaInfoPenghargaan').addClass('d-none');
                }
            });

            // Show penghargaan info when selected
            $('#selectPenghargaanModal').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const poin = selectedOption.data('poin');
                const deskripsi = selectedOption.data('deskripsi');

                if (poin) {
                    $('#penghargaanPoinModal').text(poin);
                    $('#penghargaanDeskripsiModal').text(deskripsi || '-');
                    $('#penghargaanInfo').removeClass('d-none');
                } else {
                    $('#penghargaanInfo').addClass('d-none');
                }
            });

            // Submit Beri Penghargaan
            $('#btnSubmitPenghargaan').on('click', function() {
                const form = $('#formBeriPenghargaan');
                const formData = new FormData(form[0]);

                // Validate form
                if (!form[0].checkValidity()) {
                    form[0].reportValidity();
                    return;
                }

                // Disable button
                $(this).prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...');

                $.ajax({
                    url: '{{ route('petugas.riwayat-penghargaan.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            // Show success message
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Penghargaan berhasil diberikan dan notifikasi telah dikirim.',
                                confirmButtonColor: '#43e97b'
                            }).then(() => {
                                // Close modal and reload page
                                $('#beriPenghargaanModal').modal('hide');
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Terjadi kesalahan saat memberikan penghargaan.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMsg,
                            confirmButtonColor: '#dc3545'
                        });

                        // Enable button
                        $('#btnSubmitPenghargaan').prop('disabled', false).html(
                            '<i class="bi bi-check-circle me-1"></i>Beri Penghargaan');
                    }
                });
            });

            // Reset form when modal is closed
            $('#beriPenghargaanModal').on('hidden.bs.modal', function() {
                $('#formBeriPenghargaan')[0].reset();
                $('#selectWargaPenghargaan').val('').trigger('change');
                $('#selectPenghargaanModal').val('').trigger('change');
                $('#wargaInfoPenghargaan').addClass('d-none');
                $('#penghargaanInfo').addClass('d-none');
                $('#btnSubmitPenghargaan').prop('disabled', false).html(
                    '<i class="bi bi-check-circle me-1"></i>Beri Penghargaan');
            });
        });
    </script>
@endpush
