{{-- ============================================================
    Universal Mobile Bottom Navigation Bar (Layar <= 768px)
    Design: Simple flat bar, 5 items, no floating button
    ============================================================ --}}
@auth
<nav class="mobile-bottom-nav d-md-none" id="mobileBottomNav">
    @if(auth()->user()->isAdmin())
        {{-- MENU ADMIN --}}
        <a href="{{ route('admin.dashboard') }}"
           class="mbn-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="mbn-icon fa fa-home"></i>
            <span class="mbn-label">Home</span>
        </a>
        <a href="{{ route('admin.siswa.index') }}"
           class="mbn-item {{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
            <i class="mbn-icon fa fa-users"></i>
            <span class="mbn-label">Siswa</span>
        </a>
        <a href="{{ route('admin.poin.create') }}"
           class="mbn-item mbn-center {{ request()->routeIs('admin.poin.create') ? 'active' : '' }}">
            <div class="mbn-center-btn">
                <i class="fa fa-plus"></i>
            </div>
            <span class="mbn-label">Input</span>
        </a>
        <a href="{{ route('admin.rekap.index') }}"
           class="mbn-item {{ request()->routeIs('admin.rekap.*') ? 'active' : '' }}">
            <i class="mbn-icon fa fa-bar-chart"></i>
            <span class="mbn-label">Rekap</span>
        </a>
        <a href="{{ route('profile.show') }}"
           class="mbn-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="mbn-icon fa fa-user-circle"></i>
            <span class="mbn-label">Profil</span>
        </a>
    @else
        {{-- MENU GURU / WALI KELAS --}}
        <a href="{{ route('guru.dashboard') }}"
           class="mbn-item {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
            <i class="mbn-icon fa fa-home"></i>
            <span class="mbn-label">Home</span>
        </a>
        <a href="{{ route('guru.poin.index') }}"
           class="mbn-item {{ request()->routeIs('guru.poin.index') ? 'active' : '' }}">
            <i class="mbn-icon fa fa-history"></i>
            <span class="mbn-label">Riwayat</span>
        </a>
        <a href="{{ route('guru.poin.create') }}"
           class="mbn-item mbn-center {{ request()->routeIs('guru.poin.create') ? 'active' : '' }}">
            <div class="mbn-center-btn">
                <i class="fa fa-plus"></i>
            </div>
            <span class="mbn-label">Input</span>
        </a>
        @if(auth()->user()->isWaliKelas())
        <a href="{{ route('guru.kelas.index') }}"
           class="mbn-item {{ request()->routeIs('guru.kelas.*') ? 'active' : '' }}">
            <i class="mbn-icon fa fa-university"></i>
            <span class="mbn-label">Kelas</span>
        </a>
        @else
        <a href="{{ route('guru.poin.index') }}"
           class="mbn-item {{ request()->routeIs('guru.poin.*') && !request()->routeIs('guru.poin.create') ? 'active' : '' }}">
            <i class="mbn-icon fa fa-list"></i>
            <span class="mbn-label">Poin</span>
        </a>
        @endif
        <a href="{{ route('profile.show') }}"
           class="mbn-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="mbn-icon fa fa-user-circle"></i>
            <span class="mbn-label">Profil</span>
        </a>
    @endif
</nav>

{{-- MODAL AKUN & LOGOUT --}}
<div class="modal fade" id="modalUserAccount" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-body p-0">
                {{-- Profile Header --}}
                <div style="background: linear-gradient(135deg, #1b6e3d, #2d8f4e); padding: 28px 20px 20px; text-align: center; color: #fff;">
                    <button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="modal"
                            style="position: absolute; top: 14px; right: 14px;"></button>
                    <div style="width: 64px; height: 64px; background: rgba(255,255,255,0.25); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; font-weight: 700; margin: 0 auto 12px; border: 2.5px solid rgba(255,255,255,0.4);">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->name, 0, 1)) }}
                    </div>
                    <div style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">
                        {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}
                    </div>
                    <div style="font-size: 12px; opacity: 0.8;">
                        {{ auth()->user()->username }}
                    </div>
                    <div style="margin-top: 10px; display: flex; flex-wrap: wrap; justify-content: center; gap: 6px;">
                        @foreach(auth()->user()->roles as $r)
                            <span style="background: rgba(255,255,255,0.2); padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600;">
                                {{ $r->label }}
                            </span>
                        @endforeach
                    </div>
                </div>
                {{-- Logout Button --}}
                <div style="padding: 16px 20px 20px; background: #fff;">
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-primary w-100 mb-2" style="border-radius: 12px; padding: 10px; font-weight: 600;">
                        <i class="fa fa-user-edit me-1"></i> Edit Profil & Passwords
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                                style="width: 100%; background: #e74c3c; color: #fff; border: none; border-radius: 12px; padding: 13px; font-size: 14px; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i class="fa fa-sign-out-alt"></i>
                            Keluar / Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ==========================================
   MOBILE BOTTOM NAVIGATION — Flat Clean Style
   ========================================== */
.mobile-bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    height: 64px;
    background: #ffffff;
    border-top: 1px solid #eef0f5;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.08);
    z-index: 1035;
    display: flex;
    align-items: stretch;
    padding-bottom: env(safe-area-inset-bottom, 0px);
}

/* Indicator bar garis bawah layar */
.mobile-bottom-nav::after {
    content: '';
    position: absolute;
    bottom: 6px;
    left: 50%;
    transform: translateX(-50%);
    width: 36px;
    height: 4px;
    background: #dee2e6;
    border-radius: 4px;
}

.mbn-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: #94a3b8;
    padding: 6px 0 14px;
    gap: 3px;
    transition: color 0.2s;
    position: relative;
}

.mbn-item.active {
    color: #1b6e3d;
}

/* Active indicator dot */
.mbn-item.active::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 24px;
    height: 3px;
    background: #1b6e3d;
    border-radius: 0 0 4px 4px;
}

.mbn-icon {
    font-size: 20px;
    line-height: 1;
}

.mbn-label {
    font-size: 10px;
    font-weight: 600;
    letter-spacing: 0.2px;
    line-height: 1;
}

/* Center "Input" button */
.mbn-center {
    position: relative;
}
.mbn-center-btn {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #1b6e3d, #2d8f4e);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
    margin-bottom: 1px;
    box-shadow: 0 4px 12px rgba(27, 110, 61, 0.35);
    transition: transform 0.15s;
}
.mbn-center:active .mbn-center-btn {
    transform: scale(0.93);
}
.mbn-center .mbn-label {
    color: #1b6e3d;
    font-weight: 700;
}

@media (max-width: 768px) {
    body {
        padding-bottom: 70px !important;
    }

    /* Sembunyikan sidebar, header default saat di mobile home panel aktif */
    .mobile-home-wrapper ~ .page-wrapper,
    .mobile-home-wrapper ~ .main-wrapper .header-nav {
        /* dihandle di layout */
    }
}
</style>
@endauth
