<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class MataPelajaranController extends Controller
{
    public function index(Request $request): View
    {
        $query = MataPelajaran::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_mapel', 'ILIKE', "%{$search}%")
                  ->orWhere('kode_mapel', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        $mataPelajaran = $query->orderBy('kode_mapel')->paginate(15)->withQueryString();

        return view('admin.mata-pelajaran.index', compact('mataPelajaran'));
    }

    public function create(): View
    {
        return view('admin.mata-pelajaran.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode_mapel' => ['required', 'string', 'max:20', 'unique:mata_pelajaran,kode_mapel'],
            'nama_mapel' => ['required', 'string', 'max:100'],
        ], [
            'kode_mapel.required' => 'Kode mata pelajaran wajib diisi.',
            'kode_mapel.unique'   => 'Kode mata pelajaran ini sudah ada.',
            'nama_mapel.required' => 'Nama mata pelajaran wajib diisi.',
        ]);

        $validated['is_active'] = true;
        MataPelajaran::create($validated);

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', "Mata pelajaran <strong>{$validated['nama_mapel']}</strong> berhasil ditambahkan.");
    }

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.mata-pelajaran.edit', $id);
    }

    public function edit(string $id): View
    {
        $mataPelajaran = MataPelajaran::findOrFail($id);
        return view('admin.mata-pelajaran.edit', compact('mataPelajaran'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $mapel = MataPelajaran::findOrFail($id);

        $validated = $request->validate([
            'kode_mapel' => ['required', 'string', 'max:20', Rule::unique('mata_pelajaran', 'kode_mapel')->ignore($mapel->id)],
            'nama_mapel' => ['required', 'string', 'max:100'],
        ]);

        $mapel->update($validated);

        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', "Mata pelajaran <strong>{$mapel->nama_mapel}</strong> berhasil diperbarui.");
    }

    public function destroy(string $id): RedirectResponse
    {
        $mapel = MataPelajaran::findOrFail($id);
        $mapel->update(['is_active' => false]);
        return redirect()->route('admin.mata-pelajaran.index')
            ->with('success', "Mata pelajaran <strong>{$mapel->nama_mapel}</strong> dinonaktifkan.");
    }
}
