@extends('layouts.admin')

@section('title', 'Tambah Siswa Baru')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Tambah Siswa Baru</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.siswa.index') }}">Master Siswa</a>
                </li>
                <li class="breadcrumb-item active">Tambah Siswa</li>
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fe fe-user-plus me-2"></i>Form Data Siswa Baru
                </h5>
            </div>
            <div class="card-body">

                <form action="{{ route('admin.siswa.store') }}" method="POST" id="formTambahSiswa" novalidate>
                    @csrf

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
                                   value="{{ old('nis_nisn') }}"
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
                                   value="{{ old('nomor_induk_kemenag') }}"
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
                                   value="{{ old('nama_siswa') }}"
                                   placeholder="Contoh: Ahmad Fauzi"
                                   maxlength="150"
                                   required>
                            @error('nama_siswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ========================
                            KELAS (DINAMIS DARI DB)
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
                                {{-- Looping dari data kelas yang di-query di controller (DINAMIS) --}}
                                @foreach($kelasList as $k)
                                    <option value="{{ $k->id }}"
                                            {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kelas }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kelas_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($kelasList->isEmpty())
                                <div class="form-text text-warning">
                                    <i class="fa fa-exclamation-triangle me-1"></i>
                                    Belum ada data kelas aktif. <a href="#">Tambah kelas terlebih dahulu</a>.
                                </div>
                            @endif
                        </div>

                        {{-- ========================
                            JENIS KELAMIN
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
                                <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>
                                    ♂ Laki-laki
                                </option>
                                <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>
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
                                   value="{{ old('tempat_lahir') }}"
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
                                   value="{{ old('tanggal_lahir') }}">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ========================
                            NAMA ORANG TUA
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
                                   value="{{ old('nama_orang_tua') }}"
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
                                   value="{{ old('nama_ibu') }}"
                                   maxlength="255">
                            @error('nama_ibu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ========================
                            NO HP ORANG TUA
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
                                       value="{{ old('no_hp_orang_tua') }}"
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
                                      placeholder="Contoh: Sambogunung Dukun Gresik">{{ old('alamat') }}</textarea>
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
                                   value="{{ old('rt') }}"
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
                                   value="{{ old('asal_sekolah') }}"
                                   maxlength="255">
                            @error('asal_sekolah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>{{-- end row g-3 --}}

                    {{-- ========================
                        TOMBOL AKSI
                        ======================== --}}
                    <div class="col-12">
    <div class="form-check form-switch">
        <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror"
               id="is_active" name="is_active" value="1"
               {{ old('is_active', true) ? 'checked' : '' }}>
        <label class="form-check-label fw-semibold" for="is_active">Aktif</label>
        @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>
<hr class="my-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary">
                            <i class="fa fa-times me-1"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary px-4" id="btnSimpan">
                            <i class="fa fa-save me-1"></i>Simpan Data Siswa
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
    // Inisialisasi Select2 untuk dropdown kelas
    $('#kelas_id').select2({
        placeholder: '-- Pilih Kelas --',
        allowClear: true,
        width: '100%'
    });

    // Disable tombol submit saat form sedang diproses
    $('#formTambahSiswa').on('submit', function () {
        $('#btnSimpan').prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm me-1"></span>Menyimpan...'
        );
    });
});
</script>
@endpush
