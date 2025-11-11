@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-md-8">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-gradient"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-people text-white" style="font-size: 24px;"></i>
                    </div>
                    <div>
                        <h1 class="fw-bold mb-1">Data Warga Asrama</h1>
                        <p class="text-muted mb-0">Kelola informasi warga asrama dengan mudah</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid #667eea;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Total Warga</p>
                                <h3 class="fw-bold mb-0">{{ \App\Models\WargaAsrama::count() }}</h3>
                            </div>
                            <div style="font-size: 2rem; color: #667eea;"><i class="bi bi-people-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid #43e97b;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Warga Aktif</p>
                                <h3 class="fw-bold mb-0">{{ \App\Models\WargaAsrama::where('status', 'aktif')->count() }}
                                </h3>
                            </div>
                            <div style="font-size: 2rem; color: #43e97b;"><i class="bi bi-check-circle-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 stat-card" style="border-left: 4px solid #f093fb;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <p class="text-muted small mb-1">Warga Nonaktif</p>
                                <h3 class="fw-bold mb-0">{{ \App\Models\WargaAsrama::where('status', 'nonaktif')->count() }}
                                </h3>
                            </div>
                            <div style="font-size: 2rem; color: #f093fb;"><i class="bi bi-x-circle-fill"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter Section --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-funnel me-2"></i>Filter Data</h5>
            </div>
            <div class="card-body">
                <form id="filterForm" class="row g-3">
                    <div class="col-md-3">
                        <label for="filterNama" class="form-label small fw-semibold">Nama Warga</label>
                        <input type="text" id="filterNama" name="nama" class="form-control" placeholder="Cari nama..."
                            value="{{ request('nama') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="filterNIM" class="form-label small fw-semibold">NIM</label>
                        <input type="text" id="filterNIM" name="nim" class="form-control" placeholder="NIM"
                            value="{{ request('nim') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="filterBlok" class="form-label small fw-semibold">Blok</label>
                        <select id="filterBlok" name="blok" class="form-select">
                            <option value="">-- Semua Blok --</option>
                            @foreach ($bloks as $blok)
                                <option value="{{ $blok }}" {{ request('blok') == $blok ? 'selected' : '' }}>
                                    {{ $blok }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="filterKamar" class="form-label small fw-semibold">Kamar</label>
                        <select id="filterKamar" name="kamar" class="form-select">
                            <option value="">-- Semua Kamar --</option>
                            @foreach ($kamarByBlok as $km)
                                <option value="{{ $km }}" {{ request('kamar') == $km ? 'selected' : '' }}>
                                    {{ $km }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="filterStatus" class="form-label small fw-semibold">Status</label>
                        <select id="filterStatus" name="status" class="form-select">
                            <option value="">-- Semua Status --</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif
                            </option>
                        </select>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-1"></i>Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-table me-2"></i>Daftar Warga</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 20%">Nama</th>
                                <th style="width: 12%">NIM</th>
                                <th class="text-center" style="width: 12%">Kamar</th>
                                <th class="text-center" style="width: 10%">Angkatan</th>
                                <th class="text-center" style="width: 10%">Status</th>
                                <th class="text-center" style="width: 21%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="wargaTableBody">
                            @forelse ($warga as $index => $row)
                                <tr id="row{{ $row->id_warga }}">
                                    <td class="text-center fw-bold">
                                        {{ ($warga->currentPage() - 1) * $warga->perPage() + $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2"
                                                style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi bi-person text-primary"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $row->nama }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <code>{{ $row->nim ?? '-' }}</code>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-info bg-opacity-10 text-info px-3 py-2">{{ $row->kamar ?? '-' }}</span>
                                    </td>
                                    <td class="text-center">{{ $row->angkatan ?? '-' }}</td>
                                    <td class="text-center">
                                        @if ($row->status == 'aktif')
                                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                                <i class="bi bi-check-circle me-1"></i>Aktif
                                            </span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                                <i class="bi bi-x-circle me-1"></i>Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <button class="btn btn-outline-info"
                                                onclick="showDetail('{{ $row->id_warga }}')" title="Lihat Detail"
                                                data-bs-toggle="tooltip">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button class="btn btn-outline-warning"
                                                onclick="editWarga('{{ $row->id_warga }}')" title="Edit"
                                                data-bs-toggle="tooltip">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <button class="btn btn-outline-danger"
                                                onclick="deleteWarga('{{ $row->id_warga }}')" title="Hapus"
                                                data-bs-toggle="tooltip">
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
                                        <p class="text-muted mb-0">Belum ada data warga</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                @if ($warga->hasPages())
                    <div class="border-top p-3">
                        {{ $warga->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div class="modal fade" id="modalDetail" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0">
                <div class="modal-header bg-gradient"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-info-circle me-2"></i>Detail Warga
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detailContent">
                    <div class="text-center py-5">
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

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <div class="modal-header bg-gradient"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <h5 class="modal-title text-white">
                        <i class="bi bi-pencil-square me-2"></i>Edit Warga
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="formEdit" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">

                        <div class="mb-3">
                            <label for="editNama" class="form-label fw-semibold">Nama Warga</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="editNIM" class="form-label fw-semibold">NIM</label>
                            <input type="text" class="form-control" id="editNIM" name="nim" required>
                        </div>
                        <div class="mb-3">
                            <label for="editKamar" class="form-label fw-semibold">Kamar</label>
                            <input type="text" class="form-control" id="editKamar" name="kamar" required
                                placeholder="Cth: A-101">
                        </div>
                        <div class="mb-3">
                            <label for="editAngkatan" class="form-label fw-semibold">Angkatan</label>
                            <input type="number" class="form-control" id="editAngkatan" name="angkatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label fw-semibold">Status</label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Simpan Perubahan
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

        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.1) !important;
        }

        .table-hover tbody tr {
            transition: all 0.2s ease;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
        }
    </style>
@endsection

@push('scripts')
    <script>
        let currentEditId = null;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })

            // Cascading dropdown: Blok -> Kamar
            const blokSelect = document.getElementById('filterBlok');
            const kamarSelect = document.getElementById('filterKamar');

            if (blokSelect) {
                blokSelect.addEventListener('change', function() {
                    const blok = this.value;
                    kamarSelect.innerHTML = '<option value="">-- Semua Kamar --</option>';
                    kamarSelect.disabled = !blok;

                    if (blok) {
                        fetch(`{{ route('petugas.warga.getKamar') }}?blok=${blok}`)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(kamar => {
                                    const option = document.createElement('option');
                                    option.value = kamar;
                                    option.textContent = kamar;
                                    kamarSelect.appendChild(option);
                                });
                            })
                            .catch(error => console.error('Error:', error));
                    }
                });
            }

            // Form submit
            const filterForm = document.getElementById('filterForm');
            if (filterForm) {
                filterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    this.submit(); // Allow normal form submission
                });
            }

            // Edit form submit
            const editForm = document.getElementById('formEdit');
            if (editForm) {
                editForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const id = document.getElementById('editId').value;
                    const url = `{{ route('petugas.warga.update', ':id') }}`.replace(':id', id);

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(result => {
                            if (result.success) {
                                bootstrap.Modal.getInstance(document.getElementById('modalEdit'))
                            .hide();
                                showAlert('✅ Data warga berhasil diperbarui', 'success');
                                setTimeout(() => location.reload(), 1000);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showAlert('❌ Gagal menyimpan data', 'error');
                        });
                });
            }
        });

        function showDetail(id) {
            const detailContent = document.getElementById('detailContent');
            detailContent.innerHTML =
                '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            fetch(`{{ route('petugas.warga.show', ':id') }}`.replace(':id', id), {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(warga => {
                    const statusBadge = warga.status === 'aktif' ?
                        '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Aktif</span>' :
                        '<span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Nonaktif</span>';

                    detailContent.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3"><i class="bi bi-person-badge me-2"></i>Data Pribadi</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td class="text-muted" style="width: 40%">Nama</td>
                                    <td class="fw-semibold">: ${warga.nama}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">NIM</td>
                                    <td class="fw-semibold">: ${warga.nim || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Kamar</td>
                                    <td class="fw-semibold">: ${warga.kamar || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Angkatan</td>
                                    <td class="fw-semibold">: ${warga.angkatan || '-'}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted">Status</td>
                                    <td>: ${statusBadge}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3"><i class="bi bi-graph-up me-2"></i>Statistik</h6>
                            <div class="card bg-light border-0 mb-2">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Total Pelanggaran</span>
                                        <strong>${warga.riwayat_pelanggaran ? warga.riwayat_pelanggaran.length : 0}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted">Total Penghargaan</span>
                                        <strong>${warga.riwayat_penghargaan ? warga.riwayat_penghargaan.length : 0}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;

                    new bootstrap.Modal(document.getElementById('modalDetail')).show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('❌ Gagal memuat data', 'error');
                });
        }

        function editWarga(id) {
            fetch(`{{ route('petugas.warga.show', ':id') }}`.replace(':id', id), {
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(warga => {
                    document.getElementById('editId').value = warga.id_warga;
                    document.getElementById('editNama').value = warga.nama;
                    document.getElementById('editNIM').value = warga.nim || '';
                    document.getElementById('editKamar').value = warga.kamar || '';
                    document.getElementById('editAngkatan').value = warga.angkatan || '';
                    document.getElementById('editStatus').value = warga.status || 'aktif';

                    const form = document.getElementById('formEdit');
                    form.action = `{{ route('petugas.warga.update', ':id') }}`.replace(':id', id);

                    new bootstrap.Modal(document.getElementById('modalEdit')).show();
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('❌ Gagal memuat data', 'error');
                });
        }

        function deleteWarga(id) {
            if (!confirm('⚠️ Apakah Anda yakin ingin menghapus warga ini?')) return;

            fetch(`{{ route('petugas.warga.destroy', ':id') }}`.replace(':id', id), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        const row = document.getElementById(`row${id}`);
                        if (row) {
                            row.style.transition = 'opacity 0.3s';
                            row.style.opacity = '0';
                            setTimeout(() => {
                                row.remove();
                                showAlert('✅ Warga berhasil dihapus', 'success');
                            }, 300);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('❌ Gagal menghapus warga', 'error');
                });
        }

        function showAlert(message, type = 'success') {
            const alertType = type === 'success' ? 'success' : 'danger';
            const alertHtml = `
                <div class="alert alert-${alertType} alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            const container = document.querySelector('.container-fluid');
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = alertHtml;
            container.insertBefore(tempDiv.firstElementChild, container.firstChild);
        }
    </script>
@endpush
