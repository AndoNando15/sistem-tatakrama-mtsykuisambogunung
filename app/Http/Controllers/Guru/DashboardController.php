<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\JenisPelanggaran;
use App\Models\KategoriPelanggaran;
use App\Models\Kelas;
use App\Models\PelanggaranSiswa;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $tahunAktif = TahunAjaran::where('is_active', true)->first();

        // Ambil kelas jika user ini adalah Wali Kelas
        $kelasSaya = Kelas::where('wali_kelas_id', $user->id)->withCount('siswa')->first();

        // Riwayat pencatatan poin oleh guru ini
        $riwayatInput = PelanggaranSiswa::with(['siswa.kelas', 'jenisPelanggaran'])
            ->where('user_id', $user->id)
            ->orderByDesc('tanggal')
            ->take(10)
            ->get();

        $totalPoinInput = PelanggaranSiswa::where('user_id', $user->id)->sum('poin');

        return view('guru.dashboard', compact('user', 'tahunAktif', 'kelasSaya', 'riwayatInput', 'totalPoinInput'));
    }

    public function createPoin(): View
    {
        $kelasList = Kelas::where('is_active', true)
            ->with(['siswa' => fn($q) => $q->aktif()->orderBy('nama_siswa')])
            ->orderBy('nama_kelas')
            ->get();

        $kategoriList = KategoriPelanggaran::with(['jenisPelanggaran' => fn($q) => $q->where('is_active', true)->orderBy('kode_pelanggaran')])
            ->orderBy('kode')
            ->get();

        $tahunAktif = TahunAjaran::where('is_active', true)->first();

        return view('guru.poin.create', compact('kelasList', 'kategoriList', 'tahunAktif'));
    }

    public function storePoin(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'siswa_id'             => ['required', 'exists:siswa,id'],
            'jenis_pelanggaran_id' => ['required', 'exists:jenis_pelanggaran,id'],
            'tanggal'              => ['required', 'date'],
            'catatan'              => ['nullable', 'string'],
        ], [
            'siswa_id.required'             => 'Pilih siswa terlebih dahulu.',
            'jenis_pelanggaran_id.required' => 'Pilih jenis pelanggaran.',
            'tanggal.required'              => 'Tanggal wajib diisi.',
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
            'tindak_lanjut'        => $jenis->sanksi_default,
        ]);

        return redirect()->route('guru.poin.index')
            ->with('success', 'Catatan pelanggaran siswa berhasil disimpan.');
    }

    public function riwayatPoin(Request $request): View
    {
        $user = auth()->user();
        $query = PelanggaranSiswa::with(['siswa.kelas', 'jenisPelanggaran.kategori'])
            ->where('user_id', $user->id);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama_siswa', 'ILIKE', "%{$search}%");
            });
        }

        $pelanggaran = $query->orderByDesc('tanggal')->paginate(15)->withQueryString();

        return view('guru.poin.index', compact('pelanggaran'));
    }

    public function kelasSaya(): View
    {
        $user = auth()->user();
        $kelas = Kelas::where('wali_kelas_id', $user->id)
            ->with(['siswa' => fn($q) => $q->aktif()->withSum('pelanggaranSiswa as total_poin', 'poin')])
            ->firstOrFail();

        return view('guru.kelas.index', compact('kelas'));
    }
}
