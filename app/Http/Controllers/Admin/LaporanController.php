<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AturanSanksiKumulasi;
use App\Models\KategoriPelanggaran;
use App\Models\Kelas;
use App\Models\PelanggaranSiswa;
use App\Models\PengaturanSistem;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $kelasList    = Kelas::where('is_active', true)->orderBy('nama_kelas')->get();
        $kategoriList = KategoriPelanggaran::orderBy('kode')->get();

        $query = PelanggaranSiswa::with(['siswa.kelas', 'jenisPelanggaran.kategori']);

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('kategori_id')) {
            $query->whereHas('jenisPelanggaran', fn($q) => $q->where('kategori_id', $request->kategori_id));
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $laporanList = $query->orderByDesc('tanggal')->paginate(20)->withQueryString();

        return view('admin.laporan.index', compact('laporanList', 'kelasList', 'kategoriList'));
    }

    public function cetakPelanggaran(Request $request): View
    {
        $query = PelanggaranSiswa::with(['siswa.kelas', 'jenisPelanggaran.kategori']);

        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', fn($q) => $q->where('kelas_id', $request->kelas_id));
        }

        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        $laporanList = $query->orderBy('tanggal')->get();
        $settings    = PengaturanSistem::getSettings();

        return view('admin.laporan.cetak_pelanggaran', compact('laporanList', 'settings'));
    }

    public function cetakSp(string $siswaId): View
    {
        $siswa              = Siswa::aktif()->with('kelas.waliKelas')->findOrFail($siswaId);
        $riwayatPelanggaran = PelanggaranSiswa::with(['jenisPelanggaran.kategori'])
            ->where('siswa_id', $siswa->id)
            ->orderBy('tanggal')
            ->get();

        $totalPoin = $riwayatPelanggaran->sum('poin');
        $sanksi    = AturanSanksiKumulasi::where('min_poin', '<=', $totalPoin)
            ->where('max_poin', '>=', $totalPoin)
            ->first();

        $settings = PengaturanSistem::getSettings();

        return view('admin.laporan.cetak_sp', compact('siswa', 'riwayatPelanggaran', 'totalPoin', 'sanksi', 'settings'));
    }
}
