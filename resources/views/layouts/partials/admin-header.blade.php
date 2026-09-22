{{-- ============================================================
    Admin Header / Navbar Partial (Desktop & Tablet)
    Menampilkan nama & role user login secara dinamis
    ============================================================ --}}
<div class="header">

    {{-- Logo Section --}}
    @php
        $homeRoute = auth()->check() && auth()->user()->isAdmin() ? route('admin.dashboard') : route('guru.dashboard');
        $userObj = auth()->user();
        $userName = $userObj?->nama_lengkap ?? $userObj?->name ?? 'Pengguna';
        $userInitial = strtoupper(substr($userName, 0, 1));
    @endphp

    <div class="header-left">
        <a href="{{ $homeRoute }}" class="logo">
            <img src="{{ asset('admin-assets/assets/img/logo.png') }}" alt="Logo MTs YKUI" style="max-height: 44px;">
        </a>
        <a href="{{ $homeRoute }}" class="logo logo-small">
            <img src="{{ asset('admin-assets/assets/img/logo-small.png') }}" alt="Logo" width="34" height="34">
        </a>
    </div>

    {{-- Sidebar Toggle Button --}}
    <a href="javascript:void(0);" id="toggle_btn">
        <i class="fe fe-text-align-left"></i>
    </a>

    {{-- Top Search Bar --}}
    <div class="top-nav-search">
        @if(auth()->check() && auth()->user()->isAdmin())
        <form action="{{ route('admin.siswa.index') }}" method="GET">
            <input type="text" name="search" class="form-control" placeholder="Cari nama siswa atau NISN..." value="{{ request('search') }}">
            <button class="btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
        @else
        <form action="{{ route('guru.poin.index') }}" method="GET">
            <input type="text" name="search" class="form-control" placeholder="Cari pencatatan poin..." value="{{ request('search') }}">
            <button class="btn" type="submit"><i class="fa fa-search"></i></button>
        </form>
        @endif
    </div>

    {{-- Mobile Toggle --}}
    <a class="mobile_btn" id="mobile_btn">
        <i class="fa fa-bars"></i>
    </a>

    {{-- Right Nav Menu --}}
    <ul class="nav user-menu">

        {{-- User Profile Dropdown --}}
        @auth
        <li class="nav-item dropdown has-arrow">
            <a href="#" class="dropdown-toggle nav-link d-flex align-items-center gap-2" data-bs-toggle="dropdown" id="userDropdown">
                <span class="avatar avatar-sm bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                      style="width: 34px; height: 34px; background-color: #1b6e3d !important;">
                    {{ $userInitial }}
                </span>
                <span class="d-none d-md-inline-block text-dark fw-bold small">
                    {{ $userName }}
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="userDropdown" style="border-radius: 14px; min-width: 220px;">
                <div class="user-header p-3 bg-light rounded-top">
                    <div class="d-flex align-items-center gap-2">
                        <div class="avatar avatar-sm bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                             style="width: 36px; height: 36px; background-color: #1b6e3d !important;">
                            {{ $userInitial }}
                        </div>
                        <div class="user-text">
                            <h6 class="mb-0 fw-bold text-dark fs-6">{{ $userName }}</h6>
                            <small class="text-muted">
                                @php
                                    $userRoles = $userObj->roles ?? collect();
                                @endphp
                                @if($userRoles->count() > 0)
                                    {{ $userRoles->pluck('nama_role')->implode(', ') }}
                                @else
                                    Pengguna
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
                <a class="dropdown-item py-2" href="{{ route('profile.show') }}">
                    <i class="fa fa-user me-2 text-primary"></i> Profil Saya
                </a>
                <a class="dropdown-item py-2" href="{{ route('profile.show') }}">
                    <i class="fa fa-lock me-2 text-primary"></i> Ubah Password
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}" id="logoutFormDesktop">
                    @csrf
                    <a class="dropdown-item text-danger py-2 fw-semibold"
                       href="#"
                       onclick="event.preventDefault(); document.getElementById('logoutFormDesktop').submit();">
                        <i class="fa fa-sign-out me-2"></i> Keluar / Logout
                    </a>
                </form>
            </div>
        </li>
        @endauth

    </ul>

</div>
