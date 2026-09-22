<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
        ]);

        $user = \App\Models\User::where('username', $request->username)->first();

        if ($user) {
            // Pengecekan Status Aktif
            if (!$user->is_active) {
                return back()->withInput()->withErrors([
                    'username' => 'Akun Anda telah dinonaktifkan. Silakan hubungi Administrator.',
                ]);
            }

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            // Redirect berdasarkan Role
            $namaUser = $user->nama_lengkap ?: $user->name;

            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'))
                    ->with('success', "Selamat datang kembali, <strong>{$namaUser}</strong>!");
            }

            return redirect()->intended(route('guru.dashboard'))
                ->with('success', "Selamat datang kembali, <strong>{$namaUser}</strong>!");
        }

        return back()->withInput()->withErrors([
            'username' => 'Username tidak ditemukan.',
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
