@extends('layouts.admin')

@section('title', 'Master Jenis Pelanggaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Master Jenis Pelanggaran</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Jenis Pelanggaran</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.jenis-pelanggaran.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa fa-plus me-1"></i> Tambah Jenis Pelanggaran
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- FILTER --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('admin.jenis-pelanggaran.index') }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-muted mb-1">Cari Pelanggaran</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa fa-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari uraian atau kode..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted mb-1">Kategori</label>
                    <select name="kategori_id" class="form-select">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                [{{ $kat->kode }}] {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter me-1"></i> Filter</button>
                        <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="fa fa-refresh"></i></a>
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
                <i class="fe fe-list fs-5"></i>
            </div>
            <h5 class="card-title mb-0 fw-bold text-dark">Daftar Jenis Pelanggaran</h5>
        </div>
        <span class="badge bg-primary rounded-pill px-3 py-2">Total: {{ $jenisPelanggaran->total() }} Item</span>
    </div>
    <div class="card-body p-0">
        {{-- TAMPILAN MOBILE: daftar kartu --}}
        <div class="d-md-none">
            @forelse($jenisPelanggaran as $index => $j)
                <div class="m-card">
                    <div class="d-flex align-items-start gap-2">
                        <div class="flex-grow-1 min-w-0">
                            <div class="small text-muted font-monospace">{{ $j->kode_pelanggaran ?? '-' }}</div>
                            <div class="fw-bold text-dark text-break">{{ $j->uraian_pelanggaran }}</div>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                <span class="badge badge-soft-danger rounded-pill">+{{ $j->poin }} Poin</span>
                                @if($j->kategori)
                                    <span class="badge badge-soft-info">[{{ $j->kategori->kode }}] {{ $j->kategori->nama_kategori }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <a href="{{ route('admin.jenis-pelanggaran.edit', $j->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Item"><i class="fa fa-pencil"></i></a>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $j->id }}" data-nama="{{ $j->uraian_pelanggaran }}" title="Nonaktifkan Item"><i class="fa fa-ban"></i></button>
                        </div>
                    </div>
                    @if(!empty($j->sanksi_default))
                        <dl class="m-detail mb-0">
                            <dt>Sanksi Default</dt><dd>{{ $j->sanksi_default }}</dd>
                        </dl>
                    @endif
                </div>
            @empty
                <div class="text-center text-muted py-5 px-3">
                    <i class="fe fe-list fa-3x mb-3 opacity-50 d-block"></i>
                    <h6 class="fw-bold mb-1">Data Pelanggaran Tidak Ditemukan</h6>
                    <p class="small mb-0">Belum ada jenis pelanggaran yang ditambahkan.</p>
                </div>
            @endforelse
        </div>

        {{-- TAMPILAN DESKTOP: tabel --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th>Uraian Pelanggaran</th>
                        <th class="text-center">Poin</th>
                        <th>Sanksi Default</th>
                        <th class="text-center" width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jenisPelanggaran as $index => $j)
                    <tr>
                        <td class="text-center text-muted small fw-semibold">{{ $jenisPelanggaran->firstItem() + $index }}</td>
                        <td>
                            <span class="badge badge-soft-dark font-monospace px-2 py-1">
                                {{ $j->kode_pelanggaran ?? '-' }}
                            </span>
                        </td>
                        <td>
                            @if($j->kategori)
                                <span class="badge badge-soft-info fw-semibold px-2.5 py-1">
                                    <i class="fa fa-tag me-1"></i>[{{ $j->kategori->kode }}] {{ $j->kategori->nama_kategori }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-6">{{ $j->uraian_pelanggaran }}</div>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-soft-danger rounded-pill px-3 py-1.5 fs-6 fw-bold">
                                +{{ $j->poin }} Poin
                            </span>
                        </td>
                        <td>
                            @if(!empty($j->sanksi_default))
                                <span class="text-secondary small">
                                    <i class="fa fa-gavel me-1 text-muted"></i>{{ $j->sanksi_default }}
                                </span>
                            @else
                                <span class="text-muted small fst-italic">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.jenis-pelanggaran.edit', $j->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Item">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $j->id }}" data-nama="{{ $j->uraian_pelanggaran }}" title="Nonaktifkan Item">
                                    <i class="fa fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted py-3">
                                <i class="fe fe-list fa-3x mb-3 text-muted opacity-50 d-block"></i>
                                <h6 class="fw-bold mb-1">Data Pelanggaran Tidak Ditemukan</h6>
                                <p class="small mb-0">Belum ada jenis pelanggaran yang ditambahkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.partials.pagination-footer', ['paginator' => $jenisPelanggaran, 'noun' => 'item'])
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i>Nonaktifkan Jenis Pelanggaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-1">Anda akan menonaktifkan jenis pelanggaran:</p>
                <p class="fw-bold fs-5 text-danger" id="modalNamaJenis">—</p>
                <div class="alert alert-warning mb-0"><i class="fa fa-info-circle me-2"></i>Riwayat pelanggaran siswa yang sudah dicatat sebelumnya tidak akan terpengaruh.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="formHapus" method="POST" action="">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-ban me-1"></i>Ya, Nonaktifkan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $(document).on('click', '.btn-hapus', function () {
        $('#modalNamaJenis').text($(this).data('nama'));
        $('#formHapus').attr('action', '{{ url("admin/jenis-pelanggaran") }}/' + $(this).data('id'));
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush
