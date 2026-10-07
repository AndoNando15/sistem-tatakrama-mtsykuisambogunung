@extends('layouts.admin')

@section('title', 'Master Kategori Pelanggaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Master Kategori Pelanggaran</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Kategori Pelanggaran</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.kategori-pelanggaran.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa fa-plus me-1"></i> Tambah Kategori Baru
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- FILTER --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('admin.kategori-pelanggaran.index') }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-8">
                    <label class="form-label small fw-semibold text-muted mb-1">Cari Kategori</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa fa-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama kategori atau kode..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter me-1"></i> Filter</button>
                        <a href="{{ route('admin.kategori-pelanggaran.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="fa fa-refresh"></i></a>
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
                <i class="fe fe-alert-triangle fs-5"></i>
            </div>
            <h5 class="card-title mb-0 fw-bold text-dark">Daftar Kategori Pelanggaran</h5>
        </div>
        <span class="badge bg-primary rounded-pill px-3 py-2">Total: {{ $kategori->total() }} Kategori</span>
    </div>
    <div class="card-body p-0">
        {{-- TAMPILAN MOBILE: daftar kartu --}}
        <div class="d-md-none">
            @forelse($kategori as $index => $kat)
                <div class="m-card">
                    <div class="d-flex align-items-start gap-2">
                        <div class="avatar-initial flex-shrink-0"><i class="fa fa-folder-o"></i></div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-bold text-dark text-break">{{ $kat->nama_kategori }}</div>
                            <div class="small text-muted font-monospace">{{ $kat->kode }}</div>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                <span class="badge badge-soft-info text-capitalize">{{ $kat->sifat_akumulasi }}</span>
                                <span class="badge badge-soft-primary">{{ $kat->jenis_pelanggaran_count ?? 0 }} Jenis</span>
                            </div>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <a href="{{ route('admin.kategori-pelanggaran.edit', $kat->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Kategori"><i class="fa fa-pencil"></i></a>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $kat->id }}" data-nama="{{ $kat->nama_kategori }}" title="Hapus Kategori"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5 px-3">
                    <i class="fe fe-folder fa-3x mb-3 opacity-50 d-block"></i>
                    <h6 class="fw-bold mb-1">Data Kategori Tidak Ditemukan</h6>
                    <p class="small mb-0">Belum ada kategori pelanggaran yang didaftarkan.</p>
                </div>
            @endforelse
        </div>

        {{-- TAMPILAN DESKTOP: tabel --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Kode Kategori</th>
                        <th>Nama Kategori</th>
                        <th>Sifat Akumulasi</th>
                        <th class="text-center">Jumlah Jenis Pelanggaran</th>
                        <th class="text-center" width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategori as $index => $kat)
                    <tr>
                        <td class="text-center text-muted small fw-semibold">{{ $kategori->firstItem() + $index }}</td>
                        <td>
                            <span class="badge badge-soft-dark font-monospace px-2.5 py-1 fs-6">
                                <i class="fa fa-folder-o me-1"></i>{{ $kat->kode }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-6">{{ $kat->nama_kategori }}</div>
                        </td>
                        <td>
                            <span class="badge badge-soft-info text-capitalize px-2.5 py-1">
                                <i class="fa fa-line-chart me-1"></i>{{ $kat->sifat_akumulasi }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge badge-soft-primary px-3 py-1.5 fw-bold fs-6">
                                <i class="fa fa-list-ol me-1"></i>{{ $kat->jenis_pelanggaran_count ?? 0 }} Jenis
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.kategori-pelanggaran.edit', $kat->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Kategori">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $kat->id }}" data-nama="{{ $kat->nama_kategori }}" title="Hapus Kategori">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted py-3">
                                <i class="fe fe-folder fa-3x mb-3 text-muted opacity-50 d-block"></i>
                                <h6 class="fw-bold mb-1">Data Kategori Tidak Ditemukan</h6>
                                <p class="small mb-0">Belum ada kategori pelanggaran yang didaftarkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.partials.pagination-footer', ['paginator' => $kategori, 'noun' => 'kategori'])
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i>Hapus Kategori Pelanggaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-1">Apakah Anda yakin ingin menghapus kategori:</p>
                <p class="fw-bold fs-5 text-danger" id="modalNamaKat">—</p>
                <div class="alert alert-warning mb-0"><i class="fa fa-info-circle me-2"></i>Kategori yang memiliki jenis pelanggaran tidak dapat dihapus.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="formHapus" method="POST" action="">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash me-1"></i>Ya, Hapus</button>
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
        $('#modalNamaKat').text($(this).data('nama'));
        $('#formHapus').attr('action', '{{ url("admin/kategori-pelanggaran") }}/' + $(this).data('id'));
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush
