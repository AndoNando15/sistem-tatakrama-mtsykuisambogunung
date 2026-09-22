@extends('layouts.admin')

@section('title', 'Tambah Tahun Ajaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Tambah Tahun Ajaran Baru</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tahun-ajaran.index') }}">Master Tahun Ajaran</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-plus me-2"></i>Form Tambah Tahun Ajaran</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="mb-3">
                        <label for="tahun" class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
                        <input type="text" id="tahun" name="tahun" class="form-control @error('tahun') is-invalid @enderror" placeholder="Contoh: 2024/2025" value="{{ old('tahun') }}" required>
                        @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                        <select id="semester" name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                            <option value="">-- Pilih Semester --</option>
                            <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-check mb-3">
                        <input type="checkbox" id="is_active" name="is_active" class="form-check-input" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktifkan Tahun Ajaran</label>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary" id="btnSimpan"><i class="fa fa-save me-1"></i>Simpan</button>
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
