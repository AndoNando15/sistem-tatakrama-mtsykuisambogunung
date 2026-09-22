@extends('layouts.admin')

@section('title', 'Tambah Kategori Pelanggaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Tambah Kategori Pelanggaran Baru</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.kategori-pelanggaran.index') }}">Kategori Pelanggaran</a></li>
                <li class="breadcrumb-item active">Tambah</li>
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
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-plus me-2"></i>Form Tambah Kategori</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.kategori-pelanggaran.store') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="mb-3">
                        <label for="kode" class="form-label fw-semibold">Kode Kategori <span class="text-danger">*</span></label>
                        <input type="text" id="kode" name="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Contoh: K1" value="{{ old('kode') }}" required>
                        @error('kode')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label fw-semibold">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" id="nama_kategori" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror" placeholder="Contoh: Pelanggaran Ringan / Kedisiplinan" value="{{ old('nama_kategori') }}" required>
                        @error('nama_kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="sifat_akumulasi" class="form-label fw-semibold">Sifat Akumulasi <span class="text-danger">*</span></label>
                        <select id="sifat_akumulasi" name="sifat_akumulasi" class="form-select @error('sifat_akumulasi') is-invalid @enderror" required>
                            <option value="">-- Pilih Sifat Akumulasi --</option>
                            <option value="semester" {{ old('sifat_akumulasi') == 'semester' ? 'selected' : '' }}>Per Semester (Reset tiap semester)</option>
                            <option value="tahunan" {{ old('sifat_akumulasi') == 'tahunan' ? 'selected' : '' }}>Tahunan (Reset tiap tahun ajaran)</option>
                            <option value="selamanya" {{ old('sifat_akumulasi') == 'selamanya' ? 'selected' : '' }}>Selamanya / Akumulatif (Selama menjadi siswa)</option>
                        </select>
                        @error('sifat_akumulasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.kategori-pelanggaran.index') }}" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary" id="btnSimpan"><i class="fa fa-save me-1"></i>Simpan Kategori</button>
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
