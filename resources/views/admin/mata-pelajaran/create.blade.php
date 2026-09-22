@extends('layouts.admin')

@section('title', 'Tambah Mata Pelajaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Tambah Mata Pelajaran Baru</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.mata-pelajaran.index') }}">Master Mata Pelajaran</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-plus me-2"></i>Form Tambah Mata Pelajaran</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.mata-pelajaran.store') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="mb-3">
                        <label for="kode_mapel" class="form-label fw-semibold">Kode Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" id="kode_mapel" name="kode_mapel" class="form-control @error('kode_mapel') is-invalid @enderror" placeholder="Contoh: MTK-01" value="{{ old('kode_mapel') }}" required>
                        @error('kode_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_mapel" class="form-label fw-semibold">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" id="nama_mapel" name="nama_mapel" class="form-control @error('nama_mapel') is-invalid @enderror" placeholder="Contoh: Matematika" value="{{ old('nama_mapel') }}" required>
                        @error('nama_mapel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.mata-pelajaran.index') }}" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
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
