@extends('layouts.admin')

@section('title', 'Master Role')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Master Role</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Master Role</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary shadow-sm"><i class="fa fa-plus me-1"></i> Tambah Role</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="card-title mb-0 fw-bold text-dark">Daftar Role</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Nama Role</th>
                        <th>Kode</th>
                        <th>Keterangan</th>
                        <th class="text-center">Jumlah User</th>
                        <th class="text-center" width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($roles as $i => $role)
                    <tr>
                        <td class="text-center text-muted small fw-semibold">{{ $i + 1 }}</td>
                        <td class="fw-bold text-dark">{{ $role->label }}</td>
                        <td><span class="badge badge-soft-dark font-monospace">{{ $role->nama_role }}</span></td>
                        <td>{{ $role->keterangan ?: '-' }}</td>
                        <td class="text-center">{{ $role->users_count }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-sm btn-outline-primary" title="Edit Role"><i class="fa fa-pencil"></i></a>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $role->id }}" data-nama="{{ $role->label }}" title="Hapus Role"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center text-muted py-5">Belum ada role.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i>Hapus Role</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-1">Anda akan menghapus role:</p>
                <p class="fw-bold fs-5 text-danger" id="modalNamaRole">—</p>
                <div class="alert alert-warning mb-0"><i class="fa fa-info-circle me-2"></i>Role bawaan sistem atau yang masih dipakai user tidak dapat dihapus.</div>
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
$(document).on('click', '.btn-hapus', function () {
    $('#modalNamaRole').text($(this).data('nama'));
    $('#formHapus').attr('action', '{{ url("admin/roles") }}/' + $(this).data('id'));
    $('#modalHapus').modal('show');
});
</script>
@endpush
