@extends('layouts.admin')

@section('title', 'Rekap Poin Siswa')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Rekapitulasi Poin Pelanggaran Siswa</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Rekap Poin Siswa</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- FILTER --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('admin.rekap.index') }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-muted mb-1">Cari Siswa</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa fa-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama atau NISN..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted mb-1">Kelas</label>
                    <select name="kelas_id" class="form-select">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter me-1"></i> Filter</button>
                        <a href="{{ route('admin.rekap.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="fa fa-refresh"></i></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- TABEL --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <div class="d-flex align-items-center gap-2">
            <div class="badge bg-soft-success text-success p-2 rounded-circle">
                <i class="fe fe-bar-chart-2 fs-5"></i>
            </div>
            <h5 class="card-title mb-0 fw-bold text-dark">Peringkat Akumulasi Poin Siswa</h5>
        </div>
        <span class="badge bg-primary rounded-pill px-3 py-2">Total: {{ $siswaList->total() }} Siswa</span>
    </div>
    <div class="d-md-none p-2">
        @forelse($siswaList as $s)
        @php
            $poin = $s->total_poin ?? 0;
            $sanksi = $aturanSanksi->first(fn($a) => $poin >= $a->min_poin && $poin <= $a->max_poin);
            $badge = $poin == 0 ? 'badge-soft-success' : ($poin < 20 ? 'badge-soft-info' : ($poin < 50 ? 'badge-soft-warning' : 'badge-soft-danger'));
        @endphp
        <div class="m-card">
            <div class="d-flex justify-content-between align-items-start gap-2">
                <div class="min-w-0">
                    <div class="fw-bold text-dark text-truncate">{{ $s->nama_siswa }}</div>
                    <small class="text-muted">{{ $s->kelas->nama_kelas ?? '-' }} · {{ $s->nis_nisn }}</small>
                </div>
                <span class="badge {{ $badge }} rounded-pill px-3 py-2 fw-bold">{{ $poin }} Poin</span>
            </div>
            <div class="m-detail">
                <div><i class="fa fa-gavel me-1"></i>{{ $sanksi->tindakan ?? ($poin == 0 ? 'Tidak ada pelanggaran' : 'Peringatan ringan') }}</div>
            </div>
            <div class="mt-2 d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.rekap.show', $s->id) }}" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye me-1"></i>Detail</a>
                @if($poin >= 20)
                <a href="{{ route('admin.laporan.cetak-sp', $s->id) }}" target="_blank" class="btn btn-sm btn-outline-danger"><i class="fa fa-print me-1"></i>SP</a>
                @endif
            </div>
        </div>
        @empty
        <div class="text-center text-muted py-5">Belum ada data rekapitulasi poin siswa.</div>
        @endforelse
    </div>
    <div class="card-body p-0 d-none d-md-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th class="text-center">Kelas</th>
                        <th class="text-center">Total Akumulasi Poin</th>
                        <th>Status Sanksi Kumulatif</th>
                        <th class="text-center" width="140">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswaList as $index => $s)
                    @php
                        $poin = $s->total_poin ?? 0;
                        $sanksi = $aturanSanksi->first(fn($a) => $poin >= $a->min_poin && $poin <= $a->max_poin);
                    @endphp
                    <tr>
                        <td class="text-center text-muted small fw-semibold">{{ $siswaList->firstItem() + $index }}</td>
                        <td>
                            <span class="badge badge-soft-dark font-monospace px-2 py-1">
                                <i class="fa fa-id-card-o me-1 text-muted"></i>{{ $s->nis_nisn }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="avatar-initial">
                                    {{ strtoupper(substr($s->nama_siswa, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $s->nama_siswa }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-soft-info px-2.5 py-1 fw-semibold">
                                <i class="fe fe-grid me-1"></i>{{ $s->kelas->nama_kelas ?? '-' }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($poin == 0)
                                <span class="badge badge-soft-success rounded-pill fs-6 px-3 py-1.5 fw-bold">
                                    <i class="fa fa-check-circle me-1"></i>0 Poin (Bersih)
                                </span>
                            @elseif($poin < 20)
                                <span class="badge badge-soft-info rounded-pill fs-6 px-3 py-1.5 fw-bold">
                                    {{ $poin }} Poin
                                </span>
                            @elseif($poin < 50)
                                <span class="badge badge-soft-warning rounded-pill fs-6 px-3 py-1.5 fw-bold">
                                    <i class="fa fa-exclamation-triangle me-1"></i>{{ $poin }} Poin
                                </span>
                            @else
                                <span class="badge badge-soft-danger rounded-pill fs-6 px-3 py-1.5 fw-bold">
                                    <i class="fa fa-bell me-1"></i>{{ $poin }} Poin
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($sanksi)
                                <span class="badge badge-soft-danger fw-semibold px-2.5 py-1">
                                    <i class="fa fa-gavel me-1"></i>{{ $sanksi->tindakan }}
                                </span>
                            @elseif($poin == 0)
                                <span class="badge badge-soft-success px-2.5 py-1">
                                    <i class="fa fa-smile-o me-1"></i>Tidak Ada Pelanggaran
                                </span>
                            @else
                                <span class="badge badge-soft-warning px-2.5 py-1">
                                    Peringatan Ringan
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.rekap.show', $s->id) }}" class="btn btn-sm btn-outline-primary" title="Detail Riwayat Pelanggaran">
                                    <i class="fa fa-eye me-1"></i>Detail
                                </a>
                                @if($poin >= 20)
                                    <a href="{{ route('admin.laporan.cetak-sp', $s->id) }}" target="_blank" class="btn btn-sm btn-outline-danger" title="Cetak Surat Peringatan (SP)">
                                        <i class="fa fa-print"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted py-3">
                                <i class="fe fe-bar-chart-2 fa-3x mb-3 text-muted opacity-50 d-block"></i>
                                <h6 class="fw-bold mb-1">Data Rekap Poin Tidak Ditemukan</h6>
                                <p class="small mb-0">Belum ada data rekapitulasi poin siswa.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.partials.pagination-footer', ['paginator' => $siswaList, 'noun' => 'siswa'])
</div>
@endsection
