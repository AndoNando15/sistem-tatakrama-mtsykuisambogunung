@extends('layouts.admin')

@section('title', 'Laporan & Cetak')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Laporan & Cetak Dokumen</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Laporan & Cetak</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    {{-- FILTER FORM --}}
    <div class="col-md-12 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3"><h5 class="card-title mb-0 fw-bold text-dark"><i class="fe fe-filter me-2 text-primary"></i>Filter Laporan Pelanggaran</h5></div>
            <div class="card-body py-3">
                <form action="{{ route('admin.laporan.index') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted mb-1">Kelas</label>
                            <select name="kelas_id" class="form-select">
                                <option value="">-- Semua Kelas --</option>
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold text-muted mb-1">Kategori Pelanggaran</label>
                            <select name="kategori_id" class="form-select">
                                <option value="">-- Semua Kategori --</option>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>[{{ $kat->kode }}] {{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold text-muted mb-1">Dari Tanggal</label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold text-muted mb-1">Sampai Tanggal</label>
                            <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                        </div>
                        <div class="col-md-2">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary w-100"><i class="fa fa-search me-1"></i>Filter</button>
                                <a href="{{ route('admin.laporan.cetak-pelanggaran', request()->query()) }}" target="_blank" class="btn btn-danger" title="Cetak Rekap PDF / Print"><i class="fa fa-print me-1"></i>Cetak</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- HASIL PREVIEW --}}
    <div class="col-md-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="badge bg-soft-success text-success p-2 rounded-circle">
                        <i class="fe fe-file-text fs-5"></i>
                    </div>
                    <h5 class="card-title mb-0 fw-bold text-dark">Hasil Laporan Pelanggaran Siswa</h5>
                </div>
                <span class="badge bg-primary rounded-pill px-3 py-2">Total Record: {{ $laporanList->total() }}</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="50" class="text-center">#</th>
                                <th>Tanggal</th>
                                <th>NISN</th>
                                <th>Nama Siswa</th>
                                <th class="text-center">Kelas</th>
                                <th>Jenis Pelanggaran</th>
                                <th class="text-center">Poin</th>
                                <th>Tindak Lanjut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($laporanList as $index => $lap)
                            <tr>
                                <td class="text-center text-muted small fw-semibold">{{ $laporanList->firstItem() + $index }}</td>
                                <td>
                                    <span class="badge badge-soft-dark font-monospace px-2 py-1">
                                        <i class="fa fa-calendar me-1 text-muted"></i>{{ $lap->tanggal ? $lap->tanggal->format('d/m/Y') : '-' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-soft-dark font-monospace px-2 py-1">
                                        {{ $lap->siswa->nis_nisn ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-initial avatar-initial-sm">
                                            {{ strtoupper(substr($lap->siswa->nama_siswa ?? 'S', 0, 1)) }}
                                        </div>
                                        <div class="fw-bold text-dark">{{ $lap->siswa->nama_siswa ?? '-' }}</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-soft-info px-2.5 py-1 fw-semibold">
                                        <i class="fe fe-grid me-1"></i>{{ $lap->siswa->kelas->nama_kelas ?? '-' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark fs-6">{{ $lap->jenisPelanggaran->uraian_pelanggaran ?? '-' }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-soft-danger rounded-pill px-3 py-1.5 fs-6 fw-bold">
                                        +{{ $lap->poin }} Poin
                                    </span>
                                </td>
                                <td>
                                    @if(!empty($lap->tindak_lanjut))
                                        <span class="text-secondary small">
                                            <i class="fa fa-info-circle me-1 text-muted"></i>{{ $lap->tindak_lanjut }}
                                        </span>
                                    @else
                                        <span class="text-muted small fst-italic">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <div class="text-muted py-3">
                                        <i class="fe fe-file-text fa-3x mb-3 text-muted opacity-50 d-block"></i>
                                        <h6 class="fw-bold mb-1">Data Laporan Tidak Ditemukan</h6>
                                        <p class="small mb-0">Tidak ada data laporan pelanggaran yang sesuai filter.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($laporanList->hasPages())
            <div class="card-footer bg-white d-flex align-items-center justify-content-between py-3">
                <div class="text-muted small fw-medium">Menampilkan {{ $laporanList->firstItem() }}–{{ $laporanList->lastItem() }} dari <strong>{{ $laporanList->total() }}</strong> record</div>
                <div>{{ $laporanList->links() }}</div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
