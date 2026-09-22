<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriPelanggaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class KategoriPelanggaranController extends Controller
{
    public function index(Request $request): View
    {
        $query = KategoriPelanggaran::withCount('jenisPelanggaran');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_kategori', 'ILIKE', "%{$search}%")
                  ->orWhere('kode', 'ILIKE', "%{$search}%");
            });
        }

        $kategori = $query->orderBy('kode')->paginate(15)->withQueryString();

        return view('admin.kategori-pelanggaran.index', compact('kategori'));
    }

    public function create(): View
    {
        return view('admin.kategori-pelanggaran.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kode'            => ['required', 'string', 'max:10', 'unique:kategori_pelanggaran,kode'],
            'nama_kategori'   => ['required', 'string', 'max:150'],
            'sifat_akumulasi' => ['required', Rule::in(['semester', 'tahunan', 'selamanya'])],
        ], [
            'kode.required'            => 'Kode kategori wajib diisi (contoh: K1).',
            'kode.unique'              => 'Kode ini sudah digunakan.',
            'nama_kategori.required'   => 'Nama kategori wajib diisi.',
            'sifat_akumulasi.required' => 'Sifat akumulasi wajib dipilih.',
        ]);

        KategoriPelanggaran::create($validated);

        return redirect()->route('admin.kategori-pelanggaran.index')
            ->with('success', "Kategori <strong>{$validated['kode']} - {$validated['nama_kategori']}</strong> berhasil ditambahkan.");
    }

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.kategori-pelanggaran.edit', $id);
    }

    public function edit(string $id): View
    {
        $kategori = KategoriPelanggaran::findOrFail($id);
        return view('admin.kategori-pelanggaran.edit', compact('kategori'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $kategori = KategoriPelanggaran::findOrFail($id);

        $validated = $request->validate([
            'kode'            => ['required', 'string', 'max:10', Rule::unique('kategori_pelanggaran', 'kode')->ignore($kategori->id)],
            'nama_kategori'   => ['required', 'string', 'max:150'],
            'sifat_akumulasi' => ['required', Rule::in(['semester', 'tahunan', 'selamanya'])],
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategori-pelanggaran.index')
            ->with('success', "Kategori <strong>{$kategori->kode} - {$kategori->nama_kategori}</strong> berhasil diperbarui.");
    }

    public function destroy(string $id): RedirectResponse
    {
        $kategori = KategoriPelanggaran::withCount('jenisPelanggaran')->findOrFail($id);

        if ($kategori->jenis_pelanggaran_count > 0) {
            return redirect()->route('admin.kategori-pelanggaran.index')
                ->with('error', "Kategori <strong>{$kategori->nama_kategori}</strong> tidak dapat dihapus karena masih memiliki {$kategori->jenis_pelanggaran_count} jenis pelanggaran.");
        }

        $kategori->delete();

        return redirect()->route('admin.kategori-pelanggaran.index')
            ->with('success', "Kategori <strong>{$kategori->nama_kategori}</strong> berhasil dihapus.");
    }
}
