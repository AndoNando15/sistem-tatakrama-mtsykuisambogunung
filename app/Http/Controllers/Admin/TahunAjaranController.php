<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class TahunAjaranController extends Controller
{
    public function index(Request $request): View
    {
        $query = TahunAjaran::query();

        if ($request->filled('search')) {
            $query->where('tahun', 'ILIKE', '%' . $request->search . '%');
        }

        $tahunAjaran = $query->orderByDesc('tahun')->orderBy('semester')->paginate(15)->withQueryString();

        return view('admin.tahun-ajaran.index', compact('tahunAjaran'));
    }

    public function create(): View
    {
        return view('admin.tahun-ajaran.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tahun'    => ['required', 'string', 'max:20'],
            'semester' => ['required', Rule::in(['ganjil', 'genap'])],
        ], [
            'tahun.required'    => 'Tahun ajaran wajib diisi (contoh: 2026/2027).',
            'semester.required' => 'Semester wajib dipilih.',
            'semester.in'       => 'Semester hanya boleh Ganjil atau Genap.',
        ]);

        // Validasi kombinasi tahun + semester tidak boleh duplikat
        $exists = TahunAjaran::where('tahun', $validated['tahun'])
                              ->where('semester', $validated['semester'])
                              ->exists();
        if ($exists) {
            return back()->withInput()->withErrors(['tahun' => 'Kombinasi tahun ajaran dan semester ini sudah ada.']);
        }

        $validated['is_active'] = false;
        TahunAjaran::create($validated);

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran <strong>{$validated['tahun']} ({$validated['semester']})</strong> berhasil ditambahkan.");
    }

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.tahun-ajaran.edit', $id);
    }

    public function edit(string $id): View
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return view('admin.tahun-ajaran.edit', compact('tahunAjaran'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);

        $validated = $request->validate([
            'tahun'    => ['required', 'string', 'max:20'],
            'semester' => ['required', Rule::in(['ganjil', 'genap'])],
        ]);

        // Cek duplikat kecuali record ini sendiri
        $exists = TahunAjaran::where('tahun', $validated['tahun'])
                              ->where('semester', $validated['semester'])
                              ->where('id', '!=', $tahunAjaran->id)
                              ->exists();
        if ($exists) {
            return back()->withInput()->withErrors(['tahun' => 'Kombinasi tahun ajaran dan semester ini sudah ada.']);
        }

        $tahunAjaran->update($validated);

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran berhasil diperbarui.");
    }

    public function destroy(string $id): RedirectResponse
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->delete(); // Tahun ajaran boleh dihapus permanen jika belum dipakai
        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran berhasil dihapus.");
    }

    /**
     * Toggle: jadikan tahun ajaran ini sebagai yang aktif (hanya 1 aktif sekaligus).
     */
    public function setAktif(string $id): RedirectResponse
    {
        // Nonaktifkan semua dahulu
        TahunAjaran::query()->update(['is_active' => false]);
        // Aktifkan yang dipilih
        $tahunAjaran = TahunAjaran::findOrFail($id);
        $tahunAjaran->update(['is_active' => true]);

        return redirect()->route('admin.tahun-ajaran.index')
            ->with('success', "Tahun ajaran <strong>{$tahunAjaran->tahun} ({$tahunAjaran->semester})</strong> kini menjadi tahun ajaran aktif.");
    }
}
