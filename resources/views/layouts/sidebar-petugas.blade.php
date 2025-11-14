<div class="sidebar">
    <h5 class="text-center fw-bold mb-4">Petugas</h5>
    <a href="{{ route('petugas.dashboard') }}"
        class="{{ Request::routeIs('petugas.dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('petugas.warga.index') }}" class="{{ Request::routeIs('petugas.warga.*') ? 'active' : '' }}">Data
        Warga</a>
    <a href="{{ route('petugas.pelanggaran.index') }}"
        class="{{ Request::routeIs('petugas.pelanggaran.*') ? 'active' : '' }}">Pelanggaran</a>
    <a href="{{ route('petugas.penghargaan.index') }}"
        class="{{ Request::routeIs('petugas.penghargaan.*') ? 'active' : '' }}">Penghargaan</a>
    <a href="{{ route('petugas.denda.index') }}"
        class="{{ Request::routeIs('petugas.denda.*') ? 'active' : '' }}">Denda</a>
</div>
