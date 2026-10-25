@extends('layouts.admin')

@section('title', 'Tambah Role')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Tambah Role</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Master Role</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i>Kembali</a>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="card-title mb-0">Form Tambah Role</h5></div>
            <div class="card-body">
                <form action="{{ route('admin.roles.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_role" class="form-label fw-semibold">Kode Role <span class="text-danger">*</span></label>
                        <input type="text" id="nama_role" name="nama_role" class="form-control @error('nama_role') is-invalid @enderror" value="{{ old('nama_role') }}" placeholder="contoh: bk" required>
                        <div class="form-text">Huruf kecil, angka, dan underscore saja.</div>
                        @error('nama_role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label fw-semibold">Keterangan</label>
                        <input type="text" id="keterangan" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" value="{{ old('keterangan') }}">
                        @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save me-1"></i>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
