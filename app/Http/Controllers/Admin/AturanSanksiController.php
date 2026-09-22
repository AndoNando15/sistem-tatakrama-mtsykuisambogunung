<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AturanSanksiKumulasi;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AturanSanksiController extends Controller
{
    public function index(): View
    {
        $aturan = AturanSanksiKumulasi::orderBy('min_poin')->paginate(20);
        return view('admin.aturan-sanksi.index', compact('aturan'));
    }

    public function create(): View
    {
        return view('admin.aturan-sanksi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'min_poin'    => ['required', 'integer', 'min:0'],
            'max_poin'    => ['required', 'integer', 'min:1', 'gte:min_poin'],
            'tindakan'    => ['required', 'string'],
            'nilai_sikap' => ['nullable', 'string', 'size:1'],
        ], [
            'min_poin.required'  => 'Poin minimum wajib diisi.',
            'max_poin.required'  => 'Poin maksimum wajib diisi.',
            'max_poin.gte'       => 'Poin maksimum harus lebih besar atau sama dengan poin minimum.',
            'tindakan.required'  => 'Tindakan/sanksi wajib diisi.',
            'nilai_sikap.size'   => 'Nilai sikap hanya boleh 1 karakter (A/B/C/D).',
        ]);

        AturanSanksiKumulasi::create($validated);

        return redirect()->route('admin.aturan-sanksi.index')
            ->with('success', "Aturan sanksi ({$validated['min_poin']}–{$validated['max_poin']} poin) berhasil ditambahkan.");
    }

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.aturan-sanksi.edit', $id);
    }

    public function edit(string $id): View
    {
        $aturan = AturanSanksiKumulasi::findOrFail($id);
        return view('admin.aturan-sanksi.edit', compact('aturan'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $aturan = AturanSanksiKumulasi::findOrFail($id);

        $validated = $request->validate([
            'min_poin'    => ['required', 'integer', 'min:0'],
            'max_poin'    => ['required', 'integer', 'min:1', 'gte:min_poin'],
            'tindakan'    => ['required', 'string'],
            'nilai_sikap' => ['nullable', 'string', 'size:1'],
        ]);

        $aturan->update($validated);

        return redirect()->route('admin.aturan-sanksi.index')
            ->with('success', "Aturan sanksi berhasil diperbarui.");
    }

    public function destroy(string $id): RedirectResponse
    {
        $aturan = AturanSanksiKumulasi::findOrFail($id);
        $label  = "{$aturan->min_poin}–{$aturan->max_poin} poin";
        $aturan->delete();

        return redirect()->route('admin.aturan-sanksi.index')
            ->with('success', "Aturan sanksi ({$label}) berhasil dihapus.");
    }
}
