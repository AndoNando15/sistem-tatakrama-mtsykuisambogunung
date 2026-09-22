@extends('layouts.admin')

@section('title', 'Edit Aturan Sanksi')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Edit Aturan Sanksi</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.aturan-sanksi.index') }}">Aturan Sanksi</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.aturan-sanksi.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-7 col-lg-9">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0"><i class="fe fe-edit me-2"></i>Form Edit Aturan Sanksi</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.aturan-sanksi.update', $aturan->id) }}" method="POST" id="formEdit">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="min_poin" class="form-label fw-semibold">Poin Minimum <span class="text-danger">*</span></label>
                            <input type="number" id="min_poin" name="min_poin" class="form-control @error('min_poin') is-invalid @enderror" min="0" value="{{ old('min_poin', $aturan->min_poin) }}" required>
                            @error('min_poin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="max_poin" class="form-label fw-semibold">Poin Maksimum <span class="text-danger">*</span></label>
                            <input type="number" id="max_poin" name="max_poin" class="form-control @error('max_poin') is-invalid @enderror" min="1" value="{{ old('max_poin', $aturan->max_poin) }}" required>
                            @error('max_poin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="tindakan" class="form-label fw-semibold">Tindakan / Sanksi <span class="text-danger">*</span></label>
                            <textarea id="tindakan" name="tindakan" rows="3" class="form-control @error('tindakan') is-invalid @enderror" required>{{ old('tindakan', $aturan->tindakan) }}</textarea>
                            @error('tindakan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nilai_sikap" class="form-label fw-semibold">Nilai Sikap (Opsional)</label>
                            <select id="nilai_sikap" name="nilai_sikap" class="form-select @error('nilai_sikap') is-invalid @enderror">
                                <option value="">-- Pilih Nilai Sikap --</option>
                                <option value="A" {{ old('nilai_sikap', $aturan->nilai_sikap) == 'A' ? 'selected' : '' }}>A (Sangat Baik)</option>
                                <option value="B" {{ old('nilai_sikap', $aturan->nilai_sikap) == 'B' ? 'selected' : '' }}>B (Baik)</option>
                                <option value="C" {{ old('nilai_sikap', $aturan->nilai_sikap) == 'C' ? 'selected' : '' }}>C (Cukup)</option>
                                <option value="D" {{ old('nilai_sikap', $aturan->nilai_sikap) == 'D' ? 'selected' : '' }}>D (Kurang)</option>
                            </select>
                            @error('nilai_sikap')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.aturan-sanksi.index') }}" class="btn btn-outline-secondary"><i class="fa fa-times me-1"></i>Batal</a>
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
