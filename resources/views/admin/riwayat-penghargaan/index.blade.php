@extends('layouts.app')

@section('title', 'Riwayat Penghargaan - Admin')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <h2 class="fw-bold mb-1"><i class="bi bi-trophy-fill me-2 text-warning"></i>Riwayat Penghargaan</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                        class="text-decoration-none">Dashboard</a></li>
                                <li class="breadcrumb-item active">Riwayat Penghargaan</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('admin.riwayat-penghargaan.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-2"></i>Beri Penghargaan
                    </a>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="penghargaanTable">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Nama Warga</th>
                                <th>No. Kamar</th>
                                <th>Jenis Penghargaan</th>
                                <th>Poin Reward</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayat as $index => $r)
                                <tr>
                                    <td>{{ $riwayat->firstItem() + $index }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->tanggal)->format('d M Y') }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle me-2">
                                                {{ substr($r->warga->nama ?? 'N/A', 0, 1) }}
                                            </div>
                                            <span class="fw-semibold">{{ $r->warga->nama ?? 'N/A' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $r->warga->nomor_kamar ?? 'N/A' }}</span>
                                    </td>
                                    <td>{{ $r->penghargaan->nama_penghargaan ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            +{{ $r->penghargaan->poin_reward ?? 0 }} poin
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.riwayat-penghargaan.edit', $r->id_riwayat_penghargaan) }}"
                                                class="btn btn-outline-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Hapus"
                                                onclick="confirmDelete('{{ $r->id_riwayat_penghargaan }}')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="bi bi-inbox display-4 d-block mb-3"></i>
                                            <p class="mb-0">Belum ada data riwayat penghargaan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($riwayat->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $riwayat->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    @push('styles')
        <style>
            .avatar-circle {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                font-size: 16px;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            function confirmDelete(id) {
                if (confirm('Apakah Anda yakin ingin menghapus riwayat penghargaan ini?')) {
                    const form = document.getElementById('deleteForm');
                    form.action = `/admin/riwayat-penghargaan/${id}`;
                    form.submit();
                }
            }
        </script>
    @endpush
@endsection
