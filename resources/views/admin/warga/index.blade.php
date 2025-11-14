@extends('layouts.app')
@section('title', 'Data Warga Asrama')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex justify-content-between align-items-center text-white">
                            <div class="d-flex align-items-center gap-3">
                                <div
                                    style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">Data Warga Asrama</h2>
                                    <p class="mb-0 opacity-75">Kelola data warga asrama dengan mudah</p>
                                </div>
                            </div>
                            <button type="button" class="btn btn-light btn-lg" data-bs-toggle="modal"
                                data-bs-target="#addModal">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Warga
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Card --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-funnel-fill me-2" style="color: #667eea;"></i>Filter Pencarian</h5>
            </div>
            <div class="card-body p-4">
                <form id="filterForm" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="nama" class="form-control" placeholder="Cari nama...">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="nim" class="form-control" placeholder="NIM">
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="kamar" class="form-control" placeholder="Kamar">
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="angkatan" class="form-control" placeholder="Angkatan">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="aktif">Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn w-100"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-table me-2" style="color: #667eea;"></i>Daftar Warga</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 20%">Nama</th>
                                <th style="width: 15%">NIM</th>
                                <th class="text-center" style="width: 10%">Kamar</th>
                                <th class="text-center" style="width: 12%">Angkatan</th>
                                <th class="text-center" style="width: 12%">Status</th>
                                <th class="text-center" style="width: 26%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="wargaTableBody">
                            @forelse ($wargas as $i => $row)
                                <tr>
                                    <td class="text-center fw-bold">{{ $i + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div
                                                style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                {{ strtoupper(substr($row->nama, 0, 1)) }}
                                            </div>
                                            <strong>{{ $row->nama }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $row->nim ?? '-' }}</td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">{{ $row->kamar ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">{{ $row->angkatan ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($row->status == 'aktif')
                                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i>{{ ucfirst($row->status) }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                                <i class="bi bi-x-circle me-1"></i>{{ ucfirst($row->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button type="button" class="btn btn-outline-info btn-detail"
                                                data-id="{{ $row->id_warga }}" title="Detail">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-warning btn-edit"
                                                data-id="{{ $row->id_warga }}" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-delete"
                                                data-id="{{ $row->id_warga }}" title="Hapus">
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
                                        <p class="text-muted mb-0">Tidak ada data warga</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.1) !important;
        }

        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        .btn-group-sm .btn {
            transition: all 0.2s ease;
        }

        .btn-group-sm .btn:hover {
            transform: translateY(-2px);
        }
    </style>

    <!-- Modal Tambah -->
    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formTambahWarga">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Tambah Warga Asrama</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>NIM</label>
                            <input type="text" name="nim" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Kamar</label>
                            <input type="text" name="kamar" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Angkatan</label>
                            <input type="number" name="angkatan" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-select" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditWarga">
                    @csrf
                    @method('PUT')
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Edit Data Warga</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_id_warga" name="id_warga">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label>NIM</label>
                            <input type="text" class="form-control" id="edit_nim" name="nim" required>
                        </div>
                        <div class="mb-3">
                            <label>Kamar</label>
                            <input type="text" class="form-control" id="edit_kamar" name="kamar" required>
                        </div>
                        <div class="mb-3">
                            <label>Angkatan</label>
                            <input type="number" class="form-control" id="edit_angkatan" name="angkatan" required>
                        </div>
                        <div class="mb-3">
                            <label>Status</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-warning">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Detail Warga Asrama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>Nama</th>
                                    <td id="detail_nama"></td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td id="detail_nim"></td>
                                </tr>
                                <tr>
                                    <th>Kamar</th>
                                    <td id="detail_kamar"></td>
                                </tr>
                                <tr>
                                    <th>Angkatan</th>
                                    <td id="detail_angkatan"></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td id="detail_status"></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <h6>Riwayat Pelanggaran</h6>
                                <ul id="detail_pelanggaran" class="list-group">
                                </ul>
                            </div>
                            <div>
                                <h6>Riwayat Penghargaan</h6>
                                <ul id="detail_penghargaan" class="list-group">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function() {
                function loadWargaTable(filterData = null) {
                    $.ajax({
                        url: filterData ? "{{ route('admin.warga.filter') }}" :
                            "{{ route('admin.warga.index') }}",
                        method: "GET",
                        data: filterData,
                        dataType: 'json',
                        success: function(response) {
                            if (!response.success) {
                                console.error('Response error:', response);
                                $('#wargaTableBody').html(
                                    '<tr><td colspan="7" class="text-center">Gagal memuat data</td></tr>'
                                );
                                return;
                            }

                            const wargas = response.wargas || [];

                            if (wargas.length === 0) {
                                $('#wargaTableBody').html(
                                    '<tr><td colspan="7" class="text-center">Tidak ada data warga</td></tr>'
                                );
                                return;
                            }

                            let html = '';
                            wargas.forEach((warga, index) => {
                                html += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${warga.nama || '-'}</td>
                                        <td>${warga.nim || '-'}</td>
                                        <td>${warga.kamar || '-'}</td>
                                        <td>${warga.angkatan || '-'}</td>
                                        <td>
                                            <span class="badge bg-${(warga.status || 'nonaktif') === 'aktif' ? 'success' : 'danger'}">
                                                ${warga.status ? (warga.status.charAt(0).toUpperCase() + warga.status.slice(1)) : 'Nonaktif'}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info btn-detail" data-id="${warga.id_warga}">
                                                Detail
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning btn-edit" data-id="${warga.id_warga}">
                                                Edit
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${warga.id_warga}">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });
                            $('#wargaTableBody').html(html ||
                                '<tr><td colspan="7" class="text-center">Tidak ada data warga</td></tr>'
                            );
                        },
                        error: function(xhr) {
                            console.error('Error loading data:', xhr);
                            $('#wargaTableBody').html(
                                '<tr><td colspan="7" class="text-center">Gagal memuat data warga</td></tr>'
                            );
                        }
                    });
                }

                $('#filterForm').on('submit', function(e) {
                    e.preventDefault();
                    loadWargaTable($(this).serialize());
                });

                $('#formTambahWarga').on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "{{ route('admin.warga.store') }}",
                        method: "POST",
                        data: $(this).serialize(),
                        success: function(res) {
                            $('#addModal').modal('hide');
                            $(this).trigger('reset');
                            loadWargaTable();
                            alert('Warga berhasil ditambahkan!');
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                            alert('Gagal menambahkan warga: ' + xhr.responseJSON?.message ||
                                'Unknown error');
                        }
                    });
                });

                $(document).on('click', '.btn-edit', function() {
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/admin/warga/${id}`,
                        method: 'GET',
                        success: function(response) {
                            const warga = response.data;
                            $('#edit_id_warga').val(warga.id_warga);
                            $('#edit_nama').val(warga.nama);
                            $('#edit_nim').val(warga.nim);
                            $('#edit_kamar').val(warga.kamar);
                            $('#edit_angkatan').val(warga.angkatan);
                            $('#edit_status').val(warga.status);
                            $('#editModal').modal('show');
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                            alert('Gagal memuat data warga');
                        }
                    });
                });

                $('#formEditWarga').on('submit', function(e) {
                    e.preventDefault();
                    const id = $('#edit_id_warga').val();
                    $.ajax({
                        url: `/admin/warga/${id}`,
                        method: 'PUT',
                        data: $(this).serialize(),
                        success: function(response) {
                            $('#editModal').modal('hide');
                            loadWargaTable();
                            alert('Data warga berhasil diperbarui!');
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                            alert('Gagal memperbarui data warga: ' + xhr.responseJSON?.message ||
                                'Unknown error');
                        }
                    });
                });

                $(document).on('click', '.btn-detail', function() {
                    const id = $(this).data('id');
                    $.ajax({
                        url: `/admin/warga/${id}`,
                        method: 'GET',
                        success: function(response) {
                            const warga = response.data;

                            $('#detail_nama').text(warga.nama);
                            $('#detail_nim').text(warga.nim || '-');
                            $('#detail_kamar').text(warga.kamar || '-');
                            $('#detail_angkatan').text(warga.angkatan || '-');
                            $('#detail_status').html(`
                <span class="badge bg-${warga.status === 'aktif' ? 'success' : 'danger'}">
                    ${warga.status.charAt(0).toUpperCase() + warga.status.slice(1)}
                </span>
            `);

                            let pelanggaranHtml = '';
                            if (warga.riwayat_pelanggaran && warga.riwayat_pelanggaran.length > 0) {
                                warga.riwayat_pelanggaran.forEach(p => {
                                    pelanggaranHtml += `
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">${p.pelanggaran?.nama_pelanggaran || '-'}</h6>
                                    <small class="text-muted">${p.tanggal || '-'}</small>
                                </div>
                                <span class="badge bg-danger">${p.pelanggaran?.poin || 0} Poin</span>
                            </div>
                        </li>
                    `;
                                });
                            } else {
                                pelanggaranHtml =
                                    '<li class="list-group-item">Tidak ada riwayat pelanggaran</li>';
                            }
                            $('#detail_pelanggaran').html(pelanggaranHtml);

                            let penghargaanHtml = '';
                            if (warga.riwayat_penghargaan && warga.riwayat_penghargaan.length > 0) {
                                warga.riwayat_penghargaan.forEach(p => {
                                    penghargaanHtml += `
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">${p.penghargaan?.nama_penghargaan || '-'}</h6>
                                    <small class="text-muted">${p.tanggal || '-'}</small>
                                </div>
                                <span class="badge bg-success">${p.penghargaan?.poin_reward || 0} Poin</span>
                            </div>
                        </li>
                    `;
                                });
                            } else {
                                penghargaanHtml =
                                    '<li class="list-group-item">Tidak ada riwayat penghargaan</li>';
                            }
                            $('#detail_penghargaan').html(penghargaanHtml);

                            $('#detailModal').modal('show');
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                            alert('Gagal memuat detail warga');
                        }
                    });
                });


                $(document).on('click', '.btn-delete', function() {
                    if (!confirm('Anda yakin ingin menghapus data warga ini?')) return;

                    const id = $(this).data('id');
                    $.ajax({
                        url: `/admin/warga/${id}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            loadWargaTable();
                            alert('Data warga berhasil dihapus!');
                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                            alert('Gagal menghapus data warga');
                        }
                    });
                });

                loadWargaTable();
            });
        </script>
    @endpush
@endsection
