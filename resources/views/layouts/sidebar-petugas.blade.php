<div class="sidebar">
    <div class="sidebar-header text-center mb-3">
        <img src="{{ asset('images/SITAMA.png') }}" alt="SITAMA Logo" class="sidebar-logo mb-2">
        <h5 class="fw-bold mb-0">Petugas</h5>
    </div>
    <a href="{{ route('petugas.dashboard') }}" class="{{ Request::routeIs('petugas.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </a>
    <a href="{{ route('petugas.notifikasi.index') }}"
        class="{{ Request::routeIs('petugas.notifikasi.*') ? 'active' : '' }}">
        <i class="bi bi-bell me-2"></i>Notifikasi
    </a>
    <a href="{{ route('petugas.warga.index') }}" class="{{ Request::routeIs('petugas.warga.*') ? 'active' : '' }}">
        <i class="bi bi-people me-2"></i>Data Warga
    </a>
    <a href="{{ route('petugas.pelanggaran.index') }}"
        class="{{ Request::routeIs('petugas.pelanggaran.*') ? 'active' : '' }}">
        <i class="bi bi-exclamation-triangle me-2"></i>Pelanggaran
    </a>
    <a href="{{ route('petugas.penghargaan.index') }}"
        class="{{ Request::routeIs('petugas.penghargaan.*') ? 'active' : '' }}">
        <i class="bi bi-trophy me-2"></i>Penghargaan
    </a>
    <a href="{{ route('petugas.denda.index') }}" class="{{ Request::routeIs('petugas.denda.*') ? 'active' : '' }}">
        <i class="bi bi-cash-coin me-2"></i>Denda
    </a>
    <a href="{{ route('petugas.laporan.index') }}"
        class="{{ Request::routeIs('petugas.laporan.*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-text me-2"></i>Laporan
    </a>
    <a href="{{ route('petugas.profil.index') }}" class="{{ Request::routeIs('petugas.profil.*') ? 'active' : '' }}">
        <i class="bi bi-person-circle me-2"></i>Profil
    </a>
</div>
