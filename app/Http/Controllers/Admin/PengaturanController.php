<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PengaturanSistem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    public function index(): View
    {
        $settings = PengaturanSistem::getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_sekolah'        => ['required', 'string', 'max:150'],
            'npsn'                => ['nullable', 'string', 'max:30'],
            'alamat_sekolah'      => ['nullable', 'string'],
            'nama_kepala_sekolah' => ['nullable', 'string', 'max:150'],
            'nip_kepala_sekolah'  => ['nullable', 'string', 'max:50'],
            'nama_guru_bk'        => ['nullable', 'string', 'max:150'],
            'nip_guru_bk'         => ['nullable', 'string', 'max:50'],
        ]);

        $settings = PengaturanSistem::getSettings();
        $settings->update($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Pengaturan identitas sekolah berhasil diperbarui.');
    }
}
