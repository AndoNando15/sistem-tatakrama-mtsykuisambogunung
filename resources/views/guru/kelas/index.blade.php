@extends('layouts.admin')

@section('title', 'Kelas Saya')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Monitoring Kelas {{ $kelas->nama_kelas }}</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Kelas {{ $kelas->nama_kelas }}</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card mb-4 bg-primary text-white card-body p-4 rounded-3">
    <div class="d-flex align-items-center justify-content-between">
        <div>
            <h4 class="fw-bold mb-1">Kelas {{ $kelas->nama_kelas }}</h4>
            <div class="small opacity-75">Wali Kelas: {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</div>
        </div>
        <div class="text-end">
            <div class="fs-3 fw-bold">{{ $kelas->siswa->count() }} Siswa</div>
            <div class="small opacity-75">Terdaftar</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="card-title mb-0"><i class="fe fe-users me-2"></i>Daftar Siswa & Akumulasi Poin Kelas</h5>
    </div>
    <div class="card-body p-0">
        {{-- TAMPILAN MOBILE: daftar kartu --}}
        <div class="d-md-none">
            @forelse($kelas->siswa as $index => $s)
                @php
                    $poin = $s->total_poin ?? 0;
                    $ttl = collect([$s->tempat_lahir, $s->tanggal_lahir?->translatedFormat('d M Y')])->filter()->implode(', ');
                @endphp
                <div class="px-3 py-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div style="min-width:0">
                            <div class="fw-semibold text-break">{{ $index + 1 }}. {{ $s->nama_siswa }}</div>
                            <div class="small text-muted"><code>{{ $s->nis_nisn }}</code> · {{ $s->jenis_kelamin_label }}</div>
                        </div>
                        <span class="badge {{ $poin == 0 ? 'bg-success' : 'bg-danger' }} rounded-pill px-3 flex-shrink-0">{{ $poin }} Poin</span>
                    </div>
                    <div class="small mt-2 text-muted">
                        @if($ttl)<div>TTL: <span class="text-dark">{{ $ttl }}</span></div>@endif
                        <div>Ayah/Wali: <span class="text-dark">{{ $s->nama_orang_tua ?: '-' }}</span></div>
                        <div>Ibu: <span class="text-dark">{{ $s->nama_ibu ?: '-' }}</span></div>
                        @if($s->alamat)<div>Alamat: <span class="text-dark">{{ $s->alamat }}@if($s->rt) (RT {{ $s->rt }})@endif</span></div>@endif
                        <div>No. HP: <span class="text-dark">{{ $s->no_hp_orang_tua ?: '-' }}</span></div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-muted">Belum ada siswa di kelas ini.</div>
            @endforelse
        </div>

        {{-- TAMPILAN DESKTOP: tabel --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th>Orang Tua & No. HP</th>
                        <th class="text-center">Total Poin</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas->siswa as $index => $s)
                    @php $poin = $s->total_poin ?? 0; @endphp
                    <tr>
                        <td class="text-center text-muted small">{{ $index + 1 }}</td>
                        <td><code>{{ $s->nis_nisn }}</code></td>
                        <td class="fw-semibold">{{ $s->nama_siswa }}</td>
                        <td class="text-center">{{ $s->jenis_kelamin }}</td>
                        <td>
                            <div>{{ $s->nama_orang_tua ?? '-' }}</div>
                            <small class="text-muted">{{ $s->no_hp_orang_tua ?? '-' }}</small>
                        </td>
                        <td class="text-center">
                            @if($poin == 0)
                                <span class="badge bg-success rounded-pill px-3">0 Poin</span>
                            @else
                                <span class="badge bg-danger rounded-pill fs-6 px-3">{{ $poin }} Poin</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada siswa di kelas ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
