@extends('layouts.admin')

@section('title', 'Edit Tahun Ajaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Edit Tahun Ajaran</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.tahun-ajaran.index') }}">Master Tahun Ajaran</a></li>
                <li class="breadcrumb-item active">Edit</li>
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
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-edit me-2"></i>Form Edit Tahun Ajaran</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.tahun-ajaran.update', $tahunAjaran->id) }}" method="POST" id="formEdit">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label for="tahun" class="form-label fw-semibold">Tahun <span class="text-danger">*</span></label>
                        <input type="text" id="tahun" name="tahun" class="form-control @error('tahun') is-invalid @enderror" placeholder="Contoh: 2026/2027" value="{{ old('tahun', $tahunAjaran->tahun) }}" required>
                        @error('tahun')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label fw-semibold">Semester <span class="text-danger">*</span></label>
                        <select id="semester" name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                            <option value="">-- Pilih Semester --</option>
                            <option value="ganjil" {{ old('semester', $tahunAjaran->semester) == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ old('semester', $tahunAjaran->semester) == 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                        @error('semester')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.tahun-ajaran.index') }}" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-success" id="btnUpdate"><i class="fa fa-save me-1"></i>Perbarui</button>
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
