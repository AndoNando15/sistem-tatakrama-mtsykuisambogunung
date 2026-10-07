@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Profil Saya</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('guru.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profil</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8 col-xl-7">

        {{-- PROFILE HEADER CARD --}}
        <div class="profile-hero-card mb-4">
            <div class="profile-hero-bg"></div>
            <div class="profile-hero-body">
                <div class="profile-hero-avatar">
                    {{ strtoupper(substr($user->nama_lengkap ?? $user->name, 0, 1)) }}
                </div>
                <div class="profile-hero-info">
                    <h4 class="profile-hero-name">{{ $user->nama_lengkap ?? $user->name }}</h4>
                    <p class="profile-hero-sub">
                        @foreach($user->roles as $r)
                            <span class="badge bg-white bg-opacity-25 me-1">{{ $r->label }}</span>
                        @endforeach
                    </p>
                    @if($user->nip_nik)
                        <span class="profile-hero-nip"><i class="fa fa-id-card-o me-1"></i>{{ $user->nip_nik }}</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- FORM EDIT PROFIL --}}
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0"><i class="fa fa-pencil-square-o me-2 text-primary"></i>Edit Informasi Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update') }}" method="POST" id="formProfile">
                    @csrf
                    @method('PUT')

                    {{-- SECTION: DATA PRIBADI --}}
                    <div class="form-section-label"><i class="fa fa-user me-2"></i>Data Pribadi</div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="nama_lengkap" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" id="nama_lengkap" name="nama_lengkap"
                                   class="form-control @error('nama_lengkap') is-invalid @enderror"
                                   value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>
                            @error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nip_nik" class="form-label fw-semibold">NIP / NIK</label>
                            <input type="text" id="nip_nik" name="nip_nik"
                                   class="form-control @error('nip_nik') is-invalid @enderror"
                                   value="{{ old('nip_nik', $user->nip_nik) }}"
                                   placeholder="Opsional">
                            @error('nip_nik')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input type="email" id="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="Opsional">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="no_hp" class="form-label fw-semibold">No. HP / WA</label>
                            <input type="text" id="no_hp" name="no_hp"
                                   class="form-control @error('no_hp') is-invalid @enderror"
                                   value="{{ old('no_hp', $user->no_hp) }}"
                                   placeholder="Contoh: 08123456789">
                            @error('no_hp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    {{-- SECTION: AKUN --}}
                    <div class="form-section-label"><i class="fa fa-lock me-2"></i>Akun & Keamanan</div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="username" class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-at"></i></span>
                                <input type="text" id="username" name="username"
                                       class="form-control @error('username') is-invalid @enderror"
                                       value="{{ old('username', $user->username) }}" required>
                                @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info py-2 mb-3">
                        <i class="fa fa-info-circle me-1"></i>
                        Kosongkan kolom password jika tidak ingin mengubahnya.
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="current_password" class="form-label fw-semibold">Password Lama</label>
                            <input type="password" id="current_password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror"
                                   placeholder="••••••">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="password" class="form-label fw-semibold">Password Baru</label>
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Minimal 6 karakter">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="password_confirmation" class="form-label fw-semibold">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('guru.dashboard') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-arrow-left me-1"></i>Kembali
                        </a>
                        <button type="submit" class="btn btn-primary px-4" id="btnSimpan">
                            <i class="fa fa-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

        {{-- LOGOUT CARD --}}
        <div class="card mt-3 border-0">
            <div class="card-body py-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="fa fa-sign-out me-2"></i>Keluar dari Akun
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection

@push('styles')
<style>
/* ── PROFILE HERO CARD ── */
.profile-hero-card {
    border-radius: 16px;
    overflow: hidden;
    position: relative;
    box-shadow: 0 4px 24px rgba(27, 110, 61, 0.2);
}
.profile-hero-bg {
    height: 100px;
    background: linear-gradient(135deg, #1b6e3d 0%, #2d8f4e 50%, #3aab5f 100%);
}
.profile-hero-body {
    display: flex;
    align-items: flex-end;
    gap: 18px;
    padding: 0 24px 20px;
    margin-top: -40px;
    position: relative;
}
.profile-hero-avatar {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #1b6e3d, #2d8f4e);
    border: 4px solid #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 700;
    color: #fff;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.profile-hero-info {
    padding-bottom: 4px;
}
.profile-hero-name {
    font-size: 20px;
    font-weight: 700;
    color: #1a3c2a;
    margin: 0;
    line-height: 1.3;
}
.profile-hero-sub {
    margin: 4px 0 0;
}
.profile-hero-sub .badge {
    background: #1b6e3d !important;
    color: #fff;
    font-weight: 500;
    font-size: 11px;
}
.profile-hero-nip {
    font-size: 12px;
    color: #6c757d;
}

/* ── FORM SECTION LABEL ── */
.form-section-label {
    font-size: 14px;
    font-weight: 700;
    color: #1b6e3d;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 8px;
    margin-bottom: 16px;
}

/* ── Mobile profile tweaks ── */
@media (max-width: 768px) {
    .profile-hero-body {
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding: 0 16px 16px;
        margin-top: -44px;
    }
    .profile-hero-name { font-size: 18px; }
}
</style>
@endpush

@push('scripts')
<script>
$('#formProfile').on('submit', function () {
    $('#btnSimpan').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...');
});
</script>
@endpush
