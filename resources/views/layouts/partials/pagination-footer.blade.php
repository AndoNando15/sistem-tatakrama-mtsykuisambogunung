{{-- Footer pagination bersama untuk halaman master.
     Parameter: $paginator (LengthAwarePaginator), $noun (satuan data, mis. "siswa") --}}
@if($paginator->total() > 0)
<div class="card-footer bg-white d-flex flex-column flex-md-row gap-2 align-items-center justify-content-between py-3">
    <div class="text-muted small fw-medium text-center text-md-start">
        Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari
        <strong>{{ $paginator->total() }}</strong> {{ $noun ?? 'data' }}
        @if($paginator->hasPages())
            <span class="d-md-none">· Hal. {{ $paginator->currentPage() }}/{{ $paginator->lastPage() }}</span>
        @endif
    </div>
    @if($paginator->hasPages())
        <div class="d-none d-md-block">{{ $paginator->links() }}</div>
        <div class="d-md-none m-pager w-100">{{ $paginator->links('pagination::simple-bootstrap-5') }}</div>
    @endif
</div>
@endif
