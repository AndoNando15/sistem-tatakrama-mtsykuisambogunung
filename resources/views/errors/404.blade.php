@extends('layouts.admin')

@section('title', 'Halaman Tidak Ditemukan')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title"><i class="fa fa-exclamation-triangle text-warning me-2"></i>404 - Halaman Tidak Ditemukan</h3>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center min-vh-75 text-center" style="background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);">
    <h1 class="display-1 fw-bold text-primary" style="font-size: 8rem;">404</h1>
    <p class="lead mb-4">Oops! Halaman yang Anda cari tidak ada atau telah dipindahkan.</p>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">
        <i class="fa fa-home me-2"></i>Kembali ke Dashboard
    </a>
</div>
@endsection

@push('styles')
<style>
    .min-vh-75 { min-height: 75vh; }
</style>
@endpush
