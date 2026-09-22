@extends('layouts.admin')

@section('title', 'Catat Pelanggaran Siswa')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title text-primary fw-bold">
                <i class="fa fa-plus-circle me-2"></i>Catat Pelanggaran Siswa
            </h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('guru.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('guru.poin.index') }}">Riwayat Poin</a></li>
                <li class="breadcrumb-item active">Tambah</li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10 col-xl-9">

        {{-- TOP PROGRESS BAR --}}
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="fw-bold text-primary small" id="stepProgressTitle">
                        <i class="fa fa-list-ol me-1"></i> Langkah 1 dari 5: Pilih Kelas
                    </span>
                    <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" id="btnStepBack" style="display: none;">
                        <i class="fa fa-arrow-left me-1"></i>Kembali
                    </button>
                </div>
                <div class="progress" style="height: 6px; border-radius: 10px; background-color: #e9ecef;">
                    <div class="progress-bar" id="stepProgressBar" role="progressbar" style="width: 20%; background-color: #1b6e3d; transition: width 0.3s ease;"></div>
                </div>
            </div>
        </div>

        {{-- SELECTION PILLS BREADCRUMB --}}
        <div class="d-flex flex-wrap gap-2 mb-3" id="selectionPills" style="display: none;">
            <span class="badge bg-primary fs-6 px-3 py-2 cursor-pointer" id="pillKelas" style="display:none;" onclick="goToStep(1)">
                <i class="fa fa-school me-1"></i> <span id="pillKelasText"></span> <i class="fa fa-pencil ms-1 opacity-75"></i>
            </span>
            <span class="badge bg-success fs-6 px-3 py-2 cursor-pointer" id="pillSiswa" style="display:none;" onclick="goToStep(2)">
                <i class="fa fa-user me-1"></i> <span id="pillSiswaText"></span> <i class="fa fa-pencil ms-1 opacity-75"></i>
            </span>
            <span class="badge bg-secondary fs-6 px-3 py-2 cursor-pointer" id="pillKategori" style="display:none;" onclick="goToStep(3)">
                <i class="fa fa-folder me-1"></i> <span id="pillKategoriText"></span> <i class="fa fa-pencil ms-1 opacity-75"></i>
            </span>
            <span class="badge bg-danger fs-6 px-3 py-2 cursor-pointer" id="pillJenis" style="display:none;" onclick="goToStep(4)">
                <i class="fa fa-exclamation-triangle me-1"></i> <span id="pillJenisText"></span> <i class="fa fa-pencil ms-1 opacity-75"></i>
            </span>
        </div>

        <form action="{{ route('guru.poin.store') }}" method="POST" id="formPoinCardGuru">
            @csrf
            <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="siswa_id" id="inputSiswaId">
            <input type="hidden" name="jenis_pelanggaran_id" id="inputJenisId">

            {{-- ══ STEP 1: PILIH KELAS ══ --}}
            <div class="step-card" id="step1">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-dark">
                            <i class="fa fa-school me-2 text-primary"></i>Langkah 1: Klik Pilih Kelas Siswa
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Silakan klik salah satu kelas di bawah ini:</p>
                        <div class="row g-3">
                            @forelse($kelasList as $kelas)
                            <div class="col-md-4 col-6">
                                <div class="card card-selection text-center p-3 p-md-4 cursor-pointer h-100"
                                     onclick="selectKelas({{ $kelas->id }}, '{{ $kelas->nama_kelas }}')">
                                    <div class="fs-2 text-primary mb-2"><i class="fa fa-university"></i></div>
                                    <h5 class="fw-bold mb-1 text-dark">Kelas {{ $kelas->nama_kelas }}</h5>
                                    <span class="badge bg-light text-success border px-2 py-1 small">
                                        {{ $kelas->siswa->count() }} Siswa
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-4 text-muted">Belum ada kelas aktif.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══ STEP 2: PILIH SISWA ══ --}}
            <div class="step-card" id="step2" style="display: none;">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-dark">
                            <i class="fa fa-users me-2 text-primary"></i>Langkah 2: Klik Pilih Siswa (<span id="step2KelasTitle"></span>)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-search text-muted"></i></span>
                                <input type="text" id="searchSiswaInput" class="form-control" placeholder="Cari nama atau NISN siswa...">
                            </div>
                        </div>
                        <div class="row g-2" id="siswaCardGrid">
                            {{-- Content loaded dynamically --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══ STEP 3: PILIH KATEGORI ══ --}}
            <div class="step-card" id="step3" style="display: none;">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-dark">
                            <i class="fa fa-folder-open me-2 text-primary"></i>Langkah 3: Klik Pilih Kategori Pelanggaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Pilih kelompok kategori pelanggaran:</p>
                        <div class="row g-3">
                            @foreach($kategoriList as $kat)
                            <div class="col-md-4 col-6">
                                <div class="card card-selection p-3 cursor-pointer h-100"
                                     onclick="selectKategori({{ $kat->id }}, '{{ $kat->kode }}', '{{ $kat->nama_kategori }}')">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <span class="badge bg-primary px-2 py-1">{{ $kat->kode }}</span>
                                        <span class="badge bg-light text-dark border small">{{ $kat->jenisPelanggaran->count() }} Jenis</span>
                                    </div>
                                    <h6 class="fw-bold mb-1 text-dark">{{ $kat->nama_kategori }}</h6>
                                    <small class="text-muted extra-small">Akumulasi: {{ ucfirst($kat->sifat_akumulasi) }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══ STEP 4: PILIH DETAIL PELANGGARAN ══ --}}
            <div class="step-card" id="step4" style="display: none;">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-dark">
                            <i class="fa fa-exclamation-triangle me-2 text-primary"></i>Langkah 4: Klik Detail Pelanggaran (<span id="step4KatTitle"></span>)
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small">Klik pada pelanggaran yang dilakukan siswa:</p>
                        <div class="list-group" id="jenisListContainer">
                            {{-- Content loaded dynamically --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- ══ STEP 5: KONFIRMASI & INFORMATIF ══ --}}
            <div class="step-card" id="step5" style="display: none;">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3">
                        <h5 class="card-title mb-0 fw-bold text-success">
                            <i class="fa fa-check-circle me-2"></i>Langkah 5: Ringkasan Informatif & Simpan
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-light border p-3 rounded-3 mb-4">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">Tanggal Kejadian</small>
                                    <strong class="text-dark"><i class="fa fa-calendar me-1 text-primary"></i> {{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }}</strong>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <small class="text-muted d-block">Guru Pelapor</small>
                                    <strong class="text-dark"><i class="fa fa-user me-1 text-primary"></i> {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</strong>
                                </div>
                            </div>
                        </div>

                        {{-- RINGKASAN DATA --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <small class="text-muted text-uppercase fw-bold small d-block mb-1">Siswa Terpilih</small>
                                    <h6 class="fw-bold text-dark mb-1" id="confirmSiswaNama">—</h6>
                                    <span class="badge bg-primary me-1" id="confirmKelasNama">—</span>
                                    <small class="text-muted" id="confirmNisn">—</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="p-3 border rounded-3 bg-light h-100">
                                    <small class="text-muted text-uppercase fw-bold small d-block mb-1">Detail Pelanggaran</small>
                                    <h6 class="fw-bold text-dark mb-1" id="confirmJenisNama">—</h6>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <span class="badge bg-danger fs-6 px-3" id="confirmPoinBadge">+0 Poin</span>
                                        <small class="text-muted" id="confirmKode">—</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="catatan" class="form-label fw-bold text-dark mb-1">Catatan Kejadian (Opsional)</label>
                            <textarea id="catatan" name="catatan" class="form-control" rows="3" placeholder="Catatan tempat, waktu, atau keterangan tambahan..."></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary py-3 fw-bold fs-6" id="btnSubmitPoin">
                                <i class="fa fa-save me-2"></i> Simpan Catatan Pelanggaran Siswa
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>

    </div>
</div>
@endsection

@push('styles')
<style>
.card-selection {
    transition: all 0.2s ease;
    border: 1px solid #e0e8e2;
    border-radius: 12px;
}
.card-selection:hover {
    border-color: #1b6e3d;
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(27, 110, 61, 0.15) !important;
    background-color: #f7fbf8;
}
.cursor-pointer { cursor: pointer; }
.extra-small { font-size: 11px; }
.list-group-item-selection {
    border-radius: 10px !important;
    border: 1px solid #e0e8e2;
    margin-bottom: 8px;
    transition: all 0.15s ease;
}
.list-group-item-selection:hover {
    border-color: #1b6e3d;
    background-color: #f7fbf8;
}
</style>
@endpush

@push('scripts')
<script>
// Data JSON dari backend
var kelasData = @json($kelasList);
var kategoriData = @json($kategoriList);

var currentStep = 1;
var selectedKelasId = null;
var selectedKelasNama = '';
var selectedSiswaId = null;
var selectedSiswaNama = '';
var selectedNisn = '';
var selectedKategoriId = null;
var selectedKategoriKode = '';
var selectedJenisId = null;
var selectedJenisNama = '';
var selectedJenisKode = '';
var selectedPoin = 0;
var selectedSanksi = '';

function goToStep(step) {
    currentStep = step;
    $('.step-card').hide();
    $('#step' + step).fadeIn(200);

    // Update Top Progress Bar
    var pct = (step / 5) * 100;
    $('#stepProgressBar').css('width', pct + '%');

    var titles = {
        1: 'Langkah 1 dari 5: Pilih Kelas',
        2: 'Langkah 2 dari 5: Pilih Siswa (' + selectedKelasNama + ')',
        3: 'Langkah 3 dari 5: Pilih Kategori Pelanggaran',
        4: 'Langkah 4 dari 5: Pilih Detail Pelanggaran',
        5: 'Langkah 5 dari 5: Ringkasan Informatif & Simpan'
    };
    $('#stepProgressTitle').html('<i class="fa fa-list-ol me-1"></i> ' + titles[step]);

    if (step > 1) {
        $('#btnStepBack').show();
        $('#selectionPills').show();
    } else {
        $('#btnStepBack').hide();
        $('#selectionPills').hide();
    }

    updatePills();
}

$('#btnStepBack').on('click', function () {
    if (currentStep > 1) {
        goToStep(currentStep - 1);
    }
});

function updatePills() {
    if (selectedKelasId) {
        $('#pillKelasText').text(selectedKelasNama);
        $('#pillKelas').show();
    } else { $('#pillKelas').hide(); }

    if (selectedSiswaId) {
        $('#pillSiswaText').text(selectedSiswaNama);
        $('#pillSiswa').show();
    } else { $('#pillSiswa').hide(); }

    if (selectedKategoriId) {
        $('#pillKategoriText').text(selectedKategoriKode);
        $('#pillKategori').show();
    } else { $('#pillKategori').hide(); }

    if (selectedJenisId) {
        $('#pillJenisText').text(selectedJenisNama + ' (+' + selectedPoin + ' Poin)');
        $('#pillJenis').show();
    } else { $('#pillJenis').hide(); }
}

// 1. SELECT KELAS
function selectKelas(id, nama) {
    selectedKelasId = id;
    selectedKelasNama = 'Kelas ' + nama;
    $('#step2KelasTitle').text(selectedKelasNama);

    // Render Siswa
    var kelasObj = kelasData.find(k => k.id == id);
    var siswaList = kelasObj ? (kelasObj.siswa || []) : [];
    renderSiswaGrid(siswaList);

    goToStep(2);
}

function renderSiswaGrid(siswaList) {
    var $grid = $('#siswaCardGrid');
    $grid.empty();

    if (siswaList.length === 0) {
        $grid.html('<div class="col-12 text-center py-4 text-muted">Tidak ada siswa aktif di kelas ini.</div>');
        return;
    }

    siswaList.forEach(function (s) {
        var firstLetter = (s.nama_siswa || 'S').charAt(0).toUpperCase();
        var html = `
            <div class="col-md-6 siswa-card-item" data-nama="${s.nama_siswa.toLowerCase()}" data-nisn="${(s.nis_nisn || '').toLowerCase()}">
                <div class="card card-selection p-3 cursor-pointer d-flex flex-row align-items-center gap-3"
                     onclick="selectSiswa(${s.id}, '${escapeJs(s.nama_siswa)}', '${s.nis_nisn || ''}')">
                    <div class="avatar avatar-md bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold fs-5" style="width:42px; height:42px; background-color: #1b6e3d !important;">
                        ${firstLetter}
                    </div>
                    <div>
                        <div class="fw-bold text-dark">${s.nama_siswa}</div>
                        <small class="text-muted">NISN: ${s.nis_nisn || '-'}</small>
                    </div>
                </div>
            </div>
        `;
        $grid.append(html);
    });
}

// Search Siswa Filter
$('#searchSiswaInput').on('keyup', function () {
    var val = $(this).val().toLowerCase();
    $('.siswa-card-item').each(function () {
        var nama = $(this).data('nama');
        var nisn = $(this).data('nisn');
        if (nama.indexOf(val) !== -1 || nisn.indexOf(val) !== -1) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});

// 2. SELECT SISWA
function selectSiswa(id, nama, nisn) {
    selectedSiswaId = id;
    selectedSiswaNama = nama;
    selectedNisn = nisn;
    $('#inputSiswaId').val(id);

    goToStep(3);
}

// 3. SELECT KATEGORI
function selectKategori(id, kode, nama) {
    selectedKategoriId = id;
    selectedKategoriKode = kode;
    $('#step4KatTitle').text(kode + ' - ' + nama);

    // Render Jenis
    var katObj = kategoriData.find(k => k.id == id);
    var jenisList = katObj ? (katObj.jenis_pelanggaran || []) : [];
    renderJenisList(jenisList);

    goToStep(4);
}

function renderJenisList(jenisList) {
    var $cont = $('#jenisListContainer');
    $cont.empty();

    if (jenisList.length === 0) {
        $cont.html('<div class="text-center py-4 text-muted">Belum ada jenis pelanggaran pada kategori ini.</div>');
        return;
    }

    jenisList.forEach(function (j) {
        var nameStr = j.uraian_pelanggaran || j.nama_pelanggaran || j.nama || '';
        var html = `
            <div class="list-group-item list-group-item-action list-group-item-selection p-3 cursor-pointer"
                 onclick="selectJenis(${j.id}, '${escapeJs(nameStr)}', '${j.kode_pelanggaran}', ${j.poin}, '${escapeJs(j.sanksi_default || '')}')">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="badge bg-light text-dark border me-2">${j.kode_pelanggaran}</span>
                        <strong class="text-dark">${nameStr}</strong>
                    </div>
                    <span class="badge bg-danger fs-6 px-3 py-1">+${j.poin} Poin</span>
                </div>
                ${j.sanksi_default ? '<div class="small text-muted mt-1"><i class="fa fa-info-circle me-1"></i>Sanksi default: ' + j.sanksi_default + '</div>' : ''}
            </div>
        `;
        $cont.append(html);
    });
}

// 4. SELECT JENIS PELANGGARAN
function selectJenis(id, nama, kode, poin, sanksi) {
    selectedJenisId = id;
    selectedJenisNama = nama;
    selectedJenisKode = kode;
    selectedPoin = poin;
    selectedSanksi = sanksi;
    $('#inputJenisId').val(id);

    // Populate Step 5 Confirm
    $('#confirmSiswaNama').text(selectedSiswaNama);
    $('#confirmKelasNama').text(selectedKelasNama);
    $('#confirmNisn').text('NISN: ' + (selectedNisn || '-'));
    $('#confirmJenisNama').text(selectedJenisNama);
    $('#confirmPoinBadge').text('+' + poin + ' Poin');
    $('#confirmKode').text('Kode: ' + kode);

    goToStep(5);
}

function escapeJs(str) {
    return (str || '').replace(/'/g, "\\'").replace(/"/g, '&quot;');
}
</script>
@endpush
