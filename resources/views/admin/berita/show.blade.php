@extends('layouts.app')
@section('title', 'Detail Berita')

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
                                <i class="bi bi-newspaper" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Detail Berita</h2>
                                <p class="mb-0 opacity-90">Informasi lengkap berita</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Berita Content --}}
        <div class="row">
            <div class="col-lg-10 col-xl-8 mx-auto">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        {{-- Back Button --}}
                        <div class="mb-4">
                            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary btn-sm"
                                style="border-radius: 8px;">
                                <i class="bi bi-arrow-left me-2"></i>Kembali
                            </a>
                        </div>

                        {{-- Title --}}
                        <h3 class="fw-bold mb-3" style="color: #2496FF;">{{ $berita->judul }}</h3>

                        {{-- Meta Information --}}
                        <div class="d-flex flex-wrap gap-3 mb-4 pb-3 border-bottom">
                            <small class="text-muted">
                                <i class="bi bi-person-circle me-1"></i>
                                <strong>Dibuat oleh:</strong> {{ $berita->pembuat->nama }}
                            </small>
                            <small class="text-muted">
                                <i class="bi bi-calendar3 me-1"></i>
                                <strong>Tanggal:</strong>
                                {{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y H:i') }}
                            </small>
                            @if ($berita->tanggal_mulai && $berita->tanggal_selesai)
                                <small class="text-primary">
                                    <i class="bi bi-calendar-range me-1"></i>
                                    <strong>Periode:</strong>
                                    {{ \Carbon\Carbon::parse($berita->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($berita->tanggal_selesai)->format('d M Y') }}
                                </small>
                            @endif
                        </div>

                        {{-- Poster Image --}}
                        @if ($berita->poster)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $berita->poster) }}" alt="{{ $berita->judul }}"
                                    class="img-fluid rounded shadow-sm"
                                    style="width: 100%; max-height: 500px; object-fit: cover; border-radius: 12px;">
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="berita-content">
                            <h5 class="fw-bold mb-3">Isi Berita</h5>
                            <div style="line-height: 1.8; white-space: pre-wrap; color: #333;">{{ $berita->isi_berita }}
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex gap-2 mt-4 pt-4 border-top">
                            <a href="{{ route('admin.berita.edit', $berita->id_berita) }}" class="btn btn-primary"
                                style="border-radius: 10px;">
                                <i class="bi bi-pencil me-2"></i>Edit Berita
                            </a>
                            <form action="{{ route('admin.berita.destroy', $berita->id_berita) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Yakin ingin menghapus berita ini? Notifikasi yang sudah dikirim tidak akan terhapus.')"
                                    style="border-radius: 10px;">
                                    <i class="bi bi-trash me-2"></i>Hapus Berita
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Info Card --}}
                <div class="card border-0 shadow-sm mt-3" style="border-radius: 15px; background: #f8f9fa;">
                    <div class="card-body p-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-2"></i>
                            Berita ini telah dikirim sebagai notifikasi ke semua petugas dan warga asrama.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .berita-content {
            font-size: 1rem;
        }

        .btn:hover {
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
    </style>
@endsection
