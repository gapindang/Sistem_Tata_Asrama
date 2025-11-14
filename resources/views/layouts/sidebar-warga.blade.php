<div class="sidebar">
    <h5 class="text-center fw-bold mb-4">Warga Asrama</h5>
    <a href="{{ route('warga.dashboard') }}"
        class="{{ Request::routeIs('warga.dashboard') ? 'active' : '' }}">Dashboard</a>
    <a href="{{ route('warga.notifikasi.index') }}"
        class="{{ Request::routeIs('warga.notifikasi.*') ? 'active' : '' }}">Notifikasi</a>
    <a href="{{ route('warga.pelanggaran.riwayat') }}"
        class="{{ Request::routeIs('warga.pelanggaran.*') ? 'active' : '' }}">Riwayat Pelanggaran</a>
    <a href="{{ route('warga.penghargaan.riwayat') }}"
        class="{{ Request::routeIs('warga.penghargaan.*') ? 'active' : '' }}">Riwayat Penghargaan</a>
    <a href="{{ route('warga.denda.riwayat') }}" class="{{ Request::routeIs('warga.denda.*') ? 'active' : '' }}">Denda
        Saya</a>
    <a href="{{ route('warga.profil.index') }}"
        class="{{ Request::routeIs('warga.profil.*') ? 'active' : '' }}">Profil</a>
</div>
