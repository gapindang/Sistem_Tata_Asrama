<nav class="navbar navbar-expand-lg navbar-dark fixed-top"
    style="background: linear-gradient(90deg, #910dfdff 0%, #662accff 100%);">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center" href="#">
            <i class="bi bi-building me-2" style="font-size: 24px;"></i>
            <span>SITAMA</span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                @auth
                    {{-- Notification Bell --}}
                    <li class="nav-item me-3">
                        @php
                            $user = Auth::user();
                            $unreadCount = 0;

                            if ($user->role === 'petugas') {
                                $unreadCount = \App\Models\Pemberitahuan::where('id_user', $user->id_user)
                                    ->where('status_baca', 0)
                                    ->count();
                            } elseif ($user->role === 'admin') {
                                $unreadCount = \App\Models\Pemberitahuan::where('id_user', $user->id_user)
                                    ->where('status_baca', 0)
                                    ->count();
                            } elseif ($user->role === 'warga') {
                                $unreadCount = \App\Models\Pemberitahuan::where('id_user', $user->id_user)
                                    ->where('status_baca', 0)
                                    ->count();
                            }
                        @endphp

                        <a href="@if ($user->role === 'petugas') {{ route('petugas.notifikasi.index') }}@elseif($user->role === 'admin'){{ route('admin.notifikasi.index') }}@else{{ route('warga.notifikasi.index') }} @endif"
                            class="nav-link position-relative d-flex align-items-center notification-bell"
                            title="Notifikasi">
                            <i class="bi bi-bell-fill" style="font-size: 20px;"></i>
                            @if ($unreadCount > 0)
                                <span class="badge-notif">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
                            @endif
                        </a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2" style="font-size: 20px;"></i>
                            <span>{{ Auth::user()->nama }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                @if (Auth::user()->role === 'admin')
                                    <a class="dropdown-item" href="{{ route('admin.profil.index') }}">
                                        <i class="bi bi-person me-2"></i>Profil
                                    </a>
                                @elseif(Auth::user()->role === 'petugas')
                                    <a class="dropdown-item" href="{{ route('petugas.profil.index') }}">
                                        <i class="bi bi-person me-2"></i>Profil
                                    </a>
                                @elseif(Auth::user()->role === 'warga')
                                    <a class="dropdown-item" href="{{ route('warga.profil.index') }}">
                                        <i class="bi bi-person me-2"></i>Profil
                                    </a>
                                @endif
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>Login
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar {
        padding: 0.8rem 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .navbar-brand {
        font-size: 22px;
        letter-spacing: 1px;
    }

    .nav-link {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        margin-top: 8px;
    }

    .dropdown-item {
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        padding-left: 25px;
    }

    /* Notification Bell Styles */
    .notification-bell {
        position: relative;
        transition: transform 0.2s ease;
    }

    .notification-bell:hover {
        transform: scale(1.1);
    }

    .badge-notif {
        position: absolute;
        top: -5px;
        right: -10px;
        background-color: #dc3545;
        color: white;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 6px;
        border-radius: 10px;
        min-width: 18px;
        text-align: center;
        line-height: 1.2;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .navbar-brand span {
            font-size: 18px;
        }

        .nav-link {
            padding: 0.5rem;
        }

        .navbar-collapse {
            background: linear-gradient(180deg, #0d6efd 0%, #0a58ca 100%);
            padding: 1rem;
            border-radius: 10px;
            margin-top: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .notification-bell {
            padding-left: 0.5rem;
        }

        .badge-notif {
            right: -5px;
        }
    }
</style>
