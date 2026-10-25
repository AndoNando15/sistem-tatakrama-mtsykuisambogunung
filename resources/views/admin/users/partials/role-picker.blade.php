{{-- Pilihan role (multi-select). Parameter: $roleList, $selected (array id role terpilih) --}}
<style>
    .role-picker .role-card { position: relative; display: block; height: 100%; cursor: pointer; margin: 0; }
    .role-picker .role-card input { position: absolute; opacity: 0; pointer-events: none; }
    .role-picker .role-card .role-body {
        display: flex; align-items: center; gap: .75rem; height: 100%;
        padding: .65rem .85rem; border: 1px solid #dee2e6; border-radius: .5rem;
        background: #fff; transition: all .15s ease;
    }
    .role-picker .role-card:hover .role-body { border-color: #86b7fe; background: #f8fbff; }
    .role-picker .role-check {
        flex: 0 0 22px; width: 22px; height: 22px; border-radius: 6px; border: 2px solid #ced4da;
        display: inline-flex; align-items: center; justify-content: center; color: transparent; font-size: 12px;
        transition: all .15s ease;
    }
    .role-picker .role-card input:checked + .role-body { border-color: #0d6efd; background: #eef4ff; box-shadow: 0 0 0 1px #0d6efd inset; }
    .role-picker .role-card input:checked + .role-body .role-check { background: #0d6efd; border-color: #0d6efd; color: #fff; }
    .role-picker .role-card input:focus-visible + .role-body { outline: 2px solid #0d6efd; outline-offset: 2px; }
    .role-picker .role-name { font-weight: 600; color: #212529; line-height: 1.2; }
    .role-picker .role-desc { font-size: .75rem; color: #6c757d; line-height: 1.2; }
</style>

<div class="role-picker">
    <label class="form-label fw-semibold d-block mb-1">Role Pengguna <span class="text-muted fw-normal">(dapat pilih lebih dari 1)</span></label>
    <div class="row g-2">
        @foreach($roleList as $role)
            <div class="col-lg-4 col-sm-6">
                <label class="role-card" for="role_{{ $role->id }}">
                    <input type="checkbox" name="roles[]" value="{{ $role->id }}" id="role_{{ $role->id }}"
                        {{ in_array($role->id, $selected) ? 'checked' : '' }}>
                    <span class="role-body">
                        <span class="role-check"><i class="fa fa-check"></i></span>
                        <span>
                            <span class="role-name d-block">{{ $role->label }}</span>
                            @if($role->keterangan)
                                <span class="role-desc d-block">{{ $role->keterangan }}</span>
                            @endif
                        </span>
                    </span>
                </label>
            </div>
        @endforeach
    </div>
    @error('roles')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
</div>