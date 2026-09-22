@extends('layouts.admin')

@section('title', 'Input Poin Siswa')

@section('page-header')
<div class="page-header">
    <div class="row align-items-center">
        <div class="col">
            <h3 class="page-title">Input Poin Pelanggaran Siswa</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Input Poin Siswa</li>
            </ul>
        </div>
        <div class="col-auto">
            <a href="{{ route('admin.poin.create') }}" class="btn btn-primary shadow-sm">
                <i class="fa fa-plus me-1"></i> Catat Pelanggaran Baru
            </a>
        </div>
    </div>
</div>
@endsection

@section('content')
{{-- FILTER --}}
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-body py-3">
        <form action="{{ route('admin.poin.index') }}" method="GET">
            <div class="row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">Cari Siswa</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted border-end-0"><i class="fa fa-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Nama / NISN..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-semibold text-muted mb-1">Kelas</label>
                    <select name="kelas_id" class="form-select">
                        <option value="">-- Semua Kelas --</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted mb-1">Dari Tanggal</label>
                    <input type="date" name="tanggal_mulai" class="form-control" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-semibold text-muted mb-1">Sampai Tanggal</label>
                    <input type="date" name="tanggal_selesai" class="form-control" value="{{ request('tanggal_selesai') }}">
                </div>
                <div class="col-md-2">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter me-1"></i> Filter</button>
                        <a href="{{ route('admin.poin.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="fa fa-refresh"></i></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- TABEL --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <div class="d-flex align-items-center gap-2">
            <div class="badge bg-soft-success text-success p-2 rounded-circle">
                <i class="fe fe-clipboard fs-5"></i>
            </div>
            <h5 class="card-title mb-0 fw-bold text-dark">Riwayat Transaksi Pelanggaran Siswa</h5>
        </div>
        <span class="badge bg-primary rounded-pill px-3 py-2">Total: {{ $pelanggaran->total() }} Catatan</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th width="50" class="text-center">#</th>
                        <th>Tanggal</th>
                        <th>Siswa & Kelas</th>
                        <th>Kategori & Uraian Pelanggaran</th>
                        <th class="text-center">Poin</th>
                        <th>Tindak Lanjut</th>
                        <th>Pelapor</th>
                        <th class="text-center" width="90">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggaran as $index => $p)
                    <tr>
                        <td class="text-center text-muted small fw-semibold">{{ $pelanggaran->firstItem() + $index }}</td>
                        <td>
                            <span class="badge badge-soft-dark font-monospace px-2 py-1">
                                <i class="fa fa-calendar me-1 text-muted"></i>{{ $p->tanggal ? $p->tanggal->format('d/m/Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar-initial avatar-initial-sm">
                                    {{ strtoupper(substr($p->siswa->nama_siswa ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $p->siswa->nama_siswa ?? '-' }}</div>
                                    <div class="d-flex align-items-center gap-1 mt-0.5">
                                        <span class="badge badge-soft-info px-1.5 py-0.5">
                                            <i class="fe fe-grid me-1"></i>{{ $p->siswa->kelas->nama_kelas ?? '-' }}
                                        </span>
                                        <span class="badge badge-soft-dark font-monospace px-1.5 py-0.5">
                                            {{ $p->siswa->nis_nisn ?? '-' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($p->jenisPelanggaran)
                                <div class="mb-1">
                                    <span class="badge badge-soft-info fw-semibold px-2 py-0.5">
                                        <i class="fa fa-tag me-1"></i>{{ $p->jenisPelanggaran->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </div>
                                <div class="fw-semibold text-dark fs-6">{{ $p->jenisPelanggaran->uraian_pelanggaran }}</div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge badge-soft-danger rounded-pill px-3 py-1.5 fs-6 fw-bold">
                                +{{ $p->poin }} Poin
                            </span>
                        </td>
                        <td>
                            @if(!empty($p->tindak_lanjut))
                                <span class="text-secondary small">
                                    <i class="fa fa-info-circle me-1 text-muted"></i>{{ $p->tindak_lanjut }}
                                </span>
                            @else
                                <span class="text-muted small fst-italic">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-soft-dark px-2 py-1">
                                <i class="fa fa-user me-1 text-muted"></i>{{ $p->pelapor->nama_lengkap ?? $p->pelapor->name ?? 'Admin' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-outline-danger btn-hapus" data-id="{{ $p->id }}" data-nama="{{ $p->siswa->nama_siswa ?? '' }}" title="Hapus Catatan">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <div class="text-muted py-3">
                                <i class="fe fe-clipboard fa-3x mb-3 text-muted opacity-50 d-block"></i>
                                <h6 class="fw-bold mb-1">Belum Ada Catatan Pelanggaran</h6>
                                <p class="small mb-0">Tidak ditemukan transaksi pelanggaran yang sesuai filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($pelanggaran->hasPages())
    <div class="card-footer bg-white d-flex align-items-center justify-content-between py-3">
        <div class="text-muted small fw-medium">Menampilkan {{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari <strong>{{ $pelanggaran->total() }}</strong> catatan</div>
        <div>{{ $pelanggaran->links() }}</div>
    </div>
    @endif
</div>

{{-- MODAL HAPUS --}}
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fa fa-exclamation-triangle me-2"></i>Hapus Catatan Pelanggaran</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-1">Apakah Anda yakin ingin menghapus catatan pelanggaran siswa:</p>
                <p class="fw-bold fs-5 text-danger" id="modalNamaSiswa">—</p>
                <div class="alert alert-warning mb-0"><i class="fa fa-info-circle me-2"></i>Penghapusan catatan akan secara otomatis mengurangkan akumulasi poin siswa terkait.</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="formHapus" method="POST" action="">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash me-1"></i>Ya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $(document).on('click', '.btn-hapus', function () {
        $('#modalNamaSiswa').text($(this).data('nama'));
        $('#formHapus').attr('action', '{{ url("admin/poin") }}/' + $(this).data('id'));
        $('#modalHapus').modal('show');
    });
});
</script>
@endpush
