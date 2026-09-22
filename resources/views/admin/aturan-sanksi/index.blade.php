@extends('layouts.admin')

@section('title', 'Master Aturan Sanksi')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Master Aturan Sanksi Kumulatif</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Aturan Sanksi</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.aturan-sanksi.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa fa-plus me-1"></i> Tambah Aturan Sanksi
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- TABEL --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <div class="d-flex align-items-center gap-2">
            <div class="badge bg-soft-success text-success p-2 rounded-circle">
                <i class="fe fe-book fs-5"></i>
            </div>
            <h5 class="card-title mb-0 fw-bold text-dark">Daftar Aturan Sanksi Kumulasi</h5>
        </div>
        <span class="badge bg-primary rounded-pill px-3 py-2">Total: {{ $aturan->total() }} Aturan</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Rentang Poin Pelanggaran</th>
                        <th>Tindakan / Sanksi Sekolah</th>
                        <th class="text-center">Nilai Sikap Maksimal</th>
                        <th class="text-center" width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($aturan as $index => $a)
                    <tr>
                        <td class="text-center text-muted small fw-semibold">{{ $aturan->firstItem() + $index }}</td>
                        <td>
                            <span class="badge badge-soft-danger fs-6 px-3 py-1.5 fw-bold">
                                <i class="fa fa-fire me-1"></i>{{ $a->min_poin }} – {{ $a->max_poin }} Poin
                            </span>
                        </td>
                        <td>
                            <div class="fw-bold text-dark fs-6">{{ $a->tindakan }}</div>
                        </td>
                        <td class="text-center">
                            @if($a->nilai_sikap)
                                <span class="badge badge-soft-dark fs-6 px-3 py-1 fw-bold">
                                    {{ strtoupper($a->nilai_sikap) }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.aturan-sanksi.edit', $a->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Aturan">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $a->id }}" data-nama="{{ $a->min_poin }} - {{ $a->max_poin }} poin" title="Hapus Aturan">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted py-3">
                                <i class="fe fe-book fa-3x mb-3 text-muted opacity-50 d-block"></i>
                                <h6 class="fw-bold mb-1">Data Aturan Sanksi Tidak Ditemukan</h6>
                                <p class="small mb-0">Belum ada aturan sanksi kumulatif yang dibuat.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($aturan->hasPages())
    <div class="card-footer bg-white d-flex align-items-center justify-content-between py-3">
        <div class="text-muted small fw-medium">Menampilkan {{ $aturan->firstItem() }}–{{ $aturan->lastItem() }} dari <strong>{{ $aturan->total() }}</strong> aturan</div>
        <div>{{ $aturan->links() }}</div>
    </div>
    @endif
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i>Hapus Aturan Sanksi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-1">Apakah Anda yakin ingin menghapus aturan sanksi:</p>
                <p class="fw-bold fs-5 text-danger" id="modalNamaAturan">—</p>
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
        $('#modalNamaAturan').text($(this).data('nama'));
        $('#formHapus').attr('action', '{{ url("admin/aturan-sanksi") }}/' + $(this).data('id'));
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush
