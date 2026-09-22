<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use App\Models\KategoriPelanggaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class JenisPelanggaranController extends Controller
{
    public function index(Request $request): View
    {
        $query = JenisPelanggaran::aktif()->with('kategori');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('uraian_pelanggaran', 'ILIKE', "%{$search}%")
                  ->orWhere('kode_pelanggaran', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $jenisPelanggaran = $query->orderBy('kategori_id')->orderBy('kode_pelanggaran')->paginate(15)->withQueryString();

        // Dropdown filter kategori dari DB (DINAMIS)
        $kategoriList = KategoriPelanggaran::orderBy('kode')->get();

        return view('admin.jenis-pelanggaran.index', compact('jenisPelanggaran', 'kategoriList'));
    }

    public function create(): View
    {
        // Ambil semua kategori dari DB (DINAMIS — bukan hardcoded)
        $kategoriList = KategoriPelanggaran::orderBy('kode')->get();
        return view('admin.jenis-pelanggaran.create', compact('kategoriList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kategori_id'        => ['required', 'exists:kategori_pelanggaran,id'],
            'kode_pelanggaran'   => ['nullable', 'string', 'max:20'],
            'uraian_pelanggaran' => ['required', 'string'],
            'poin'               => ['required', 'integer', 'min:1', 'max:100'],
            'sanksi_default'     => ['nullable', 'string'],
        ], [
            'kategori_id.required'        => 'Kategori pelanggaran wajib dipilih.',
            'kategori_id.exists'          => 'Kategori yang dipilih tidak valid.',
            'uraian_pelanggaran.required' => 'Uraian pelanggaran wajib diisi.',
            'poin.required'               => 'Poin wajib diisi.',
            'poin.min'                    => 'Poin minimal 1.',
        ]);

        $validated['is_active'] = true;
        JenisPelanggaran::create($validated);

        return redirect()->route('admin.jenis-pelanggaran.index')
            ->with('success', 'Jenis pelanggaran baru berhasil ditambahkan.');
    }

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.jenis-pelanggaran.edit', $id);
    }

    public function edit(string $id): View
    {
        $jenis        = JenisPelanggaran::aktif()->findOrFail($id);
        $kategoriList = KategoriPelanggaran::orderBy('kode')->get();
        return view('admin.jenis-pelanggaran.edit', compact('jenis', 'kategoriList'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $jenis = JenisPelanggaran::aktif()->findOrFail($id);

        $validated = $request->validate([
            'kategori_id'        => ['required', 'exists:kategori_pelanggaran,id'],
            'kode_pelanggaran'   => ['nullable', 'string', 'max:20'],
            'uraian_pelanggaran' => ['required', 'string'],
            'poin'               => ['required', 'integer', 'min:1', 'max:100'],
            'sanksi_default'     => ['nullable', 'string'],
        ]);

        $jenis->update($validated);

        return redirect()->route('admin.jenis-pelanggaran.index')
            ->with('success', 'Jenis pelanggaran berhasil diperbarui.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $jenis = JenisPelanggaran::aktif()->findOrFail($id);
        // Soft History: nonaktifkan agar riwayat poin siswa tetap valid
        $jenis->update(['is_active' => false]);

        return redirect()->route('admin.jenis-pelanggaran.index')
            ->with('success', "Jenis pelanggaran <strong>{$jenis->kode_pelanggaran}</strong> telah dinonaktifkan. Riwayat poin siswa tetap tersimpan.");
    }
}
