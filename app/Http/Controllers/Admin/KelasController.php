<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class KelasController extends Controller
{
    public function index(Request $request): View
    {
        $query = Kelas::with('waliKelas');

        if ($request->filled('search')) {
            $query->where('nama_kelas', 'ILIKE', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        $kelas = $query->orderBy('nama_kelas')->paginate(15)->withQueryString();

        return view('admin.kelas.index', compact('kelas'));
    }

    public function create(): View
    {
        // Ambil user aktif dari DB untuk opsi wali kelas (DINAMIS)
        $guruList = User::where('is_active', true)->orderBy('nama_lengkap')->get();
        return view('admin.kelas.create', compact('guruList'));
    }

   public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'nama_kelas'    => ['required', 'string', 'max:50', 'unique:kelas,nama_kelas'],
        'wali_kelas_id' => ['nullable', 'exists:users,id'],
        'is_active'     => ['nullable', 'boolean'],
    ], [
        'nama_kelas.required' => 'Nama kelas wajib diisi.',
        'nama_kelas.unique'   => 'Nama kelas ini sudah ada.',
    ]);

    // Jika is_active tidak ada di request (misal checkbox tidak dicentang), set true secara default atau false sesuai kebutuhan
    $validated['is_active'] = $request->has('is_active');

    Kelas::create($validated);

    return redirect()->route('admin.kelas.index')
        ->with('success', "Kelas <strong>{$validated['nama_kelas']}</strong> berhasil ditambahkan.");
}

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.kelas.edit', $id);
    }

    public function edit(string $id): View
    {
        $kelas    = Kelas::findOrFail($id);
        $guruList = User::where('is_active', true)->orderBy('nama_lengkap')->get();
        return view('admin.kelas.edit', compact('kelas', 'guruList'));
    }

public function update(Request $request, string $id): RedirectResponse
{
    $kelas = Kelas::findOrFail($id);

    $validated = $request->validate([
        'nama_kelas'    => ['required', 'string', 'max:50', Rule::unique('kelas', 'nama_kelas')->ignore($kelas->id)],
        'wali_kelas_id' => ['nullable', 'exists:users,id'],
        'is_active'     => ['nullable', 'boolean'],
    ]);

    $validated['is_active'] = $request->has('is_active');

    $kelas->update($validated);

    return redirect()->route('admin.kelas.index')
        ->with('success', "Kelas <strong>{$kelas->nama_kelas}</strong> berhasil diperbarui.");
}

    public function destroy(string $id): RedirectResponse
    {
        $kelas = Kelas::findOrFail($id);
        // Soft History: nonaktifkan kelas, bukan hapus permanen
        $kelas->update(['is_active' => false]);

        return redirect()->route('admin.kelas.index')
            ->with('success', "Kelas <strong>{$kelas->nama_kelas}</strong> telah dinonaktifkan.");
    }
}
