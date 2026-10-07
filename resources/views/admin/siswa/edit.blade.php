@extends('layouts.admin')

@section('title', 'Edit Data Siswa')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Edit Data Siswa</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.siswa.index') }}">Master Siswa</a>
                </li>
                <li class="breadcrumb-item active">Edit: {{ $siswa->nama_siswa }}</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
                <i class="fa fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row justify-content-center">
    <div class="col-xl-8 col-lg-10">

        {{-- Info Card Siswa --}}
        <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
            <i class="fa fa-pencil-square-o fa-lg me-3"></i>
            <div>
                Anda sedang mengedit data siswa: <strong>{{ $siswa->nama_siswa }}</strong>
                (NIS/NISN: <code>{{ $siswa->nis_nisn }}</code>)
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fe fe-edit me-2"></i>Form Edit Data Siswa
                </h5>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.siswa.update', $siswa->id) }}"
                      method="POST"
                      id="formEditSiswa"
                      novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3">

                        {{-- ========================
                            NIS / NISN
                            ======================== --}}
                        <div class="col-md-6">
                            <label for="nis_nisn" class="form-label fw-semibold">
                                NIS / NISN <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="nis_nisn"
                                   name="nis_nisn"
                                   class="form-control @error('nis_nisn') is-invalid @enderror"
                                   value="{{ old('nis_nisn', $siswa->nis_nisn) }}"
                                   placeholder="Contoh: 12345678901234"
                                   maxlength="20"
                                   required>
                            @error('nis_nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nomor_induk_kemenag" class="form-label fw-semibold">Nomor Induk Kemenag</label>
                            <input type="text"
                                   id="nomor_induk_kemenag"
                                   name="nomor_induk_kemenag"
                                   class="form-control @error('nomor_induk_kemenag') is-invalid @enderror"
                                   value="{{ old('nomor_induk_kemenag', $siswa->nomor_induk_kemenag) }}"
                                   maxlength="255">
                            @error('nomor_induk_kemenag')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ========================
                            NAMA SISWA
                            ======================== --}}
                        <div class="col-md-6">
                            <label for="nama_siswa" class="form-label fw-semibold">
                                Nama Lengkap Siswa <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   id="nama_siswa"
                                   name="nama_siswa"
                                   class="form-control @error('nama_siswa') is-invalid @enderror"
                                   value="{{ old('nama_siswa', $siswa->nama_siswa) }}"
                                   placeholder="Contoh: Ahmad Fauzi"
                                   maxlength="150"
                                   required>
                            @error('nama_siswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ========================
                            KELAS — PRE-FILLED DARI DB
                            ======================== --}}
                        <div class="col-md-6">
                            <label for="kelas_id" class="form-label fw-semibold">
                                Kelas <span class="text-danger">*</span>
                            </label>
                            <select id="kelas_id"
                                    name="kelas_id"
                                    class="form-select select2 @error('kelas_id') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Kelas --</option>
                                {{-- Looping dari data kelas yang di-query di controller (DINAMIS)
                                     Nilai kelas saat ini otomatis terpilih via perbandingan ID --}}
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}"
                                            {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ========================
                            JENIS KELAMIN — PRE-FILLED
                            ======================== --}}
                        <div class="col-md-6">
                            <label for="jenis_kelamin" class="form-label fw-semibold">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <select id="jenis_kelamin"
                                    name="jenis_kelamin"
                                    class="form-select @error('jenis_kelamin') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="L"
                                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'L' ? 'selected' : '' }}>
                                    ♂ Laki-laki
                                </option>
                                <option value="P"
                                        {{ old('jenis_kelamin', $siswa->jenis_kelamin) === 'P' ? 'selected' : '' }}>
                                    ♀ Perempuan
                                </option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tempat_lahir" class="form-label fw-semibold">Tempat Lahir</label>
                            <input type="text"
                                   id="tempat_lahir"
                                   name="tempat_lahir"
                                   class="form-control @error('tempat_lahir') is-invalid @enderror"
                                   value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                                   maxlength="255">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                            <input type="date"
                                   id="tanggal_lahir"
                                   name="tanggal_lahir"
                                   class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                   value="{{ old('tanggal_lahir', $siswa->tanggal_lahir?->format('Y-m-d')) }}">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ========================
                            NAMA ORANG TUA — PRE-FILLED
                            ======================== --}}
                        <div class="col-md-6">
                            <label for="nama_orang_tua" class="form-label fw-semibold">
                                Nama Orang Tua / Wali
                                <span class="text-muted small">(Opsional)</span>
                            </label>
                            <input type="text"
                                   id="nama_orang_tua"
                                   name="nama_orang_tua"
                                   class="form-control @error('nama_orang_tua') is-invalid @enderror"
                                   value="{{ old('nama_orang_tua', $siswa->nama_orang_tua) }}"
                                   placeholder="Contoh: Bapak Ahmad Rasyid"
                                   maxlength="150">
                            @error('nama_orang_tua')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="nama_ibu" class="form-label fw-semibold">Nama Ibu</label>
                            <input type="text"
                                   id="nama_ibu"
                                   name="nama_ibu"
                                   class="form-control @error('nama_ibu') is-invalid @enderror"
                                   value="{{ old('nama_ibu', $siswa->nama_ibu) }}"
                                   maxlength="255">
                            @error('nama_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ========================
                            NO HP ORANG TUA — PRE-FILLED
                            ======================== --}}
                        <div class="col-md-6">
                            <label for="no_hp_orang_tua" class="form-label fw-semibold">
                                No. HP Orang Tua / Wali
                                <span class="text-muted small">(Opsional)</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa fa-whatsapp text-success"></i>
                                </span>
                                <input type="text"
                                       id="no_hp_orang_tua"
                                       name="no_hp_orang_tua"
                                       class="form-control @error('no_hp_orang_tua') is-invalid @enderror"
                                       value="{{ old('no_hp_orang_tua', $siswa->no_hp_orang_tua) }}"
                                       placeholder="Contoh: 08123456789"
                                       maxlength="20">
                            </div>
                            @error('no_hp_orang_tua')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="alamat" class="form-label fw-semibold">Alamat</label>
                            <textarea id="alamat"
                                      name="alamat"
                                      class="form-control @error('alamat') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Contoh: Sambogunung Dukun Gresik">{{ old('alamat', $siswa->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="rt" class="form-label fw-semibold">RT</label>
                            <input type="text"
                                   id="rt"
                                   name="rt"
                                   class="form-control @error('rt') is-invalid @enderror"
                                   value="{{ old('rt', $siswa->rt) }}"
                                   maxlength="255">
                            @error('rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="asal_sekolah" class="form-label fw-semibold">Asal Sekolah</label>
                            <input type="text"
                                   id="asal_sekolah"
                                   name="asal_sekolah"
                                   class="form-control @error('asal_sekolah') is-invalid @enderror"
                                   value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}"
                                   maxlength="255">
                            @error('asal_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>{{-- end row g-3 --}}

                    {{-- ========================
                        METADATA RECORD
                        ======================== --}}
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="bg-light rounded p-3 small text-muted">
                                <i class="fa fa-clock-o me-1"></i>
                                Data dibuat: <strong>{{ $siswa->created_at ? $siswa->created_at->format('d M Y, H:i') : '-' }}</strong>
                                &nbsp;&nbsp;|&nbsp;&nbsp;
                                <i class="fa fa-refresh me-1"></i>
                                Terakhir diperbarui: <strong>{{ $siswa->updated_at ? $siswa->updated_at->format('d M Y, H:i') : '-' }}</strong>
                            </div>
                        </div>
                    </div>

                    {{-- ========================
                        TOMBOL AKSI
                        ======================== --}}
                    <hr class="my-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-times me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-success px-4" id="btnUpdate">
                            <i class="fa fa-save me-1"></i>Perbarui Data Siswa
                        </button>
                    </div>

                </form>

            </div>{{-- card-body --}}
        </div>{{-- card --}}

    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Inisialisasi Select2 untuk dropdown kelas dengan nilai yang sudah terpilih
    $('#kelas_id').select2({
        placeholder: '-- Pilih Kelas --',
        allowClear: true,
        width: '100%'
    });

    // Disable tombol submit saat form sedang diproses
    $('#formEditSiswa').on('submit', function () {
        $('#btnUpdate').prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1"></span>Memperbarui...'
        );
    });
});
</script>
@endpush
