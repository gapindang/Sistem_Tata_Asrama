@extends('layouts.app')
@section('title', 'Daftar Berita')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #2496FF 0%, #4F90FF 50%, #65B5FF 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3 text-white">
                                <div
                                    style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-newspaper" style="font-size: 2rem;"></i>
                                </div>
                                <div>
                                    <h2 class="fw-bold mb-1">Daftar Berita</h2>
                                    <p class="mb-0 opacity-90">Kelola semua berita asrama</p>
                                </div>
                            </div>
                            <a href="{{ route('admin.berita.create') }}" class="btn btn-light"
                                style="border-radius: 10px; font-weight: 600;">
                                <i class="bi bi-plus-lg me-2"></i>Buat Berita Baru
                            </a>
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

        {{-- Berita List --}}
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-body p-4">
                @forelse ($berita as $item)
                    <div class="berita-item p-4 mb-3 border rounded"
                        style="border-radius: 12px; border-color: #dee2e6 !important;">
                        <div class="row">
                            @if ($item->poster)
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <img src="{{ asset('storage/' . $item->poster) }}" alt="{{ $item->judul }}"
                                        class="img-fluid rounded"
                                        style="border-radius: 10px; object-fit: cover; width: 100%; height: 200px;">
                                </div>
                                <div class="col-md-9">
                                @else
                                    <div class="col-12">
                            @endif
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-2">{{ $item->judul }}</h5>
                                    <div class="d-flex flex-wrap gap-3 mb-2">
                                        <small class="text-muted">
                                            <i class="bi bi-person-circle me-1"></i>
                                            {{ $item->pembuat->nama }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
                                        </small>
                                        @if ($item->tanggal_mulai && $item->tanggal_selesai)
                                            <small class="text-primary">
                                                <i class="bi bi-calendar-range me-1"></i>
                                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }} -
                                                {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                                            </small>
                                        @endif
                                    </div>
                                    <p class="mb-3 text-muted" style="line-height: 1.6;">
                                        {{ Str::limit($item->isi_berita, 200) }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.berita.show', $item->id_berita) }}"
                                    class="btn btn-sm btn-info text-white" style="border-radius: 8px;">
                                    <i class="bi bi-eye me-1"></i>Lihat
                                </a>
                                <a href="{{ route('admin.berita.edit', $item->id_berita) }}" class="btn btn-sm btn-primary"
                                    style="border-radius: 8px;">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                                <form action="{{ route('admin.berita.destroy', $item->id_berita) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Yakin ingin menghapus berita ini?')"
                                        style="border-radius: 8px;">
                                        <i class="bi bi-trash me-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>
        @empty
            <div class="text-center py-5">
                <i class="bi bi-newspaper" style="font-size: 4rem; color: #ddd;"></i>
                <p class="text-muted mt-3 mb-0">Belum ada berita</p>
                <small class="text-muted">Klik tombol "Buat Berita Baru" untuk membuat berita pertama</small>
            </div>
            @endforelse
        </div>
    </div>
    </div>

    <style>
        .berita-item {
            transition: all 0.3s ease;
            background: #ffffff;
        }

        .berita-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 15px rgba(36, 150, 255, 0.15);
        }

        .btn-sm {
            transition: all 0.2s ease;
        }

        .btn-sm:hover {
            transform: translateY(-2px);
        }
    </style>
@endsection
