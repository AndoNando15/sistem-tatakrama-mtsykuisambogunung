<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    // ==========================================================
    // INDEX — Daftar siswa aktif dengan filter & search
    // ==========================================================

    /**
     * Tampilkan daftar siswa aktif dengan fitur pencarian dan filter kelas.
     * Semua data bersumber dari query Eloquent dinamis — tidak ada data statis.
     */
    public function index(Request $request): View
    {
        // Query dasar: hanya siswa aktif, eager load relasi kelas
        $query = Siswa::aktif()->with('kelas');

        // Filter pencarian: nama siswa atau NIS/NISN
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'ILIKE', "%{$search}%")
                  ->orWhere('nis_nisn', 'ILIKE', "%{$search}%");
            });
        }

        // Filter berdasarkan kelas (dari dropdown dinamis)
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        // Paginasi 15 data per halaman, pertahankan query string
        $siswa = $query->orderBy('nama_siswa', 'asc')->paginate(15)->withQueryString();

        // Ambil semua kelas aktif dari DB untuk dropdown filter (DINAMIS)
        $kelasList = Kelas::aktif()->orderBy('nama_kelas', 'asc')->get();

        return view('admin.siswa.index', compact('siswa', 'kelasList'));
    }

    // ==========================================================
    // CREATE — Form tambah siswa baru
    // ==========================================================

    /**
     * Tampilkan form untuk menambah data siswa baru.
     * Daftar kelas di-query secara dinamis dari database.
     */
    public function create(): View
    {
        // Ambil kelas aktif dari DB untuk opsi <select> (DINAMIS — bukan array statis)
        $kelasList = Kelas::aktif()->orderBy('nama_kelas', 'asc')->get();

        return view('admin.siswa.create', compact('kelasList'));
    }

    // ==========================================================
    // STORE — Simpan data siswa baru ke database
    // ==========================================================

    /**
     * Validasi dan simpan data siswa baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nis_nisn'        => ['required', 'string', 'max:20', 'unique:siswa,nis_nisn'],
            'nama_siswa'      => ['required', 'string', 'max:150'],
            'kelas_id'        => ['required', 'integer', 'exists:kelas,id'],
            'jenis_kelamin'   => ['required', Rule::in(['L', 'P'])],
            'nomor_induk_kemenag' => ['nullable', 'string', 'max:255'],
            'tempat_lahir'    => ['nullable', 'string', 'max:255'],
            'tanggal_lahir'   => ['nullable', 'date'],
            'nama_orang_tua'  => ['nullable', 'string', 'max:150'],
            'nama_ibu'        => ['nullable', 'string', 'max:255'],
            'no_hp_orang_tua' => ['nullable', 'string', 'max:20'],
            'alamat'          => ['nullable', 'string'],
            'rt'              => ['nullable', 'string', 'max:255'],
            'asal_sekolah'    => ['nullable', 'string', 'max:255'],
        ], [
            'nis_nisn.required'      => 'NIS/NISN wajib diisi.',
            'nis_nisn.unique'        => 'NIS/NISN ini sudah terdaftar di sistem.',
            'nama_siswa.required'    => 'Nama siswa wajib diisi.',
            'kelas_id.required'      => 'Kelas wajib dipilih.',
            'kelas_id.exists'        => 'Kelas yang dipilih tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin hanya boleh L (Laki-laki) atau P (Perempuan).',
        ]);

        // Set status aktif secara default
        $validated['is_active'] = true;

        $siswa = Siswa::create($validated);
        $siswa->catatRiwayatKelas();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', "Data siswa <strong>{$validated['nama_siswa']}</strong> berhasil ditambahkan.");
    }

    // ==========================================================
    // SHOW — (Tidak digunakan, redirect ke edit)
    // ==========================================================

    public function show(string $id): RedirectResponse
    {
        return redirect()->route('admin.siswa.edit', $id);
    }

    // ==========================================================
    // EDIT — Form edit data siswa
    // ==========================================================

    /**
     * Tampilkan form edit data siswa berdasarkan ID.
     * Data siswa & daftar kelas di-query dari database.
     */
    public function edit(string $id): View
    {
        // Ambil data siswa berdasarkan ID (hanya yang aktif)
        $siswa = Siswa::aktif()->findOrFail($id);

        // Ambil semua kelas aktif dari DB untuk dropdown (DINAMIS)
        $kelasList = Kelas::aktif()->orderBy('nama_kelas', 'asc')->get();

        return view('admin.siswa.edit', compact('siswa', 'kelasList'));
    }

    // ==========================================================
    // UPDATE — Perbarui data siswa di database
    // ==========================================================

    /**
     * Validasi dan update data siswa yang ada.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $siswa = Siswa::aktif()->findOrFail($id);

        $validated = $request->validate([
            'nis_nisn'        => ['required', 'string', 'max:20', Rule::unique('siswa', 'nis_nisn')->ignore($siswa->id)],
            'nama_siswa'      => ['required', 'string', 'max:150'],
            'kelas_id'        => ['required', 'integer', 'exists:kelas,id'],
            'jenis_kelamin'   => ['required', Rule::in(['L', 'P'])],
            'nomor_induk_kemenag' => ['nullable', 'string', 'max:255'],
            'tempat_lahir'    => ['nullable', 'string', 'max:255'],
            'tanggal_lahir'   => ['nullable', 'date'],
            'nama_orang_tua'  => ['nullable', 'string', 'max:150'],
            'nama_ibu'        => ['nullable', 'string', 'max:255'],
            'no_hp_orang_tua' => ['nullable', 'string', 'max:20'],
            'alamat'          => ['nullable', 'string'],
            'rt'              => ['nullable', 'string', 'max:255'],
            'asal_sekolah'    => ['nullable', 'string', 'max:255'],
        ], [
            'nis_nisn.required'      => 'NIS/NISN wajib diisi.',
            'nis_nisn.unique'        => 'NIS/NISN ini sudah digunakan oleh siswa lain.',
            'nama_siswa.required'    => 'Nama siswa wajib diisi.',
            'kelas_id.required'      => 'Kelas wajib dipilih.',
            'kelas_id.exists'        => 'Kelas yang dipilih tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        $siswa->update($validated);
        $siswa->catatRiwayatKelas();

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', "Data siswa <strong>{$siswa->nama_siswa}</strong> berhasil diperbarui.");
    }

    // ==========================================================
    // DESTROY — Soft delete: ubah is_active = false
    // ==========================================================

    /**
     * Nonaktifkan siswa (soft history — BUKAN hard delete).
     * Riwayat poin siswa tetap utuh karena data tidak dihapus permanen.
     */
    public function destroy(string $id): RedirectResponse
    {
        $siswa = Siswa::aktif()->findOrFail($id);

        // Prinsip Soft History: ubah flag is_active menjadi false,
        // bukan menghapus record dari database.
        $siswa->update(['is_active' => false]);

        return redirect()
            ->route('admin.siswa.index')
            ->with('success', "Siswa <strong>{$siswa->nama_siswa}</strong> telah dinonaktifkan. Riwayat poin tetap tersimpan.");
    }
}
