<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'SITAMA - Sistem Informasi Asrama')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #8250f7ff;
            color: white;
            padding-top: 70px;
            transition: transform 0.3s ease-in-out;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            overflow-y: auto;
        }

        .sidebar h5 {
            padding: 0 20px;
            margin-bottom: 20px;
            font-size: 18px;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 15px;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            font-size: 14px;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-left-color: white;
            padding-left: 25px;
        }

        .sidebar a.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-left-color: white;
            font-weight: 600;
        }

        .content {
            margin-left: 250px;
            padding: 80px 20px 20px 20px;
            min-height: 100vh;
            transition: margin-left 0.3s ease-in-out;
        }

        .navbar {
            z-index: 1020;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 10px;
            left: 10px;
            z-index: 1030 !important;
            background: #910dfdff;
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 8px;
            cursor: pointer !important;
            transition: all 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            pointer-events: auto !important;
            touch-action: manipulation;
        }

        .sidebar-toggle:hover {
            background: #662accff;
            transform: scale(1.05);
        }

        .sidebar-toggle i {
            font-size: 20px;
            pointer-events: none;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            pointer-events: none;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
            pointer-events: auto !important;
        }

        /* Remove z-index stacking context on .content so Bootstrap modals inside it can sit above the backdrop.
           Having z-index:1 here was forcing all child modals behind the global backdrop appended to <body>. */
        .content {
            position: static;
            /* was relative */
        }

        /* Child elements no longer need forced stacking context settings */

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
                padding: 70px 15px 15px 15px;
            }

            .sidebar-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .navbar-brand {
                margin-left: 50px;
            }
        }

        @media (min-width: 769px) and (max-width: 1024px) {
            .sidebar {
                width: 220px;
            }

            .content {
                margin-left: 220px;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    @if (Auth::check())
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
    @endif

    @include('layouts.navbar')

    @if (Auth::check())
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            function closeSidebar() {
                $('.sidebar').removeClass('show');
                $('#sidebarOverlay').removeClass('show');
                $('#sidebarToggle i').removeClass('bi-x-lg').addClass('bi-list');
            }

            function closeNavbar() {
                const navbar = $('#navbarNav');
                if (navbar.hasClass('show')) {
                    navbar.collapse('hide');
                }
            }

            $(document).on('click', '#sidebarToggle', function(e) {
                e.preventDefault();
                const $sidebar = $('.sidebar');
                const $overlay = $('#sidebarOverlay');
                const $icon = $(this).find('i');

                if ($sidebar.hasClass('show')) {
                    closeSidebar();
                } else {
                    $sidebar.addClass('show');
                    $overlay.addClass('show');
                    $icon.removeClass('bi-list').addClass('bi-x-lg');
                }
            });

            $(document).on('click', '#sidebarOverlay', function() {
                closeSidebar();
            });

            $(document).on('click', '.sidebar a', function() {
                if ($(window).width() <= 768) {
                    setTimeout(closeSidebar, 100);
                }
            });

            $(document).on('click', function(e) {
                const $navbar = $('#navbarNav');
                const $toggler = $('.navbar-toggler');
                const $userDropdown = $('#userDropdown');

                if ($navbar.hasClass('show')) {
                    const isClickInsideNavbar = $navbar[0].contains(e.target);
                    const isClickOnToggler = $toggler[0] && $toggler[0].contains(e.target);
                    const isClickOnDropdown = $userDropdown[0] && (
                        $userDropdown[0].contains(e.target) ||
                        $(e.target).closest('.dropdown-menu').length > 0
                    );

                    if (!isClickInsideNavbar && !isClickOnToggler && !isClickOnDropdown) {
                        closeNavbar();
                    }
                }
            });

            $(document).on('click', '#navbarNav .nav-link:not(.dropdown-toggle)', function() {
                if ($(window).width() < 992 && !$(this).closest('form').length) {
                    setTimeout(closeNavbar, 150);
                }
            });

            $(document).on('click', '#navbarNav .dropdown-item', function() {
                if ($(window).width() < 992 && !$(this).closest('form').length && $(this).attr('href') !==
                    '#') {
                    setTimeout(closeNavbar, 150);
                }
            });

            $(window).on('resize', function() {
                if ($(window).width() > 768) {
                    closeSidebar();
                }
            });
        });
    </script>

    @stack('scripts')
</body>

</html>
