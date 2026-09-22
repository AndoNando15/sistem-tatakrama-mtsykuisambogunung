@extends('layouts.admin')

@section('title', 'Master Mata Pelajaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Master Mata Pelajaran</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Mata Pelajaran</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.mata-pelajaran.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa fa-plus me-1"></i> Tambah Mata Pelajaran
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- FILTER --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('admin.mata-pelajaran.index') }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-muted mb-1">Cari Mata Pelajaran</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa fa-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari nama atau kode..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">Status</label>
                    <select name="status" class="form-select">
                        <option value="">-- Semua Status --</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter me-1"></i> Filter</button>
                        <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="fa fa-refresh"></i></a>
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
                <i class="fe fe-book-open fs-5"></i>
            </div>
            <h5 class="card-title mb-0 fw-bold text-dark">Daftar Mata Pelajaran</h5>
        </div>
        <span class="badge bg-primary rounded-pill px-3 py-2">Total: {{ $mataPelajaran->total() }} Mapel</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Kode Mapel</th>
                        <th>Nama Mata Pelajaran</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mataPelajaran as $index => $mp)
                    <tr>
                        <td class="text-center text-muted small fw-semibold">{{ $mataPelajaran->firstItem() + $index }}</td>
                        <td>
                            <span class="badge badge-soft-dark font-monospace px-2.5 py-1 fs-6">
                                <i class="fa fa-bookmark-o me-1"></i>{{ $mp->kode_mapel ?? '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-initial avatar-initial-sm">
                                    <i class="fe fe-book"></i>
                                </div>
                                <div class="fw-bold text-dark fs-6">{{ $mp->nama_mapel }}</div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($mp->is_active ?? true)
                                <span class="badge badge-soft-success px-2.5 py-1">
                                    <i class="fa fa-check me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge badge-soft-danger px-2.5 py-1">
                                    <i class="fa fa-ban me-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.mata-pelajaran.edit', $mp->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Mapel">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $mp->id }}" data-nama="{{ $mp->nama_mapel }}" title="Nonaktifkan Mapel">
                                    <i class="fa fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted py-3">
                                <i class="fe fe-book fa-3x mb-3 text-muted opacity-50 d-block"></i>
                                <h6 class="fw-bold mb-1">Data Mapel Tidak Ditemukan</h6>
                                <p class="small mb-0">Belum ada mata pelajaran yang didaftarkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($mataPelajaran->hasPages())
    <div class="card-footer bg-white d-flex align-items-center justify-content-between py-3">
        <div class="text-muted small fw-medium">Menampilkan {{ $mataPelajaran->firstItem() }}–{{ $mataPelajaran->lastItem() }} dari <strong>{{ $mataPelajaran->total() }}</strong> mapel</div>
        <div>{{ $mataPelajaran->links() }}</div>
    </div>
    @endif
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i>Nonaktifkan Mata Pelajaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-1">Anda akan menonaktifkan mata pelajaran:</p>
                <p class="fw-bold fs-5 text-danger" id="modalNamaMP">—</p>
                <div class="alert alert-warning mb-0"><i class="fa fa-info-circle me-2"></i>Data terkait tidak akan dihapus.</div>
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
        $('#modalNamaMP').text($(this).data('nama'));
        $('#formHapus').attr('action', '{{ url("admin/mata-pelajaran") }}/' + $(this).data('id'));
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush
