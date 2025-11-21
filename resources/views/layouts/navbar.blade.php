<nav class="navbar navbar-expand-lg navbar-dark fixed-top"
    style="background: linear-gradient(90deg, #0d6efd 0%, #0a58ca 100%);">
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
    }
</style>
