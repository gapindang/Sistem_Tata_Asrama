@extends('layouts.app')
@section('title', 'Master Pelanggaran')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex justify-content-between align-items-center text-white">
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-exclamation-triangle-fill" style="font-size: 2rem;"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">Master Pelanggaran</h2>
                                    <p class="mb-0 opacity-75">Kelola jenis pelanggaran dan poin sanksi</p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal"
                                data-bs-target="#addModal">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Pelanggaran
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
                                style="width: 50px; height: 50px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-list-ul text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Total Jenis</p>
                                <h3 class="fw-bold mb-0" style="color: #f093fb;">{{ $pelanggarans->count() }}</h3>
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
                                <i class="bi bi-exclamation-circle text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Poin Tertinggi</p>
                                <h3 class="fw-bold mb-0" style="color: #fa709a;">{{ $pelanggarans->max('poin') ?? 0 }}</h3>
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
                                <i class="bi bi-calculator text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <div>
                                <p class="text-muted small mb-1">Rata-rata Poin</p>
                                <h3 class="fw-bold mb-0" style="color: #667eea;">
                                    {{ number_format($pelanggarans->avg('poin') ?? 0, 1) }}</h3>
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
                        <h5 class="fw-bold mb-0"><i class="bi bi-table me-2" style="color: #f093fb;"></i>Daftar Pelanggaran
                        </h5>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="searchPelanggaran"
                            placeholder="🔍 Cari pelanggaran...">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 35%">Nama Pelanggaran</th>
                                <th style="width: 40%">Deskripsi</th>
                                <th class="text-center" style="width: 10%">Poin</th>
                                <th class="text-center" style="width: 10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="pelanggaranTableBody">
                            @forelse ($pelanggarans as $index => $pelanggaran)
                                <tr class="pelanggaran-row" data-nama="{{ strtolower($pelanggaran->nama_pelanggaran) }}">
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div
                                                style="width: 35px; height: 35px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 8px; display: flex; align-items-center; justify-content: center; color: white;">
                                                <i class="bi bi-x-circle"></i>
                                            </div>
                                            <strong>{{ $pelanggaran->nama_pelanggaran }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small
                                            class="text-muted">{{ Str::limit($pelanggaran->deskripsi ?? 'Tidak ada deskripsi', 80) }}</small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge px-3 py-2"
                                            style="background: {{ $pelanggaran->poin >= 15 ? 'linear-gradient(135deg, #ff416c 0%, #ff4b2b 100%)' : ($pelanggaran->poin >= 10 ? 'linear-gradient(135deg, #fa709a 0%, #fee140 100%)' : 'linear-gradient(135deg, #fbc2eb 0%, #a6c1ee 100%)') }}; color: white; font-weight: bold; font-size: 0.9rem;">
                                            {{ $pelanggaran->poin }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-warning btn-edit"
                                                data-id="{{ $pelanggaran->id_pelanggaran }}"
                                                data-nama="{{ $pelanggaran->nama_pelanggaran }}"
                                                data-deskripsi="{{ $pelanggaran->deskripsi }}"
                                                data-poin="{{ $pelanggaran->poin }}" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-delete"
                                                data-id="{{ $pelanggaran->id_pelanggaran }}" title="Hapus">
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
                                        <p class="text-muted mb-0">Belum ada data pelanggaran</p>
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
                <form id="formTambah" method="POST" action="{{ route('admin.pelanggaran.store') }}">
                    @csrf
                    <div class="modal-header"
                        style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Tambah Pelanggaran</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pelanggaran <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="nama_pelanggaran" class="form-control form-control-lg" required
                                placeholder="Contoh: Terlambat masuk asrama">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi pelanggaran (opsional)"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Poin Pelanggaran <span
                                    class="text-danger">*</span></label>
                            <input type="number" name="poin" class="form-control form-control-lg" required
                                min="1" max="100" placeholder="0">
                            <small class="text-muted">Poin antara 1-100</small>
                        </div>
                    </div>
                    <div class="modal-footer border-top">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn text-white"
                            style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
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
                        <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Pelanggaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <input type="hidden" id="edit_id">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Pelanggaran <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="edit_nama" name="nama_pelanggaran"
                                class="form-control form-control-lg" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea id="edit_deskripsi" name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Poin Pelanggaran <span
                                    class="text-danger">*</span></label>
                            <input type="number" id="edit_poin" name="poin" class="form-control form-control-lg"
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
            background-color: rgba(240, 147, 251, 0.05);
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
            $('#searchPelanggaran').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.pelanggaran-row').each(function() {
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

                $('#formEdit').attr('action', `/admin/pelanggaran/${id}`);
                $('#editModal').modal('show');
            });

            // Delete button handler
            $('.btn-delete').on('click', function() {
                if (!confirm('⚠️ Apakah Anda yakin ingin menghapus pelanggaran ini?')) return;

                const id = $(this).data('id');
                $.ajax({
                    url: `/admin/pelanggaran/${id}`,
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
