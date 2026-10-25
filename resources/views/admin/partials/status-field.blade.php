{{-- Field Status (Aktif / Nonaktif) yang dipakai semua form master data.
     Parameter: $active (bool, default true), $class (wrapper), $hint (teks bantuan opsional) --}}
@php $statusValue = (string) old('is_active', ($active ?? true) ? '1' : '0'); @endphp
<div class="{{ $class ?? 'mb-3' }}">
    <label for="is_active" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
    <select id="is_active" name="is_active" class="form-select @error('is_active') is-invalid @enderror" required>
        <option value="1" {{ $statusValue === '1' ? 'selected' : '' }}>Aktif</option>
        <option value="0" {{ $statusValue === '0' ? 'selected' : '' }}>Nonaktif</option>
    </select>
    @isset($hint)<div class="form-text">{{ $hint }}</div>@endisset
    @error('is_active')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
