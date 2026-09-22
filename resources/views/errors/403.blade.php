@extends('layouts.admin')

@section('title', 'Akses Ditolak')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title"><i class="fa fa-lock text-danger me-2"></i>403 - Akses Ditolak</h3>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center min-vh-75 text-center" style="background: linear-gradient(135deg, #fff5f5 0%, #ffe3e3 100%);">
    <h1 class="display-1 fw-bold text-danger" style="font-size: 8rem;">403</h1>
    <p class="lead mb-4">Maaf, Anda tidak memiliki hak akses untuk melihat halaman ini.</p>
    <a href="{{ url()->previous() ?? route('admin.dashboard') }}" class="btn btn-danger btn-lg me-2">
        <i class="fa fa-arrow-left me-1"></i>Kembali
    </a>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary btn-lg">
        <i class="fa fa-home me-1"></i>Ke Dashboard
    </a>
</div>
@endsection

@push('styles')
<style>
    .min-vh-75 { min-height: 75vh; }
</style>
@endpush
