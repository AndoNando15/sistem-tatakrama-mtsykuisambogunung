@extends('layouts.admin')

@section('title', 'Riwayat Pencatatan Pelanggaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Riwayat Pencatatan Pelanggaran</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Riwayat Saya</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('guru.poin.create') }}" class="btn btn-primary">
                <i class="fa fa-plus me-1"></i> Input Cepat
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- FILTER --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form action="{{ route('guru.poin.index') }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label small fw-semibold mb-1">Cari Siswa</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama siswa..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter me-1"></i>Filter</button>
                        <a href="{{ route('guru.poin.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="fa fa-refresh"></i></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- TABEL --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0"><i class="fe fe-list me-2"></i>Daftar Catatan yang Anda Masukkan</h5>
        <span class="badge bg-primary rounded-pill">Total: {{ $pelanggaran->total() }}</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Tanggal</th>
                        <th>Siswa & Kelas</th>
                        <th>Kategori & Pelanggaran</th>
                        <th class="text-center">Poin</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggaran as $index => $p)
                    <tr>
                        <td class="text-center text-muted small">{{ $pelanggaran->firstItem() + $index }}</td>
                        <td>{{ $p->tanggal ? $p->tanggal->format('d/m/Y') : '-' }}</td>
                        <td>
                            <div class="fw-semibold">{{ $p->siswa->nama_siswa ?? '-' }}</div>
                            <small class="text-muted">{{ $p->siswa->kelas->nama_kelas ?? '-' }} ({{ $p->siswa->nis_nisn ?? '-' }})</small>
                        </td>
                        <td>
                            @if($p->jenisPelanggaran)
                                <span class="badge bg-soft-info text-info me-1">{{ $p->jenisPelanggaran->kategori->nama_kategori ?? '' }}</span>
                                <div class="small mt-1">{{ $p->jenisPelanggaran->uraian_pelanggaran }}</div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger rounded-pill fs-6 px-3">+{{ $p->poin }}</span>
                        </td>
                        <td class="small text-muted">{{ $p->catatan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted"><i class="fa fa-inbox fa-3x mb-3 d-block"></i><p>Belum ada catatan pelanggaran yang Anda masukkan.</p></div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pelanggaran->hasPages())
    <div class="card-footer d-flex align-items-center justify-content-between">
        <div class="text-muted small">Menampilkan {{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }}</div>
        <div>{{ $pelanggaran->links() }}</div>
    </div>
    @endif
</div>
@endsection
