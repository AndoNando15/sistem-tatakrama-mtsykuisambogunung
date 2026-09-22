@extends('layouts.admin')

@section('title', 'Edit Kategori Pelanggaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Edit Kategori Pelanggaran</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.kategori-pelanggaran.index') }}">Kategori Pelanggaran</a></li>
                <li class="breadcrumb-item active">Edit: {{ $kategori->kode }}</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.kategori-pelanggaran.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-edit me-2"></i>Form Edit Kategori</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.kategori-pelanggaran.update', $kategori->id) }}" method="POST" id="formEdit">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label for="kode" class="form-label fw-semibold">Kode Kategori <span class="text-danger">*</span></label>
                        <input type="text" id="kode" name="kode" class="form-control @error('kode') is-invalid @enderror" value="{{ old('kode', $kategori->kode) }}" required>
                        @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" id="nama_kategori" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" required>
                        @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="sifat_akumulasi" class="form-label fw-semibold">Sifat Akumulasi <span class="text-danger">*</span></label>
                        <select id="sifat_akumulasi" name="sifat_akumulasi" class="form-select @error('sifat_akumulasi') is-invalid @enderror" required>
                            <option value="">-- Pilih Sifat Akumulasi --</option>
                            <option value="semester" {{ old('sifat_akumulasi', $kategori->sifat_akumulasi) == 'semester' ? 'selected' : '' }}>Per Semester (Reset tiap semester)</option>
                            <option value="tahunan" {{ old('sifat_akumulasi', $kategori->sifat_akumulasi) == 'tahunan' ? 'selected' : '' }}>Tahunan (Reset tiap tahun ajaran)</option>
                            <option value="selamanya" {{ old('sifat_akumulasi', $kategori->sifat_akumulasi) == 'selamanya' ? 'selected' : '' }}>Selamanya / Akumulatif (Selama menjadi siswa)</option>
                        </select>
                        @error('sifat_akumulasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.kategori-pelanggaran.index') }}" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-success" id="btnUpdate"><i class="fa fa-save me-1"></i>Perbarui Kategori</button>
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
