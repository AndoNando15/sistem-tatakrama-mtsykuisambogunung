@extends('layouts.admin')

@section('title', 'Tambah Jenis Pelanggaran')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Tambah Jenis Pelanggaran Baru</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.jenis-pelanggaran.index') }}">Jenis Pelanggaran</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-7 col-lg-9">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-plus me-2"></i>Form Tambah Jenis Pelanggaran</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.jenis-pelanggaran.store') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="kategori_id" class="form-label fw-semibold">Kategori Pelanggaran <span class="text-danger">*</span></label>
                            <select id="kategori_id" name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($kategoriList as $kat)
                                    <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
                                        [{{ $kat->kode }}] {{ $kat->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="kode_pelanggaran" class="form-label fw-semibold">Kode Pelanggaran (Opsional)</label>
                            <input type="text" id="kode_pelanggaran" name="kode_pelanggaran" class="form-control @error('kode_pelanggaran') is-invalid @enderror" placeholder="Contoh: P01" value="{{ old('kode_pelanggaran') }}">
                            @error('kode_pelanggaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="uraian_pelanggaran" class="form-label fw-semibold">Uraian / Deskripsi Pelanggaran <span class="text-danger">*</span></label>
                            <textarea id="uraian_pelanggaran" name="uraian_pelanggaran" rows="3" class="form-control @error('uraian_pelanggaran') is-invalid @enderror" placeholder="Contoh: Datang terlambat lebih dari 15 menit tanpa alasan yang sah..." required>{{ old('uraian_pelanggaran') }}</textarea>
                            @error('uraian_pelanggaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="poin" class="form-label fw-semibold">Poin Pelanggaran <span class="text-danger">*</span></label>
                            <input type="number" id="poin" name="poin" class="form-control @error('poin') is-invalid @enderror" min="1" max="100" value="{{ old('poin', 5) }}" required>
                            @error('poin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-8">
                            <label for="sanksi_default" class="form-label fw-semibold">Sanksi Default (Opsional)</label>
                            <input type="text" id="sanksi_default" name="sanksi_default" class="form-control @error('sanksi_default') is-invalid @enderror" placeholder="Contoh: Teguran lisan & pencatatan poin" value="{{ old('sanksi_default') }}">
                            @error('sanksi_default')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.jenis-pelanggaran.index') }}" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
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
