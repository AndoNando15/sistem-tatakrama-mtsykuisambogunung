@extends('layouts.admin')

@section('title', 'Master Siswa')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Master Siswa</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Master Siswa</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa fa-plus me-1"></i> Tambah Siswa Baru
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')

{{-- FILTER & PENCARIAN --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('admin.siswa.index') }}" method="GET" id="filterForm">
            <div class="row g-2 align-items-end">
                <div class="col-md-5">
                    <label for="search" class="form-label small fw-semibold text-muted mb-1">Pencarian Data</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa fa-search"></i></span>
                        <input type="text"
                               id="search"
                               name="search"
                               class="form-control border-start-0"
                               placeholder="Cari nama siswa atau NIS / NISN..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="kelas_id" class="form-label small fw-semibold text-muted mb-1">Filter Kelas</label>
                    <select name="kelas_id" id="kelas_id" class="form-select select2">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}"
                                    {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100" id="btnFilter">
                            <i class="fa fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.siswa.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- TABEL DATA SISWA --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <div class="d-flex align-items-center gap-2">
            <div class="badge bg-soft-success text-success p-2 rounded-circle">
                <i class="fe fe-users fs-5"></i>
            </div>
            <h5 class="card-title mb-0 fw-bold text-dark">Daftar Siswa</h5>
        </div>
        <span class="badge bg-primary rounded-pill px-3 py-2">
            Total: {{ $siswa->total() }} Siswa
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tableSiswa">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>NIS / NISN</th>
                        <th>Nama Siswa</th>
                        <th class="text-center">Kelas</th>
                        <th class="text-center">Jenis Kelamin</th>
                        <th>Orang Tua & WhatsApp</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" width="130">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $index => $s)
                    <tr>
                        <td class="text-center text-muted small fw-semibold">
                            {{ $siswa->firstItem() + $index }}
                        </td>
                        <td>
                            <span class="badge badge-soft-dark font-monospace px-2 py-1">
                                <i class="fa fa-id-card-o me-1 text-muted"></i>{{ $s->nis_nisn }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2.5">
                                <div class="avatar-initial">
                                    {{ strtoupper(substr($s->nama_siswa, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $s->nama_siswa }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            @if($s->kelas)
                                <span class="badge badge-soft-info fw-semibold px-2.5 py-1">
                                    <i class="fe fe-grid me-1"></i>{{ $s->kelas->nama_kelas }}
                                </span>
                            @else
                                <span class="badge bg-light text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($s->jenis_kelamin === 'L')
                                <span class="badge badge-soft-primary px-2.5 py-1">
                                    <i class="fa fa-mars me-1"></i>Laki-laki
                                </span>
                            @else
                                <span class="badge badge-soft-danger px-2.5 py-1">
                                    <i class="fa fa-venus me-1"></i>Perempuan
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="fw-semibold text-dark small mb-0.5">
                                    <i class="fa fa-user text-muted me-1"></i>{{ $s->nama_orang_tua ?? '-' }}
                                </span>
                                @if($s->no_hp_orang_tua)
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $s->no_hp_orang_tua);
                                        if (str_starts_with($cleanPhone, '0')) {
                                            $cleanPhone = '62' . substr($cleanPhone, 1);
                                        }
                                    @endphp
                                    <a href="https://wa.me/{{ $cleanPhone }}"
                                       target="_blank" class="badge badge-soft-success text-decoration-none d-inline-flex align-items-center gap-1 align-self-start mt-1" title="Kirim Pesan WhatsApp">
                                        <i class="fa fa-whatsapp text-success fw-bold"></i> {{ $s->no_hp_orang_tua }}
                                    </a>
                                @else
                                    <span class="text-muted small fst-italic">Tanpa Kontak</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">
                            @if($s->is_active ?? true)
                                <span class="badge badge-soft-success px-2.5 py-1">
                                    <i class="fa fa-check me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge badge-soft-danger px-2.5 py-1">
                                    <i class="fa fa-ban me-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-inline-flex gap-1">
                                <a href="{{ route('admin.siswa.edit', $s->id) }}"
                                   class="btn btn-sm btn-outline-primary"
                                   title="Edit Data Siswa">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <button type="button"
                                        class="btn btn-sm btn-outline-danger btn-hapus"
                                        data-id="{{ $s->id }}"
                                        data-nama="{{ $s->nama_siswa }}"
                                        title="Nonaktifkan Siswa">
                                    <i class="fa fa-ban"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted py-3">
                                <i class="fa fa-inbox fa-3x mb-3 text-muted opacity-50 d-block"></i>
                                <h6 class="fw-bold mb-1">Data Siswa Tidak Ditemukan</h6>
                                <p class="small mb-2">Coba sesuaikan kata kunci pencarian atau filter kelas Anda.</p>
                                @if(request()->hasAny(['search', 'kelas_id']))
                                    <a href="{{ route('admin.siswa.index') }}" class="btn btn-sm btn-outline-secondary mt-1">
                                        <i class="fa fa-refresh me-1"></i> Reset Filter
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($siswa->hasPages())
    <div class="card-footer bg-white d-flex align-items-center justify-content-between py-3">
        <div class="text-muted small fw-medium">
            Menampilkan {{ $siswa->firstItem() }}–{{ $siswa->lastItem() }} dari <strong>{{ $siswa->total() }}</strong> siswa
        </div>
        <div>
            {{ $siswa->links() }}
        </div>
    </div>
    @endif
</div>

{{-- MODAL KONFIRMASI NONAKTIFKAN SISWA --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-labelledby="modalHapusLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalHapusLabel">
                    <i class="fa fa-exclamation-triangle me-2"></i>Konfirmasi Nonaktifkan Siswa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-1">Anda akan menonaktifkan siswa:</p>
                <p class="fw-bold fs-5 text-danger" id="modalNamaSiswa">—</p>
                <div class="alert alert-warning mb-0">
                    <i class="fa fa-info-circle me-2"></i>
                    <strong>Catatan:</strong> Data siswa tidak dihapus permanen. Riwayat poin pelanggaran tetap tersimpan sebagai arsip historis.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i>Batal
                </button>
                <form id="formHapus" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" id="btnKonfirmasiHapus">
                        <i class="fa fa-ban me-1"></i>Ya, Nonaktifkan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .font-monospace { font-family: SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace; font-size: .82rem; }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: '-- Semua Kelas --',
        allowClear: true,
        width: '100%'
    });

    $(document).on('click', '.btn-hapus', function () {
        var id   = $(this).data('id');
        var nama = $(this).data('nama');

        $('#modalNamaSiswa').text(nama);
        $('#formHapus').attr('action', '{{ url("admin/siswa") }}/' + id);
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush
