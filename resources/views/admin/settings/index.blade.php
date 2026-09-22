@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Pengaturan Sistem & Identitas Madrasah</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Pengaturan Sistem</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-settings me-2"></i>Konfigurasi Profil Sekolah & Pejabat</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" id="formSettings">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="nama_sekolah" class="form-label fw-semibold">Nama Sekolah / Madrasah <span class="text-danger">*</span></label>
                            <input type="text" id="nama_sekolah" name="nama_sekolah" class="form-control @error('nama_sekolah') is-invalid @enderror" value="{{ old('nama_sekolah', $settings->nama_sekolah) }}" required>
                            @error('nama_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="npsn" class="form-label fw-semibold">NPSN</label>
                            <input type="text" id="npsn" name="npsn" class="form-control @error('npsn') is-invalid @enderror" value="{{ old('npsn', $settings->npsn) }}">
                            @error('npsn')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="alamat_sekolah" class="form-label fw-semibold">Alamat Lengkap Sekolah</label>
                            <textarea id="alamat_sekolah" name="alamat_sekolah" rows="2" class="form-control @error('alamat_sekolah') is-invalid @enderror">{{ old('alamat_sekolah', $settings->alamat_sekolah) }}</textarea>
                            @error('alamat_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-2"><i class="fa fa-user-circle me-2"></i>Data Kepala Sekolah / Pimpinan</h6>

                        <div class="col-md-6">
                            <label for="nama_kepala_sekolah" class="form-label fw-semibold">Nama Kepala Sekolah</label>
                            <input type="text" id="nama_kepala_sekolah" name="nama_kepala_sekolah" class="form-control @error('nama_kepala_sekolah') is-invalid @enderror" value="{{ old('nama_kepala_sekolah', $settings->nama_kepala_sekolah) }}">
                            @error('nama_kepala_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nip_kepala_sekolah" class="form-label fw-semibold">NIP Kepala Sekolah</label>
                            <input type="text" id="nip_kepala_sekolah" name="nip_kepala_sekolah" class="form-control @error('nip_kepala_sekolah') is-invalid @enderror" value="{{ old('nip_kepala_sekolah', $settings->nip_kepala_sekolah) }}">
                            @error('nip_kepala_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold text-primary mb-2"><i class="fa fa-user-md me-2"></i>Data Guru BK / Konselor</h6>

                        <div class="col-md-6">
                            <label for="nama_guru_bk" class="form-label fw-semibold">Nama Koordinator BK</label>
                            <input type="text" id="nama_guru_bk" name="nama_guru_bk" class="form-control @error('nama_guru_bk') is-invalid @enderror" value="{{ old('nama_guru_bk', $settings->nama_guru_bk) }}">
                            @error('nama_guru_bk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nip_guru_bk" class="form-label fw-semibold">NIP Koordinator BK</label>
                            <input type="text" id="nip_guru_bk" name="nip_guru_bk" class="form-control @error('nip_guru_bk') is-invalid @enderror" value="{{ old('nip_guru_bk', $settings->nip_guru_bk) }}">
                            @error('nip_guru_bk')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4" id="btnSimpan"><i class="fa fa-save me-1"></i>Simpan Pengaturan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#formSettings').on('submit', function(){ $('#btnSimpan').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...'); });
</script>
@endpush
