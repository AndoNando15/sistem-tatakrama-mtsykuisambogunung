@extends('layouts.admin')

@section('title', 'Master Tahun Ajaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Master Tahun Ajaran</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Master Tahun Ajaran</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.tahun-ajaran.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa fa-plus me-1"></i> Tambah Tahun Ajaran
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- FILTER --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('admin.tahun-ajaran.index') }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small fw-semibold text-muted mb-1">Cari Tahun</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa fa-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Cari tahun..." value="{{ request('search') }}">
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
                        <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="fa fa-refresh"></i></a>
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
                <i class="fe fe-calendar fs-5"></i>
            </div>
            <h5 class="card-title mb-0 fw-bold text-dark">Daftar Tahun Ajaran</h5>
        </div>
        <span class="badge bg-primary rounded-pill px-3 py-2">Total: {{ $tahunAjaran->total() }} Record</span>
    </div>
    <div class="card-body p-0">
        {{-- TAMPILAN MOBILE: daftar kartu --}}
        <div class="d-md-none">
            @forelse($tahunAjaran as $index => $ta)
                <div class="m-card">
                    <div class="d-flex align-items-start gap-2">
                        <div class="avatar-initial flex-shrink-0"><i class="fa fa-calendar"></i></div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-bold text-dark">{{ $ta->tahun }}</div>
                            <div class="small text-muted">Semester {{ ucfirst($ta->semester) }}</div>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                <span class="badge {{ ($ta->is_active ?? true) ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                    {{ ($ta->is_active ?? true) ? 'Aktif Berjalan' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <a href="{{ route('admin.tahun-ajaran.edit', $ta->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Tahun Ajaran"><i class="fa fa-pencil"></i></a>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $ta->id }}" data-nama="{{ $ta->tahun }} {{ $ta->semester }}" title="Nonaktifkan"><i class="fa fa-ban"></i></button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5 px-3">
                    <i class="fe fe-calendar fa-3x mb-3 opacity-50 d-block"></i>
                    <h6 class="fw-bold mb-1">Data Tahun Ajaran Tidak Ditemukan</h6>
                    <p class="small mb-0">Belum ada tahun ajaran yang didaftarkan.</p>
                </div>
            @endforelse
        </div>

        {{-- TAMPILAN DESKTOP: tabel --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tahunAjaran as $index => $ta)
                    <tr>
                        <td class="text-center text-muted small fw-semibold">{{ $tahunAjaran->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-initial avatar-initial-sm">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <div class="fw-bold text-dark fs-6">{{ $ta->tahun }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-soft-info px-2.5 py-1 fw-semibold">
                                <i class="fa fa-clock-o me-1"></i>Semester {{ ucfirst($ta->semester) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($ta->is_active ?? true)
                                <span class="badge badge-soft-success px-2.5 py-1">
                                    <i class="fa fa-check me-1"></i>Aktif Berjalan
                                </span>
                            @else
                                <span class="badge badge-soft-danger px-2.5 py-1">
                                    <i class="fa fa-ban me-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.tahun-ajaran.edit', $ta->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Tahun Ajaran">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $ta->id }}" data-nama="{{ $ta->tahun }} {{ $ta->semester }}" title="Nonaktifkan">
                                    <i class="fa fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted py-3">
                                <i class="fe fe-calendar fa-3x mb-3 text-muted opacity-50 d-block"></i>
                                <h6 class="fw-bold mb-1">Data Tahun Ajaran Tidak Ditemukan</h6>
                                <p class="small mb-0">Belum ada tahun ajaran yang didaftarkan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.partials.pagination-footer', ['paginator' => $tahunAjaran, 'noun' => 'record'])
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i>Nonaktifkan Tahun Ajaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-1">Anda akan menonaktifkan tahun ajaran:</p>
                <p class="fw-bold fs-5 text-danger" id="modalNamaTA">—</p>
                <div class="alert alert-warning mb-0"><i class="fa fa-info-circle me-2"></i>Data yang berhubungan tidak akan dihapus.</div>
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
        $('#modalNamaTA').text($(this).data('nama'));
        $('#formHapus').attr('action', '{{ url("admin/tahun_ajaran") }}/' + $(this).data('id'));
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush
