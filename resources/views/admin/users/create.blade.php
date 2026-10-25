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
                            <label for="nip_nik" class="form-label fw-semibold">NIP (Opsional)</label>
                            <input type="text" id="nip_nik" name="nip_nik" class="form-control @error('nip_nik') is-invalid @enderror" value="{{ old('nip_nik') }}">
                            @error('nip_nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan" class="form-label fw-semibold">Jabatan</label>
                            <input type="text" id="jabatan" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}">
                            @error('jabatan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nik" class="form-label fw-semibold">NIK (Opsional)</label>
                            <input type="text" id="nik" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}">
                            @error('nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nuptk" class="form-label fw-semibold">NUPTK/PagelD</label>
                            <input type="text" id="nuptk" name="nuptk" class="form-control @error('nuptk') is-invalid @enderror" value="{{ old('nuptk') }}">
                            @error('nuptk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir</label>
                            <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}">
                            @error('tempat_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label fw-semibold">Jenis Kelamin</label>
                            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki" {{ old('jenis_kelamin') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ old('jenis_kelamin') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('jenis_kelamin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="pendidikan_terakhir" class="form-label fw-semibold">Pendidikan Terakhir</label>
                            <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" class="form-control @error('pendidikan_terakhir') is-invalid @enderror" value="{{ old('pendidikan_terakhir') }}">
                            @error('pendidikan_terakhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan_pokok" class="form-label fw-semibold">Jabatan Pokok</label>
                            <input type="text" id="jabatan_pokok" name="jabatan_pokok" class="form-control @error('jabatan_pokok') is-invalid @enderror" value="{{ old('jabatan_pokok') }}">
                            @error('jabatan_pokok')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="jabatan_tambahan" class="form-label fw-semibold">Jabatan Tambahan</label>
                            <input type="text" id="jabatan_tambahan" name="jabatan_tambahan" class="form-control @error('jabatan_tambahan') is-invalid @enderror" value="{{ old('jabatan_tambahan') }}">
                            @error('jabatan_tambahan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="alamat" class="form-label fw-semibold">Alamat Sesuai E-KTP</label>
                            <textarea id="alamat" name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                            @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tanggal_mulai_tugas" class="form-label fw-semibold">Tanggal Mulai Tugas</label>
                            <input type="date" id="tanggal_mulai_tugas" name="tanggal_mulai_tugas" class="form-control @error('tanggal_mulai_tugas') is-invalid @enderror" value="{{ old('tanggal_mulai_tugas') }}">
                            @error('tanggal_mulai_tugas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label fw-semibold">No. WA Aktif (Opsional)</label>
                            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}">
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        @include('admin.partials.status-field', ['active' => true, 'class' => 'col-md-6'])
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
                    @include('admin.users.partials.role-picker', ['roleList' => $roleList, 'selected' => (array) old('roles', [])])

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
