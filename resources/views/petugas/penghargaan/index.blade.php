@extends('layouts.app')
@section('title', 'Data Penghargaan')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center gap-3 text-white">
                            <div
                                style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-trophy-fill" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Jenis Penghargaan</h2>
                                <p class="mb-0 opacity-75">Referensi jenis penghargaan dan poin reward</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                                <i class="bi bi-list-check"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 small">Total Jenis</p>
                                <h3 class="fw-bold mb-0">{{ $penghargaans->count() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 small">Poin Tertinggi</p>
                                <h3 class="fw-bold mb-0">{{ $penghargaans->max('poin_reward') ?? 0 }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm stat-card" style="border-radius: 15px;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-circle" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                                <i class="bi bi-calculator"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-1 small">Rata-rata Poin</p>
                                <h3 class="fw-bold mb-0">
                                    {{ $penghargaans->count() > 0 ? number_format($penghargaans->avg('poin_reward'), 1) : 0 }}
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Table Section --}}
        <div class="card border-0 shadow-sm" style="border-radius: 15px;">
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-table me-2" style="color: #43e97b;"></i>Daftar Penghargaan
                    </h5>
                    <div class="input-group" style="max-width: 300px;">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" id="searchPenghargaan" placeholder="Cari penghargaan...">
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                            <tr>
                                <th class="text-center" style="width: 5%">No</th>
                                <th style="width: 30%">Nama Penghargaan</th>
                                <th style="width: 45%">Deskripsi</th>
                                <th class="text-center" style="width: 15%">Poin Reward</th>
                                <th class="text-center" style="width: 5%">
                                    <i class="bi bi-info-circle" title="Informasi"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tablePenghargaan">
                            @forelse ($penghargaans as $index => $item)
                                <tr data-nama="{{ strtolower($item->nama_penghargaan) }}">
                                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-award-fill text-success"></i>
                                            <strong>{{ $item->nama_penghargaan }}</strong>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ Str::limit($item->deskripsi, 80) }}</small>
                                    </td>
                                    <td class="text-center">
                                        @if ($item->poin_reward >= 15)
                                            <span class="badge"
                                                style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); padding: 8px 15px;">
                                                +{{ $item->poin_reward }} Poin
                                            </span>
                                        @elseif($item->poin_reward >= 10)
                                            <span class="badge"
                                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 8px 15px;">
                                                +{{ $item->poin_reward }} Poin
                                            </span>
                                        @else
                                            <span class="badge"
                                                style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); padding: 8px 15px;">
                                                +{{ $item->poin_reward }} Poin
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-success btn-detail" data-bs-toggle="tooltip"
                                            title="Lihat Detail" data-id="{{ $item->id_penghargaan }}"
                                            data-nama="{{ $item->nama_penghargaan }}"
                                            data-deskripsi="{{ $item->deskripsi }}" data-poin="{{ $item->poin_reward }}">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                        <p class="text-muted mt-3 mb-0">Tidak ada data penghargaan</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold" id="detailModalLabel">
                        <i class="bi bi-info-circle me-2"></i>Detail Penghargaan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-4">
                        <div class="col-md-12">
                            <div class="card border-0 bg-light" style="border-radius: 15px;">
                                <div class="card-body p-4">
                                    <div class="mb-4">
                                        <label class="text-muted small mb-2">Nama Penghargaan</label>
                                        <h4 class="fw-bold mb-0" id="detailNama"></h4>
                                    </div>
                                    <div class="mb-4">
                                        <label class="text-muted small mb-2">Deskripsi</label>
                                        <p class="mb-0" id="detailDeskripsi"></p>
                                    </div>
                                    <div>
                                        <label class="text-muted small mb-2">Poin Reward</label>
                                        <h2 class="fw-bold mb-0" id="detailPoin"></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <a href="{{ route('petugas.penghargaan.create') }}" class="btn"
                        style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border: none;">
                        <i class="bi bi-plus-circle me-1"></i>Beri Penghargaan
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stat-card {
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .icon-circle {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(67, 233, 123, 0.05);
        }

        #tablePenghargaan tr.hidden {
            display: none;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            $('#searchPenghargaan').on('keyup', function() {
                const searchValue = $(this).val().toLowerCase();

                $('#tablePenghargaan tr').each(function() {
                    const nama = $(this).data('nama');
                    if (nama) {
                        if (nama.includes(searchValue)) {
                            $(this).removeClass('hidden');
                        } else {
                            $(this).addClass('hidden');
                        }
                    }
                });
            });

            $('.btn-detail').on('click', function() {
                const nama = $(this).data('nama');
                const deskripsi = $(this).data('deskripsi');
                const poin = $(this).data('poin');

                $('#detailNama').text(nama);
                $('#detailDeskripsi').text(deskripsi);

                let poinBadge = '';
                if (poin >= 15) {
                    poinBadge =
                        `<span class="badge fs-4" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">+${poin} Poin</span>`;
                } else if (poin >= 10) {
                    poinBadge =
                        `<span class="badge fs-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">+${poin} Poin</span>`;
                } else {
                    poinBadge =
                        `<span class="badge fs-4" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">+${poin} Poin</span>`;
                }
                $('#detailPoin').html(poinBadge);

                const modal = new bootstrap.Modal($('#detailModal')[0]);
                modal.show();
            });
        });
    </script>
@endpush
