<div class="sidebar">
    <h5 class="text-center fw-bold mb-4">Admin Panel</h5>
    <a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </a>
    <a href="{{ route('admin.search') }}" class="{{ Request::routeIs('admin.search*') ? 'active' : '' }}">
        <i class="bi bi-search me-2"></i>Pencarian
    </a>
    <a href="{{ route('admin.notifikasi.index') }}" class="{{ Request::routeIs('admin.notifikasi.*') ? 'active' : '' }}">
        <i class="bi bi-bell me-2"></i>Notifikasi
    </a>
    <a href="{{ route('admin.warga.index') }}" class="{{ Request::routeIs('admin.warga.*') ? 'active' : '' }}">
        <i class="bi bi-people me-2"></i>Data Warga
    </a>
    <a href="{{ route('admin.petugas.index') }}" class="{{ Request::routeIs('admin.petugas.*') ? 'active' : '' }}">
        <i class="bi bi-person-badge me-2"></i>Kelola Petugas
    </a>
    <a href="{{ route('admin.pelanggaran.index') }}"
        class="{{ Request::routeIs('admin.pelanggaran.*') ? 'active' : '' }}">
        <i class="bi bi-exclamation-triangle me-2"></i>Pelanggaran
    </a>
    <a href="{{ route('admin.penghargaan.index') }}"
        class="{{ Request::routeIs('admin.penghargaan.*') ? 'active' : '' }}">
        <i class="bi bi-trophy me-2"></i>Penghargaan
    </a>
    <a href="{{ route('admin.denda.index') }}" class="{{ Request::routeIs('admin.denda.*') ? 'active' : '' }}">
        <i class="bi bi-cash-coin me-2"></i>Denda
    </a>
    <a href="{{ route('admin.kalender.index') }}" class="{{ Request::routeIs('admin.kalender.*') ? 'active' : '' }}">
        <i class="bi bi-calendar-event me-2"></i>Kalender
    </a>
    <a href="{{ route('admin.laporan.index') }}" class="{{ Request::routeIs('admin.laporan.*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-text me-2"></i>Laporan
    </a>
    <a href="{{ route('admin.pengaturan.index') }}"
        class="{{ Request::routeIs('admin.pengaturan.*') ? 'active' : '' }}">
        <i class="bi bi-gear me-2"></i>Pengaturan
    </a>
</div>
