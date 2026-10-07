<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Tatakrama MTs</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin-assets/assets/img/favicon.png') }}">

    {{-- Bootstrap CSS --}}
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/bootstrap.min.css') }}">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/font-awesome.min.css') }}">

    {{-- Feather Icon --}}
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/feathericon.min.css') }}">

    {{-- Morris CSS --}}
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/plugins/morris/morris.css') }}">

    {{-- Select2 CSS --}}
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/select2.min.css') }}">

    {{-- Main Style --}}
    <link rel="stylesheet" href="{{ asset('admin-assets/assets/css/style.css') }}">

    {{-- Custom inline styles untuk app --}}
    <style>
        :root {
            --primary-color: #1b6e3d;
            --accent-color: #2d8f4e;
            --success-color: #27ae60;
            --danger-color: #c0392b;
            --sidebar-bg: #1a3c2a;
            --gold-accent: #c5a830;
        }
        .badge-pill { padding: 5px 10px; }
        .page-title-box .page-title { font-size: 1.1rem; font-weight: 600; color: #1a3c2a; }
        .breadcrumb-item.active { color: #6c757d; }
        .card { border: none; box-shadow: 0 2px 12px rgba(0,0,0,.06); border-radius: 12px; overflow: hidden; }
        .card-header { background: #fff; border-bottom: 1px solid #edf2ee; padding: 16px 20px; }
        
        /* ── BADGES & UTILITIES ── */
        .badge-soft-success { background-color: #e8f5e9 !important; color: #1b6e3d !important; border: 1px solid #c8e6c9; }
        .badge-soft-danger { background-color: #ffebee !important; color: #c0392b !important; border: 1px solid #ffcdd2; }
        .badge-soft-warning { background-color: #fff8e1 !important; color: #b78103 !important; border: 1px solid #ffe082; }
        .badge-soft-info { background-color: #e0f7fa !important; color: #00838f !important; border: 1px solid #b2ebf2; }
        .badge-soft-primary { background-color: #e8f0fe !important; color: #1a73e8 !important; border: 1px solid #c2e7ff; }
        .badge-soft-dark { background-color: #f1f5f9 !important; color: #334155 !important; border: 1px solid #cbd5e1; }
        
        .avatar-initial {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1b6e3d, #2d8f4e);
            color: #ffffff;
            font-weight: 700;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(27, 110, 61, 0.2);
            flex-shrink: 0;
        }

        .avatar-initial-sm {
            width: 30px;
            height: 30px;
            font-size: 0.78rem;
        }
        
        /* ── TABLE STYLING REFINEMENTS ── */
        .table { width: 100%; vertical-align: middle; margin-bottom: 0; }
        .table thead th { background: #f4f8f5; border-bottom: 2px solid #e2ece4; font-weight: 700; font-size: .78rem; text-transform: uppercase; letter-spacing: .6px; color: #1a3c2a; padding: 12px 16px; white-space: nowrap; }
        .table tbody td { padding: 13px 16px; font-size: .88rem; border-bottom: 1px solid #f0f5f1; color: #2d3748; }
        .table tbody tr:hover { background-color: #f7fbf8; }
        .table tbody tr:last-child td { border-bottom: none; }
        
        /* ── CLEAN BOOTSTRAP 5 PAGINATION STYLING ── */
        .pagination { margin: 0; display: flex; align-items: center; gap: 3px; }
        .page-item .page-link {
            border-radius: 8px !important;
            border: 1px solid #e0e8e2 !important;
            color: #1b6e3d !important;
            font-weight: 600 !important;
            padding: 6px 14px !important;
            font-size: 0.85rem !important;
            background-color: #ffffff !important;
            box-shadow: none !important;
            margin: 0 2px !important;
            transition: all 0.15s ease !important;
        }
        .page-item.active .page-link {
            background-color: #1b6e3d !important;
            background: linear-gradient(135deg, #1b6e3d, #2d8f4e) !important;
            border-color: #1b6e3d !important;
            color: #ffffff !important;
            box-shadow: 0 3px 8px rgba(27, 110, 61, 0.25) !important;
        }
        .page-item.disabled .page-link {
            color: #94a3b8 !important;
            background-color: #f8fafc !important;
            border-color: #f1f5f9 !important;
        }
        .page-item .page-link:hover:not(.active) {
            background-color: #eef5f0 !important;
            color: #155a31 !important;
            border-color: #1b6e3d !important;
        }
        /* SVG Arrow fix in pagination links */
        nav .pagination svg,
        .pagination svg,
        .page-link svg {
            width: 14px !important;
            height: 14px !important;
            display: inline-block !important;
            vertical-align: middle !important;
        }
        /* Sembunyikan blok teks redundant bawaan paginator di desktop card footer */
        .card-footer nav .d-none.flex-sm-fill > div:first-child {
            display: none !important;
        }
        .card-footer nav .d-flex.justify-content-between.flex-fill {
            display: none !important;
        }

        .btn-sm { border-radius: 8px; font-size: .8rem; font-weight: 600; padding: 5px 10px; }
        .btn-primary { background: #1b6e3d !important; border-color: #1b6e3d !important; }
        .btn-primary:hover, .btn-primary:focus { background: #155a31 !important; border-color: #155a31 !important; }
        .btn-outline-primary { color: #1b6e3d !important; border-color: #1b6e3d !important; }
        .btn-outline-primary:hover { background: #1b6e3d !important; color: #fff !important; }
        .bg-primary { background-color: #1b6e3d !important; }
        .text-primary { color: #1b6e3d !important; }
        a { color: #1b6e3d; }
        a:hover { color: #155a31; }
        .flash-notification { animation: slideDown .4s ease; }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-15px); } to { opacity: 1; transform: translateY(0); } }

        /* ── DESKTOP SIDEBAR STYLING (FIX DOUBLE YELLOW & WHITE BLEED) ── */
        .sidebar,
        .sidebar-inner,
        #sidebar,
        #sidebar-menu {
            background: #1a3c2a !important;
            background-color: #1a3c2a !important;
        }

        /* Enforce transparent background on all li containers to kill white bleed */
        .sidebar-menu ul,
        .sidebar-menu li,
        .sidebar-menu ul li,
        .sidebar-menu > ul > li,
        .sidebar-menu > ul > li.active,
        .sidebar-menu > ul > li.active:hover,
        .sidebar-menu > ul > li:hover {
            background: transparent !important;
            background-color: transparent !important;
            border: none !important;
            border-left: none !important;
            box-shadow: none !important;
        }

        /* Remove default template pseudo-element lines */
        .sidebar-menu ul li:before,
        .sidebar-menu ul li:after,
        .sidebar-menu ul li.active:before,
        .sidebar-menu ul li.active:after,
        .sidebar-menu > ul > li.active:before,
        .sidebar-menu > ul > li.active:after,
        .sidebar-menu > ul > li > a:before,
        .sidebar-menu > ul > li > a:after {
            display: none !important;
            content: none !important;
            border: none !important;
            background: none !important;
        }

        .sidebar-menu > ul > li.menu-title,
        .sidebar-menu > ul > li.menu-title:hover,
        .sidebar-menu li.menu-title,
        .sidebar-menu li.menu-title:hover {
            background-color: transparent !important;
            background: transparent !important;
            color: inherit !important;
            cursor: default !important;
            margin-top: 8px;
        }

        .sidebar-menu > ul > li.menu-title span,
        .sidebar-menu > ul > li.menu-title:hover span {
            color: #c5a830 !important;
            font-size: 0.72rem !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 1px !important;
            padding: 14px 18px 6px !important;
            display: block;
            opacity: 0.95;
            cursor: default !important;
            background: none !important;
        }

        .sidebar-menu ul li a {
            color: #ffffff !important;
            font-size: 0.88rem !important;
            font-weight: 600 !important;
            display: flex !important;
            align-items: center !important;
            padding: 10px 14px !important;
            border-radius: 8px !important;
            margin: 3px 10px !important;
            transition: all 0.2s ease !important;
            line-height: 1.4 !important;
            background: transparent !important;
            border: none !important;
        }

        .sidebar-menu ul li a span {
            color: #ffffff !important;
            font-weight: 600 !important;
            opacity: 0.95;
            flex: 1;
        }

        .sidebar-menu ul li a i,
        .sidebar-menu ul li a svg {
            color: #a2d2b5 !important;
            font-size: 1.05rem !important;
            width: 24px !important;
            height: 24px !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            margin-right: 12px !important;
            flex-shrink: 0 !important;
            text-align: center !important;
        }

        /* Hover HANYA untuk link navigasi tidak aktif */
        .sidebar-menu ul li:not(.menu-title):not(.active) a:hover,
        .sidebar-menu ul li:not(.menu-title):not(.active) a:focus {
            background-color: #238448 !important;
            background: #238448 !important;
            color: #ffffff !important;
        }

        .sidebar-menu ul li:not(.menu-title):not(.active) a:hover span,
        .sidebar-menu ul li:not(.menu-title):not(.active) a:hover i {
            color: #ffffff !important;
            opacity: 1 !important;
        }

        /* Single Clean Active Link Styling with 1 Gold Accent Bar */
        .sidebar-menu ul li.active a,
        .sidebar-menu ul li.active a:hover,
        .sidebar-menu ul li.active a:focus {
            background: linear-gradient(135deg, #1b6e3d 0%, #2d8f4e 100%) !important;
            background-color: #1b6e3d !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25) !important;
            border-left: 4px solid #c5a830 !important;
        }

        .sidebar-menu ul li.active a span,
        .sidebar-menu ul li.active a i {
            color: #ffffff !important;
            opacity: 1 !important;
        }
        
        /* ── DESKTOP HEADER & TOPBAR ── */
        .header { background-color: #ffffff !important; border-bottom: 1px solid #e0e8e2 !important; box-shadow: 0 2px 10px rgba(0,0,0,0.04); }
        .header-left { background-color: #1a3c2a !important; border-right: 1px solid #143222; }
        .header-left .logo img { max-height: 42px; object-fit: contain; }
        #toggle_btn { color: #1b6e3d !important; }
        .top-nav-search .form-control { border-radius: 20px; border: 1px solid #e0e8e2; background: #f8fafc; font-size: 0.85rem; }
        .top-nav-search .form-control:focus { border-color: #1b6e3d; background: #fff; }
        .top-nav-search .btn { color: #1b6e3d; }

        /* ── KARTU DATA MASTER (tampilan mobile, dipakai semua halaman master) ── */
        .min-w-0 { min-width: 0; }
        .m-card { padding: 14px 16px; margin: 0 0 10px; background: #fff; border: 1px solid #d3e6db; border-left: 3px solid #1f9d55; border-radius: 10px; box-shadow: 0 1px 3px rgba(20,30,60,.06); }
        .m-card:last-child { margin-bottom: 0; }
        .m-detail > div { grid-column: 1 / -1; }
        .d-md-none:has(> .m-card) { padding: 10px; background: #f1f8f4; }
        .m-detail { display: grid; grid-template-columns: 110px 1fr; gap: 4px 10px; margin-top: 10px; padding-top: 10px; border-top: 1px dashed #e3e6ec; font-size: .82rem; }
        .m-detail dt { font-weight: 500; color: #8a91a0; }
        .m-detail dd { margin: 0; color: #2b2f3a; word-break: break-word; }
        .m-pager .pagination { justify-content: center; margin: 0; }

        /* ── MOBILE GLOBAL: layout tweak ── */
        @media (max-width: 768px) {
            /* Saat mobile home panel aktif (halaman dashboard), sembunyikan main layout */
            body.has-mobile-home .main-wrapper {
                display: none !important;
            }

            /* Untuk halaman non-dashboard: sembunyikan sidebar & HEADER admin,
               tampilkan konten normal + mobile page header + bottom nav */
            body:not(.has-mobile-home) .sidebar,
            body:not(.has-mobile-home) .header {
                display: none !important;
            }
            body:not(.has-mobile-home) .page-wrapper {
                margin-left: 0 !important;
                padding-top: 0 !important;
            }
            body:not(.has-mobile-home) .page-header {
                display: block !important;
                margin: 0 0 12px !important;
                padding: 0 !important;
            }
            /* Judul & breadcrumb sudah ada di mobile header; sisakan tombol aksi (mis. "Tambah") */
            body:not(.has-mobile-home) .page-header .col,
            body:not(.has-mobile-home) .page-header .btn-outline-secondary {
                display: none !important;
            }
            body:not(.has-mobile-home) .page-header:not(:has(.col-auto .btn:not(.btn-outline-secondary))) {
                display: none !important;
            }
            body:not(.has-mobile-home) .page-header .col-auto {
                width: 100%;
            }
            body:not(.has-mobile-home) .page-header .col-auto .btn {
                width: 100%;
            }
            body:not(.has-mobile-home) .content.container-fluid {
                padding: 14px !important;
                padding-bottom: 84px !important;
            }
        }
    </style>


    {{-- Per-page styles stack --}}
    @stack('styles')
</head>
<body>

{{-- ── MOBILE HOMEPAGE PANEL (hanya tampil di ≤768px) ── --}}
@include('layouts.partials.mobile-home')

{{-- ── MOBILE PAGE HEADER (halaman non-dashboard ≤768px) ── --}}
@include('layouts.partials.mobile-page-header')

<div class="main-wrapper">

    {{-- Header / Navbar --}}
    @include('layouts.partials.admin-header')

    {{-- Sidebar --}}
    @include('layouts.partials.admin-sidebar')

    {{-- Page Wrapper --}}
    <div class="page-wrapper">
        <div class="content container-fluid">

            {{-- Page Header --}}
            @yield('page-header')

            {{-- Flash Notifications --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show flash-notification" role="alert">
                    <i class="fa fa-check-circle me-2"></i> {!! session('success') !!}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show flash-notification" role="alert">
                    <i class="fa fa-times-circle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show flash-notification" role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Main Content --}}
            @yield('content')

        </div>

        {{-- Footer --}}
        {{-- Footer hidden per request --}}
    </div>

</div>

{{-- jQuery --}}
<script src="{{ asset('admin-assets/assets/js/jquery-3.6.0.min.js') }}"></script>

{{-- Bootstrap Bundle --}}
<script src="{{ asset('admin-assets/assets/js/bootstrap.bundle.min.js') }}"></script>

{{-- SlimScroll --}}
<script src="{{ asset('admin-assets/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

{{-- Select2 JS --}}
<script src="{{ asset('admin-assets/assets/js/select2.min.js') }}"></script>

{{-- Main Script --}}
<script src="{{ asset('admin-assets/assets/js/script.js') }}"></script>

{{-- Per-page scripts stack --}}
@stack('scripts')
{{-- Universal Mobile Bottom Navigation Bar --}}
@include('layouts.partials.mobile-bottom-nav')

</body>
</html>
