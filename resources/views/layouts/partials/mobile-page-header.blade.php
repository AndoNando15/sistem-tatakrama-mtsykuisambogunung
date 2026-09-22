{{-- ============================================================
    MOBILE PAGE HEADER — Top bar untuk halaman non-dashboard
    Tampilkan: tombol back + judul halaman + avatar profil
    Hanya tampil di mobile (<= 768px) via CSS
    Warna: Hijau MTs YKUI Sambogunung
    ============================================================ --}}
@auth
@unless(request()->routeIs('admin.dashboard') || request()->routeIs('guru.dashboard'))
<div class="mobile-page-header d-md-none">
    <a href="javascript:history.back()" class="mph-back">
        <i class="fa fa-arrow-left"></i>
    </a>
    <div class="mph-title">@yield('title', 'Halaman')</div>
    <a href="{{ route('profile.show') }}" class="mph-profile-btn">
        <span class="mph-profile-initial">{{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->name, 0, 1)) }}</span>
    </a>
</div>
@endunless
@endauth

<style>
@media (max-width: 768px) {
    .mobile-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        height: 52px;
        padding: 0 12px;
        background: #fff;
        border-bottom: 1px solid #e0e8e2;
        position: sticky;
        top: 0;
        z-index: 1020;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    }
    .mph-back {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        color: #1a3c2a;
        font-size: 16px;
        text-decoration: none;
        background: #eef5f0;
        transition: background 0.15s;
    }
    .mph-back:active { background: #d5e8da; }
    .mph-title {
        font-size: 15px;
        font-weight: 700;
        color: #1a3c2a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 60%;
        text-align: center;
    }
    .mph-profile-btn {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1b6e3d, #2d8f4e);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }
    .mph-profile-initial {
        color: #fff;
        font-size: 14px;
        font-weight: 700;
    }

    .page-header { display: none !important; }
}
@media (min-width: 769px) {
    .mobile-page-header { display: none !important; }
}
</style>
