@extends('layouts.app')
@section('title', 'Teman Asrama')

@section('content')
    <div class="container-fluid py-4">
        {{-- Header Section --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px;">
                    <div class="card-body py-4">
                        <div class="d-flex align-items-center gap-3 text-white">
                            <div
                                style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                            </div>
                            <div>
                                <h2 class="fw-bold mb-1">Teman Asrama</h2>
                                <p class="mb-0 opacity-75">Daftar penghuni asrama dan kontak teman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search & Filter --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control" id="searchWarga" placeholder="Cari nama atau NIM...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="filterKamar">
                            <option value="">Semua Kamar</option>
                            @for ($i = 1; $i <= 50; $i++)
                                <option value="{{ $i }}">Kamar {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select class="form-select" id="filterAngkatan">
                            <option value="">Semua Angkatan</option>
                            @for ($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn w-100"
                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;"
                            id="btnFilter">
                            <i class="bi bi-funnel me-2"></i>Terapkan Filter
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Warga Grid --}}
        <div class="row g-4" id="wargaGrid">
            @forelse ($wargas as $index => $warga)
                <div class="col-lg-4 col-md-6 warga-card" data-nama="{{ strtolower($warga->nama) }}"
                    data-nim="{{ $warga->nim ?? '' }}" data-kamar="{{ $warga->kamar ?? '' }}"
                    data-angkatan="{{ $warga->angkatan ?? '' }}">
                    <div class="card border-0 shadow-sm h-100 hover-card"
                        style="border-radius: 15px; transition: all 0.3s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start gap-3">
                                <div
                                    style="width: 70px; height: 70px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 2rem; flex-shrink: 0;">
                                    {{ strtoupper(substr($warga->nama, 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="fw-bold mb-2">{{ $warga->nama }}</h5>
                                    <div class="mb-2">
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <i class="bi bi-card-text me-1"></i>{{ $warga->nim ?? '-' }}
                                        </span>
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <span class="badge bg-success-subtle text-success border border-success">
                                            <i class="bi bi-door-closed me-1"></i>Kamar {{ $warga->kamar ?? '-' }}
                                        </span>
                                        <span class="badge bg-info-subtle text-info border border-info">
                                            <i class="bi bi-calendar3 me-1"></i>{{ $warga->angkatan ?? '-' }}
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-3">
                                        <i class="bi bi-envelope me-1"></i>{{ $warga->email ?? 'Email tidak tersedia' }}
                                    </p>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-outline-primary flex-grow-1"
                                            onclick="showContact('{{ $warga->nama }}', '{{ $warga->no_telepon ?? '-' }}', '{{ $warga->email ?? '-' }}')">
                                            <i class="bi bi-telephone me-1"></i>Kontak
                                        </button>
                                        <button class="btn btn-sm btn-outline-success"
                                            onclick="showProfile('{{ $warga->nama }}')">
                                            <i class="bi bi-person-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">Belum ada data warga</h5>
                        <p class="text-muted">Data warga asrama akan ditampilkan di sini</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div id="noResults" class="text-center py-5 d-none">
            <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
            <h5 class="text-muted mt-3">Tidak ada hasil yang ditemukan</h5>
            <p class="text-muted">Coba ubah kata kunci atau filter pencarian</p>
        </div>
    </div>

    {{-- Modal Contact --}}
    <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px; border: none;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold" id="contactModalLabel">
                        <i class="bi bi-telephone-fill me-2"></i>Informasi Kontak
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <div
                            style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 2.5rem; margin: 0 auto;">
                            A
                        </div>
                        <h5 class="fw-bold mt-3" id="contactNama"></h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex align-items-center gap-3 border-0 bg-light mb-2"
                            style="border-radius: 10px;">
                            <i class="bi bi-telephone-fill text-primary fs-4"></i>
                            <div>
                                <small class="text-muted d-block">No. Telepon</small>
                                <strong id="contactPhone">-</strong>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center gap-3 border-0 bg-light mb-2"
                            style="border-radius: 10px;">
                            <i class="bi bi-envelope-fill text-success fs-4"></i>
                            <div>
                                <small class="text-muted d-block">Email</small>
                                <strong id="contactEmail">-</strong>
                            </div>
                        </div>
                        <div class="list-group-item d-flex align-items-center gap-3 border-0 bg-light"
                            style="border-radius: 10px;">
                            <i class="bi bi-whatsapp text-success fs-4"></i>
                            <div>
                                <small class="text-muted d-block">WhatsApp</small>
                                <strong id="contactWhatsapp">-</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light" style="border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .warga-card.hidden {
            display: none;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Search functionality
            $('#searchWarga').on('keyup', function() {
                filterWarga();
            });

            $('#btnFilter').on('click', function() {
                filterWarga();
            });

            function filterWarga() {
                const searchValue = $('#searchWarga').val().toLowerCase();
                const kamarFilter = $('#filterKamar').val();
                const angkatanFilter = $('#filterAngkatan').val();

                let visibleCount = 0;

                $('.warga-card').each(function() {
                    const nama = $(this).data('nama');
                    const nim = $(this).data('nim');
                    const kamar = $(this).data('kamar').toString();
                    const angkatan = $(this).data('angkatan').toString();

                    let showCard = true;

                    // Search filter
                    if (searchValue && !nama.includes(searchValue) && !nim.includes(searchValue)) {
                        showCard = false;
                    }

                    // Kamar filter
                    if (kamarFilter && kamar !== kamarFilter) {
                        showCard = false;
                    }

                    // Angkatan filter
                    if (angkatanFilter && angkatan !== angkatanFilter) {
                        showCard = false;
                    }

                    if (showCard) {
                        $(this).removeClass('hidden');
                        visibleCount++;
                    } else {
                        $(this).addClass('hidden');
                    }
                });

                // Show no results message
                if (visibleCount === 0) {
                    $('#noResults').removeClass('d-none');
                } else {
                    $('#noResults').addClass('d-none');
                }
            }
        });

        function showContact(nama, phone, email) {
            $('#contactNama').text(nama);
            $('#contactPhone').text(phone || '-');
            $('#contactEmail').text(email || '-');
            $('#contactWhatsapp').text(phone || '-');
            const modal = new bootstrap.Modal($('#contactModal')[0]);
            modal.show();
        }

        function showProfile(nama) {
            alert('Fitur profil lengkap untuk ' + nama + ' segera hadir!');
        }
    </script>
@endpush
