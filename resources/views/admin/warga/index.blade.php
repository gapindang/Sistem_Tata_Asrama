@extends('layouts.app')
@section('title', 'Data Warga Asrama')

@section('content')
    <h2 class="mb-4">👥 Data Warga Asrama</h2>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addModal">
        + Tambah Warga
    </button>

    <div class="card mb-3">
        <div class="card-body">
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
                    <button type="submit" class="btn btn-secondary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Kamar</th>
                    <th>Angkatan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="wargaTableBody">
                @forelse ($wargas as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $row->nama }}</td>
                        <td>{{ $row->nim ?? '-' }}</td>
                        <td>{{ $row->kamar ?? '-' }}</td>
                        <td>{{ $row->angkatan ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $row->status == 'aktif' ? 'success' : 'danger' }}">
                                {{ ucfirst($row->status) }}
                            </span>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info btn-detail" data-id="{{ $row->id_warga }}">
                                Detail
                            </button>
                            <button type="button" class="btn btn-sm btn-warning btn-edit" data-id="{{ $row->id_warga }}">
                                Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="{{ $row->id_warga }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada data warga</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

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
