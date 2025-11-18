@extends('layouts.app')
@section('title', 'Catat Pelanggaran')

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
                                <i class="bi bi-clipboard-plus" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Catat Pelanggaran Baru</h2>
                                <p class="mb-0 opacity-75">Input pelanggaran warga asrama</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert"
                style="border-radius: 15px; border-left: 4px solid #43e97b;">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Berhasil!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert"
                style="border-radius: 15px; border-left: 4px solid #f5576c;">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Terjadi Kesalahan!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-form me-2" style="color: #f093fb;"></i>Form Pencatatan Pelanggaran
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('petugas.riwayat_pelanggaran.store') }}"
                            enctype="multipart/form-data" id="formPelanggaran">
                            @csrf

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-person-fill me-2" style="color: #667eea;"></i>Warga Asrama
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="id_warga" class="form-select form-select-lg" id="selectWarga" required>
                                    <option value="">-- Pilih Warga --</option>
                                    @foreach ($wargas as $w)
                                        <option value="{{ $w->id_warga }}" data-nama="{{ $w->nama }}"
                                            data-nim="{{ $w->nim ?? '-' }}" data-kamar="{{ $w->kamar ?? '-' }}">
                                            {{ $w->nama }} - {{ $w->nim ?? 'Tanpa NIM' }} (Kamar
                                            {{ $w->kamar ?? '-' }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Pilih warga yang melakukan pelanggaran</small>
                            </div>

                            <div id="wargaInfo" class="alert alert-info d-none mb-4"
                                style="border-radius: 12px; border-left: 4px solid #667eea;">
                                <div class="d-flex align-items-center gap-3">
                                    <div
                                        style="width: 50px; height: 50px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 1.5rem;">
                                        <span id="wargaInitial"></span>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 fw-bold" id="wargaNama"></h6>
                                        <small class="text-muted">
                                            <i class="bi bi-card-text me-1"></i><span id="wargaNim"></span> |
                                            <i class="bi bi-door-closed ms-2 me-1"></i>Kamar <span id="wargaKamar"></span>
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-exclamation-triangle-fill me-2" style="color: #f093fb;"></i>Jenis
                                    Pelanggaran
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="id_pelanggaran" class="form-select form-select-lg" id="selectPelanggaran"
                                    required>
                                    <option value="">-- Pilih Pelanggaran --</option>
                                    @foreach ($pelanggarans as $p)
                                        <option value="{{ $p->id_pelanggaran }}" data-poin="{{ $p->poin }}"
                                            data-deskripsi="{{ $p->deskripsi }}">
                                            {{ $p->nama_pelanggaran }} ({{ $p->poin }} Poin)
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-muted">Pilih jenis pelanggaran yang dilakukan</small>
                            </div>

                            <div id="pelanggaranInfo" class="alert alert-warning d-none mb-4"
                                style="border-radius: 12px; border-left: 4px solid #f093fb;">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6 class="fw-bold mb-2"><i class="bi bi-info-circle me-2"></i>Detail Pelanggaran
                                        </h6>
                                        <p class="mb-0 small" id="pelanggaranDeskripsi"></p>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <label class="small text-muted d-block mb-1">Poin Pelanggaran</label>
                                        <h2 class="fw-bold mb-0" style="color: #f5576c;">
                                            <span id="pelanggaranPoin"></span>
                                        </h2>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-calendar-event me-2" style="color: #fa709a;"></i>Tanggal Kejadian
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal" class="form-control form-control-lg"
                                    id="inputTanggal" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" required>
                                <small class="text-muted">Tanggal terjadinya pelanggaran</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-camera me-2" style="color: #43e97b;"></i>Bukti Pelanggaran
                                    <span class="text-muted small">(Opsional)</span>
                                </label>
                                <input type="file" name="bukti" class="form-control form-control-lg"
                                    id="inputBukti" accept="image/*,.pdf">
                                <small class="text-muted">Format: JPG, PNG, atau PDF (Maksimal 2MB)</small>
                                <div id="buktiPreview" class="mt-3"></div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-chat-left-text me-2" style="color: #667eea;"></i>Keterangan Tambahan
                                    <span class="text-muted small">(Opsional)</span>
                                </label>
                                <textarea name="keterangan" class="form-control" rows="4"
                                    placeholder="Tambahkan keterangan detail mengenai pelanggaran..."></textarea>
                            </div>

                            <hr class="my-4">

                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('petugas.dashboard') }}" class="btn btn-lg btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-lg"
                                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border: none;">
                                    <i class="bi bi-save me-2"></i>Simpan Pelanggaran
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-select:focus,
        .form-control:focus {
            border-color: #f093fb;
            box-shadow: 0 0 0 0.25rem rgba(240, 147, 251, 0.25);
        }

        #buktiPreview img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#selectWarga').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const nama = selectedOption.data('nama');
                const nim = selectedOption.data('nim');
                const kamar = selectedOption.data('kamar');

                if (nama) {
                    $('#wargaInitial').text(nama.charAt(0).toUpperCase());
                    $('#wargaNama').text(nama);
                    $('#wargaNim').text(nim);
                    $('#wargaKamar').text(kamar);
                    $('#wargaInfo').removeClass('d-none');
                } else {
                    $('#wargaInfo').addClass('d-none');
                }
            });

            $('#selectPelanggaran').on('change', function() {
                const selectedOption = $(this).find('option:selected');
                const poin = selectedOption.data('poin');
                const deskripsi = selectedOption.data('deskripsi');

                if (poin) {
                    $('#pelanggaranPoin').text(poin + ' Poin');
                    $('#pelanggaranDeskripsi').text(deskripsi || 'Tidak ada deskripsi');
                    $('#pelanggaranInfo').removeClass('d-none');
                } else {
                    $('#pelanggaranInfo').addClass('d-none');
                }
            });

            $('#inputBukti').on('change', function(e) {
                const file = e.target.files[0];
                const preview = $('#buktiPreview');

                if (file) {
                    const fileType = file.type;
                    const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB

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
                                <div class="alert alert-success" style="border-radius: 12px;">
                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <img src="${e.target.result}" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                        <div class="col-md-9">
                                            <strong><i class="bi bi-check-circle me-2"></i>File berhasil dipilih</strong><br>
                                            <small class="text-muted">Nama: ${file.name} | Ukuran: ${fileSize} MB</small>
                                        </div>
                                    </div>
                                </div>
                            `);
                        };
                        reader.readAsDataURL(file);
                    } else if (fileType === 'application/pdf') {
                        preview.html(`
                            <div class="alert alert-success" style="border-radius: 12px;">
                                <i class="bi bi-file-pdf text-danger me-2" style="font-size: 2rem;"></i>
                                <strong>File PDF berhasil dipilih</strong><br>
                                <small class="text-muted">Nama: ${file.name} | Ukuran: ${fileSize} MB</small>
                            </div>
                        `);
                    }
                } else {
                    preview.html('');
                }
            });

            $('#formPelanggaran').on('submit', function(e) {
                const warga = $('#selectWarga').val();
                const pelanggaran = $('#selectPelanggaran').val();
                const tanggal = $('#inputTanggal').val();

                if (!warga || !pelanggaran || !tanggal) {
                    e.preventDefault();
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                    return false;
                }

                const confirmMsg =
                    `Apakah Anda yakin ingin mencatat pelanggaran ini?\n\nWarga: ${$('#selectWarga option:selected').data('nama')}\nPelanggaran: ${$('#selectPelanggaran option:selected').text()}\nTanggal: ${tanggal}`;

                if (!confirm(confirmMsg)) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@endpush
