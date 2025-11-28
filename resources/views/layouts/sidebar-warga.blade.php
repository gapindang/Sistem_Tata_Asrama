<div class="sidebar">
    <div class="sidebar-header text-center mb-3">
        <img src="{{ asset('images/SITAMA.png') }}" alt="SITAMA Logo" class="sidebar-logo mb-2">
        <h5 class="fw-bold mb-0">Warga Asrama</h5>
    </div>
    <a href="{{ route('warga.dashboard') }}" class="{{ Request::routeIs('warga.dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </a>
    <a href="{{ route('warga.notifikasi.index') }}" class="{{ Request::routeIs('warga.notifikasi.*') ? 'active' : '' }}">
        <i class="bi bi-bell me-2"></i>Notifikasi
    </a>
    <a href="{{ route('warga.pelanggaran.riwayat') }}"
        class="{{ Request::routeIs('warga.pelanggaran.*') ? 'active' : '' }}">
        <i class="bi bi-exclamation-triangle me-2"></i>Riwayat Pelanggaran
    </a>
    <a href="{{ route('warga.penghargaan.riwayat') }}"
        class="{{ Request::routeIs('warga.penghargaan.*') ? 'active' : '' }}">
        <i class="bi bi-trophy me-2"></i>Riwayat Penghargaan
    </a>
    <a href="{{ route('warga.denda.riwayat') }}" class="{{ Request::routeIs('warga.denda.*') ? 'active' : '' }}">
        <i class="bi bi-cash-coin me-2"></i>Denda Saya
    </a>
    <a href="{{ route('warga.statistik.index') }}"
        class="{{ Request::routeIs('warga.statistik.*') ? 'active' : '' }}">
        <i class="bi bi-graph-up me-2"></i>Statistik Poin
    </a>
    <a href="{{ route('warga.pesan.index') }}" class="{{ Request::routeIs('warga.pesan.*') ? 'active' : '' }}">
        <i class="bi bi-chat-dots me-2"></i>Pesan
    </a>
    <a href="{{ route('warga.profil.index') }}" class="{{ Request::routeIs('warga.profil.*') ? 'active' : '' }}">
        <i class="bi bi-person-circle me-2"></i>Profil
    </a>
</div>
