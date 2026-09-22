@extends('layouts.admin')

@section('title', 'Dashboard Guru')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title text-primary fw-bold">Dashboard Guru & Pendidik</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item active">Selamat Datang, {{ $user->nama_lengkap ?? $user->name }}</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('guru.poin.create') }}" class="btn btn-primary shadow-sm fw-bold px-3">
                <i class="fa fa-plus-circle me-1"></i> Catat Pelanggaran Baru
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- STAT WIDGETS GURU --}}
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="card border-0 h-100 shadow-sm text-white" style="background: linear-gradient(135deg, #1b6e3d 0%, #2d8f4e 100%);">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <div class="small opacity-80 text-uppercase fw-semibold">Catatan Pelanggaran</div>
                        <h2 class="fw-bold mb-0 display-6">{{ number_format($riwayatInput->count()) }}</h2>
                    </div>
                    <span style="background: rgba(255,255,255,0.2); border-radius: 14px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="fe fe-edit-3 fs-2"></i>
                    </span>
                </div>
                <small class="opacity-75">Diinput oleh Anda</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 shadow-sm text-white" style="background: linear-gradient(135deg, #c0392b 0%, #e74c3c 100%);">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <div class="small opacity-80 text-uppercase fw-semibold">Total Poin Dicatat</div>
                        <h2 class="fw-bold mb-0 display-6">+{{ number_format($totalPoinInput) }}</h2>
                    </div>
                    <span style="background: rgba(255,255,255,0.2); border-radius: 14px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="fe fe-alert-circle fs-2"></i>
                    </span>
                </div>
                <small class="opacity-75">Akumulasi Poin Pelanggaran</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 h-100 shadow-sm text-white" style="background: linear-gradient(135deg, #1a3c2a 0%, #2d5a3f 100%);">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div>
                        <div class="small opacity-80 text-uppercase fw-semibold">Kelas Binaan (Wali Kelas)</div>
                        <h2 class="fw-bold mb-0 fs-3">{{ $kelasSaya ? 'Kelas ' . $kelasSaya->nama_kelas : 'Bukan Wali Kelas' }}</h2>
                    </div>
                    <span style="background: rgba(255,255,255,0.2); border-radius: 14px; width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                        <i class="fe fe-layout fs-2"></i>
                    </span>
                </div>
                <small class="opacity-75">
                    @if($kelasSaya)
                        Total: {{ $kelasSaya->siswa_count ?? $kelasSaya->siswa->count() }} Siswa Active
                    @else
                        Guru Mata Pelajaran
                    @endif
                </small>
            </div>
        </div>
    </div>
</div>

{{-- RECENT RECORD TABLE --}}
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0 fw-bold text-dark">
            <i class="fe fe-clock me-2 text-primary"></i>Riwayat Catatan Poin Terakhir Oleh Anda
        </h5>
        <a href="{{ route('guru.poin.index') }}" class="btn btn-sm btn-outline-primary fw-bold">
            Lihat Semua Riwayat <i class="fa fa-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Tanggal</th>
                        <th>Siswa</th>
                        <th>Detail Pelanggaran</th>
                        <th class="text-center">Poin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatInput as $index => $r)
                    <tr>
                        <td class="text-center text-muted small">{{ $index + 1 }}</td>
                        <td><span class="badge bg-light text-dark border"><i class="fa fa-calendar me-1 text-muted"></i>{{ $r->tanggal ? $r->tanggal->format('d/m/Y') : '-' }}</span></td>
                        <td>
                            <div class="fw-bold text-dark">{{ $r->siswa->nama_siswa ?? '-' }}</div>
                            <small class="text-muted">Kelas {{ $r->siswa->kelas->nama_kelas ?? '-' }}</small>
                        </td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $r->jenisPelanggaran->uraian_pelanggaran ?? $r->jenisPelanggaran->nama_pelanggaran ?? '-' }}</div>
                            @if($r->catatan)
                                <small class="text-muted"><i class="fa fa-commenting-o me-1"></i>{{ $r->catatan }}</small>
                            @endif
                        </td>
                        <td class="text-center"><span class="badge bg-danger fs-6 px-3 py-1">+{{ $r->poin }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fa fa-inbox fa-3x mb-2 d-block opacity-50"></i>
                            Belum ada catatan pelanggaran yang Anda masukkan.
                            <div class="mt-2">
                                <a href="{{ route('guru.poin.create') }}" class="btn btn-sm btn-primary">Catat Pelanggaran Sekarang</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
