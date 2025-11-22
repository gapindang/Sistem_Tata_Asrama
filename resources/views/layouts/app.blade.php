<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SITAMA - Sistem Informasi Asrama')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #8250f7ff;
            color: white;
            padding-top: 60px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px 20px;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .content {
            margin-left: 250px;
            padding: 20px;
        }

        .navbar {
            z-index: 1030;
        }
    </style>

    @stack('styles')
</head>

<body>

    @include('layouts.navbar')

    @if (Auth::check())
        @if (Auth::user()->role == 'admin')
            @include('layouts.sidebar-admin')
        @elseif(Auth::user()->role == 'petugas')
            @include('layouts.sidebar-petugas')
        @else
            @include('layouts.sidebar-warga')
        @endif
    @endif

    <div class="content" id="main-content">
        @yield('content')
    </div>

    @include('layouts.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    @include('layouts.scripts')
    @stack('scripts')
    @yield('scripts')
</body>

</html>
