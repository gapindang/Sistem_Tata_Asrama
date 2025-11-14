<div class="sidebar">
    <h5 class="text-center fw-bold mb-4">Admin Panel</h5>
    <a href="{{ route('admin.dashboard') }}"
        class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('admin.notifikasi.index') }}"
        class="{{ Request::routeIs('admin.notifikasi.*') ? 'active' : '' }}">Notifikasi</a>
    <a href="{{ route('admin.warga.index') }}" class="{{ Request::routeIs('admin.warga.*') ? 'active' : '' }}">Data
        Warga</a>
    <a href="{{ route('admin.pelanggaran.index') }}"
        class="{{ Request::routeIs('admin.pelanggaran.*') ? 'active' : '' }}">Pelanggaran</a>
    <a href="{{ route('admin.penghargaan.index') }}"
        class="{{ Request::routeIs('admin.penghargaan.*') ? 'active' : '' }}">Penghargaan</a>
    <a href="{{ route('admin.denda.index') }}"
        class="{{ Request::routeIs('admin.denda.*') ? 'active' : '' }}">Denda</a>
    <a href="{{ route('admin.kalender.index') }}"
        class="{{ Request::routeIs('admin.kalender.*') ? 'active' : '' }}">Kalender</a>
    <a href="{{ route('admin.laporan.index') }}"
        class="{{ Request::routeIs('admin.laporan.*') ? 'active' : '' }}">Laporan</a>
    <a href="{{ route('admin.pengaturan.index') }}"
        class="{{ Request::routeIs('admin.pengaturan.*') ? 'active' : '' }}">Pengaturan</a>
</div>
