@extends('layouts.admin')

@section('title', 'Master Guru & User')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Master Guru & User</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Master Guru & User</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa fa-plus me-1"></i> Tambah User Baru
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- FILTER --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('admin.users.index') }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-semibold text-muted mb-1">Cari User</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa fa-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Nama, username, NIK, NUPTK, jabatan..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">Role</label>
                    <select name="role_id" class="form-select">
                        <option value="">-- Semua Role --</option>
                        @foreach($roleList as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted mb-1">Status</label>
                    <select name="status" class="form-select">
                        <option value="">-- Semua --</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter me-1"></i> Filter</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="fa fa-refresh"></i></a>
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
                <i class="fe fe-user-check fs-5"></i>
            </div>
            <h5 class="card-title mb-0 fw-bold text-dark">Data Guru dan User</h5>
        </div>
        <span class="badge bg-primary rounded-pill px-3 py-2">Total: {{ $users->total() }} User</span>
    </div>
    <div class="card-body p-0">
        {{-- TAMPILAN MOBILE: daftar kartu --}}
        <div class="d-md-none">
            @forelse($users as $index => $u)
                <div class="m-card">
                    <div class="d-flex align-items-start gap-2">
                        <div class="avatar-initial flex-shrink-0">{{ strtoupper(substr($u->nama_lengkap ?? $u->name, 0, 1)) }}</div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-bold text-dark text-break">{{ $u->nama_lengkap ?? $u->name }}</div>
                            <div class="small text-muted font-monospace">@ {{ $u->username }}</div>
                            <div class="d-flex flex-wrap gap-1 mt-1">
                                <span class="badge {{ ($u->is_active ?? true) ? 'badge-soft-success' : 'badge-soft-danger' }}">
                                    {{ ($u->is_active ?? true) ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                @forelse($u->roles as $role)
                                    <span class="badge badge-soft-info">{{ $role->label }}</span>
                                @empty
                                    <span class="badge badge-soft-dark fst-italic">Tanpa Role</span>
                                @endforelse
                            </div>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-outline-primary" title="Edit User"><i class="fa fa-pencil"></i></a>
                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $u->id }}" data-nama="{{ $u->nama_lengkap ?? $u->name }}" title="Nonaktifkan User"><i class="fa fa-ban"></i></button>
                        </div>
                    </div>
                    <dl class="m-detail mb-0">
                        @foreach([
                            'Jabatan' => $u->jabatan,
                            'NIK' => $u->nik,
                            'NUPTK/PagelD' => $u->nuptk,
                            'Tempat, Tanggal Lahir' => trim(($u->tempat_lahir ?? '') . ($u->tanggal_lahir ? ', ' . $u->tanggal_lahir->format('d/m/Y') : '')),
                            'Jenis Kelamin' => $u->jenis_kelamin,
                            'Pendidikan Terakhir' => $u->pendidikan_terakhir,
                            'Jabatan Pokok' => $u->jabatan_pokok,
                            'Jabatan Tambahan' => $u->jabatan_tambahan,
                            'Alamat Sesuai E-KTP' => $u->alamat,
                            'Tanggal Mulai Tugas' => $u->tanggal_mulai_tugas?->format('d/m/Y'),
                            'No. WA Aktif' => $u->no_hp,
                        ] as $label => $value)
                            @if(filled($value))
                                <dt>{{ $label }}</dt><dd>{{ $value }}</dd>
                            @endif
                        @endforeach
                    </dl>
                </div>
            @empty
                <div class="text-center text-muted py-5 px-3">
                    <i class="fe fe-user-x fa-3x mb-3 opacity-50 d-block"></i>
                    <h6 class="fw-bold mb-1">Data User Tidak Ditemukan</h6>
                    <p class="small mb-0">Belum ada user yang terdaftar dalam sistem.</p>
                </div>
            @endforelse
        </div>

        {{-- TAMPILAN DESKTOP: tabel --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-hover table-sm align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>NIK</th>
                        <th>NUPTK/PagelD</th>
                        <th>Tempat, Tanggal Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Pendidikan Terakhir</th>
                        <th>Jabatan Pokok</th>
                        <th>Jabatan Tambahan</th>
                        <th>Alamat Sesuai E-KTP</th>
                        <th>Tanggal Mulai Tugas</th>
                        <th>No. WA Aktif</th>
                        <th>Username</th>
                        <th>Hak Akses (Role)</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $u)
                    <tr>
                        <td class="text-center text-muted small fw-semibold">{{ $users->firstItem() + $index }}</td>
                        <td>
                            <span class="fw-bold text-dark">{{ $u->nama_lengkap ?? $u->name }}</span>
                        </td>
                        <td>{{ $u->jabatan ?: '-' }}</td>
                        <td class="font-monospace">{{ $u->nik ?: '-' }}</td>
                        <td class="font-monospace">{{ $u->nuptk ?: '-' }}</td>
                        <td class="text-nowrap">
                            {{ trim(($u->tempat_lahir ?? '') . ($u->tanggal_lahir ? ', ' . $u->tanggal_lahir->format('d/m/Y') : '')) ?: '-' }}
                        </td>
                        <td>{{ $u->jenis_kelamin ?: '-' }}</td>
                        <td>{{ $u->pendidikan_terakhir ?: '-' }}</td>
                        <td>{{ $u->jabatan_pokok ?: '-' }}</td>
                        <td>{{ $u->jabatan_tambahan ?: '-' }}</td>
                        <td>{{ $u->alamat ?: '-' }}</td>
                        <td class="text-nowrap">{{ $u->tanggal_mulai_tugas?->format('d/m/Y') ?? '-' }}</td>
                        <td class="text-nowrap">{{ $u->no_hp ?: '-' }}</td>
                        <td>{{ $u->username }}</td>
                        <td>
                            @forelse($u->roles as $role)
                                @php
                                    $roleName = strtolower($role->nama_role);
                                    $badgeClass = 'badge-soft-info';
                                    if(str_contains($roleName, 'admin')) $badgeClass = 'badge-soft-success';
                                    elseif(str_contains($roleName, 'bk') || str_contains($roleName, 'konseling')) $badgeClass = 'badge-soft-primary';
                                    elseif(str_contains($roleName, 'wali')) $badgeClass = 'badge-soft-warning';
                                @endphp
                                <span class="badge {{ $badgeClass }} fw-semibold me-1 px-2.5 py-1">
                                    <i class="fa fa-user-shield me-1"></i>{{ $role->label }}
                                </span>
                            @empty
                                <span class="badge badge-soft-dark fst-italic">Tanpa Role</span>
                            @endforelse
                        </td>
                        <td class="text-center">
                            @if($u->is_active ?? true)
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
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-outline-primary" title="Edit User">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $u->id }}" data-nama="{{ $u->nama_lengkap ?? $u->name }}" title="Nonaktifkan User">
                                    <i class="fa fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="17" class="text-center py-5">
                            <div class="text-muted py-3">
                                <i class="fe fe-user-x fa-3x mb-3 text-muted opacity-50 d-block"></i>
                                <h6 class="fw-bold mb-1">Data User Tidak Ditemukan</h6>
                                <p class="small mb-0">Belum ada user yang terdaftar dalam sistem.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @include('layouts.partials.pagination-footer', ['paginator' => $users, 'noun' => 'user'])
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i>Nonaktifkan User</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-1">Anda akan menonaktifkan user:</p>
                <p class="fw-bold fs-5 text-danger" id="modalNamaUser">—</p>
                <div class="alert alert-warning mb-0"><i class="fa fa-info-circle me-2"></i>User ini tidak akan dapat login lagi ke dalam sistem.</div>
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
        $('#modalNamaUser').text($(this).data('nama'));
        $('#formHapus').attr('action', '{{ url("admin/users") }}/' + $(this).data('id'));
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush
