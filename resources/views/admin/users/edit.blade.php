@extends('layouts.admin')

@section('title', 'Edit User')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Edit User</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Master User</a></li>
                <li class="breadcrumb-item active">Edit: {{ $user->nama_lengkap ?? $user->name }}</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-user-check me-2"></i>Form Edit User</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST" id="formEdit">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $user->nama_lengkap ?? $user->name) }}" required>
                            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                            <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>
                            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email (Opsional)</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nip_nik" class="form-label fw-semibold">NIP (Opsional)</label>
                            <input type="text" id="nip_nik" name="nip_nik" class="form-control @error('nip_nik') is-invalid @enderror" value="{{ old('nip_nik', $user->nip_nik) }}">
                            @error('nip_nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan" class="form-label fw-semibold">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $user->jabatan) }}">
                            @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nik" class="form-label fw-semibold">NIK (Opsional)</label>
                            <input type="text" id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik', $user->nik) }}">
                            @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nuptk" class="form-label fw-semibold">NUPTK/PagelD</label>
                            <input type="text" id="nuptk" name="nuptk" class="form-control @error('nuptk') is-invalid @enderror" value="{{ old('nuptk', $user->nuptk) }}">
                            @error('nuptk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $user->tempat_lahir) }}">
                            @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $user->tanggal_lahir?->format('Y-m-d')) }}">
                            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin) === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="pendidikan_terakhir" class="form-label fw-semibold">Pendidikan Terakhir</label>
                            <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-control @error('pendidikan_terakhir') is-invalid @enderror" value="{{ old('pendidikan_terakhir', $user->pendidikan_terakhir) }}">
                            @error('pendidikan_terakhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan_pokok" class="form-label fw-semibold">Jabatan Pokok</label>
                            <input type="text" id="jabatan_pokok" name="jabatan_pokok" class="form-control @error('jabatan_pokok') is-invalid @enderror" value="{{ old('jabatan_pokok', $user->jabatan_pokok) }}">
                            @error('jabatan_pokok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan_tambahan" class="form-label fw-semibold">Jabatan Tambahan</label>
                            <input type="text" id="jabatan_tambahan" name="jabatan_tambahan" class="form-control @error('jabatan_tambahan') is-invalid @enderror" value="{{ old('jabatan_tambahan', $user->jabatan_tambahan) }}">
                            @error('jabatan_tambahan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="alamat" class="form-label fw-semibold">Alamat Sesuai E-KTP</label>
                            <textarea id="alamat" name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $user->alamat) }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_mulai_tugas" class="form-label fw-semibold">Tanggal Mulai Tugas</label>
                            <input type="date" id="tanggal_mulai_tugas" name="tanggal_mulai_tugas" class="form-control @error('tanggal_mulai_tugas') is-invalid @enderror" value="{{ old('tanggal_mulai_tugas', $user->tanggal_mulai_tugas?->format('Y-m-d')) }}">
                            @error('tanggal_mulai_tugas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label fw-semibold">No. WA Aktif (Opsional)</label>
                            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $user->no_hp) }}">
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        @include('admin.partials.status-field', ['active' => $user->is_active, 'class' => 'col-md-6'])
                    </div>

                    <div class="alert alert-light border my-4">
                        <small class="text-muted"><i class="fa fa-info-circle me-1"></i>Kosongkan password jika tidak ingin mengganti password user ini.</small>
                        <div class="row g-3 mt-1">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Password Baru</label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                    </div>

                    @include('admin.users.partials.role-picker', ['roleList' => $roleList, 'selected' => old('roles', $userRoleIds)])

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-success" id="btnUpdate"><i class="fa fa-save me-1"></i>Perbarui User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#formEdit').on('submit', function(){ $('#btnUpdate').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...'); });
</script>
@endpush
