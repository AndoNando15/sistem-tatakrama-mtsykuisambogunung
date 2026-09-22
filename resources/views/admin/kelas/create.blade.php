@extends('layouts.admin')

@section('title', 'Tambah Kelas')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Tambah Kelas Baru</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.kelas.index') }}">Master Kelas</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-7 col-lg-9">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-plus me-2"></i>Form Tambah Kelas</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.kelas.store') }}" method="POST" id="formTambah">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nama_kelas" class="form-label fw-semibold">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" id="nama_kelas" name="nama_kelas"
                                   class="form-control @error('nama_kelas') is-invalid @enderror"
                                   value="{{ old('nama_kelas') }}"
                                   placeholder="Contoh: VII-A" required>
                            @error('nama_kelas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="wali_kelas_id" class="form-label fw-semibold">Wali Kelas <span class="text-muted small">(Opsional)</span></label>
                            <select id="wali_kelas_id" name="wali_kelas_id"
                                    class="form-select @error('wali_kelas_id') is-invalid @enderror">
                                <option value="">-- Pilih Wali Kelas --</option>
                                @foreach($guruList as $g)
                                    <option value="{{ $g->id }}" {{ old('wali_kelas_id') == $g->id ? 'selected' : '' }}>
                                        {{ $g->nama_lengkap ?? $g->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('wali_kelas_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <!-- Tambahkan di dalam form g-3, misalnya sebelum tombol hr class="my-4" -->
<div class="col-12">
    <div class="form-check form-switch">
        <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" 
               id="is_active" name="is_active" value="1" 
               {{ old('is_active', true) ? 'checked' : '' }}>
        <label class="form-check-label fw-semibold" for="is_active">Status Aktif</label>
        @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
                    <hr class="my-4">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.kelas.index') }}" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary px-4" id="btnSimpan"><i class="fa fa-save me-1"></i>Simpan Kelas</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
$('#formTambah').on('submit', function() { $('#btnSimpan').prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...'); });
</script>
@endpush
