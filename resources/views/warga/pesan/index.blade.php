@extends('layouts.app')

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
                                <i class="bi bi-chat-dots" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Pesan</h2>
                                <p class="mb-0 opacity-90">Kirim pesan atau pertanyaan kepada admin/petugas asrama</p>
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

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            {{-- Form Kirim Pesan --}}
            <div class="col-md-5">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-send me-2" style="color: #2496FF;"></i>
                            Kirim Pesan Baru
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('warga.pesan.store') }}" method="POST" id="formPesan">
                            @csrf
                            <div class="mb-3">
                                <label for="to" class="form-label fw-semibold">
                                    <i class="bi bi-person-badge me-1"></i>Kepada
                                </label>
                                <select class="form-select" id="to" name="to">
                                    <option value="">Admin/Petugas Asrama</option>
                                </select>
                                <small class="text-muted">Pesan akan dikirim ke admin dan petugas</small>
                            </div>

                            <div class="mb-3">
                                <label for="pesan" class="form-label fw-semibold">
                                    <i class="bi bi-chat-square-text me-1"></i>Pesan <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="pesan" name="pesan" rows="6" placeholder="Tulis pesan Anda di sini..."
                                    required maxlength="2000"></textarea>
                                <small class="text-muted">Maksimal 2000 karakter</small>
                            </div>

                            <button type="submit" class="btn btn-primary w-100"
                                style="background: linear-gradient(135deg, #2496FF 0%, #4F90FF 100%); border: none;">
                                <i class="bi bi-send me-2"></i>Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Riwayat Pesan --}}
            <div class="col-md-7">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-clock-history me-2" style="color: #2496FF;"></i>
                            Riwayat Pesan
                        </h5>
                    </div>
                    <div class="card-body p-4" style="max-height: 600px; overflow-y: auto;">
                        @forelse ($messages as $message)
                            <div class="message-item p-3 mb-3 border rounded"
                                style="background: #f8f9fa; border-color: #dee2e6 !important;">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <div
                                            style="width: 40px; height: 40px; background: linear-gradient(135deg, #2496FF 0%, #4F90FF 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-send text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">Pesan Anda</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                {{ \Carbon\Carbon::parse($message->tanggal)->format('d M Y H:i') }}
                                            </small>
                                        </div>
                                    </div>
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle me-1"></i>Terkirim
                                    </span>
                                </div>
                                <div class="ps-5">
                                    <p class="mb-0 text-dark" style="white-space: pre-wrap;">{{ $message->pesan }}</p>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 4rem; color: #ddd;"></i>
                                <p class="text-muted mt-3 mb-0">Belum ada riwayat pesan</p>
                                <small class="text-muted">Pesan yang Anda kirim akan muncul di sini</small>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-control:focus,
        .form-select:focus {
            border-color: #4F90FF;
            box-shadow: 0 0 0 0.2rem rgba(79, 144, 255, 0.25);
        }

        .message-item {
            transition: all 0.3s ease;
        }

        .message-item:hover {
            transform: translateX(5px);
            box-shadow: 0 2px 8px rgba(36, 150, 255, 0.15);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(36, 150, 255, 0.4);
            transition: all 0.3s ease;
        }

        /* Custom scrollbar */
        .card-body::-webkit-scrollbar {
            width: 8px;
        }

        .card-body::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .card-body::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #2496FF 0%, #4F90FF 100%);
            border-radius: 10px;
        }

        .card-body::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #1a7de8 0%, #3d7ee8 100%);
        }
    </style>
@endsection

@push('scripts')
    <script>
        // Character counter
        const pesanTextarea = document.getElementById('pesan');
        if (pesanTextarea) {
            pesanTextarea.addEventListener('input', function() {
                const remaining = 2000 - this.value.length;
                const smallText = this.nextElementSibling;
                smallText.textContent = `Tersisa ${remaining} karakter`;

                if (remaining < 100) {
                    smallText.classList.add('text-warning');
                } else {
                    smallText.classList.remove('text-warning');
                }

                if (remaining < 0) {
                    smallText.classList.add('text-danger');
                    smallText.classList.remove('text-warning');
                }
            });
        }

        // Smooth scroll to bottom on new message
        const messageContainer = document.querySelector('.card-body[style*="overflow-y"]');
        if (messageContainer && messageContainer.children.length > 0) {
            messageContainer.scrollTop = 0; // Start from top
        }

        // Form validation
        document.getElementById('formPesan')?.addEventListener('submit', function(e) {
            const pesan = document.getElementById('pesan').value.trim();
            if (pesan.length === 0) {
                e.preventDefault();
                alert('Pesan tidak boleh kosong!');
                return false;
            }
            if (pesan.length > 2000) {
                e.preventDefault();
                alert('Pesan terlalu panjang! Maksimal 2000 karakter.');
                return false;
            }
        });
    </script>
@endpush
