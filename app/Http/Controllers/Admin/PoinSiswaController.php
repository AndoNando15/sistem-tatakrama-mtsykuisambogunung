<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use App\Models\PelanggaranSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PoinSiswaController extends Controller
{
    public function index(Request $request): View
    {
        $query = PelanggaranSiswa::with(['siswa.kelas', 'jenisPelanggaran.kategori', 'pelapor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_siswa', 'ILIKE', "%{$search}%")
                  ->orWhere('nis_nisn', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $pelanggaran = $query->orderByDesc('tanggal')->orderByDesc('id')->paginate(15)->withQueryString();

        $kelasList = \App\Models\Kelas::where('is_active', true)->orderBy('nama_kelas')->get();

        return view('admin.poin.index', compact('pelanggaran', 'kelasList'));
    }

    public function create(): View
    {
        $kelasList = \App\Models\Kelas::where('is_active', true)
            ->with(['siswa' => fn($q) => $q->aktif()->orderBy('nama_siswa')])
            ->orderBy('nama_kelas')
            ->get();

        $kategoriList = \App\Models\KategoriPelanggaran::with(['jenisPelanggaran' => fn($q) => $q->where('is_active', true)->orderBy('kode_pelanggaran')])
            ->orderBy('kode')
            ->get();

        $tahunAktif = TahunAjaran::where('is_active', true)->first();

        return view('admin.poin.create', compact('kelasList', 'kategoriList', 'tahunAktif'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id'             => ['required', 'exists:siswa,id'],
            'jenis_pelanggaran_id' => ['required', 'exists:jenis_pelanggaran,id'],
            'tanggal'              => ['required', 'date'],
            'catatan'              => ['nullable', 'string'],
            'tindak_lanjut'        => ['nullable', 'string'],
        ], [
            'siswa_id.required'             => 'Siswa wajib dipilih.',
            'jenis_pelanggaran_id.required' => 'Jenis pelanggaran wajib dipilih.',
            'tanggal.required'              => 'Tanggal kejadian wajib diisi.',
        ]);

        $jenis = JenisPelanggaran::findOrFail($validated['jenis_pelanggaran_id']);
        $tahunAktif = TahunAjaran::where('is_active', true)->first();

        PelanggaranSiswa::create([
            'siswa_id'             => $validated['siswa_id'],
            'jenis_pelanggaran_id' => $validated['jenis_pelanggaran_id'],
            'tahun_ajaran_id'      => $tahunAktif?->id,
            'user_id'              => auth()->id(),
            'poin'                 => $jenis->poin,
            'tanggal'              => $validated['tanggal'],
            'catatan'              => $validated['catatan'] ?? null,
            'tindak_lanjut'        => $validated['tindak_lanjut'] ?? $jenis->sanksi_default,
        ]);

        return redirect()->route('admin.poin.index')
            ->with('success', 'Catatan poin pelanggaran siswa berhasil disimpan.');
    }

    public function destroy(string $id): RedirectResponse
    {
        $pelanggaran = PelanggaranSiswa::findOrFail($id);
        $pelanggaran->delete();

        return redirect()->route('admin.poin.index')
            ->with('success', 'Catatan poin pelanggaran berhasil dihapus.');
    }
}
