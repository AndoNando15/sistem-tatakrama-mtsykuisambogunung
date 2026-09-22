<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil user yang sedang login.
     */
    public function show()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update data profil user yang sedang login.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username'     => ['required', 'string', 'max:50', 'unique:users,username,' . $user->id],
            'email'        => ['nullable', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'nip_nik'      => ['nullable', 'string', 'max:30'],
            'no_hp'        => ['nullable', 'string', 'max:20'],
        ];

        // Hanya validasi password jika diisi
        if ($request->filled('password')) {
            $rules['password']              = ['required', Password::min(6), 'confirmed'];
            $rules['password_confirmation'] = ['required'];
            $rules['current_password']      = ['required', function ($attr, $val, $fail) use ($user) {
                if (!Hash::check($val, $user->password)) {
                    $fail('Password lama tidak sesuai.');
                }
            }];
        }

        $validated = $request->validate($rules, [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'username.required'     => 'Username wajib diisi.',
            'username.unique'       => 'Username sudah digunakan.',
            'email.unique'          => 'Email sudah digunakan.',
            'password.min'          => 'Password minimal 6 karakter.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
        ]);

        // Kumpulkan data yang akan di-update
        $updateData = [
            'nama_lengkap' => $validated['nama_lengkap'],
            'name'         => $validated['nama_lengkap'], // sinkronkan name juga
            'username'     => $validated['username'],
            'email'        => $validated['email'] ?? null,
            'nip_nik'      => $validated['nip_nik'] ?? null,
            'no_hp'        => $validated['no_hp'] ?? null,
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
