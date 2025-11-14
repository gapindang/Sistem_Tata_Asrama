@extends('layouts.app')
@section('title', 'Master Penghargaan')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex justify-content-between align-items-center text-white">
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-trophy-fill" style="font-size: 2rem;"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">Master Penghargaan</h2>
                                    <p class="mb-0 opacity-75">Kelola jenis penghargaan dan poin reward</p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal"
                                data-bs-target="#addModal">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Penghargaan
                            </button>
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
                            <div
                                style="width: 50px; height: 50px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-list-ul text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Total Jenis</p>
                                <h3 class="fw-bold mb-0" style="color: #43e97b;">{{ $penghargaans->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-star-fill text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Poin Tertinggi</p>
                                <h3 class="fw-bold mb-0" style="color: #667eea;">
                                    {{ $penghargaans->max('poin_reward') ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                style="width: 50px; height: 50px; background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-calculator text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Rata-rata Poin</p>
                                <h3 class="fw-bold mb-0" style="color: #fa709a;">
                                    {{ number_format($penghargaans->avg('poin_reward') ?? 0, 1) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom py-3">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-0"><i class="bi bi-table me-2" style="color: #43e97b;"></i>Daftar Penghargaan
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="searchPenghargaan"
                            placeholder="🔍 Cari penghargaan...">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 35%">Nama Penghargaan</th>
                                <th style="width: 40%">Deskripsi</th>
                                <th class="text-center" style="width: 10%">Poin</th>
                                <th class="text-center" style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="penghargaanTableBody">
                            @forelse ($penghargaans as $index => $penghargaan)
                                <tr class="penghargaan-row" data-nama="{{ strtolower($penghargaan->nama_penghargaan) }}">
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div
                                                style="width: 35px; height: 35px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                                <i class="bi bi-award-fill"></i>
                                            </div>
                                            <strong>{{ $penghargaan->nama_penghargaan }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small
                                            class="text-muted">{{ Str::limit($penghargaan->deskripsi ?? 'Tidak ada deskripsi', 80) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge px-3 py-2"
                                            style="background: {{ $penghargaan->poin_reward >= 15 ? 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)' : ($penghargaan->poin_reward >= 10 ? 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)' : 'linear-gradient(135deg, #a8edea 0%, #fed6e3 100%)') }}; color: white; font-weight: bold; font-size: 0.9rem;">
                                            +{{ $penghargaan->poin_reward }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-warning btn-edit"
                                                data-id="{{ $penghargaan->id_penghargaan }}"
                                                data-nama="{{ $penghargaan->nama_penghargaan }}"
                                                data-deskripsi="{{ $penghargaan->deskripsi }}"
                                                data-poin="{{ $penghargaan->poin_reward }}" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-delete"
                                                data-id="{{ $penghargaan->id_penghargaan }}" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="mb-3">
                                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                                        </div>
                                        <p class="text-muted mb-0">Belum ada data penghargaan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <form id="formTambah" method="POST" action="{{ route('admin.penghargaan.store') }}">
                    @csrf
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Penghargaan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Penghargaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_penghargaan" class="form-control form-control-lg" required
                                placeholder="Contoh: Juara Lomba Kebersihan">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi penghargaan (opsional)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Poin Reward <span class="text-danger">*</span></label>
                            <input type="number" name="poin_reward" class="form-control form-control-lg" required
                                min="1" max="100" placeholder="0">
                            <small class="text-muted">Poin reward antara 1-100</small>
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white"
                            style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                            <i class="bi bi-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Penghargaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Penghargaan <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="edit_nama" name="nama_penghargaan"
                                class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea id="edit_deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Poin Reward <span class="text-danger">*</span></label>
                            <input type="number" id="edit_poin" name="poin_reward" class="form-control form-control-lg"
                                required min="1" max="100">
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-save me-2"></i>Update
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
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(67, 233, 123, 0.05);
        }

        .btn-group-sm .btn {
            transition: all 0.2s ease;
        }

        .btn-group-sm .btn:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Search functionality
            $('#searchPenghargaan').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.penghargaan-row').each(function() {
                    const nama = $(this).data('nama');
                    if (nama.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            // Edit button handler
            $('.btn-edit').on('click', function() {
                const id = $(this).data('id');
                const nama = $(this).data('nama');
                const deskripsi = $(this).data('deskripsi');
                const poin = $(this).data('poin');

                $('#edit_id').val(id);
                $('#edit_nama').val(nama);
                $('#edit_deskripsi').val(deskripsi);
                $('#edit_poin').val(poin);

                $('#formEdit').attr('action', `/admin/penghargaan/${id}`);
                $('#editModal').modal('show');
            });

            // Delete button handler
            $('.btn-delete').on('click', function() {
                if (!confirm('⚠️ Apakah Anda yakin ingin menghapus penghargaan ini?')) return;

                const id = $(this).data('id');
                $.ajax({
                    url: `/admin/penghargaan/${id}`,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('❌ Gagal menghapus: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('❌ Terjadi kesalahan saat menghapus');
                    }
                });
            });

            // Form submit handlers
            $('#formTambah').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert('❌ Gagal menyimpan: ' + (xhr.responseJSON?.message ||
                            'Terjadi kesalahan'));
                    }
                });
            });

            $('#formEdit').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert('❌ Gagal update: ' + (xhr.responseJSON?.message ||
                            'Terjadi kesalahan'));
                    }
                });
            });
        });
    </script>
@endpush
