<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with('roles');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'ILIKE', "%{$search}%")
                  ->orWhere('username', 'ILIKE', "%{$search}%")
                  ->orWhere('nip_nik', 'ILIKE', "%{$search}%")
                  ->orWhere('nik', 'ILIKE', "%{$search}%")
                  ->orWhere('nuptk', 'ILIKE', "%{$search}%")
                  ->orWhere('jabatan', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('role_id')) {
            $query->whereHas('roles', fn($q) => $q->where('roles.id', $request->role_id));
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        $users    = $query->orderBy('nama_lengkap')->paginate(15)->withQueryString();
        // Ambil semua role dari DB untuk filter dropdown (DINAMIS)
        $roleList = Role::orderBy('nama_role')->get();

        return view('admin.users.index', compact('users', 'roleList'));
    }

    public function create(): View
    {
        // Ambil semua role dari DB untuk checkbox multi-role (DINAMIS)
        $roleList = Role::orderBy('nama_role')->get();
        return view('admin.users.create', compact('roleList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'username'     => ['required', 'string', 'max:50', 'unique:users,username'],
            'email'        => ['nullable', 'email', 'unique:users,email'],
            'nip_nik'      => ['nullable', 'string', 'max:30'],
            'nik'          => ['nullable', 'string', 'max:30'],
            'jabatan'      => ['nullable', 'string', 'max:100'],
            'nuptk'        => ['nullable', 'string', 'max:30'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:100'],
            'jabatan_pokok' => ['nullable', 'string', 'max:100'],
            'jabatan_tambahan' => ['nullable', 'string', 'max:100'],
            'alamat'       => ['nullable', 'string', 'max:1000'],
            'tanggal_mulai_tugas' => ['nullable', 'date'],
            'no_hp'        => ['nullable', 'string', 'max:20'],
            'is_active'    => ['required', 'boolean'],
            'password'     => ['required', 'string', 'min:6', 'confirmed'],
            'roles'        => ['nullable', 'array'],
            'roles.*'      => ['exists:roles,id'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username ini sudah dipakai.',
            'password.required'     => 'Password wajib diisi.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name'         => $validated['nama_lengkap'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'username'     => $validated['username'],
            'email'        => $validated['email'] ?? null,
            'nip_nik'      => $validated['nip_nik'] ?? null,
            'nik'          => $validated['nik'] ?? null,
            'jabatan'      => $validated['jabatan'] ?? null,
            'nuptk'        => $validated['nuptk'] ?? null,
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'pendidikan_terakhir' => $validated['pendidikan_terakhir'] ?? null,
            'jabatan_pokok' => $validated['jabatan_pokok'] ?? null,
            'jabatan_tambahan' => $validated['jabatan_tambahan'] ?? null,
            'alamat'       => $validated['alamat'] ?? null,
            'tanggal_mulai_tugas' => $validated['tanggal_mulai_tugas'] ?? null,
            'no_hp'        => $validated['no_hp'] ?? null,
            'password'     => Hash::make($validated['password']),
            'is_active'    => $validated['is_active'],
        ]);

        // Assign roles dari DB (multi-role — bukan hardcoded array)
        if (!empty($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }

        return redirect()->route('admin.users.index')
            ->with('success', "User <strong>{$user->nama_lengkap}</strong> berhasil ditambahkan.");
    }

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.users.edit', $id);
    }

    public function edit(string $id): View
    {
        $user     = User::with('roles')->findOrFail($id);
        // Ambil semua role dari DB untuk checkbox (DINAMIS)
        $roleList = Role::orderBy('nama_role')->get();
        // ID role yang sudah dimiliki user ini
        $userRoleIds = $user->roles->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'roleList', 'userRoleIds'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $rules = [
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'username'     => ['required', 'string', 'max:50', Rule::unique('users', 'username')->ignore($user->id)],
            'email'        => ['nullable', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'nip_nik'      => ['nullable', 'string', 'max:30'],
            'nik'          => ['nullable', 'string', 'max:30'],
            'jabatan'      => ['nullable', 'string', 'max:100'],
            'nuptk'        => ['nullable', 'string', 'max:30'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:100'],
            'jabatan_pokok' => ['nullable', 'string', 'max:100'],
            'jabatan_tambahan' => ['nullable', 'string', 'max:100'],
            'alamat'       => ['nullable', 'string', 'max:1000'],
            'tanggal_mulai_tugas' => ['nullable', 'date'],
            'no_hp'        => ['nullable', 'string', 'max:20'],
            'is_active'    => ['required', 'boolean'],
            'roles'        => ['nullable', 'array'],
            'roles.*'      => ['exists:roles,id'],
        ];

        // Password bersifat opsional saat edit
        if ($request->filled('password')) {
            $rules['password'] = ['string', 'min:6', 'confirmed'];
        }

        $validated = $request->validate($rules);

        $updateData = [
            'name'         => $validated['nama_lengkap'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'username'     => $validated['username'],
            'email'        => $validated['email'] ?? null,
            'nip_nik'      => $validated['nip_nik'] ?? null,
            'nik'          => $validated['nik'] ?? null,
            'jabatan'      => $validated['jabatan'] ?? null,
            'nuptk'        => $validated['nuptk'] ?? null,
            'tempat_lahir' => $validated['tempat_lahir'] ?? null,
            'tanggal_lahir' => $validated['tanggal_lahir'] ?? null,
            'jenis_kelamin' => $validated['jenis_kelamin'] ?? null,
            'pendidikan_terakhir' => $validated['pendidikan_terakhir'] ?? null,
            'jabatan_pokok' => $validated['jabatan_pokok'] ?? null,
            'jabatan_tambahan' => $validated['jabatan_tambahan'] ?? null,
            'alamat'       => $validated['alamat'] ?? null,
            'tanggal_mulai_tugas' => $validated['tanggal_mulai_tugas'] ?? null,
            'no_hp'        => $validated['no_hp'] ?? null,
            'is_active'    => $validated['is_active'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        // Sync multi-role dari DB (DINAMIS)
        $user->roles()->sync($validated['roles'] ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', "User <strong>{$user->nama_lengkap}</strong> berhasil diperbarui.");
    }

    public function destroy(string $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        // Soft History: nonaktifkan, jangan hapus permanen
        $user->update(['is_active' => false]);

        return redirect()->route('admin.users.index')
            ->with('success', "User <strong>{$user->nama_lengkap}</strong> telah dinonaktifkan.");
    }
}
