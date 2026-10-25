<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RoleController extends Controller
{
    // Role bawaan dipakai oleh logika akses, jadi tidak boleh diubah namanya atau dihapus.
    private const SYSTEM_ROLES = ['admin', 'guru', 'wali_kelas', 'kepsek'];

    public function index(): View
    {
        $roles = Role::withCount('users')->orderBy('nama_role')->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function create(): View
    {
        return view('admin.roles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_role'  => ['required', 'string', 'max:50', 'regex:/^[a-z0-9_]+$/', 'unique:roles,nama_role'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ], [
            'nama_role.required' => 'Nama role wajib diisi.',
            'nama_role.regex'    => 'Nama role hanya boleh huruf kecil, angka, dan underscore.',
            'nama_role.unique'   => 'Nama role ini sudah ada.',
        ]);

        $role = Role::create($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', "Role <strong>{$role->label}</strong> berhasil ditambahkan.");
    }

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.roles.edit', $id);
    }

    public function edit(string $id): View
    {
        $role     = Role::findOrFail($id);
        $isSystem = in_array($role->nama_role, self::SYSTEM_ROLES, true);

        return view('admin.roles.edit', compact('role', 'isSystem'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $role     = Role::findOrFail($id);
        $isSystem = in_array($role->nama_role, self::SYSTEM_ROLES, true);

        $rules = ['keterangan' => ['nullable', 'string', 'max:255']];
        if (!$isSystem) {
            $rules['nama_role'] = ['required', 'string', 'max:50', 'regex:/^[a-z0-9_]+$/', Rule::unique('roles', 'nama_role')->ignore($role->id)];
        }

        $validated = $request->validate($rules, [
            'nama_role.regex'  => 'Nama role hanya boleh huruf kecil, angka, dan underscore.',
            'nama_role.unique' => 'Nama role ini sudah ada.',
        ]);

        $role->update($validated);

        return redirect()->route('admin.roles.index')
            ->with('success', "Role <strong>{$role->label}</strong> berhasil diperbarui.");
    }

    public function destroy(string $id): RedirectResponse
    {
        $role = Role::withCount('users')->findOrFail($id);

        if (in_array($role->nama_role, self::SYSTEM_ROLES, true)) {
            return back()->with('error', "Role <strong>{$role->label}</strong> adalah role bawaan sistem dan tidak dapat dihapus.");
        }

        if ($role->users_count > 0) {
            return back()->with('error', "Role <strong>{$role->label}</strong> masih dipakai {$role->users_count} user.");
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('success', "Role <strong>{$role->label}</strong> berhasil dihapus.");
    }
}
