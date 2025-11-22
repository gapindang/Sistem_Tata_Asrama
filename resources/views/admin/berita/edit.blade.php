@extends('layouts.app')
@section('title', 'Edit Berita')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #2496FF 0%, #4F90FF 50%, #65B5FF 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center gap-3 text-white">
                            <div
                                style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-pencil-square" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Edit Berita</h2>
                                <p class="mb-0 opacity-90">Perbarui informasi berita</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alert Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>
                <strong>Terjadi kesalahan!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="row">
            <div class="col-lg-10 col-xl-8 mx-auto">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-pencil-square me-2" style="color: #2496FF;"></i>
                            Form Edit Berita
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.berita.update', $berita->id_berita) }}" method="POST"
                            enctype="multipart/form-data" id="formBerita">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="judul" class="form-label fw-semibold">
                                    <i class="bi bi-type me-1"></i>Judul Berita <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror"
                                    id="judul" name="judul" value="{{ old('judul', $berita->judul) }}" required
                                    placeholder="Masukkan judul berita">
                                @error('judul')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="tanggal_mulai" class="form-label fw-semibold">
                                        <i class="bi bi-calendar-event me-1"></i>Tanggal Mulai
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                        id="tanggal_mulai" name="tanggal_mulai"
                                        value="{{ old('tanggal_mulai', $berita->tanggal_mulai ? $berita->tanggal_mulai->format('Y-m-d') : '') }}">
                                    @error('tanggal_mulai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Opsional - Untuk berita dengan periode waktu</small>
                                </div>

                                <div class="col-md-6">
                                    <label for="tanggal_selesai" class="form-label fw-semibold">
                                        <i class="bi bi-calendar-check me-1"></i>Tanggal Selesai
                                    </label>
                                    <input type="date" class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                        id="tanggal_selesai" name="tanggal_selesai"
                                        value="{{ old('tanggal_selesai', $berita->tanggal_selesai ? $berita->tanggal_selesai->format('Y-m-d') : '') }}">
                                    @error('tanggal_selesai')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Harus lebih besar dari tanggal mulai</small>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="poster" class="form-label fw-semibold">
                                    <i class="bi bi-image me-1"></i>Poster/Gambar
                                </label>

                                @if ($berita->poster)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $berita->poster) }}" alt="Current poster"
                                            class="img-thumbnail" style="max-width: 300px; border-radius: 10px;">
                                        <p class="text-muted mt-1 mb-0">
                                            <small>Poster saat ini. Upload gambar baru untuk menggantinya.</small>
                                        </p>
                                    </div>
                                @endif

                                <input type="file" class="form-control @error('poster') is-invalid @enderror"
                                    id="poster" name="poster" accept="image/jpeg,image/jpg,image/png"
                                    onchange="previewImage(event)">
                                @error('poster')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB</small>

                                {{-- Preview --}}
                                <div id="imagePreview" class="mt-3" style="display: none;">
                                    <p class="text-muted mb-2"><small>Preview gambar baru:</small></p>
                                    <img id="preview" src="" alt="Preview" class="img-thumbnail"
                                        style="max-width: 300px; border-radius: 10px;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="isi_berita" class="form-label fw-semibold">
                                    <i class="bi bi-text-paragraph me-1"></i>Isi Berita <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('isi_berita') is-invalid @enderror" id="isi_berita"
                                    name="isi_berita" rows="10" required
                                    placeholder="Tulis isi berita di sini...">{{ old('isi_berita', $berita->isi_berita) }}</textarea>
                                @error('isi_berita')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-warning" style="border-radius: 10px;">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Perhatian:</strong> Perubahan berita tidak akan memperbarui notifikasi yang sudah
                                dikirim sebelumnya.
                            </div>

                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary"
                                    style="border-radius: 10px; padding: 12px 30px;">
                                    <i class="bi bi-arrow-left me-2"></i>Batal
                                </a>
                                <button type="submit" class="btn btn-primary"
                                    style="background: linear-gradient(135deg, #2496FF 0%, #4F90FF 100%); border: none; border-radius: 10px; padding: 12px 30px;">
                                    <i class="bi bi-save me-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus {
            border-color: #4F90FF;
            box-shadow: 0 0 0 0.2rem rgba(79, 144, 255, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(36, 150, 255, 0.4);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        textarea {
            resize: vertical;
        }
    </style>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('imagePreview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        }

        // Form validation
        document.getElementById('formBerita')?.addEventListener('submit', function(e) {
            const judul = document.getElementById('judul').value.trim();
            const isiBerita = document.getElementById('isi_berita').value.trim();
            const tanggalMulai = document.getElementById('tanggal_mulai').value;
            const tanggalSelesai = document.getElementById('tanggal_selesai').value;

            if (judul.length === 0) {
                e.preventDefault();
                alert('Judul berita tidak boleh kosong!');
                return false;
            }

            if (isiBerita.length === 0) {
                e.preventDefault();
                alert('Isi berita tidak boleh kosong!');
                return false;
            }

            if (tanggalMulai && tanggalSelesai) {
                if (new Date(tanggalSelesai) < new Date(tanggalMulai)) {
                    e.preventDefault();
                    alert('Tanggal selesai harus lebih besar atau sama dengan tanggal mulai!');
                    return false;
                }
            }
        });
    </script>
@endsection
