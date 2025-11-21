@extends('layouts.app')
@section('title', 'Pengaturan Sistem')
@section('content')

    <style>
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .page-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
            font-size: 1.8rem;
        }

        .page-header p {
            margin-bottom: 0;
            opacity: 0.95;
        }

        .settings-nav {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .settings-nav .nav-link {
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 600;
            transition: all 0.3s;
            color: #666;
            border: 2px solid transparent;
        }

        .settings-nav .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .settings-nav .nav-link:not(.active):hover {
            background: #f8f9fa;
            color: #333;
        }

        .settings-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .settings-card h4 {
            color: #333;
            font-weight: 700;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .form-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 12px 15px;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .btn-save {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .logo-preview {
            width: 150px;
            height: 150px;
            object-fit: contain;
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 10px;
            background: #f8f9fa;
        }

        .pelanggaran-item {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .pelanggaran-item:hover {
            background: #fff;
            border-left-color: #667eea;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        }

        .badge-kategori {
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .kategori-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 20px;
            }

            .page-header h2 {
                font-size: 1.5rem;
            }

            .settings-card {
                padding: 20px;
            }
        }
    </style>

    <div class="container-fluid px-3 px-md-4 mt-3 mt-md-4">
        <!-- Page Header -->
        <div class="page-header">
            <h2><i class="bi bi-gear-fill"></i> Pengaturan Sistem</h2>
            <p>Kelola pengaturan, kategori pelanggaran, dan identitas asrama</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Navigation Tabs -->
        <div class="settings-nav">
            <ul class="nav nav-pills" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="identitas-tab" data-bs-toggle="pill" data-bs-target="#identitas"
                        type="button" role="tab">
                        <i class="bi bi-building me-2"></i>Identitas Asrama
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="kategori-tab" data-bs-toggle="pill" data-bs-target="#kategori"
                        type="button" role="tab">
                        <i class="bi bi-list-task me-2"></i>Kategori Pelanggaran
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="settingsTabContent">
            <!-- Identitas Asrama Tab -->
            <div class="tab-pane fade show active" id="identitas" role="tabpanel">
                <div class="settings-card">
                    <h4><i class="bi bi-building me-2"></i>Identitas Asrama</h4>
                    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="nama_asrama" class="form-label">
                                        <i class="bi bi-building me-1"></i>Nama Asrama
                                    </label>
                                    <input type="text" class="form-control" id="nama_asrama" name="nama_asrama"
                                        value="{{ $pengaturan['nama_asrama'] ?? '' }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat_asrama" class="form-label">
                                        <i class="bi bi-geo-alt me-1"></i>Alamat
                                    </label>
                                    <textarea class="form-control" id="alamat_asrama" name="alamat_asrama" rows="3">{{ $pengaturan['alamat_asrama'] ?? '' }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="telepon_asrama" class="form-label">
                                                <i class="bi bi-telephone me-1"></i>Telepon
                                            </label>
                                            <input type="text" class="form-control" id="telepon_asrama"
                                                name="telepon_asrama" value="{{ $pengaturan['telepon_asrama'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="email_asrama" class="form-label">
                                                <i class="bi bi-envelope me-1"></i>Email
                                            </label>
                                            <input type="email" class="form-control" id="email_asrama" name="email_asrama"
                                                value="{{ $pengaturan['email_asrama'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="kepala_asrama" class="form-label">
                                        <i class="bi bi-person-badge me-1"></i>Kepala Asrama
                                    </label>
                                    <input type="text" class="form-control" id="kepala_asrama" name="kepala_asrama"
                                        value="{{ $pengaturan['kepala_asrama'] ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-image me-1"></i>Logo Asrama
                                    </label>
                                    <div class="text-center mb-3">
                                        @if (isset($pengaturan['logo_asrama']) && $pengaturan['logo_asrama'])
                                            <img src="{{ asset('storage/' . $pengaturan['logo_asrama']) }}"
                                                alt="Logo Asrama" class="logo-preview mb-3" id="logoPreview">
                                        @else
                                            <div class="logo-preview mb-3 d-flex align-items-center justify-content-center"
                                                id="logoPreview">
                                                <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" class="form-control" id="logo_asrama" name="logo_asrama"
                                        accept="image/*" onchange="previewLogo(event)">
                                    <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-save">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Kategori Pelanggaran Tab -->
            <div class="tab-pane fade" id="kategori" role="tabpanel">
                <div class="settings-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0"><i class="bi bi-list-task me-2"></i>Kategori Pelanggaran & Poin</h4>
                        <button class="btn btn-save" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                            <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
                        </button>
                    </div>

                    @forelse ($pelanggaranByKategori as $kategori => $items)
                        <div class="kategori-header">
                            <i class="bi bi-folder me-2"></i>{{ $kategori }}
                        </div>

                        @foreach ($items as $pelanggaran)
                            <div class="pelanggaran-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-2">{{ $pelanggaran->nama_pelanggaran }}</h6>
                                        <div class="d-flex gap-3 mb-2">
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-triangle me-1"></i>{{ $pelanggaran->poin }}
                                                Poin
                                            </span>
                                            <span class="badge bg-warning text-dark">
                                                <i class="bi bi-cash me-1"></i>Rp
                                                {{ number_format($pelanggaran->denda, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        @if ($pelanggaran->deskripsi)
                                            <p class="text-muted small mb-0">{{ $pelanggaran->deskripsi }}</p>
                                        @endif
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#editKategoriModal{{ $pelanggaran->id_pelanggaran }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form
                                            action="{{ route('admin.pengaturan.kategori.delete', $pelanggaran->id_pelanggaran) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editKategoriModal{{ $pelanggaran->id_pelanggaran }}"
                                tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="border-radius: 15px;">
                                        <div class="modal-header"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                                            <h5 class="modal-title fw-bold">
                                                <i class="bi bi-pencil me-2"></i>Edit Kategori Pelanggaran
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('admin.pengaturan.kategori.update') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id_pelanggaran"
                                                value="{{ $pelanggaran->id_pelanggaran }}">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Pelanggaran</label>
                                                    <input type="text" class="form-control" name="nama_pelanggaran"
                                                        value="{{ $pelanggaran->nama_pelanggaran }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Kategori</label>
                                                    <select class="form-select" name="kategori" required>
                                                        <option value="Ringan"
                                                            {{ $pelanggaran->kategori == 'Ringan' ? 'selected' : '' }}>
                                                            Ringan</option>
                                                        <option value="Sedang"
                                                            {{ $pelanggaran->kategori == 'Sedang' ? 'selected' : '' }}>
                                                            Sedang</option>
                                                        <option value="Berat"
                                                            {{ $pelanggaran->kategori == 'Berat' ? 'selected' : '' }}>Berat
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Poin</label>
                                                            <input type="number" class="form-control" name="poin"
                                                                value="{{ $pelanggaran->poin }}" required min="0">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-3">
                                                            <label class="form-label">Denda (Rp)</label>
                                                            <input type="number" class="form-control" name="denda"
                                                                value="{{ $pelanggaran->denda }}" required
                                                                min="0">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi</label>
                                                    <textarea class="form-control" name="deskripsi" rows="3">{{ $pelanggaran->deskripsi }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-save">
                                                    <i class="bi bi-save me-1"></i>Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @empty
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 4rem; color: #ddd;"></i>
                            <p class="text-muted mt-3">Belum ada kategori pelanggaran</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div class="modal fade" id="tambahKategoriModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 15px;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Kategori Pelanggaran
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.pengaturan.kategori.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Pelanggaran</label>
                            <input type="text" class="form-control" name="nama_pelanggaran" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kategori</label>
                            <select class="form-select" name="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <option value="Ringan">Ringan</option>
                                <option value="Sedang">Sedang</option>
                                <option value="Berat">Berat</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Poin</label>
                                    <input type="number" class="form-control" name="poin" required min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Denda (Rp)</label>
                                    <input type="number" class="form-control" name="denda" required min="0">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-save">
                            <i class="bi bi-save me-1"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewLogo(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('logoPreview');
                if (output.tagName === 'IMG') {
                    output.src = reader.result;
                } else {
                    output.innerHTML = '<img src="' + reader.result +
                        '" alt="Logo Preview" class="logo-preview">';
                }
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

@endsection
