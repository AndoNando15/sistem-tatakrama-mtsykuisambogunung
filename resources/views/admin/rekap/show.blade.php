@extends('layouts.admin')

@section('title', 'Detail Riwayat Poin Siswa')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Detail Riwayat Pelanggaran</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.rekap.index') }}">Rekap Poin Siswa</a></li>
                <li class="breadcrumb-item active">{{ $siswa->nama_siswa }}</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.rekap.index') }}" class="btn btn-outline-secondary me-2"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
            <a href="{{ route('admin.laporan.cetak-sp', $siswa->id) }}" target="_blank" class="btn btn-danger"><i class="fa fa-print me-1"></i>Cetak Surat SP</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    {{-- BIODATA SISWA --}}
    <div class="col-lg-4 mb-4">
        <div class="card card-body text-center p-4">
            <div class="avatar avatar-xl bg-soft-primary text-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center fs-2 fw-bold" style="width: 80px; height: 80px;">
                {{ strtoupper(substr($siswa->nama_siswa, 0, 1)) }}
            </div>
            <h4 class="fw-bold mb-1">{{ $siswa->nama_siswa }}</h4>
            <div class="text-muted small mb-3">NISN: {{ $siswa->nis_nisn }} | Kelas: {{ $siswa->kelas->nama_kelas ?? '-' }}</div>

            <div class="bg-light p-3 rounded mb-3">
                <div class="small text-muted mb-1">Total Akumulasi Poin</div>
                <div class="fs-2 fw-bold text-danger">{{ $totalPoin }} Poin</div>
            </div>

            <div class="text-start small">
                <div class="mb-2"><strong>Wali Kelas:</strong> {{ $siswa->kelas->waliKelas->nama_lengkap ?? '-' }}</div>
                <div class="mb-2"><strong>Orang Tua:</strong> {{ $siswa->nama_orang_tua ?? '-' }}</div>
                <div class="mb-2"><strong>No HP Ortu:</strong> {{ $siswa->no_hp_orang_tua ?? '-' }}</div>
                <div><strong>Status Sanksi:</strong>
                    @if($sanksiBerlaku)
                        <span class="badge bg-danger ms-1">{{ $sanksiBerlaku->tindakan }}</span>
                    @else
                        <span class="badge bg-success ms-1">Normal / Bebas SP</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- RIWAYAT TABLE --}}
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-list me-2"></i>Rincian Pelanggaran yang Dicatat</h5></div>
            <div class="d-md-none p-2">
                @forelse($riwayatPelanggaran as $r)
                <div class="m-card">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="min-w-0">
                            <div class="fw-semibold">{{ $r->jenisPelanggaran->uraian_pelanggaran ?? '-' }}</div>
                            <small class="text-muted">{{ $r->jenisPelanggaran->kategori->nama_kategori ?? '' }}</small>
                        </div>
                        <span class="badge bg-danger rounded-pill px-3 py-2">+{{ $r->poin }}</span>
                    </div>
                    <div class="m-detail">
                        <div><i class="fa fa-calendar me-1"></i>{{ $r->tanggal ? $r->tanggal->format('d/m/Y') : '-' }}</div>
                        @if($r->catatan)<div class="fst-italic">"{{ $r->catatan }}"</div>@endif
                        @if($r->tindak_lanjut)<div><i class="fa fa-info-circle me-1"></i>{{ $r->tindak_lanjut }}</div>@endif
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-5">Siswa ini bersih dari catatan pelanggaran.</div>
                @endforelse
            </div>
            <div class="card-body p-0 d-none d-md-block">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th width="50">#</th>
                                <th>Tanggal</th>
                                <th>Jenis Pelanggaran</th>
                                <th class="text-center">Poin</th>
                                <th>Tindak Lanjut</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatPelanggaran as $index => $r)
                            <tr>
                                <td class="text-center text-muted small">{{ $index + 1 }}</td>
                                <td>{{ $r->tanggal ? $r->tanggal->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <span class="badge bg-info text-white">{{ $r->jenisPelanggaran->kategori->nama_kategori ?? '' }}</span>
                                    <div class="fw-semibold mt-1">{{ $r->jenisPelanggaran->uraian_pelanggaran ?? '-' }}</div>
                                    @if($r->catatan)
                                        <small class="text-muted fst-italic">"{{ $r->catatan }}"</small>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-danger rounded-pill">+{{ $r->poin }}</span>
                                </td>
                                <td class="small text-muted">{{ $r->tindak_lanjut ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted"><i class="fa fa-smile-o fa-3x mb-3 text-success d-block"></i><p>Siswa ini bersih dari catatan pelanggaran.</p></div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
