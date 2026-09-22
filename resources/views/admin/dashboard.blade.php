@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title text-primary fw-bold">Dashboard Administrator</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Ringkasan Sistem Tatakrama MTs</li>
            </ul>
        </div>
        <div class="col-auto">
            <span class="badge bg-light text-dark border px-3 py-2 fs-6">
                <i class="fa fa-calendar me-1 text-success"></i>
                {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- ============================================================
    STATISTIK RINGKASAN — Data Dinamis
    ============================================================ --}}
<div class="row g-4 mb-4">

    {{-- Total Siswa --}}
    <div class="col-xl-4 col-sm-6 col-12">
        <div class="card border-0 h-100 shadow-sm" style="background: linear-gradient(135deg, #1b6e3d 0%, #2d8f4e 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="mb-1 opacity-80 small text-uppercase fw-semibold">Total Siswa Aktif</p>
                        <h2 class="mb-0 fw-bold display-6">{{ number_format($totalSiswa) }}</h2>
                    </div>
                    <span style="background: rgba(255,255,255,0.2); border-radius: 16px; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;">
                        <i class="fe fe-users" style="font-size: 1.8rem;"></i>
                    </span>
                </div>
                <div class="mt-3 pt-2 border-top border-white border-opacity-25 d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.siswa.index') }}" class="text-white text-decoration-none small fw-bold">
                        Kelola Data Siswa <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                    <span class="badge bg-white bg-opacity-25">Aktif</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Total User / Guru --}}
    <div class="col-xl-4 col-sm-6 col-12">
        <div class="card border-0 h-100 shadow-sm" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="mb-1 opacity-80 small text-uppercase fw-semibold">Guru & Pengguna</p>
                        <h2 class="mb-0 fw-bold display-6">{{ number_format($totalUsers) }}</h2>
                    </div>
                    <span style="background: rgba(255,255,255,0.2); border-radius: 16px; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;">
                        <i class="fe fe-user-check" style="font-size: 1.8rem;"></i>
                    </span>
                </div>
                <div class="mt-3 pt-2 border-top border-white border-opacity-25 d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none small fw-bold">
                        Kelola Data Pengguna <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                    <span class="badge bg-white bg-opacity-25">User System</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Jenis Pelanggaran --}}
    <div class="col-xl-4 col-sm-6 col-12">
        <div class="card border-0 h-100 shadow-sm" style="background: linear-gradient(135deg, #1a3c2a 0%, #2d5a3f 100%);">
            <div class="card-body text-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="mb-1 opacity-80 small text-uppercase fw-semibold">Master Jenis Pelanggaran</p>
                        <h2 class="mb-0 fw-bold display-6">{{ number_format($totalAturan) }}</h2>
                    </div>
                    <span style="background: rgba(255,255,255,0.2); border-radius: 16px; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center;">
                        <i class="fe fe-list" style="font-size: 1.8rem;"></i>
                    </span>
                </div>
                <div class="mt-3 pt-2 border-top border-white border-opacity-25 d-flex align-items-center justify-content-between">
                    <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="text-white text-decoration-none small fw-bold">
                        Lihat Master Pelanggaran <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                    <span class="badge bg-warning text-dark font-monospace">Master Rules</span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ============================================================
    QUICK ACTION SHORTCUTS (AKSES CEPAT DESKTOP)
    ============================================================ --}}
<div class="card border-0 mb-4 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold text-dark">
            <i class="fe fe-zap me-2 text-primary"></i>Akses Cepat Administrator
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3 col-6">
                <a href="{{ route('admin.poin.create') }}" class="card text-center p-3 border text-decoration-none shadow-sm h-100" style="transition: transform 0.15s ease;">
                    <div class="fs-1 text-success mb-2"><i class="fe fe-plus-circle"></i></div>
                    <h6 class="fw-bold text-dark mb-1">Input Poin Siswa</h6>
                    <small class="text-muted">Catat Pelanggaran</small>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="{{ route('admin.siswa.index') }}" class="card text-center p-3 border text-decoration-none shadow-sm h-100" style="transition: transform 0.15s ease;">
                    <div class="fs-1 text-primary mb-2"><i class="fe fe-users"></i></div>
                    <h6 class="fw-bold text-dark mb-1">Master Siswa</h6>
                    <small class="text-muted">Kelola Data Siswa</small>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="{{ route('admin.rekap.index') }}" class="card text-center p-3 border text-decoration-none shadow-sm h-100" style="transition: transform 0.15s ease;">
                    <div class="fs-1 text-info mb-2"><i class="fe fe-bar-chart-2"></i></div>
                    <h6 class="fw-bold text-dark mb-1">Rekap Poin Siswa</h6>
                    <small class="text-muted">Monitoring Akumulasi</small>
                </a>
            </div>
            <div class="col-md-3 col-6">
                <a href="{{ route('admin.laporan.index') }}" class="card text-center p-3 border text-decoration-none shadow-sm h-100" style="transition: transform 0.15s ease;">
                    <div class="fs-1 text-warning mb-2"><i class="fe fe-printer"></i></div>
                    <h6 class="fw-bold text-dark mb-1">Laporan & Cetak</h6>
                    <small class="text-muted">Cetak SP & Rekap</small>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ============================================================
    INFO SAMBUTAN SISTEM
    ============================================================ --}}
<div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f0f7f2 0%, #e2efe6 100%); border-left: 5px solid #1b6e3d !important;">
    <div class="card-body py-4">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="fw-bold text-primary mb-1">
                    Selamat Datang, {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}! 👋
                </h5>
                <p class="text-dark mb-0">
                    Anda sedang mengelola <strong>Sistem Tatakrama & Kedisiplinan Siswa MTs YKUI Sambogunung</strong>.
                    Seluruh transaksi pencatatan poin dan pencetakan laporan otomatis terintegrasi real-time.
                </p>
            </div>
            <div class="col-auto d-none d-md-block">
                <i class="fe fe-shield text-success" style="font-size: 3.8rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>
</div>

@endsection
