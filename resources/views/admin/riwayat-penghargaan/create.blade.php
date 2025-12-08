@extends('layouts.app')

@section('title', 'Beri Penghargaan - Admin')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1"><i class="bi bi-award-fill me-2 text-warning"></i>Beri Penghargaan</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                        class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.riwayat-penghargaan.index') }}"
                                        class="text-decoration-none">Riwayat Penghargaan</a></li>
                                <li class="breadcrumb-item active">Beri Penghargaan</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('admin.riwayat-penghargaan.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="row">
            <div class="col-lg-8 col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.riwayat-penghargaan.store') }}" method="POST" id="penghargaanForm">
                            @csrf

                            <!-- Pilih Warga -->
                            <div class="mb-4">
                                <label for="id_warga" class="form-label fw-semibold">
                                    <i class="bi bi-person-fill me-2"></i>Warga Asrama <span class="text-danger">*</span>
                                </label>
                                <select name="id_warga" id="id_warga"
                                    class="form-select @error('id_warga') is-invalid @enderror" required>
                                    <option value="">-- Pilih Warga --</option>
                                    @foreach ($warga as $w)
                                        <option value="{{ $w->id_warga }}"
                                            {{ old('id_warga') == $w->id_warga ? 'selected' : '' }}>
                                            {{ $w->nama }} - {{ $w->nomor_kamar }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_warga')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Pilih Penghargaan -->
                            <div class="mb-4">
                                <label for="id_penghargaan" class="form-label fw-semibold">
                                    <i class="bi bi-trophy-fill me-2"></i>Jenis Penghargaan <span
                                        class="text-danger">*</span>
                                </label>
                                <select name="id_penghargaan" id="id_penghargaan"
                                    class="form-select @error('id_penghargaan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Penghargaan --</option>
                                    @foreach ($penghargaan as $p)
                                        <option value="{{ $p->id_penghargaan }}" data-poin="{{ $p->poin_reward }}"
                                            data-deskripsi="{{ $p->deskripsi }}"
                                            {{ old('id_penghargaan') == $p->id_penghargaan ? 'selected' : '' }}>
                                            {{ $p->nama_penghargaan }} (+{{ $p->poin_reward }} poin)
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_penghargaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Detail Penghargaan -->
                                <div id="penghargaanDetail" class="mt-3 p-3 bg-light rounded d-none">
                                    <h6 class="fw-bold mb-2">Detail Penghargaan:</h6>
                                    <p class="mb-1"><strong>Poin Reward:</strong> <span id="poinReward"
                                            class="badge bg-success">0</span></p>
                                    <p class="mb-0"><strong>Deskripsi:</strong> <span id="deskripsiPenghargaan"
                                            class="text-muted">-</span></p>
                                </div>
                            </div>

                            <!-- Tanggal -->
                            <div class="mb-4">
                                <label for="tanggal" class="form-label fw-semibold">
                                    <i class="bi bi-calendar-event me-2"></i>Tanggal <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="tanggal" id="tanggal"
                                    class="form-control @error('tanggal') is-invalid @enderror"
                                    value="{{ old('tanggal', date('Y-m-d')) }}" required>
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Berikan Penghargaan
                                </button>
                                <a href="{{ route('admin.riwayat-penghargaan.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-x-circle me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="col-lg-4 col-12 mt-4 mt-lg-0">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3"><i class="bi bi-info-circle me-2"></i>Informasi</h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small>Pilih warga yang berhak menerima penghargaan</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small>Tentukan jenis penghargaan yang sesuai</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small>Poin reward akan otomatis ditambahkan</small>
                            </li>
                            <li class="mb-0">
                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                <small>Notifikasi akan dikirim ke warga</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
            rel="stylesheet" />
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                // Initialize Select2
                $('#id_warga').select2({
                    theme: 'bootstrap-5',
                    placeholder: '-- Pilih Warga --',
                    allowClear: true
                });

                $('#id_penghargaan').select2({
                    theme: 'bootstrap-5',
                    placeholder: '-- Pilih Penghargaan --',
                    allowClear: true
                });

                // Show penghargaan detail when selected
                $('#id_penghargaan').on('change', function() {
                    const selectedOption = $(this).find('option:selected');
                    const poin = selectedOption.data('poin');
                    const deskripsi = selectedOption.data('deskripsi');

                    if (poin) {
                        $('#poinReward').text('+' + poin + ' poin');
                        $('#deskripsiPenghargaan').text(deskripsi || '-');
                        $('#penghargaanDetail').removeClass('d-none');
                    } else {
                        $('#penghargaanDetail').addClass('d-none');
                    }
                });
            });
        </script>
    @endpush
@endsection
