{{-- ============================================================
    Admin & Guru Sidebar Navigation Partial
    Menampilkan menu dinamis secara ketat sesuai Role User Login
    ============================================================ --}}
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                @auth
                @if(auth()->user()->isAdmin())
                    {{-- ============================================================
                        MENU KHUSUS ROLE ADMIN
                        ============================================================ --}}
                    <li class="menu-title">
                        <span>Menu Utama</span>
                    </li>
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fa fa-tachometer"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li class="menu-title">
                        <span>Master Data</span>
                    </li>
                    <li class="{{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.siswa.index') }}">
                            <i class="fa fa-graduation-cap"></i>
                            <span>Master Siswa</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.kelas.index') }}">
                            <i class="fa fa-th-large"></i>
                            <span>Master Kelas</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.users.index') }}">
                            <i class="fa fa-user-circle"></i>
                            <span>Master Guru & User</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.mata-pelajaran.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.mata-pelajaran.index') }}">
                            <i class="fa fa-book"></i>
                            <span>Master Mata Pelajaran</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.tahun-ajaran.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.tahun-ajaran.index') }}">
                            <i class="fa fa-calendar"></i>
                            <span>Tahun Ajaran</span>
                        </a>
                    </li>

                    <li class="menu-title">
                        <span>Pelanggaran & Poin</span>
                    </li>
                    <li class="{{ request()->routeIs('admin.kategori-pelanggaran.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.kategori-pelanggaran.index') }}">
                            <i class="fa fa-tags"></i>
                            <span>Kategori Pelanggaran</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.jenis-pelanggaran.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.jenis-pelanggaran.index') }}">
                            <i class="fa fa-list-alt"></i>
                            <span>Jenis Pelanggaran</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.poin.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.poin.index') }}">
                            <i class="fa fa-pencil-square-o"></i>
                            <span>Input Poin Siswa</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('admin.rekap.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.rekap.index') }}">
                            <i class="fa fa-bar-chart"></i>
                            <span>Rekap Poin Siswa</span>
                        </a>
                    </li>

                    <li class="menu-title">
                        <span>Aturan & Sanksi</span>
                    </li>
                    <li class="{{ request()->routeIs('admin.aturan-sanksi.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.aturan-sanksi.index') }}">
                            <i class="fa fa-gavel"></i>
                            <span>Aturan Sanksi</span>
                        </a>
                    </li>

                    <li class="menu-title">
                        <span>Laporan</span>
                    </li>
                    <li class="{{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.laporan.index') }}">
                            <i class="fa fa-file-text-o"></i>
                            <span>Laporan & Cetak</span>
                        </a>
                    </li>

                    <li class="menu-title">
                        <span>Pengaturan</span>
                    </li>
                    <li class="{{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.index') }}">
                            <i class="fa fa-cogs"></i>
                            <span>Pengaturan Sistem</span>
                        </a>
                    </li>

                @else
                    {{-- ============================================================
                        MENU KHUSUS ROLE GURU / WALI KELAS
                        ============================================================ --}}
                    <li class="menu-title">
                        <span>Menu Utama Guru</span>
                    </li>
                    <li class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('guru.dashboard') }}">
                            <i class="fa fa-tachometer"></i>
                            <span>Dashboard Guru</span>
                        </a>
                    </li>

                    <li class="menu-title">
                        <span>Pencatatan Poin</span>
                    </li>
                    <li class="{{ request()->routeIs('guru.poin.create') ? 'active' : '' }}">
                        <a href="{{ route('guru.poin.create') }}">
                            <i class="fa fa-plus-circle"></i>
                            <span>Catat Pelanggaran</span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('guru.poin.index') ? 'active' : '' }}">
                        <a href="{{ route('guru.poin.index') }}">
                            <i class="fa fa-history"></i>
                            <span>Riwayat Saya</span>
                        </a>
                    </li>

                    @if(auth()->user()->isWaliKelas())
                        <li class="menu-title">
                            <span>Wali Kelas</span>
                        </li>
                        <li class="{{ request()->routeIs('guru.kelas.*') ? 'active' : '' }}">
                            <a href="{{ route('guru.kelas.index') }}">
                                <i class="fa fa-th-large"></i>
                                <span>Monitoring Kelas Saya</span>
                            </a>
                        </li>
                    @endif
                @endif
                @endauth
            </ul>
        </div>
    </div>
</div>
