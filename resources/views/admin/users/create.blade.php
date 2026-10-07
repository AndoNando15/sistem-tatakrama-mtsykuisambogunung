@extends('layouts.admin')

@section('title', 'Tambah User')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Tambah User Baru</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Master User</a></li>
                <li class="breadcrumb-item active">Tambah</li>
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
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-user-plus me-2"></i>Form Tambah User</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" required>
                            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                            <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" required>
                            @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email (Opsional)</label>
                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nip_nik" class="form-label fw-semibold">NIP / NIK (Opsional)</label>
                            <input type="text" id="nip_nik" name="nip_nik" class="form-control @error('nip_nik') is-invalid @enderror" value="{{ old('nip_nik') }}">
                            @error('nip_nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label fw-semibold">No HP (Opsional)</label>
                            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}">
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password <span class="text-danger">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>

                    <hr class="my-4">
                    <label class="form-label fw-semibold d-block">Role Pengguna (Dapat Pilih Lebih Dari 1)</label>
                    <div class="row g-2">
                        @foreach($roleList as $role)
                        <div class="col-md-4 col-6">
                            <div class="form-check card-radio p-2 border rounded">
                                <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                                    {{ is_array(old('roles')) && in_array($role->id, old('roles')) ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium ms-1" for="role_{{ $role->id }}">
                                    {{ $role->label }}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary" id="btnSimpan"><i class="fa fa-save me-1"></i>Simpan User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#formTambah').on('submit', function(){ $('#btnSimpan').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...'); });
</script>
@endpush
