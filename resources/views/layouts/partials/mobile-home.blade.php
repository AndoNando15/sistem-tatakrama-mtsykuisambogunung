{{-- ============================================================
    MOBILE HOMEPAGE PANEL
    - Hanya tampil di layar <= 768px
    - Hanya tampil di halaman dashboard (admin.dashboard / guru.dashboard)
    - Full screen height, scroll internal saja
    - Warna: Hijau MTs YKUI Sambogunung
    ============================================================ --}}
@auth
@if(request()->routeIs('admin.dashboard') || request()->routeIs('guru.dashboard'))
<div class="mh-wrapper" id="mobileHomePanel">

    {{-- ══ SCROLLABLE AREA ══ --}}
    <div class="mh-scroll">

        {{-- ── HEADER BAR ── --}}
        <div class="mh-topbar">
            <div class="d-flex align-items-center gap-2">
                <div class="mh-logo-box">
                    <i class="fa fa-shield"></i>
                </div>
                <div>
                    <div class="mh-app-name">Tatakrama MTs</div>
                    <div class="mh-app-sub">YKUI Sambogunung</div>
                </div>
            </div>
            <a href="{{ route('profile.show') }}" class="mh-bell-btn text-decoration-none">
                <i class="fa fa-user-circle" style="font-size:22px; color:#1b6e3d;"></i>
            </a>
        </div>

        {{-- ── PROFILE CARD ── --}}
        <div class="mh-px">
            <a href="{{ route('profile.show') }}" class="mh-profile-card text-decoration-none">
                <div class="mh-avatar">
                    {{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->name, 0, 1)) }}
                </div>
                <div class="mh-profile-info">
                    <div class="mh-profile-name">{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</div>
                    <div class="mh-profile-id">
                        @if(auth()->user()->nip_nik)
                            NIP: {{ auth()->user()->nip_nik }}
                        @else
                            {{ auth()->user()->username }}
                        @endif
                    </div>
                    <div class="mh-profile-role-badge">
                        @foreach(auth()->user()->roles->take(2) as $r)
                            {{ $r->label }}{{ !$loop->last ? ' · ' : '' }}
                        @endforeach
                        <i class="fa fa-chevron-right ms-1 text-white-50" style="font-size: 9px;"></i>
                    </div>
                </div>
            </a>
        </div>

        {{-- ── QUICK SERVICES ── --}}
        <div class="mh-px mh-mt">
            <div class="mh-section-title">Quick Services</div>
            <div class="mh-grid">
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.siswa.index') }}" class="mh-card">
                        <div class="mh-card-icon" style="background:#e8f5e9;">
                            <i class="fa fa-users" style="color:#1b6e3d;"></i>
                        </div>
                        <span class="mh-card-label">Data Siswa</span>
                    </a>
                    <a href="{{ route('admin.poin.create') }}" class="mh-card">
                        <div class="mh-card-icon" style="background:#fff8e1;">
                            <i class="fa fa-plus-circle" style="color:#c5a830;"></i>
                        </div>
                        <span class="mh-card-label">Input Poin</span>
                    </a>
                    <a href="{{ route('admin.kelas.index') }}" class="mh-card">
                        <div class="mh-card-icon" style="background:#e0f2f1;">
                            <i class="fa fa-building" style="color:#2d8f4e;"></i>
                        </div>
                        <span class="mh-card-label">Data Kelas</span>
                    </a>
                    <a href="{{ route('admin.rekap.index') }}" class="mh-card">
                        <div class="mh-card-icon" style="background:#f3e5f5;">
                            <i class="fa fa-bar-chart" style="color:#7b1fa2;"></i>
                        </div>
                        <span class="mh-card-label">Rekap</span>
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="mh-card">
                        <div class="mh-card-icon" style="background:#fff3e0;">
                            <i class="fa fa-file-text-o" style="color:#e67e22;"></i>
                        </div>
                        <span class="mh-card-label">Laporan</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="mh-card">
                        <div class="mh-card-icon" style="background:#e8eaf6;">
                            <i class="fa fa-cog" style="color:#5b6abf;"></i>
                        </div>
                        <span class="mh-card-label">Kelola User</span>
                    </a>
                @else
                    {{-- GURU --}}
                    <a href="{{ route('guru.poin.create') }}" class="mh-card">
                        <div class="mh-card-icon" style="background:#e8f5e9;">
                            <i class="fa fa-plus-circle" style="color:#1b6e3d;"></i>
                        </div>
                        <span class="mh-card-label">Input Poin</span>
                    </a>
                    <a href="{{ route('guru.poin.index') }}" class="mh-card">
                        <div class="mh-card-icon" style="background:#fff8e1;">
                            <i class="fa fa-history" style="color:#c5a830;"></i>
                        </div>
                        <span class="mh-card-label">Riwayat</span>
                    </a>
                    @if(auth()->user()->isWaliKelas())
                    <a href="{{ route('guru.kelas.index') }}" class="mh-card">
                        <div class="mh-card-icon" style="background:#e0f2f1;">
                            <i class="fa fa-building" style="color:#2d8f4e;"></i>
                        </div>
                        <span class="mh-card-label">Kelas Saya</span>
                    </a>
                    @endif
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalUserAccount" class="mh-card">
                        <div class="mh-card-icon" style="background:#e8eaf6;">
                            <i class="fa fa-user-circle" style="color:#5b6abf;"></i>
                        </div>
                        <span class="mh-card-label">Profil Saya</span>
                    </a>
                @endif
            </div>
        </div>

        {{-- ── INFO CARDS ── --}}
        <div class="mh-px mh-mt">
            <div class="mh-section-title">Informasi</div>

            <div class="mh-info-card">
                <div class="mh-info-icon" style="background:#e8f5e9; color:#1b6e3d;">
                    <i class="fa fa-calendar"></i>
                </div>
                <div>
                    <div class="mh-info-lbl">Tanggal Hari Ini</div>
                    <div class="mh-info-val">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</div>
                </div>
            </div>

            <div class="mh-info-card mh-mt-sm">
                <div class="mh-info-icon" style="background:#fff8e1; color:#c5a830;">
                    <i class="fa fa-shield"></i>
                </div>
                <div>
                    <div class="mh-info-lbl">Sistem Aktif</div>
                    <div class="mh-info-val">Tatakrama & Kedisiplinan Siswa MTs</div>
                </div>
            </div>
        </div>

        {{-- SPACER BAWAH untuk bottom nav --}}
        <div style="height: 88px;"></div>

    </div>{{-- end .mh-scroll --}}
</div>{{-- end .mh-wrapper --}}
@endif
@endauth

<style>
/* =============================================
   MOBILE HOME PANEL — Full Screen Layout
   Warna: Hijau MTs YKUI Sambogunung
   ============================================= */
@media (max-width: 768px) {

    .mh-wrapper {
        position: fixed;
        inset: 0;
        z-index: 1030;
        display: flex;
        flex-direction: column;
        background: #f2f5f3;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .mh-scroll {
        flex: 1;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
        padding-bottom: 80px;
    }

    /* ── TOP BAR ── */
    .mh-topbar {
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 16px;
        height: 58px;
        border-bottom: 1px solid #e0e8e2;
        position: sticky;
        top: 0;
        z-index: 10;
        flex-shrink: 0;
    }
    .mh-logo-box {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #1b6e3d, #2d8f4e);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 15px;
        flex-shrink: 0;
    }
    .mh-app-name {
        font-size: 14px;
        font-weight: 700;
        color: #1a3c2a;
        line-height: 1.2;
    }
    .mh-app-sub {
        font-size: 10px;
        color: #7a9a87;
        line-height: 1;
    }
    .mh-bell-btn {
        background: none;
        border: none;
        padding: 6px;
    }

    /* ── PADDING HELPERS ── */
    .mh-px     { padding: 0 16px; }
    .mh-mt     { margin-top: 20px; }
    .mh-mt-sm  { margin-top: 10px; }

    /* ── SECTION TITLE ── */
    .mh-section-title {
        font-size: 15px;
        font-weight: 700;
        color: #1a3c2a;
        margin-bottom: 12px;
    }

    /* ── PROFILE CARD ── */
    .mh-profile-card {
        background: linear-gradient(135deg, #1b6e3d 0%, #2d8f4e 60%, #3aab5f 100%);
        border-radius: 18px;
        padding: 20px 20px;
        display: flex;
        align-items: center;
        gap: 14px;
        color: #fff;
        box-shadow: 0 6px 24px rgba(27, 110, 61, 0.3);
        margin-top: 16px;
    }
    .mh-avatar {
        width: 58px;
        height: 58px;
        background: rgba(255,255,255,0.22);
        border: 2px solid rgba(255,255,255,0.4);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 700;
        flex-shrink: 0;
    }
    .mh-profile-name {
        font-size: 16px;
        font-weight: 700;
        line-height: 1.3;
    }
    .mh-profile-id {
        font-size: 12px;
        opacity: 0.82;
        margin-top: 2px;
    }
    .mh-profile-role-badge {
        display: inline-block;
        margin-top: 6px;
        background: rgba(255,255,255,0.18);
        border-radius: 20px;
        padding: 2px 10px;
        font-size: 11px;
        font-weight: 600;
    }

    /* ── QUICK SERVICES GRID ── */
    .mh-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }
    .mh-card {
        background: #fff;
        border-radius: 16px;
        padding: 16px 8px 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 8px;
        text-decoration: none !important;
        border: 1px solid #e4ece6;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        transition: transform 0.12s ease, box-shadow 0.12s ease;
        -webkit-tap-highlight-color: transparent;
    }
    .mh-card:active {
        transform: scale(0.94);
        box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    }
    .mh-card-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }
    .mh-card-label {
        font-size: 11px;
        font-weight: 600;
        color: #4a5568;
        text-align: center;
        line-height: 1.3;
    }

    /* ── INFO CARDS ── */
    .mh-info-card {
        background: #fff;
        border-radius: 14px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 14px;
        border: 1px solid #e4ece6;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .mh-info-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .mh-info-lbl {
        font-size: 10px;
        color: #7a9a87;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }
    .mh-info-val {
        font-size: 13px;
        font-weight: 600;
        color: #1a3c2a;
        margin-top: 2px;
    }

    /* ── Sembunyikan desktop layout saat mobile home tampil ── */
    body.has-mobile-home .main-wrapper {
        display: none !important;
    }
}

@media (min-width: 769px) {
    .mh-wrapper { display: none !important; }
}
</style>

@auth
@if(request()->routeIs('admin.dashboard') || request()->routeIs('guru.dashboard'))
<script>
    document.documentElement.classList.add('mobile-home-active');
    document.body.classList.add('has-mobile-home');
</script>
@endif
@endauth
